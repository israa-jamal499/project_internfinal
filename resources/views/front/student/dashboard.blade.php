@extends('front.layout.student')

@section('title', 'dashboard')

@section('content')
<main class="student-page dashboard-page">

    <!-- Page Header -->
    <section class="page-title-box">
        <h2>مرحبًا، {{ $student->full_name ?? 'الطالبة' }} 👋</h2>
        <p>
            هذه لوحة الطالب الخاصة بك، ومنها يمكنك متابعة حالة التدريب، الساعات المعتمدة،
            التقارير الأسبوعية، والإشعارات الأخيرة بشكل سريع وواضح.
        </p>
    </section>

    <!-- Hero Summary -->
    <section class="dashboard-hero white-card">
        <div class="dashboard-hero-content">
            <div class="hero-text">
              <span class="hero-badge badge {{ $internship ? 'badge-success' : 'badge-secondary' }}">
    {{ $internship?->status ?? 'لا يوجد تدريب' }}
</span>
                <h3>أنتِ الآن في مرحلة التدريب الميداني</h3>
                <p>
                    تابعي ساعات التدريب، ارفعي التقارير الأسبوعية، وراجعي آخر الملاحظات
                    من المشرف والشركة حتى تكملي متطلبات التدريب بنجاح.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('front.student.internship') }}" class="btn btn-primary">🏢 ملف التدريب</a>
                    <a href="{{ route('front.student.weekly-reports') }}" class="btn btn-light">📝 رفع تقرير</a>
                </div>
            </div>

            <div class="hero-progress-card">
                <h4>نسبة الإنجاز</h4>
                <div class="progress-circle" style="background: conic-gradient(#3e7cd7 0% {{ $progressPercent }}%, #dce9ff {{ $progressPercent }}% 100%);">
                    <div class="progress-circle-inner">
                    <strong>{{ $progressPercent }}%</strong>
                        <span>مكتمل</span>
                    </div>
                </div>
                <p>تم اعتماد {{ $approvedHours }} ساعة من أصل {{ $requiredHours }} ساعة مطلوبة</p>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="dashboard-stats">
        <article class="stat-card white-card">
            <div class="stat-icon">📌</div>
            <div class="stat-info">
                <h3>طلبات التقديم</h3>
               <strong>{{ $applicationsCount }}</strong>
<span>بينها {{ $acceptedApplicationsCount }} مقبول</span>
            </div>
        </article>

        <article class="stat-card white-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-info">
                <h3>الساعات المعتمدة</h3>
                <strong>{{ $approvedHours }}</strong>
<span>المتبقي {{ $remainingHours }} ساعة</span>
            </div>
        </article>

        <article class="stat-card white-card">
            <div class="stat-icon">📝</div>
            <div class="stat-info">
                <h3>التقارير</h3>
                <strong>{{ $reportsCount }}</strong>
<span>آخر تقرير {{ $latestReportStatus }}</span>
            </div>
        </article>

        <article class="stat-card white-card">
            <div class="stat-icon">🔔</div>
            <div class="stat-info">
                <h3>الإشعارات الجديدة</h3>
                <strong>{{ $newNotificationsCount }}</strong>
<span>آخر تحديث {{ $notifications->first()?->created_at?->diffForHumans() ?? 'لا يوجد' }}</span>
            </div>
        </article>
    </section>

    <!-- Main Grid -->
    <section class="dashboard-grid">

        <!-- Left -->
        <div class="dashboard-main-column">

            <!-- Current Internship -->
            <article class="dashboard-card white-card">
                <div class="card-head">
                    <h3>🏢 بيانات التدريب الحالي</h3>
                    <a href="{{ route('front.student.internship') }}">عرض التفاصيل</a>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                       <strong>{{ $internship->company->name ?? '-' }}</strong>
                        <strong>شركة التقنية الحديثة</strong>
                    </div>

                    <div class="info-item">
                        <span class="label">المشرف الأكاديمي</span>
                       <strong>{{ $internship->supervisor->full_name ?? 'لم يتم تعيين مشرف بعد' }}</strong>
                    </div>

                    <div class="info-item">
                        <span class="label">المشرف الميداني</span>
                       <strong>{{ $internship->company->name ?? '-' }}</strong>
                    </div>

                    <div class="info-item">
                        <span class="label">حالة التدريب</span>
                       <strong class="text-success">{{ $internship->status ?? '-' }}</strong>
                    </div>

                    <div class="info-item">
                        <span class="label">تاريخ البداية</span>
                        <strong>{{ $internship->start_date ?? '-' }}</strong>
                    </div>

                    <div class="info-item">
                        <span class="label">تاريخ النهاية</span>
                       <strong>{{ $internship->end_date ?? '-' }}</strong>
                    </div>
                </div>
            </article>

