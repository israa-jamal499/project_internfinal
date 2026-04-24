@extends('cms.supervisor.parent')
@section('title','edit student')
@section('main-title','تعديل الطالب')

@section('css')
<link rel="stylesheet" href="{{ asset('internship/css/admin.css') }}">
@endsection

@section('content')
<main class="page">
    <div class="page-head">
        <div class="page-title">
            <p>تعديل بيانات الطالب.</p>
        </div>

        <div class="page-actions">
            <a href="{{ route('cms.supervisor.students.index') }}" class="btn btn-outline">رجوع</a>
        </div>
    </div>

    <section class="card">
        <div class="card-head">
            <h2>تعديل: {{ $student->full_name }}</h2>
            <div class="hint">عدلي البيانات المطلوبة</div>
        </div>

        <div id="error_alert" class="alert alert-danger" hidden>
            <ul id="error_messages_ul"></ul>
        </div>

        <form id="edit_form">
            @csrf
            @method('PUT')

            <div class="tools-row">
                <div class="tool">
                    <label>الاسم الكامل</label>
                    <input type="text" id="full_name" value="{{ $student->full_name }}">
                </div>

                <div class="tool">
                    <label>البريد الإلكتروني</label>
                    <input type="email" id="email" value="{{ $student->user->email ?? '' }}">
                </div>

                <div class="tool">
                    <label>الرقم الجامعي</label>
                    <input type="text" id="university_number" value="{{ $student->university_number }}">
                </div>

                <div class="tool">
                    <label>المستوى</label>
                    <input type="text" id="level" value="{{ $student->level }}">
                </div>

                <div class="tool">
                    <label>الحالة</label>
                    <select id="general_status">
                        @foreach(['active','inactive','graduated','suspended'] as $status)
                            <option value="{{ $status }}" {{ $student->general_status == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="tool">
                    <label>الجنس</label>
                    <select id="gender">
                        <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>male</option>
                        <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>female</option>
                    </select>
                </div>

                <div class="tool">
                    <label>الهاتف</label>
                    <input type="text" id="phone" value="{{ $student->phone }}">
                </div>

                <div class="tool">
                    <label>العنوان</label>
                    <input type="text" id="address" value="{{ $student->address }}">
                </div>

                <div class="tool">
                    <label>تاريخ الميلاد</label>
                    <input type="date" id="birthdate" value="{{ $student->birthdate }}">
                </div>

                <div class="tool">
                    <label>المدينة</label>
                    <select id="city_id">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $student->city_id == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="tool">
                    <label>الكلية</label>
                    <select id="college_id">
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}" {{ $student->college_id == $college->id ? 'selected' : '' }}>
                                {{ $college->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="tool">
                    <label>التخصص</label>
                    <select id="specialization_id">
                        <option value="">بدون</option>
                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization->id }}" {{ $student->specialization_id == $specialization->id ? 'selected' : '' }}>
                                {{ $specialization->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="tool">
                    <label>CV</label>
                    <input type="text" id="cv" value="{{ $student->cv }}">
                </div>
            </div>

            <div class="page-actions mt-3">
                <button type="button" class="btn btn-primary" onclick="performUpdate()">حفظ التعديل</button>
            </div>
        </form>
    </section>
</main>
@endsection

@section('scripts')
<script>
function performUpdate() {
    let data = {
        full_name: document.getElementById('full_name').value,
        email: document.getElementById('email').value,
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

    update('{{ route('cms.supervisor.students.update', $student->id) }}', data, '{{ route('cms.supervisor.students.index') }}');
}
</script>
@endsection
