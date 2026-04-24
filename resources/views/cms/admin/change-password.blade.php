@extends('cms.admin.temp')

@section('title', 'تغيير كلمة المرور')
@section('main-title', 'تغيير كلمة المرور')
@section('css')
<style>
.alert{
    padding:12px 14px;
    border-radius:12px;
}
</style>
@endsection
@section('content')
<div class="card p-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
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

    <form action="{{ route('admin.password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>كلمة المرور الحالية</label>
            <input type="password" name="current_password" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>كلمة المرور الجديدة</label>
            <input type="password" name="new_password" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>تأكيد كلمة المرور الجديدة</label>
            <input type="password" name="new_password_confirmation" class="form-control">
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">حفظ التغيير</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">رجوع</a>
        </div>
    </form>
</div>
@endsection
