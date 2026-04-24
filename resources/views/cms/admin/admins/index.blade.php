@extends('cms.admin.temp')
@section('title' ,'admins')
@section('main-title','إدارة الأدمن')

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
            <p>عرض، بحث، ومتابعة بيانات الأدمن.</p>
        </div>

        <div class="page-actions">

            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">+ إضافة أدمن</a>
        </div>
    </div>

    <section class="card">
        <div class="card-head">
            <h2>الأدمن</h2>
            <div class="hint">استخدمي البحث للوصول بسرعة</div>
        </div>

        <div class="tools-row">
            <div class="tool">
                <label for="searchInput">بحث</label>
                <input id="searchInput" type="text" placeholder="ابحث بالاسم أو الإيميل أو الهاتف..." />
            </div>

            <div class="tool tool-inline">
                <button class="btn btn-light" id="resetBtn">إعادة تعيين</button>
                <div class="count-pill">
                    المعروض: <span id="shownCount">0</span> / <span id="allCount">0</span>
                </div>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table" id="adminsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد</th>
                        <th>الهاتف</th>
                        <th>العنوان</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr
                            data-name="{{ $admin->name }}"
                            data-email="{{ $admin->user->email ?? '-' }}"
                            data-phone="{{ $admin->phone ?? '-' }}"
                        >
                            <td>{{ $admin->id }}</td>
                            <td class="fw">{{ $admin->name }}</td>
                            <td>{{ $admin->user->email ?? '-' }}</td>
                            <td>{{ $admin->phone ?? '-' }}</td>
                            <td>{{ $admin->address ?? '-' }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.admins.show', $admin->id) }}" class="icon-btn" title="عرض">👁</a>
                                <a href="{{ route('admin.admins.edit', $admin->id) }}" class="icon-btn" title="تعديل">✏️</a>
                                <button type="button" class="icon-btn" title="حذف"
        onclick="confirmDestroy('{{ route('admin.admins.destroy', $admin->id) }}', this)">
    🗑
</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $admins->links() }}
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const resetBtn = document.getElementById('resetBtn');
    const shownCount = document.getElementById('shownCount');
    const allCount = document.getElementById('allCount');
    const rows = document.querySelectorAll('#adminsTable tbody tr');

    function filterRows() {
        let shown = 0;

        rows.forEach(row => {
            const name = row.dataset.name ? row.dataset.name.toLowerCase() : '';
            const email = row.dataset.email ? row.dataset.email.toLowerCase() : '';
            const phone = row.dataset.phone ? row.dataset.phone.toLowerCase() : '';
            const search = searchInput.value.toLowerCase();

            const matchesSearch =
                name.includes(search) ||
                email.includes(search) ||
                phone.includes(search);

            row.style.display = matchesSearch ? '' : 'none';

            if (matchesSearch) {
                shown++;
            }
        });

        shownCount.textContent = shown;
        allCount.textContent = rows.length;
    }

    searchInput.addEventListener('input', filterRows);

    resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        filterRows();
    });

    filterRows();
</script>
@endsection
