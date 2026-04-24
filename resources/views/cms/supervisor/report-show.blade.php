@extends('cms.supervisor.temp')
@section('title','show-report')
@section('main-title','عرض التقرير')

@section('content')
<div class="card p-4">
    <h3 class="mb-4">تفاصيل التقرير الأسبوعي</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <strong>الطالب:</strong>
            {{ $report->internship->student->full_name ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الشركة:</strong>
            {{ $report->internship->company->name ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الفرصة:</strong>
            {{ $report->internship->opportunity->title ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الأسبوع:</strong>
            {{ $report->week_number }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>تاريخ الإرسال:</strong>
            {{ $report->submitted_at ? $report->submitted_at->format('Y-m-d') : '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الحالة:</strong>
            {{ $report->status }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>عدد الساعات:</strong>
            {{ $report->hours_worked }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>بداية الأسبوع:</strong>
            {{ $report->week_start ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>نهاية الأسبوع:</strong>
            {{ $report->week_end ?? '-' }}
        </div>

        <div class="col-md-12 mb-3">
            <strong>المهام المنجزة:</strong>
            <div class="border rounded p-3 mt-2">{{ $report->tasks_completed ?? '-' }}</div>
        </div>

        <div class="col-md-12 mb-3">
            <strong>ما تعلمه الطالب:</strong>
            <div class="border rounded p-3 mt-2">{{ $report->learnings ?? '-' }}</div>
        </div>

        <div class="col-md-12 mb-3">
            <strong>التحديات:</strong>
            <div class="border rounded p-3 mt-2">{{ $report->challenges ?? '-' }}</div>
        </div>

        <div class="col-md-12 mb-3">
            <strong>المهام المخطط لها:</strong>
            <div class="border rounded p-3 mt-2">{{ $report->tasks_planned ?? '-' }}</div>
        </div>

        @if($report->file_path)
            <div class="col-md-12 mb-3">
                <strong>الملف المرفق:</strong><br>
                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-light mt-2">
                    عرض الملف
                </a>
            </div>
        @endif
    </div>

    <hr>

    <form method="POST" action="{{ route('cms.supervisor.weekly-reports.update', $report->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>ملاحظات المشرف</label>
            <textarea name="supervisor_feedback" class="form-control" rows="4">{{ old('supervisor_feedback', $report->supervisor_feedback) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>الحالة</label>
            <select name="status" class="form-control">
                <option value="قيد المراجعة" {{ $report->status == 'قيد المراجعة' ? 'selected' : '' }}>قيد المراجعة</option>
                <option value="تمت المراجعة" {{ $report->status == 'تمت المراجعة' ? 'selected' : '' }}>تمت المراجعة</option>
                <option value="مرفوض" {{ $report->status == 'مرفوض' ? 'selected' : '' }}>مرفوض</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">حفظ المراجعة</button>
        <a href="{{ route('cms.supervisor.weekly-reports') }}" class="btn btn-light">رجوع</a>
    </form>
</div>
@endsection
