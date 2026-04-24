@extends('cms.admin.temp')
@section('title', 'Trashed Companies')
@section('main-title', 'سلة محذوفات الشركات')

@section('content')
<div class="card p-4">

    <div class="mb-3">
        <a href="{{ route('admin.companies.index') }}" class="btn btn-primary">العودة للشركات</a>

        <button type="button" class="btn btn-danger"
                onclick="updatePage('{{ route('admin.companies.forceAll') }}', {})">
            حذف الكل نهائياً
        </button>
    </div>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الشركة</th>
                <th>الإيميل</th>
                <th>الهاتف</th>
                <th>المدينة</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($companies as $company)
                <tr>
                    <td>{{ $company->id }}</td>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->user->email ?? '-' }}</td>
                    <td>{{ $company->phone ?? '-' }}</td>
                    <td>{{ $company->city->name ?? '-' }}</td>
                    <td>{{ $company->status }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm"
                                onclick="updatePage('{{ route('admin.companies.restore', $company->id) }}', {})">
                            استعادة
                        </button>

                        <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDestroy('{{ route('admin.companies.force', $company->id) }}', this)">
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
