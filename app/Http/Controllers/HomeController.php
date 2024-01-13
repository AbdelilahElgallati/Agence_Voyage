<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Voyage;
use App\Models\Notification as ModelsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hotel_maroc = Hotel::where('pays_hotel','maroc')->take(3)->get();
        $hotel_monde = Hotel::where('pays_hotel','!=','maroc')->take(3)->get();
        $voyages = Voyage::All()->take(3);
        $hotelCounts = Hotel::query()
            ->select(DB::raw("CONCAT(UCASE(LEFT(ville_hotel, 1)), LOWER(SUBSTRING(ville_hotel, 2))) AS ville_hotel, COUNT(*) AS total"))
            ->groupBy('ville_hotel')
            ->get();
        return view('home', compact('hotel_monde', 'voyages','hotel_maroc','hotelCounts'));
    }

    public function home_hotel()
    {
        $hotels = Hotel::where('user_id',Auth()->user()->id)->get();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('home_hotel', compact('hotels','hotel_personnel'));
    }

    public function home_admin()
    {
        $hotel_maroc = Hotel::where('pays_hotel','maroc')->take(3)->get();
        $hotel_monde = Hotel::where('pays_hotel','!=','maroc')->take(3)->get();
        $voyages = Voyage::All()->take(3);
        $hotelCounts = Hotel::query()
            ->select(DB::raw("CONCAT(UCASE(LEFT(ville_hotel, 1)), LOWER(SUBSTRING(ville_hotel, 2))) AS ville_hotel, COUNT(*) AS total"))
            ->groupBy('ville_hotel')
            ->get();
        return view('home_admin', compact('hotel_monde', 'voyages','hotel_maroc','hotelCounts'));
    }
}
