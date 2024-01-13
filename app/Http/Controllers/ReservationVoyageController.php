<?php

namespace App\Http\Controllers;

use App\Models\Reservation_voyage;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Voyage;
use App\Models\Notification as ModelsNotification;
use Illuminate\Support\Facades\Auth;

class ReservationVoyageController extends Controller
{
    public function index()
    {
        $commandes = Reservation_voyage::when(Auth()->user()->role === 'admin', function ($query) {
            $query->where('reservation_voyages.id', '>', 0);
            })
            ->join('voyages', 'voyages.id', '=', 'reservation_voyages.voyage_id')
            ->join('users', 'users.id', '=', 'reservation_voyages.user_id')
            ->select('reservation_voyages.id','voyages.ville_voyage','users.nom_complete','users.email','users.num_tel','voyages.date_debut_voyage','voyages.date_fin_voyage','reservation_voyages.nombre_personnes','reservation_voyages.prix','reservation_voyages.status','reservation_voyages.user_id','reservation_voyages.voyage_id','voyages.nbr_place_reste_voyage')
            ->get();
        return view('voyage.commande_voyage', compact('commandes'));
    }

    public function reservation_voyage()
    {
        $reservations = Reservation_voyage::where('reservation_voyages.user_id', '=', Auth::user()->id)
            ->join('voyages', 'voyages.id', '=', 'reservation_voyages.voyage_id')
            ->join('users', 'users.id', '=', 'reservation_voyages.user_id')
            ->select('reservation_voyages.id','voyages.ville_voyage','users.nom_complete','users.email','users.num_tel','voyages.date_debut_voyage','voyages.date_fin_voyage','reservation_voyages.nombre_personnes','reservation_voyages.prix','reservation_voyages.status','reservation_voyages.user_id','reservation_voyages.voyage_id','voyages.nbr_place_reste_voyage')
            ->get();
        return view('voyage.reservation_voyage',compact('reservations'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_personnes' => 'required|numeric|min:1',
            'prix' => 'required|numeric|min:0',
        ]);
        $voyage = Voyage::findOrFail($request->input('voyage_id'));
        if($voyage->nbr_place_reste_voyage == 0){
            return redirect()->back()->with('error','Il ne reste plus de places disponibles.');
        }else{
            $prix_total = $validatedData['nombre_personnes'] * $validatedData['prix'];
            $reservation = new Reservation_voyage();
            $reservation->voyage_id = $request->input('voyage_id');
            $reservation->user_id = $request->input('user_id');
            $reservation->nombre_personnes = $validatedData['nombre_personnes'];
            $reservation->Prix = $prix_total;
            $reservation->save();

            $notification = new ModelsNotification();
            $notification->message = Auth::user()->nom_complete . ' a reserver la voyage organisés à '. $request->input('ville') ;
            $notification->user_id = $voyage->user_id;
            $notification->role = 'admin';
            $notification->save();

            $notification = new ModelsNotification();
            $notification->message = 'Vous avez reserver la voyage organisés à '. $request->input('ville') .' avec succès';
            $notification->user_id = Auth::user()->id;
            $notification->role = 'user';
            $notification->save();

            return redirect()->back()->with('success', 'Votre réservation a été enregistrée avec succès!');
        }

    }


    public function show(Reservation_voyage $reservation_voyage)
    {
        //
    }

    public function edit(Reservation_voyage $reservation_voyage)
    {
        //
    }

