<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Company;
use App\Models\Opportunity;
use App\Models\Application;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('user')->orderBy('id', 'desc')->paginate(10);
        return view('cms.admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('cms.admin.admins.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:45',
            'address' => 'nullable|string|max:255',
        ]);

         if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

        DB::beginTransaction();

        try {
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'admin';
            $user->status = 'active';
            $user->save();

            $admin = new Admin();
            $admin->user_id = $user->id;
            $admin->name = $request->name;
            $admin->phone = $request->phone;
            $admin->address = $request->address;
            $isSaved = $admin->save();

            DB::commit();

            return response()->json([
                'icon' => $isSaved ? 'success' : 'error',
                'title' => $isSaved ? 'Created successfully' : 'Create failed',
                'redirect' => route('admin.admins.index'),
            ], $isSaved ? 200 : 400);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'icon' => 'error',
                'title' => 'Create failed',
            ], 400);
        }
    }

    public function show($id)
    {
        $admin = Admin::with('user')->findOrFail($id);
        return view('cms.admin.admins.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = Admin::with('user')->findOrFail($id);
        return view('cms.admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:45',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $admin->name = $request->name;
        $admin->phone = $request->phone;
        $admin->address = $request->address;
        $isUpdated = $admin->save();

        return response()->json([
            'icon' => $isUpdated ? 'success' : 'error',
            'title' => $isUpdated ? 'Updated successfully' : 'Update failed',
            'redirect' => route('admin.admins.index'),
        ], $isUpdated ? 200 : 400);
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $isDeleted = $admin->delete();

        if ($isDeleted) {
            User::findOrFail($admin->user_id)->delete();
        }

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }



    public function restore($id)
    {
        $admin = Admin::onlyTrashed()->findOrFail($id);
        $admin->restore();

        User::onlyTrashed()->findOrFail($admin->user_id)->restore();

        return redirect()->back()->with('success', 'Restored successfully');
    }
   public function profile()
{
    $user =Auth::user()->load('admin.images');

    return view('cms.admin.profile', compact('user'));
}

public function editProfile()
{
    $user = Auth::user()->load('admin.images');

    return view('cms.admin.edit-profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = Auth::user()->load('admin.images');
$admin = $user->admin;

if (!$admin) {
    $admin = new \App\Models\Admin();
    $admin->user_id = $user->id;
    $admin->name = $request->name;
    $admin->phone = $request->phone;
    $admin->address = $request->address;
    $admin->save();
} else {
    $admin->name = $request->name;
    $admin->phone = $request->phone;
    $admin->address = $request->address;
    $admin->save();
}

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:3|max:100',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $user->email = $request->email;
    $user->save();

    $admin->name = $request->name;
    $admin->phone = $request->phone;
    $admin->address = $request->address;
    $admin->save();

    if ($request->hasFile('image')) {
        $oldImage = $admin->images()->first();

        if ($oldImage) {
            Storage::disk('public')->delete($oldImage->path);
            $oldImage->delete();
        }

        $path = $request->file('image')->store('admins', 'public');

        $admin->images()->create([
            'path' => $path,
        ]);
    }

    return redirect()->route('admin.admin.profile')
        ->with('success', 'تم تحديث الملف الشخصي بنجاح');
}


public function editPassword()
{
    return view('cms.admin.change-password');
}

public function updatePassword(Request $request)
{
    $user = Auth::user();

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
        return redirect()->back()
            ->with('error', 'كلمة المرور الحالية غير صحيحة');
    }

    if (Hash::check($request->new_password, $user->password)) {
        return redirect()->back()
            ->with('error', 'كلمة المرور الجديدة يجب أن تكون مختلفة عن الحالية');
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('admin.password.edit')
        ->with('success', 'تم تغيير كلمة المرور بنجاح');
}

public function dashboard()
{
    // KPI
    $studentsCount = Student::count();
    $companiesCount = Company::count();
    $opportunitiesCount = Opportunity::count();
    $applicationsCount = Application::whereDate('created_at', today())->count();

    // أحدث الطلبات
    $latestApplications = Application::with([
        'student',
        'company',
        'opportunity'
    ])->latest()->take(5)->get();

    // فرص جديدة
    $latestOpportunities = Opportunity::with('company')
        ->latest()
        ->take(3)
        ->get();

    // إشعارات
    $notifications = Notification::latest()->take(3)->get();

    return view('cms.admin.dashboard', compact(
        'studentsCount',
        'companiesCount',
        'opportunitiesCount',
        'applicationsCount',
        'latestApplications',
        'latestOpportunities',
        'notifications'
    ));
}
}
