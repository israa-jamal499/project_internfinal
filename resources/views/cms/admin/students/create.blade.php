@extends('cms.admin.temp')
@section('title', 'Create Student')
@section('main-title', 'إضافة طالب')

@section('content')
<div class="card p-4">

    <div id="error_alert" class="alert alert-danger" hidden>
        <ul id="error_messages_ul" class="mb-0"></ul>
    </div>

    <form id="create_form">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label>الاسم الكامل</label>
                <input type="text" id="full_name" class="form-control">
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
                <label>الرقم الجامعي</label>
                <input type="text" id="university_number" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>المستوى</label>
                <input type="text" id="level" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الحالة</label>
                <select id="general_status" class="form-control">
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                    <option value="graduated">graduated</option>
                    <option value="suspended">suspended</option>
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>السيرة الذاتية</label>
                <input type="text" id="cv" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>العنوان</label>
                <input type="text" id="address" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>رقم الجوال</label>
                <input type="text" id="phone" class="form-control">
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>الجنس</label>
                <select id="gender" class="form-control">
                    <option value="">اختر الجنس</option>
                    <option value="male">male</option>
                    <option value="female">female</option>
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>تاريخ الميلاد</label>
                <input type="date" id="birthdate" class="form-control">
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
                <label>الكلية</label>
                <select id="college_id" class="form-control">
                    <option value="">اختر الكلية</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}">{{ $college->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label>التخصص</label>
                <select id="specialization_id" class="form-control">
                    <option value="">اختر التخصص</option>
                    @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div>
        <button type="button" onclick="performStore()" class="btn btn-primary">حفظ</button>
        <a href="{{ route('admin.students.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performStore() {
        let data = {
            full_name: document.getElementById('full_name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            university_number: document.getElementById('university_number').value,
            level: document.getElementById('level').value,
            general_status: document.getElementById('general_status').value,
            cv: document.getElementById('cv').value,
            address: document.getElementById('address').value,
            phone: document.getElementById('phone').value,
            gender: document.getElementById('gender').value,
            birthdate: document.getElementById('birthdate').value,
            city_id: document.getElementById('city_id').value,
            college_id: document.getElementById('college_id').value,
            specialization_id: document.getElementById('specialization_id').value,
        };

        store('{{ route('admin.students.store') }}', data);
    }
</script>
@endsection
