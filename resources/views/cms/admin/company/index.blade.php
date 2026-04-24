@extends('cms.admin.temp')
@section('title' ,'companies')
@section('main-title','ادارة الشركات')

@section('css')
<style>
.active {
    background: #ffffff20;
    border-right: 4px solid #00c0ff;
}
</style>
@endsection

@section('content')
<main class="page">
    <div class="page-head">
        <div class="page-title">
            <p>عرض، بحث، فلترة، ومتابعة بيانات الشركات.</p>
        </div>

        <div class="page-actions">
            <a href="{{ route('admin.companies.trashed') }}" class="btn btn-outline">سلة المحذوفات</a>
            <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">+ إضافة شركة</a>
        </div>
    </div>

    <section class="card">
        <div class="card-head">
            <h2>الشركات</h2>
            <div class="hint">استخدمي البحث والفلترة للوصول بسرعة</div>
        </div>

        <div class="tools-row">
            <div class="tool">
                <label for="searchInput">بحث</label>
                <input id="searchInput" type="text" placeholder="ابحث باسم الشركة أو الإيميل..." />
            </div>

            <div class="tool">
                <label for="statusFilter">الحالة</label>
                <select id="statusFilter">
                    <option value="all">الكل</option>
                    <option value="pending">pending</option>
                    <option value="approved">approved</option>
                    <option value="rejected">rejected</option>
                    <option value="inactive">inactive</option>
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
            <table class="table" id="companiesTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الشركة</th>
                        <th>البريد</th>
                        <th>الهاتف</th>
                        <th>المدينة</th>
                        <th>المجال</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)
                        <tr
                            data-name="{{ $company->name }}"
                            data-email="{{ $company->user->email ?? '-' }}"
                            data-status="{{ $company->status }}"
                        >
                            <td>{{ $company->id }}</td>
                            <td class="fw">{{ $company->name }}</td>
                            <td>{{ $company->user->email ?? '-' }}</td>
                            <td>{{ $company->phone ?? '-' }}</td>
                            <td>{{ $company->city->name ?? '-' }}</td>
                            <td>{{ $company->field_name ?? '-' }}</td>
                            <td>{{ $company->status }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.companies.show', $company->id) }}" class="icon-btn" title="عرض">👁</a>
                                <a href="{{ route('admin.companies.edit', $company->id) }}" class="icon-btn" title="تعديل">✏️</a>
                                <button type="button" class="icon-btn" title="حذف"
                                        onclick="confirmDestroy('{{ route('admin.companies.destroy', $company->id) }}', this)">
                                    🗑
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $companies->links() }}
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const resetBtn = document.getElementById('resetBtn');
    const shownCount = document.getElementById('shownCount');
    const allCount = document.getElementById('allCount');
    const rows = document.querySelectorAll('#companiesTable tbody tr');

    function filterRows() {
        let shown = 0;

        rows.forEach(row => {
            const name = row.dataset.name ? row.dataset.name.toLowerCase() : '';
            const email = row.dataset.email ? row.dataset.email.toLowerCase() : '';
            const status = row.dataset.status || '';

            const search = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            const matchesSearch = name.includes(search) || email.includes(search);
            const matchesStatus = statusValue === 'all' || status === statusValue;

            const visible = matchesSearch && matchesStatus;
            row.style.display = visible ? '' : 'none';

            if (visible) {
                shown++;
            }
        });

        shownCount.textContent = shown;
        allCount.textContent = rows.length;
    }

    searchInput.addEventListener('input', filterRows);
    statusFilter.addEventListener('change', filterRows);

    resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        statusFilter.value = 'all';
        filterRows();
    });

    filterRows();
</script>
@endsection
