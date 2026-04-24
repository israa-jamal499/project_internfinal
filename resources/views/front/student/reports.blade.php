@extends('front.layout.student')

@section('title','weekly-reports')

@section('content')
<main class="student-page reports-page">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <section class="page-title-box">
        <h2>التقارير الأسبوعية</h2>
        <p>
            يمكنك من هنا رفع تقارير التدريب الأسبوعية ومتابعة حالة مراجعتها من قبل المشرف.
        </p>
    </section>

    <section class="reports-stats">
        <article class="mini-card white-card">
            <span>إجمالي التقارير</span>
            <strong id="totalReports">{{ $totalReports }}</strong>
        </article>
        <article class="mini-card white-card">
            <span>مقبول</span>
            <strong id="acceptedReports">{{ $acceptedReports }}</strong>
        </article>
        <article class="mini-card white-card">
            <span>قيد المراجعة</span>
            <strong id="pendingReports">{{ $pendingReports }}</strong>
        </article>
        <article class="mini-card white-card">
            <span>مرفوض</span>
            <strong id="rejectedReports">{{ $rejectedReports }}</strong>
        </article>
    </section>

    @if($internship)
    <section class="report-form-card white-card">
        <div class="card-head no-link">
            <h3>📝 رفع تقرير جديد</h3>
        </div>

        <form method="POST" action="{{ route('front.student.weekly-reports.store') }}" enctype="multipart/form-data" class="report-form-grid">
            @csrf

            <div class="form-group">
                <label>الأسبوع</label>
                <input type="number" name="week_number" class="form-control" min="1" value="{{ old('week_number') }}" placeholder="مثال: 1">
            </div>

            <div class="form-group">
                <label>عدد ساعات العمل</label>
                <input type="number" name="hours_worked" class="form-control" min="0" value="{{ old('hours_worked') }}" placeholder="مثال: 6">
            </div>

            <div class="form-group">
                <label>بداية الأسبوع</label>
                <input type="date" name="week_start" class="form-control" value="{{ old('week_start') }}">
            </div>

            <div class="form-group">
                <label>نهاية الأسبوع</label>
                <input type="date" name="week_end" class="form-control" value="{{ old('week_end') }}">
            </div>

            <div class="form-group full-span">
                <label>المهام التي تم إنجازها</label>
                <textarea name="tasks_completed" class="form-textarea" rows="4" placeholder="اكتبي أهم ما تم إنجازه خلال هذا الأسبوع">{{ old('tasks_completed') }}</textarea>
            </div>

            <div class="form-group full-span">
                <label>ما الذي تعلمته</label>
                <textarea name="learnings" class="form-textarea" rows="3">{{ old('learnings') }}</textarea>
            </div>

            <div class="form-group full-span">
                <label>التحديات</label>
                <textarea name="challenges" class="form-textarea" rows="3">{{ old('challenges') }}</textarea>
            </div>

            <div class="form-group full-span">
                <label>المهام المخطط لها</label>
                <textarea name="tasks_planned" class="form-textarea" rows="3">{{ old('tasks_planned') }}</textarea>
            </div>

            <div class="form-group full-span">
                <label>إرفاق التقرير</label>
                <input type="file" name="file_path" class="form-control">
            </div>

            <div class="full-span">
                <button type="submit" class="btn btn-primary">رفع التقرير</button>
            </div>
        </form>
    </section>
    @endif

    <section class="reports-table-card white-card">
        <div class="card-head no-link">
            <h3>📂 التقارير المرفوعة</h3>
        </div>

        <div class="table-wrap">
            <table class="clean-table">
                <thead>
                    <tr>
                        <th>الأسبوع</th>
                        <th>ملخص الإنجاز</th>
                        <th>تاريخ الإرسال</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody id="reportsTableBody">
                    @forelse($reports as $report)
                        <tr>
                            <td>الأسبوع {{ $report->week_number }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($report->tasks_completed, 40) }}</td>
                           <td>{{ $report->submitted_at ? \Carbon\Carbon::parse($report->submitted_at)->format('Y-m-d') : '-' }}</td>
                            <td>
                                @if($report->status == 'تمت المراجعة')
                                    <span class="badge badge-success">مقبول</span>
                                @elseif($report->status == 'قيد المراجعة')
                                    <span class="badge badge-warning">قيد المراجعة</span>
                                @else
                                    <span class="badge badge-danger">مرفوض</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('front.student.weekly-reports.show', $report->id) }}" class="btn btn-light btn-sm-link">عرض</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">لا توجد تقارير مرفوعة حتى الآن</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</main>
@endsection

@section('css')
<style>
.reports-page{
    display:grid;
    gap:18px;
}
.reports-stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
}
.mini-card{
    padding:18px;
    border-radius:20px;
    text-align:center;
}
.mini-card span{
    display:block;
    color:#64748b;
    font-size:13px;
    margin-bottom:8px;
}
.mini-card strong{
    font-size:28px;
    color:#122033;
    font-weight:900;
}
.report-form-card,
.reports-table-card{
    padding:22px;
    border-radius:22px;
}
.report-form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:16px;
}
.form-group{
    display:grid;
    gap:8px;
}
.form-group label{
    font-size:14px;
    font-weight:800;
    color:#334155;
}
.full-span{
    grid-column:1 / -1;
}
.btn-sm-link{
    padding:8px 12px;
    font-size:12px;
}
.clean-table tbody tr:hover{
    background:#f8fbff;
}
.alert {
    padding: 12px 14px;
    border-radius: 10px;
}
.alert-success {
    background: #e7f8ee;
    color: #0a7a36;
    border: 1px solid #c8f0d7;
}
.alert-danger {
    background: #ffe9e9;
    color: #b00000;
    border: 1px solid #ffd0d0;
}
@media (max-width:900px){
    .reports-stats{
        grid-template-columns:repeat(2,1fr);
    }
    .report-form-grid{
        grid-template-columns:1fr;
    }
}
@media (max-width:600px){
    .reports-stats{
        grid-template-columns:1fr;
    }
}
</style>
@endsection