<!-- Hours Progress -->
            <article class="dashboard-card white-card">
                <div class="card-head">
                    <h3>⏳ تقدم ساعات التدريب</h3>
                    <a href="{{ route('front.student.hours') }}">إدارة الساعات</a>
                </div>

                <div class="hours-summary">
                    <div class="hours-box">
                        <span>الساعات المطلوبة</span>
                       <strong>{{ $requiredHours }}</strong>
                    </div>
                    <div class="hours-box">
                        <span>الساعات المعتمدة</span>
                       <strong>{{ $approvedHours }}</strong>
                    </div>
                    <div class="hours-box">
                        <span>الساعات المتبقية</span>
                       <strong>{{ $remainingHours }}</strong>
                    </div>
                </div>

                <div class="progress-block">
                    <div class="progress-labels">
                        <span>نسبة الإنجاز</span>
                        <strong>{{ $progressPercent }}%</strong>
                    </div>
                    <div class="progress-bar">
                       <div class="progress-fill" style="width: {{ $progressPercent }}%;"></div>
                    </div>
                </div>
            </article>
              <!-- Certificate Status -->
            <article class="dashboard-card white-card">
                <div class="certificate-status-card">
    @if($internship && $internship->certificate && $internship->certificate->is_issued)
        <span class="badge badge-success">متاحة الآن</span>
        <p>تم إصدار شهادة التدريب الخاصة بك ويمكنك عرضها الآن.</p>
    @else
        <span class="badge badge-info">غير متاحة حاليًا</span>
        <p>
            ستتوفر الشهادة بعد إكمال جميع الساعات المطلوبة واعتماد التدريب
            بشكل نهائي من المشرف والكلية.
        </p>
    @endif
</div>
            </article>

            <!-- Latest Reports -->
            <article class="dashboard-card white-card">
                <div class="card-head">
                    <h3>📝 آخر التقارير</h3>
                    <a href="{{ route('front.student.weekly-reports') }}">عرض الكل</a>
                </div>

                <div class="simple-table-wrap">
                    <table class="clean-table">
                        <thead>
                            <tr>
                                <th>الأسبوع</th>
                                <th>عنوان التقرير</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                      <tbody>
    @forelse($latestReports as $report)
        <tr>
            <td>الأسبوع {{ $report->week_number }}</td>
            <td>{{ \Illuminate\Support\Str::limit($report->tasks_completed ?? $report->learnings ?? 'بدون عنوان', 35) }}</td>
            <td>{{ $report->created_at->format('Y-m-d') }}</td>
            <td>
                @if($report->status == 'تمت المراجعة')
                    <span class="badge badge-success">مقبول</span>
                @elseif($report->status == 'مرفوض')
                    <span class="badge badge-danger">مرفوض</span>
                @else
                    <span class="badge badge-warning">قيد المراجعة</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">لا توجد تقارير حتى الآن</td>
        </tr>
    @endforelse
</tbody>
                    </table>
                </div>
            </article>
        </div>

        <!-- Right -->
        <aside class="dashboard-side-column">

            <!-- Quick Actions -->
            <article class="dashboard-card white-card">
                <div class="card-head no-link">
                    <h3>⚡ إجراءات سريعة</h3>
                </div>

                <div class="quick-actions">
                    <a href="{{ route('front.student.applications') }}" class="quick-action">
                        <span class="quick-icon">📌</span>
                        <div>
                            <strong>طلباتي</strong>
                            <small>متابعة حالة الطلبات</small>
                        </div>
                    </a>

                    <a href="{{ route('front.student.weekly-reports') }}" class="quick-action">
                        <span class="quick-icon">📝</span>
                        <div>
                            <strong>رفع تقرير</strong>
                            <small>إضافة تقرير أسبوعي جديد</small>
                        </div>
                    </a>

                    <a href="{{ route('front.student.hours') }}" class="quick-action">
                        <span class="quick-icon">⏳</span>
                        <div>
                            <strong>ساعاتي</strong>
                            <small>إرسال طلب اعتماد ساعات</small>
                        </div>
                <a href="{{ route('front.student.messages') }}" class="quick-action">
    <span class="quick-icon">💬</span>
    <div>
        <strong>الرسائل</strong>
        <small>التواصل مع المشرف أو الشركة</small>
    </div>
