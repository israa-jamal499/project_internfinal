<?php

namespace App\Http\Controllers\Cms\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyEvaluation;
use App\Models\Internship;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;

        $internships = Internship::with([
                'student.specialization',
                'opportunity',
                'companyEvaluation'
            ])
            ->where('companies_id', $company->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('cms.company.evaluation', compact('internships'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $validator = Validator::make($request->all(), [
            'internships_id' => 'required|exists:internships,id',
            'overall_assessment' => 'nullable|in:1,2,3,4,5',
            'technical_skills' => 'required|in:ممتاز,جيد جدا,جيد,ضعيف',
            'commitment_discipline' => 'required|in:ممتاز,جيد جدا,جيد,ضعيف',
            'communication_teamwork' => 'required|in:ممتاز,جيد جدا,جيد,ضعيف',
            'general_feedback' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->getMessageBag()->first())
                ->withInput();
        }

        $internship = Internship::where('companies_id', $company->id)
            ->findOrFail($request->internships_id);

        $evaluation = CompanyEvaluation::where('internships_id', $internship->id)->first();

        if ($evaluation) {
            $evaluation->overall_assessment = $request->overall_assessment;
            $evaluation->technical_skills = $request->technical_skills;
            $evaluation->commitment_discipline = $request->commitment_discipline;
            $evaluation->communication_teamwork = $request->communication_teamwork;
            $evaluation->general_feedback = $request->general_feedback;
            $evaluation->is_final = true;
            $isSaved = $evaluation->save();
        } else {
            $evaluation = new CompanyEvaluation();
            $evaluation->internships_id = $internship->id;
            $evaluation->overall_assessment = $request->overall_assessment;
            $evaluation->technical_skills = $request->technical_skills;
            $evaluation->commitment_discipline = $request->commitment_discipline;
            $evaluation->communication_teamwork = $request->communication_teamwork;
            $evaluation->general_feedback = $request->general_feedback;
            $evaluation->is_final = true;
            $isSaved = $evaluation->save();
        }
        Notification::create([
    'title' => 'تم إضافة تقييم الشركة',
    'body' => 'تم إضافة تقييم جهة التدريب إلى ملف تدريبك.',
    'type' => 'company_evaluation',
    'link' => route('front.student.internship'),
    'is_read' => false,
    'read_at' => null,
    'user_id' => $internship->student->user_id,
]);

        return redirect()->route('cms.company.evaluation')
            ->with($isSaved ? 'success' : 'error', $isSaved ? 'تم حفظ تقييم الشركة بنجاح' : 'فشل حفظ التقييم');
    }
}
