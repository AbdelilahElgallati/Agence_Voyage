<?php

namespace App\Http\Controllers;

use App\Models\DemandeOffre;
use App\Models\Hotel;
use App\Models\Notification as ModelsNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view("hotel.hotel",compact("hotels",'hotel_personnel'));
    }

    public function gestion()
    {
        $hotels = Hotel::where('user_id', Auth::user()->id)->get();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('hotel.gestion_hotel',compact("hotels",'hotel_personnel'));
    }

    public function hotel_admin()
    {
        $hotels = Hotel::all();
        $hotel_personnel = Hotel::where('user_id',Auth::user()->id)->get();
        return view('admin.hotel',compact("hotels",'hotel_personnel'));
    }

    public function search_hotel(Request $request)
    {
        $nom_hotel = $request->input('nom_hotel');
        $ville_hotel = $request->input('ville_hotel');
        $pays_hotel = $request->input('pays_hotel');
        $type_hotel = $request->input('type_hotel');
        $prix_min = is_numeric($request->input('prix_hotel_min')) ? $request->input('prix_hotel_min') : 0;
        $prix_max = is_numeric($request->input('prix_hotel_max')) ? $request->input('prix_hotel_max') : PHP_INT_MAX;
        $nbr_etoil_hotel = $request->input('nbr_etoil_hotel');
        $query = Hotel::query();
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
        $hotels = $query->get();
        $hotel_personnel = Hotel::where('user_id', Auth()->user()->id)->get();
        return view('hotel.hotel', compact('hotels','hotel_personnel'));
    }

    public function search_hotel_admin(Request $request)
    {
        $nom_hotel = $request->input('nom_hotel');
        $ville_hotel = $request->input('ville_hotel');
        $pays_hotel = $request->input('pays_hotel');
        $type_hotel = $request->input('type_hotel');
        $prix_min = is_numeric($request->input('prix_hotel_min')) ? $request->input('prix_hotel_min') : 0;
        $prix_max = is_numeric($request->input('prix_hotel_max')) ? $request->input('prix_hotel_max') : PHP_INT_MAX;
        $nbr_etoil_hotel = $request->input('nbr_etoil_hotel');
        $query = Hotel::query();
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
        $hotels = $query->get();
        $hotel_personnel = Hotel::where('user_id', Auth()->user()->id)->get();
        return view('admin.hotel',compact("hotels",'hotel_personnel'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $hotel = new Hotel();
        $hotel->nom_hotel = $request->nom_hotel;
        $hotel->pays_hotel = $request->pays_hotel;
        $hotel->ville_hotel = $request->ville_hotel;
        $hotel->adresse_hotel = $request->adresse_hotel;
        $hotel->num_tel_hotel = $request->num_tel_hotel;
        $hotel->image_hotel = $request->image_hotel;
        $hotel->contrat_hotel = $request->contrat_hotel;
        $hotel->type_hotel = $request->type_hotel;
        $hotel->nbr_etoil_hotel = $request->nbr_etoil_hotel;
        $hotel->prix_hotel = $request->prix_hotel;
        $hotel->user_id = $request->user_id;
        $hotel->save();

        $user = User::where('id', $request->user_id)->first();
        $user->hotel = 'true';
        $user->save();


        DemandeOffre::where('id',$request->id)->delete();

        $notification = new ModelsNotification();
        $notification->message = 'Votre demande d\'offre d\'hotel '.$hotel->nom_hotel. ' a été accepter' ;
        $notification->user_id = $request->user_id;
        $notification->role = 'user';
        $notification->save();

        $notification = new ModelsNotification();
        $notification->message = 'Votre demande d\'offre d\'hotel '.$hotel->nom_hotel. ' a été accepter' ;
        $notification->user_id = $request->user_id;
        $notification->role = 'hotel';
        $notification->save();

        $notification = new ModelsNotification();
        $notification->message = 'Vous avez acceptée la demande d\'offre d\'hotel '.$hotel->nom_hotel ;
        $notification->user_id = Auth::user()->id;
        $notification->role = 'admin';
        $notification->save();

        return redirect()->route('home.admin.hotel')->with('success', 'L\'hotel a été ajouté avec succès.');
    }

    public function show(Hotel $hotel)
    {
        //
    }

    public function edit($id)
    {
        $hotel = Hotel::findorFail($id);
        $hotel_personnel = Hotel::where('user_id',Auth::user()->id)->get();
        return view('hotel.modification_hotel',compact("hotel",'hotel_personnel'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findorFail($id);
        $hotel->nom_hotel = $request->nom_hotel;
        $hotel->pays_hotel = $request->pays_hotel;
        $hotel->ville_hotel = $request->ville_hotel;
        $hotel->adresse_hotel = $request->adresse_hotel;
        $hotel->num_tel_hotel = $request->num_tel_hotel;
        if($request->file('image_hotel') != null){
            $images = $request->file('image_hotel');
            $imagePaths = [];
            foreach ($images as $image) {
                $imagePath = $image->storeAs(
                    'image-hotel', time() . '_' . $image->getClientOriginalName(), 'images'
                );
                $imagePaths[] = $imagePath;
            }
            $hotel->image_hotel = implode('|', $imagePaths);
        }
        if($request->file('contrat_hotel') != null){
            $hotel->contrat_hotel = $request->file('contrat_hotel')->storeAs(
                'contrat-hotel', time() . '_' . $request->file('contrat_hotel')->getClientOriginalName(), 'images'
            );
        }
        $hotel->type_hotel = $request->type_hotel;
        $hotel->nbr_etoil_hotel = $request->nbr_etoil_hotel;
        $hotel->prix_hotel = $request->prix_hotel;
        $hotel->user_id = $request->user_id;
        $hotel->save();
        return redirect()->route('home.hotel.chambre.gestion',$hotel->id)->with('success', 'La modification de hotel a été effectuée avec succès.');
    }

    public function destroy($id)
    {
        Hotel::findorFail($id)->delete();
        return redirect()->back()->with('success', 'L\'hotel a été supprimer avec succès.');
    }
}
