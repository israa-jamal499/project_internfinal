@extends('cms.supervisor.temp')
@section('title','show-hour')
@section('main-title','عرض سجل الساعات')

@section('content')
<div class="card p-4">

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:15px; padding:12px 14px; border-radius:12px; background:#e7f8ee; color:#0a7a36; border:1px solid #c8f0d7;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom:15px; padding:12px 14px; border-radius:12px; background:#ffe9e9; color:#b00000; border:1px solid #ffd0d0;">
            {{ session('error') }}
        </div>
    @endif

    <h3 class="mb-4">تفاصيل سجل الساعات</h3>

    <div class="row">
        <div class="col-md-6 mb-3">
            <strong>الطالب:</strong>
            {{ $hourLog->internship->student->full_name ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الشركة:</strong>
            {{ $hourLog->internship->company->name ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الفرصة:</strong>
            {{ $hourLog->internship->opportunity->title ?? '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>التاريخ:</strong>
            {{ $hourLog->work_date ? $hourLog->work_date->format('Y-m-d') : '-' }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>عدد الساعات:</strong>
            {{ $hourLog->hours }}
        </div>

        <div class="col-md-6 mb-3">
            <strong>الحالة الحالية:</strong>
            {{ $hourLog->status }}
        </div>

        <div class="col-md-12 mb-3">
            <strong>وصف العمل:</strong>
            <div class="border rounded p-3 mt-2">{{ $hourLog->description }}</div>
        </div>
    </div>

    <hr>

    <form method="POST" action="{{ route('cms.supervisor.hours.update', $hourLog->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>ملاحظات المشرف</label>
            <textarea name="supervisor_feedback" class="form-control" rows="4">{{ old('supervisor_feedback', $hourLog->supervisor_feedback) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>الحالة</label>
            <select name="status" class="form-control">
                <option value="pending" {{ $hourLog->status == 'pending' ? 'selected' : '' }}>معلق</option>
                <option value="approved" {{ $hourLog->status == 'approved' ? 'selected' : '' }}>معتمد</option>
                <option value="rejected" {{ $hourLog->status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">حفظ الاعتماد</button>
        <a href="{{ route('cms.supervisor.hours') }}" class="btn btn-light">رجوع</a>
    </form>
</div>
@endsection
