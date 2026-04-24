@extends('cms.admin.temp')

@section('title', 'عرض الشركة')
@section('main-title', 'عرض الشركة')

@section('content')
<div class="card p-4">
    <div class="row">
        <div class="col-md-6 mb-3"><strong>اسم الشركة:</strong> {{ $company->name }}</div>
        <div class="col-md-6 mb-3"><strong>البريد:</strong> {{ $company->user->email ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>رقم الجوال:</strong> {{ $company->phone ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الحالة:</strong> {{ $company->status }}</div>
        <div class="col-md-6 mb-3"><strong>المدينة:</strong> {{ $company->city->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الموقع الإلكتروني:</strong> {{ $company->website ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>مجال العمل:</strong> {{ $company->field_name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>العنوان:</strong> {{ $company->address ?? '-' }}</div>
        <div class="col-md-12 mb-3"><strong>الوصف:</strong> {{ $company->description ?? '-' }}</div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.companies.edit', $company->id) }}" class="btn btn-primary">تعديل</a>
        <a href="{{ route('admin.companies.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection
