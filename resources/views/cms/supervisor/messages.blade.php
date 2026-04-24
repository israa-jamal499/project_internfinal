@extends('cms.supervisor.parent')

@section('title','الرسائل')

@section('content')
<section class="content supervisor-messages-page">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mb-3">
            <div class="col-12">
                <div class="card card-outline card-primary shadow-sm border-0 page-header-card">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h3 class="mb-1">📨 رسائل الطلاب</h3>
                            <p class="text-muted mb-0">راجعي الرسائل الواردة من الطلاب، وافتحي أي رسالة للقراءة والرد.</p>
                        </div>

                        <div class="header-stats d-flex align-items-center flex-wrap">
                            <span class="badge badge-primary p-2 ml-2">الواردة: {{ $inboxMessages->count() }}</span>
                            <span class="badge badge-warning p-2">غير المقروءة: {{ $unreadCount }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <ul class="nav nav-pills flex-column text-right message-folder-list" id="folderList">
                <li class="nav-item">
                    <a href="#" class="nav-link active" data-filter="all">
                        الوارد
                        <span class="badge bg-primary float-left">{{ $inboxMessages->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-filter="unread">
                        غير المقروءة
                        <span class="badge bg-warning float-left">{{ $unreadCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-filter="read">المقروءة</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-filter="saved">المحفوظة</a>
                </li>
            </ul>

            <div class="col-md-9">

                <div class="card card-primary card-outline shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title mb-2 mb-md-0">📨 صندوق الوارد</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm inbox-search-box">
                                <input type="text" class="form-control" id="messageSearchInput" placeholder="بحث عن طالب أو موضوع">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped mb-0">
                                <tbody id="messagesTableBody">

                                @forelse($inboxMessages as $message)
                                    <tr class="message-row {{ $selectedMessage && $selectedMessage->id == $message->id ? 'active-message-row' : '' }}"
                                        data-folder="{{ $message->is_saved ? 'saved' : ($message->is_read ? 'read' : 'unread') }}"
                                        data-student="{{ $message->sender->student->full_name ?? '-' }}"
                                        data-subject="{{ $message->subject ?? 'بدون موضوع' }}">
                                        <td width="50">
                                            <form method="POST" action="{{ route('cms.supervisor.messages.toggleSave', $message->id) }}">
                                                @csrf
                                                <button class="btn btn-default btn-sm" type="submit">
                                                    <i class="{{ $message->is_saved ? 'fas' : 'far' }} fa-star"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="mailbox-name text-primary font-weight-bold">
                                            <a href="{{ route('cms.supervisor.messages.show', $message->id) }}">
                                                {{ $message->sender->student->full_name ?? '-' }}
                                            </a>
                                        </td>
                                        <td class="mailbox-subject">
                                            <b>{{ $message->subject ?? 'رسالة' }}</b>
                                        </td>
                                        <td class="mailbox-date">
                                            {{ $message->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">لا توجد رسائل</td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($selectedMessage)
                <div class="card mt-3 shadow-sm border-0" id="messagePreviewCard">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title mb-2 mb-md-0">📄 تفاصيل الرسالة</h3>

                        <div class="preview-actions">
                            <button class="btn btn-primary btn-sm" type="button" id="openReplyBtn">رد</button>

                            @if(!$selectedMessage->is_read)
                            <form method="POST" action="{{ route('cms.supervisor.messages.markRead', $selectedMessage->id) }}" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-outline-secondary btn-sm" type="submit">تعليم كمقروءة</button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="preview-meta-row">
                            <strong>الطالب:</strong>
                            <span id="previewStudent">{{ $selectedMessage->sender->student->full_name ?? '-' }}</span>
                        </div>

                        <div class="preview-meta-row">
                            <strong>الموضوع:</strong>
                            <span id="previewSubject">{{ $selectedMessage->subject ?? 'بدون موضوع' }}</span>
                        </div>

                        <div class="preview-meta-row">
                            <strong>الوقت:</strong>
                            <span id="previewTime">{{ $selectedMessage->created_at->diffForHumans() }}</span>
                        </div>

                        <hr>

                        <p id="previewBody" class="mb-0 preview-message-body">
                            {{ $selectedMessage->body }}
                        </p>
                    </div>
                </div>

                <div class="card mt-3 shadow-sm border-0" id="replyCard" style="display:none;">
                    <div class="card-header bg-white">
                        <h3 class="card-title mb-0">✉️ الرد على الرسالة</h3>
                    </div>

                    <form method="POST" action="{{ route('cms.supervisor.messages.reply') }}">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="receiver_id" value="{{ $selectedMessage->sender_id }}">
                            <input type="hidden" name="internships_id" value="{{ $selectedMessage->internships_id }}">

                            <div class="form-group">
                                <label>إلى الطالب</label>
                                <input type="text" class="form-control" value="{{ $selectedMessage->sender->student->full_name ?? '-' }}" readonly>
                            </div>

                            <div class="form-group">
                                <label>الموضوع</label>
                                <input type="text" name="subject" class="form-control" value="رد: {{ $selectedMessage->subject ?? 'رسالة' }}">
                            </div>

                            <div class="form-group">
                                <label>الرسالة</label>
                                <textarea name="body" id="replyMessage" class="form-control" rows="5" placeholder="اكتبي ردك هنا..."></textarea>
                            </div>
                        </div>

                        <div class="card-footer bg-white text-left">
                            <button type="submit" class="btn btn-primary">إرسال الرد</button>
                            <button type="button" class="btn btn-outline-secondary" id="cancelReplyBtn">إلغاء</button>
                        </div>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('messageSearchInput');
    const folderLinks = document.querySelectorAll('#folderList .nav-link');
    const rows = document.querySelectorAll('.message-row');
    const replyCard = document.getElementById('replyCard');
    const openReplyBtn = document.getElementById('openReplyBtn');
    const cancelReplyBtn = document.getElementById('cancelReplyBtn');

    folderLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const filter = this.dataset.filter;

            folderLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            rows.forEach(row => {
                const folder = row.dataset.folder;
                row.style.display = (filter === 'all' || folder === filter) ? '' : 'none';
            });
        });
    });

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const value = this.value.toLowerCase().trim();

            rows.forEach(row => {
                const student = row.dataset.student.toLowerCase();
                const subject = row.dataset.subject.toLowerCase();

                row.style.display = (student.includes(value) || subject.includes(value)) ? '' : 'none';
            });
        });
    }

    if (openReplyBtn && replyCard) {
        openReplyBtn.addEventListener('click', function () {
            replyCard.style.display = 'block';
            replyCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    if (cancelReplyBtn && replyCard) {
        cancelReplyBtn.addEventListener('click', function () {
            replyCard.style.display = 'none';
        });
    }
});
</script>
@endsection
