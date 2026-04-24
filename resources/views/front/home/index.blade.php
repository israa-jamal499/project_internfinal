@extends('front.layout.main')
@section('title', 'Main Page')

@section('content')
@section('css')
@endsection

<!-- ===== Hero ===== -->
<section class="hero-mostaql">
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <h1>ابدأ تدريبك الميداني بسهولة</h1>
    <p>منصة رسمية لإدارة التدريب الميداني</p>

    <div class="hero-search">
      <input type="text" placeholder="ابحث عن فرصة تدريب..." id="heroSearchInput">
      <button id="heroSearchBtn">ابحث الآن</button>
    </div>

    <div class="register-options">
      <a href="{{ route('front.auth.register-student') }}" class="register-card student">
        🎓 سجل كطالب
      </a>

      <a href="{{ route('front.auth.register-company') }}" class="register-card company">
        🏢 سجل كشركة
      </a>
    </div>
  </div>
</section>

<!-- ===== How Start ===== -->
<section class="how-start reveal">
  <h2>كيف تبدأ تدريبك الميداني؟</h2>

  <div class="steps-container">
    <div class="step-box">📝 سجل حساب</div>
    <div class="step-box">🔍 اختر فرصة</div>
    <div class="step-box">📊 تابع تقدمك</div>
  </div>
</section>

<section class="features">
  <h2>لماذا تستخدم منصة التدريب الميداني؟</h2>

  <div class="features-grid">
    <div class="feature reveal">
      <i class="fas fa-tasks"></i>
      <h3>إدارة سهلة للتدريب</h3>
      <p>سجّل تدريبك وتابع جميع خطواته إلكترونيًا.</p>
    </div>

    <div class="feature reveal">
      <i class="fas fa-building"></i>
      <h3>فرص تدريب موثوقة</h3>
      <p>تصفح فرص تدريب من شركات معتمدة.</p>
    </div>

    <div class="feature reveal">
      <i class="fas fa-chart-line"></i>
      <h3>متابعة تقدمك</h3>
      <p>راقب تقاريرك وتقييمك النهائي.</p>
    </div>

    <div class="feature reveal">
      <i class="fas fa-comments"></i>
      <h3>تواصل مباشر</h3>
      <p>تواصل مع جهة التدريب بسهولة.</p>
    </div>

    <div class="feature reveal">
      <i class="fas fa-lock"></i>
      <h3>أمان البيانات</h3>
      <p>بياناتك محفوظة وآمنة بالكامل.</p>
    </div>

    <div class="feature reveal">
      <i class="fas fa-certificate"></i>
      <h3>شهادة رسمية</h3>
      <p>احصل على شهادة بعد إتمام التدريب.</p>
    </div>
  </div>
</section>

<!-- ===== Latest Opportunities ===== -->
<section class="latest-section">
  <h2>أحدث فرص التدريب</h2>

  <div class="opportunity-grid">
    @forelse($latestOpportunities as $opportunity)
      <div class="opportunity-card">
        <div class="card-image">
          @if($opportunity->image)
            <img src="{{ asset('storage/' . $opportunity->image->path) }}" alt="{{ $opportunity->title }}">
          @else
            <img src="{{ asset('internship/img/web.png') }}" alt="{{ $opportunity->title }}">
          @endif
        </div>

        <div class="card-body">
          <h3>{{ $opportunity->title }}</h3>

          <p>
            {{ $opportunity->company->name ?? '-' }} | {{ $opportunity->seats }} مقاعد
          </p>

          <span>
            @forelse($opportunity->specializations as $specialization)
              {{ $specialization->name }}@if(!$loop->last) ، @endif
            @empty
              لا يوجد تخصص محدد
            @endforelse
          </span>

          <a href="{{ route('front.home.opportunity-details', ['id' => $opportunity->id]) }}" class="view-btn">
            عرض التفاصيل
          </a>
        </div>
      </div>
    @empty
      <div style="width:100%; text-align:center; padding:20px;">
        لا توجد فرص متاحة حالياً
      </div>
    @endforelse
  </div>

  <div class="all-opportunities">
    <a href="{{ route('front.home.opportunities') }}" class="main-cta">
      عرض جميع فرص التدريب
    </a>
  </div>
</section>

<!-- ===== Call To Action ===== -->
<section class="cta-section">
  <h2>ابدأ تدريبك الميداني الآن</h2>
  <p>سجل حسابك وابدأ التقديم على الفرص المتاحة فورًا</p>

  <a href="{{ route('front.auth.register-student') }}" class="cta-btn">
    إنشاء حساب طالب
  </a>
</section>

@section('js')
@endsection
@endsection
