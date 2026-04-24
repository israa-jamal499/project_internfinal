<?php

namespace App\Http\Controllers\Cms\Company;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;

        $internships = Internship::with([
                'student.user',
                'student.specialization',
                'student.city',
                'opportunity'
            ])
            ->where('companies_id', $company->id)
            ->where('status', 'قيد التدريب')
            ->latest()
            ->get();

        return view('cms.company.interns', compact('internships'));
    }

    public function show($id)
    {
        $company = Auth::user()->company;

        $internship = Internship::with([
                'student.user',
                'student.specialization',
                'student.city',
                'student.college',
                'opportunity',
                'supervisor'
            ])
            ->where('companies_id', $company->id)
            ->findOrFail($id);

        return view('cms.company.internsprofile', compact('internship'));
    }

    public function stop($id)
    {
        $company = Auth::user()->company;

        $internship = Internship::where('companies_id', $company->id)
            ->findOrFail($id);

        $internship->status = 'متوقف';
        $internship->end_date = now()->toDateString();
        $isUpdated = $internship->save();
Notification::create([
    'title' => 'انتهاء تدريب',
    'body' => 'انتهى تدريب أحد الطلاب، يرجى إضافة التقييم.',
    'type' => 'internship',
    'is_read' => false,
    'read_at' => null,
    'user_id' => $internship->company->user_id,
]);

        return redirect()->back()->with(
            $isUpdated ? 'success' : 'error',
            $isUpdated ? 'تم إنهاء التدريب بنجاح' : 'فشل إنهاء التدريب'
        );
    }
}