@extends('cms.admin.temp')
@section('title', 'Create Company')
@section('main-title', 'إضافة شركة')

@section('content')
<div class="card p-4">

    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <form id="create_form">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label>اسم الشركة</label>
                <input type="text" id="name" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>البريد الإلكتروني</label>
                <input type="email" id="email" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>كلمة المرور</label>
                <input type="password" id="password" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>رقم الجوال</label>
                <input type="text" id="phone" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الموقع الإلكتروني</label>
                <input type="text" id="website" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الحالة</label>
                <select id="status" class="form-control">
                    <option value="pending">pending</option>
                    <option value="approved">approved</option>
                    <option value="rejected">rejected</option>
                    <option value="inactive">inactive</option>
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>المدينة</label>
                <select id="city_id" class="form-control">
                    <option value="">اختر المدينة</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>مجال العمل</label>
                <input type="text" id="field_name" class="form-control">
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>العنوان</label>
                <input type="text" id="address" class="form-control">
            </div>

            <div class="form-group col-md-12 mb-3">
                <label>الوصف</label>
                <textarea id="description" class="form-control" rows="4"></textarea>
            </div>
        </div>
    </form>

    <div>
        <button type="button" onclick="performStore()" class="btn btn-primary">حفظ</button>
        <a href="{{ route('admin.companies.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performStore() {
        let data = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            phone: document.getElementById('phone').value,
            website: document.getElementById('website').value,
            status: document.getElementById('status').value,
            city_id: document.getElementById('city_id').value,
            field_name: document.getElementById('field_name').value,
            address: document.getElementById('address').value,
            description: document.getElementById('description').value,
        };

        store('{{ route('admin.companies.store') }}', data);
    }
</script>
@endsection
