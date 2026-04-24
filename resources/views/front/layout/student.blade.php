<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student || @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('internship/css/student.css') }}">
    @yield('css')
</head>
<body>

   @php
    $authUser = auth()->user()?->loadMissing('student.images');
    $studentModel = $authUser?->student;
    $studentImage = $studentModel?->images?->first();

    $studentName = $studentName ?? ($studentModel->full_name ?? 'اسم الطالب');
    $studentId   = $studentId ?? ($studentModel->university_number ?? '202200000');
    $studentAvatar = $studentAvatar ?? (
        $studentImage
            ? asset('storage/' . $studentImage->path)
            : asset('internship/img/default-avatar.png')
    );
@endphp

    <header class="student-topbar">
        <div class="topbar-container">

            <div class="topbar-right">
                <div class="topbar-title">
                    <h3 id="pageTitle">لوحة الطالب</h3>
                    <p>نظام التدريب الميداني</p>
                </div>
            </div>

            <div class="topbar-left">

                <div class="notif-wrapper">
                    <button type="button" class="topbar-icon-btn" id="notifBtn" aria-label="الإشعارات">
                        <span class="topbar-icon">🔔</span>
                        <span class="notif-badge" id="notifCount">0</span>
                    </button>

                    <div class="notif-dropdown" id="notifDropdown">
                        <div class="notif-header">
                            <h4>الإشعارات</h4>
                            <span class="notif-sub">آخر التنبيهات الخاصة بك</span>
                        </div>

                        <div class="notif-body" id="notifBody">
                            <a href="{{ route('front.student.notifications') }}" class="notif-item">
                                <span class="notif-title">لا توجد إشعارات جديدة</span>
                                <span class="notif-desc">يمكنك متابعة جميع الإشعارات من الصفحة المخصصة</span>
                            </a>
                        </div>

                        <div class="notif-footer">
                            <a href="{{ route('front.student.notifications') }}">عرض كل الإشعارات</a>
                        </div>
                    </div>
                </div>

                <div class="student-profile-wrapper">
                   <button type="button" class="student-profile" id="studentMenuBtn" aria-label="قائمة الطالب">
    <img src="{{ $studentAvatar }}" alt="Student" class="student-avatar">

    <div class="student-info">
        <span class="student-name">{{ $studentName }}</span>
        <span class="student-id">{{ $studentId }}</span>
    </div>

    <span class="student-arrow">▾</span>
</button>

                    <div class="student-dropdown" id="studentDropdown">

                        <a href="{{ route('front.student.profile') }}">تعديل الملف الشخصي</a>
                        <a href="{{ route('front.student.password.edit') }}">🔒 تغيير كلمة المرور</a>

                        <hr>
                        <a href="{{ route('front.auth.login') }}" class="logout">🚪 تسجيل خروج</a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <nav class="student-pages-nav">
        <div class="student-pages-container">
            <a href="{{ route('front.student.dashboard') }}" data-title="لوحة الطالب">🏠 الرئيسية</a>
            <a href="{{ route('front.student.profile') }}" data-title="الملف الشخصي">👤 الملف الشخصي</a>
            <a href="{{ route('front.student.applications') }}" data-title="طلباتي">📌 طلباتي</a>
            <a href="{{ route('front.student.internship') }}" data-title="ملف التدريب">🏢 التدريب</a>
            <a href="{{ route('front.student.messages') }}" data-title="الرسائل">💬 الرسائل</a>
            <a href="{{ route('front.student.weekly-reports') }}" data-title="التقارير">📝 التقارير</a>
            <a href="{{ route('front.student.hours') }}" data-title="ساعات التدريب">⏳ الساعات</a>
            <a href="{{ route('front.student.certificate') }}" data-title="الشهادة">🎓 الشهادة</a>
            <a href="{{ route('front.student.notifications') }}" data-title="الإشعارات">🔔 الإشعارات</a>
        </div>
    </nav>

    <main class="student-main">
        @yield('content')
    </main>

    <footer class="main-footer">
        <div class="footer-container">

            <div class="footer-col">
                <h3>بوابة التدريب الميداني</h3>
                <p>
                    منصة رسمية تساعد طلبة الكلية الجامعية للعلوم التطبيقية على البحث عن فرص التدريب،
                    التقديم عليها، ومتابعة الساعات والتقارير والتقييمات بشكل منظم.
                </p>
            </div>

            <div class="footer-col">
                <h3>روابط سريعة</h3>
                <ul>
                    <li><a href="{{ route('front.home.front.home.index') }}">الرئيسية</a></li>
                    <li><a href="{{ route('front.home.opportunities') }}">فرص التدريب</a></li>
                    <li><a href="{{ route('front.auth.login') }}">تسجيل الدخول</a></li>
                    <li><a href="{{ route('front.auth.register-student') }}">تسجيل طالب</a></li>
                    <li><a href="{{ route('front.auth.register-company') }}">تسجيل شركة</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>تواصل معنا</h3>
                <ul>
                    <li>📍 فلسطين - غزة</li>
                    <li>📧 info@ucas.edu.ps</li>
                    <li>🌐 ucas.edu.ps</li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p>© 2026 الكلية الجامعية للعلوم التطبيقية - جميع الحقوق محفوظة</p>
        </div>
    </footer>

    <script src="{{ asset('internship/js/student.js') }}"></script>
    @yield('js')
</body>
</html>
