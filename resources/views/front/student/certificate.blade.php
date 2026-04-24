@extends('front.layout.student')
@section('title','certificate')

@section('css')
<style>
.certificate-page{
    display:grid;
    gap:18px;
}
.certificate-card{
    background:#fff;
    border-radius:22px;
    padding:28px;
    box-shadow:0 8px 24px rgba(0,0,0,0.06);
    border:1px solid #edf1f5;
    text-align:center;
}
.certificate-card h2{
    margin:0 0 10px;
    color:#1c2b4a;
    font-size:28px;
    font-weight:900;
}
.certificate-card p{
    color:#475569;
    line-height:1.9;
    font-size:15px;
}
.certificate-box{
    margin-top:20px;
    border:2px dashed #3e7cd7;
    border-radius:20px;
    padding:30px 20px;
    background:#f8fbff;
}
.certificate-title{
    font-size:30px;
    font-weight:900;
    color:#2c5aa0;
    margin-bottom:18px;
}
.certificate-name{
    font-size:26px;
    font-weight:900;
    color:#111827;
    margin:12px 0;
}
.certificate-meta{
    font-size:15px;
    color:#475569;
    margin:8px 0;
}
.empty-cert{
    background:#fff;
    border-radius:22px;
    padding:28px;
    border:1px solid #edf1f5;
    text-align:center;
}
.empty-cert p{
    color:#64748b;
    font-size:15px;
}
.btn{
    border:none;
    padding:10px 14px;
    border-radius:12px;
    cursor:pointer;
    font-size:13px;
    font-weight:900;
    text-decoration:none;
    display:inline-block;
}
.btn-primary{
    background:#3e7cd7;
    color:#fff;
}
</style>
@endsection

@section('content')
<main class="student-page certificate-page">

    @if($internship && $internship->certificate && $internship->certificate->is_issued)
        <section class="certificate-card">
            <h2>الشهادة</h2>
            <p>تم إصدار شهادة إتمام التدريب الخاصة بك بنجاح.</p>

            <div class="certificate-box">
                <div class="certificate-title">شهادة إتمام تدريب</div>

                <p>نشهد بأن</p>

                <div class="certificate-name">
                    {{ $internship->student->full_name ?? auth()->user()->student->full_name ?? '-' }}
                </div>

                <p>
                    قد أتم/أتَمّت التدريب الميداني بنجاح في
                    <strong>{{ $internship->company->name ?? '-' }}</strong>
                </p>

                <div class="certificate-meta">
                    الفرصة: {{ $internship->opportunity->title ?? '-' }}
                </div>

                <div class="certificate-meta">
                    رقم الشهادة: {{ $internship->certificate->certificate_number }}
                </div>

                <div class="certificate-meta">
                    تاريخ الإصدار: {{ $internship->certificate->issue_date ? $internship->certificate->issue_date->format('Y-m-d') : '-' }}
                </div>

                <div class="certificate-meta">
                    الساعات المعتمدة: {{ $internship->completed_hours ?? 0 }} ساعة
                </div>

                @if($internship->certificate->notes)
                    <div class="certificate-meta">
                        ملاحظات: {{ $internship->certificate->notes }}
                    </div>
                @endif
            </div>
        </section>
    @else
        <section class="empty-cert">
            <h2>الشهادة</h2>
            <p>لم يتم إصدار شهادة لك بعد. ستظهر هنا بعد اكتمال التدريب واعتمادها.</p>
        </section>
    @endif

</main>
@endsection
