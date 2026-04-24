@extends('cms.supervisor.parent')
@section('title','show student')
@section('main-title','عرض الطالب')

@section('css')
<link rel="stylesheet" href="{{ asset('internship/css/admin.css') }}">
@endsection

@section('content')
<main class="page">
    <div class="page-head">
        <div class="page-title">
            <p>عرض بيانات الطالب.</p>
        </div>

        <div class="page-actions">
            <a href="{{ route('cms.supervisor.students.index') }}" class="btn btn-outline">رجوع</a>
            <a href="{{ route('cms.supervisor.students.edit', $student->id) }}" class="btn btn-primary">تعديل</a>
        </div>
    </div>

    <section class="card">
        <div class="card-head">
            <h2>{{ $student->full_name }}</h2>
            <div class="hint">{{ $student->general_status }}</div>
        </div>

        <div class="tools-row">
            <div class="tool"><label>البريد</label><input value="{{ $student->user->email ?? '-' }}" disabled></div>
            <div class="tool"><label>الرقم الجامعي</label><input value="{{ $student->university_number }}" disabled></div>
            <div class="tool"><label>الكلية</label><input value="{{ $student->college->name ?? '-' }}" disabled></div>
            <div class="tool"><label>التخصص</label><input value="{{ $student->specialization->name ?? '-' }}" disabled></div>
            <div class="tool"><label>المدينة</label><input value="{{ $student->city->name ?? '-' }}" disabled></div>
            <div class="tool"><label>الهاتف</label><input value="{{ $student->phone ?? '-' }}" disabled></div>
            <div class="tool"><label>الجنس</label><input value="{{ $student->gender }}" disabled></div>
            <div class="tool"><label>تاريخ الميلاد</label><input value="{{ $student->birthdate ?? '-' }}" disabled></div>
            <div class="tool"><label>العنوان</label><input value="{{ $student->address ?? '-' }}" disabled></div>
            <div class="tool"><label>CV</label><input value="{{ $student->cv ?? '-' }}" disabled></div>
        </div>
    </section>
</main>
@endsection
