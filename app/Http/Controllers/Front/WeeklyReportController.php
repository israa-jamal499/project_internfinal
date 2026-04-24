<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\WeeklyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

class WeeklyReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $internship = Internship::where('students_id', $user->student->id)
            ->latest()
            ->first();

        if (!$internship) {
            return view('front.student.reports', [
                'reports' => collect(),
                'totalReports' => 0,
                'acceptedReports' => 0,
                'pendingReports' => 0,
                'rejectedReports' => 0,
                'internship' => null,
            ]);
        }

        $reports = WeeklyReport::where('internships_id', $internship->id)
            ->orderBy('week_number', 'desc')
            ->get();

        $totalReports = $reports->count();
        $acceptedReports = $reports->where('status', 'تمت المراجعة')->count();
        $pendingReports = $reports->where('status', 'قيد المراجعة')->count();
        $rejectedReports = $reports->where('status', 'مرفوض')->count();

        return view('front.student.reports', compact(
            'reports',
            'totalReports',
            'acceptedReports',
            'pendingReports',
            'rejectedReports',
            'internship'
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
            return redirect()->back()->with('error', 'لا يوجد تدريب فعلي لرفع التقارير عليه');
        }

        $validator = Validator::make($request->all(), [
            'week_number' => 'required|integer|min:1',
            'tasks_completed' => 'required|string',
            'learnings' => 'nullable|string',
            'challenges' => 'nullable|string',
            'tasks_planned' => 'nullable|string',
            'hours_worked' => 'nullable|integer|min:0',
            'week_start' => 'nullable|date',
            'week_end' => 'nullable|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $exists = WeeklyReport::where('internships_id', $internship->id)
            ->where('week_number', $request->week_number)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'تم رفع تقرير لهذا الأسبوع مسبقاً');
        }

        $path = null;
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('weekly_reports', 'public');
        }

        WeeklyReport::create([
            'week_number' => $request->week_number,
            'supervisor_feedback' => null,
            'status' => 'قيد المراجعة',
            'submitted_at' => now(),
            'reviewed_at' => null,
            'hours_worked' => $request->hours_worked ?? 0,
            'learnings' => $request->learnings,
            'challenges' => $request->challenges,
            'tasks_planned' => $request->tasks_planned,
            'tasks_completed' => $request->tasks_completed,
            'week_start' => $request->week_start,
            'week_end' => $request->week_end,
            'file_path' => $path,
            'internships_id' => $internship->id,
        ]);

        return redirect()->route('front.student.weekly-reports')
            ->with('success', 'تم رفع التقرير بنجاح');
    }

    public function show($id)
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $internship = Internship::where('students_id', $user->student->id)
            ->latest()
            ->first();

        $report = WeeklyReport::where('internships_id', $internship->id)
            ->findOrFail($id);

        return view('front.student.weekly-report-show', compact('report'));
    }
}