<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = auth()->user();
        $notifications = $user->unreadNotifications->get();

        // Mettre à jour les notifications comme lues
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'notifications' => $notifications,
            'count' => $user->unreadNotifications->count(),
        ]);
    }
}
