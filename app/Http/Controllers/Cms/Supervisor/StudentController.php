<?php

namespace App\Http\Controllers\Cms\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\College;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Opportunity;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $supervisor = Auth::user()->supervisor;

        $students = Student::with(['user', 'college', 'specialization', 'city'])
            ->whereHas('internships', function ($query) use ($supervisor) {
                $query->where('supervisors_id', $supervisor->id);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cms.supervisor.students.index', compact('students'));
    }

    public function create()
    {
        $cities = City::orderBy('name')->get();
        $colleges = College::orderBy('name')->get();
        $specializations = Specialization::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        $opportunities = Opportunity::orderBy('title')->get();

        return view('cms.supervisor.students.create', compact(
            'cities',
            'colleges',
            'specializations',
            'companies',
            'opportunities'
        ));
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
        'companies_id' => 'required|exists:companies,id',
        'opportunities_id' => 'required|exists:opportunities,id',
    ]);

     if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    DB::beginTransaction();

    try {
        $supervisor = Auth::user()->supervisor;
        $opportunity = Opportunity::findOrFail($request->opportunities_id);

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'student';
        $user->status = 'active';
        $user->save();

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
        $student->save();

        Internship::create([
            'start_date' => now()->toDateString(),
            'end_date' => null,
            'status' => 'قيد التدريب',
            'required_hours' => $opportunity->required_hours ?? 0,
            'completed_hours' => 0,
            'total_hours' => 0,
            'notes' => null,
            'tasks' => null,
            'students_id' => $student->id,
            'companies_id' => $request->companies_id,
            'supervisors_id' => $supervisor->id,
            'opportunities_id' => $request->opportunities_id,
            'applications_id' => null,
        ]);

        DB::commit();

        return response()->json([
            'icon' => 'success',
            'title' => 'Student created successfully',
        ], 200);

    } catch (\Throwable $e) {
        DB::rollBack();

        return response()->json([
            'errors' => [$e->getMessage()],
        ], 400);
    }
}

    public function show($id)
    {
        $supervisor = Auth::user()->supervisor;

        $student = Student::with(['user', 'college', 'specialization', 'city'])
            ->whereHas('internships', function ($query) use ($supervisor) {
                $query->where('supervisors_id', $supervisor->id);
            })
            ->findOrFail($id);

        return view('cms.supervisor.students.show', compact('student'));
    }

    public function edit($id)
    {
        $supervisor = Auth::user()->supervisor;

        $student = Student::with('user')
            ->whereHas('internships', function ($query) use ($supervisor) {
                $query->where('supervisors_id', $supervisor->id);
            })
            ->findOrFail($id);

        $cities = City::orderBy('name')->get();
        $colleges = College::orderBy('name')->get();
        $specializations = Specialization::orderBy('name')->get();

        return view('cms.supervisor.students.edit', compact(
            'student',
            'cities',
            'colleges',
            'specializations'
        ));
    }

    public function update(Request $request, $id)
    {
        $supervisor = Auth::user()->supervisor;

        $student = Student::with('user')
            ->whereHas('internships', function ($query) use ($supervisor) {
                $query->where('supervisors_id', $supervisor->id);
            })
            ->findOrFail($id);

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
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
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
        $supervisor = Auth::user()->supervisor;

        $student = Student::whereHas('internships', function ($query) use ($supervisor) {
            $query->where('supervisors_id', $supervisor->id);
        })->findOrFail($id);

        $isDeleted = $student->delete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function trashed()
    {
        $supervisor = Auth::user()->supervisor;

        $students = Student::onlyTrashed()
            ->whereHas('internships', function ($query) use ($supervisor) {
                $query->where('supervisors_id', $supervisor->id);
            })
            ->with(['user', 'college', 'specialization', 'city'])
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('cms.supervisor.students.trashed', compact('students'));
    }

    public function restore($id)
    {
        $supervisor = Auth::user()->supervisor;

        $student = Student::onlyTrashed()
            ->whereHas('internships', function ($query) use ($supervisor) {
                $query->where('supervisors_id', $supervisor->id);
            })
            ->findOrFail($id);

        $isRestored = $student->restore();

        return response()->json([
            'icon' => $isRestored ? 'success' : 'error',
            'title' => $isRestored ? 'Restored successfully' : 'Restore failed',
        ], $isRestored ? 200 : 400);
    }

    public function force($id)
    {
        $supervisor = Auth::user()->supervisor;

        $student = Student::onlyTrashed()
            ->whereHas('internships', function ($query) use ($supervisor) {
                $query->where('supervisors_id', $supervisor->id);
            })
            ->findOrFail($id);

        $isDeleted = $student->forceDelete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted permanently successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }

    public function forceAll()
    {
        $supervisor = Auth::user()->supervisor;

        $students = Student::onlyTrashed()
            ->whereHas('internships', function ($query) use ($supervisor) {
                $query->where('supervisors_id', $supervisor->id);
            });

        if ($students->count() == 0) {
            return response()->json([
                'icon' => 'info',
                'title' => 'No trashed students found',
            ], 200);
        }

        $students->forceDelete();

        return response()->json([
            'icon' => 'success',
            'title' => 'All trashed students deleted permanently',
        ], 200);
    }
}
