<?php

namespace App\Http\Controllers\Cms\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\WeeklyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeeklyReportController extends Controller
{
    public function index()
    {
        $reports = WeeklyReport::with([
                'internship.student',
            ])
            ->orderBy('id', 'desc')
            ->get();

        return view('cms.supervisor.weekly-reports', compact('reports'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:قيد المراجعة,تمت المراجعة,مرفوض',
            'supervisor_feedback' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $report = WeeklyReport::with('internship.student')->findOrFail($id);
        $report->status = $request->status;
        $report->supervisor_feedback = $request->supervisor_feedback;
        $report->reviewed_at = now();
        $isUpdated = $report->save();

        Notification::create([
    'title' => 'تحديث على التقرير الأسبوعي',
    'body' => $report->status == 'تمت المراجعة'
        ? 'تمت مراجعة تقريرك الأسبوعي من قبل المشرف.'
        : 'تم رفض تقريرك الأسبوعي من قبل المشرف.',
    'type' => 'weekly_report',
    'link' => route('front.student.weekly-reports'),
    'is_read' => false,
    'read_at' => null,
    'user_id' => $report->internship->student->user_id,
]);

        return response()->json([
            'icon' => $isUpdated ? 'success' : 'error',
            'title' => $isUpdated ? 'Updated successfully' : 'Update failed',
        ], $isUpdated ? 200 : 400);


    }
public function show($id)
{
    $report = WeeklyReport::with([
        'internship.student',
        'internship.company',
        'internship.opportunity',
    ])->findOrFail($id);

    return view('cms.supervisor.report-show', compact('report'));
}
}
