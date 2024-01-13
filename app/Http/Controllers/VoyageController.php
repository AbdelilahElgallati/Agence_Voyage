<?php

namespace App\Http\Controllers;

use App\Models\Voyage;
use App\Models\Hotel;
use App\Models\Notification as ModelsNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class VoyageController extends Controller
{
    public function index()
    {
        $voyages = Voyage::all();
        return view("voyage.voyage",compact("voyages"));
    }

    public function all_voyage()
    {
        $voyages = Voyage::all();
        return view('admin.voyage',compact("voyages"));
    }

    public function create()
    {
        return view('voyage.ajoute_voyage');
    }

    public function store(Request $request)
    {
        $images = $request->file('image_voyage');
        $imagePaths = [];
        foreach ($images as $image) {
            $imagePath = $image->storeAs(
                'image-voyage', time() . '_' . $image->getClientOriginalName(), 'images'
            );
            $imagePaths[] = $imagePath;
        }
        $voyage = new Voyage();
        $voyage->pays_voyage = $request->pays_voyage;
        $voyage->ville_voyage = $request->ville_voyage;
        $voyage->date_debut_voyage = $request->date_debut_voyage;
        $voyage->date_fin_voyage = $request->date_fin_voyage;
        $voyage->nbr_personne_voyage = $request->nbr_personne_voyage;
        $voyage->nbr_place_reste_voyage = $request->nbr_personne_voyage;
        $voyage->numero_tel_voyage = $request->numero_tel_voyage;
        $voyage->type_hibergement = $request->type_hibergement;
        $voyage->image_voyage = implode('|', $imagePaths);
        $voyage->prix_voyage = $request->prix_voyage;
        $voyage->user_id = $request->user_id;
        $voyage->save();

        return redirect()->route('home.admin.voyage')->with('success', 'La voyage a été enregistrer avec succès.');
    }

    public function show(Voyage $voyage)
    {
        //
    }

    public function edit($id)
    {
        $voyage = Voyage::findorFail($id);
        return view('voyage.modification_voyage',compact("voyage"));
    }

    public function update(Request $request, $id)
    {
        $voyage = Voyage::findorFail($id);
        $voyage->pays_voyage = $request->pays_voyage;
        $voyage->ville_voyage = $request->ville_voyage;
        $voyage->date_debut_voyage = $request->date_debut_voyage;
        $voyage->date_fin_voyage = $request->date_fin_voyage;
        $voyage->nbr_personne_voyage = $request->nbr_personne_voyage;
        $voyage->nbr_place_reste_voyage = $request->nbr_place_reste_voyage;
        $voyage->type_hibergement = $request->type_hibergement;
        if($request->file('image_voyage') != null){
            $images = $request->file('image_voyage');
            $imagePaths = [];
            foreach ($images as $image) {
                $imagePath = $image->storeAs(
                    'image-voyage', time() . '_' . $image->getClientOriginalName(), 'images'
                );
                $imagePaths[] = $imagePath;
            }
            $voyage->image_voyage = implode('|', $imagePaths);
        }
        $voyage->prix_voyage = $request->prix_voyage;
        $voyage->user_id = $request->user_id;
        $voyage->save();


        return redirect()->route('home.admin.voyage')->with('success', 'La modification de voyage a été effectuée avec succès.');
    }

    public function search_voyage_admin(Request $request)
    {
        $ville = $request->input('ville');
        $pays = $request->input('pays');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $prixMin = $request->input('prix_min');
        $prixMax = $request->input('prix_max');

        $voyages = Voyage::query()
            ->when($ville, function ($query) use ($ville) {
                $query->where('ville_voyage', $ville);
            })
            ->when($pays, function ($query) use ($pays) {
                $query->where('pays_voyage', $pays);
            })
            ->when($dateDebut, function ($query) use ($dateDebut) {
                $query->where('date_debut_voyage', '>=', $dateDebut);
            })
            ->when($dateFin, function ($query) use ($dateFin) {
                $query->where('date_fin_voyage', '<=', $dateFin);
            })
            ->when($prixMin, function ($query) use ($prixMin) {
                $query->where('prix_voyage', '>=', $prixMin);
            })
            ->when($prixMax, function ($query) use ($prixMax) {
                $query->where('prix_voyage', '<=', $prixMax);
            })
            ->get();
        return view('admin.voyage',compact('voyages'));
    }

    public function search_voyage(Request $request)
    {
        $ville = $request->input('ville');
        $pays = $request->input('pays');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $prixMin = $request->input('prix_min');
        $prixMax = $request->input('prix_max');

        $voyages = Voyage::query()
            ->when($ville, function ($query) use ($ville) {
                $query->where('ville_voyage', $ville);
            })
            ->when($pays, function ($query) use ($pays) {
                $query->where('pays_voyage', $pays);
            })
            ->when($dateDebut, function ($query) use ($dateDebut) {
                $query->where('date_debut_voyage', '>=', $dateDebut);
            })
            ->when($dateFin, function ($query) use ($dateFin) {
                $query->where('date_fin_voyage', '<=', $dateFin);
            })
            ->when($prixMin, function ($query) use ($prixMin) {
                $query->where('prix_voyage', '>=', $prixMin);
            })
            ->when($prixMax, function ($query) use ($prixMax) {
                $query->where('prix_voyage', '<=', $prixMax);
            })
            ->get();
        return view("voyage.voyage",compact('voyages'));
    }

    public function destroy($id)
    {
        Voyage::where('id',$id)->delete();
        return redirect()->back()->with('success','La voyage a été supprimée avec succès');
    }
}
