<?php

namespace App\Http\Controllers\Cms\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Internship;
use App\Models\WeeklyReport;
use App\Models\SupervisorEvaluation;

class SupervisorController extends Controller
{
    public function profile()
    {
        $user = Auth::user()->load([
            'supervisor.images',
            'supervisor.city',
        ]);

        if (!$user || !$user->supervisor) {
            return redirect()->route('front.auth.login');
        }

        $supervisor = $user->supervisor;
        $cities = City::orderBy('name')->get();

        return view('cms.supervisor.profile', compact('user', 'supervisor', 'cities'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user()->load('supervisor.images');

        if (!$user || !$user->supervisor) {
            return redirect()->route('front.auth.login');
        }

        $supervisor = $user->supervisor;

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:150',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city_id' => 'nullable|exists:cities,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->email = $request->email;
        $user->save();

        $supervisor->full_name = $request->full_name;
        $supervisor->phone = $request->phone;
        $supervisor->address = $request->address;
        $supervisor->city_id = $request->city_id;
        $supervisor->save();

        if ($request->hasFile('image')) {
            $oldImage = $supervisor->images()->first();

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage->path);
                $oldImage->delete();
            }

            $path = $request->file('image')->store('supervisors', 'public');

            $supervisor->images()->create([
                'path' => $path,
            ]);
        }

        return redirect()->route('cms.supervisor.profile')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function editPassword()
    {
        $user = Auth::user();

        if (!$user || !$user->supervisor) {
            return redirect()->route('front.auth.login');
        }

        return view('cms.supervisor.profile');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->supervisor) {
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

        return redirect()->route('cms.supervisor.password.edit')
            ->with('success', 'تم تغيير كلمة المرور بنجاح');
    }

    public function dashboard()
{
    $supervisor = Auth::user()->supervisor;

    $studentCount = Internship::where('supervisors_id', $supervisor->id)
        ->distinct('students_id')
        ->count('students_id');

    $weekReportsCount = WeeklyReport::whereHas('internship', function ($query) use ($supervisor) {
            $query->where('supervisors_id', $supervisor->id);
        })
        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        ->count();

    $pendingReportsCount = WeeklyReport::whereHas('internship', function ($query) use ($supervisor) {
            $query->where('supervisors_id', $supervisor->id);
        })
        ->where('status', 'بانتظار المراجعة')
        ->count();

    $evaluationsCount = SupervisorEvaluation::whereHas('internship', function ($query) use ($supervisor) {
            $query->where('supervisors_id', $supervisor->id);
        })
        ->count();

    $latestInternships = Internship::with(['student', 'company'])
        ->where('supervisors_id', $supervisor->id)
        ->latest()
        ->take(5)
        ->get();

    $latestReports = WeeklyReport::with('internship.student')
        ->whereHas('internship', function ($query) use ($supervisor) {
            $query->where('supervisors_id', $supervisor->id);
        })
        ->latest()
        ->take(5)
        ->get();

    return view('cms.supervisor.dashboard', compact(
        'studentCount',
        'weekReportsCount',
        'pendingReportsCount',
        'evaluationsCount',
        'latestInternships',
        'latestReports'
    ));
}
}