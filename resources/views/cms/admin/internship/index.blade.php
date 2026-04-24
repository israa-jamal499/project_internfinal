
@extends('cms.admin.temp')
@section('title' ,'internships')
@section('main-title','ادارة التدريب')

@section('main-title','ادارة التدريب')
@section('css')
@endsection
@section('content')

  <main class="page" data-page="internships">

    <div class="page-head">
      <div class="page-title">

        <p>متابعة تسجيلات التدريب، حالة الطالب، الشركة، المشرف، وتواريخ البداية والنهاية.</p>
      </div>

      <div class="page-actions">
        <a href="{{ route('admin.internships.create') }}" class="btn btn-primary">+ إضافة تدريب</a>
      </div>
    </div>

    <!-- Stats -->
     <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>اجمالي التدريبات</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">عدد سجلات التدريب<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning ">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>قيد التدريب</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">طلاب بدأوا التدريب<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success ">
              <div class="inner">
                <h3>44</h3>

                <p>مكتمل</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">طلاب انهوا التدريب<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>متوقف</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">تدريب موقوف/معلق<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

</section>

    <!-- Tools + Table -->
    <section class="card">
      <div class="card-head">
        <h2>سجلات التدريب</h2>
        <div class="hint">بحث/فلترة ثم إدارة السجل من الإجراءات</div>
      </div>

      <div class="tools-row">
        <div class="tool">
          <label for="searchInput">بحث</label>
          <input id="searchInput" type="text" placeholder="ابحث باسم الطالب أو الشركة أو المشرف..." />
        </div>

        <div class="tool">
          <label for="statusFilter">الحالة</label>
          <select id="statusFilter">
            <option value="all">الكل</option>
            <option value="قيد التدريب">قيد التدريب</option>
            <option value="مكتمل">مكتمل</option>
            <option value="متوقف">متوقف</option>
          </select>
        </div>

        <div class="tool">
                <label for="collegeFilter">الكلية</label>
                <select id="collegeFilter">
                    <option value="all">الكل</option>
                    @foreach($internships->pluck('internship.name')->filter()->unique() as $internshipName)
                        <option value="{{ $internshipName }}">{{ $internshipName }}</option>
                    @endforeach
                </select>
            </div>

        <div class="tool tool-inline">
          <button class="btn btn-light" data-action="reset">إعادة تعيين</button>
          <div class="count-pill">
            المعروض: <span data-count="shown">0</span> / <span data-count="all">0</span>
          </div>
        </div>
      </div>

      <div class="table-wrap">
        <table class="table" id="internshipsTable">
          <thead>
            <tr>
              <th>#</th>
              <th>الطالب</th>
              <th>القسم</th>
              <th>الشركة</th>
              <th>المشرف</th>
              <th>البداية</th>
              <th>النهاية</th>
              <th>الحالة</th>
              <th>إجراءات</th>
            </tr>
          </thead>

        <tbody>
@forelse($internships as $internship)
    <tr
        data-student="{{ $internship->student->full_name ?? '-' }}"
        data-dept="{{ $internship->student->specialization->name ?? '-' }}"
        data-company="{{ $internship->company->name ?? '-' }}"
        data-supervisor="{{ $internship->supervisor->full_name ?? '-' }}"
        data-start="{{ $internship->start_date ?? '-' }}"
        data-end="{{ $internship->end_date ?? '-' }}"
        data-status="{{ $internship->status }}"
        data-notes="{{ $internship->notes ?? '-' }}"
    >
        <td>{{ $loop->iteration }}</td>
        <td class="fw">{{ $internship->student->full_name ?? '-' }}</td>
        <td>{{ $internship->student->specialization->name ?? '-' }}</td>
        <td>{{ $internship->company->name ?? '-' }}</td>
        <td>{{ $internship->supervisor->full_name ?? '-' }}</td>
        <td>{{ $internship->start_date ?? '-' }}</td>
        <td>{{ $internship->end_date ?? '-' }}</td>
        <td>
            @if($internship->status == 'قيد التدريب')
                <span class="chip chip-success">قيد التدريب</span>
            @elseif($internship->status == 'مكتمل')
                <span class="chip chip-info">مكتمل</span>
            @else
                <span class="chip chip-warning">متوقف</span>
            @endif
        </td>
        <td class="actions">
            <a href="{{ route('admin.internships.show', $internship->id) }}" class="icon-btn">👁</a>
            <a href="{{ route('admin.internships.edit', $internship->id) }}" class="icon-btn">✏️</a>
            <button type="button" class="icon-btn" onclick="performDestroy({{ $internship->id }}, this)">🗑</button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center">لا توجد سجلات تدريب</td>
    </tr>