    public function update(Request $request)
    {
        $commande = Reservation_voyage::findOrFail($request->commande_id);
        if ($request->has('accepter')) {
            $commande->status = 'acceptée';

            $voyage = Voyage::findOrFail($request->voyage_id);
            $voyage->nbr_place_reste_voyage = $voyage->nbr_place_reste_voyage - $commande->nbr_personnes;
            $voyage->save();

            $notification = new ModelsNotification();
            $notification->message = 'Vous avez acceptez la reservation de voyage organisés à '.$voyage->ville_voyage ;
            $notification->user_id = Auth::user()->id;
            $notification->role = 'admin';
            $notification->save();

            $notification = new ModelsNotification();
            $notification->message = 'Votre reservation de voyage à '.$voyage->ville_voyage .' a été accepter' ;
            $notification->user_id = $commande->user_id;
            $notification->role = 'user';
            $notification->save();


        } elseif ($request->has('refuser')) {
            $commande->status = 'refusée';

            $voyage = Voyage::findOrFail($request->voyage_id);

            $notification = new ModelsNotification();
            $notification->message = 'Vous avez refusé la reservation de voyage organisés à '.$voyage->ville_voyage ;
            $notification->user_id = Auth::user()->id;
            $notification->role = 'admin';
            $notification->save();

            $notification = new ModelsNotification();
            $notification->message = 'Votre reservation de voyage à '.$voyage->ville_voyage .' a été refuser'; ;
            $notification->user_id = $commande->user_id;
            $notification->role = 'user';
            $notification->save();
        } else {
            return redirect()->back()->with('error', 'Une erreur est survenue');
        }
        try {
            $commande->save();
            return redirect()->back()->with('success', 'La commande a été mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : '.$e->getMessage());
        }
    }

    public function imprimer(Request $request)
    {
        $reservationId = $request->input('reservation_id');
        // Récupérer la réservation à imprimer
        $reservation = Reservation_voyage::find($reservationId);
        $voyage = Voyage::where('id', $reservation->voyage_id)->first();

        if ($reservation) {
            // Vous pouvez personnaliser le format et la mise en page de votre carte d'impression ici
            $html = '<div class="col-md-12">';
            $html .=     '<div class="card shadow  bg-white" id="card-recommandation" style="border-radius: 10px;box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);">';
            $html .=        '<div class="row">';
            $html .=            '<div class="col-sm-4">';
            $html .=                '<img style="height: -webkit-fill-available;max-height: 300px;" style="object-fit: cover;border-top-left-radius: 10px;border-top-right-radius: 10px;animation-duration: 1s;animation-fill-mode: both;" src="'. asset('image/' . $voyage->image_voyage) .'" class="card-img-top" alt="">';
            $html .=            '</div>';
            $html .=            '<div class="col-sm-8">';
            $html .=                '<h2 class="card-title col-sm-12 text-center">Carte de réservation</h2>';
            $html .=                '<div class="card-body">';
            $html .=                    '<div class="row" style="align-items: center;">';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Nom complete: ' . Auth::user()->nom_complete . '</p>';
            $html .=                        '</div>';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Prix: ' . $reservation->Prix . ' MAD</p>';
            $html .=                        '</div>';
            $html .=                    '</div>';
            $html .=                    '<hr>';
            $html .=                    '<div class="row" style="align-items: center;">';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Ville: ' . $voyage->ville_voyage . '</p>';
            $html .=                        '</div>';
            $html .=                        '<div class="col-sm-6 ">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Pays: ' . $voyage->pays_voyage . '</p>';
            $html .=                        '</div>';
            $html .=                    '</div>';
            $html .=                    '<hr>';
            $html .=                    '<div class="row" style="align-items: center;">';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Date de début: ' . $voyage->date_debut_voyage . '</p>';
            $html .=                        '</div>';
            $html .=                        '<div class="col-sm-6 ">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Date de fin: ' . $voyage->date_fin_voyage . '</p>';
            $html .=                        '</div>';
            $html .=                    '</div>';
            $html .=                    '<hr>';
            $html .=                    '<div class="row" style="align-items: center;">';
            $html .=                        '<div class="col-sm-6" >';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Nombre de personnes: ' . $reservation->nombre_personnes . '</p>';
            $html .=                        '</div>';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Numéro de téléphone: ' . Auth::user()->num_tel . '</p>';
            $html .=                        '</div>';
            $html .=                    '</div>';
            $html .=                '</div>';
            $html .=            '</div>';
            $html .=        '</div>';
            $html .=    '</div>';
            $html .='</div>';

            return view('voyage.imprimer')->with('html', $html);
        } else {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }
    }

    public function destroy($id)
    {
        Reservation_voyage::where('id',$id)->delete();
        return redirect()->back()->with('success','La reservation a été supprimée avec succès');
    }
}
