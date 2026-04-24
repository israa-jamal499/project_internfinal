@extends('front.layout.student')

@section('title','show-report')

@section('content')
<main class="student-page">
    <section class="white-card" style="padding:22px; border-radius:22px;">
        <h2>عرض التقرير الأسبوعي</h2>
        <hr>

        <p><strong>الأسبوع:</strong> {{ $report->week_number }}</p>
        <p><strong>الحالة:</strong> {{ $report->status }}</p>
        <p><strong>ساعات العمل:</strong> {{ $report->hours_worked }}</p>
        <p><strong>بداية الأسبوع:</strong> {{ $report->week_start ?? '-' }}</p>
        <p><strong>نهاية الأسبوع:</strong> {{ $report->week_end ?? '-' }}</p>

        <p><strong>المهام المنجزة:</strong><br>{{ $report->tasks_completed }}</p>
        <p><strong>ما تعلمته:</strong><br>{{ $report->learnings ?? '-' }}</p>
        <p><strong>التحديات:</strong><br>{{ $report->challenges ?? '-' }}</p>
        <p><strong>المهام المخطط لها:</strong><br>{{ $report->tasks_planned ?? '-' }}</p>
        <p><strong>ملاحظات المشرف:</strong><br>{{ $report->supervisor_feedback ?? 'لا توجد ملاحظات بعد' }}</p>

        @if($report->file_path)
            <p>
                <strong>الملف المرفق:</strong>
                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank">عرض الملف</a>
            </p>
        @endif

        <a href="{{ route('front.student.weekly-reports') }}" class="btn btn-primary">رجوع</a>
    </section>
</main>
@endsection
