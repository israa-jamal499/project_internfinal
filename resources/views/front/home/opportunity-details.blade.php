@extends('front.layout.main')
@section('title', content: 'opportunities details')

@section('content')
@section('css')
@endsection

<!-- Page Header -->
<section class="page-header">
  <h1>تفاصيل فرصة التدريب</h1>
  <p>
    اقرأ تفاصيل الفرصة قبل التقديم. تأكدي أنها مناسبة لتخصصك وساعات التدريب المطلوبة.
  </p>
</section>

<!-- Opportunity Details Layout -->
<section class="details-layout">

  <!-- LEFT: Main Content -->
  <div class="details-main">

    <!-- Opportunity Cover -->
    <div class="details-cover">
      @if($opportunity->image)
        <img src="{{ asset('storage/' . $opportunity->image->path) }}" alt="Opportunity Cover" />
      @else
        <img src="{{ asset('internship/img/webDev.jpeg') }}" alt="Opportunity Cover" />
      @endif
    </div>

    <!-- Title + Company -->
    <div class="details-title">
      <h2 id="opTitle">{{ $opportunity->title }}</h2>
      <div class="details-company">
        <span id="opCompany">{{ $opportunity->company->name ?? '-' }}</span>
        <span class="badge badge-type" id="opType">{{ $opportunity->type }}</span>
        <span class="badge badge-status" id="opStatus">{{ $opportunity->status }}</span>
      </div>
    </div>

    <!-- Quick Info -->
    <div class="details-info-grid">
      <div class="info-box">
        <div class="label">📍 الموقع</div>
        <div class="value" id="opLocation">
          {{ $opportunity->type == 'عن بعد' ? 'عن بعد' : ($opportunity->city->name ?? '-') }}
        </div>
      </div>

      <div class="info-box">
        <div class="label">⏳ عدد الساعات</div>
        <div class="value" id="opHours">{{ $opportunity->required_hours }} ساعة</div>
      </div>

      <div class="info-box">
        <div class="label">🎓 التخصص المطلوب</div>
        <div class="value" id="opMajor">
          @forelse($opportunity->specializations as $specialization)
            {{ $specialization->name }}@if(!$loop->last) ، @endif
          @empty
            -
          @endforelse
        </div>
      </div>

      <div class="info-box">
        <div class="label">📅 تاريخ النشر</div>
        <div class="value" id="opDate">{{ $opportunity->created_at->format('Y-m-d') }}</div>
      </div>
    </div>

    <!-- Description -->
    <div class="details-section">
      <h3>📌 وصف الفرصة</h3>
      <p id="opDesc">
        {{ $opportunity->description }}
      </p>
    </div>

    <!-- Requirements -->
    <div class="details-section">
      <h3>✅ المتطلبات</h3>
      <ul id="opRequirements">
        @if($opportunity->requirements)
          @foreach(preg_split('/\r\n|\r|\n/', $opportunity->requirements) as $item)
            @if(trim($item) !== '')
              <li>{{ $item }}</li>
            @endif
          @endforeach
        @else
          <li>لا توجد متطلبات مضافة</li>
        @endif
      </ul>
    </div>

    <!-- Benefits / Skills -->
    <div class="details-section">
      <h3>⭐ المهارات / الفوائد</h3>

      <div class="skills-list" id="opSkills">
        @if($opportunity->benefits)
          @foreach(preg_split('/\r\n|\r|\n/', $opportunity->benefits) as $item)
            @if(trim($item) !== '')
              <span class="skill">{{ $item }}</span>
            @endif
          @endforeach
        @else
          <span class="skill">لا توجد فوائد مضافة</span>
        @endif
      </div>
    </div>

    <!-- Company Info -->
    <div class="details-section">
      <h3>🏢 معلومات عن الشركة</h3>

      <div class="company-card">
        <div class="company-logo">
          @if($opportunity->company && $opportunity->company->image)
            <img src="{{ asset('storage/' . $opportunity->company->image->path) }}" alt="Company Logo" />
          @else
            <img src="{{ asset('internship/img/codelog.png') }}" alt="Company Logo" />
          @endif
        </div>

        <div class="company-data">
          <h4 id="companyName">{{ $opportunity->company->name ?? '-' }}</h4>
          <p id="companyAbout">
            {{ $opportunity->company->description ?? 'لا يوجد وصف للشركة' }}
          </p>

          <div class="company-meta">
            <span>📧 البريد: <strong id="companyEmail">{{ $opportunity->company->user->email ?? '-' }}</strong></span>
            <span>🌐 الموقع: <strong id="companyWebsite">{{ $opportunity->company->website ?? '-' }}</strong></span>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- RIGHT: Sidebar -->
  <aside class="details-sidebar">

    <!-- Apply Card -->
    <div class="sidebar-card apply-card">
      <h3>التقديم على الفرصة</h3>
      <p>
        للتقديم يجب تسجيل الدخول كطالب أولاً.
      </p>

      @if(session('success'))
  <div class="alert alert-success" style="margin-bottom:10px;">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger" style="margin-bottom:10px;">
    {{ session('error') }}
  </div>
@endif

@if(auth()->check() && auth()->user()->role == 'student')
  <form action="{{ route('front.home.opportunities.apply', $opportunity->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn-primary">تقديم الآن</button>
  </form>
@else
  <form action="{{ route('front.home.opportunities.apply', $opportunity->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn-primary">تقديم الآن</button>
  </form>
@endif

      <div class="apply-note">
        ⚠️ سيتم إرسال الطلب للشركة + للمشرف الأكاديمي للمراجعة.
      </div>
    </div>

    <!-- Supervisor Note -->
    <div class="sidebar-card">
      <h3>ملاحظة من الكلية</h3>
      <p>
        يجب أن تكون الفرصة ضمن ساعات التدريب المعتمدة، وسيتم متابعة التقارير الأسبوعية خلال فترة التدريب.
      </p>
    </div>

    <!-- Similar Opportunities -->
    <div class="sidebar-card">
      <h3>فرص مشابهة</h3>

      @forelse($similarOpportunities as $similar)
        <div class="mini-op">
          @if($similar->image)
            <img src="{{ asset('storage/' . $similar->image->path) }}" alt="mini" />
          @else
            <img src="{{ asset('internship/img/webDev.jpeg') }}" alt="mini" />
          @endif
          <div>
            <h4>{{ $similar->title }}</h4>
            <a href="{{ route('front.home.opportunity-details', ['id' => $similar->id]) }}" class="btn-card">عرض التفاصيل</a>
          </div>
        </div>
      @empty
        <p>لا توجد فرص مشابهة حالياً</p>
      @endforelse

    </div>

  </aside>

</section>

@section('js')
@endsection
@endsection
