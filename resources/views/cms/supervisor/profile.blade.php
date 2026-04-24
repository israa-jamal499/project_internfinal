@extends('cms.supervisor.temp')
@section('title','profile')
@section('main-title','الملف الشخصي')

@section('content')
<style>
.supervisor-profile-page{
    width:92%;
    margin:30px auto;
    direction:rtl;
    font-family:Tahoma, Arial, sans-serif;
}

.supervisor-profile-card{
    background:#fff;
    border-radius:18px;
    padding:24px;
    box-shadow:0 8px 24px rgba(0,0,0,0.06);
    border:1px solid #eef3f6;
}

.supervisor-profile-top{
    display:flex;
    align-items:center;
    gap:18px;
    flex-wrap:wrap;
    margin-bottom:24px;
    padding-bottom:18px;
    border-bottom:1px solid #eef3f6;
}

.supervisor-avatar,
.supervisor-avatar-placeholder{
    width:90px;
    height:90px;
    border-radius:50%;
    object-fit:cover;
    background:#eef4ff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
    font-weight:bold;
    color:#3e7cd7;
}

.supervisor-profile-info h3{
    margin:0 0 6px;
    font-size:24px;
    color:#1c2b4a;
}

.supervisor-profile-info p{
    margin:0 0 4px;
    color:#6b7280;
    font-size:14px;
}

.supervisor-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:16px;
}

.supervisor-group{
    margin-bottom:14px;
}

.supervisor-label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    color:#1c2b4a;
    font-size:14px;
}

.supervisor-input,
.supervisor-select{
    width:100%;
    padding:11px 12px;
    border:1px solid #dbe3ee;
    border-radius:10px;
    font-size:14px;
    outline:none;
    background:#fff;
}

.supervisor-input:focus,
.supervisor-select:focus{
    border-color:#3e7cd7;
    box-shadow:0 0 0 3px rgba(62,124,215,0.12);
}

.supervisor-actions{
    margin-top:18px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.supervisor-btn{
    border:none;
    border-radius:10px;
    padding:11px 18px;
    font-weight:bold;
    cursor:pointer;
    text-decoration:none;
}

.supervisor-btn.primary{
    background:#3e7cd7;
    color:#fff;
}

.supervisor-btn.light{
    background:#eef3f6;
    color:#1c2b4a;
}

.alert-success{
    background:#e9f9ef;
    color:#166534;
    border:1px solid #c7efd3;
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:12px;
}

.alert-danger{
    background:#fff1f2;
    color:#b42318;
    border:1px solid #fecdd3;
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:12px;
}

@media(max-width:768px){
    .supervisor-grid{
        grid-template-columns:1fr;
    }
}
</style>

<div class="supervisor-profile-page">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-danger">
            <ul style="margin:0;padding-right:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $supervisorImage = $supervisor->images->first() ?? null;
    @endphp

    <div class="supervisor-profile-card">
        <div class="supervisor-profile-top">
            @if($supervisorImage)
                <img src="{{ asset('storage/' . $supervisorImage->path) }}" class="supervisor-avatar" alt="supervisor">
            @else
                <div class="supervisor-avatar-placeholder">
                    {{ mb_substr($supervisor->full_name ?? 'م', 0, 1) }}
                </div>
            @endif

            <div class="supervisor-profile-info">
                <h3>{{ $supervisor->full_name }}</h3>
                <p>{{ $user->email }}</p>
                <p>{{ $supervisor->phone ?? 'لا يوجد رقم' }}</p>
            </div>
        </div>

        <form action="{{ route('cms.supervisor.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="supervisor-group">
                <label class="supervisor-label">الصورة الشخصية</label>
                <input type="file" name="image" class="supervisor-input">
            </div>

            <div class="supervisor-grid">
                <div class="supervisor-group">
                    <label class="supervisor-label">الاسم الكامل</label>
                    <input type="text" name="full_name" class="supervisor-input" value="{{ old('full_name', $supervisor->full_name) }}">
                </div>

                <div class="supervisor-group">
                    <label class="supervisor-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="supervisor-input" value="{{ old('email', $user->email) }}">
                </div>

                <div class="supervisor-group">
                    <label class="supervisor-label">رقم الهاتف</label>
                    <input type="text" name="phone" class="supervisor-input" value="{{ old('phone', $supervisor->phone) }}">
                </div>

                <div class="supervisor-group">
                    <label class="supervisor-label">المدينة</label>
                    <select name="city_id" class="supervisor-select">
                        <option value="">اختر</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id', $supervisor->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="supervisor-group" style="grid-column:1/-1;">
                    <label class="supervisor-label">العنوان</label>
                    <input type="text" name="address" class="supervisor-input" value="{{ old('address', $supervisor->address) }}">
                </div>
            </div>

            <div class="supervisor-actions">
                <button type="submit" class="supervisor-btn primary">حفظ التعديلات</button>
                <a href="{{ route('cms.supervisor.password.edit') }}" class="supervisor-btn light">تغيير كلمة المرور</a>
            </div>
        </form>
    </div>
</div>
@endsection
