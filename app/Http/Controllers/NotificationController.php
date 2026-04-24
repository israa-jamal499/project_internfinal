<?php

namespace App\Http\Controllers;

use App\Models\Notification;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function studentIndex()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('front.student.notifications', compact('notifications'));
    }

    public function supervisorIndex()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('cms.supervisor.notifications', compact('notifications'));
    }



    public function adminIndex()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('cms.admin.notifications', compact('notifications'));
    }

    public function markRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);

        $notification->is_read = true;
        $notification->read_at = now();
        $notification->save();

        if ($notification->link) {
            return redirect($notification->link);
        }

        return redirect()->back()->with('success', 'تم تعليم الإشعار كمقروء');
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return redirect()->back()->with('success', 'تم تعليم جميع الإشعارات كمقروءة');
    }


public function companyIndex()
{
    $notifications = Notification::where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('cms.company.notifications', compact('notifications'));
}


}
