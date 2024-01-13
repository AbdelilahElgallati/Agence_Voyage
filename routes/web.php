<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\DemandeOffreController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReservationChambreController;
use App\Http\Controllers\ReservationVoyageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoyageController;
use App\Models\DemandeOffre;
use App\Models\Hotel;
use App\Models\Reservation_chambre;
use App\Models\Voyage;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/essaye',function(){ return view('essaye'); });

Route::get('/', function () {
    $hotel_maroc = Hotel::where('pays_hotel','maroc')->take(3)->get();
    $hotel_monde = Hotel::where('pays_hotel','!=','maroc')->take(3)->get();
    $voyages = Voyage::All()->take(3);
    $hotelCounts = Hotel::query()
            ->select('ville_hotel', DB::raw('count(*) as total'))
            ->groupBy('ville_hotel')
            ->get();
    return view('welcome', compact('hotel_monde','hotelCounts', 'voyages','hotel_maroc'));
});

Auth::routes();

// route home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home-admin', [App\Http\Controllers\HomeController::class, 'home_admin'])->name('home_admin');
Route::get('/home-hotel', [App\Http\Controllers\HomeController::class, 'home_hotel'])->name('home_hotel');

// route user
Route::get('/home/profile', [UserController::class, 'index'])->name('home.profile');
Route::get('/home/profile-admin', [UserController::class, 'profile_admin'])->name('home.profile.admin');
Route::get('/home/admin/utilisateurs', [UserController::class, 'users'])->name('home.users');
Route::get('/home/admin/utilisateurs/detail/{id}', [UserController::class, 'detail'])->name('home.users.detail');
Route::delete('/home/user/supprimer/{id}', [UserController::class, 'destroy'])->name('home.user.destroy');
Route::delete('/home/user/compte/supprimer/{id}', [UserController::class, 'destroy_compte'])->name('home.user.compte.destroy');
Route::post('/home/user/update', [UserController::class, 'update_compte'])->name('home.user.compte.update');
Route::post('/home/user/mot-passe/update', [UserController::class, 'update_password'])->name('home.user.password.update');


// route hotel
Route::get('/home/hotel', [HotelController::class, 'index'])->name('home.hotel');
Route::get('/home/hotel/gestion', [HotelController::class, 'gestion'])->name('home.hotel.gestion');
Route::get('/home/hotel/edit/{id}', [HotelController::class, 'edit'])->name('home.hotel.edit');
Route::post('/home/hotel/update/{id}', [HotelController::class, 'update'])->name('home.hotel.update');
Route::get('/home/admin/hotel', [HotelController::class, 'hotel_admin'])->name('home.admin.hotel');
Route::delete('/home/hotel/supprimer/{id}', [HotelController::class, 'destroy'])->name('home.hotel.destroy');
Route::post('/home/hotel/enregistrer', [HotelController::class, 'store'])->name('home.hotel.store');


// route demande hotel
Route::get('/home/demande-hotel', [DemandeOffreController::class, 'index'])->name('home.demande-hotel');
Route::delete('/home/demande-hotel/supprimer/{id}', [DemandeOffreController::class, 'destroy'])->name('home.demande-hotel.destroy');
Route::get('/home/demande-hotel/create', [DemandeOffreController::class, 'create'])->name('home.demande-hotel.create');
Route::post('/home/demande-hotel/enregistrer', [DemandeOffreController::class, 'store_demande'])->name('home.demande-hotel.save');
Route::post('/home/user/demande-hotel/enregistrer', [DemandeOffreController::class, 'store'])->name('home.demande-hotel.store');



// route voyage
Route::get('/home/voyage', [VoyageController::class, 'index'])->name('home.voyage');
Route::get('/home/admin/voyage', [VoyageController::class, 'all_voyage'])->name('home.admin.voyage');
Route::get('/home/voyage/edit/{id}', [VoyageController::class, 'edit'])->name('home.voyage.edit');
Route::post('/home/voyage/update/{id}', [VoyageController::class, 'update'])->name('home.voyage.update');
Route::get('/home/voyage/create', [VoyageController::class, 'create'])->name('home.voyage.create');
Route::post('/home/voyage/enregistrer', [VoyageController::class, 'store'])->name('home.voyage.save');
Route::delete('/home/voyage/supprimer/{id}', [VoyageController::class, 'destroy'])->name('home.voyage.destroy');


// route chambre
Route::get('/home/hotel/chambres/{id}', [ChambreController::class, 'chambre'])->name('home.hotel.chambre');
Route::get('/home/hotel/chambres/gestion/{id}', [ChambreController::class, 'show'])->name('home.hotel.chambre.gestion');
Route::get('/home/admin/hotel/chambres/gestion/{id}', [ChambreController::class, 'show_admin'])->name('home.admin.hotel.chambre.gestion');
Route::get('/home/hotel/chambre/create', [ChambreController::class, 'create'])->name('home.hotel.chambre.create');
Route::post('/home/hotel/chambre/enregistrer', [ChambreController::class, 'store'])->name('home.hotel.chambre.save');
Route::get('/home/hotel/chambre/edit/{id}', [ChambreController::class, 'edit'])->name('home.hotel.chambre.edit');
Route::post('/home/hotel/chambre/update/{id}', [ChambreController::class, 'update'])->name('home.hotel.chambre.update');
Route::delete('/home/hotel/chambre/supprimer/{id}', [ChambreController::class, 'destroy'])->name('home.hotel.chambre.destroy');
Route::get('/home/admin/utilisateurs/hotel/chambres/detail/{id}', [ChambreController::class, 'chambre_detail'])->name('admin.hotel.chambre.detail');



