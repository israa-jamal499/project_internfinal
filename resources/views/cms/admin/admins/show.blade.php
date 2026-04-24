@extends('cms.admin.temp')

@section('title', 'عرض الأدمن')
@section('main-title', 'عرض الأدمن')

@section('content')
<div class="card p-4">
    <div class="row">
        <div class="col-md-6 mb-3"><strong>الاسم:</strong> {{ $admin->name }}</div>
        <div class="col-md-6 mb-3"><strong>البريد:</strong> {{ $admin->user->email ?? '—' }}</div>
        <div class="col-md-6 mb-3"><strong>الهاتف:</strong> {{ $admin->phone ?? '—' }}</div>
        <div class="col-md-6 mb-3"><strong>العنوان:</strong> {{ $admin->address ?? '—' }}</div>
    </div>

    <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">رجوع</a>
</div>
@endsection
