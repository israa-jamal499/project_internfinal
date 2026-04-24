<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Notification;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store($id)
    {
        if (!Auth::check()) {
            return redirect()->route('front.auth.login')
                ->with('error', 'يجب تسجيل الدخول كطالب أولاً');
        }

        $user = Auth::user();

        if ($user->role != 'student') {
            return redirect()->route('front.auth.login')
                ->with('error', 'فقط الطالب يمكنه التقديم على الفرصة');
        }

        if (!$user->student) {
            return redirect()->route('front.auth.login')
                ->with('error', 'بيانات الطالب غير موجودة');
        }

        $opportunity = Opportunity::findOrFail($id);

        if ($opportunity->status != 'مفتوحة') {
            return redirect()->back()
                ->with('error', 'هذه الفرصة غير متاحة للتقديم حالياً');
        }

        if ($opportunity->deadline < now()->toDateString()) {
            return redirect()->back()
                ->with('error', 'انتهى موعد التقديم على هذه الفرصة');
        }

        if ($opportunity->filled_seats >= $opportunity->seats) {
            return redirect()->back()
                ->with('error', 'لا توجد مقاعد متاحة حالياً');
        }

        $applicationExists = Application::where('students_id', $user->student->id)
            ->where('opportunities_id', $opportunity->id)
            ->exists();

        if ($applicationExists) {
            return redirect()->route('front.student.applications')
                ->with('error', 'لقد قمتِ بالتقديم على هذه الفرصة مسبقاً');
        }

        $application = new Application();
        $application->cover_letter = null;
        $application->status = 'قيد المراجعة';
        $application->students_id = $user->student->id;
        $application->opportunities_id = $opportunity->id;
        $isSaved = $application->save();

        Notification::create([
    'title' => 'طلب تدريب جديد',
    'body' => 'قام طالب جديد بالتقديم على إحدى فرصك التدريبية.',
    'type' => 'application',
    'is_read' => false,
    'read_at' => null,
    'user_id' => $opportunity->company->user_id,
]);

        return redirect()->route('front.student.applications')
            ->with($isSaved ? 'success' : 'error', $isSaved ? 'تم إرسال طلب التقديم بنجاح' : 'فشل إرسال الطلب');
    }
}
