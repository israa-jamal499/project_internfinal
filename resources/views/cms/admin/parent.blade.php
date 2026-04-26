<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>بوابة التدريب الميداني | @yield('title')</title>

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
    <link rel="stylesheet" href="{{ asset('internship/css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
/* ===== إعداد عام ===== */
body {
    font-family: 'Cairo', sans-serif;
    direction: rtl;
    text-align: right;
}

/* ===== RTL Fix ===== */
.main-sidebar {
    right: 0;
    left: auto;
}

.content-wrapper,
.main-header,
.main-footer {
    margin-right: 250px;
    margin-left: 0 !important;
}

.sidebar-collapse .content-wrapper,
.sidebar-collapse .main-header,
.sidebar-collapse .main-footer {
    margin-right: 0 !important;
}

.sidebar-collapse .main-sidebar {
    margin-right: -250px;
}

/* ===== Navbar ===== */
.main-header.navbar {
    background: linear-gradient(90deg, #0f4c81, #1d5fa7) !important;
}

.main-header .nav-link {
    color: #fff !important;
}

/* ===== Sidebar ===== */
.main-sidebar {
    background: linear-gradient(180deg, #0f4c81, #1d5fa7) !important;
}

/* Brand */
.brand-link {
    text-align: right;
    color: #fff !important;
}

/* User */
.user-panel .info {
    padding-right: 10px;
}

.user-panel .info a {
    color: #fff !important;
}

/* ===== Menu ===== */
.nav-sidebar .nav-link {
    text-align: right;
    color: #fff !important;
}

.nav-sidebar .nav-icon {
    margin-left: .5rem;
    margin-right: 0;
}

/* Hover */
.nav-sidebar .nav-link:hover {
    background-color: rgba(255,255,255,0.1);
}

/* Active */
.nav-sidebar .nav-link.active {
    background: #fff !important;
    color: #0f4c81 !important;
}

.nav-sidebar .nav-link.active i,
.nav-sidebar .nav-link.active p {
    color: #0f4c81 !important;
}

/* Sub menu */
.nav-sidebar .nav-treeview {
    padding-right: 14px;
}

.nav-sidebar .nav-treeview .nav-link {
    padding-right: 30px;
    background: rgba(255,255,255,0.05);
}

/* ===== Dropdown ===== */
.dropdown-menu {
    direction: rtl;
    text-align: right;
}

.navbar-search-block .form-control-navbar {
    text-align: right;
}

/* ===== Footer ===== */
.main-footer {
    background: #1d5fa7;
    color: #fff;
}

.main-footer * {
    color: #fff;
}

/* ===== Mobile ===== */
@media (max-width: 991.98px) {
    .content-wrapper,
    .main-header,
    .main-footer {
        margin-right: 0 !important;
    }

    .main-sidebar {
        margin-right: -250px;
    }

    .sidebar-open .main-sidebar {
        margin-right: 0;
    }
}
/* ===== إصلاح شكل البحث في السايدبار ===== */

.sidebar .input-group {
    display: flex !important;
    flex-direction: row-reverse !important; /* مهم للـ RTL */
}

.form-control-sidebar {
    text-align: right !important;
    border-radius: 0 8px 8px 0 !important;
}

.btn-sidebar {
    border-radius: 8px 0 0 8px !important;
    display: flex !important;
    align-items: center;
    justify-content: center;
}

/* توسيط الأيقونة */
.btn-sidebar i {
    margin: 0 !important;
}
</style>

    @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('cms/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">الرئيسية</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.students.index') }}" class="nav-link text-white">الطلاب</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.companies.index') }}" class="nav-link text-white">الشركات</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.supervisors.index') }}" class="nav-link text-white">المشرفون</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.opportunities.index') }}" class="nav-link text-white">الفرص</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.internships.index') }}" class="nav-link text-white">التدريب</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.cms.admin.report') }}" class="nav-link text-white">التقارير</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.admin.certificates.index') }}" class="nav-link text-white">الشهادات</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.notifications') }}" class="nav-link text-white">الإشعارات</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link text-white" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="ابحث هنا" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Messages Dropdown -->
            {{-- <li class="nav-item dropdown">
                <a class="nav-link text-white" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge-danger navbar-badge">{{ $unreadAdminMessagesCount }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-right" dir="rtl">
    <span class="dropdown-item dropdown-header">{{ $adminMessages->count() }} رسائل</span>
    <div class="dropdown-divider"></div>

    @forelse($adminMessages as $message)
        <a href="#" class="dropdown-item">
            <div class="media">
                <img src="{{ asset('cms/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle ml-3">
                <div class="media-body text-right">
                    <h3 class="dropdown-item-title">
                        {{
                            $message->sender->student->full_name
                            ?? $message->sender->company->name
                            ?? $message->sender->supervisor->full_name
                            ?? 'مستخدم'
                        }}
                        @if(!$message->is_read)
                            <span class="float-left text-sm text-danger"><i class="fas fa-star"></i></span>
                        @endif
                    </h3>

                    <p class="text-sm">{{ \Illuminate\Support\Str::limit($message->body, 35) }}</p>
                    <p class="text-sm text-muted">
                        <i class="far fa-clock ml-1"></i> {{ $message->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </a>

        <div class="dropdown-divider"></div>
    @empty
        <span class="dropdown-item text-center">لا توجد رسائل</span>
        <div class="dropdown-divider"></div>
    @endforelse

    <a href="#" class="dropdown-item dropdown-footer">عرض كل الرسائل</a>
</div>
            </li> --}}

            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link text-white" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge-warning navbar-badge">{{ $unreadAdminNotificationsCount }}</span>
                </a>
               <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-right" dir="rtl">
    <span class="dropdown-item dropdown-header">{{ $adminNotifications->count() }} إشعار</span>
    <div class="dropdown-divider"></div>

    @forelse($adminNotifications as $notification)
        <a href="{{ $notification->link ?: '#' }}" class="dropdown-item">
            <i class="fas fa-bell ml-2"></i> {{ $notification->title }}
            <span class="float-left text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
        </a>

        <div class="dropdown-divider"></div>
    @empty
        <span class="dropdown-item text-center">لا توجد إشعارات</span>
        <div class="dropdown-divider"></div>
    @endforelse

    <a href="{{ route('admin.notifications') }}" class="dropdown-item dropdown-footer">عرض كل الإشعارات</a>
</div>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('cms/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">بوابة التدريب الميداني</span>
        </a>

        <div class="sidebar">
<div class="user-panel mt-3 pb-3 mb-3 d-flex">

    @php
        $adminImage = $adminUser?->admin?->images?->first();
    @endphp

    <div class="image">
        <a href="{{ route('admin.admin.profile') }}">
            <img
                src="{{ $adminImage ? asset('storage/' . $adminImage->path) : asset('cms/dist/img/user2-160x160.jpg') }}"
                class="img-circle elevation-2"
                alt="User Image"
            >
        </a>
    </div>

    <div class="info">
        <a href="{{ route('admin.admin.profile') }}" class="d-block">
            {{ $adminUser?->admin?->name ?? 'مدير النظام' }}
        </a>
    </div>

</div>

            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="ابحث" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="nav-icon fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column admin-sidebar-menu" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item has-treeview {{ request()->routeIs('admin.dashboard*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                لوحة التحكم
                                <i class="left fas fa-angle-down"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview" style="{{ request()->routeIs('admin.dashboard*') ? 'display:block;' : 'display:none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>الرئيسية</p>
                                </a>
                            </li>

                            {{-- <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>الإحصائيات</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>آخر الأنشطة</p>
                                </a>
                            </li> --}}
                        </ul>
                    </li>

                   <li class="nav-header">ادارة المستخدمين

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                الادمن
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.admins.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسة</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.admins.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>اضافة أدمن</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                المشرف
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.supervisors.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسية</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.supervisors.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>اضافة مشرف</p>
                </a>
              </li>

            </ul>

          </li>
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                الشركة
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.companies.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسية</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.companies.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>اضافة شركة</p>
                </a>
              </li>

            </ul>

          </li>
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                الطلاب
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.students.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسية</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.students.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>اضافة طالب</p>
                </a>
              </li>

            </ul>

          </li>
          </li>

                    <li class="nav-header">إدارة التدريب</li>

                    <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                الفرص
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.opportunities.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسة</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.opportunities.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>اضافة قرصة</p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                التدريب
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.internships.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسة</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.internships.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>اضافة تدريب</p>
                </a>
              </li>

            </ul>
          </li>



                    <li class="nav-item">
                        <a href="{{ route('admin.cms.admin.report') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>التقارير</p>
                        </a>
                    </li>

                 <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                الشهادات
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.admin.certificates.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسة</p>
                </a>
              </li>


            </ul>
          </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.notifications') }}" class="nav-link {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>الإشعارات</p>
                        </a>
                    </li>

  <li class="nav-header">ادارة المحتوى

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                القسم
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.colleges.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسة</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.colleges.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>انشاء قسم</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                التخصص
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.specializations.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسية</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.specializations.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>انشاء تخصص</p>
                </a>
              </li>

            </ul>

          </li>
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                الدولة
                <i class="nav-icon fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.cities.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>الرئيسية</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.cities.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>انشاء دولة</p>
                </a>
              </li>

            </ul>

          </li>
          </li>

                    <li class="nav-header">الإعدادات</li>
<li class="nav-item">
                        <a href="{{ route('cms.supervisor.profile') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-edit"></i>
                            <p>تعديل الملف الشخصي</p>
                        </a>
                    </li>

                    <li class="nav-item">
    <a href="{{ route('admin.password.edit') }}" class="nav-link {{ request()->routeIs('admin.password.edit') ? 'active' : '' }}">
        <i class="nav-icon fas fa-lock"></i>
        <p>تغيير كلمة المرور</p>
    </a>
</li>

                    <li class="nav-item">
                        <a href="{{ route('front.home.front.home.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>تسجيل الخروج</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('main-title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">@yield('main-title')</a>
                            </li>
                            <li class="breadcrumb-item active">@yield('sub-title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>
            &copy; {{ now()->year }} - بوابة التدريب الميداني | {{ env('APP_NAME') }}
        </strong>
        <div class="float-left d-none d-sm-inline-block">
            <b>الإصدار</b> {{ env('APP_VERSION') }}
        </div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('cms/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('cms/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('cms/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('cms/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('cms/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('cms/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('cms/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('cms/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('cms/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('cms/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('cms/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('cms/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('crud.js') }}"></script>


@yield('scripts')
</body>
</html>

