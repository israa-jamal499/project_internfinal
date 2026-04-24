@extends('front.layout.main')
@section('title',content: 'Student Register')

@section('content')
@section('css')
@endsection
  <style>
  /* ===== Register Page ===== */

.register-section {
  min-height: 90vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(135deg, #1e4fa3, #0f2b5b);
  padding: 40px 20px;
}

.register-card {
  width: 100%;
  max-width: 420px;
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(14px);
  padding: 35px;
  border-radius: 20px;
  text-align: center;
  color: white;
  box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.register-card h2 {
  margin-bottom: 8px;
}

.register-card p {
  opacity: 0.9;
  margin-bottom: 20px;
}

/* Inputs */

.input-group {
  margin-bottom: 14px;
}

.input-group input {
  width: 100%;
  padding: 14px;
  border-radius: 10px;
  border: none;
  outline: none;
  font-size: 15px;
  box-sizing: border-box;
}

/* Button */

.register-btn {
  width: 100%;
  padding: 14px;
  border-radius: 12px;
  border: none;
  background: rgb(15, 79, 152);
  color: #0b101a;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  transition: 0.3s;
}

.register-btn:hover {
  background: #0b1e45;
  transform: translateY(-2px);
}

/* Login link */

.login-link {
  margin-top: 18px;
  font-size: 14px;
}

.login-link a {
  color: #cfe3ff;
  text-decoration: none;
  font-weight: bold;
}

.login-link a:hover {
  text-decoration: underline;
}
.input-group select.form-select {
    width: 100%;
    height: 50px;
    border: none;
    outline: none;
    border-radius: 12px;
    padding: 0 15px;
    background: #f1f5f9;
    color: #333;
    font-size: 15px;
    appearance: none;
}
.input-group {
    margin-bottom: 14px;
}
  </style>



<section class="register-section">

  <div class="register-card">

    <h2>إنشاء حساب طالب 🎓</h2>
    <p>املئي البيانات لإنشاء حساب جديد</p>

<form class="register-form" method="POST" action="{{ route('front.auth.register-student.store') }}">
    @csrf

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 15px;">
            <ul style="margin:0; padding-right:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="input-group">
        <input type="text" name="full_name" placeholder="الاسم الكامل" value="{{ old('full_name') }}" required>
    </div>

    <div class="input-group">
        <input type="email" name="email" placeholder="البريد الإلكتروني" value="{{ old('email') }}" required>
    </div>

    <div class="input-group">
        <input type="text" name="university_number" placeholder="الرقم الجامعي" value="{{ old('university_number') }}" required>
    </div>

    <div class="input-group">
        <select name="college_id" id="college_id" class="form-select" required>
            <option value="">اختر الكلية</option>
            @foreach($colleges as $college)
                <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>
                    {{ $college->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="input-group">
        <select name="specialization_id" id="specialization_id" class="form-select" required>
            <option value="">اختر التخصص</option>
            @foreach($specializations as $specialization)
                <option value="{{ $specialization->id }}"
                        data-college="{{ $specialization->college_id }}"
                        {{ old('specialization_id') == $specialization->id ? 'selected' : '' }}>
                    {{ $specialization->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="input-group">
        <select name="city_id" class="form-select" required>
            <option value="">اختر المدينة</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="input-group">
        <input type="text" name="phone" placeholder="رقم الجوال" value="{{ old('phone') }}">
    </div>

    <div class="input-group">
        <input type="text" name="address" placeholder="العنوان" value="{{ old('address') }}">
    </div>

    <div class="input-group">
        <select name="gender" class="form-select">
            <option value="">اختر الجنس</option>
            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
        </select>
    </div>

    <div class="input-group">
        <input type="date" name="birthdate" value="{{ old('birthdate') }}">
    </div>

    <div class="input-group">
        <input type="text" name="level" placeholder="المستوى الدراسي" value="{{ old('level') }}">
    </div>

    <div class="input-group">
        <input type="password" name="password" placeholder="كلمة المرور" required>
    </div>

    <div class="input-group">
        <input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" required>
    </div>

    <button type="submit" class="register-btn">
        إنشاء الحساب
    </button>
</form>

    <p class="login-link">
      لديك حساب بالفعل؟
      <a href="{{ route('front.auth.login') }}">سجل الدخول</a>
    </p>

  </div>

</section>

@endsection


@section('js')
{{-- <script>
    document.getElementById('college_id').addEventListener('change', function () {
        let collegeId = this.value;
        let specializationSelect = document.getElementById('specialization_id');

        specializationSelect.innerHTML = '<option value="">اختر التخصص</option>';

        if (collegeId === '') {
            return;
        }

        fetch(`/front/auth/college-specializations/${collegeId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    specializationSelect.innerHTML = '<option value="">لا يوجد تخصصات لهذه الكلية</option>';
                    return;
                }

                data.forEach(function (specialization) {
                    specializationSelect.innerHTML += `<option value="${specialization.id}">${specialization.name}</option>`;
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }); --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const collegeSelect = document.getElementById('college_id');
        const specializationSelect = document.getElementById('specialization_id');
        const specializationOptions = Array.from(specializationSelect.options);

        function filterSpecializations() {
            const selectedCollege = collegeSelect.value;

            specializationSelect.innerHTML = '<option value="">اختر التخصص</option>';

            specializationOptions.forEach(option => {
                if (option.value === '') return;

                if (option.dataset.college === selectedCollege) {
                    specializationSelect.appendChild(option);
                }
            });

            const oldSpecialization = "{{ old('specialization_id') }}";
            if (oldSpecialization) {
                specializationSelect.value = oldSpecialization;
            }
        }

        collegeSelect.addEventListener('change', filterSpecializations);

        if (collegeSelect.value) {
            filterSpecializations();
        }
    });
</script>

@endsection

