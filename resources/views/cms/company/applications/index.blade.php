@extends('cms.company.temp')
@section('title','applications')
@section('main-title','طلبات التقديم')

@section('content')
<style>
.company-app-page {
    width: 92%;
    margin: 25px auto 0;
}

.apps-header {
    background: #fff;
    border-radius: 18px;
    padding: 18px;
    border: 1px solid #eef3f6;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
}

.apps-header h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 900;
    color: #222;
}

.apps-header p {
    margin: 8px 0 0;
    font-size: 13px;
    color: #666;
}

.apps-filters {
    margin-top: 16px;
    display: grid;
    grid-template-columns: 1.4fr 1fr;
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
}

.apps-table-wrap {
    margin-top: 16px;
    background: #fff;
    border-radius: 18px;
    border: 1px solid #eef3f6;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.apps-table {
    width: 100%;
    border-collapse: collapse;
}

.apps-table th,
.apps-table td {
    padding: 14px 12px;
    text-align: center;
    border-bottom: 1px solid #eef3f6;
    font-size: 14px;
}

.apps-table th {
    background: #f8fbff;
    font-weight: 900;
    color: #333;
}

.status-chip {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 900;
    display: inline-block;
}

.status-review {
    background: #fff4db;
    border: 1px solid #ffe2a8;
    color: #9a6700;
}

.status-accepted {
    background: #e7f8ee;
    border: 1px solid #c8f0d7;
    color: #0a7a36;
}

.status-rejected {
    background: #ffe9e9;
    border: 1px solid #ffd0d0;
    color: #b00000;
}

.btn-outline {
    padding: 8px 12px;
    border-radius: 12px;
    border: 1px solid #dfe7ef;
    background: #fff;
    font-size: 13px;
    font-weight: 900;
    text-decoration: none;
    color: #3e7cd7;
    display: inline-block;
}

.empty-box {
    padding: 30px;
    text-align: center;
    color: #777;
}

@media (max-width: 900px) {
    .apps-filters {
        grid-template-columns: 1fr;
    }

    .apps-table-wrap {
        overflow-x: auto;
    }
}
</style>

<main class="company-app-page">
    <section class="apps-header">
        <h2>📄 طلبات التقديم على فرص الشركة</h2>
        <p>عرض الطلبات الواردة على فرص التدريب الخاصة بشركتك ومتابعة حالتها.</p>
    </section>

    <section class="apps-filters">
        <div class="filter-box">
            <label>🔍 بحث</label>
            <input type="text" id="searchInput" placeholder="ابحث باسم الطالب أو عنوان الفرصة..." />
        </div>

        <div class="filter-box">
            <label>📂 الحالة</label>
            <select id="statusFilter">
                <option value="all">الكل</option>
                <option value="قيد المراجعة">قيد المراجعة</option>
                <option value="مقبول">مقبول</option>
                <option value="مرفوض">مرفوض</option>
            </select>
        </div>
    </section>

    <section class="apps-table-wrap">
        @if($applications->count() > 0)
            <table class="apps-table" id="applicationsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الطالب</th>
                        <th>الفرصة</th>
                        <th>التخصص</th>
                        <th>الحالة</th>
                        <th>تاريخ التقديم</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                        <tr
                            data-student="{{ $application->student->full_name ?? '-' }}"
                            data-opportunity="{{ $application->opportunity->title ?? '-' }}"
                            data-status="{{ $application->status }}"
                        >
                            <td>{{ $application->id }}</td>
                            <td>{{ $application->student->full_name ?? '-' }}</td>
                            <td>{{ $application->opportunity->title ?? '-' }}</td>
                            <td>{{ $application->student->specialization->name ?? '-' }}</td>
                            <td>
                                @if($application->status == 'قيد المراجعة')
                                    <span class="status-chip status-review">قيد المراجعة</span>
                                @elseif($application->status == 'مقبول')
                                    <span class="status-chip status-accepted">مقبول</span>
                                @else
                                    <span class="status-chip status-rejected">مرفوض</span>
                                @endif
                            </td>
                            <td>{{ $application->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('applications.show', $application->id) }}" class="btn-outline">👁 عرض</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-box">
                لا توجد طلبات حالياً.
            </div>
        @endif
    </section>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");
    const rows = document.querySelectorAll("#applicationsTable tbody tr");

    function filterRows() {
        const searchValue = searchInput.value.trim().toLowerCase();
        const statusValue = statusFilter.value;

        rows.forEach(row => {
            const student = row.getAttribute("data-student").toLowerCase();
            const opportunity = row.getAttribute("data-opportunity").toLowerCase();
            const status = row.getAttribute("data-status");

            const matchesSearch = student.includes(searchValue) || opportunity.includes(searchValue);
            const matchesStatus = statusValue === "all" || status === statusValue;

            row.style.display = (matchesSearch && matchesStatus) ? "" : "none";
        });
    }

    if (searchInput) searchInput.addEventListener("input", filterRows);
    if (statusFilter) statusFilter.addEventListener("change", filterRows);
});
</script>
@endsection
