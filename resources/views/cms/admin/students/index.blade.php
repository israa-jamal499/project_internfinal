@extends('cms.admin.temp')
@section('title' ,'students')
@section('main-title','ادارة الطلاب')

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
            <p>عرض، بحث، فلترة، ومتابعة بيانات الطلاب.</p>
        </div>

        <div class="page-actions">
            <a href="{{ route('admin.students.trashed') }}" class="btn btn-outline">سلة المحذوفات</a>
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">+ إضافة طالب</a>
        </div>
    </div>

    <section class="card">
        <div class="card-head">
            <h2>الطلاب</h2>
            <div class="hint">استخدمي البحث والفلترة للوصول بسرعة</div>
        </div>

        <div class="tools-row">
            <div class="tool">
                <label for="searchInput">بحث</label>
                <input id="searchInput" type="text" placeholder="ابحث بالاسم أو الرقم الجامعي أو الإيميل..." />
            </div>

            <div class="tool">
                <label for="departmentFilter">التخصص</label>
                <select id="departmentFilter">
                    <option value="all">الكل</option>
                    @foreach($students->pluck('specialization.name')->filter()->unique() as $specializationName)
                        <option value="{{ $specializationName }}">{{ $specializationName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="tool">
                <label for="statusFilter">الحالة</label>
                <select id="statusFilter">
                    <option value="all">الكل</option>
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                    <option value="graduated">graduated</option>
                    <option value="suspended">suspended</option>
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
            <table class="table" id="studentsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الرقم الجامعي</th>
                        <th>التخصص</th>
                        <th>البريد</th>
                        <th>الحالة</th>
                        <th>الكلية</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr
                            data-name="{{ $student->full_name }}"
                            data-id="{{ $student->university_number }}"
                            data-dept="{{ $student->specialization->name ?? '-' }}"
                            data-email="{{ $student->user->email ?? '-' }}"
                            data-status="{{ $student->general_status }}"
                        >
                            <td>{{ $student->id }}</td>
                            <td class="fw">{{ $student->full_name }}</td>
                            <td>{{ $student->university_number }}</td>
                            <td>{{ $student->specialization->name ?? '-' }}</td>
                            <td>{{ $student->user->email ?? '-' }}</td>
                            <td>{{ $student->general_status }}</td>
                            <td>{{ $student->college->name ?? '-' }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.students.show', $student->id) }}" class="icon-btn" title="عرض">👁</a>
                                <a href="{{ route('admin.students.edit', $student->id) }}" class="icon-btn" title="تعديل">✏️</a>
                                <button type="button" class="icon-btn" title="حذف"
                                        onclick="confirmDestroy('{{ route('admin.students.destroy', $student->id) }}', this)">
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

        {{-- <div class="mt-3">
            {{ $students->links() }}
        </div> --}}
    </section>
</main>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const departmentFilter = document.getElementById('departmentFilter');
    const statusFilter = document.getElementById('statusFilter');
    const resetBtn = document.getElementById('resetBtn');
    const shownCount = document.getElementById('shownCount');
    const allCount = document.getElementById('allCount');
    const rows = document.querySelectorAll('#studentsTable tbody tr');

    function filterRows() {
        let shown = 0;

        rows.forEach(row => {
            const name = row.dataset.name ? row.dataset.name.toLowerCase() : '';
            const id = row.dataset.id ? row.dataset.id.toLowerCase() : '';
            const dept = row.dataset.dept || '';
            const email = row.dataset.email ? row.dataset.email.toLowerCase() : '';
            const status = row.dataset.status || '';

            const search = searchInput.value.toLowerCase();
            const deptValue = departmentFilter.value;
            const statusValue = statusFilter.value;

            const matchesSearch = name.includes(search) || id.includes(search) || email.includes(search);
            const matchesDept = deptValue === 'all' || dept === deptValue;
            const matchesStatus = statusValue === 'all' || status === statusValue;

            const visible = matchesSearch && matchesDept && matchesStatus;
            row.style.display = visible ? '' : 'none';

            if (visible) {
                shown++;
            }
        });

        shownCount.textContent = shown;
        allCount.textContent = rows.length;
    }

    searchInput.addEventListener('input', filterRows);
    departmentFilter.addEventListener('change', filterRows);
    statusFilter.addEventListener('change', filterRows);

    resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        departmentFilter.value = 'all';
        statusFilter.value = 'all';
        filterRows();
    });

    filterRows();
</script>
@endsection
