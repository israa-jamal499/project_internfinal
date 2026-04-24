@extends('cms.company.temp')
@section('title', 'Create Opportunity')
@section('main-title', 'إضافة فرصة')

@section('content')
<div class="card p-4">
    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <form id="create_form">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label>عنوان الفرصة</label>
                <input type="text" id="title" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>نوع التدريب</label>
                <select id="type" class="form-control">
                    <option value="حضوري">حضوري</option>
                    <option value="عن بعد">عن بعد</option>
                    <option value="هجين">هجين</option>
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>عدد الساعات المطلوبة</label>
                <input type="number" id="required_hours" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>عدد المقاعد</label>
                <input type="number" id="seats" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>آخر موعد</label>
                <input type="date" id="deadline" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الحالة</label>
                <select id="status" class="form-control">
                    <option value="مفتوحة">مفتوحة</option>
                    <option value="مغلقة">مغلقة</option>
                    <option value="مسودة">مسودة</option>
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>المدينة</label>
                <select id="cities_id" class="form-control">
                    <option value="">اختر المدينة</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>التخصصات</label>
                <select id="specializations" class="form-control" >
                    @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>الوصف</label>
                <textarea id="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>المتطلبات</label>
                <textarea id="requirements" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>الفوائد</label>
                <textarea id="benefits" class="form-control" rows="3"></textarea>
            </div>
        </div>
    </form>

    <div>
        <button type="button" onclick="performStore()" class="btn btn-primary">حفظ</button>
        <a href="{{ route('opportunities.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performStore() {
        let specializations = Array.from(document.getElementById('specializations').selectedOptions).map(option => option.value);

        let data = {
            title: document.getElementById('title').value,
            type: document.getElementById('type').value,
            required_hours: document.getElementById('required_hours').value,
            seats: document.getElementById('seats').value,
            deadline: document.getElementById('deadline').value,
            status: document.getElementById('status').value,
            cities_id: document.getElementById('cities_id').value,
            description: document.getElementById('description').value,
            requirements: document.getElementById('requirements').value,
            benefits: document.getElementById('benefits').value,
            specializations: specializations,
        };

        store('{{ route('opportunities.store') }}', data);
    }
</script>
@endsection
