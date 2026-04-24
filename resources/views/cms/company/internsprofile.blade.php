@extends('cms.company.temp')
@section('title','intern profile')
@section('main-title','ملف المتدرب')

@section('content')
<style>
.profile-container{
  width:92%;
  margin:25px auto;
}

.profile-card{
  background:#fff;
  border:1px solid #e3e8ef;
  border-radius:18px;
  padding:20px;
  box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.profile-head{
  display:flex;
  align-items:center;
  gap:18px;
  margin-bottom:20px;
  flex-wrap:wrap;
}

.profile-head img{
  width:90px;
  height:90px;
  border-radius:50%;
  object-fit:cover;
  border:2px solid #e3e8ef;
}

.profile-name{
  font-size:22px;
  font-weight:900;
  color:#1c2b4a;
}

.profile-sub{
  margin-top:6px;
  color:#6b7280;
  font-size:14px;
}

.status-badge{
  display:inline-block;
  margin-top:10px;
  background:#eafff1;
  color:#047857;
  padding:6px 12px;
  border-radius:999px;
  font-size:12px;
  font-weight:bold;
}

.info-grid{
  display:grid;
  grid-template-columns:repeat(2, 1fr);
  gap:14px;
  margin-top:18px;
}

.info-box{
  background:#f8fbff;
  border:1px solid #e8eef4;
  border-radius:16px;
  padding:14px;
}

.info-box h4{
  margin:0 0 8px;
  font-size:14px;
  color:#3e7cd7;
  font-weight:900;
}

.info-box p{
  margin:0;
  font-size:14px;
  color:#1c2b4a;
  line-height:1.8;
}

.note-box{
  margin-top:18px;
  background:#f8fbff;
  border:1px solid #e8eef4;
  border-radius:16px;
  padding:14px;
}

.note-box h4{
  margin:0 0 8px;
  font-size:14px;
  color:#3e7cd7;
  font-weight:900;
}

.note-box p{
  margin:0;
  font-size:14px;
  color:#334155;
  line-height:1.8;
}

.actions{
  margin-top:20px;
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}

.btn{
  border:none;
  padding:10px 14px;
  border-radius:12px;
  cursor:pointer;
  font-size:13px;
  font-weight:900;
  text-decoration:none;
  transition:0.2s ease;
  display:inline-block;
}

.btn-primary{
  background:#3e7cd7;
  color:#fff;
}

.btn-light{
  background:#f1f5f9;
  color:#1c2b4a;
}

.btn-danger{
  background:#ffebeb;
  color:#b91c1c;
}

@media (max-width: 900px){
  .info-grid{
    grid-template-columns:1fr;
  }
}
</style>

<div class="profile-container">
  <div class="profile-card">

    <div class="profile-head">
      @if($internship->student && $internship->student->image)
        <img src="{{ asset('storage/' . $internship->student->image->path) }}" alt="student">
      @else
        <img src="{{ asset('internship/img/israa.jpeg') }}" alt="student">
      @endif

      <div>
        <div class="profile-name">{{ $internship->student->full_name ?? '-' }}</div>
        <div class="profile-sub">
          الرقم الجامعي: {{ $internship->student->university_number ?? '-' }}
        </div>
        <span class="status-badge">{{ $internship->status }}</span>
      </div>
    </div>

    <div class="info-grid">
      <div class="info-box">
        <h4>التخصص</h4>
        <p>{{ $internship->student->specialization->name ?? '-' }}</p>
      </div>

      <div class="info-box">
        <h4>الكلية</h4>
        <p>{{ $internship->student->college->name ?? '-' }}</p>
      </div>

      <div class="info-box">
        <h4>المدينة</h4>
        <p>{{ $internship->student->city->name ?? '-' }}</p>
      </div>

      <div class="info-box">
        <h4>البريد الإلكتروني</h4>
        <p>{{ $internship->student->user->email ?? '-' }}</p>
      </div>

      <div class="info-box">
        <h4>رقم الجوال</h4>
        <p>{{ $internship->student->phone ?? '-' }}</p>
      </div>

      <div class="info-box">
        <h4>عنوان السكن</h4>
        <p>{{ $internship->student->address ?? '-' }}</p>
      </div>

      <div class="info-box">
        <h4>الفرصة</h4>
        <p>{{ $internship->opportunity->title ?? '-' }}</p>
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
        <h4>الساعات المطلوبة</h4>
        <p>{{ $internship->required_hours ?? 0 }} ساعة</p>
      </div>

      <div class="info-box">
        <h4>الساعات المنجزة</h4>
        <p>{{ $internship->completed_hours ?? 0 }} ساعة</p>
      </div>

      <div class="info-box">
        <h4>إجمالي الساعات</h4>
        <p>{{ $internship->total_hours ?? 0 }} ساعة</p>
      </div>

      <div class="info-box">
        <h4>المشرف</h4>
        <p>{{ $internship->supervisor->full_name ?? 'لم يتم تعيين مشرف بعد' }}</p>
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

    <div class="actions">
      <a href="{{ route('cms.company.interns') }}" class="btn btn-light">رجوع</a>

      @if($internship->status == 'قيد التدريب')
        <form action="{{ route('cms.company.interns.stop', $internship->id) }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="btn btn-danger" onclick="return confirm('هل تريد إنهاء تدريب هذا الطالب؟')">
            إنهاء التدريب
          </button>
        </form>
      @endif
    </div>

  </div>
</div>
@endsection
