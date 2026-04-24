@extends('front.layout.student')
@section('title','internship')

@section('css')
<style>
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

.internship-card{
  background: #fff;
  border: 1px solid #e8eef4;
  border-radius: 18px;
  padding: 20px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.06);
  margin-bottom: 18px;
}

.info-grid{
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 14px;
  margin-top: 18px;
}

.info-box{
  background: #f8fbff;
  border: 1px solid #e8eef4;
  border-radius: 16px;
  padding: 14px;
}

.info-box h4{
  margin: 0 0 8px;
  font-size: 14px;
  color: #3e7cd7;
  font-weight: 900;
}

.info-box p{
  margin: 0;
  font-size: 14px;
  color: #1c2b4a;
  line-height: 1.8;
}

.status-badge{
  display: inline-block;
  padding: 8px 14px;
  border-radius: 999px;
  font-size: 13px;
  font-weight: 900;
}

.status-running{
  background: #eafff1;
  color: #047857;
}

.status-complete{
  background: #eaf4ff;
  color: #1d4ed8;
}

.status-stop{
  background: #fff1f1;
  color: #b91c1c;
}

.hours-box{
  margin-top: 18px;
  background: #fff;
  border: 1px solid #e8eef4;
  border-radius: 18px;
  padding: 18px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

.hours-header{
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}

.hours-header h3{
  margin: 0;
  font-size: 18px;
  color: #1c2b4a;
}

.progress-wrap{
  width: 100%;
  height: 14px;
  background: #edf2f7;
  border-radius: 999px;
  overflow: hidden;
  margin-top: 16px;
}

.progress-bar{
  height: 100%;
  background: #3e7cd7;
  border-radius: 999px;
}

.note-box{
  margin-top: 18px;
  background: #f8fbff;
  border: 1px solid #e8eef4;
  border-radius: 16px;
  padding: 14px;
}

.note-box h4{
  margin: 0 0 8px;
  font-size: 14px;
  color: #3e7cd7;
  font-weight: 900;
}

.note-box p{
  margin: 0;
  font-size: 14px;
  color: #334155;
  line-height: 1.8;
}

.empty-state{
  text-align:center;
  padding:40px 20px;
  background:#fff;
  border:1px solid #e8eef4;
  border-radius:18px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.06);
}

