<?php

namespace App\Http\Controllers\Cms\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Notification;
use App\Models\SupervisorEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{
    public function index()
    {
        $internships = Internship::with([
                'student',
                'supervisorEvaluation'
            ])
            ->orderBy('id', 'desc')
            ->get();

        $studentsCount = $internships->count();
        $savedCount = SupervisorEvaluation::count();
        $pendingCount = $internships->filter(function ($internship) {
            return !$internship->supervisorEvaluation;
        })->count();

        $evaluations = SupervisorEvaluation::with([
                'internship.student'
            ])
            ->orderBy('id', 'desc')
            ->get();

        return view('cms.supervisor.evaluation', compact(
            'internships',
            'studentsCount',
            'savedCount',
            'pendingCount',
            'evaluations'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'internships_id' => 'required|exists:internships,id',
            'overall_assessment' => 'required|in:ممتاز,جيد جدًا,جيد,مقبول',
            'commitment' => 'required|integer|min:1|max:10',
            'skills' => 'required|integer|min:1|max:10',
            'communication' => 'required|integer|min:1|max:10',
            'general_feedback' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->getMessageBag()->first())
                ->withInput();
        }

        $evaluation = SupervisorEvaluation::where('internships_id', $request->internships_id)->first();

        if ($evaluation) {
            $evaluation->overall_assessment = $request->overall_assessment;
            $evaluation->commitment = $request->commitment;
            $evaluation->skills = $request->skills;
            $evaluation->communication = $request->communication;
            $evaluation->general_feedback = $request->general_feedback;
            $evaluation->is_final = true;
            $isSaved = $evaluation->save();
        } else {
            $evaluation = new SupervisorEvaluation();
            $evaluation->internships_id = $request->internships_id;
            $evaluation->overall_assessment = $request->overall_assessment;
            $evaluation->commitment = $request->commitment;
            $evaluation->skills = $request->skills;
            $evaluation->communication = $request->communication;
            $evaluation->general_feedback = $request->general_feedback;
            $evaluation->is_final = true;
            $isSaved = $evaluation->save();
        }
        Notification::create([
    'title' => 'تم إضافة تقييم المشرف',
    'body' => 'تم إضافة تقييم المشرف إلى ملف تدريبك.',
    'type' => 'supervisor_evaluation',
    'link' => route('front.student.internship'),
    'is_read' => false,
    'read_at' => null,
    'user_id' => $evaluation->internship->student->user_id,
]);

        return redirect()->route('cms.supervisor.evaluation')
            ->with($isSaved ? 'success' : 'error', $isSaved ? 'تم حفظ التقييم بنجاح' : 'فشل حفظ التقييم');
    }
}
