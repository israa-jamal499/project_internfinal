@extends('cms.company.temp')
@section('title', 'Trashed Opportunities')
@section('main-title', 'سلة محذوفات الفرص')

@section('content')
<div class="card p-4">

    <div class="mb-3">
        <a href="{{ route('opportunities.index') }}" class="btn btn-primary">العودة للفرص</a>

        <button type="button" class="btn btn-danger"
                onclick="updatePage('{{ route('opportunities.forceAll') }}', {})">
            حذف الكل نهائياً
        </button>
    </div>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>عنوان الفرصة</th>
                <th>المدينة</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($opportunities as $opportunity)
                <tr>
                    <td>{{ $opportunity->id }}</td>
                    <td>{{ $opportunity->title }}</td>
                    <td>{{ $opportunity->city->name ?? '-' }}</td>
                    <td>{{ $opportunity->status }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm"
                                onclick="updatePage('{{ route('opportunities.restore', $opportunity->id) }}', {})">
                            استعادة
                        </button>

                        <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDestroy('{{ route('opportunities.force', $opportunity->id) }}', this)">
                            حذف نهائي
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">لا توجد بيانات محذوفة</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
