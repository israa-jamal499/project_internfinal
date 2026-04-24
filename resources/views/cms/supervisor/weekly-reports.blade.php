@extends('cms.supervisor.temp')
@section('title','reports')
@section('main-title','التقارير')
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
.filters-row select,
.feedback-box{
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
.btn-main,
.btn-soft,
.btn-view{
  border:none;
  border-radius:14px;
  padding:10px 16px;
  cursor:pointer;
  font-weight:700;
}
.btn-main{
  background:#2563eb;
  color:#fff;
}
.btn-soft{
  background:#fee2e2;
  color:#b91c1c;
}
.btn-view{
  background:#e5eefc;
  color:#2563eb;
}
.modal{
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.35);
  display:none;
  align-items:center;
  justify-content:center;
  z-index:9999;
}
.modal.active{
  display:flex;
}
.modal-box{
  width:min(760px, 92%);
  background:#fff;
  border-radius:22px;
  padding:20px;
  max-height:90vh;
  overflow:auto;
}
.modal-head{
  display:flex;
  align-items:center;
  justify-content:space-between;
  margin-bottom:14px;
}
.modal-close{
  border:none;
  background:transparent;
  font-size:20px;
  cursor:pointer;
}
.modal-body{
  display:grid;
  gap:12px;
}
.report-text{
  background:#f8fafc;
  border:1px solid #e2e8f0;
  border-radius:14px;
  padding:14px;
  line-height:1.9;
}
.modal-actions{
  display:flex;
  gap:10px;
  justify-content:flex-end;
  margin-top:18px;
}
.alert{
  padding:12px 14px;
  border-radius:12px;
  margin-bottom:14px;
}
.alert-success{
  background:#e7f8ee;
  color:#0a7a36;
  border:1px solid #c8f0d7;
}
.alert-danger{
  background:#ffe9e9;
  color:#b00000;
  border:1px solid #ffd0d0;
}
@media (max-width:700px){
  .filters-row{
    grid-template-columns:1fr;
  }
}
</style>
@endsection

@section('content')

<main class="sup-wrap">

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <section class="sup-head">
    <h2>📄 مراجعة التقارير الأسبوعية</h2>
    <p>هنا يمكن للمشرف قراءة التقارير واعتمادها أو رفضها.</p>
  </section>

  <section class="sup-card">

    <div class="filters-row">
      <input type="text" id="searchReport" placeholder="🔎 ابحث باسم الطالب..." />
      <select id="filterReportStatus">
        <option value="all">كل الحالات</option>
        <option value="قيد المراجعة">بانتظار المراجعة</option>
        <option value="تمت المراجعة">تمت المراجعة</option>
        <option value="مرفوض">مرفوض</option>
      </select>
    </div>

    <div class="table-responsive">
      <table class="sup-table">
        <thead>
          <tr>
            <th>#</th>
            <th>الطالب</th>
            <th>الأسبوع</th>
            <th>تاريخ الإرسال</th>
            <th>الحالة</th>
            <th>إجراء</th>
          </tr>
        </thead>
        <tbody id="reportsTable">
          @forelse($reports as $report)
            <tr data-student="{{ $report->internship->student->full_name ?? '-' }}" data-status="{{ $report->status }}">
              <td>{{ $loop->iteration }}</td>
              <td>{{ $report->internship->student->full_name ?? '-' }}</td>
              <td>الأسبوع {{ $report->week_number }}</td>
              <td>{{ $report->submitted_at ? $report->submitted_at->format('Y-m-d') : '-' }}</td>
              <td>
                @if($report->status == 'قيد المراجعة')
                  <span class="badge badge-warning">بانتظار المراجعة</span>
                @elseif($report->status == 'تمت المراجعة')
                  <span class="badge badge-success">تمت المراجعة</span>
                @else
                  <span class="badge badge-danger">مرفوض</span>
                @endif
              </td>
              <td>
                <a href="{{ route('cms.supervisor.weekly-reports.show', $report->id) }}" class="btn-view">عرض</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6">لا توجد تقارير حالياً</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </section>

</main>

<div class="modal" id="reportModal">
  <div class="modal-box">
    <div class="modal-head">
      <h3 id="reportTitle">عرض التقرير</h3>
      <button class="modal-close" id="closeReportModal">✖</button>
    </div>

    <div class="modal-body">
      <p><b>الطالب:</b> <span id="reportStudent"></span></p>
      <p><b>الأسبوع:</b> <span id="reportWeek"></span></p>
      <p><b>تاريخ الإرسال:</b> <span id="reportDate"></span></p>
      <p><b>عدد الساعات:</b> <span id="reportHours"></span></p>

      <p><b>المهام المنجزة:</b></p>
      <div class="report-text" id="reportTasksCompleted"></div>

      <p><b>ما تم تعلمه:</b></p>
      <div class="report-text" id="reportLearnings"></div>

      <p><b>التحديات:</b></p>
      <div class="report-text" id="reportChallenges"></div>

      <p><b>المهام المخطط لها:</b></p>
      <div class="report-text" id="reportTasksPlanned"></div>

      <div id="reportFileWrapper" style="display:none;">
        <p><b>الملف المرفق:</b></p>
        <a id="reportFileLink" href="#" target="_blank" class="btn-view">فتح الملف</a>
      </div>

      <div>
        <label><b>ملاحظات المشرف:</b></label>
        <textarea id="supervisor_feedback" class="feedback-box" rows="4" placeholder="اكتب ملاحظاتك هنا..."></textarea>
      </div>
    </div>

    <div class="modal-actions">
      <button class="btn-soft" id="btnReject">❌ رفض</button>
      <button class="btn-main" id="btnApprove">✅ اعتماد</button>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('searchReport').addEventListener('input', filterReports);
document.getElementById('filterReportStatus').addEventListener('change', filterReports);

function filterReports() {
    const search = document.getElementById('searchReport').value.trim().toLowerCase();
    const status = document.getElementById('filterReportStatus').value;
    const rows = document.querySelectorAll('#reportsTable tr');

    rows.forEach(row => {
        const student = row.getAttribute('data-student')?.toLowerCase() || '';
        const rowStatus = row.getAttribute('data-status') || '';

        const matchSearch = student.includes(search);
        const matchStatus = status === 'all' || rowStatus === status;

        row.style.display = (matchSearch && matchStatus) ? '' : 'none';
    });
}
</script>
@endsection
