<?php

namespace App\Http\Controllers\Cms\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $messages = Message::with([
                'sender.student',
                'receiver',
                'internship.student',
            ])
            ->where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $inboxMessages = Message::with([
                'sender.student',
                'internship.student',
            ])
            ->where('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $selectedMessage = $inboxMessages->first();

        $unreadCount = $inboxMessages->where('is_read', false)->count();
        $readCount = $inboxMessages->where('is_read', true)->count();
        $savedCount = $inboxMessages->where('is_saved', true)->count();

        return view('cms.supervisor.messages', compact(
            'inboxMessages',
            'selectedMessage',
            'unreadCount',
            'readCount',
            'savedCount'
        ));
    }

    public function show($id)
    {
        $user = Auth::user();

        $message = Message::with([
                'sender.student',
                'internship.student',
            ])
            ->where('receiver_id', $user->id)
            ->findOrFail($id);

        if (!$message->is_read) {
            $message->is_read = true;
            $message->read_at = now();
            $message->save();
        }

        $inboxMessages = Message::with([
                'sender.student',
                'internship.student',
            ])
            ->where('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $unreadCount = $inboxMessages->where('is_read', false)->count();
        $readCount = $inboxMessages->where('is_read', true)->count();
        $savedCount = $inboxMessages->where('is_saved', true)->count();

        return view('cms.supervisor.messages', [
            'inboxMessages' => $inboxMessages,
            'selectedMessage' => $message,
            'unreadCount' => $unreadCount,
            'readCount' => $readCount,
            'savedCount' => $savedCount,
        ]);
    }

    public function reply(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'internships_id' => 'nullable|exists:internships,id',
            'subject' => 'nullable|string|max:150',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }

        Message::create([
            'subject' => $request->subject,
            'body' => $request->body,
            'is_read' => false,
            'read_at' => null,
            'is_saved' => false,
            'internships_id' => $request->internships_id,
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
        ]);
        Notification::create([
    'title' => 'رد جديد على رسالتك',
    'body' => 'قام المشرف بالرد على رسالتك.',
    'type' => 'message_reply',
    'link' => route('front.student.messages'),
    'is_read' => false,
    'read_at' => null,
    'user_id' => $request->receiver_id,
]);

        return redirect()->route('cms.supervisor.messages')
            ->with('success', 'تم إرسال الرد بنجاح');
    }

    public function markRead($id)
    {
        $user = Auth::user();

        $message = Message::where('receiver_id', $user->id)->findOrFail($id);
        $message->is_read = true;
        $message->read_at = now();
        $message->save();

        return redirect()->back()->with('success', 'تم تعليم الرسالة كمقروءة');
    }

    public function toggleSave($id)
{
    $user = Auth::user();

    $message = Message::where('receiver_id', $user->id)->findOrFail($id);
    $message->is_saved = !$message->is_saved;
    $message->save();

    return redirect()->back()->with('success', 'تم تحديث حالة الحفظ');
}
}
