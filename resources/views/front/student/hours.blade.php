@extends('front.layout.student')

@section('title','hours')

@section('content')
<main class="student-page hours-page">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <section class="page-title-box">
        <h2>ساعات التدريب</h2>
        <p>
            من هنا يمكنك متابعة الساعات المطلوبة، الساعات المعتمدة، وإضافة سجل ساعات جديد وإرسالها للاعتماد.
        </p>
    </section>

    <section class="hours-stats">
        <article class="mini-card white-card">
            <span>الساعات المطلوبة</span>
            <strong id="requiredHours">{{ $requiredHours }}</strong>
        </article>

        <article class="mini-card white-card">
            <span>الساعات المعتمدة</span>
            <strong id="approvedHours">{{ $approvedHours }}</strong>
        </article>

        <article class="mini-card white-card">
            <span>الساعات المعلقة</span>
            <strong id="pendingHours">{{ $pendingHours }}</strong>
        </article>

        <article class="mini-card white-card">
            <span>الساعات المتبقية</span>
            <strong id="remainingHours">{{ $remainingHours }}</strong>
        </article>
    </section>

    <section class="hours-progress-card white-card">
        <div class="card-head no-link">
            <h3>⏳ تقدم الساعات</h3>
        </div>

        <div class="progress-labels">
            <span>نسبة الإنجاز</span>
            <strong id="progressPercent">{{ $progressPercent }}%</strong>
        </div>

        <div class="progress-bar">
            <div class="progress-fill" id="hoursProgressFill" style="width: {{ $progressPercent }}%;"></div>
        </div>
    </section>

    @if($internship)
    <section class="hours-form-card white-card">
        <div class="card-head no-link">
            <h3>➕ إضافة سجل ساعات</h3>
        </div>

        <form method="POST" action="{{ route('front.student.hours.store') }}" class="hours-form-grid">
            @csrf

            <div class="form-group">
                <label>التاريخ</label>
                <input type="date" name="work_date" class="form-control" value="{{ old('work_date') }}">
            </div>

            <div class="form-group">
                <label>عدد الساعات</label>
                <input type="number" name="hours" class="form-control" min="1" max="12" placeholder="مثال: 4" value="{{ old('hours') }}">
            </div>

            <div class="form-group full-span">
                <label>وصف العمل المنجز</label>
                <textarea name="description" class="form-textarea" rows="4" placeholder="اكتبي باختصار ما الذي تم إنجازه في هذا اليوم">{{ old('description') }}</textarea>
            </div>

            <div class="full-span">
                <button type="submit" class="btn btn-primary">حفظ السجل</button>
            </div>
        </form>
    </section>
    @endif

    <section class="hours-table-card white-card">
        <div class="card-head">
            <h3>📋 سجل الساعات</h3>
        </div>

        <div class="table-wrap">
            <table class="clean-table">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>عدد الساعات</th>
                        <th>وصف العمل</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody id="hoursTableBody">
                    @forelse($hourLogs as $log)
                        <tr>
                            <td>{{ $log->work_date ? $log->work_date->format('Y-m-d') : '-' }}</td>
                            <td>{{ $log->hours }}</td>
                            <td>{{ $log->description }}</td>
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
                                @if($log->status != 'approved')
                                    <form method="POST" action="{{ route('front.student.hours.destroy', $log->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm-link" onclick="return confirm('هل تريد حذف السجل؟')">حذف</button>
                                    </form>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">لا توجد سجلات ساعات حتى الآن</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</main>
@endsection

@section('css')
<style>
.hours-page{
    display:grid;
    gap:18px;
}
.hours-stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
}
.mini-card{
    padding:18px;
    border-radius:20px;
    text-align:center;
}
.mini-card span{
    display:block;
    color:#64748b;
    font-size:13px;
    margin-bottom:8px;
}
.mini-card strong{
    font-size:28px;
    color:#122033;
    font-weight:900;
}
.hours-progress-card,
.hours-form-card,
.hours-table-card{
    padding:22px;
    border-radius:22px;
}
.progress-labels{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}
.progress-labels span{
    color:#64748b;
    font-size:14px;
}
.progress-labels strong{
    color:#122033;
    font-size:15px;
    font-weight:900;
}
.progress-bar{
    width:100%;
    height:12px;
    background:#eaf1fb;
    border-radius:999px;
    overflow:hidden;
}
.progress-fill{
    height:100%;
    border-radius:999px;
    background:linear-gradient(90deg, #3e7cd7, #6ea0ee);
    transition:width .3s ease;
}
.hours-form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:16px;
}
.form-group{
    display:grid;
    gap:8px;
}
.form-group label{
    font-size:14px;
    font-weight:800;
    color:#334155;
}
.full-span{
    grid-column:1 / -1;
}
.btn-sm-link{
    padding:8px 12px;
    font-size:12px;
}
.clean-table tbody tr:hover{
    background:#f8fbff;
}
.alert{
    padding:12px 14px;
    border-radius:12px;
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
@media (max-width:900px){
    .hours-stats{
        grid-template-columns:repeat(2,1fr);
    }
    .hours-form-grid{
        grid-template-columns:1fr;
    }
}
@media (max-width:600px){
    .hours-stats{
        grid-template-columns:1fr;
    }
}
</style>
@endsection
