<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UCAS Internship Portal ||@yield('title')</title>
@yield('css')
  <link rel="stylesheet" href="{{ asset('internship/css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>

<!-- ===== Navbar ===== -->
<nav class="navbar">

  <div class="menu_1">
    <a id="btn_sidmenu">
      <i class="fas fa-bars"></i>
    </a>
  </div>

  <div class="logo-container">
    <img src="{{ asset('internship/img/LOGO-WWB.png') }}" class="college-logo">
  </div>

<ul class="nav-links">
    <li><a href="{{ route('front.home.front.home.index') }}">الرئيسية</a></li>


    <li><a href="{{ route('front.home.opportunities') }}">فرص التدريب</a></li>



    <li><a href="{{ route('front.home.about') }}">عن النظام</a></li>
    <li><a href="{{ route('front.home.how-it-works') }}">كيف يعمل</a></li>
  </ul>

  <div class="nav-actions">
    <div class="search-box">
      <input type="text" placeholder="ابحث عن فرص التدريب..." id="searchInput">
      <button class="search-btn" id="searchBtn">🔍</button>
    </div>

    <a href="{{ route('front.auth.login') }}" class="btn btn-login">دخول</a>
    <a href="{{ route('front.auth.register-new') }}" class="btn btn-register">حساب جديد</a>
  </div>

</nav>

<!-- ===== Side Menu ===== -->
<div class="side-menu" id="sideMenu">

  <div class="menu-header">
    <span>القائمة</span>
    <button class="close-btn" id="closeMenu">
      <i class="fas fa-times"></i>
    </button>
  </div>

  <a href="{{ route('front.home.front.home.index') }}">الرئيسية</a>
  <a href="{{ route('front.home.opportunities') }}">فرص التدريب</a>
  <a href="{{ route('front.auth.login') }}">تسجيل دخول</a>
  <a href="{{ route('front.auth.register-student') }}">تسجيل طالب</a>
  <a href="{{ route('front.auth.register-company') }}">تسجيل شركة</a>
  <a href="{{ route('front.home.how-it-works') }}">كيف يعمل</a>

</div>
<div class="overlay" id="overlay"></div>
@yield('content')


<!-- ===== Footer ===== -->
<footer>
  <p>&copy; 2026 UCAS Internship Portal</p>
</footer>
@yield('js')
<script src="{{ asset('internship/js/main.js') }}"></script>

</body>
</html>

