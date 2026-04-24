@extends('cms.supervisor.parent')
@section('title' ,'students')
@section('main-title','ادارة الطلاب')

@section('css')
<style>
.active {
    background: #ffffff20;
    border-right: 4px solid #00c0ff;
}
</style>
<link rel="stylesheet" href="{{ asset('internship/css/admin.css') }}">
@endsection

@section('content')
<main class="page">
    <div class="page-head">
        <div class="page-title">
            <p>عرض، بحث، فلترة، ومتابعة بيانات الطلاب.</p>
        </div>

        <div class="page-actions">
            <!-- أهم تعديل هون -->
            <a href="{{ route('cms.supervisor.students.trashed') }}" class="btn btn-outline">سلة المحذوفات</a>
            <a href="{{ route('cms.supervisor.students.create') }}" class="btn btn-primary">+ إضافة طالب</a>
        </div>
    </div>

    <section class="card">
        <div class="card-head">
            <h2>الطلاب</h2>
            <div class="hint">استخدمي البحث والفلترة للوصول بسرعة</div>
        </div>

        <div class="tools-row">
            <div class="tool">
                <label>بحث</label>
                <input id="searchInput" type="text" placeholder="ابحث بالاسم أو الرقم الجامعي أو الإيميل..." />
            </div>

            <div class="tool">
                <label>التخصص</label>
                <select id="departmentFilter">
                    <option value="all">الكل</option>
                    @foreach($students->pluck('specialization.name')->filter()->unique() as $specializationName)
                        <option value="{{ $specializationName }}">{{ $specializationName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="tool">
                <label>الحالة</label>
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
                                <!-- أهم تعديل هون -->
                                <a href="{{ route('cms.supervisor.students.show', $student->id) }}" class="icon-btn">👁</a>
                                <a href="{{ route('cms.supervisor.students.edit', $student->id) }}" class="icon-btn">✏️</a>

                                <button type="button" class="icon-btn"
                                    onclick="confirmDestroy('{{ route('cms.supervisor.students.destroy', $student->id) }}', this)">
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
            {{ $students->links() }}
        </div>
    </section>
</main>
@endsection
