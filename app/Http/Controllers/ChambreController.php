<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use App\Models\Hotel;
use App\Models\Notification as ModelsNotification;
use App\Models\Reservation_chambre;
use App\Models\Reservation_voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChambreController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $hotel_id = $request->hotel_id;
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('chambre.ajoute_chambre', compact('hotel_id','hotel_personnel'));
    }

    public function store(Request $request)
    {
        $images = $request->file('image');
        $imagePaths = [];
        foreach ($images as $image) {
            $imagePath = $image->storeAs(
                'image-chambre', time() . '_' . $image->getClientOriginalName(), 'images'
            );
            $imagePaths[] = $imagePath;
        }
        $chambre = new Chambre();
        $chambre->type = $request->type;
        $chambre->description = $request->description;
        $chambre->image = implode('|', $imagePaths);
        $chambre->occupation_maximale = $request->occupation_maximale;
        $chambre->type_lit= $request->type_lit;
        $chambre->taille = $request->taille;
        $chambre->prix_chambre = $request->prix_chambre;
        $chambre->hotel_id = $request->hotel_id;
        // $chambre->user_id_chambre = $request->user_id;
        $chambre->save();
        return redirect()->route('home.hotel.chambre.gestion',$chambre->hotel_id)->with('success', 'La chambre a été ajouté avec succès.');
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        $chambres = Chambre::where('hotel_id', $id)->get();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('chambre.gestion_chambre', compact("hotel", 'chambres','hotel_personnel'));
    }

    public function show_admin($id){
        $hotel = Hotel::findOrFail($id);
        $chambres = Chambre::where('hotel_id', $id)->get();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('admin.chambre', compact('hotel', 'chambres','hotel_personnel'));
    }

    public function chambre($id)
    {
        $hotel = Hotel::findOrFail($id);
        $chambres = Chambre::where('hotel_id', $id)->get();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('chambre.chambre', compact("hotel", 'chambres','hotel_personnel'));
    }

    public function chambre_detail($id)
    {
        $hotel = Hotel::findOrFail($id);
        $chambres = Chambre::where('hotel_id', $id)->get();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('admin.detail_hotel', compact('hotel', 'chambres','commandes','reservations','reservations_voyage','hotel_personnel'));
    }

    public function edit($id)
    {
        $chambre = chambre::findorFail($id);
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('chambre.modification_chambre',compact("chambre",'hotel_personnel'));
    }

    public function update(Request $request, $id)
    {
        $chambre = chambre::findorFail($id);
        $chambre->type = $request->type;
        $chambre->description = $request->description;
        if($request->file('image') != null){
            $images = $request->file('image');
            $imagePaths = [];
            foreach ($images as $image) {
                $imagePath = $image->storeAs(
                    'image-chambre', time() . '_' . $image->getClientOriginalName(), 'images'
                );
                $imagePaths[] = $imagePath;
            }
            $chambre->image = implode('|', $imagePaths);
        }
        $chambre->occupation_maximale = $request->occupation_maximale;
        $chambre->type_lit= $request->type_lit;
        $chambre->taille = $request->taille;
        $chambre->prix_chambre = $request->prix_chambre;
        $chambre->status = $request->status;
        $chambre->hotel_id = $request->hotel_id;
        // $chambre->user_id_chambre = $request->user_id;
        $chambre->save();
        return redirect()->route('home.hotel.chambre.gestion',$chambre->hotel_id)->with('success', 'La modification de chambre a été effectuée avec succès.');
    }

    public function search_chambre(Request $request, $id)
    {
        $typeChambre = $request->input('type');
        $occupationMaximale = $request->input('occupation_maximale');
        $typeLit = $request->input('type_lit');
        $taille = $request->input('taille');
        $prixChambre = $request->input('prix_chambre');

        $hotel = Hotel::findOrFail($id);
        $chambres = Chambre::query()
            ->where('hotel_id',$id)
            ->when($typeChambre, function ($query) use ($typeChambre) {
                $query->where('type', $typeChambre);
            })
            ->when($occupationMaximale, function ($query) use ($occupationMaximale) {
                $query->where('occupation_maximale', $occupationMaximale);
            })
            ->when($typeLit, function ($query) use ($typeLit) {
                $query->where('type_lit', $typeLit);
            })
            ->when($taille, function ($query) use ($taille) {
                $query->where('taille', $taille);
            })
            ->when($prixChambre, function ($query) use ($prixChambre) {
                $query->where('prix_chambre', '<=', $prixChambre);
            })
            ->get();

        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('chambre.chambre', compact("hotel", 'chambres','hotel_personnel'));
    }

    public function search_chambre_gestion(Request $request, $id)
    {
        $typeChambre = $request->input('type');
        $occupationMaximale = $request->input('occupation_maximale');
        $typeLit = $request->input('type_lit');
        $taille = $request->input('taille');
        $prixChambre = $request->input('prix_chambre');

        $hotel = Hotel::findOrFail($id);
        $chambres = Chambre::query()
            ->where('hotel_id',$id)
            ->when($typeChambre, function ($query) use ($typeChambre) {
                $query->where('type', $typeChambre);
            })
            ->when($occupationMaximale, function ($query) use ($occupationMaximale) {
                $query->where('occupation_maximale', $occupationMaximale);
            })
            ->when($typeLit, function ($query) use ($typeLit) {
                $query->where('type_lit', $typeLit);
            })
            ->when($taille, function ($query) use ($taille) {
                $query->where('taille', $taille);
            })
            ->when($prixChambre, function ($query) use ($prixChambre) {
                $query->where('prix_chambre', '<=', $prixChambre);
            })
            ->get();

        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('chambre.gestion_chambre', compact("hotel", 'chambres','hotel_personnel'));
    }

    public function search_chambre_admin(Request $request, $id){
        $typeChambre = $request->input('type');
        $occupationMaximale = $request->input('occupation_maximale');
        $typeLit = $request->input('type_lit');
        $taille = $request->input('taille');
        $prixChambre = $request->input('prix_chambre');

        $hotel = Hotel::findOrFail($id);
        $chambres = Chambre::query()
            ->where('hotel_id',$id)
            ->when($typeChambre, function ($query) use ($typeChambre) {
                $query->where('type', $typeChambre);
            })
            ->when($occupationMaximale, function ($query) use ($occupationMaximale) {
                $query->where('occupation_maximale', $occupationMaximale);
            })
            ->when($typeLit, function ($query) use ($typeLit) {
                $query->where('type_lit', $typeLit);
            })
            ->when($taille, function ($query) use ($taille) {
                $query->where('taille', $taille);
            })
            ->when($prixChambre, function ($query) use ($prixChambre) {
                $query->where('prix_chambre', '<=', $prixChambre);
            })
            ->get();
        return view('admin.chambre', compact('hotel', 'chambres'));
    }

    public function destroy($id)
    {
        Chambre::findorFail($id)->delete();
        return redirect()->back()->with('success', 'La chambre a été supprimer avec succès.');
    }

    public function destroy_admin($id)
    {
        Chambre::findorFail($id)->delete();
        return redirect()->back()->with('success', 'La chambre a été supprimer avec succès.');
    }
}
