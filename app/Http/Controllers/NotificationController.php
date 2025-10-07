<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher toutes les notifications de l'utilisateur
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');

        if ($filter === 'unread') {
            $query->unread();
        } elseif ($filter === 'read') {
            $query->read();
        }

        $notifications = $query->paginate(20);
        $unreadCount = Notification::where('user_id', auth()->id())->unread()->count();

        return view('notifications.index', compact('notifications', 'unreadCount', 'filter'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->markAsRead();

        if ($notification->link) {
            return redirect($notification->link);
        }

        return redirect()->back()->with('success', 'Notification marquée comme lue');
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues');
    }

    /**
     * Supprimer une notification
     */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification supprimée');
    }

    /**
     * Supprimer toutes les notifications lues
     */
    public function deleteRead()
    {
        Notification::where('user_id', auth()->id())
            ->read()
            ->delete();

        return redirect()->back()->with('success', 'Toutes les notifications lues ont été supprimées');
    }

    /**
     * Obtenir le nombre de notifications non lues (API)
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())->unread()->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Obtenir les notifications récentes (API)
     */
    public function recent()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->unread()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'icon' => $notification->getIconClass(),
                    'priority' => $notification->priority,
                    'link' => $notification->link,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            });

        return response()->json($notifications);
    }
}
