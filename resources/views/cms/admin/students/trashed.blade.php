@extends('cms.admin.temp')
@section('title', 'Trashed Students')
@section('main-title', 'سلة محذوفات الطلاب')

@section('content')
<div class="card p-4">

    <div class="mb-3">
        <a href="{{ route('admin.students.index') }}" class="btn btn-primary">العودة للطلاب</a>

        <button type="button" class="btn btn-danger"
                onclick="updatePage('{{ route('admin.students.forceAll') }}', {})">
            حذف الكل نهائياً
        </button>
    </div>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>الإيميل</th>
                <th>الرقم الجامعي</th>
                <th>الكلية</th>
                <th>التخصص</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->user->email ?? '-' }}</td>
                    <td>{{ $student->university_number }}</td>
                    <td>{{ $student->college->name ?? '-' }}</td>
                    <td>{{ $student->specialization->name ?? '-' }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm"
                                onclick="updatePage('{{ route('admin.students.restore', $student->id) }}', {})">
                            استعادة
                        </button>

                        <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDestroy('{{ route('admin.students.force', $student->id) }}', this)">
                            حذف نهائي
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">لا توجد بيانات محذوفة</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
