@extends('cms.company.temp')
@section('title','notifications')
@section('main-title','الاشعارات')
@section('content')

<style>
.company-notifications-page {
    width: 92%;
    margin: 25px auto;
    direction: rtl;
    text-align: right;
}

/* header */
.company-notifications-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.company-notifications-title {
    margin: 0;
    color: #1c2b4a;
    font-size: 22px;
    font-weight: 700;
}

.company-notifications-clear {
    background: #ef4444;
    color: #fff;
    border: none;
    padding: 10px 14px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

.company-notifications-clear:hover {
    background: #dc2626;
}

/* card */
.company-notification-card {
    background: #fff;
    border-radius: 14px;
    padding: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* unread */
.company-notification-unread {
    border-right: 5px solid #3e7cd7;
    background: #f8fbff;
}

/* content */
.company-notification-content {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* icon */
.company-notification-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    background: #eef3ff;
}

/* text */
.company-notification-text h4 {
    margin: 0;
    font-size: 15px;
    color: #1c2b4a;
}

.company-notification-text p {
    margin: 3px 0 0;
    font-size: 13px;
    color: #6b7280;
}

.company-notification-time {
    font-size: 12px;
    color: #9ca3af;
    margin-top: 4px;
}

/* buttons */
.company-notification-actions {
    display: flex;
    gap: 8px;
}

.company-notification-btn {
    border: none;
    padding: 7px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
}

.company-notification-read {
    background: #3e7cd7;
    color: #fff;
}

.company-notification-delete {
    background: #ef4444;
    color: #fff;
}

/* empty */
.company-notification-empty {
    text-align: center;
    margin-top: 50px;
    color: #6b7280;
    display: none;
}
</style>

<div class="company-notifications-page">

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

<script>

function deleteNotif(btn){
    const card = btn.closest(".company-notification-card");
    card.remove();
    checkEmpty();
}

function clearAll(){
    document.querySelectorAll(".company-notification-card").forEach(card => card.remove());
    checkEmpty();
}

function checkEmpty(){
    const cards = document.querySelectorAll(".company-notification-card");
    if(cards.length === 0){
        document.getElementById("emptyMsg").style.display = "block";
    }
}
</script>

@endsection
