@extends('cms.company.temp')

@section('title', 'عرض الفرصة')
@section('main-title', 'عرض الفرصة')

@section('content')
<div class="card p-4">

    @if($opportunity->image)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $opportunity->image->path) }}" width="250" class="img-thumbnail">
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3"><strong>العنوان:</strong> {{ $opportunity->title }}</div>
        <div class="col-md-6 mb-3"><strong>المدينة:</strong> {{ $opportunity->city->name ?? '-' }}</div>
        <div class="col-md-6 mb-3"><strong>النوع:</strong> {{ $opportunity->type }}</div>
        <div class="col-md-6 mb-3"><strong>الساعات المطلوبة:</strong> {{ $opportunity->required_hours }}</div>
        <div class="col-md-6 mb-3"><strong>المقاعد:</strong> {{ $opportunity->filled_seats }}/{{ $opportunity->seats }}</div>
        <div class="col-md-6 mb-3"><strong>آخر موعد:</strong> {{ $opportunity->deadline }}</div>
        <div class="col-md-6 mb-3"><strong>الحالة:</strong> {{ $opportunity->status }}</div>
        <div class="col-md-12 mb-3"><strong>الوصف:</strong> {{ $opportunity->description }}</div>
        <div class="col-md-12 mb-3"><strong>المتطلبات:</strong> {{ $opportunity->requirements ?? '-' }}</div>
        <div class="col-md-12 mb-3"><strong>الفوائد:</strong> {{ $opportunity->benefits ?? '-' }}</div>
        <div class="col-md-12 mb-3">
            <strong>التخصصات:</strong>
            @forelse($opportunity->specializations as $specialization)
                <span class="badge bg-primary">{{ $specialization->name }}</span>
            @empty
                -
            @endforelse
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('opportunities.edit', $opportunity->id) }}" class="btn btn-primary">تعديل</a>
        <a href="{{ route('opportunities.index') }}" class="btn btn-light">رجوع</a>
    </div>
</div>
@endsection
