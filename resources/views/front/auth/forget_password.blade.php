@extends('front.layout.main')
@section('title', 'password forgot')
@section('css')
@endsection
@section('content')

<main class="login-page">

  <div class="login-card">

    <h2>🔑 استعادة كلمة المرور</h2>

    <p class="login-sub">
      أدخلي بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور
    </p>

    <form onsubmit="sendResetLink(event)">

      <div class="input-group">
        <input type="email" id="resetEmail" required placeholder="البريد الإلكتروني">
        <span class="icon">📧</span>
      </div>

      <button type="submit" class="login-btn">
        إرسال رابط الاستعادة
      </button>

    </form>

    <div class="login-links">
      <a href="{{ route('front.auth.login') }}">← العودة إلى تسجيل الدخول</a>
    </div>

  </div>

</main>
@endsection

@section('js')

@endsection
