
@extends('cms.admin.temp')
@section('title' ,'dashboard')
@section('main-title',' الرئيسية')
@section('css')
@endsection
@section('content')

<main class ="container" class="admin-main" dir="rtl">
  <div class="admin-container">

    <!-- Header -->
    <div class="dash-header">
      <div>

        <p class="dash-sub">ملخص سريع لأداء النظام اليوم</p>
      </div>

      <div class="dash-actions">
        <button class="btn btn-light" type="button" id="btnRefresh">تحديث</button>
        <a class="btn btn-primary" href="{{ route('opportunities.create') }}">+ إضافة فرصة</a>
      </div>
    </div>

    <!-- KPI Cards -->
    <section class="kpi-grid">
      <article class="kpi-card">
        <div class="kpi-icon">👩‍🎓</div>
        <div class="kpi-info">
          <p class="kpi-label">الطلاب</p>
          <h3 class="kpi-value" id="kpiStudents">{{ $studentsCount }}</h3>

          <p class="kpi-meta"><span class="up">▲ 6%</span> مقارنة بالأسبوع الماضي</p>
        </div>
      </article>

      <article class="kpi-card">
        <div class="kpi-icon">🏢</div>
        <div class="kpi-info">
          <p class="kpi-label">الشركات</p>
          <h3 class="kpi-value" id="kpiCompanies">{{ $companiesCount }}</h3>
          <p class="kpi-meta"><span class="up">▲ 3%</span> شركات جديدة هذا الشهر</p>
        </div>
      </article>

      <article class="kpi-card">
        <div class="kpi-icon">🧳</div>
        <div class="kpi-info">
          <p class="kpi-label">الفرص المنشورة</p>
          <h3 class="kpi-value" id="kpiOpps">{{ $opportunitiesCount }}</h3>
          <p class="kpi-meta"><span class="down">▼ 2%</span> فرص أقل من الأسبوع الماضي</p>
        </div>
      </article>

      <article class="kpi-card">
        <div class="kpi-icon">📝</div>
        <div class="kpi-info">
          <p class="kpi-label">طلبات جديدة</p>
          <h3 class="kpi-value" id="kpiNewApps">{{ $applicationsCount }}</h3>
          <p class="kpi-meta">آخر 24 ساعة</p>
        </div>
      </article>
    </section>

    <!-- Row: Chart + Quick Actions -->
    <section class="dash-grid-2">
      <div class="card">
        <div class="card-head">
          <h2 class="card-title">الطلبات خلال الأسبوع</h2>
          <span class="pill">آخر 7 أيام</span>
        </div>
        <div class="card-body">
          <canvas id="appsChart" height="110"></canvas>
          <div class="mini-legend">
            <span><i class="dot dot-a"></i> طلبات</span>
            <span><i class="dot dot-b"></i> فرص جديدة</span>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-head">
          <h2 class="card-title">روابط سريعة</h2>
          <span class="pill">إدارة</span>
        </div>

        <div class="card-body quick-actions">
          <a class="qa" href="{{ route('admin.students.index') }}">إدارة الطلاب</a>
          <a class="qa" href="{{ route('admin.companies.index') }}">إدارة الشركات</a>
          <a class="qa" href="{{ route('admin.opportunities.index') }}">إدارة الفرص</a>
          <a class="qa" href="{{ route('admin.internships.index') }}">ملفات التدريب</a>
          <a class="qa" href="{{ route('admin.cms.admin.report') }}">التقارير</a>
          <a class="qa" href="{{ route('admin.notifications') }}">الإشعارات</a>
        </div>
      </div>
    </section>

    <!-- Row: Latest Applications + Latest Opportunities -->
    <section class="dash-grid-2">
      <div class="card">
        <div class="card-head">
          <h2 class="card-title">أحدث الطلبات</h2>
          <a class="link" href="{{ route('admin.students.index') }}">عرض الكل</a>
        </div>

        <div class="card-body">
          <div class="table-wrap">
            <table class="dash-table">
              <thead>
                <tr>
                  <th>الطالب</th>
                  <th>الشركة</th>
                  <th>الفرصة</th>
                  <th>الحالة</th>
                  <th>التاريخ</th>
                </tr>
              </thead>
             <tbody>
@foreach($latestApplications as $app)
<tr>
    <td>{{ $app->student->full_name ?? '-' }}</td>
    <td>{{ $app->company->name ?? '-' }}</td>
    <td>{{ $app->opportunity->title ?? '-' }}</td>
    <td>
        @if($app->status == 'pending')
            <span class="badge pending">قيد المراجعة</span>
        @elseif($app->status == 'accepted')
            <span class="badge accepted">مقبول</span>
        @else
            <span class="badge rejected">مرفوض</span>
        @endif
    </td>
    <td>{{ $app->created_at->diffForHumans() }}</td>
</tr>
@endforeach
</tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-head">
          <h2 class="card-title">فرص جديدة</h2>
          <a class="link" href="{{ route('admin.opportunities.index') }}">عرض الكل</a>
        </div>

        <div class="card-body">
          <div class="op-list">
@foreach($latestOpportunities as $opp)
    <div class="op-item">
        <div>
            <h4>{{ $opp->title }}</h4>
            <p>{{ $opp->company->name ?? '-' }} • {{ $opp->type }}</p>
        </div>
        <span class="badge info">جديدة</span>
    </div>
@endforeach
</div>

          <div class="divider"></div>

          <h3 class="card-mini-title">إشعارات سريعة</h3>
          <ul class="notif-list">
@foreach($notifications as $noti)
    <li>{{ $noti->title }}</li>
@endforeach
</ul>
        </div>
      </div>
    </section>

  </div>
</main>




@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  const ctx = document.getElementById('appsChart');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['سبت','أحد','اثنين','ثلاثاء','أربعاء','خميس','جمعة'],
      datasets: [
        { label: 'طلبات', data: [8, 12, 10, 14, 20, 18, 22], tension: .35 },
        { label: 'فرص جديدة', data: [1, 2, 1, 3, 2, 4, 3], tension: .35 }
      ]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } }
      }
    }
  });

  document.getElementById('btnRefresh').addEventListener('click', () => {
    location.reload();
  });
</script>
@endsection


</body>
</html>
@endsection