</a>
                </div>
            </article>

            <!-- Supervisor Card -->
            <article class="dashboard-card white-card">
                <div class="card-head no-link">
                    <h3>👨‍🏫 بيانات المشرف</h3>
                </div>

                <div class="person-card">
                    <div class="person-avatar">أ</div>
                    <div class="person-info">
                        <strong>{{ $internship->supervisor->full_name ?? 'لم يتم تعيين مشرف بعد' }}</strong>
<span>المشرف الأكاديمي</span>
                    </div>
                </div>

                <ul class="details-list">
                    <li><span>البريد الإلكتروني</span><strong>{{ $internship->supervisor->user->email ?? '-' }}</strong></li>
<li><span>رقم التواصل</span><strong>{{ $internship->supervisor->phone ?? '-' }}</strong></li>
<li><span>القسم</span><strong>{{ $student->specialization->name ?? '-' }}</strong></li>
                </ul>
            </article>

            <!-- Latest Notifications -->
            <article class="dashboard-card white-card">
                <div class="card-head">
                    <h3>🔔 آخر الإشعارات</h3>
                    <a href="{{ route('front.student.notifications') }}">عرض الكل</a>
                </div>

             <div class="mini-notifications">
    @forelse($notifications as $notification)
        <div class="mini-notification">
            <span class="mini-dot blue"></span>
            <div>
                <strong>{{ $notification->title }}</strong>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @empty
        <div class="mini-notification">
            <div>
                <strong>لا توجد إشعارات حديثة</strong>
                <small>-</small>
            </div>
        </div>
    @endforelse
</div>
            </article>


        </aside>

    </section>
</main>
@endsection

@section('css')
<style>
/* =========================
   Dashboard Page
========================= */
.dashboard-page {
    padding-bottom: 10px;
}
.dashboard-card {
  margin-bottom: 20px;
}
.dashboard-hero {
    padding: 28px;
    margin-bottom: 18px;
    border-radius: 24px;
}
.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}
.progress-circle {
  box-shadow: inset 0 0 20px rgba(0,0,0,0.05);
}
.dashboard-hero-content {
    display: grid;
    grid-template-columns: 1.5fr 340px;
    gap: 20px;
    align-items: center;
}

.hero-badge {
    margin-bottom: 14px;
}

.hero-text h3 {
    margin: 0 0 10px;
    font-size: 30px;
    font-weight: 900;
    color: #122033;
}

.hero-text p {
    margin: 0;
    color: #64748b;
    line-height: 1.9;
    font-size: 15px;
    max-width: 720px;
}

.hero-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 18px;
}

.hero-progress-card {
    background: linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
    border: 1px solid #dce9ff;
    border-radius: 22px;
    padding: 22px;
    text-align: center;
}

.hero-progress-card h4 {
    margin: 0 0 16px;
    font-size: 18px;
    font-weight: 900;
    color: #17324f;
}

.hero-progress-card p {
    margin: 14px 0 0;
    color: #5f7187;
    font-size: 14px;
    line-height: 1.8;
}

.progress-circle {
    width: 170px;
    height: 170px;
    margin: auto;
    border-radius: 50%;
    background:
        conic-gradient(#3e7cd7 0% 68%, #dce9ff 68% 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.progress-circle-inner {
    width: 124px;
    height: 124px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.progress-circle-inner strong {
    font-size: 28px;
    color: #17324f;
    font-weight: 900;
}

.progress-circle-inner span {
    font-size: 13px;
    color: #64748b;
}

.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 18px;
}

.stat-card {
    padding: 20px;
    border-radius: 22px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: #eef4ff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.stat-info h3 {
    margin: 0 0 6px;
    font-size: 14px;
    color: #64748b;
    font-weight: 800;
}

.stat-info strong {
    display: block;
    font-size: 28px;
    line-height: 1;
    color: #122033;
    margin-bottom: 6px;
}

.stat-info span {
    font-size: 13px;
    color: #64748b;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 18px;
    align-items: start;
}

.dashboard-main-column,
.dashboard-side-column {
    display: grid;
    gap: 18px;
}

.dashboard-card {
    padding: 22px;
    border-radius: 22px;
}

.card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 18px;
}

