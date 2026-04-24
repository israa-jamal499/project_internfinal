@extends('cms.admin.temp')
@section('title','Show Certificate')
@section('main-title','عرض / إصدار الشهادة')

@section('content')
<div class="card p-4">

    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3"><strong>الطالب:</strong> {{ $internship->student->full_name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الشركة:</strong> {{ $internship->company->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الفرصة:</strong> {{ $internship->opportunity->title ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>حالة التدريب:</strong> {{ $internship->status }}</div>
        <div class="col-md-6 mb-3"><strong>الساعات المطلوبة:</strong> {{ $internship->required_hours }}</div>
        <div class="col-md-6 mb-3"><strong>الساعات المنجزة:</strong> {{ $internship->completed_hours }}</div>
    </div>

    @if($internship->certificate && $internship->certificate->is_issued)
        <div class="alert alert-success">
            <strong>رقم الشهادة:</strong> {{ $internship->certificate->certificate_number }} <br>
            <strong>تاريخ الإصدار:</strong> {{ $internship->certificate->issue_date ? $internship->certificate->issue_date->format('Y-m-d') : '-' }} <br>
            <strong>ملاحظات:</strong> {{ $internship->certificate->notes ?? '-' }}
        </div>
    @endif

    <form id="create_form">
        <input type="hidden" id="internships_id" value="{{ $internship->id }}">

        <div class="form-group mb-3">
            <label>تاريخ الإصدار</label>
            <input type="date" id="issue_date" class="form-control"
                   value="{{ $internship->certificate?->issue_date ? $internship->certificate->issue_date->format('Y-m-d') : date('Y-m-d') }}">
        </div>

        <div class="form-group mb-3">
            <label>ملاحظات</label>
            <textarea id="notes" class="form-control" rows="4">{{ $internship->certificate?->notes }}</textarea>
        </div>

        <div class="mt-3">
            <button type="button" onclick="performStore()" class="btn btn-primary">إصدار / تحديث الشهادة</button>
            <a href="{{ route('admin.admin.certificates.index') }}" class="btn btn-light">رجوع</a>
        </div>
    </form>
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
