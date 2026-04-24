@extends('cms.supervisor.parent')
@section('title','create student')
@section('main-title','إضافة طالب')

@section('css')
<link rel="stylesheet" href="{{ asset('internship/css/admin.css') }}">
@endsection

@section('content')
<main class="page">
    <div class="page-head">
        <div class="page-title">
            <p>إضافة طالب جديد وربطه بتدريب مع المشرف.</p>
        </div>

        <div class="page-actions">
            <a href="{{ route('cms.supervisor.students.index') }}" class="btn btn-outline">رجوع</a>
        </div>
    </div>

    <section class="card">
        <div class="card-head">
            <h2>بيانات الطالب</h2>
            <div class="hint">أدخلي البيانات المطلوبة</div>
        </div>
        <div id="error_alert" class="alert alert-danger" hidden>
    <ul id="error_messages_ul"></ul>
</div>

        <form id="create_form">
            @csrf

            <div class="tools-row">
                <div class="tool"><label>الاسم الكامل</label><input type="text" id="full_name"></div>
                <div class="tool"><label>البريد الإلكتروني</label><input type="email" id="email"></div>
                <div class="tool"><label>كلمة المرور</label><input type="password" id="password"></div>
                <div class="tool"><label>الرقم الجامعي</label><input type="text" id="university_number"></div>
                <div class="tool"><label>المستوى</label><input type="text" id="level"></div>

                <div class="tool">
                    <label>الحالة</label>
                    <select id="general_status">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                        <option value="graduated">graduated</option>
                        <option value="suspended">suspended</option>
                    </select>
                </div>

                <div class="tool">
                    <label>الجنس</label>
                    <select id="gender">
                        <option value="male">male</option>
                        <option value="female">female</option>
                    </select>
                </div>

                <div class="tool"><label>الهاتف</label><input type="text" id="phone"></div>
                <div class="tool"><label>العنوان</label><input type="text" id="address"></div>
                <div class="tool"><label>تاريخ الميلاد</label><input type="date" id="birthdate"></div>

                <div class="tool">
                    <label>المدينة</label>
                    <select id="city_id">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="tool">
                    <label>الكلية</label>
                    <select id="college_id">
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}">{{ $college->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="tool">
                    <label>التخصص</label>
                    <select id="specialization_id">
                        <option value="">بدون</option>
                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="tool">
                    <label>الشركة</label>
                    <select id="companies_id">
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="tool">
                    <label>الفرصة</label>
                    <select id="opportunities_id">
                        @foreach($opportunities as $opportunity)
                            <option value="{{ $opportunity->id }}">{{ $opportunity->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="tool"><label>CV</label><input type="text" id="cv"></div>
            </div>

            <div class="page-actions mt-3">
                <button type="button" class="btn btn-primary" onclick="performStore()">حفظ</button>
            </div>
        </form>
    </section>
</main>
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
        companies_id: document.getElementById('companies_id').value,
        opportunities_id: document.getElementById('opportunities_id').value,
    };

    store('{{ route('cms.supervisor.students.store') }}', data, '{{ route('cms.supervisor.students.index') }}');
}
</script>
@endsection
