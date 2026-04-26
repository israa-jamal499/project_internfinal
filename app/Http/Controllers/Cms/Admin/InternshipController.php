<?php

namespace App\Http\Controllers\Cms\Admin;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Notification;
use App\Models\Opportunity;
use App\Models\Student;
use App\Models\Supervisor;
use Illuminate\Http\Request;



class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::with([
                'student.specialization',
                'company',
                'supervisor',
                'opportunity',
            ])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $totalInternships = Internship::count();
        $activeInternships = Internship::where('status', 'قيد التدريب')->count();
        $completedInternships = Internship::where('status', 'مكتمل')->count();
        $stoppedInternships = Internship::where('status', 'متوقف')->count();

        return view('cms.admin.internship.index', compact(
            'internships',
            'totalInternships',
            'activeInternships',
            'completedInternships',
            'stoppedInternships'
        ));
    }

    public function create()
    {
        $students = Student::orderBy('full_name')->get();
        $companies = Company::orderBy('name')->get();
        $supervisors = Supervisor::orderBy('full_name')->get();
        $opportunities = Opportunity::orderBy('title')->get();

        return view('cms.admin.internship.create', compact(
            'students',
            'companies',
            'supervisors',
            'opportunities'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'students_id' => 'required|exists:students,id',
            'companies_id' => 'required|exists:companies,id',
            'supervisors_id' => 'nullable|exists:supervisors,id',
            'opportunities_id' => 'required|exists:opportunities,id',
            // 'applications_id' => 'nullable|exists:applications,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:قيد التدريب,مكتمل,متوقف',
            'required_hours' => 'required|integer|min:0',
            'completed_hours' => 'nullable|integer|min:0',
            'total_hours' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:255',
            'tasks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $internship = new Internship();
        $internship->students_id = $request->students_id;
        $internship->companies_id = $request->companies_id;
        $internship->supervisors_id = $request->supervisors_id;
        $internship->opportunities_id = $request->opportunities_id;
        // $internship->applications_id = $request->applications_id;
        $internship->start_date = $request->start_date;
        $internship->end_date = $request->end_date;
        $internship->status = $request->status;
        $internship->required_hours = $request->required_hours;
        $internship->completed_hours = $request->completed_hours ?? 0;
        $internship->total_hours = $request->total_hours ?? 0;
        $internship->notes = $request->notes;
        $internship->tasks = $request->tasks;
        $isSaved = $internship->save();

        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'Created successfully' : 'Create failed',
            'redirect' => route('admin.internships.index'),
        ], $isSaved ? 200 : 400);
    }

    public function show($id)
    {
        $internship = Internship::with([
                'student.user',
                'student.city',
                'student.college',
                'student.specialization',
                'company',
                'supervisor',
                'opportunity',
            ])
            ->findOrFail($id);

        return view('cms.admin.internship.show', compact('internship'));
    }

    public function edit($id)
    {
        $internship = Internship::findOrFail($id);
        $students = Student::orderBy('full_name')->get();
        $companies = Company::orderBy('name')->get();
        $supervisors = Supervisor::orderBy('full_name')->get();
        $opportunities = Opportunity::orderBy('title')->get();

        return view('cms.admin.internship.edit', compact(
            'internship',
            'students',
            'companies',
            'supervisors',
            'opportunities'
        ));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'students_id' => 'required|exists:students,id',
            'companies_id' => 'required|exists:companies,id',
            'supervisors_id' => 'nullable|exists:supervisors,id',
            'opportunities_id' => 'required|exists:opportunities,id',
            // 'applications_id' => 'nullable|exists:applications,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:قيد التدريب,مكتمل,متوقف',
            'required_hours' => 'required|integer|min:0',
            'completed_hours' => 'nullable|integer|min:0',
            'total_hours' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:255',
            'tasks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $internship = Internship::findOrFail($id);
        $internship->students_id = $request->students_id;
        $internship->companies_id = $request->companies_id;
        $internship->supervisors_id = $request->supervisors_id;
        $internship->opportunities_id = $request->opportunities_id;
        // $internship->applications_id = $request->applications_id;
        $internship->start_date = $request->start_date;
        $internship->end_date = $request->end_date;
        $internship->status = $request->status;
        $internship->required_hours = $request->required_hours;
        $internship->completed_hours = $request->completed_hours ?? 0;
        $internship->total_hours = $request->total_hours ?? 0;
        $internship->notes = $request->notes;
        $internship->tasks = $request->tasks;
        $isUpdated = $internship->save();
        Notification::create([
    'title' => 'انتهاء تدريب',
    'body' => 'انتهى تدريب أحد الطلاب، يرجى إضافة التقييم.',
    'type' => 'internship',
    'is_read' => false,
    'read_at' => null,
    'user_id' => $internship->company->user_id,
]);
        return response()->json([
            'icon' => $isUpdated ? 'success' : 'error',
            'title' => $isUpdated ? 'Updated successfully' : 'Update failed',
            'redirect' => route('admin.internships.index'),
        ], $isUpdated ? 200 : 400);
    }

    public function destroy($id)
    {
        $internship = Internship::findOrFail($id);
        $isDeleted = $internship->delete();

        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted successfully' : 'Delete failed',
        ], $isDeleted ? 200 : 400);
    }
}