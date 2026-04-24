@extends('cms.supervisor.parent')

@section('title','الرئيسية')
@section('main-title','الرئيسية')

@section('content')
<main class="sup-wrap">

  <section class="sup-head">
    <h2>🏠 Dashboard المشرف الأكاديمي</h2>
    <p>ملخص سريع للطلاب والتقارير بآخر أسبوع.</p>
  </section>

  <section class="sup-stats">
    <div class="stat-card">
      <h4>👩‍🎓 الطلاب تحت الإشراف</h4>
      <span>{{ $studentCount }}</span>
    </div>

    <div class="stat-card">
      <h4>📄 تقارير هذا الأسبوع</h4>
      <span>{{ $weekReportsCount }}</span>
    </div>

    <div class="stat-card">
      <h4>⏳ تقارير بانتظار المراجعة</h4>
      <span>{{ $pendingReportsCount }}</span>
    </div>

    <div class="stat-card">
      <h4>⭐ تقييمات مكتملة</h4>
      <span>{{ $evaluationsCount }}</span>
    </div>
  </section>

  <section class="sup-card">
    <div class="card-head">
      <h3>👩‍🎓 أحدث الطلاب</h3>
      <a class="link-btn" href="{{ route('cms.supervisor.students.index') }}">عرض الكل</a>
    </div>

    <div class="table-responsive">
      <table class="sup-table">
        <thead>
          <tr>
            <th>#</th>
            <th>الطالب</th>
            <th>الرقم الجامعي</th>
            <th>الشركة</th>
            <th>الحالة</th>
          </tr>
        </thead>
        <tbody>
          @forelse($latestInternships as $internship)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $internship->student->full_name ?? '-' }}</td>
              <td>{{ $internship->student->university_number ?? '-' }}</td>
              <td>{{ $internship->company->name ?? '-' }}</td>
              <td>{{ $internship->status ?? '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">لا توجد بيانات</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  <section class="sup-card">
    <div class="card-head">
      <h3>📄 آخر التقارير</h3>
      <a class="link-btn" href="{{ route('cms.supervisor.weekly-reports') }}">مراجعة التقارير</a>
    </div>

    <div class="table-responsive">
      <table class="sup-table">
        <thead>
          <tr>
            <th>#</th>
            <th>الطالب</th>
            <th>الأسبوع</th>
            <th>الحالة</th>
            <th>إجراء</th>
          </tr>
        </thead>
        <tbody>
          @forelse($latestReports as $report)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $report->internship->student->full_name ?? '-' }}</td>
              <td>الأسبوع {{ $report->week_number }}</td>
              <td>{{ $report->status }}</td>
              <td>
                <a class="link-btn" href="{{ route('cms.supervisor.weekly-reports.show', $report->id) }}">عرض</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">لا توجد تقارير</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

</main>
@endsection
