<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\StudentHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentHourController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $internship = Internship::with('studentHours')
            ->where('students_id', $user->student->id)
            ->latest()
            ->first();

        if (!$internship) {
            return view('front.student.hours', [
                'internship' => null,
                'hourLogs' => collect(),
                'requiredHours' => 0,
                'approvedHours' => 0,
                'pendingHours' => 0,
                'remainingHours' => 0,
                'progressPercent' => 0,
            ]);
        }

        $hourLogs = StudentHour::where('internships_id', $internship->id)
            ->orderBy('work_date', 'desc')
            ->get();

        $requiredHours = $internship->required_hours ?? 0;
        $approvedHours = $hourLogs->where('status', 'approved')->sum('hours');
        $pendingHours = $hourLogs->where('status', 'pending')->sum('hours');
        $remainingHours = max($requiredHours - $approvedHours, 0);
        $progressPercent = $requiredHours > 0 ? min(round(($approvedHours / $requiredHours) * 100), 100) : 0;

        return view('front.student.hours', compact(
            'internship',
            'hourLogs',
            'requiredHours',
            'approvedHours',
            'pendingHours',
            'remainingHours',
            'progressPercent'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $internship = Internship::where('students_id', $user->student->id)
            ->latest()
            ->first();

        if (!$internship) {
            return redirect()->back()->with('error', 'لا يوجد تدريب فعلي لإضافة الساعات عليه');
        }

        $validator = Validator::make($request->all(), [
            'work_date' => 'required|date',
            'hours' => 'required|integer|min:1|max:12',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->getMessageBag()->first())
                ->withInput();
        }

        StudentHour::create([
            'work_date' => $request->work_date,
            'hours' => $request->hours,
            'description' => $request->description,
            'status' => 'pending',
            'supervisor_feedback' => null,
            'submitted_at' => now(),
            'reviewed_at' => null,
            'internships_id' => $internship->id,
        ]);

        return redirect()->route('front.student.hours')
            ->with('success', 'تم حفظ سجل الساعات بنجاح');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $internship = Internship::where('students_id', $user->student->id)
            ->latest()
            ->first();

        $hourLog = StudentHour::where('internships_id', $internship->id)
            ->findOrFail($id);

        if ($hourLog->status == 'approved') {
            return redirect()->back()->with('error', 'لا يمكن حذف سجل ساعات معتمد');
        }

        $isDeleted = $hourLog->delete();

        return redirect()->back()->with(
            $isDeleted ? 'success' : 'error',
            $isDeleted ? 'تم حذف سجل الساعات بنجاح' : 'فشل حذف السجل'
        );
    }
}
