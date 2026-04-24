@extends('cms.supervisor.temp')
@section('title','hours')
@section('main-title','اعتماد الساعات')

@section('css')
<style>
.sup-wrap{
  display:grid;
  gap:20px;
}
.sup-head{
  background:#fff;
  border-radius:22px;
  padding:28px;
}
.sup-head h2{
  margin:0 0 8px;
}
.sup-head p{
  margin:0;
  color:#6b7280;
}
.stats-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:14px;
}
.stat-card{
  background:#fff;
  border-radius:18px;
  padding:18px;
  text-align:center;
}
.stat-card span{
  display:block;
  color:#64748b;
  font-size:13px;
  margin-bottom:8px;
}
.stat-card strong{
  font-size:28px;
  color:#122033;
  font-weight:900;
}
.sup-card{
  background:#fff;
  border-radius:22px;
  padding:18px;
}
.filters-row{
  display:grid;
  grid-template-columns:1fr 220px;
  gap:14px;
  margin-bottom:18px;
}
.filters-row input,
.filters-row select{
  width:100%;
  border:1px solid #d9e2ec;
  border-radius:16px;
  padding:14px;
  outline:none;
}
.table-responsive{
  overflow:auto;
}
.sup-table{
  width:100%;
  border-collapse:collapse;
}
.sup-table th,
.sup-table td{
  padding:16px 12px;
  border-bottom:1px solid #eef2f7;
  text-align:center;
}
.badge{
  padding:8px 14px;
  border-radius:999px;
  font-size:13px;
  font-weight:700;
  display:inline-block;
}
.badge-warning{
  background:#fef3c7;
  color:#a16207;
}
.badge-success{
  background:#dcfce7;
  color:#15803d;
}
.badge-danger{
  background:#fee2e2;
  color:#b91c1c;
}
.btn-view{
  border:none;
  border-radius:14px;
  padding:10px 16px;
  cursor:pointer;
  font-weight:700;
  background:#e5eefc;
  color:#2563eb;
  text-decoration:none;
  display:inline-block;
}
@media (max-width:900px){
  .stats-grid{
    grid-template-columns:repeat(2,1fr);
  }
}
@media (max-width:700px){
  .filters-row,
  .stats-grid{
    grid-template-columns:1fr;
  }
}
</style>
@endsection

@section('content')
<main class="sup-wrap">

  <section class="sup-head">
    <h2>⏳ اعتماد ساعات التدريب</h2>
    <p>هنا يمكن للمشرف مراجعة سجلات الساعات واعتمادها أو رفضها.</p>
  </section>

  <section class="stats-grid">
    <article class="stat-card">
      <span>إجمالي السجلات</span>
      <strong>{{ $totalLogs }}</strong>
    </article>

    <article class="stat-card">
      <span>معتمد</span>
      <strong>{{ $approvedLogs }}</strong>
    </article>

    <article class="stat-card">
      <span>معلق</span>
      <strong>{{ $pendingLogs }}</strong>
    </article>

    <article class="stat-card">
      <span>مرفوض</span>
      <strong>{{ $rejectedLogs }}</strong>
    </article>
  </section>

  <section class="sup-card">
    <div class="filters-row">
      <input type="text" id="searchHour" placeholder="🔎 ابحث باسم الطالب أو الشركة..." />
      <select id="filterHourStatus">
        <option value="all">كل الحالات</option>
        <option value="pending">معلق</option>
        <option value="approved">معتمد</option>
        <option value="rejected">مرفوض</option>
      </select>
    </div>

    <div class="table-responsive">
      <table class="sup-table">
        <thead>
          <tr>
            <th>#</th>
            <th>الطالب</th>
            <th>الشركة</th>
            <th>التاريخ</th>
            <th>عدد الساعات</th>
            <th>الحالة</th>
            <th>إجراء</th>
          </tr>
        </thead>
        <tbody id="hoursTable">
          @forelse($hourLogs as $log)
            <tr data-student="{{ $log->internship->student->full_name ?? '-' }}" data-company="{{ $log->internship->company->name ?? '-' }}" data-status="{{ $log->status }}">
              <td>{{ $loop->iteration }}</td>
              <td>{{ $log->internship->student->full_name ?? '-' }}</td>
              <td>{{ $log->internship->company->name ?? '-' }}</td>
              <td>{{ $log->work_date ? $log->work_date->format('Y-m-d') : '-' }}</td>
              <td>{{ $log->hours }}</td>
              <td>
                @if($log->status == 'approved')
                  <span class="badge badge-success">معتمد</span>
                @elseif($log->status == 'pending')
                  <span class="badge badge-warning">معلق</span>
                @else
                  <span class="badge badge-danger">مرفوض</span>
                @endif
              </td>
              <td>
                <a href="{{ route('cms.supervisor.hours.show', $log->id) }}" class="btn-view">عرض</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7">لا توجد سجلات ساعات حالياً</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

</main>
@endsection

@section('js')
<script>
document.getElementById('searchHour').addEventListener('input', filterHours);
document.getElementById('filterHourStatus').addEventListener('change', filterHours);

function filterHours() {
    const search = document.getElementById('searchHour').value.trim().toLowerCase();
    const status = document.getElementById('filterHourStatus').value;
    const rows = document.querySelectorAll('#hoursTable tr');

    rows.forEach(row => {
        const student = row.getAttribute('data-student')?.toLowerCase() || '';
        const company = row.getAttribute('data-company')?.toLowerCase() || '';
        const rowStatus = row.getAttribute('data-status') || '';

        const matchSearch = student.includes(search) || company.includes(search);
        const matchStatus = status === 'all' || rowStatus === status;

        row.style.display = (matchSearch && matchStatus) ? '' : 'none';
    });
}
</script>
@endsection
