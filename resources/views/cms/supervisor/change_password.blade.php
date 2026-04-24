@extends('cms.supervisor.temp')
@section('title','change-password')
@section('main-title','تغيير كلمة المرور')

@section('content')
<style>
.supervisor-password-page{
    width:92%;
    margin:30px auto;
    direction:rtl;
    font-family:Tahoma, Arial, sans-serif;
}

.supervisor-password-card{
    max-width:500px;
    margin:auto;
    background:#fff;
    padding:24px;
    border-radius:16px;
    box-shadow:0 8px 24px rgba(0,0,0,0.06);
    border:1px solid #eef3f6;
}

.supervisor-password-title{
    font-size:22px;
    font-weight:bold;
    color:#1c2b4a;
    margin-bottom:8px;
}

.supervisor-password-desc{
    color:#6b7280;
    font-size:13px;
    margin-bottom:20px;
}

.supervisor-password-group{
    margin-bottom:14px;
}

.supervisor-password-label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    color:#1c2b4a;
    font-size:14px;
}

.supervisor-password-input{
    width:100%;
    padding:11px 12px;
    border:1px solid #dbe3ee;
    border-radius:10px;
    font-size:14px;
    outline:none;
}

.supervisor-password-input:focus{
    border-color:#3e7cd7;
    box-shadow:0 0 0 3px rgba(62,124,215,0.12);
}

.supervisor-password-btn{
    width:100%;
    margin-top:10px;
    border:none;
    background:#3e7cd7;
    color:#fff;
    padding:12px;
    border-radius:10px;
    font-weight:bold;
    cursor:pointer;
}

.alert-success{
    background:#e9f9ef;
    color:#166534;
    border:1px solid #c7efd3;
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:12px;
}

.alert-danger{
    background:#fff1f2;
    color:#b42318;
    border:1px solid #fecdd3;
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:12px;
}
</style>

<div class="supervisor-password-page">
    <div class="supervisor-password-card">

        <div class="supervisor-password-title">🔒 تغيير كلمة المرور</div>
        <div class="supervisor-password-desc">أدخل كلمة المرور الحالية ثم الجديدة</div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-danger">
                <ul style="margin:0;padding-right:18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cms.supervisor.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="supervisor-password-group">
                <label class="supervisor-password-label">كلمة المرور الحالية</label>
                <input type="password" name="current_password" class="supervisor-password-input">
            </div>

            <div class="supervisor-password-group">
                <label class="supervisor-password-label">كلمة المرور الجديدة</label>
                <input type="password" name="new_password" class="supervisor-password-input">
            </div>

            <div class="supervisor-password-group">
                <label class="supervisor-password-label">تأكيد كلمة المرور الجديدة</label>
                <input type="password" name="new_password_confirmation" class="supervisor-password-input">
            </div>

            <button type="submit" class="supervisor-password-btn">حفظ كلمة المرور الجديدة</button>
        </form>
    </div>
</div>
@endsection
