<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $grossiste = User::where('role', 'grossiste')->first();

        if (!$grossiste) {
            return view('messages.index', [
                'messages' => collect([]),
                'grossiste' => null,
            ]);
        }

        $messages = Message::betweenUsers($user->id, $grossiste->id)
            ->with(['fromUser', 'toUser'])
            ->orderBy('created_at')
            ->get();

        Message::where('from_user_id', $grossiste->id)
            ->where('to_user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('messages.index', compact('messages', 'grossiste'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'to_user_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();

        $toUser = User::findOrFail($request->to_user_id);

        if ($user->isVendeur() && !$toUser->isGrossiste()) {
            return response()->json(['error' => 'Vous ne pouvez envoyer des messages qu\'au grossiste.'], 403);
        }

        $message = Message::create([
            'from_user_id' => $user->id,
            'to_user_id' => $request->to_user_id,
            'message' => $request->message,
        ]);

        $message->load(['fromUser', 'toUser']);

        return response()->json([
            'message' => 'Message envoyé.',
            'data' => [
                'id' => $message->id,
                'message' => $message->message,
                'from_user' => $message->fromUser->name,
                'created_at' => $message->created_at->format('d/m/Y H:i'),
                'is_mine' => true,
            ],
        ]);
    }

    public function markRead(Message $message)
    {
        $user = Auth::user();

        if ($message->to_user_id !== $user->id) {
            return response()->json(['error' => 'Non autorisé.'], 403);
        }

        $message->markAsRead();

        return response()->json(['message' => 'Message marqué comme lu.']);
    }

    public function unreadCount()
    {
        $user = Auth::user();
        $count = Message::getUnreadCount($user->id);

        return response()->json(['count' => $count]);
    }

    public function adminIndex()
    {
        $user = Auth::user();

        if (!$user->isGrossiste()) {
            abort(403);
        }

        $vendeurs = User::where('role', 'vendeur')
            ->where('is_active', true)
            ->with(['receivedMessages' => function ($query) use ($user) {
                $query->where('from_user_id', $user->id)->where('is_read', false);
            }])
            ->get();

        $conversations = [];

        foreach ($vendeurs as $vendeur) {
            $lastMessage = Message::betweenUsers($user->id, $vendeur->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $unreadCount = Message::where('from_user_id', $vendeur->id)
                ->where('to_user_id', $user->id)
                ->where('is_read', false)
                ->count();

            $conversations[] = [
                'user' => $vendeur,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount,
            ];
        }

        usort($conversations, function ($a, $b) {
            $aTime = $a['last_message'] ? $a['last_message']->created_at : null;
            $bTime = $b['last_message'] ? $b['last_message']->created_at : null;

            if (!$aTime && !$bTime) return 0;
            if (!$aTime) return 1;
            if (!$bTime) return -1;

            return $bTime <=> $aTime;
        });

        return view('admin.messages.index', compact('conversations'));
    }

    public function conversation(User $user)
    {
        $admin = Auth::user();

        if (!$admin->isGrossiste()) {
            abort(403);
        }

        if (!$user->isVendeur()) {
            abort(404);
        }

        $messages = Message::betweenUsers($admin->id, $user->id)
            ->with(['fromUser', 'toUser'])
            ->orderBy('created_at')
            ->get();

        Message::where('from_user_id', $user->id)
            ->where('to_user_id', $admin->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('admin.messages.conversation', compact('messages', 'user'));
    }

    public function adminSend(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'to_user_id' => 'required|exists:users,id',
        ]);

        $admin = Auth::user();

        if (!$admin->isGrossiste()) {
            return response()->json(['error' => 'Non autorisé.'], 403);
        }

        $toUser = User::findOrFail($request->to_user_id);

        if (!$toUser->isVendeur()) {
            return response()->json(['error' => 'Vous ne pouvez envoyer des messages qu\'aux vendeurs.'], 403);
        }

        $message = Message::create([
            'from_user_id' => $admin->id,
            'to_user_id' => $request->to_user_id,
            'message' => $request->message,
        ]);

        $message->load(['fromUser', 'toUser']);

        return response()->json([
            'message' => 'Message envoyé.',
            'data' => [
                'id' => $message->id,
                'message' => $message->message,
                'from_user' => $message->fromUser->name,
                'created_at' => $message->created_at->format('d/m/Y H:i'),
                'is_mine' => true,
            ],
        ]);
    }
}