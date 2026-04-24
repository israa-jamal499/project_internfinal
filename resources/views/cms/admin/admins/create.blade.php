@extends('cms.admin.temp')
@section('title', 'Create Admin')
@section('main-title', 'إضافة أدمن')

@section('content')
<div class="card p-4">

    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <form id="create_form">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label>الاسم</label>
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
                <label>تأكيد كلمة المرور</label>
                <input type="password" id="password_confirmation" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>رقم الهاتف</label>
                <input type="text" id="phone" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>العنوان</label>
                <input type="text" id="address" class="form-control">
            </div>
        </div>

        <div>
            <button type="button" onclick="performStore()" class="btn btn-primary">حفظ</button>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">رجوع</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function performStore() {
        let data = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address').value,
        };

        store('{{ route('admin.admins.store') }}', data);
    }
</script>
@endsection
