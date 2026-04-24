@extends('front.layout.student')

@section('title','profile')
@section('css')
<style>
.profile-page-wrap{
    max-width: 950px;
    margin: 0 auto;
}

.profile-card{
    background: #fff;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(15, 76, 129, 0.08);
    border: 1px solid #e8eef6;
}

.profile-card-header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.profile-card-title{
    font-size: 24px;
    font-weight: 800;
    color: #0f2b46;
    display: flex;
    align-items: center;
    gap: 10px;
}

.profile-top{
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 18px;
    border-radius: 20px;
    background: linear-gradient(135deg, #f8fbff, #eef5ff);
    border: 1px solid #dbe8f8;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.profile-avatar,
.avatar-circle-placeholder{
    width: 95px;
    height: 95px;
    border-radius: 50%;
    object-fit: cover;
    background: #dfefff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    font-weight: 800;
    color: #1d5fa7;
    flex-shrink: 0;
    border: 4px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.profile-top-info h3{
    margin: 0 0 6px;
    color: #102a43;
    font-size: 24px;
    font-weight: 800;
}

.profile-top-info p{
    margin: 0 0 4px;
    color: #6b7b8d;
    font-size: 14px;
}

.status-badge{
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
}

.profile-section-title{
    font-size: 16px;
    font-weight: 800;
    color: #1b3b5a;
    margin: 24px 0 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.profile-grid{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.form-group{
    margin-bottom: 0;
}

.form-label{
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 700;
    color: #274c77;
}

.input-wrap{
    position: relative;
}

.input-wrap i{
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #7a8da6;
    font-size: 14px;
}

.form-control,
.form-select{
    width: 100%;
    height: 50px;
    border: 1px solid #d6e2f0;
    border-radius: 14px;
    background: #fff;
    padding: 0 44px 0 14px;
    font-size: 14px;
    color: #102a43;
    outline: none;
    transition: .2s ease;
}

.form-control:focus,
.form-select:focus{
    border-color: #1d5fa7;
    box-shadow: 0 0 0 3px rgba(29,95,167,0.12);
}

.avatar-upload-row{
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.avatar-upload-btn{
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #1d5fa7;
    color: #fff;
    padding: 10px 16px;
    border-radius: 12px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
    transition: .2s ease;
}

.avatar-upload-btn:hover{
    background: #174d87;
}

.profile-actions{
    display: flex;
    gap: 10px;
    margin-top: 24px;
    flex-wrap: wrap;
}

.btn{
    border: none;
    border-radius: 14px;
    padding: 12px 20px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-primary{
    background: #1d5fa7;
    color: #fff;
}

.btn-primary:hover{
    background: #174d87;
}

.btn-light{
    background: #eef4fb;
    color: #1d3d63;
    border: 1px solid #d5e2f1;
}

.alert{
    padding: 14px 16px;
    border-radius: 14px;
    margin-bottom: 14px;
    font-size: 14px;
}

.alert-success{
    background: #e9f9ef;
    color: #166534;
    border: 1px solid #c7efd3;
}

.alert-danger{
    background: #fff1f2;
    color: #b42318;
    border: 1px solid #fecdd3;
}

@media (max-width: 768px){
    .profile-grid{
        grid-template-columns: 1fr;
    }

    .profile-card{
        padding: 18px;
    }

    .profile-top{
        align-items: flex-start;
    }

    .profile-top-info h3{
        font-size: 20px;
    }
}
</style>
@endsection

@section('content')
<div class="profile-page-wrap">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0;padding-right:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $studentImage = $student->images->first() ?? null;
    @endphp

    <div class="profile-card">

        <div class="profile-card-header">
            <div class="profile-card-title">
                <i class="fa fa-user"></i>
                الملف الشخصي
            </div>

            <span class="status-badge {{ $student->general_status == 'active' ? 'badge-success' : 'badge-warning' }}">
                {{ ['active'=>'نشط','inactive'=>'غير نشط','graduated'=>'خريج','suspended'=>'موقوف'][$student->general_status] ?? $student->general_status }}
            </span>
        </div>

        <div class="profile-top">
            @if($studentImage)
                <img src="{{ asset('storage/' . $studentImage->path) }}" alt="avatar" class="profile-avatar">
            @else
                <div class="avatar-circle-placeholder">
                    {{ mb_substr($student->full_name ?? 'ط', 0, 1) }}
                </div>
            @endif

            <div class="profile-top-info">
                <h3>{{ $student->full_name }}</h3>
                <p>{{ $user->email }}</p>
                <p>الرقم الجامعي: {{ $student->university_number }}</p>
                <p>{{ $student->college->name ?? '—' }}</p>
            </div>
        </div>

        <form action="{{ route('front.student.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="profile-section-title">
                <i class="fa fa-camera"></i>
                الصورة الشخصية
            </div>

            <div class="avatar-upload-row">
                <label for="image" class="avatar-upload-btn">
                    <i class="fa fa-upload"></i>
                    اختر صورة
                </label>
                <input type="file" name="image" id="image" accept="image/*" style="display:none" onchange="previewAvatar(this)">
                <span id="avatarName" style="font-size:13px;color:#6b7b8d;">لم يتم اختيار ملف</span>
            </div>

            <div class="profile-section-title">
                <i class="fa fa-info-circle"></i>
                البيانات الشخصية
            </div>

            <div class="profile-grid">
                <div class="form-group">
                    <label class="form-label">الاسم الكامل</label>
                    <div class="input-wrap">
                        <i class="fa fa-user"></i>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $student->full_name) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">رقم الهاتف</label>
                    <div class="input-wrap">
                        <i class="fa fa-phone"></i>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">المدينة</label>
                    <div class="input-wrap">
                        <i class="fa fa-map-marker-alt"></i>
                        <select name="city_id" class="form-select">
                            <option value="">اختر</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id', $student->city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">الكلية</label>
                    <div class="input-wrap">
                        <i class="fa fa-university"></i>
                        <select name="college_id" class="form-select">
                            <option value="">اختر</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college->id }}" {{ old('college_id', $student->college_id) == $college->id ? 'selected' : '' }}>
                                    {{ $college->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">المستوى الدراسي</label>
                    <div class="input-wrap">
                        <i class="fa fa-layer-group"></i>
                        <select name="level" class="form-select">
                            <option value="">اختر</option>
                            @foreach(['أولى','ثانية','ثالثة','رابعة','خامسة'] as $level)
                                <option value="{{ $level }}" {{ old('level', $student->level) == $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">الجنس</label>
                    <div class="input-wrap">
                        <i class="fa fa-venus-mars"></i>
                        <select name="gender" class="form-select">
                            <option value="">اختر</option>
                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">تاريخ الميلاد</label>
                    <div class="input-wrap">
                        <i class="fa fa-calendar"></i>
                        <input type="date" name="birthdate" class="form-control"
                               value="{{ old('birthdate', $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">العنوان</label>
                    <div class="input-wrap">
                        <i class="fa fa-location-dot"></i>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $student->address) }}">
                    </div>
                </div>
            </div>

            <div class="profile-actions">
                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                <a href="{{ route('front.student.password.edit') }}" class="btn btn-light">تغيير كلمة المرور</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
function previewAvatar(input) {
    const fileName = document.getElementById('avatarName');
    if (input.files && input.files[0]) {
        fileName.textContent = input.files[0].name;
    } else {
        fileName.textContent = 'لم يتم اختيار ملف';
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const pageTitle = document.getElementById("pageTitle");
    if (pageTitle) {
        pageTitle.textContent = "الملف الشخصي";
    }
});
</script>
@endsection