@endforelse
</tbody>
        </table>
      </div>

     <div class="mt-3">
    {{ $internships->links() }}
</div>
    </section>
  </main>







@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", () => {
  const page = document.querySelector('main[data-page="internships"]');
  if (!page) return;

  const table = document.getElementById("internshipsTable");
  if (!table) return;

  // Helpers
  const $ = (sel, root = document) => root.querySelector(sel);
  const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));
  const norm = (s) => (s ?? "").toString().trim().toLowerCase();

  function openModal(modal) { modal?.classList.add("open"); }
  function closeModal(modal) { modal?.classList.remove("open"); }

  const tbody = table.querySelector("tbody");

  // Tools
  const searchInput = $("#searchInput");
  const statusFilter = $("#statusFilter");
  const deptFilter = $("#deptFilter");

  // Counts
  const allCountEl = $('[data-count="all"]');
  const shownCountEl = $('[data-count="shown"]');

  // Stats
  const statTotal = $('[data-stat="total"]');
  const statActive = $('[data-stat="active"]');
  const statDone = $('[data-stat="done"]');
  const statStopped = $('[data-stat="stopped"]');

  // Modals
  const viewModal = $("#viewModal");
  const formModal = $("#formModal");
  const formTitle = $('[data-form-title]');

  // Form inputs
  const iStudent = $("#iStudent");
  const iDept = $("#iDept");
  const iCompany = $("#iCompany");
  const iSupervisor = $("#iSupervisor");
  const iStart = $("#iStart");
  const iEnd = $("#iEnd");
  const iStatus = $("#iStatus");
  const iNotes = $("#iNotes");

  let editingRow = null;

  function rows() {
    return $$("#internshipsTable tbody tr");
  }



  function matches(tr) {
    const q = norm(searchInput?.value);
    const status = statusFilter?.value || "all";
    const dept = deptFilter?.value || "all";

    const student = norm(tr.dataset.student);
    const company = norm(tr.dataset.company);
    const supervisor = norm(tr.dataset.supervisor);

    const okSearch = !q || student.includes(q) || company.includes(q) || supervisor.includes(q);
    const okStatus = status === "all" || tr.dataset.status === status;
    const okDept = dept === "all" || tr.dataset.dept === dept;

    return okSearch && okStatus && okDept;
  }

  // ===== Pagination =====
  let currentPage = 1;
  const rowsPerPage = 6;

  const prevBtn = $('[data-action="prev"]');
  const nextBtn = $('[data-action="next"]');
  const pageBtns = $$("[data-pagebtn]");

  function visibleRows() {
    return rows().filter(tr => tr.style.display !== "none");
  }

  function renderPage(pageNum) {
    const vis = visibleRows();
    const totalPages = Math.max(1, Math.ceil(vis.length / rowsPerPage));

    currentPage = Math.min(Math.max(1, pageNum), totalPages);

    vis.forEach(tr => (tr.hidden = true));
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    vis.slice(start, end).forEach(tr => (tr.hidden = false));

    pageBtns.forEach((b, i) => b.classList.toggle("active", i + 1 === currentPage));
    if (prevBtn) prevBtn.disabled = currentPage === 1;
    if (nextBtn) nextBtn.disabled = currentPage === totalPages;
  }

  function applyFilters() {
    let shown = 0;
    rows().forEach(tr => {
      const ok = matches(tr);
      tr.style.display = ok ? "" : "none";
      if (ok) shown++;
    });
    shownCountEl.textContent = shown;
    renderPage(1);
  }

  // Listeners
  searchInput?.addEventListener("input", applyFilters);
  statusFilter?.addEventListener("change", applyFilters);
  deptFilter?.addEventListener("change", applyFilters);

  // Reset
  $('[data-action="reset"]')?.addEventListener("click", () => {
    if (searchInput) searchInput.value = "";
    if (statusFilter) statusFilter.value = "all";
    if (deptFilter) deptFilter.value = "all";
    applyFilters();
  });



  });



  // Pagination events
  pageBtns.forEach(btn => btn.addEventListener("click", () => renderPage(Number(btn.dataset.pagebtn))));
  prevBtn?.addEventListener("click", () => renderPage(currentPage - 1));
  nextBtn?.addEventListener("click", () => renderPage(currentPage + 1));

  // Init
  updateStats();
  applyFilters();
  renderPage(1);

</script>

<script>
    function performDestroy(id, reference) {
        confirmDestroy('/cms/admin/internships/' + id, reference);
    }
</script>
@endsection

