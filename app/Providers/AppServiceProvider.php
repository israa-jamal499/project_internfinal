<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('cms.admin.*', function ($view) {
        $adminUser = Auth::user();

        $adminMessages = collect();
        $adminNotifications = collect();
        $unreadAdminMessagesCount = 0;
        $unreadAdminNotificationsCount = 0;

        if ($adminUser && $adminUser->role == 'admin') {
            $adminMessages = Message::with(['sender.student', 'sender.company', 'sender.supervisor'])
                ->where('receiver_id', $adminUser->id)
                ->latest()
                ->take(5)
                ->get();

            $adminNotifications = Notification::where('user_id', $adminUser->id)
                ->latest()
                ->take(5)
                ->get();

            $unreadAdminMessagesCount = Message::where('receiver_id', $adminUser->id)
                ->where('is_read', false)
                ->count();

            $unreadAdminNotificationsCount = Notification::where('user_id', $adminUser->id)
                ->where('is_read', false)
                ->count();
        }

        $view->with([
            'adminUser' => $adminUser,
            'adminMessages' => $adminMessages,
            'adminNotifications' => $adminNotifications,
            'unreadAdminMessagesCount' => $unreadAdminMessagesCount,
            'unreadAdminNotificationsCount' => $unreadAdminNotificationsCount,
        ]);
    });




     View::composer(['cms.company.*'], function ($view) {
        $user = Auth::user();

        $navNotifications = collect();
        $unreadNotificationsCount = 0;

        if ($user) {
            $navNotifications = Notification::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            $unreadNotificationsCount = Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
        }

        $view->with([
            'navNotifications' => $navNotifications,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    });



    View::composer(['cms.supervisor.*'], function ($view) {
    $user = Auth::user();

    $navMessages = collect();
    $navNotifications = collect();
    $unreadMessagesCount = 0;
    $unreadNotificationsCount = 0;

    if ($user) {
        $navMessages = Message::with('sender.student')
            ->where('receiver_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $unreadMessagesCount = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();

        $navNotifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $unreadNotificationsCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
    }

    $view->with(compact(
        'navMessages',
        'navNotifications',
        'unreadMessagesCount',
        'unreadNotificationsCount'
    ));
});

View::composer(['cms.supervisor.*'], function ($view) {
    $user = Auth::user();

    $navMessages = collect();
    $navNotifications = collect();
    $unreadMessagesCount = 0;
    $unreadNotificationsCount = 0;

    if ($user) {
        $navMessages = Message::with([
                'sender.student',
                'sender.company',
                'sender.supervisor'
            ])
            ->where('receiver_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $unreadMessagesCount = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();

        $navNotifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $unreadNotificationsCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
    }

    $view->with(compact(
        'navMessages',
        'navNotifications',
        'unreadMessagesCount',
        'unreadNotificationsCount'
    ));
});
}}
