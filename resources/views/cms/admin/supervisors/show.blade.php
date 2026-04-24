@extends('cms.admin.temp')

@section('title', 'عرض المشرف')
@section('main-title', 'عرض المشرف')

@section('content')
<div class="card p-4">
    <div class="row">
        <div class="col-md-6 mb-3"><strong>الاسم:</strong> {{ $supervisor->full_name }}</div>
        <div class="col-md-6 mb-3"><strong>البريد:</strong> {{ $supervisor->user->email ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>رقم الجوال:</strong> {{ $supervisor->phone ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الحالة:</strong> {{ $supervisor->status }}</div>
        <div class="col-md-6 mb-3"><strong>المدينة:</strong> {{ $supervisor->city->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الكلية:</strong> {{ $supervisor->college->name ?? '-' }}</div>
        <div class="col-md-12 mb-3"><strong>الملاحظات:</strong> {{ $supervisor->notes ?? '-' }}</div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.supervisors.edit', $supervisor->id) }}" class="btn btn-primary">تعديل</a>
        <a href="{{ route('admin.supervisors.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection
