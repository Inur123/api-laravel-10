<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function showNotifications()
    {
        // Ensure the user is authenticated
        $notifications = auth()->user()->notifications;
        return view('notifications.index', compact('notifications'));
    }
}
