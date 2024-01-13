<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Notification as ModelsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    function index(){
        $notifications = ModelsNotification::where('role' , '=', 'user')
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('created_at', 'desc')->get();
        return view('user.notification',compact('notifications'));
    }

    function notif_hotel(){
        $notifications = ModelsNotification::where('role' , '=', 'hotel')
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('created_at', 'desc')->get();
        if(Auth::user()){
            $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
            return view('user.notification_hotel', compact('hotel_personnel','notifications'));
        }
    }

    function notif_admin(){
        $notifications = ModelsNotification::where('role' , '=', 'admin')
        ->where('user_id', '=', Auth::user()->id)
        ->orderBy('created_at', 'desc')->get();
        return view('user.notification_admin',compact('notifications'));
    }

}
