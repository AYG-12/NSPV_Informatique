<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $items  = $user->notifications()->latest()->take(15)->get()->map(fn($n) => [
            'id'      => $n->id,
            'data'    => $n->data,
            'read'    => !is_null($n->read_at),
            'time'    => $n->created_at->diffForHumans(),
        ]);

        return response()->json([
            'notifications' => $items,
            'unread'        => $user->unreadNotifications()->count(),
        ]);
    }

    public function markRead(string $id)
    {
        auth()->user()->notifications()->where('id', $id)->first()?->markAsRead();

        return response()->json(['ok' => true]);
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['ok' => true]);
    }
}
