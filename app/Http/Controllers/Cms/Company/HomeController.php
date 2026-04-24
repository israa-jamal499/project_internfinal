<?php

namespace App\Http\Controllers\Cms\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\CompanyEvaluation;
use App\Models\Internship;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;

class HomeController extends Controller
{


public function dashboard()
{
    $user = Auth::user();

    if (!$user || !$user->company) {
        return redirect()->route('front.auth.login');
    }

    $company = $user->company;

    $opportunitiesCount = Opportunity::where('companies_id', $company->id)->count();

    $newApplicationsCount = Application::whereHas('opportunity', function ($query) use ($company) {
        $query->where('companies_id', $company->id);
    })->where('status', 'قيد المراجعة')->count();

    $currentInternsCount = Internship::where('companies_id', $company->id)
        ->where('status', 'قيد التدريب')
        ->count();

    $completedEvaluationsCount = CompanyEvaluation::whereHas('internship', function ($query) use ($company) {
        $query->where('companies_id', $company->id);
    })->count();

    $latestApplications = Application::with([
            'student',
            'opportunity'
        ])
        ->whereHas('opportunity', function ($query) use ($company) {
            $query->where('companies_id', $company->id);
        })
        ->latest()
        ->take(5)
        ->get();

    return view('cms.company.dashboard', compact(
        'company',
        'opportunitiesCount',
        'newApplicationsCount',
        'currentInternsCount',
        'completedEvaluationsCount',
        'latestApplications'
    ));
}

public function profile()
{
    $user = Auth::user()->load([
        'company.images',
        'company.city',
    ]);

    if (!$user || !$user->company) {
        return redirect()->route('front.auth.login');
    }

    $company = $user->company;
    $cities = City::orderBy('name')->get();

    return view('cms.company.profile', compact('user', 'company', 'cities'));
}

public function updateProfile(Request $request)
{
    $user = Auth::user()->load('company.images');

    if (!$user || !$user->company) {
        return redirect()->route('front.auth.login');
    }

    $company = $user->company;

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:2|max:150',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'website' => 'nullable|string|max:255',
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

    $company->name = $request->name;
    $company->phone = $request->phone;
    $company->website = $request->website;
    $company->address = $request->address;
    $company->city_id = $request->city_id;
    $company->save();

    if ($request->hasFile('image')) {
        $oldImage = $company->images()->first();

        if ($oldImage) {
            Storage::disk('public')->delete($oldImage->path);
            $oldImage->delete();
        }

        $path = $request->file('image')->store('companies', 'public');

        $company->images()->create([
            'path' => $path,
        ]);
    }

    return redirect()->route('password.update')
        ->with('success', 'تم تحديث الملف الشخصي بنجاح');
}

public function editPassword()
{
    $user = Auth::user();

    if (!$user || !$user->company) {
        return redirect()->route('front.auth.login');
    }

    return view('cms.company.change_password');
}

public function updatePassword(Request $request)
{
    $user = Auth::user();

    if (!$user || !$user->company) {
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

    return redirect()->route('password.edit')
        ->with('success', 'تم تغيير كلمة المرور بنجاح');
}


public function companyIndex()
{
    $notifications = Notification::where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('cms.company.notifications', compact('notifications'));
}

public function markRead($id)
{
    $notification = Notification::where('user_id', Auth::id())->findOrFail($id);

    $notification->is_read = true;
    $notification->read_at = now();
    $notification->save();

    return redirect()->back();
}

public function delete($id)
{
    $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
    $notification->delete();

    return redirect()->back();
}

public function clearAll()
{
    Notification::where('user_id', Auth::id())->delete();

    return redirect()->back();
}
}
