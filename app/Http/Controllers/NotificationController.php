<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;

class NotificationController extends Controller
{
    public function index()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        $notifications = $user->notifications;
        return response()->json($notifications, 200);
    }
}