// reservation chambre
Route::get('/home/hotel/chambre/reservation', [ReservationChambreController::class, 'reservation_chambre'])->name('home.hotel.chambre.reservation');
Route::get('/home/hotel/chambre/commande', [ReservationChambreController::class, 'commande_chambre'])->name('home.hotel.chambre.commande');
Route::post('/home/hotel/chambre/reservation/enregistrer', [ReservationChambreController::class, 'store'])->name('home.hotel.chambre.reservation.save');
Route::post('/home/hotel/chambre/reservation/update', [ReservationChambreController::class, 'update'])->name('home.hotel.chambre.reservation.update');
Route::delete('/home/hotel/chambre/reservation/annuler/{id}', [ReservationChambreController::class, 'destroy'])->name('home.hotel.chambre.reservation.destroy');
Route::delete('/home/admin/hotel/chambre/reservation/annuler/{id}', [ReservationChambreController::class, 'destroy_admin'])->name('home.admin.hotel.chambre.destroy');


// reservation voyage
Route::get('/home/voyage/commandes', [ReservationVoyageController::class, 'reservation_voyage'])->name('home.voyage.reservation');
Route::get('/home/voyage/reservation', [ReservationVoyageController::class, 'index'])->name('home.voyage.commande');
Route::post('/home/voyage/reservation/enregistrer', [ReservationVoyageController::class, 'store'])->name('home.voyage.reservation.save');
Route::post('/home/voyage/reservation/update', [ReservationVoyageController::class, 'update'])->name('home.voyage.reservation.update');
Route::delete('/home/voyage/reservation/annuler/{id}', [ReservationVoyageController::class, 'destroy'])->name('home.voyage.reservation.destroy');


// route search
Route::post('home/admin/hotel',[HotelController::class,'search_hotel_admin'])->name('admin.hotel.search');
Route::post('home/admin/voyage',[VoyageController::class,'search_voyage_admin'])->name('admin.voyage.search');
Route::post('/home/admin/hotel/chambres/{id}',[ChambreController::class,'search_chambre_admin'])->name('admin.chambre.search');
Route::post('home/hotel',[HotelController::class,'search_hotel'])->name('home.hotel.search');
// Route::post('home/admin/hotel',[HotelController::class,'search_hotel_admin'])->name('home.admin.hotel.search');
Route::post('home/voyage',[VoyageController::class,'search_voyage'])->name('home.voyage.search');
Route::post('home/hotel/chambres/gestion/{id}',[ChambreController::class,'search_chambre_gestion'])->name('home.hotel.chambre.gestion.search');
Route::post('home/admin/hotel/chambres/gestion/{id}',[ChambreController::class,'search_chambre_admin'])->name('home.admin.hotel.chambre.search');
Route::post('home/hotel/chambres/{id}',[ChambreController::class,'search_chambre'])->name('home.hotel.chambre.search');
Route::post('/home/demande-hotel',[DemandeOffreController::class,'search_demande_admin'])->name('admin.demande.search');



// route notifications
Route::get('home/notifications',[NotificationController::class,'index'])->name('home.notifications');
Route::get('home/notifications-hotel',[NotificationController::class,'notif_hotel'])->name('home.notifications-hotel');
Route::get('home/notifications-admin',[NotificationController::class,'notif_admin'])->name('home.notifications-admin');


// route login et register
Route::post('/login/administration',function(){ return view('auth.login_admin'); })->name('login.administration');
Route::post('/login/utilisateurs', function () { return view('auth.login_user'); })->name('login.users');
Route::get('/login/hotel',function(){ return view('auth.login_hotel'); })->name('login.hotels');
Route::get('/register/utilisateurs',function(){ return view('auth.register_user'); })->name('inscription.users');
Route::get('/register/hotel',function(){ return view('auth.register_hotel'); })->name('inscription.hotel');
Route::post('/login/hotel', [LoginController::class, 'hotelLogin'])->name('login.hotel');
Route::post('/login/user', [LoginController::class, 'userLogin'])->name('login.user');
Route::post('/login/admin', [LoginController::class, 'adminLogin'])->name('login.administrations');
Route::post('/register/user', [RegisterController::class, 'register_user'])->name('register.user');


// route d'imprimer
Route::post('/imprimer/reservation-chambre', [ReservationChambreController::class, 'imprimer'])->name('imprimer.reservation.chambre');
Route::post('/imprimer/reservation-voyage', [ReservationVoyageController::class, 'imprimer'])->name('imprimer.reservation.voyage');



