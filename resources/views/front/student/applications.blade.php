@extends('front.layout.student')
@section('title','applications')

@section('css')
<style>
/* =========================
  Student Top Navbar
========================= */

body {
  margin: 0;
  font-family: Tahoma, Arial, sans-serif;
  background: #f7f9fb;
}

.student-topbar {
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

.topbar-left {
  display: flex;
  align-items: center;
  gap: 16px;
  position: relative;
}

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

.student-profile {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  background: #3e7cd7;
  padding: 6px 12px;
  border-radius: 10px;
  transition: 0.2s ease;
}

.student-profile:hover {
  background: #3e7cd7;
}

.student-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid rgba(255, 255, 255, 0.6);
}

.student-info {
  display: flex;
  flex-direction: column;
  line-height: 1.2;
}

.student-name {
  color: #fff;
  font-size: 14px;
  font-weight: 600;
}

.student-id {
  color: #cfe0e7;
  font-size: 12px;
}

.student-arrow {
  color: #fff;
  font-size: 14px;
  margin-right: 4px;
}

.student-dropdown {
  position: absolute;
  top: 62px;
  z-index: 9999;
  left: 0;
  right: auto;
  width: 210px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
  overflow: hidden;
  display: none;
}

.student-dropdown a {
  display: block;
  padding: 12px 14px;
  color: #3e7cd7;
  font-size: 14px;
  text-decoration: none;
  transition: 0.2s ease;
}

.student-dropdown a:hover {
  background: #f2f5f7;
}

.student-dropdown hr {
  margin: 0;
  border: none;
  border-top: 1px solid #eee;
}

.student-dropdown .logout {
  color: #d40000;
  font-weight: 600;
}

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

.student-pages-nav {
  width: 100%;
  background: #ffffff;
  border-bottom: 1px solid #e6edf1;
}

.student-pages-container {
  width: 92%;
  margin: auto;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  gap: 16px;
  padding: 10px 0;
  flex-wrap: wrap;
}

.student-pages-container a {
  text-decoration: none;
  color: #3e7cd7;
  font-size: 14px;
  font-weight: 600;
  padding: 8px 12px;
  border-radius: 10px;
  transition: 0.2s ease;
}

.student-pages-container a:hover {
  background: #eef3f6;
}

.student-pages-container a.active {
  background:#3e7cd7;
  color: #fff;
}

.notif-wrapper {
  position: relative;
}

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

.notif-dropdown.active {
  display: block;
}

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

.notif-body {
  max-height: 300px;
  overflow-y: auto;
}

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

.main-footer {
  background: #3e7cd7;
  color: #fff;
  padding: 45px 0 15px;
  margin-top: 50px;
}

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

/* =========================
   Applications Page
========================= */

.page-container{
  width: 92%;
  margin: 25px auto 0;
}

.page-title{
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 18px;
}

.page-title h2{
  margin: 0;
  font-size: 20px;
  font-weight: 900;
  color: #1c2b4a;
}

.page-title p{
  margin: 6px 0 0;
  font-size: 13px;
  color: #6b7280;
}

.apps-actions{
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.apps-actions input,
.apps-actions select{
  padding: 10px 12px;
  border-radius: 12px;
  border: 1px solid #e3eaf2;
  outline: none;
  font-size: 13px;
  background: #fff;
  min-width: 240px;
}

.apps-actions select{
  min-width: 160px;
  cursor: pointer;
}

.apps-grid{
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 14px;
}

.app-card{
  background: #fff;
  border: 1px solid #e8eef4;
  border-radius: 18px;
  padding: 16px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.06);
  transition: 0.2s ease;
}

.app-card:hover{
  transform: translateY(-2px);
}

.app-head{
  display: flex;
  align-items: center;
  gap: 12px;
}

.app-logo{
  width: 55px;
  height: 55px;
  border-radius: 14px;
  object-fit: cover;
  border: 1px solid #e8eef4;
  background: #fff;
}

.app-title{
  flex: 1;
}

.app-title h3{
  margin: 0;
  font-size: 15px;
  font-weight: 900;
  color: #1c2b4a;
}

.app-title p{
  margin: 6px 0 0;
  font-size: 12px;
  color: #6b7280;
}

