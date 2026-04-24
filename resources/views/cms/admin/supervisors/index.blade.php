@extends('cms.admin.temp')
@section('title' ,'supervisors')
@section('main-title','ادارة المشرفين')

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
            <p>عرض، بحث، فلترة، ومتابعة بيانات المشرفين.</p>
        </div>

        <div class="page-actions">

            <a href="{{ route('admin.supervisors.create') }}" class="btn btn-primary">+ إضافة مشرف</a>
        </div>
    </div>

    <section class="card">
        <div class="card-head">
            <h2>المشرفون</h2>
            <div class="hint">استخدمي البحث والفلترة للوصول بسرعة</div>
        </div>

        <div class="tools-row">
            <div class="tool">
                <label for="searchInput">بحث</label>
                <input id="searchInput" type="text" placeholder="ابحث بالاسم أو الإيميل..." />
            </div>

            <div class="tool">
                <label for="collegeFilter">الكلية</label>
                <select id="collegeFilter">
                    <option value="all">الكل</option>
                    @foreach($supervisors->pluck('college.name')->filter()->unique() as $collegeName)
                        <option value="{{ $collegeName }}">{{ $collegeName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="tool">
                <label for="statusFilter">الحالة</label>
                <select id="statusFilter">
                    <option value="all">الكل</option>
                    <option value="active">active</option>
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
            <table class="table" id="supervisorsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد</th>
                        <th>الهاتف</th>
                        <th>المدينة</th>
                        <th>الكلية</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supervisors as $supervisor)
                        <tr
                            data-name="{{ $supervisor->full_name }}"
                            data-email="{{ $supervisor->user->email ?? '-' }}"
                            data-college="{{ $supervisor->college->name ?? '-' }}"
                            data-status="{{ $supervisor->status }}"
                        >
                            <td>{{ $supervisor->id }}</td>
                            <td class="fw">{{ $supervisor->full_name }}</td>
                            <td>{{ $supervisor->user->email ?? '-' }}</td>
                            <td>{{ $supervisor->phone ?? '-' }}</td>
                            <td>{{ $supervisor->city->name ?? '-' }}</td>
                            <td>{{ $supervisor->college->name ?? '-' }}</td>
                            <td>{{ $supervisor->status }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.supervisors.show', $supervisor->id) }}" class="icon-btn" title="عرض">👁</a>
                                <a href="{{ route('admin.supervisors.edit', $supervisor->id) }}" class="icon-btn" title="تعديل">✏️</a>
                                <button type="button" class="icon-btn" title="حذف"
                                        onclick="confirmDestroy('{{ route('admin.supervisors.destroy', $supervisor->id) }}', this)">
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
            {{ $supervisors->links() }}
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const collegeFilter = document.getElementById('collegeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const resetBtn = document.getElementById('resetBtn');
    const shownCount = document.getElementById('shownCount');
    const allCount = document.getElementById('allCount');
    const rows = document.querySelectorAll('#supervisorsTable tbody tr');

    function filterRows() {
        let shown = 0;

        rows.forEach(row => {
            const name = row.dataset.name ? row.dataset.name.toLowerCase() : '';
            const email = row.dataset.email ? row.dataset.email.toLowerCase() : '';
            const college = row.dataset.college || '';
            const status = row.dataset.status || '';

            const search = searchInput.value.toLowerCase();
            const collegeValue = collegeFilter.value;
            const statusValue = statusFilter.value;

            const matchesSearch = name.includes(search) || email.includes(search);
            const matchesCollege = collegeValue === 'all' || college === collegeValue;
            const matchesStatus = statusValue === 'all' || status === statusValue;

            const visible = matchesSearch && matchesCollege && matchesStatus;
            row.style.display = visible ? '' : 'none';

            if (visible) {
                shown++;
            }
        });

        shownCount.textContent = shown;
        allCount.textContent = rows.length;
    }

    searchInput.addEventListener('input', filterRows);
    collegeFilter.addEventListener('change', filterRows);
    statusFilter.addEventListener('change', filterRows);

    resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        collegeFilter.value = 'all';
        statusFilter.value = 'all';
        filterRows();
    });

    filterRows();
</script>
@endsection
