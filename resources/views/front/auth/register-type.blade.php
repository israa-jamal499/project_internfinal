@extends('front.layout.main')
@section('title',content: 'New Regestrition')

@section('content')
@section('css')
@endsection
 <style>
/* ===== Auth Background ===== */

.auth-bg {
  min-height: 100vh;
  background: linear-gradient(135deg, #1e3c72, #2a5298);
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  overflow: hidden;
}

/* دوائر الخلفية */

.bg-circle {
  position: absolute;
  border-radius: 50%;
  background: rgba(255,255,255,0.08);
}

.circle-1 {
  width: 500px;
  height: 500px;
  top: -150px;
  left: -150px;
}

.circle-2 {
  width: 450px;
  height: 450px;
  bottom: -150px;
  right: -150px;
}

/* الكارد الرئيسي */

.auth-card {
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(12px);
  padding: 40px;
  border-radius: 24px;
  width: 480px;
  text-align: center;
  color: white;
  box-shadow: 0 10px 40px rgba(0,0,0,0.2);
  z-index: 1;
}

.auth-card h2 {
  margin-bottom: 10px;
   margin-bottom: 15px;
}

.auth-card p {
  opacity: 0.9;
  margin-bottom: 30px;
   margin-bottom: 35px;
}

/* خيارات الحساب */

.account-options {
  display: flex;
  gap: 20px;
}

.account-box {
  flex: 1;
  background: rgba(255,255,255,0.9);
  color: #1e3c72;
  padding: 25px;
  border-radius: 16px;
  text-decoration: none;
  transition: 0.3s ease;
   cursor: pointer;
  border: 2px solid transparent;
  font-size: 32px;
}
.account-box:active {
  transform: scale(0.97);
   border-color: #2a74ff;
  background: white;
  box-shadow: 0 0 20px rgba(42,116,255,0.25);
}

.account-box h3 {
  margin: 10px 0 5px;
  font-size: 22px;
  font-weight: 800;
}

.account-box span {
  font-size: 14px;
  opacity: 0.8;
}

.account-box:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
   border-color: #2a74ff;
  background: white;
}
.auth-card {
  animation: fadeIn 0.6s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive */

@media (max-width: 600px) {
  .account-options {
    flex-direction: column;
  }

  .auth-card {
    width: 90%;
  }
}

 </style>


<section class="auth-bg">

  <!-- دوائر الخلفية -->
  <div class="bg-circle circle-1"></div>
  <div class="bg-circle circle-2"></div>

  <!-- الكارد -->
  <div class="auth-card">

    <h2>اختر نوع الحساب</h2>
    <p>حدد نوع الحساب الذي تريد إنشاءه</p>

    <div class="account-options">

      <a href="{{ route('front.auth.register-student') }}" class="account-box">
        🎓
        <h3>طالب</h3>
        <span>التقديم على فرص التدريب</span>
      </a>

      <a href="{{ route('front.auth.register-company') }}" class="account-box">
        🏢
        <h3>شركة</h3>
        <span>نشر فرص تدريب</span>
      </a>

    </div>

  </div>

</section>






@section('js')
@endsection
@endsection
