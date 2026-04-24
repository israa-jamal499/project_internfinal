@extends('cms.admin.temp')
@section('title','Certificates')
@section('main-title','إدارة الشهادات')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">الشهادات</h4>
    </div>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>الطالب</th>
                <th>الشركة</th>
                <th>الفرصة</th>
                <th>حالة التدريب</th>
                <th>الساعات</th>
                <th>الشهادة</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            @forelse($internships as $internship)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $internship->student->full_name ?? '-' }}</td>
                    <td>{{ $internship->company->name ?? '-' }}</td>
                    <td>{{ $internship->opportunity->title ?? '-' }}</td>
                    <td>{{ $internship->status }}</td>
                    <td>{{ $internship->completed_hours }}/{{ $internship->required_hours }}</td>
                    <td>
                        @if($internship->certificate && $internship->certificate->is_issued)
                            <span class="badge badge-success">تم الإصدار</span>
                        @else
                            <span class="badge badge-warning">غير صادرة</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.admin.certificates.show', $internship->id) }}" class="btn btn-primary btn-sm">عرض</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">لا توجد بيانات</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $internships->links() }}
    </div>
</div>
@endsection
@section('scripts')
<script>
    function performStore() {
        let data = {
            internships_id: document.getElementById('internships_id').value,
            issue_date: document.getElementById('issue_date').value,
            notes: document.getElementById('notes').value,
        };

        store('/cms/admin/certificates/store', data);
    }
</script>
@endsection
