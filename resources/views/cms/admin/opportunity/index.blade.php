@extends('cms.admin.temp')

@section('title','opportunities')
@section('main-title','ادارة الفرص')

@section('styles')
@endsection

@section('content')
<main class="page" data-page="opportunities">

    <div class="page-head">
        <div class="page-title">
            <p>إضافة فرص تدريب، البحث والفلترة، إدارة الحالة وعدد المقاعد.</p>
        </div>

        <div class="page-actions">
            <a href="{{ route('admin.opportunities.trashed') }}" class="btn btn-outline">سلة المحذوفات</a>
            <a href="{{ route('admin.opportunities.create') }}" class="btn btn-primary">+ إضافة فرصة</a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $opportunities->total() }}</h3>
                            <p>اجمالي الفرص</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">عدد الفرص المضافة في النظام <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ \App\Models\Opportunity::where('status', 'مفتوحة')->count() }}</h3>
                            <p>مفتوحة</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">يمكن للطلاب التقديم عليها <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ \App\Models\Opportunity::where('status', 'مسودة')->count() }}</h3>
                            <p>مسودة</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">بحاجة مراجعة أو إكمال <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ \App\Models\Opportunity::where('status', 'مغلقة')->count() }}</h3>
                            <p>مغلقة</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">تم اغلاق التقديم عليها <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="card">
        <div class="card-head">
            <h2>الفرص</h2>
            <div class="hint">بحث/فلترة ثم إدارة الفرصة من الإجراءات</div>
        </div>

        <div class="tools-row">
            <div class="tool">
                <label for="searchInput">بحث</label>
                <input id="searchInput" type="text" placeholder="ابحث بعنوان الفرصة أو اسم الشركة أو المدينة..." />
            </div>

            <div class="tool">
                <label for="typeFilter">نوع التدريب</label>
                <select id="typeFilter">
                    <option value="all">الكل</option>
                    <option value="حضوري">حضوري</option>
                    <option value="عن بعد">عن بعد</option>
                    <option value="هجين">هجين</option>
                </select>
            </div>

            <div class="tool">
                <label for="statusFilter">الحالة</label>
                <select id="statusFilter">
                    <option value="all">الكل</option>
                    <option value="مفتوحة">مفتوحة</option>
                    <option value="مغلقة">مغلقة</option>
                    <option value="مسودة">مسودة</option>
                </select>
            </div>

            <div class="tool tool-inline">
                <button class="btn btn-light" id="resetBtn">إعادة تعيين</button>
                <div class="count-pill">
                    المعروض: <span id="shownCount">0</span> / <span id="allCount">0</span>
                </div>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table" id="oppsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان الفرصة</th>
                        <th>الشركة</th>
                        <th>النوع</th>
                        <th>المدينة</th>
                        <th>المقاعد</th>
                        <th>آخر موعد</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($opportunities as $opportunity)
                        <tr
                            data-title="{{ $opportunity->title }}"
                            data-company="{{ $opportunity->company->name ?? '-' }}"
                            data-type="{{ $opportunity->type }}"
                            data-city="{{ $opportunity->city->name ?? '-' }}"
                            data-status="{{ $opportunity->status }}"
                        >
                            <td>{{ $opportunity->id }}</td>
                            <td class="fw">{{ $opportunity->title }}</td>
                            <td>{{ $opportunity->company->name ?? '-' }}</td>
                            <td>{{ $opportunity->type }}</td>
                            <td>{{ $opportunity->city->name ?? '-' }}</td>
                            <td>{{ $opportunity->filled_seats }}/{{ $opportunity->seats }}</td>
                            <td>{{ $opportunity->deadline }}</td>
                            <td>{{ $opportunity->status }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.opportunities.show', $opportunity->id) }}" class="icon-btn" title="عرض">👁</a>
                                <a href="{{ route('admin.opportunities.edit', $opportunity->id) }}" class="icon-btn" title="تعديل">✏️</a>
                                <button type="button" class="icon-btn" title="حذف"
                                        onclick="confirmDestroy('{{ route('admin.opportunities.destroy', $opportunity->id) }}', this)">
                                    🗑
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $opportunities->links() }}
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const resetBtn = document.getElementById('resetBtn');
    const shownCount = document.getElementById('shownCount');
    const allCount = document.getElementById('allCount');
    const rows = document.querySelectorAll('#oppsTable tbody tr');

    function filterRows() {
        let shown = 0;

        rows.forEach(row => {
            const title = row.dataset.title ? row.dataset.title.toLowerCase() : '';
            const company = row.dataset.company ? row.dataset.company.toLowerCase() : '';
            const city = row.dataset.city ? row.dataset.city.toLowerCase() : '';
            const type = row.dataset.type || '';
            const status = row.dataset.status || '';

            const search = searchInput.value.toLowerCase();
            const typeValue = typeFilter.value;
            const statusValue = statusFilter.value;

            const matchesSearch = title.includes(search) || company.includes(search) || city.includes(search);
            const matchesType = typeValue === 'all' || type === typeValue;
            const matchesStatus = statusValue === 'all' || status === statusValue;

            const visible = matchesSearch && matchesType && matchesStatus;
            row.style.display = visible ? '' : 'none';

            if (visible) {
                shown++;
            }
        });

        shownCount.textContent = shown;
        allCount.textContent = rows.length;
    }

    searchInput.addEventListener('input', filterRows);
    typeFilter.addEventListener('change', filterRows);
    statusFilter.addEventListener('change', filterRows);

    resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        typeFilter.value = 'all';
        statusFilter.value = 'all';
        filterRows();
    });

    filterRows();
</script>
@endsection
