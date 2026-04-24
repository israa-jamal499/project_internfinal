@extends('cms.admin.temp')
@section('title', 'Edit Admin')
@section('main-title', 'تعديل أدمن')

@section('content')
<div class="card p-4">

    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <form id="create_form">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label>الاسم</label>
                <input type="text" id="name" class="form-control" value="{{ $admin->name }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>البريد الإلكتروني</label>
                <input type="email" class="form-control" value="{{ $admin->user->email ?? '' }}" disabled>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>رقم الهاتف</label>
                <input type="text" id="phone" class="form-control" value="{{ $admin->phone }}">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>العنوان</label>
                <input type="text" id="address" class="form-control" value="{{ $admin->address }}">
            </div>
        </div>

        <div>
            <button type="button" onclick="performUpdate()" class="btn btn-primary">تحديث</button>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">رجوع</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate() {
        let data = {
            name: document.getElementById('name').value,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address').value,
        };

        updateRoute('{{ route('admin.admins.update', $admin->id) }}', data);
    }
</script>
@endsection
