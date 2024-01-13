<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Reservation_chambre;
use App\Models\Reservation_voyage;
use App\Models\Voyage;
use App\Models\Notification as ModelsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function profile_admin(){
        $user = Auth::user();
        return view('user.profile_admin', compact('user'));
    }

    public function users()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return view('admin.utilisateur', compact('users'));
    }

    public function detail($id){
        $user = User::where('id', $id)->first();
        $hotels = Hotel::where('user_id', $id)->get();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        $commandes = Reservation_chambre::where('posteur_id', '=', Auth::user()->id)
            ->where('reservation_chambres.status', '=', 'En attent')
            ->join('users', 'users.id', '=', 'reservation_chambres.user_id')
            ->join('chambres','chambres.id', '=','reservation_chambres.chambre_id')
            ->join('hotels', 'hotels.id', '=', 'chambres.hotel_id')
            ->select('reservation_chambres.id','reservation_chambres.email','reservation_chambres.telephone',
                'reservation_chambres.date_debut','reservation_chambres.date_fin','reservation_chambres.nombre_personnes',
                'reservation_chambres.prix','reservation_chambres.status','users.nom_complete',
                'chambres.type','hotels.nom_hotel','hotels.ville_hotel')
            ->get();
        $reservations = Reservation_chambre::where('reservation_chambres.user_id', '=', Auth::user()->id)
            ->join('users', 'users.id', '=', 'reservation_chambres.posteur_id')
            ->join('chambres', 'chambres.id', '=', 'reservation_chambres.chambre_id')
            ->join('hotels', 'hotels.id', '=', 'chambres.hotel_id')
            ->select('reservation_chambres.id','reservation_chambres.email', 'reservation_chambres.telephone', 'reservation_chambres.date_debut', 'reservation_chambres.date_fin', 'reservation_chambres.nombre_personnes', 'reservation_chambres.prix', 'reservation_chambres.status', 'users.nom_complete', 'chambres.type', 'hotels.nom_hotel', 'hotels.ville_hotel')
            ->get();
        $reservations_voyage = Reservation_voyage::where('user_id', '=', Auth::user()->id)->get();
        // return $user;
        return view('admin.detail', compact('user','hotels','hotel_personnel','reservations_voyage','reservations','commandes'));
    }

    public function getChambres($hotelId)
    {
        $chambres = Chambre::where('hotel_id', $hotelId)->get();

        return $chambres;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update_compte(Request $request)
    {
        $user = User::findorFail($request->user_id);
        $user->nom_complete = $request->nom_complete;
        $user->email = $request->email;
        $user->adresse = $request->adresse;
        $user->num_tel = $request->num_tel;
        $user->save();

        // $notification = new ModelsNotification();
        // $notification->message = 'Vous avez modifier votre compte avec succès';
        // $notification->user_id = Auth::user()->id;
        // $notification->save();

        return redirect()->back()->with('success','Modification de compte avec succès');
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'password_actuelle' => 'required|min:8',
            'password' => 'required|min:8',
            'password_confirme' => 'required|same:password',
        ]);
        $user = Auth::user();
        // Check if the current password is correct
        if (!Hash::check($request->password_actuelle, $user->password)) {
            return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect.');
        }
        try {
            $user->password = Hash::make($request->password);
            return redirect()->back()->with('success', 'La modification de mot de passe a été effectuée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error' ,'Une erreur est survenue lors de la modification de mot de passe. Veuillez réessayer.');
        }
    }

    public function destroy($id)
    {
        User::findorFail($id)->delete();
        return redirect()->back()->with('success','L\'utilisateur a été supprimée avec succès');
    }

    public function destroy_compte($id)
    {
        User::findorFail($id)->delete();
        $hotel_maroc = Hotel::where('pays_hotel','maroc')->take(2)->get();
        $hotel_monde = Hotel::where('pays_hotel','!=','maroc')->take(2)->get();
        $voyages = Voyage::All()->take(2);
        $hotelCounts = Hotel::query()
                ->select('ville_hotel', DB::raw('count(*) as total'))
                ->groupBy('ville_hotel')
                ->get();
        if(Auth::user()){
            $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
            return view('welcome', compact('hotel_monde','hotelCounts', 'voyages','hotel_maroc','hotel_personnel'));
        }
        return view('welcome', compact('hotel_monde','hotelCounts', 'voyages','hotel_maroc'))->with('success','Le compte a été supprimée avec succès');
    }
}