.card-head h3 {
    margin: 0;
    font-size: 19px;
    font-weight: 900;
    color: #122033;
}

.card-head a {
    text-decoration: none;
    color: #3e7cd7;
    font-size: 13px;
    font-weight: 800;
}

.card-head.no-link {
    margin-bottom: 16px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}

.info-item {
    background: #f8fbff;
    border: 1px solid #e6eef8;
    border-radius: 18px;
    padding: 16px;
}

.info-item .label {
    display: block;
    color: #64748b;
    font-size: 13px;
    margin-bottom: 8px;
}

.info-item strong {
    color: #122033;
    font-size: 15px;
    font-weight: 900;
}

.text-success {
    color: #178a46 !important;
}

.hours-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 18px;
}

.hours-box {
    background: #f8fbff;
    border: 1px solid #e6eef8;
    border-radius: 18px;
    padding: 16px;
    text-align: center;
}

.hours-box span {
    display: block;
    color: #64748b;
    font-size: 13px;
    margin-bottom: 10px;
}

.hours-box strong {
    font-size: 28px;
    color: #122033;
    font-weight: 900;
}

.progress-block {
    margin-top: 8px;
}

.progress-labels {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}

.progress-labels span {
    color: #64748b;
    font-size: 14px;
}

.progress-labels strong {
    color: #122033;
    font-size: 14px;
    font-weight: 900;
}

.progress-bar {
    width: 100%;
    height: 12px;
    background: #eaf1fb;
    border-radius: 999px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(90deg, #3e7cd7, #6ea0ee);
}

.simple-table-wrap {
    overflow-x: auto;
}

.quick-actions {
    display: grid;
    gap: 12px;
}

.quick-action {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    padding: 14px;
    border-radius: 18px;
    background: #f8fbff;
    border: 1px solid #e6eef8;
    transition: 0.2s ease;
}

.quick-action:hover {
    transform: translateY(-2px);
    background: #f1f7ff;
}

.quick-icon {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: #e9f1ff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.quick-action strong {
    display: block;
    color: #122033;
    font-size: 14px;
    margin-bottom: 4px;
}

.quick-action small {
    color: #64748b;
    font-size: 12px;
}

.person-card {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.person-avatar {
    width: 58px;
    height: 58px;
    border-radius: 18px;
    background: linear-gradient(135deg, #3e7cd7, #6ea0ee);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 900;
}

.person-info strong {
    display: block;
    color: #122033;
    font-size: 16px;
    margin-bottom: 4px;
}

.person-info span {
    color: #64748b;
    font-size: 13px;
}

.details-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: grid;
    gap: 12px;
}

.details-list li {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #eef2f7;
}

.details-list li:last-child {
    border-bottom: none;
}

.details-list li span {
    color: #64748b;
    font-size: 13px;
}

.details-list li strong {
    color: #122033;
    font-size: 13px;
    text-align: left;
}

.mini-notifications {
    display: grid;
    gap: 14px;
}

.mini-notification {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eef2f7;
}

.mini-notification:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.mini-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-top: 6px;
    flex-shrink: 0;
}

.mini-dot.blue { background: #3e7cd7; }
.mini-dot.green { background: #14a44d; }
.mini-dot.orange { background: #f59e0b; }

.mini-notification strong {
    display: block;
    color: #122033;
    font-size: 14px;
    margin-bottom: 4px;
}

.mini-notification small {
    color: #64748b;
    font-size: 12px;
}

.certificate-status-card {
    background: #f8fbff;
    border: 1px solid #e6eef8;
    border-radius: 18px;
    padding: 16px;
}

.certificate-status-card p {
    margin: 12px 0 0;
    color: #64748b;
    line-height: 1.9;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 1100px) {
    .dashboard-hero-content,
    .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .dashboard-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .hero-text h3 {
        font-size: 24px;
    }

    .dashboard-stats,
    .info-grid,
    .hours-summary {
        grid-template-columns: 1fr;
    }

    .dashboard-card,
    .dashboard-hero {
        padding: 18px;
    }

    .card-head {
        align-items: flex-start;
        flex-direction: column;
    }

    .progress-circle {
        width: 150px;
        height: 150px;
    }

    .progress-circle-inner {
        width: 110px;
        height: 110px;
    }
}
.clean-table td {
  padding: 12px;
}
.mini-notification:hover {
  background: #f8fbff;
  border-radius: 10px;
}
.student-page {
  min-height: auto;
}
</style>
@endsection
