@extends('front.layout.student')

@section('title','تغيير كلمة المرور')

@section('content')

<style>
.password-page {
    width: 92%;
    margin: 30px auto;
    direction: rtl;
    font-family: Tahoma;
}

.password-card {
    background: #fff;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    max-width: 500px;
    margin: auto;
}

.password-title {
    font-size: 22px;
    font-weight: bold;
    color: #1c2b4a;
    margin-bottom: 10px;
}

.password-desc {
    color: #6b7280;
    font-size: 13px;
    margin-bottom: 20px;
}

.password-group {
    margin-bottom: 15px;
}

.password-label {
    font-weight: bold;
    font-size: 14px;
    color: #1c2b4a;
    margin-bottom: 6px;
    display: block;
}

.password-input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 14px;
}

.password-input:focus {
    border-color: #3e7cd7;
    box-shadow: 0 0 0 3px rgba(62,124,215,0.12);
    outline: none;
}

.password-btn {
    margin-top: 15px;
    width: 100%;
    background: #3e7cd7;
    color: #fff;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

.password-btn:hover {
    background: #2f68bd;
}

.password-error {
    color: red;
    font-size: 13px;
    margin-top: 5px;
}

.password-success {
    color: green;
    font-weight: bold;
    margin-bottom: 10px;
}
</style>

<div class="password-page">

    <div class="password-card">

        <div class="password-title">🔒 تغيير كلمة المرور</div>
        <div class="password-desc">يرجى إدخال كلمة المرور الحالية ثم الجديدة</div>

        {{-- رسالة نجاح --}}
        @if(session('success'))
            <div class="password-success">{{ session('success') }}</div>
        @endif

        {{-- رسالة خطأ --}}
        @if(session('error'))
            <div class="password-error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('front.student.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="password-group">
                <label class="password-label">كلمة المرور الحالية</label>
                <input type="password" name="current_password" class="password-input">
            </div>

            <div class="password-group">
                <label class="password-label">كلمة المرور الجديدة</label>
                <input type="password" name="new_password" class="password-input">
            </div>

            <div class="password-group">
                <label class="password-label">تأكيد كلمة المرور</label>
                <input type="password" name="new_password_confirmation" class="password-input">
            </div>

            <button class="password-btn">تغيير كلمة المرور</button>

        </form>

    </div>

</div>

@endsection
