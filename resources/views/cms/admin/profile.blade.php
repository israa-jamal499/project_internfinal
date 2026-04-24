@extends('cms.admin.temp')

@section('title', 'الملف الشخصي')
@section('main-title', 'الملف الشخصي')

@section('content')
<div class="card p-4">

    <div class="row align-items-center mb-4">
        <div class="col-md-3 text-center mb-3 mb-md-0">
            @php
                $adminImage = $user?->admin?->images?->first();
            @endphp

            <img
                src="{{ $adminImage ? asset('storage/' . $adminImage->path) : asset('cms/dist/img/user2-160x160.jpg') }}"
                alt="Admin Image"
                class="img-fluid rounded-circle shadow"
                style="width: 150px; height: 150px; object-fit: cover;"
            >
        </div>

        <div class="col-md-9">
            <h3 class="mb-3">{{ $user->admin->name ?? 'مدير النظام' }}</h3>
            <p class="mb-2"><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
            <p class="mb-2"><strong>رقم الهاتف:</strong> {{ $user->admin->phone ?? '-' }}</p>
            <p class="mb-2"><strong>العنوان:</strong> {{ $user->admin->address ?? '-' }}</p>
            <p class="mb-2"><strong>الدور:</strong> {{ $user->role ?? 'admin' }}</p>
            <p class="mb-0">
                <strong>الحالة:</strong>
                @if(($user->status ?? '') == 'active')
                    <span class="badge badge-success">نشط</span>
                @else
                    <span class="badge badge-danger">غير نشط</span>
                @endif
            </p>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="border rounded p-3 h-100">
                <h5 class="mb-3">معلومات الحساب</h5>
                <p class="mb-2"><strong>اسم الأدمن:</strong> {{ $user->admin->name ?? '-' }}</p>
                <p class="mb-2"><strong>الإيميل:</strong> {{ $user->email }}</p>
                <p class="mb-0"><strong>الحالة:</strong> {{ $user->status ?? '-' }}</p>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="border rounded p-3 h-100">
                <h5 class="mb-3">معلومات إضافية</h5>
                <p class="mb-2"><strong>رقم الهاتف:</strong> {{ $user->admin->phone ?? '-' }}</p>
                <p class="mb-2"><strong>العنوان:</strong> {{ $user->admin->address ?? '-' }}</p>
                <p class="mb-0"><strong>معرف المستخدم:</strong> {{ $user->id }}</p>
            </div>
        </div>

    </div>

    <div class="mt-3">
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">تعديل الملف الشخصي</a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">رجوع</a>
    </div>

</div>
@endsection
