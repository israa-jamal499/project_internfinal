@extends('cms.supervisor.parent')
@section('title','trashed students')
@section('main-title','سلة محذوفات الطلاب')

@section('css')
<link rel="stylesheet" href="{{ asset('internship/css/admin.css') }}">
@endsection

@section('content')
<main class="page">
    <div class="page-head">
        <div class="page-title">
            <p>استرجاع أو حذف الطلاب نهائيًا.</p>
        </div>

        <div class="page-actions">
            <a href="{{ route('cms.supervisor.students.index') }}" class="btn btn-outline">رجوع</a>
            <button type="button" class="btn btn-primary"
                    onclick="confirmDestroy('{{ route('cms.supervisor.students.forceAll') }}', this)">
                حذف الكل نهائيًا
            </button>
        </div>
    </div>

    <section class="card">
        <div class="card-head">
            <h2>الطلاب المحذوفون</h2>
            <div class="hint">قائمة الطلاب المحذوفين</div>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الرقم الجامعي</th>
                        <th>البريد</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td class="fw">{{ $student->full_name }}</td>
                            <td>{{ $student->university_number }}</td>
                            <td>{{ $student->user->email ?? '-' }}</td>
                            <td>{{ $student->general_status }}</td>
                            <td class="actions">
                                <button type="button" class="icon-btn"
                                    onclick="performRestore('{{ route('cms.supervisor.students.restore', $student->id) }}')">
                                    ♻️
                                </button>

                                <button type="button" class="icon-btn"
                                    onclick="confirmDestroy('{{ route('cms.supervisor.students.force', $student->id) }}', this)">
                                    🗑
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا توجد بيانات محذوفة</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
function performRestore(url) {
    axios.post(url)
        .then(function () {
            location.reload();
        })
        .catch(function (error) {
            console.log(error.response);
        });
}
</script>
@endsection
