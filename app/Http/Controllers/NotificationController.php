<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    // Ambil 10 notifikasi terbaru (read & unread)
    public function latest()
    {
        return auth()->user()->unreadNotifications()->latest()->take(10)->get();
    }

    // Tandai notifikasi tertentu sebagai sudah dibaca
    public function markAsRead($id)
    {
        $notif = DatabaseNotification::where('id', $id)
            ->where('notifiable_id', auth()->id())
            ->first();

        if ($notif && is_null($notif->read_at)) {
            $notif->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }
}