.empty-state p{
  margin: 0 0 16px;
  color:#64748b;
  font-size:14px;
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

.btn-light{
  background: #f1f5f9;
  color: #1c2b4a;
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

@media (max-width: 900px){
  .info-grid{
    grid-template-columns: 1fr;
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
      <h2>ملف التدريب</h2>
      <p>تابعي حالة تدريبك الحالي وبيانات الفرصة والساعات المطلوبة</p>
    </div>
  </div>

  @if($internship)
    @php
      $statusClass = 'status-running';
      $statusText = 'قيد التدريب';

      if ($internship->status == 'مكتمل') {
          $statusClass = 'status-complete';
          $statusText = 'مكتمل';
      } elseif ($internship->status == 'متوقف') {
          $statusClass = 'status-stop';
          $statusText = 'متوقف';
      }

      $requiredHours = $internship->required_hours ?? 0;
      $completedHours = $internship->completed_hours ?? 0;
      $progress = $requiredHours > 0 ? min(100, round(($completedHours / $requiredHours) * 100)) : 0;
    @endphp

    <section class="internship-card">
      <div class="hours-header">
        <h3>{{ $internship->opportunity->title ?? 'فرصة التدريب' }}</h3>
        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
      </div>

      <div class="info-grid">
        <div class="info-box">
          <h4>الشركة</h4>
          <p>{{ $internship->company->name ?? '-' }}</p>
        </div>

        <div class="info-box">
          <h4>المشرف</h4>
          <p>{{ $internship->supervisor->full_name ?? 'لم يتم تعيين مشرف بعد' }}</p>
        </div>

        <div class="info-box">
          <h4>تاريخ البداية</h4>
          <p>{{ $internship->start_date ?? '-' }}</p>
        </div>

        <div class="info-box">
          <h4>تاريخ النهاية</h4>
          <p>{{ $internship->end_date ?? 'غير محدد بعد' }}</p>
        </div>

        <div class="info-box">
          <h4>الحالة</h4>
          <p>{{ $internship->status }}</p>
        </div>

        <div class="info-box">
          <h4>الفرصة المرتبطة</h4>
          <p>{{ $internship->opportunity->title ?? '-' }}</p>
        </div>
      </div>
    </section>

    <section class="hours-box">
      <div class="hours-header">
        <h3>تقدّم الساعات</h3>
        <span>{{ $progress }}%</span>
      </div>

      <div class="progress-wrap">
        <div class="progress-bar" style="width: {{ $progress }}%;"></div>
      </div>

      <div class="info-grid" style="margin-top:18px;">
        <div class="info-box">
          <h4>الساعات المطلوبة</h4>
          <p>{{ $requiredHours }} ساعة</p>
        </div>

        <div class="info-box">
          <h4>الساعات المنجزة</h4>
          <p>{{ $completedHours }} ساعة</p>
        </div>

        <div class="info-box">
          <h4>إجمالي الساعات</h4>
          <p>{{ $internship->total_hours ?? 0 }} ساعة</p>
        </div>

        <div class="info-box">
          <h4>الساعات المتبقية</h4>
          <p>{{ max(0, $requiredHours - $completedHours) }} ساعة</p>
        </div>
      </div>

      <div class="note-box">
        <h4>ملاحظات التدريب</h4>
        <p>{{ $internship->notes ?: 'لا توجد ملاحظات حالياً' }}</p>
      </div>

      <div class="note-box">
        <h4>المهام</h4>
        <p>{{ $internship->tasks ?: 'لا توجد مهام مضافة حالياً' }}</p>
      </div>


    </section>
    <section class="hours-box">
    <div class="hours-header">
        <h3>تقييم المشرف</h3>
        @if($internship->supervisorEvaluation && $internship->supervisorEvaluation->is_final)
            <span class="status-badge status-complete">معتمد</span>
        @else
            <span class="status-badge status-stop">غير متوفر</span>
        @endif
    </div>

    @if($internship->supervisorEvaluation && $internship->supervisorEvaluation->is_final)
        <div class="info-grid" style="margin-top:18px;">
            <div class="info-box">
                <h4>التقييم العام</h4>
                <p>{{ $internship->supervisorEvaluation->overall_assessment }}</p>
            </div>

            <div class="info-box">
                <h4>الالتزام</h4>
                <p>{{ $internship->supervisorEvaluation->commitment }}/10</p>
            </div>

            <div class="info-box">
                <h4>المهارات</h4>
                <p>{{ $internship->supervisorEvaluation->skills }}/10</p>
            </div>

            <div class="info-box">
                <h4>التواصل</h4>
                <p>{{ $internship->supervisorEvaluation->communication }}/10</p>
            </div>
        </div>

        <div class="note-box">
            <h4>ملاحظات المشرف</h4>
            <p>{{ $internship->supervisorEvaluation->general_feedback ?: 'لا توجد ملاحظات حالياً' }}</p>
        </div>
    @else
        <div class="note-box">
            <h4>تقييم المشرف</h4>
            <p>لم يتم إضافة تقييم من المشرف بعد.</p>
        </div>
    @endif
</section>
<section class="hours-box">
    <div class="hours-header">
        <h3>تقييم الشركة</h3>
        @if($internship->companyEvaluation && $internship->companyEvaluation->is_final)
            <span class="status-badge status-complete">معتمد</span>
        @else
            <span class="status-badge status-stop">غير متوفر</span>
        @endif
    </div>

    @if($internship->companyEvaluation && $internship->companyEvaluation->is_final)
        <div class="info-grid" style="margin-top:18px;">
            <div class="info-box">
                <h4>التقييم العام</h4>
                <p>{{ $internship->companyEvaluation->overall_assessment }}/5</p>
            </div>

            <div class="info-box">
                <h4>المهارات التقنية</h4>
                <p>{{ $internship->companyEvaluation->technical_skills }}</p>
            </div>

            <div class="info-box">
                <h4>الالتزام والانضباط</h4>
                <p>{{ $internship->companyEvaluation->commitment_discipline }}</p>
            </div>

            <div class="info-box">
                <h4>التواصل والعمل الجماعي</h4>
                <p>{{ $internship->companyEvaluation->communication_teamwork }}</p>
            </div>
        </div>

        <div class="note-box">
            <h4>ملاحظات الشركة</h4>
            <p>{{ $internship->companyEvaluation->general_feedback ?: 'لا توجد ملاحظات حالياً' }}</p>
        </div>
    @else
        <div class="note-box">
            <h4>تقييم الشركة</h4>
            <p>لم يتم إضافة تقييم من الشركة بعد.</p>
        </div>
    @endif
</section>

  @else
    <div class="empty-state">
      <p>لا يوجد لديك تدريب فعلي حتى الآن. بعد قبول طلبك من الشركة سيظهر ملف التدريب هنا.</p>
      <a href="{{ route('front.student.applications') }}" class="btn btn-primary">الذهاب إلى طلباتي</a>
    </div>
  @endif

</main>
@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll(".student-pages-container a");
  const currentPath = window.location.pathname;

  links.forEach(link => {
    if (link.getAttribute("href") === currentPath) {
      link.classList.add("active");
    }
  });
});
</script>
@endsection
