@extends('cms.admin.temp')

@section('title', 'عرض الطالب')
@section('main-title', 'عرض الطالب')

@section('content')
<div class="card p-4">
    <div class="row">
        <div class="col-md-6 mb-3"><strong>الاسم:</strong> {{ $student->full_name }}</div>
        <div class="col-md-6 mb-3"><strong>البريد:</strong> {{ $student->user->email ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الرقم الجامعي:</strong> {{ $student->university_number }}</div>
        <div class="col-md-6 mb-3"><strong>المستوى:</strong> {{ $student->level ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الحالة:</strong> {{ $student->general_status }}</div>
        <div class="col-md-6 mb-3"><strong>الجنس:</strong> {{ $student->gender ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>تاريخ الميلاد:</strong> {{ $student->birthdate ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>رقم الجوال:</strong> {{ $student->phone ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>العنوان:</strong> {{ $student->address ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>المدينة:</strong> {{ $student->city->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الكلية:</strong> {{ $student->college->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>التخصص:</strong> {{ $student->specialization->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>CV:</strong> {{ $student->cv ?? '-' }}</div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-primary">تعديل</a>
        <a href="{{ route('admin.students.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection
