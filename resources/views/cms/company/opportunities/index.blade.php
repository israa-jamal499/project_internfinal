@extends('cms.company.temp')
@section('title','opportunities')
@section('main-title','ادارة الفرص')

@section('content')
<style>
.company-opps-page {
  width: 92%;
  margin: 25px auto 0;
}

.opps-header {
  background: #fff;
  border-radius: 18px;
  padding: 18px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  border: 1px solid #eef3f6;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
}

.opps-header h2 {
  margin: 0;
  font-size: 20px;
  font-weight: 900;
  color: #222;
}

.opps-header p {
  margin: 8px 0 0;
  font-size: 13px;
  color: #666;
  line-height: 1.8;
}

.btn-primary {
  background: #3e7cd7;
  color: #fff;
  padding: 10px 14px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 800;
  border: none;
  cursor: pointer;
  transition: 0.2s;
  text-decoration: none;
  display: inline-block;
}

.btn-primary:hover {
  opacity: 0.92;
}

.opps-filters {
  margin-top: 16px;
  display: grid;
  grid-template-columns: 1.4fr 1fr 1fr;
  gap: 12px;
}

.filter-box {
  background: #fff;
  border-radius: 16px;
  padding: 14px;
  border: 1px solid #eef3f6;
  box-shadow: 0 10px 22px rgba(0, 0, 0, 0.04);
}

.filter-box label {
  display: block;
  margin-bottom: 8px;
  font-size: 13px;
  font-weight: 900;
  color: #333;
}

.filter-box input,
.filter-box select {
  width: 100%;
  padding: 11px 12px;
  border-radius: 14px;
  border: 1px solid #dfe7ef;
  outline: none;
  font-size: 13px;
  transition: 0.2s;
}

.opps-grid {
  margin-top: 16px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
  gap: 14px;
}

.opp-card {
  background: #fff;
  border-radius: 18px;
  overflow: hidden;
  border: 1px solid #eef3f6;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
  transition: 0.2s;
}

.opp-card:hover {
  transform: translateY(-2px);
}

.opp-img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  display: block;
}

.opp-content {
  padding: 14px;
}

.opp-title {
  margin: 0;
  font-size: 15px;
  font-weight: 900;
  color: #222;
}

.opp-desc {
  margin: 10px 0 0;
  font-size: 13px;
  color: #666;
  line-height: 1.8;
}

.opp-meta {
  margin-top: 12px;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  font-size: 12px;
  font-weight: 800;
}

.opp-meta span {
  padding: 6px 10px;
  border-radius: 999px;
  background: #f7f9fb;
  border: 1px solid #eef3f6;
  color: #333;
}

.status.open {
  background: #e7f8ee;
  border: 1px solid #c8f0d7;
  color: #0a7a36;
}

.status.closed {
  background: #ffe9e9;
  border: 1px solid #ffd0d0;
  color: #b00000;
}

.status.draft {
  background: #fff4db;
  border: 1px solid #ffe2a8;
  color: #9a6700;
}

