@extends('cms.admin.parent')

@section('title', 'التقارير')
@section('main-title','التقارير')
@section('styles')
<style>
/* =========================
   REPORTS PAGE (ISOLATED)
========================= */

.reports-page {
  direction: rtl;
}

/* Layout */
.reports-page .content-wrapper {
  padding: 20px;
}

/* Card */
.reports-page .card {
  border-radius: 14px;
  border: 1px solid #e6edf5;
  box-shadow: 0 6px 16px rgba(0,0,0,0.05);
  margin-bottom: 20px;
}

/* Header */
.reports-page .card-header {
  background: #f8fbff;
  border-bottom: 1px solid #e6edf5;
  font-weight: bold;
}

/* Inputs */
.reports-page input,
.reports-page select {
  border-radius: 8px !important;
  border: 1px solid #dbe4ff;
}

.reports-page input:focus,
.reports-page select:focus {
  border-color: #3e7cd7;
  box-shadow: 0 0 0 2px rgba(62,124,215,0.1);
}

/* Buttons */
.reports-page .btn {
  border-radius: 8px;
  font-size: 14px;
}

/* Small boxes (الإحصائيات) */
.reports-page .small-box {
  border-radius: 14px;
  padding: 10px;
  color: #fff;
}

.reports-page .small-box .inner h3 {
  font-size: 26px;
  font-weight: bold;
}

.reports-page .small-box .icon {
  font-size: 40px;
  opacity: 0.2;
  top: 10px;
}

/* Colors */
.reports-page .bg-primary { background: #3e7cd7 !important; }
.reports-page .bg-success { background: #28a745 !important; }
.reports-page .bg-warning { background: #f4b400 !important; }
.reports-page .bg-info { background: #17a2b8 !important; }

/* Table */
.reports-page .table {
  margin: 0;
  text-align: center;
}

.reports-page .table thead {
  background: #f8fbff;
}

.reports-page .table th {
  font-weight: 700;
  font-size: 14px;
}

.reports-page .table td {
  font-size: 13px;
  vertical-align: middle;
}

/* Table container */
.reports-page .table-responsive {
  overflow-x: auto;
}

/* Badges */
.reports-page .badge {
  padding: 6px 10px;
  border-radius: 10px;
  font-size: 12px;
}

/* Pagination */
.reports-page .pagination .page-link {
  border-radius: 6px;
  margin: 0 2px;
}

/* Modal */
.reports-page .modal-content {
  border-radius: 12px;
}

.reports-page .modal-header {
  background: #3e7cd7;
  color: #fff;
}

/* تحسين الفراغات */
.reports-page .row {
  margin-bottom: 10px;
}

/* Responsive */
@media (max-width: 768px) {
  .reports-page .small-box {
    margin-bottom: 10px;
  }
}
</style>
@endsection
@section('content')
<div  class="reports-page" dir="rtl">
    <!-- Page Header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Filters -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">فلترة التقارير</h3>
                </div>
                <div class="card-body">
                    <form class="row">
                        <div class="col-md-3 mb-3">
                            <label>نوع التقرير</label>
                            <select class="form-control">
                                <option>الكل</option>
                                <option>تقارير الطلاب</option>
                                <option>تقارير الشركات</option>
                                <option>تقارير التدريب</option>
                                <option>تقارير الساعات</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>الحالة</label>
                            <select class="form-control">
                                <option>الكل</option>
                                <option>مكتمل</option>
                                <option>قيد المراجعة</option>
                                <option>مؤرشف</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>من تاريخ</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>إلى تاريخ</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>بحث</label>
                            <input type="text" class="form-control" placeholder="ابحث باسم التقرير أو الجهة...">
                        </div>

                        <div class="col-md-6 mb-3 d-flex align-items-end justify-content-start gap-2">
                            <button type="button" class="btn btn-primary ml-2">
                                <i class="fas fa-filter"></i> تطبيق الفلترة
                            </button>
                            <button type="button" class="btn btn-success ml-2">
                                <i class="fas fa-file-excel"></i> تصدير Excel
                            </button>
                            <button type="button" class="btn btn-secondary">
                                <i class="fas fa-print"></i> طباعة
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                           <h3>{{ $totalReports }}</h3>
                            <p>إجمالي التقارير</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                           <h3>{{ $completedReports }}</h3>
                            <p>تقارير مكتملة</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                           <h3>{{ $pendingReports }}</h3>
                            <p>قيد المراجعة</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                           <h3>{{ $archivedReports }}</h3>
                            <p>مؤرشفة</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-archive"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">قائمة التقارير</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>اسم التقرير</th>
                                <th>النوع</th>
                                <th>الجهة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الحالة</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                     <tbody>
    @forelse($weeklyReports as $report)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>
                تقرير الأسبوع {{ $report->week_number }}
                - {{ $report->internship->student->full_name ?? '-' }}
            </td>

            <td>تقارير الطلاب</td>

            <td>{{ $report->internship->company->name ?? '-' }}</td>

            <td>{{ $report->created_at ? $report->created_at->format('Y-m-d') : '-' }}</td>

            <td>
                @if($report->status == 'تمت المراجعة')
                    <span class="badge badge-success">مكتمل</span>
                @elseif($report->status == 'بانتظار المراجعة')
                    <span class="badge badge-warning">قيد المراجعة</span>
                @else
                    <span class="badge badge-secondary">{{ $report->status }}</span>
                @endif
            </td>

            <td>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#reportModal{{ $report->id }}">
                    <i class="fas fa-eye"></i> عرض
                </button>
            </td>
        </tr>

        <div class="modal fade" id="reportModal{{ $report->id }}" tabindex="-1" role="dialog" dir="rtl">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">تفاصيل التقرير</h5>
                        <button type="button" class="close ml-0 mr-auto text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p><strong>الطالب:</strong> {{ $report->internship->student->full_name ?? '-' }}</p>
                        <p><strong>الشركة:</strong> {{ $report->internship->company->name ?? '-' }}</p>
                        <p><strong>الأسبوع:</strong> {{ $report->week_number }}</p>
                        <p><strong>الحالة:</strong> {{ $report->status }}</p>
                        <hr>
                        <p><strong>المهام المنجزة:</strong></p>
                        <p>{{ $report->tasks_completed ?? '-' }}</p>

                        <p><strong>الملاحظات:</strong></p>
                        <p>{{ $report->notes ?? '-' }}</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <tr>
            <td colspan="7">لا توجد تقارير</td>
        </tr>
    @endforelse
</tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-left">
                        <li class="page-item"><a class="page-link" href="#">«</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true" dir="rtl">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="reportModalLabel">تفاصيل التقرير</h5>
                <button type="button" class="close ml-0 mr-auto text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p><strong>اسم التقرير:</strong> تقرير متابعة تدريب الطالب أحمد</p>
                <p><strong>النوع:</strong> تقارير الطلاب</p>
                <p><strong>الجهة:</strong> شركة المستقبل</p>
                <p><strong>تاريخ الإنشاء:</strong> 2026-04-07</p>
                <p><strong>الحالة:</strong> مكتمل</p>
                <hr>
                <p>
                    هذا مثال على محتوى التقرير. هون لاحقًا بتقدري تعرضي نص التقرير كامل،
                    أو ملخص، أو بيانات جاية من قاعدة البيانات.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary">تنزيل التقرير</button>
            </div>
        </div>
    </div>
</div>
@endsection
