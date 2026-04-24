@extends('cms.company.temp')
@section('title','application')
@section('main-title','عرض الطلب')

@section('content')
<div class="card p-4">

    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3"><strong>اسم الطالب:</strong> {{ $application->student->full_name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>البريد الإلكتروني:</strong> {{ $application->student->user->email ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>رقم الجوال:</strong> {{ $application->student->phone ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>المدينة:</strong> {{ $application->student->city->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الكلية:</strong> {{ $application->student->college->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>التخصص:</strong> {{ $application->student->specialization->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الفرصة:</strong> {{ $application->opportunity->title ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>مدينة الفرصة:</strong> {{ $application->opportunity->city->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>الحالة الحالية:</strong> {{ $application->status }}</div>
        <div class="col-md-6 mb-3"><strong>تاريخ التقديم:</strong> {{ $application->created_at->format('Y-m-d') }}</div>

        <div class="col-md-12 mb-3">
            <strong>رسالة التقديم:</strong>
            <div class="border rounded p-3 mt-2">
                {{ $application->cover_letter ?? '-' }}
            </div>
        </div>
    </div>

    <hr>

    <form id="create_form">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label>تحديث الحالة</label>
                <select id="status" class="form-control">
                    <option value="قيد المراجعة" {{ $application->status == 'قيد المراجعة' ? 'selected' : '' }}>قيد المراجعة</option>
                    <option value="مقبول" {{ $application->status == 'مقبول' ? 'selected' : '' }}>مقبول</option>
                    <option value="مرفوض" {{ $application->status == 'مرفوض' ? 'selected' : '' }}>مرفوض</option>
                </select>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>ملاحظات</label>
                <textarea id="admin_notes" class="form-control" rows="4">{{ $application->admin_notes }}</textarea>
            </div>
        </div>
    </form>

    <div class="mt-3">
        <button type="button" onclick="performUpdate()" class="btn btn-primary">حفظ التحديث</button>
        <a href="{{ route('applications.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate() {
        let data = {
            status: document.getElementById('status').value,
            admin_notes: document.getElementById('admin_notes').value,
        };

        update('{{ route('applications.update', $application->id) }}', data, '{{ route('applications.index') }}');
    }
</script>
@endsection
