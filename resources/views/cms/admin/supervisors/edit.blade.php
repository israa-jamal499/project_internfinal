@extends('cms.admin.temp')
@section('title', 'Edit Supervisor')
@section('main-title', 'تعديل المشرف')

@section('content')
<div class="card p-4">

    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <form id="create_form">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label>الاسم الكامل</label>
                <input type="text" id="full_name" class="form-control" value="{{ $supervisor->full_name }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>البريد الإلكتروني</label>
                <input type="email" id="email" class="form-control" value="{{ $supervisor->user->email ?? '' }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>رقم الجوال</label>
                <input type="text" id="phone" class="form-control" value="{{ $supervisor->phone }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الحالة</label>
                <select id="status" class="form-control">
                    <option value="active" {{ $supervisor->status == 'active' ? 'selected' : '' }}>active</option>
                    <option value="inactive" {{ $supervisor->status == 'inactive' ? 'selected' : '' }}>inactive</option>
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>المدينة</label>
                <select id="city_id" class="form-control">
                    <option value="">اختر المدينة</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $supervisor->city_id == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الكلية</label>
                <select id="college_id" class="form-control">
                    <option value="">اختر الكلية</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}" {{ $supervisor->college_id == $college->id ? 'selected' : '' }}>
                            {{ $college->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>ملاحظات</label>
                <textarea id="notes" class="form-control" rows="4">{{ $supervisor->notes }}</textarea>
            </div>
        </div>
    </form>

    <div>
        <button type="button" onclick="performUpdate()" class="btn btn-primary">تحديث</button>
        <a href="{{ route('admin.supervisors.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate() {
        let data = {
            full_name: document.getElementById('full_name').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            status: document.getElementById('status').value,
            city_id: document.getElementById('city_id').value,
            college_id: document.getElementById('college_id').value,
            notes: document.getElementById('notes').value,
        };

        update('{{ route('admin.supervisors.update', $supervisor->id) }}', data, '{{ route('admin.supervisors.index') }}');
    }
</script>
@endsection