.status{
  font-size: 12px;
  font-weight: 900;
  padding: 7px 10px;
  border-radius: 999px;
  white-space: nowrap;
}

.status.pending{
  background: #fff6e5;
  color: #b45309;
}

.status.accepted{
  background: #eafff1;
  color: #047857;
}

.status.rejected{
  background: #ffe9e9;
  color: #b91c1c;
}

.app-body{
  margin-top: 12px;
}

.app-meta{
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  font-size: 13px;
  color: #334155;
}

.app-meta strong{
  font-weight: 900;
  color: #1c2b4a;
}

.app-note{
  margin-top: 12px;
  padding: 12px;
  border-radius: 14px;
  background: #f7f9fb;
  border: 1px solid #e8eef4;
  font-size: 13px;
  color: #334155;
  line-height: 1.8;
}

.accepted-note{
  background: #ecfff3;
  border-color: #c9f7d8;
}

.rejected-note{
  background: #fff1f1;
  border-color: #ffd0d0;
}

.app-actions{
  margin-top: 14px;
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.btn{
  border: none;
  padding: 10px 14px;
  border-radius: 12px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 900;
  text-decoration: none;
  transition: 0.2s ease;
  display: inline-block;
}

.btn-primary{
  background: #3e7cd7;
  color: #fff;
}

.btn-primary:hover{
  opacity: 0.92;
}

.btn-light{
  background: #f1f5f9;
  color: #1c2b4a;
}

.btn-light:hover{
  background: #e7edf6;
}

.btn-danger{
  background: #ffebeb;
  color: #b91c1c;
}

.btn-danger:hover{
  background: #ffd6d6;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin: 22px 0 24px;
}

.summary-card {
    background: #ffffff;
    border: 1px solid #e7edf5;
    border-radius: 20px;
    padding: 14px 14px;
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}

.summary-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.09);
    border-color: #d6e3f5;
}

.summary-card::before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 6px;
    height: 100%;
    background: #3e7cd7;
    border-radius: 20px 0 0 20px;
}

.sum-icon {
    border-radius: 14px;
    background: #eef4ff;
    color: #3e7cd7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    font-size: 16px;
}

.summary-card div {
    flex: 1;
    text-align: right;
}

.summary-card h3 {
    margin: 0;
    font-weight: 900;
    color: #1e293b;
    line-height: 1.1;
    font-size: 22px;
}

.summary-card p {
    margin: 8px 0 0;
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
}

.summary-card:nth-child(1)::before {
    background: #3e7cd7;
}

.summary-card:nth-child(2)::before {
    background: #f59e0b;
}

.summary-card:nth-child(3)::before {
    background: #10b981;
}

.summary-card:nth-child(4)::before {
    background: #ef4444;
}

.summary-card:nth-child(1) .sum-icon {
    background: #eef4ff;
    color: #3e7cd7;
}

.summary-card:nth-child(2) .sum-icon {
    background: #fff7e8;
    color: #d97706;
}

.summary-card:nth-child(3) .sum-icon {
    background: #ecfdf5;
    color: #059669;
}

.summary-card:nth-child(4) .sum-icon {
    background: #fef2f2;
    color: #dc2626;
}

.empty-state{
  text-align:center;
  padding:30px;
}

.alert {
  padding: 12px 14px;
  border-radius: 10px;
  margin-bottom: 16px;
}

.alert-success {
  background: #e7f8ee;
  color: #0a7a36;
  border: 1px solid #c8f0d7;
}

.alert-danger {
  background: #ffe9e9;
  color: #b00000;
  border: 1px solid #ffd0d0;
}

@media (max-width: 1100px){
  .summary-grid{
    grid-template-columns: repeat(2, 1fr);
  }
  .apps-grid{
    grid-template-columns: 1fr;
  }
}

@media (max-width: 520px){
  .apps-actions input{
    min-width: 100%;
  }
  .apps-actions select{
    min-width: 100%;
  }
  .app-meta{
    grid-template-columns: 1fr;
  }
}

@media (max-width: 600px) {
    .summary-grid {
        grid-template-columns: 1fr;
    }

    .summary-card {
        min-height: 95px;
        padding: 16px;
    }

    .summary-card h3 {
        font-size: 24px;
    }

    .summary-card p {
        font-size: 13px;
    }

    .sum-icon {
        width: 44px;
        height: 44px;
        font-size: 20px;
    }
}
</style>
@endsection

