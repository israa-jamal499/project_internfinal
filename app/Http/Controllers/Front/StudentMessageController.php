<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;
class StudentMessageController extends Controller
{
    public function index()
    {
        $user = auth::user();

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $internship = Internship::with(['supervisor.user', 'company.user'])
            ->where('students_id', $user->student->id)
            ->latest()
            ->first();

        if (!$internship) {
            return view('front.student.massege', [
                'internship' => null,
                'supervisorUser' => null,
                'companyUser' => null,
                'supervisorMessages' => collect(),
                'companyMessages' => collect(),
            ]);
        }

        $supervisorUser = optional($internship->supervisor)->user;
        $companyUser = optional($internship->company)->user;

        $supervisorMessages = collect();
        if ($supervisorUser) {
            $supervisorMessages = Message::where('internships_id', $internship->id)
                ->where(function ($query) use ($user, $supervisorUser) {
                    $query->where('sender_id', $user->id)->where('receiver_id', $supervisorUser->id)
                          ->orWhere(function ($q) use ($user, $supervisorUser) {
                              $q->where('sender_id', $supervisorUser->id)->where('receiver_id', $user->id);
                          });
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        $companyMessages = collect();
        if ($companyUser) {
            $companyMessages = Message::where('internships_id', $internship->id)
                ->where(function ($query) use ($user, $companyUser) {
                    $query->where('sender_id', $user->id)->where('receiver_id', $companyUser->id)
                          ->orWhere(function ($q) use ($user, $companyUser) {
                              $q->where('sender_id', $companyUser->id)->where('receiver_id', $user->id);
                          });
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return view('front.student.massege', compact(
            'internship',
            'supervisorUser',
            'companyUser',
            'supervisorMessages',
            'companyMessages'
        ));
    }

    public function send(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role != 'student' || !$user->student) {
            return redirect()->route('front.auth.login');
        }

        $internship = Internship::with(['supervisor.user', 'company.user'])
            ->where('students_id', $user->student->id)
            ->latest()
            ->first();

        if (!$internship) {
            return redirect()->back()->with('error', 'لا يوجد تدريب مرتبط لإرسال الرسائل');
        }

        $validator = Validator::make($request->all(), [
            'receiver_type' => 'required|in:supervisor,company',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }

        $receiver = null;

        if ($request->receiver_type == 'supervisor') {
    $receiver = optional($internship->supervisor)->user;
} else {
    $receiver = optional($internship->company)->user;
}

        if (!$receiver) {
            return redirect()->back()->with('error', 'الجهة المستلمة غير متوفرة');
        }

        Message::create([
            'subject' => null,
            'body' => $request->body,
            'is_read' => false,
            'read_at' => null,
            'is_saved' => false,
            'internships_id' => $internship->id,
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
        ]);
        Notification::create([
    'title' => 'رسالة جديدة',
    'body' => 'لديك رسالة جديدة من الطالب بخصوص التدريب.',
    'type' => 'message',
    'link' => route('cms.supervisor.messages'),
    'is_read' => false,
    'read_at' => null,
    'user_id' => $receiver->id,
]);
        return redirect()->route('front.student.messages')
            ->with('success', 'تم إرسال الرسالة بنجاح');

    }


}
