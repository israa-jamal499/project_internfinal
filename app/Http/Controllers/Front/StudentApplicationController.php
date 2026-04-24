<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class StudentApplicationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $applications = Application::with([
                'opportunity.company',
                'opportunity.city',
                'opportunity.image'
            ])
            ->where('students_id', $user->student->id)
            ->latest()
            ->get();

        $totalApplications = $applications->count();
        $pendingApplications = $applications->where('status', 'قيد المراجعة')->count();
        $acceptedApplications = $applications->where('status', 'مقبول')->count();
        $rejectedApplications = $applications->where('status', 'مرفوض')->count();

        return view('front.student.applications', compact(
            'applications',
            'totalApplications',
            'pendingApplications',
            'acceptedApplications',
            'rejectedApplications'
        ));
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $application = Application::where('students_id', $user->student->id)
            ->findOrFail($id);

        if ($application->status != 'قيد المراجعة') {
            return redirect()->back()->with('error', 'لا يمكن إلغاء هذا الطلب');
        }

        $isDeleted = $application->delete();

        return redirect()->back()->with(
            $isDeleted ? 'success' : 'error',
            $isDeleted ? 'تم إلغاء الطلب بنجاح' : 'فشل إلغاء الطلب'
        );
    }
}
