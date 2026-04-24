@extends('front.layout.main')
@section('title', 'Company Register')

@section('css')
<style>
  .register-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    position: relative;
    overflow: hidden;
    padding: 40px 20px;
  }

  .register-section::before,
  .register-section::after {
    content: "";
    position: absolute;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
  }

  .register-section::before {
    top: -120px;
    right: -120px;
  }

  .register-section::after {
    bottom: -120px;
    left: -120px;
  }

  .register-card {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(12px);
    padding: 30px;
    width: 100%;
    max-width: 420px;
    border-radius: 20px;
    text-align: center;
    color: white;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    transition: 0.3s ease;
  }

  .register-card:hover {
    transform: translateY(-5px);
  }

  .register-card h2 {
    margin-bottom: 8px;
    font-size: 22px;
  }

  .register-card p {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 20px;
  }

  .register-card form {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .register-card input,
  .register-card select,
  .register-card textarea {
    width: 100%;
    min-height: 46px;
    padding: 12px 14px;
    border-radius: 10px;
    border: none;
    outline: none;
    font-size: 14px;
    box-sizing: border-box;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
  }

  .register-card textarea {
    resize: vertical;
    min-height: 90px;
  }

  .register-card button {
    padding: 14px;
    border-radius: 10px;
    border: none;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    background: #1e78ff;
  }

  .register-card button:hover {
    opacity: 0.9;
    background: #0f5ed8;
  }

  .register-card span {
    display: block;
    margin-top: 15px;
    font-size: 14px;
  }

  .register-card a {
    color: #fff;
    text-decoration: underline;
  }

  .alert {
    padding: 10px 14px;
    border-radius: 10px;
    text-align: right;
    margin-bottom: 10px;
    font-size: 14px;
  }

  .alert-danger {
    background: rgba(255, 77, 77, 0.18);
    color: #fff;
  }

  .alert-success {
    background: rgba(46, 204, 113, 0.18);
    color: #fff;
  }
</style>
@endsection

@section('content')
<section class="register-section">
  <div class="register-card">
    <h2>🏢 إنشاء حساب شركة</h2>
    <p>أدخلي بيانات الشركة لإنشاء حساب جديد</p>

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

    <form method="POST" action="{{ route('front.auth.register-company.store') }}">
      @csrf

      <input
        type="text"
        name="name"
        placeholder="اسم الشركة"
        value="{{ old('name') }}"
        required
      >

      <input
        type="email"
        name="email"
        placeholder="البريد الإلكتروني للشركة"
        value="{{ old('email') }}"
        required
      >

      <input
        type="text"
        name="responsible_name"
        placeholder="اسم المسؤول"
        value="{{ old('responsible_name') }}"
      >

      <input
        type="tel"
        name="phone"
        placeholder="رقم الهاتف"
        value="{{ old('phone') }}"
      >

      <select name="city_id">
        <option value="">اختر المدينة</option>
        @foreach($cities as $city)
          <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
            {{ $city->name }}
          </option>
        @endforeach
      </select>

      <input
        type="text"
        name="address"
        placeholder="العنوان"
        value="{{ old('address') }}"
      >

      <input
        type="text"
        name="website"
        placeholder="الموقع الإلكتروني"
        value="{{ old('website') }}"
      >

      <input
        type="text"
        name="field_name"
        placeholder="مجال عمل الشركة"
        value="{{ old('field_name') }}"
      >

      <textarea
        name="description"
        placeholder="وصف مختصر عن الشركة"
      >{{ old('description') }}</textarea>

      <input
        type="password"
        name="password"
        placeholder="كلمة المرور"
        required
      >

      <input
        type="password"
        name="password_confirmation"
        placeholder="تأكيد كلمة المرور"
        required
      >

      <button type="submit">إنشاء حساب الشركة</button>
    </form>

    <span>
      لديك حساب؟ <a href="{{ route('front.auth.login') }}">سجل الدخول</a>
    </span>
  </div>
</section>
@endsection

@section('js')
@endsection
