<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\College;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'college', 'specialization', 'city'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.admin.students.index', compact('students'));
    }

    public function create()
    {
        $cities = City::orderBy('name')->get();
        $colleges = College::orderBy('name')->get();
        $specializations = Specialization::orderBy('name')->get();

        return view('cms.admin.students.create', compact('cities', 'colleges', 'specializations'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:45',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:20',
            'university_number' => 'required|string|max:45|unique:students,university_number',
            'level' => 'nullable|string|max:45',
            'general_status' => 'required|in:active,inactive,graduated,suspended',
            'cv' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:45',
            'phone' => 'nullable|string|max:45',
            'gender' => 'required|in:male,female',
            'birthdate' => 'nullable|date',
            'city_id' => 'required|exists:cities,id',
            'college_id' => 'required|exists:colleges,id',
            'specialization_id' => 'nullable|exists:specializations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'student';
        $user->status = 'active';
        $isUserSaved = $user->save();

        if (!$isUserSaved) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Failed to create user',
            ], 400);
        }

        $student = new Student();
        $student->full_name = $request->full_name;
        $student->university_number = $request->university_number;
        $student->level = $request->level;
        $student->general_status = $request->general_status;
        $student->cv = $request->cv;
        $student->address = $request->address;
        $student->phone = $request->phone;
        $student->gender = $request->gender;
        $student->birthdate = $request->birthdate;
        $student->user_id = $user->id;
        $student->city_id = $request->city_id;
        $student->college_id = $request->college_id;
        $student->specialization_id = $request->specialization_id;
        $isSaved = $student->save();

        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'Student created successfully' : 'Create failed',
        ], $isSaved ? 200 : 400);
    }

    public function show($id)
    {
        $student = Student::with(['user', 'college', 'specialization', 'city'])->findOrFail($id);
        return view('cms.admin.students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $cities = City::orderBy('name')->get();
        $colleges = College::orderBy('name')->get();
        $specializations = Specialization::orderBy('name')->get();

        return view('cms.admin.students.edit', compact('student', 'cities', 'colleges', 'specializations'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:45',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'university_number' => 'required|string|max:45|unique:students,university_number,' . $student->id,
            'level' => 'nullable|string|max:45',
            'general_status' => 'required|in:active,inactive,graduated,suspended',
            'cv' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:45',
            'phone' => 'nullable|string|max:45',
            'gender' => 'required|in:male,female',
            'birthdate' => 'nullable|date',
            'city_id' => 'required|exists:cities,id',
            'college_id' => 'required|exists:colleges,id',
            'specialization_id' => 'nullable|exists:specializations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $student->user->email = $request->email;
        $student->user->save();

        $student->full_name = $request->full_name;
        $student->university_number = $request->university_number;
        $student->level = $request->level;
        $student->general_status = $request->general_status;
        $student->cv = $request->cv;
        $student->address = $request->address;
        $student->phone = $request->phone;
        $student->gender = $request->gender;
        $student->birthdate = $request->birthdate;
        $student->city_id = $request->city_id;
        $student->college_id = $request->college_id;
        $student->specialization_id = $request->specialization_id;

        $isUpdated = $student->save();

        return response()->json([
            'icon' => $isUpdated ? 'success' : 'error',
            'title' => $isUpdated ? 'Student updated successfully' : 'Update failed',
        ], $isUpdated ? 200 : 400);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $isDeleted = $student->delete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function trashed()
    {
        $students = Student::onlyTrashed()
            ->with(['user', 'college', 'specialization', 'city'])
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('cms.admin.students.trashed', compact('students'));
    }

    public function restore($id)
{
    $isRestored = Student::onlyTrashed()->findOrFail($id)->restore();

    return response()->json([
        'icon' => $isRestored ? 'success' : 'error',
        'title' => $isRestored ? 'Restored successfully' : 'Restore failed',
    ], $isRestored ? 200 : 400);
}

    public function force($id)
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        $isDeleted = $student->forceDelete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted permanently successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function forceAll()
{
    $count = Student::onlyTrashed()->count();

    if ($count == 0) {
        return response()->json([
            'icon' => 'info',
            'title' => 'No trashed students found',
        ], 200);
    }

    Student::onlyTrashed()->forceDelete();

    return response()->json([
        'icon' => 'success',
        'title' => 'All trashed students deleted permanently',
    ], 200);
}
}