@section('content')
<main class="page-container">

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="page-title">
    <div>
      <h2>طلباتي</h2>
      <p>تابعي جميع طلبات التدريب التي قمتي بالتقديم عليها</p>
    </div>

    <div class="apps-actions">
      <input type="text" id="searchInput" placeholder="ابحث باسم الفرصة أو الشركة..." />
      <select id="statusFilter">
        <option value="all">كل الحالات</option>
        <option value="pending">قيد المراجعة</option>
        <option value="accepted">مقبول</option>
        <option value="rejected">مرفوض</option>
      </select>
    </div>
  </div>

  <section class="summary-grid">
    <div class="summary-card">
      <span class="sum-icon">📌</span>
      <div>
        <h3 id="totalApps">{{ $totalApplications }}</h3>
        <p>إجمالي الطلبات</p>
      </div>
    </div>

    <div class="summary-card">
      <span class="sum-icon">⏳</span>
      <div>
        <h3 id="pendingApps">{{ $pendingApplications }}</h3>
        <p>طلبات قيد المراجعة</p>
      </div>
    </div>

    <div class="summary-card">
      <span class="sum-icon">✅</span>
      <div>
        <h3 id="acceptedApps">{{ $acceptedApplications }}</h3>
        <p>طلبات مقبولة</p>
      </div>
    </div>

    <div class="summary-card">
      <span class="sum-icon">❌</span>
      <div>
        <h3 id="rejectedApps">{{ $rejectedApplications }}</h3>
        <p>طلبات مرفوضة</p>
      </div>
    </div>
  </section>

  <section class="apps-grid" id="appsGrid">
    @forelse($applications as $application)
      @php
        $statusClass = 'pending';
        $statusText = 'قيد المراجعة';

        if ($application->status == 'مقبول') {
            $statusClass = 'accepted';
            $statusText = 'مقبول';
        } elseif ($application->status == 'مرفوض') {
            $statusClass = 'rejected';
            $statusText = 'مرفوض';
        }
      @endphp

      <article class="app-card" data-status="{{ $statusClass }}">
        <div class="app-head">
          @if($application->opportunity && $application->opportunity->image)
            <img src="{{ asset('storage/' . $application->opportunity->image->path) }}" alt="Company" class="app-logo" />
          @else
            <img src="{{ asset('internship/img/webDev.jpeg') }}" alt="Company" class="app-logo" />
          @endif

          <div class="app-title">
            <h3>{{ $application->opportunity->title ?? '-' }}</h3>
            <p>{{ $application->opportunity->company->name ?? '-' }} - {{ $application->opportunity->city->name ?? '-' }}</p>
          </div>

          <span class="status {{ $statusClass }}">{{ $statusText }}</span>
        </div>

        <div class="app-body">
          <div class="app-meta">
            <span>📅 تاريخ التقديم: <strong>{{ $application->created_at->format('Y-m-d') }}</strong></span>
            <span>⏳ عدد الساعات: <strong>{{ $application->opportunity->required_hours ?? '-' }} ساعة</strong></span>
            <span>📍 المكان: <strong>{{ $application->opportunity->type ?? '-' }}</strong></span>
          </div>

          @if($application->status == 'قيد المراجعة')
            <div class="app-note">
              <strong>ملاحظة:</strong>
              {{ $application->admin_notes ?: 'تم استلام طلبك وسيتم التواصل معك بعد مراجعة الطلب.' }}
            </div>
          @elseif($application->status == 'مقبول')
            <div class="app-note accepted-note">
              🎉 تم قبولك مبدئيًا! يرجى متابعة صفحة <strong>Internship</strong> لاستكمال الإجراءات.
            </div>
          @else
            <div class="app-note rejected-note">
              {{ $application->admin_notes ?: 'للأسف لم يتم اختيارك لهذه الفرصة، يمكنك التقديم على فرص أخرى مناسبة.' }}
            </div>
          @endif
        </div>

        <div class="app-actions">
          <a class="btn btn-light" href="{{ route('front.home.opportunity-details', ['id' => $application->opportunity->id]) }}">
            عرض الفرصة
          </a>

          @if($application->status == 'قيد المراجعة')
            <form action="{{ route('front.student.applications.destroy', $application->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" onclick="return confirm('هل تريدين إلغاء الطلب؟')">إلغاء الطلب</button>
            </form>
          @endif

          @if($application->status == 'مقبول')
            <a class="btn btn-primary" href="{{ route('front.student.internship') }}">الانتقال لملف التدريب</a>
          @endif
        </div>
      </article>
    @empty
      <div class="empty-state" id="emptyState">
        <p>لم تقومي بالتقديم على أي فرصة بعد</p>
        <a href="{{ route('front.home.opportunities') }}" class="btn btn-primary">
          استعرضي الفرص الآن
        </a>
      </div>
    @endforelse
  </section>

  <div class="empty-state" id="emptyStateFiltered" style="display:none;">
    <p>لا توجد نتائج مطابقة</p>
    <a href="{{ route('front.home.opportunities') }}" class="btn btn-primary">
      استعرضي الفرص الآن
    </a>
  </div>

