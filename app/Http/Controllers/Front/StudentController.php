<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Internship;
use App\Models\Notification;
use App\Models\WeeklyReport;
use App\Models\StudentHour;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\City;
use App\Models\College;
use Illuminate\Http\Request;
class StudentController extends Controller
{

public function profile()
    {
        $user = Auth::user()->load([
            'student.images',
            'student.city',
            'student.college',
        ]);

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $student = $user->student;
        $cities = City::orderBy('name')->get();
        $colleges = College::orderBy('name')->get();

        return view('front.student.profile', compact('user', 'student', 'cities', 'colleges'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user()->load('student.images');

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $student = $user->student;

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:150',
            'phone' => 'nullable|string|max:20',
            'city_id' => 'nullable|exists:cities,id',
            'college_id' => 'nullable|exists:colleges,id',
            'level' => 'nullable|string|max:50',
            'gender' => 'nullable|in:male,female',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student->full_name = $request->full_name;
        $student->phone = $request->phone;
        $student->city_id = $request->city_id;
        $student->college_id = $request->college_id;
        $student->level = $request->level;
        $student->gender = $request->gender;
        $student->birthdate = $request->birthdate;
        $student->address = $request->address;
        $student->save();

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        if ($request->hasFile('image')) {
            $oldImage = $student->images()->first();

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage->path);
                $oldImage->delete();
            }

            $path = $request->file('image')->store('students', 'public');

            $student->images()->create([
                'path' => $path,
            ]);
        }

        return redirect()->route('front.student.profile')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function editPassword()
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student') {
            return redirect()->route('front.auth.login');
        }

        return view('front.student.change-password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student') {
            return redirect()->route('front.auth.login');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور الحالية غير صحيحة');
        }

        if (Hash::check($request->new_password, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور الجديدة يجب أن تكون مختلفة عن الحالية');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('front.student.password.edit')
            ->with('success', 'تم تغيير كلمة المرور بنجاح');
    }

    public function internship()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('front.auth.login');
        }

        if ($user->role != 'student') {
            return redirect()->route('front.auth.login');
        }

        if (!$user->student) {
            return redirect()->back()->with('error', 'بيانات الطالب غير موجودة');
        }

        $internship = Internship::with([
    'company',
    'opportunity',
    'supervisor',
    'supervisorEvaluation',
    'companyEvaluation'
])->where('students_id', $user->student->id)
  ->latest()
  ->first();

        return view('front.student.internship', compact('internship'));
    }


    public function certificate()
{
    $user = Auth::user();

    if (!$user || $user->role != 'student' || !$user->student) {
        return redirect()->route('front.auth.login');
    }

    $internship = Internship::with([
        'company',
        'opportunity',
        'certificate'
    ])->where('students_id', $user->student->id)
      ->latest()
      ->first();

    return view('front.student.certificate', compact('internship'));
}

public function dashboard()
{
    $user = Auth::user()->load([
        'student.images',
        'student.specialization',
    ]);

    if (!$user || $user->role != 'student' || !$user->student) {
        return redirect()->route('front.auth.login');
    }

    $student = $user->student;

    $internship = Internship::with([
        'company.user',
        'supervisor.user',
        'certificate',
    ])->where('students_id', $student->id)->latest()->first();

    $applications = Application::with(['company', 'opportunity'])
        ->where('students_id', $student->id)
        ->latest()
        ->get();

    $latestReports = WeeklyReport::whereHas('internship', function ($query) use ($student) {
            $query->where('students_id', $student->id);
        })
        ->latest()
        ->take(3)
        ->get();

    $notifications = Notification::where('user_id', $user->id)
        ->latest()
        ->take(3)
        ->get();

    $applicationsCount = $applications->count();
    $acceptedApplicationsCount = $applications->where('status', 'مقبول')->count();

    $approvedHours = 0;
    $requiredHours = 0;
    $remainingHours = 0;
    $progressPercent = 0;

    if ($internship) {
        $approvedHours = StudentHour::where('internships_id', $internship->id)
            ->where('status', 'approved')
            ->sum('hours');

        $requiredHours = $internship->required_hours ?? 0;
        $remainingHours = max($requiredHours - $approvedHours, 0);
        $progressPercent = $requiredHours > 0
            ? min(round(($approvedHours / $requiredHours) * 100), 100)
            : 0;
    }

    $reportsCount = WeeklyReport::whereHas('internship', function ($query) use ($student) {
            $query->where('students_id', $student->id);
        })
        ->count();

    $latestReportStatus = $latestReports->first()->status ?? 'لا يوجد';
    $newNotificationsCount = Notification::where('user_id', $user->id)
        ->where('is_read', false)
        ->count();

    return view('front.student.dashboard', compact(
        'user',
        'student',
        'internship',
        'applicationsCount',
        'acceptedApplicationsCount',
        'approvedHours',
        'requiredHours',
        'remainingHours',
        'progressPercent',
        'reportsCount',
        'latestReportStatus',
        'notifications',
        'newNotificationsCount',
        'latestReports'
    ));
}



}