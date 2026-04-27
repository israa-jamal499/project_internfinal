<?php

namespace App\Http\Controllers\Cms\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Internship;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;

        $applications = Application::with([
                'student.user',
                'student.college',
                'student.specialization',
                'opportunity'
            ])
            ->whereHas('opportunity', function ($query) use ($company) {
                $query->where('companies_id', $company->id);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('cms.company.applications.index', compact('applications'));
    }

    public function show($id)
    {
        $company = Auth::user()->company;

        $application = Application::with([
                'student.user',
                'student.city',
                'student.college',
                'student.specialization',
                'opportunity.city'
            ])
            ->whereHas('opportunity', function ($query) use ($company) {
                $query->where('companies_id', $company->id);
            })
            ->findOrFail($id);

        return view('cms.company.applications.show', compact('application'));
    }

public function update(Request $request, $id)
{
    $company = Auth::user()->company;

    $application = Application::with(['student', 'opportunity'])
        ->whereHas('opportunity', function ($query) use ($company) {
            $query->where('companies_id', $company->id);
        })
        ->findOrFail($id);

    $validator = Validator::make($request->all(), [
        'status' => 'required|in:قيد المراجعة,مقبول,مرفوض',
        'admin_notes' => 'nullable|string',
    ]);

     if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    $application->status = $request->status;
    $application->admin_notes = $request->admin_notes;
    $application->reviewed_at = now();

    $isUpdated = $application->save();

    if ($isUpdated && $request->status == 'مقبول') {
        $internshipExists = Internship::where('applications_id', $application->id)->exists();

if (!$internshipExists) {
    Internship::create([
        'start_date' => now()->toDateString(),
        'end_date' => null,
        'status' => 'قيد التدريب',
        'required_hours' => $application->opportunity->required_hours ?? 0,
        'completed_hours' => 0,
        'total_hours' => 0,
        'notes' => null,
        'tasks' => null,
        'students_id' => $application->students_id,
        'companies_id' => $application->opportunity->companies_id,
        'supervisors_id' => null,
        'opportunities_id' => $application->opportunities_id,
        'applications_id' => $application->id,
    ]);
}
    }

    if ($isUpdated) {
        Notification::create([
            'title' => 'تحديث على طلب التقديم',
            'body' => $application->status == 'مقبول'
                ? 'تم قبول طلبك للتدريب.'
                : ($application->status == 'مرفوض'
                    ? 'تم رفض طلبك للتدريب.'
                    : 'تم تحديث حالة طلبك.'),
            'type' => 'application',
            'link' => route('front.student.applications'),
            'is_read' => false,
            'read_at' => null,
            'user_id' => $application->student->user_id,
        ]);
    }

    return response()->json([
        'icon' => $isUpdated ? 'success' : 'error',
        'title' => $isUpdated ? 'Application updated successfully' : 'Update failed',
    ], $isUpdated ? 200 : 400);
}
}
