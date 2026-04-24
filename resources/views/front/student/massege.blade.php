@extends('front.layout.student')

@section('title','messages')

@section('content')
<main class="student-page messages-page">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <section class="page-title-box">
        <h2>الرسائل</h2>
        <p>
            يمكنك التواصل مع المشرف الأكاديمي أو مسؤول جهة التدريب من خلال هذه الصفحة.
        </p>
    </section>

    <section class="messages-layout">

        <aside class="messages-sidebar white-card">
            <div class="messages-sidebar-head">
                <h3>المحادثات</h3>
            </div>

            <div class="chat-list">
                @if($supervisorUser)
                    <div class="chat-user active" data-chat="supervisor" onclick="selectChat('supervisor')">
                        <div class="chat-avatar">أ</div>
                        <div class="chat-user-info">
                            <strong>{{ $internship->supervisor->full_name ?? 'المشرف' }}</strong>
                            <span>المشرف الأكاديمي</span>
                        </div>
                    </div>
                @endif

                @if($companyUser)
                    <div class="chat-user {{ !$supervisorUser ? 'active' : '' }}" data-chat="company" onclick="selectChat('company')">
                        <div class="chat-avatar company">ش</div>
                        <div class="chat-user-info">
                            <strong>{{ $internship->company->name ?? 'جهة التدريب' }}</strong>
                            <span>جهة التدريب</span>
                        </div>
                    </div>
                @endif
            </div>
        </aside>

        <section class="messages-chat white-card">
            <div class="chat-header">
                <div class="chat-header-user">
                    <div class="chat-avatar" id="chatAvatar">{{ $supervisorUser ? 'أ' : 'ش' }}</div>
                    <div>
                        <strong id="chatName">
                            {{ $supervisorUser ? ($internship->supervisor->full_name ?? 'المشرف الأكاديمي') : ($internship->company->name ?? 'جهة التدريب') }}
                        </strong>
                        <span id="chatRole">
                            {{ $supervisorUser ? 'المشرف الأكاديمي' : 'جهة التدريب' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="chat-body" id="chatBody">
                @if($supervisorUser)
                    <div class="chat-pane" id="supervisorChat">
                        @forelse($supervisorMessages as $message)
                            <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                                <p>{{ $message->body }}</p>
                                <span>{{ $message->created_at->format('h:i A') }}</span>
                            </div>
                        @empty
                            <div class="empty-chat">لا توجد رسائل مع المشرف بعد</div>
                        @endforelse
                    </div>
                @endif

                @if($companyUser)
                    <div class="chat-pane" id="companyChat" style="{{ $supervisorUser ? 'display:none;' : '' }}">
                        @forelse($companyMessages as $message)
                            <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                                <p>{{ $message->body }}</p>
                                <span>{{ $message->created_at->format('h:i A') }}</span>
                            </div>
                        @empty
                            <div class="empty-chat">لا توجد رسائل مع جهة التدريب بعد</div>
                        @endforelse
                    </div>
                @endif
            </div>

            @if($internship)
            <form class="chat-input-area" method="POST" action="{{ route('front.student.messages.send') }}">
                @csrf
                <input type="hidden" name="receiver_type" id="receiver_type" value="{{ $supervisorUser ? 'supervisor' : 'company' }}">
                <input type="text" name="body" id="messageInput" class="form-control" placeholder="اكتبي رسالتك هنا...">
                <button type="submit" class="btn btn-primary">إرسال</button>
            </form>
            @endif
        </section>

    </section>

</main>
@endsection

@section('css')
<style>
.messages-page{
    display:grid;
    gap:18px;
}
.messages-layout{
    display:grid;
    grid-template-columns:320px 1fr;
    gap:18px;
    align-items:start;
}
.messages-sidebar,
.messages-chat{
    border-radius:22px;
}
.messages-sidebar{
    padding:18px;
}
.messages-sidebar-head{
    margin-bottom:14px;
}
.messages-sidebar-head h3{
    margin:0;
    color:#122033;
}
.chat-list{
    display:grid;
    gap:10px;
}
.chat-user{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px;
    border-radius:16px;
    cursor:pointer;
    transition:.2s ease;
    border:1px solid #edf2f7;
}
.chat-user:hover{
    background:#f8fbff;
}
.chat-user.active{
    background:#eef4ff;
    border-color:#d7e6ff;
}
.chat-avatar{
    width:48px;
    height:48px;
    border-radius:14px;
    background:#3e7cd7;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:900;
    font-size:20px;
}
.chat-avatar.company{
    background:#14a44d;
}
.chat-user-info strong{
    display:block;
    color:#122033;
    font-size:14px;
    margin-bottom:4px;
}
.chat-user-info span{
    color:#64748b;
    font-size:12px;
}
.messages-chat{
    display:grid;
    grid-template-rows:auto 1fr auto;
    min-height:520px;
}
.chat-header{
    padding:18px 20px;
    border-bottom:1px solid #eef2f7;
}
.chat-header-user{
    display:flex;
    align-items:center;
    gap:12px;
}
.chat-header-user strong{
    display:block;
    color:#122033;
}
.chat-header-user span{
    color:#64748b;
    font-size:13px;
}
.chat-body{
    padding:20px;
    display:block;
    background:#f8fbff;
    min-height:340px;
}
.chat-pane{
    display:grid;
    gap:12px;
}
.message{
    max-width:70%;
    padding:14px 16px;
    border-radius:18px;
}
.message p{
    margin:0 0 6px;
    line-height:1.8;
    font-size:14px;
}
.message span{
    font-size:11px;
    color:#64748b;
}
.message.received{
    background:#fff;
    border:1px solid #e5edf5;
    justify-self:start;
}
.message.sent{
    background:#3e7cd7;
    color:#fff;
    justify-self:end;
}
.message.sent span{
    color:rgba(255,255,255,.8);
}
.chat-input-area{
    display:grid;
    grid-template-columns:1fr auto;
    gap:12px;
    padding:18px 20px;
    border-top:1px solid #eef2f7;
    background:#fff;
}
.empty-chat{
    color:#64748b;
    background:#fff;
    border:1px dashed #d8e1ee;
    border-radius:16px;
    padding:18px;
    text-align:center;
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
.alert-danger{
    background:#ffe9e9;
    color:#b00000;
    border:1px solid #ffd0d0;
}
@media (max-width:900px){
    .messages-layout{
        grid-template-columns:1fr;
    }
}
@media (max-width:600px){
    .chat-input-area{
        grid-template-columns:1fr;
    }
    .message{
        max-width:100%;
    }
}
</style>
@endsection

@section('js')
<script>
function selectChat(chatKey){
    document.querySelectorAll('.chat-user').forEach(item => item.classList.remove('active'));

    const selected = document.querySelector(`.chat-user[data-chat="${chatKey}"]`);
    if(selected) selected.classList.add('active');

    const supervisorChat = document.getElementById('supervisorChat');
    const companyChat = document.getElementById('companyChat');
    const receiverType = document.getElementById('receiver_type');
    const chatName = document.getElementById('chatName');
    const chatRole = document.getElementById('chatRole');
    const chatAvatar = document.getElementById('chatAvatar');

    if(chatKey === 'supervisor'){
        if(supervisorChat) supervisorChat.style.display = 'grid';
        if(companyChat) companyChat.style.display = 'none';
        if(receiverType) receiverType.value = 'supervisor';
        if(chatName) chatName.textContent = @json($internship?->supervisor?->full_name ?? 'المشرف الأكاديمي');
        if(chatRole) chatRole.textContent = 'المشرف الأكاديمي';
        if(chatAvatar){
            chatAvatar.textContent = 'أ';
            chatAvatar.classList.remove('company');
        }
    } else {
        if(supervisorChat) supervisorChat.style.display = 'none';
        if(companyChat) companyChat.style.display = 'grid';
        if(receiverType) receiverType.value = 'company';
        if(chatName) chatName.textContent = @json($internship?->company?->name ?? 'جهة التدريب');
        if(chatRole) chatRole.textContent = 'جهة التدريب';
        if(chatAvatar){
            chatAvatar.textContent = 'ش';
            chatAvatar.classList.add('company');
        }
    }
}
</script>
@endsection