</main>
@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", () => {
  const notifBtn = document.getElementById("notifBtn");
  const notifDropdown = document.getElementById("notifDropdown");
  const studentMenuBtn = document.getElementById("studentMenuBtn");
  const studentDropdown = document.getElementById("studentDropdown");

  if (notifBtn && notifDropdown) {
    notifBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      if (studentDropdown) studentDropdown.style.display = "none";
      notifDropdown.classList.toggle("active");
    });
  }

  if (studentMenuBtn && studentDropdown) {
    studentMenuBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      if (notifDropdown) notifDropdown.classList.remove("active");
      studentDropdown.style.display =
        studentDropdown.style.display === "block" ? "none" : "block";
    });
  }

  document.addEventListener("click", () => {
    if (notifDropdown) notifDropdown.classList.remove("active");
    if (studentDropdown) studentDropdown.style.display = "none";
  });

  if (notifDropdown) {
    notifDropdown.addEventListener("click", (e) => e.stopPropagation());
  }

  if (studentDropdown) {
    studentDropdown.addEventListener("click", (e) => e.stopPropagation());
  }

  const links = document.querySelectorAll(".student-pages-container a");
  const currentPath = window.location.pathname;

  links.forEach(link => {
    if (link.getAttribute("href") === currentPath) {
      link.classList.add("active");
    }
  });

  const searchInput = document.getElementById("searchInput");
  const statusFilter = document.getElementById("statusFilter");
  const totalApps = document.getElementById("totalApps");
  const pendingApps = document.getElementById("pendingApps");
  const acceptedApps = document.getElementById("acceptedApps");
  const rejectedApps = document.getElementById("rejectedApps");
  const emptyStateFiltered = document.getElementById("emptyStateFiltered");

  function updateCounters() {
    const visibleCards = [...document.querySelectorAll(".app-card")]
      .filter(card => card.style.display !== "none");

    totalApps.textContent = visibleCards.length;
    pendingApps.textContent = visibleCards.filter(card => card.dataset.status === "pending").length;
    acceptedApps.textContent = visibleCards.filter(card => card.dataset.status === "accepted").length;
    rejectedApps.textContent = visibleCards.filter(card => card.dataset.status === "rejected").length;

    if (emptyStateFiltered) {
      emptyStateFiltered.style.display = visibleCards.length === 0 ? "block" : "none";
    }
  }

  function filterApplications() {
    const appCards = document.querySelectorAll(".app-card");
    const q = (searchInput?.value || "").trim().toLowerCase();
    const st = statusFilter?.value || "all";

    appCards.forEach(card => {
      const text = card.innerText.toLowerCase();
      const cardStatus = card.getAttribute("data-status");

      const matchSearch = text.includes(q);
      const matchStatus = st === "all" || st === cardStatus;

      card.style.display = (matchSearch && matchStatus) ? "block" : "none";
    });

    updateCounters();
  }

  if (searchInput) searchInput.addEventListener("input", filterApplications);
  if (statusFilter) statusFilter.addEventListener("change", filterApplications);

  filterApplications();
});
</script>
@endsection
