@extends('front.layout.main')
@section('title', content: 'opportunities')

@section('content')
@section('css')
@endsection

<!-- Page Header -->
<section class="page-header">
  <h1>فرص التدريب</h1>
  <p>
    تصفحي أحدث فرص التدريب الميداني المعتمدة للطلبة في الكلية الجامعية للعلوم التطبيقية (UCAS).
  </p>
</section>

<!-- Filters -->
<section class="filters-container">
  <div class="filters">
    <input type="text" id="searchInput" placeholder="ابحث عن فرصة أو شركة..." />

    <select id="majorFilter">
      <option value="all">كل التخصصات</option>
      @foreach($specializations as $specialization)
        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
      @endforeach
    </select>

    <select id="typeFilter">
      <option value="all">كل الأنواع</option>
      <option value="حضوري">وجاهي</option>
      <option value="عن بعد">عن بعد</option>
      <option value="هجين">هجين</option>
    </select>
  </div>
</section>

<!-- Cards -->
<section class="cards-container" id="cardsContainer">

  @forelse($opportunities as $opportunity)
    @php
      $specializationIds = $opportunity->specializations->pluck('id')->implode(',');
    @endphp

    <div class="op-card"
         data-major="{{ $specializationIds }}"
         data-type="{{ $opportunity->type }}">
      <div class="thumb">
        @if($opportunity->image)
          <img src="{{ asset('storage/' . $opportunity->image->path) }}" alt="{{ $opportunity->title }}" />
        @else
          <img src="{{ asset('internship/img/web.png') }}" alt="{{ $opportunity->title }}" />
        @endif
      </div>

      <h3>{{ $opportunity->title }}</h3>
      <div class="company">{{ $opportunity->company->name ?? '-' }}</div>

      <div class="info">
        @if($opportunity->type == 'عن بعد')
          🌍 عن بعد | ⏳ {{ $opportunity->required_hours }} ساعة
        @else
          📍 {{ $opportunity->city->name ?? '-' }} | ⏳ {{ $opportunity->required_hours }} ساعة
        @endif
      </div>

      <p class="desc">
        {{ \Illuminate\Support\Str::limit($opportunity->description, 120) }}
      </p>

      <a href="{{ route('front.home.opportunity-details', ['id' => $opportunity->id]) }}" class="btn-card">
        عرض التفاصيل
      </a>
    </div>
  @empty
    <div style="width:100%; text-align:center; padding:30px;">
      لا توجد فرص متاحة حالياً
    </div>
  @endforelse

</section>

<!-- Empty State -->
<div class="empty-state" id="emptyState">
  لا توجد فرص مطابقة لبحثك 💔
</div>

<div style="display:flex; justify-content:center; margin:30px 0;">
  {{ $opportunities->links() }}
</div>

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const majorFilter = document.getElementById('majorFilter');
    const typeFilter = document.getElementById('typeFilter');
    const cards = document.querySelectorAll('.op-card');
    const emptyState = document.getElementById('emptyState');

    function filterCards() {
        let visibleCount = 0;

        cards.forEach(card => {
            const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
            const company = card.querySelector('.company')?.textContent.toLowerCase() || '';
            const major = card.getAttribute('data-major') || '';
            const type = card.getAttribute('data-type') || '';

            const searchValue = searchInput.value.trim().toLowerCase();
            const majorValue = majorFilter.value;
            const typeValue = typeFilter.value;

            const matchesSearch = title.includes(searchValue) || company.includes(searchValue);
            const matchesMajor = majorValue === 'all' || major.split(',').includes(majorValue);
            const matchesType = typeValue === 'all' || type === typeValue;

            const visible = matchesSearch && matchesMajor && matchesType;
            card.style.display = visible ? '' : 'none';

            if (visible) visibleCount++;
        });

        emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', filterCards);
    majorFilter.addEventListener('change', filterCards);
    typeFilter.addEventListener('change', filterCards);

    filterCards();
});
</script>
@endsection
@endsection
