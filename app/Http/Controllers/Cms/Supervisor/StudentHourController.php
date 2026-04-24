<?php

namespace App\Http\Controllers\Cms\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\StudentHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentHourController extends Controller
{
    public function index()
    {
        $hourLogs = StudentHour::with([
                'internship.student',
                'internship.company',
            ])
            ->orderBy('id', 'desc')
            ->get();

        $totalLogs = $hourLogs->count();
        $approvedLogs = $hourLogs->where('status', 'approved')->count();
        $pendingLogs = $hourLogs->where('status', 'pending')->count();
        $rejectedLogs = $hourLogs->where('status', 'rejected')->count();

        return view('cms.supervisor.hours', compact(
            'hourLogs',
            'totalLogs',
            'approvedLogs',
            'pendingLogs',
            'rejectedLogs'
        ));
    }

    public function show($id)
    {
        $hourLog = StudentHour::with([
                'internship.student',
                'internship.company',
                'internship.opportunity',
            ])
            ->findOrFail($id);

        return view('cms.supervisor.hour-show', compact('hourLog'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected',
            'supervisor_feedback' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }

        $hourLog = StudentHour::with('internship')->findOrFail($id);
        $oldStatus = $hourLog->status;

        $hourLog->status = $request->status;
        $hourLog->supervisor_feedback = $request->supervisor_feedback;
        $hourLog->reviewed_at = now();
        $isUpdated = $hourLog->save();

        if ($isUpdated) {
            $internship = $hourLog->internship;

            $approvedHours = StudentHour::where('internships_id', $internship->id)
                ->where('status', 'approved')
                ->sum('hours');

            $totalHours = StudentHour::where('internships_id', $internship->id)
                ->sum('hours');

            $internship->completed_hours = $approvedHours;
            $internship->total_hours = $totalHours;
            $internship->save();
        }
        Notification::create([
    'title' => 'تحديث على سجل الساعات',
    'body' => $hourLog->status == 'approved'
        ? 'تم اعتماد سجل الساعات الخاص بك.'
        : ($hourLog->status == 'rejected'
            ? 'تم رفض سجل الساعات الخاص بك.'
            : 'تم تحديث حالة سجل الساعات الخاص بك.'),
    'type' => 'student_hours',
    'link' => route('front.student.hours'),
    'is_read' => false,
    'read_at' => null,
    'user_id' => $hourLog->internship->student->user_id,
]);

        return redirect()->route('cms.supervisor.hours', $hourLog->id)
            ->with($isUpdated ? 'success' : 'error', $isUpdated ? 'تم تحديث حالة الساعات بنجاح' : 'فشل تحديث السجل');
    }
}