.opp-actions {
  margin-top: 14px;
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.btn-outline {
  padding: 9px 12px;
  border-radius: 12px;
  border: 1px solid #dfe7ef;
  background: #fff;
  font-size: 13px;
  font-weight: 900;
  cursor: pointer;
  text-decoration: none;
  color: #3e7cd7;
  transition: 0.2s;
}

.btn-outline:hover {
  background: #f2f7ff;
  border-color: #3e7cd7;
}

.btn-danger {
  padding: 9px 12px;
  border-radius: 12px;
  border: 1px solid #ffd0d0;
  background: #fff;
  color: #b00000;
  font-size: 13px;
  font-weight: 900;
  cursor: pointer;
  transition: 0.2s;
}

.btn-danger:hover {
  background: #ffe9e9;
}

@media (max-width: 900px) {
  .opps-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .opps-filters {
    grid-template-columns: 1fr;
  }
}
</style>

<main class="company-opps-page">
  <section class="opps-header">
    <div class="header-text">
      <h2>📌 فرص التدريب الخاصة بشركتي</h2>
      <p>إدارة فرص التدريب: إضافة، تعديل، حذف، ومعرفة حالة كل فرصة.</p>
    </div>

    <div class="header-actions">
      <a href="{{ route('opportunities.create') }}" class="btn-primary">➕ إضافة فرصة جديدة</a>
      <a href="{{ route('opportunities.trashed') }}" class="btn-outline">سلة المحذوفات</a>
    </div>
  </section>

  <section class="opps-filters">
    <div class="filter-box">
      <label>🔍 بحث</label>
      <input type="text" id="searchInput" placeholder="ابحث باسم الفرصة أو المدينة..." />
    </div>

    <div class="filter-box">
      <label>📂 الحالة</label>
      <select id="statusFilter">
        <option value="all">الكل</option>
        <option value="مفتوحة">مفتوحة</option>
        <option value="مغلقة">مغلقة</option>
        <option value="مسودة">مسودة</option>
      </select>
    </div>

    <div class="filter-box">
      <label>📅 الترتيب</label>
      <select id="sortFilter">
        <option value="new">الأحدث</option>
        <option value="old">الأقدم</option>
      </select>
    </div>
  </section>

  <section class="opps-grid" id="oppsGrid">
    @forelse($opportunities as $opportunity)
      <div class="opp-card"
           data-status="{{ $opportunity->status }}"
           data-date="{{ $opportunity->created_at }}">

        @if($opportunity->image)
          <img src="{{ asset('storage/' . $opportunity->image->path) }}" alt="Opportunity" class="opp-img" />
        @else
          <img src="{{ asset('internship/img/web.png') }}" alt="Opportunity" class="opp-img" />
        @endif

        <div class="opp-content">
          <h3 class="opp-title">{{ $opportunity->title }}</h3>
          <p class="opp-desc">
            {{ \Illuminate\Support\Str::limit($opportunity->description, 120) }}
          </p>

          <div class="opp-meta">
            <span>📍 {{ $opportunity->city->name ?? '-' }}</span>
            <span>⏳ {{ $opportunity->required_hours }} ساعة</span>

            @if($opportunity->status == 'مفتوحة')
              <span class="status open">مفتوحة</span>
            @elseif($opportunity->status == 'مغلقة')
              <span class="status closed">مغلقة</span>
            @else
              <span class="status draft">مسودة</span>
            @endif
          </div>

          <div class="opp-actions">
            <a href="{{ route('opportunities.show', $opportunity->id) }}" class="btn-outline">👁 عرض</a>
            <a href="{{ route('opportunities.edit', $opportunity->id) }}" class="btn-outline">✏ تعديل</a>
            <button type="button" class="btn-danger"
                    onclick="confirmDestroy('{{ route('opportunities.destroy', $opportunity->id) }}', this)">
              🗑 حذف
            </button>
          </div>
        </div>
      </div>
    @empty
      <div class="opp-card">
        <div class="opp-content">
          <h3 class="opp-title">لا توجد فرص حالياً</h3>
          <p class="opp-desc">ابدئي بإضافة فرصة تدريب جديدة لشركتك.</p>
        </div>
      </div>
    @endforelse
  </section>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchInput");
  const statusFilter = document.getElementById("statusFilter");
  const sortFilter = document.getElementById("sortFilter");
  const oppsGrid = document.getElementById("oppsGrid");

  function filterAndSort() {
    const cards = Array.from(document.querySelectorAll(".opp-card"));
    const searchValue = searchInput.value.trim().toLowerCase();
    const statusValue = statusFilter.value;
    const sortValue = sortFilter.value;

    cards.forEach(card => {
      const titleElement = card.querySelector(".opp-title");
      const descElement = card.querySelector(".opp-desc");

      if (!titleElement || !descElement) return;

      const title = titleElement.textContent.toLowerCase();
      const desc = descElement.textContent.toLowerCase();
      const cardStatus = card.getAttribute("data-status");

      const matchesSearch = title.includes(searchValue) || desc.includes(searchValue);
      const matchesStatus = (statusValue === "all") || (cardStatus === statusValue);

      card.style.display = (matchesSearch && matchesStatus) ? "block" : "none";
    });

    const visibleCards = cards.filter(c => c.style.display !== "none");

    visibleCards.sort((a, b) => {
      const dateA = new Date(a.getAttribute("data-date"));
      const dateB = new Date(b.getAttribute("data-date"));
      return sortValue === "new" ? dateB - dateA : dateA - dateB;
    });

    visibleCards.forEach(card => oppsGrid.appendChild(card));
  }

  if (searchInput) searchInput.addEventListener("input", filterAndSort);
  if (statusFilter) statusFilter.addEventListener("change", filterAndSort);
  if (sortFilter) sortFilter.addEventListener("change", filterAndSort);
});
</script>
@endsection
