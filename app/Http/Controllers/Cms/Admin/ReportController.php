<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeeklyReport;
use App\Models\StudentHour;
use App\Models\CompanyEvaluation;
use App\Models\SupervisorEvaluation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $weeklyReports = WeeklyReport::with('internship.student', 'internship.company')
            ->latest()
            ->get();

        $hoursReportsCount = StudentHour::count();
        $companyEvaluationsCount = CompanyEvaluation::count();
        $supervisorEvaluationsCount = SupervisorEvaluation::count();

        $totalReports = $weeklyReports->count() + $hoursReportsCount + $companyEvaluationsCount + $supervisorEvaluationsCount;

        $completedReports = $weeklyReports->where('status', 'تمت المراجعة')->count();
        $pendingReports = $weeklyReports->where('status', 'بانتظار المراجعة')->count();
        $archivedReports = $weeklyReports->where('status', 'مؤرشف')->count();

        return view('cms.admin.report', compact(
            'weeklyReports',
            'totalReports',
            'completedReports',
            'pendingReports',
            'archivedReports'
        ));
    }
}
