@extends('cms.supervisor.parent')
@section('title','الإشعارات')

@section('content')
<section class="content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">الإشعارات</h3>

                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">تعليم الكل كمقروء</button>
                </form>
            </div>

            <div class="card-body">
                @forelse($notifications as $notification)
                    <div class="border rounded p-3 mb-3 {{ $notification->is_read ? '' : 'bg-light' }}">
                        <h5>{{ $notification->title }}</h5>
                        <p class="mb-1">{{ $notification->body ?? '-' }}</p>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>

                        <div class="mt-2">
                            @if(!$notification->is_read)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">فتح</button>
                                </form>
                            @elseif($notification->link)
                                <a href="{{ $notification->link }}" class="btn btn-light btn-sm">عرض</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted">لا توجد إشعارات</div>
                @endforelse
            </div>
        </div>

    </div>
</section>
@endsection
