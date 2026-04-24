@extends('cms.admin.temp')
@section('title', 'Show Internship')
@section('main-title', 'عرض التدريب')

@section('content')
<div class="card p-4">
    <div class="row">

        <div class="col-md-6 mb-3">
            <strong>الطالب:</strong>
            {{ $internship->student->full_name ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>البريد الإلكتروني:</strong>
            {{ $internship->student->user->email ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>التخصص:</strong>
            {{ $internship->student->specialization->name ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الكلية:</strong>
            {{ $internship->student->college->name ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الشركة:</strong>
            {{ $internship->company->name ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>المشرف:</strong>
            {{ $internship->supervisor->full_name ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الفرصة:</strong>
            {{ $internship->opportunity->title ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الحالة:</strong>
            {{ $internship->status }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>تاريخ البداية:</strong>
            {{ $internship->start_date ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>تاريخ النهاية:</strong>
            {{ $internship->end_date ?? '-' }}
        </div>

        <div class="col-md-4 mb-3">
            <strong>الساعات المطلوبة:</strong>
            {{ $internship->required_hours }}
        </div>

        <div class="col-md-4 mb-3">
            <strong>الساعات المنجزة:</strong>
            {{ $internship->completed_hours }}
        </div>

        <div class="col-md-4 mb-3">
            <strong>إجمالي الساعات:</strong>
            {{ $internship->total_hours }}
        </div>

        <div class="col-md-12 mb-3">
            <strong>الملاحظات:</strong>
            {{ $internship->notes ?? '-' }}
        </div>

        <div class="col-md-12 mb-3">
            <strong>المهام:</strong>
            {{ $internship->tasks ?? '-' }}
        </div>

    </div>

    <div class="mt-3">
        <a href="{{ route('admin.internships.edit', $internship->id) }}" class="btn btn-primary">تعديل</a>
        <a href="{{ route('admin.internships.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection
