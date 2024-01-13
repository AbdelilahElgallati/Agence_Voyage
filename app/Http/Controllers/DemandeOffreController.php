<?php

namespace App\Http\Controllers;

use App\Models\DemandeOffre;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\User;
use App\Models\Notification as ModelsNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DemandeOffreController extends Controller
{
    public function index()
    {
        $demandes = DemandeOffre::all();
        return view('admin.demande',compact("demandes"));
    }

    public function search_demande_admin(Request $request)
    {
        $nom_hotel = $request->input('nom_hotel');
        $ville_hotel = $request->input('ville_hotel');
        $pays_hotel = $request->input('pays_hotel');
        $type_hotel = $request->input('type_hotel');
        $prix_min = is_numeric($request->input('prix_hotel_min')) ? $request->input('prix_hotel_min') : 0;
        $prix_max = is_numeric($request->input('prix_hotel_max')) ? $request->input('prix_hotel_max') : PHP_INT_MAX;
        $nbr_etoil_hotel = $request->input('nbr_etoil_hotel');
        $query = DemandeOffre::query();
        if ($nom_hotel) {
            $query->where('nom_hotel', 'like', '%' . $nom_hotel. '%');
        }
        if ($ville_hotel) {
            $query->where('ville_hotel', 'like', '%' . $ville_hotel. '%');
        }
        if ($pays_hotel) {
            $query->where('pays_hotel',  'like', '%' . $pays_hotel. '%');
        }
        if ($type_hotel) {
            $query->where('type_hotel', $type_hotel);
        }
        if ($prix_min) {
            $query->where('prix_hotel', '>=', $prix_min);
        }
        if ($prix_max) {
            $query->where('prix_hotel', '<=', $prix_max);
        }
        if ( $nbr_etoil_hotel ) {
            $query->where('nbr_etoil_hotel', $nbr_etoil_hotel);
        }
        $demandes = $query->get();
        return view('admin.demande',compact('demandes'));
    }

    public function create()
    {
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('hotel.demande_hotel',compact('hotel_personnel'));
    }
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function store(Request $request)
    {
        $user = new User();
        $user->nom_complete = $request->nom_complete;
        $user->email = $request->email;
        $user->num_tel = $request->num_tel;
        $user->adresse = $request->adresse;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        $images = $request->file('image_hotel');
        $imagePaths = [];
        foreach ($images as $image) {
            $imagePath = $image->storeAs('image-hotel', time() . '_' . $image->getClientOriginalName(), 'images');
            $imagePaths[] = $imagePath;
        }
        $demande = new DemandeOffre();
        $demande->nom_hotel = $request->nom_hotel;
        $demande->pays_hotel = $request->pays_hotel;
        $demande->ville_hotel = $request->ville_hotel;
        $demande->adresse_hotel = $request->adresse_hotel;
        $demande->num_tel_hotel = $request->num_tel_hotel;
        $demande->image_hotel = implode('|', $imagePaths);
        $demande->contrat_hotel = $request->file('contrat_hotel')->storeAs(
            'contrat-hotel', time() . '_' . $request->file('contrat_hotel')->getClientOriginalName(), 'images'
        );
        $demande->type_hotel = $request->type_hotel;
        $demande->nbr_etoil_hotel = $request->nbr_etoil_hotel;
        $demande->prix_hotel = $request->prix_hotel;
        $demande->user_id = $user->id;
        $demande->save();

        $notification = new ModelsNotification();
        $notification->message = Auth::user()->nom_complete . ' a demander une offre d\'hotel';
        $notification->user_id = Auth::user()->id;
        $notification->role = 'admin';
        $notification->save();

        $notification = new ModelsNotification();
        $notification->message = 'Votre demande a été envoyer avec success';
        $notification->user_id = Auth::user()->id;
        $notification->role = 'user';
        $notification->save();

        return redirect()->route('home');
    }

    public function store_demande(Request $request)
    {
        $images = $request->file('image_hotel');
        $imagePaths = [];
        foreach ($images as $image) {
            $imagePath = $image->storeAs('image-hotel', time() . '_' . $image->getClientOriginalName(), 'images');
            $imagePaths[] = $imagePath;
        }
        $demande = new DemandeOffre();
        $demande->nom_hotel = $request->nom_hotel;
        $demande->pays_hotel = $request->pays_hotel;
        $demande->ville_hotel = $request->ville_hotel;
        $demande->adresse_hotel = $request->adresse_hotel;
        $demande->num_tel_hotel = $request->num_tel_hotel;
        $demande->image_hotel = implode('|', $imagePaths);
        $demande->contrat_hotel = $request->file('contrat_hotel')->storeAs(
            'contrat-hotel', time() . '_' . $request->file('contrat_hotel')->getClientOriginalName(), 'images'
        );
        $demande->type_hotel = $request->type_hotel;
        $demande->nbr_etoil_hotel = $request->nbr_etoil_hotel;
        $demande->prix_hotel = $request->prix_hotel;
        $demande->user_id = $request->user_id;
        $demande->save();

        $notification = new ModelsNotification();
        $notification->message = Auth::user()->nom_complete . ' a demander une offre d\'hotel';
        $notification->user_id = Auth::user()->id;
        $notification->role = 'admin';
        $notification->save();

        $notification = new ModelsNotification();
        $notification->message = 'Votre demande a été envoyer avec success';
        $notification->user_id = Auth::user()->id;
        $notification->role = 'user';
        $notification->save();

        return redirect()->route('home_hotel')->with('success', 'demande envoyer avec success');
    }

    public function show(DemandeOffre $demandeOffre)
    {
        //
    }

    public function edit(DemandeOffre $demandeOffre)
    {
        //
    }

    public function update(Request $request, DemandeOffre $demandeOffre)
    {
        //
    }

    public function destroy($id)
    {
        $demande = DemandeOffre::findorFail($id)->get();

        $notification = new ModelsNotification();
        $notification->message = 'Votre demande d\'offre d\'hotel '.$demande->nom_hotel. 'a été refuser' ;
        $notification->user_id = $demande->user_id;
        $notification->role = 'user';
        $notification->save();

        $notification = new ModelsNotification();
        $notification->message = 'Vous avez refuser la demande d\'offre d\'hotel '.$demande->nom_hotel ;
        $notification->user_id = Auth::user()->id;
        $notification->role = 'admin';
        $notification->save();

        DemandeOffre::findorFail($id)->delete();

        return redirect()->back()->with('success', 'La demande a été refuser avec succès.');
    }
}
