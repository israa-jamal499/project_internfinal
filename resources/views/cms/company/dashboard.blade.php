@extends('cms.company.temp')
@section('title','dashboard')
@section('main-title','الرئيسية')
@section('content')

  <style>
    /* =========================
      Student Top Navbar
    ========================= */

    body {
      margin: 0;
      font-family: Tahoma, Arial, sans-serif;
      background: #f7f9fb;
    }

    .company-topbar {
      width: 100%;
      background: #3e7cd7;
      padding: 10px 0;
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .topbar-container {
      width: 92%;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    /* =========================
      RIGHT side (Student Info) -> now LEFT
    ========================= */

    .topbar-left {
      display: flex;
      align-items: center;
      gap: 16px;
      position: relative;
    }

    /* Notification icon */
    .topbar-icon {
      font-size: 18px;
      color: #fff;
      cursor: pointer;
      position: relative;
    }

    .notif-badge {
      position: absolute;
      top: -6px;
      right: -10px;
      background: #ff4d4d;
      color: #fff;
      font-size: 11px;
      font-weight: bold;
      padding: 2px 6px;
      border-radius: 20px;
    }

    /* Student profile */
    .company-profile {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      background: #3e7cd7;
      padding: 6px 12px;
      border-radius: 10px;
      transition: 0.2s ease;
    }

    .scompany-profile:hover {
      background: #3e7cd7;
    }

    .company-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid rgba(255, 255, 255, 0.6);
    }

    .company-info {
      display: flex;
      flex-direction: column;
      line-height: 1.2;
    }

    .company-name {
      color: #fff;
      font-size: 14px;
      font-weight: 600;
    }

    .company-email {
      color: #cfe0e7;
      font-size: 12px;
    }

    .company-arrow {
      color: #fff;
      font-size: 14px;
      margin-right: 4px;
    }

    /* Dropdown */
    .company-dropdown {
      position: absolute;
      top: 62px;
       z-index: 9999;
      /* ✅ الآن لأنها باليسار */
      left: 0;
      right: auto;

      width: 210px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
      overflow: hidden;
      display: none;
    }

    .company-dropdown a {
      display: block;
      padding: 12px 14px;
      color: #3e7cd7;
      font-size: 14px;
      text-decoration: none;
      transition: 0.2s ease;
    }

    .company-dropdown a:hover {
      background: #f2f5f7;
    }

    .company-dropdown hr {
      margin: 0;
      border: none;
      border-top: 1px solid #eee;
    }

    .company-dropdown .logout {
      color: #d40000;
      font-weight: 600;
    }

    /* =========================
      LEFT side (Title) -> now RIGHT
    ========================= */

    .topbar-right .topbar-title h3 {
      margin: 0;
      color: #fff;
      font-size: 18px;
      font-weight: 700;
    }

    .topbar-right .topbar-title p {
      margin: 2px 0 0;
      color: #cfe0e7;
      font-size: 13px;
    }

    /* =========================
      Student Pages Nav Links
    ========================= */

    .company-pages-nav {
      width: 100%;
      background: #ffffff;
      border-bottom: 1px solid #e6edf1;
    }

    .company-pages-container {
      width: 92%;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 16px;
      padding: 10px 0;
      flex-wrap: wrap;
    }

    .company-pages-container a {
      text-decoration: none;
      color: #3e7cd7;
      font-size: 14px;
      font-weight: 600;
      padding: 8px 12px;
      border-radius: 10px;
      transition: 0.2s ease;
    }

    .company-pages-container a:hover {
      background: #eef3f6;
    }

    .company-pages-container a.active {
      background:#3e7cd7;
      color: #fff;
    }
    /* Notifications Wrapper */
.notif-wrapper {
  position: relative;
}

/* Notifications Dropdown */
.notif-dropdown {
  position: absolute;
  top: 62px;
  right: 0;
  width: 340px;
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 10px 35px rgba(0, 0, 0, 0.18);
  overflow: hidden;
  display: none;
  z-index: 9999;
}

/* Show */
.notif-dropdown.active {
  display: block;
}

/* Header */
.notif-header {
  padding: 14px 16px;
  border-bottom: 1px solid #eee;
}

.notif-header h4 {
  margin: 0;
  font-size: 16px;
  font-weight: 800;
  color: #222;
}

.notif-sub {
  display: block;
  margin-top: 4px;
  font-size: 12px;
  color: #777;
}

/* Body */
.notif-body {
  max-height: 300px;
  overflow-y: auto;
}

/* Notification item */
.notif-item {
  display: block;
  padding: 12px 16px;
  text-decoration: none;
  border-bottom: 1px solid #f2f2f2;
  transition: 0.2s;
}

.notif-item:hover {
  background: #f7f9fb;
}

.notif-title {
  display: block;
  font-weight: 700;
  color: #333;
  font-size: 14px;
}

.notif-desc {
  display: block;
  margin-top: 3px;
  font-size: 12px;
  color: #888;
}

/* Footer */
.notif-footer {
  padding: 12px 16px;
  text-align: center;
  background: #fafafa;
}

.notif-footer a {
  color: #0b72e7;
  font-weight: 700;
  text-decoration: none;
}
/* .main-footer {
  background: #3e7cd7;
  color: #fff;
  padding: 45px 0 15px;
  margin-top: 50px;
} */

.footer-container {
  width: 92%;
  margin: auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 25px;
}

.footer-col h3 {
  margin: 0 0 14px;
  font-size: 18px;
  font-weight: 800;
}

.footer-col p {
  margin: 0;
  font-size: 13px;
  line-height: 1.8;
  opacity: 0.95;
}

.footer-col ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-col ul li {
  margin-bottom: 10px;
  font-size: 14px;
}

.footer-col ul li a {
  color: #fff;
  text-decoration: none;
  font-size: 14px;
  transition: 0.2s ease;
}

.footer-col ul li a:hover {
  text-decoration: underline;
  opacity: 0.9;
}

.footer-bottom {
  border-top: 1px solid rgba(255, 255, 255, 0.25);
  margin-top: 25px;
  padding-top: 12px;
  text-align: center;
}

.footer-bottom p {
  margin: 0;
  font-size: 13px;
  opacity: 0.9;
}
/* =========================
   Dashboard Page
========================= */
.company-dashboard {
  width: 92%;
  margin: 25px auto 0;
}

/* Welcome */
.dash-welcome {
  background: #ffffff;
  border-radius: 18px;
  padding: 18px 18px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 15px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
  border: 1px solid #eef3f6;
}

.welcome-text h2 {
  margin: 0;
  font-size: 20px;
  color: #222;
  font-weight: 900;
}

.welcome-text p {
  margin: 8px 0 0;
  font-size: 13px;
  color: #666;
  line-height: 1.8;
  max-width: 520px;
}

.welcome-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.btn-primary {
  background: #3e7cd7;
  color: #fff;
  padding: 10px 14px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  transition: 0.2s;
}

.btn-primary:hover {
  opacity: 0.9;
}

.btn-outline {
  background: #fff;
  border: 1px solid #3e7cd7;
  color: #3e7cd7;
  padding: 10px 14px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  transition: 0.2s;
}

.btn-outline:hover {
  background: #f1f6ff;
}

/* Stats */
.dash-stats {
  margin-top: 18px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
  gap: 14px;
}

.stat-card {
  background: #fff;
  border-radius: 18px;
  padding: 16px 14px;
  display: flex;
  align-items: center;
  gap: 14px;
  border: 1px solid #eef3f6;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

.stat-icon {
  width: 52px;
  height: 52px;
  border-radius: 16px;
  background: #f1f6ff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
}

.stat-title {
  display: block;
  font-size: 13px;
  color: #666;
  font-weight: 700;
}

.stat-number {
  display: block;
  margin-top: 4px;
  font-size: 20px;
  color: #222;
  font-weight: 900;
}

/* Grid */
.dash-grid {
  margin-top: 18px;
  display: grid;
  grid-template-columns: 1.5fr 1fr;
  gap: 14px;
}

.dash-box {
  background: #fff;
  border-radius: 18px;
  padding: 16px;
  border: 1px solid #eef3f6;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

.dash-box-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
}

.dash-box-header h3 {
  margin: 0;
  font-size: 16px;
  font-weight: 900;
  color: #222;
}

.dash-link {
  text-decoration: none;
  color: #3e7cd7;
  font-size: 13px;
  font-weight: 800;
}

.table-wrap {
  overflow-x: auto;
}

.dash-table {
  width: 100%;
  border-collapse: collapse;
  min-width: 520px;
}

.dash-table th,
.dash-table td {
  text-align: right;
  padding: 12px 10px;
  font-size: 13px;
}

.dash-table thead th {
  background: #f7f9fb;
  color: #333;
  font-weight: 900;
  border-bottom: 1px solid #eee;
}

.dash-table tbody td {
  border-bottom: 1px solid #f2f2f2;
  color: #333;
}

.table-btn {
  background: #3e7cd7;
  color: #fff;
  text-decoration: none;
  padding: 7px 10px;
  border-radius: 10px;
  font-size: 12px;
  font-weight: 800;
  display: inline-block;
}

.table-btn:hover {
  opacity: 0.9;
}

/* Status */
.status {
  padding: 6px 10px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 800;
  display: inline-block;
}

.status.new {
  background: #fff3cd;
  color: #8a6d00;
}

.status.review {
  background: #e7f3ff;
  color: #0b72e7;
}

.status.accepted {
  background: #d4edda;
  color: #1e7e34;
}

.status.rejected {
  background: #f8d7da;
  color: #b02a37;
}

/* Quick Actions */
.quick-actions {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.quick-card {
  display: flex;
  gap: 12px;
  align-items: center;
  background: #f7f9fb;
  border: 1px solid #eef3f6;
  border-radius: 16px;
  padding: 12px;
  text-decoration: none;
  transition: 0.2s ease;
}

.quick-card:hover {
  background: #f1f6ff;
}

.quick-icon {
  width: 48px;
  height: 48px;
  border-radius: 16px;
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
}

.quick-info h4 {
  margin: 0;
  font-size: 14px;
  font-weight: 900;
  color: #222;
}

.quick-info p {
  margin: 5px 0 0;
  font-size: 12px;
  color: #666;
  line-height: 1.6;
}

/* Responsive */
@media (max-width: 950px) {
  .dash-grid {
    grid-template-columns: 1fr;
  }

  .dash-table {
    min-width: 600px;
  }

  .dash-welcome {
    flex-direction: column;
    align-items: flex-start;
  }
}

</style>
<!-- =========================
   Company Dashboard Content
========================= -->
<main class="company-dashboard">

  <!-- Welcome Section -->
  <section class="dash-welcome">
    <div class="welcome-text">
     <h2>مرحبًا {{ $company->name ?? 'الشركة' }} 👋</h2>
      <p>
        هنا يمكنك إدارة فرص التدريب، متابعة الطلبات، إدارة المتدربين،
        وإرسال التقييمات بكل سهولة.
      </p>
    </div>

    <div class="welcome-actions">
      <a href="{{ route('opportunities.create') }}" class="btn-primary">➕ إنشاء فرصة جديدة</a>
     <a href="{{ route('applications.index') }}" class="btn-outline">📌 عرض الطلبات</a>
    </div>
  </section>

  <!-- Stats Cards -->
  {{-- <section class="dash-stats">

    <div class="stat-card">
      <div class="stat-icon">📢</div>
      <div class="stat-info">
        <span class="stat-title">الفرص المنشورة</span>
        <span class="stat-number" id="statOpportunities">6</span>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon">📌</div>
      <div class="stat-info">
        <span class="stat-title">طلبات جديدة</span>
        <span class="stat-number" id="statNewApps">12</span>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon">🏢</div>
      <div class="stat-info">
        <span class="stat-title">متدربين حاليين</span>
        <span class="stat-number" id="statInterns">4</span>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon">⭐</div>
      <div class="stat-info">
        <span class="stat-title">تقييمات مكتملة</span>
        <span class="stat-number" id="statEvaluations">3</span>
      </div>
    </div>

  </section> --}}
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
               <h3>{{ $opportunitiesCount }}</h3>

                <p>الفرص المنشورة</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ route('opportunities.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h3>{{ $newApplicationsCount }}<sup style="font-size: 20px">%</sup></h3>

                <p>طلبات جديدة</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ route('applications.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $currentInternsCount }}</h3>

                <p>متدربين حاليين</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ route('cms.company.interns') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $completedEvaluationsCount }}</h3>

                <p>تقييمات مكتملة</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{ route('cms.company.evaluation') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

    </section>
  <!-- Dashboard Grid -->
  <section class="dash-grid">

    <!-- Latest Applications -->
    <div class="dash-box">
      <div class="dash-box-header">
        <h3>📌 آخر الطلبات</h3>
        <a href="{{ route('applications.index') }}" class="dash-link">عرض الكل</a>
      </div>

      <div class="table-wrap">
        <table class="dash-table">
          <thead>
            <tr>
              <th>اسم الطالب</th>
              <th>الفرصة</th>
              <th>الحالة</th>
              <th>الإجراء</th>
            </tr>
          </thead>

        <tbody id="appsTable">
    @forelse($latestApplications as $application)
        <tr>
            <td>{{ $application->student->full_name ?? '-' }}</td>
            <td>{{ $application->opportunity->title ?? '-' }}</td>
            <td>
                @if($application->status == 'قيد المراجعة')
                    <span class="status review">قيد المراجعة</span>
                @elseif($application->status == 'مقبول')
                    <span class="status accepted">مقبول</span>
                @elseif($application->status == 'مرفوض')
                    <span class="status rejected">مرفوض</span>
                @else
                    <span class="status new">{{ $application->status }}</span>
                @endif
            </td>
            <td>
                <a class="table-btn" href="{{ route('applications.show', $application->id) }}">عرض</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align:center;">لا توجد طلبات حتى الآن</td>
        </tr>
    @endforelse
</tbody>
        </table>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="dash-box">
      <div class="dash-box-header">
        <h3>⚡ إجراءات سريعة</h3>
      </div>

      <div class="quick-actions">

        <a href="{{ route('opportunities.create') }}" class="quick-card">
          <div class="quick-icon">➕</div>
          <div class="quick-info">
            <h4>إنشاء فرصة</h4>
            <p>إضافة فرصة تدريب جديدة للطلاب</p>
          </div>
        </a>

        <a href="{{ route('opportunities.index') }}" class="quick-card">
          <div class="quick-icon">📢</div>
          <div class="quick-info">
            <h4>إدارة الفرص</h4>
            <p>تعديل أو حذف الفرص المنشورة</p>
          </div>
        </a>

        <a href="{{ route('cms.company.interns') }}" class="quick-card">
          <div class="quick-icon">🏢</div>
          <div class="quick-info">
            <h4>المتدربين</h4>
            <p>عرض الطلاب المقبولين ومتابعتهم</p>
          </div>
        </a>

        <a href="{{ route('cms.company.evaluation') }}" class="quick-card">
          <div class="quick-icon">⭐</div>
          <div class="quick-info">
            <h4>التقييم</h4>
            <p>تقييم أداء الطلاب وإرسال النتيجة</p>
          </div>
        </a>

      </div>
    </div>

  </section>

</main>


@endsection
