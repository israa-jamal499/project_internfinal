@extends('cms.admin.temp')

@section('title', 'تعديل الملف الشخصي')
@section('main-title', 'تعديل الملف الشخصي')

@section('content')
<div class="card p-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row align-items-center mb-4">
            <div class="col-md-3 text-center mb-3 mb-md-0">
                @php
                    $adminImage = $user?->admin?->images?->first();
                @endphp

                <img
                    src="{{ $adminImage ? asset('storage/' . $adminImage->path) : asset('cms/dist/img/user2-160x160.jpg') }}"
                    alt="Admin Image"
                    class="img-fluid rounded-circle shadow mb-3"
                    style="width: 150px; height: 150px; object-fit: cover;"
                >

                <div>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

            <div class="col-md-9">
                <div class="form-group mb-3">
                    <label>الاسم</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $user->admin->name ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label>رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $user->admin->phone ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label>العنوان</label>
                    <input type="text" name="address" class="form-control"
                           value="{{ old('address', $user->admin->address ?? '') }}">
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            <a href="{{ route('admin.admin.profile') }}" class="btn btn-secondary">رجوع</a>
        </div>
    </form>
</div>
@endsection
