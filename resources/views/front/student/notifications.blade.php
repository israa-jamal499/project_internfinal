@extends('front.layout.student')
@section('title','notifications')

@section('content')
<main class="student-page notifications-page">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="page-title-box">
        <h2>الإشعارات</h2>
        <p>تابعي آخر التنبيهات المتعلقة بالتدريب، التقارير، الساعات، التقييمات، والشهادة.</p>
    </section>

    <section class="white-card notifications-card">
        <div class="notifications-head">
            <h3>كل الإشعارات</h3>

            <form method="POST" action="{{ route('notifications.readAll') }}">
                @csrf
                <button type="submit" class="btn btn-light">تعليم الكل كمقروء</button>
            </form>
        </div>

        <div class="notifications-list">
            @forelse($notifications as $notification)
                <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}">
                    <div class="notification-content">
                        <h4>{{ $notification->title }}</h4>
                        <p>{{ $notification->body ?? '-' }}</p>
                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="notification-actions">
                        @if(!$notification->is_read)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">فتح</button>
                            </form>
                        @elseif($notification->link)
                            <a href="{{ $notification->link }}" class="btn btn-light btn-sm">عرض</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">لا توجد إشعارات حاليًا</div>
            @endforelse
        </div>
    </section>
</main>
@endsection

@section('css')
<style>
.notifications-page{display:grid;gap:18px}
.notifications-card{padding:22px;border-radius:22px}
.notifications-head{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:18px}
.notifications-list{display:grid;gap:14px}
.notification-item{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:14px;
    padding:16px;
    border:1px solid #e8edf5;
    border-radius:18px;
}
.notification-item.unread{
    background:#f8fbff;
    border-color:#dbe9ff;
}
.notification-item.read{
    background:#fff;
}
.notification-content h4{
    margin:0 0 6px;
    color:#122033;
    font-size:16px;
}
.notification-content p{
    margin:0 0 8px;
    color:#475569;
    line-height:1.8;
    font-size:14px;
}
.notification-content span{
    color:#64748b;
    font-size:12px;
}
.empty-state{
    text-align:center;
    padding:20px;
    border:1px dashed #d9e2ec;
    border-radius:16px;
    color:#64748b;
}
.alert{
    padding:12px 14px;
    border-radius:12px;
}
.alert-success{
    background:#e7f8ee;
    color:#0a7a36;
    border:1px solid #c8f0d7;
}
@media(max-width:700px){
    .notifications-head,.notification-item{
        flex-direction:column;
        align-items:stretch;
    }
}
</style>
@endsection
