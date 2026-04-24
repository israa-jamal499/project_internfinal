@extends('cms.admin.temp')

@section('title', 'الإشعارات')
@section('main-title', 'الإشعارات')

@section('content')
<div class="card p-4">

    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="mb-2 mb-md-0">كل الإشعارات</h4>

        <form action="{{ route('notifications.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-light border">
                تعليم الكل كمقروء
            </button>
        </form>
    </div>

    @forelse($notifications as $notification)
        <div class="border rounded p-3 mb-3 {{ $notification->is_read ? 'bg-white' : 'bg-light' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div>
                    <h5 class="mb-1">{{ $notification->title }}</h5>
                    <p class="mb-2 text-muted">{{ $notification->body ?? '-' }}</p>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>

                <div class="mt-2 mt-md-0">
                    @if(!$notification->is_read)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">فتح</button>
                        </form>
                    @elseif($notification->link)
                        <a href="{{ $notification->link }}" class="btn btn-secondary btn-sm">عرض</a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center text-muted py-5">
            لا توجد إشعارات حاليًا
        </div>
    @endforelse

</div>
@endsection

@section('css')
<style>
.alert-success{
    background: #e7f8ee;
    color: #0a7a36;
    border: 1px solid #c8f0d7;
    padding: 12px 14px;
    border-radius: 12px;
}
</style>
@endsection
