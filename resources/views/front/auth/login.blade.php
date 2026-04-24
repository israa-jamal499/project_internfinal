@extends('front.layout.main')
@section('title', 'login')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700&display=swap">
<link rel="stylesheet" href="{{ asset('cms/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="{{ asset('cms/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('cms/plugins/jqvmap/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('cms/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<link rel="stylesheet" href="{{ asset('cms/plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('cms/plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    .login-link {
        color: #ffffff;
        font-weight: 500;
        text-decoration: none;
    }

    .login-link:hover {
        color: #ffd700;
    }

    .login-page {
        min-height: 90vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #1e4fa3, #0f2b5b);
        padding: 40px 20px;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(14px);
        padding: 35px;
        border-radius: 20px;
        text-align: center;
        color: white;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .login-subtitle {
        opacity: 0.9;
        margin-bottom: 20px;
    }

    .input-group {
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }

    .input-group i {
        padding: 0 14px;
        color: #666;
    }

    .input-group input {
        width: 100%;
        padding: 14px;
        border: none;
        outline: none;
        font-size: 15px;
        background: transparent;
    }

    .login-btn {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: none;
        background: rgb(15, 79, 152);
        color: white;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        margin-bottom: 14px;
    }

    .login-btn:hover {
        background: #0b1e45;
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 15px;
        text-align: right;
    }

    .alert-danger {
        background: #ffe5e5;
        color: #a10000;
    }

    .alert-success {
        background: #e5ffea;
        color: #0b6b2d;
    }
</style>
@endsection

@section('content')
<section class="login-page">
    <div class="login-card">
        <h2>مرحبًا بعودتك 👋</h2>
        <p class="login-subtitle">سجل الدخول لمتابعة فرص التدريب</p>

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
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('front.auth.login.post') }}">
            @csrf

            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input
                    type="email"
                    name="email"
                    placeholder="البريد الإلكتروني"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input
                    type="password"
                    name="password"
                    placeholder="كلمة المرور"
                    required
                >
            </div>

            <button type="submit" class="login-btn">
                تسجيل الدخول
            </button>

            <div class="social-auth-links text-center mb-3">
                <a href="" class="btn btn-danger mb-2 d-block">
                    تسجيل الدخول باستخدام جوجل
                </a>

                <a href="" class="btn btn-primary d-block">
                    تسجيل الدخول باستخدام فيسبوك
                </a>
            </div>

            <p class="mb-1">
                <a href="{{ route('front.auth.forgot-password') }}" class="login-link">نسيت كلمة المرور</a>
            </p>

            <p class="mb-0">
                <a href="{{ route('front.auth.register-new') }}" class="login-link">تسجيل جديد</a>
            </p>
        </form>
    </div>
</section>
@endsection

@section('js')
@endsection
