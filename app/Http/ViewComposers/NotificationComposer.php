<?php

namespace App\Http\ViewComposers;

use App\Models\Notification;
use Illuminate\View\View;

class NotificationComposer
{
    public function compose(View $view)
    {
        if (auth()->check()) {
            $unreadNotifications = Notification::where('user_id', auth()->id())
                ->unread()
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $unreadCount = Notification::where('user_id', auth()->id())
                ->unread()
                ->count();

            $view->with('unreadNotifications', $unreadNotifications);
            $view->with('notificationCount', $unreadCount);
        } else {
            $view->with('unreadNotifications', collect());
            $view->with('notificationCount', 0);
        }
    }
}
