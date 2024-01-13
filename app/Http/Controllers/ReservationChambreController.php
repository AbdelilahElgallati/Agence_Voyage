<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use App\Models\Reservation_chambre;
use App\Models\Hotel;
use App\Models\Notification as ModelsNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationChambreController extends Controller
{
    public function commande_chambre()
    {
        $commandes = Reservation_chambre::where('posteur_id', '=', Auth::user()->id)
            ->where('reservation_chambres.status', '=', 'En attent')
            ->join('users', 'users.id', '=', 'reservation_chambres.user_id')
            ->join('chambres','chambres.id', '=','reservation_chambres.chambre_id')
            ->join('hotels', 'hotels.id', '=', 'chambres.hotel_id')
            ->select('reservation_chambres.id','users.email','users.num_tel','users.nom_complete','reservation_chambres.date_debut','reservation_chambres.date_fin','reservation_chambres.nbr_personne','reservation_chambres.prix','reservation_chambres.status','chambres.type','hotels.nom_hotel','hotels.ville_hotel')
            ->get();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('chambre.commande_chambre',compact('commandes','hotel_personnel'));
    }

    public function reservation_chambre()
    {
        $reservations = Reservation_chambre::where('reservation_chambres.user_id', '=', Auth::user()->id)
        ->join('users', 'users.id', '=', 'reservation_chambres.posteur_id')
        ->join('chambres', 'chambres.id', '=', 'reservation_chambres.chambre_id')
        ->join('hotels', 'hotels.id', '=', 'chambres.hotel_id')
        ->select('reservation_chambres.id','users.email','users.num_tel','users.nom_complete','reservation_chambres.date_debut','reservation_chambres.date_fin','reservation_chambres.nbr_personne','reservation_chambres.prix','reservation_chambres.status','chambres.type','hotels.nom_hotel','hotels.ville_hotel')
        ->get();
        $hotel_personnel = Hotel::where('user_id',Auth()->user()->id)->get();
        return view('chambre.reservation_chambre', compact('reservations','hotel_personnel'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Vérifier la disponibilité de la chambre dans la période de réservation
        $chambre = Chambre::findOrFail($request->input('chambre_id'));
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');

        $reservationsExistantes = Reservation_chambre::where('chambre_id', $request->input('chambre_id'))
            ->where(function ($query) use ($dateDebut, $dateFin) {
                $query->where(function ($subQuery) use ($dateDebut, $dateFin) {
                    $subQuery->where('date_debut', '>=', $dateDebut)
                        ->where('date_debut', '<', $dateFin);
                })->orWhere(function ($subQuery) use ($dateDebut, $dateFin) {
                    $subQuery->where('date_fin', '>', $dateDebut)
                        ->where('date_fin', '<=', $dateFin);
                })->orWhere(function ($subQuery) use ($dateDebut, $dateFin) {
                    $subQuery->where('date_debut', '<=', $dateDebut)
                        ->where('date_fin', '>=', $dateFin);
                });
            })->count();

        if ($reservationsExistantes > 0) {
            return redirect()->back()->with('error', 'La chambre est déjà réservée pour cette période');
        }

        else {
            $date_debut = Carbon::createFromFormat('Y-m-d', $request->input('date_debut'));
            $date_fin = Carbon::createFromFormat('Y-m-d', $request->input('date_fin'));
            $nombre_jours = $date_debut->diffInDays($date_fin);
            $prix_totale = $nombre_jours * $request->input('prix');

            $reservation = new Reservation_chambre();
            $reservation->chambre_id = $request->input('chambre_id');
            $reservation->user_id = $request->input('user_id');
            $reservation->posteur_id = $request->input('posteur_id');
            $reservation->date_debut = $request->input('date_debut');
            $reservation->date_fin = $request->input('date_fin');
            $reservation->nbr_personne = $request->input('nombre_personnes');
            $reservation->prix = $prix_totale ;
            $reservation->save();

            $chambre = Chambre::where('id', $request->input('chambre_id'))->first();
            $hotel = Hotel::where('id', $chambre->hotel_id)->first();

            $notification = new ModelsNotification();
            $notification->message = Auth::user()->nom_complete . ' a reserver la chambre '. $chambre->type .' d\'hotel '. $hotel->nom_hotel;
            $notification->user_id = $hotel->user_id;
            $notification->role = 'hotel';
            $notification->save();

            $notification = new ModelsNotification();
            $notification->message = 'Vous avez reserver la chambre '. $chambre->type .' d\'hotel '. $hotel->nom_hotel .' avec succès';
            $notification->user_id = Auth::user()->id;
            $notification->role = 'user';
            $notification->save();


            return redirect()->route('home')->with('success', 'Votre réservation a été enregistrée avec succès!');
        }
    }

    public function show(Reservation_chambre $reservation_chambre)
    {
        //
    }

    public function edit(Reservation_chambre $reservation_chambre)
    {
        //
    }

    public function update(Request $request)
    {
        $commande = Reservation_chambre::findOrFail($request->commande_id);
        $chambre = Chambre::where('id', $commande->chambre_id)->first();
        $hotel = Hotel::where('id', $chambre->hotel_id)->first();

        // Vérifier si la commande est pour accepter ou refuser
        if ($request->has('accepter')) {
            $commande->status = 'acceptée';

            $notification = new ModelsNotification();
            $notification->message = 'Vous avez accepté la reservation de '. $chambre->type .' d\'hotel '. $hotel->nom_hotel;
            $notification->user_id = $hotel->user_id;
            $notification->role = 'hotel';
            $notification->save();

            $notification = new ModelsNotification();
            $notification->message = 'Votre reservation de '. $chambre->type .' d\'hotel '. $hotel->nom_hotel .' a été accepter';
            $notification->user_id = $commande->user_id ;
            $notification->role = 'user';
            $notification->save();

        } elseif ($request->has('refuser')) {
            $commande->status = 'refusée';

            $notification = new ModelsNotification();
            $notification->message = 'Vous avez refusé la reservation de '. $chambre->type .' d\'hotel '. $hotel->nom_hotel ;
            $notification->user_id = $hotel->user_id;
            $notification->role = 'hotel';
            $notification->save();

            $notification = new ModelsNotification();
            $notification->message = 'Votre reservation de '. $chambre->type .' d\'hotel '. $hotel->nom_hotel .' a été refuser'; ;
            $notification->user_id = $commande->user_id;
            $notification->role = 'user';
            $notification->save();

        } else {
            return redirect()->back()->with('error', 'Une erreur est survenue');
        }



        try {
            $commande->save();
            return redirect()->back()->with('success', 'La réservation a été mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : '.$e->getMessage());
        }
    }

    public function imprimer(Request $request)
    {
        $reservationId = $request->input('reservation_id');
        // Récupérer la réservation à imprimer
        $reservation = Reservation_chambre::find($reservationId);
        $chambre = Chambre::where('id', $reservation->chambre_id)->first();
        $hotel = Hotel::where('id', $chambre->hotel_id)->first();

        if ($reservation) {
            // Vous pouvez personnaliser le format et la mise en page de votre carte d'impression ici
            $html = '<div class="col-md-12">';
            $html .=     '<div class="card shadow  bg-white" id="card-recommandation" style="border-radius: 10px;box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);">';
            $html .=        '<div class="row">';
            $html .=            '<div class="col-sm-4">';
            $html .=                '<img style="height: -webkit-fill-available;max-height: 350px;" style="object-fit: cover;border-top-left-radius: 10px;border-top-right-radius: 10px;animation-duration: 1s;animation-fill-mode: both;" src="'. asset('image/' . $chambre->image) .'" class="card-img-top" alt="">';
            $html .=            '</div>';
            $html .=            '<div class="col-sm-8">';
            $html .=                '<h2 class="card-title col-sm-12 text-center">Carte de réservation</h2>';
            $html .=                '<div class="card-body">';
            $html .=                    '<div class="row" style="align-items: center;">';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Nom complete: ' . Auth::user()->nom_complete . '</p>';
            $html .=                        '</div>';
            $html .=                        '<div class="col-sm-6 ">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Nom d\'hotel: ' . $hotel->nom_hotel . '</p>';
            $html .=                        '</div>';
            $html .=                    '</div>';
            $html .=                    '<hr>';
            $html .=                    '<div class="row" style="align-items: center;">';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Ville: ' . $hotel->ville_hotel . '</p>';
            $html .=                        '</div>';
            $html .=                        '<div class="col-sm-6 ">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Pays: ' . $hotel->pays_hotel . '</p>';
            $html .=                        '</div>';
            $html .=                    '</div>';
            $html .=                    '<hr>';
            $html .=                    '<div class="row" style="align-items: center;">';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Date de début: ' . $reservation->date_debut . '</p>';
            $html .=                        '</div>';
            $html .=                        '<div class="col-sm-6 ">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Date de fin: ' . $reservation->date_fin . '</p>';
            $html .=                        '</div>';
            $html .=                    '</div>';
            $html .=                    '<hr>';
            $html .=                    '<div class="row" style="align-items: center;">';
            $html .=                        '<div class="col-sm-6" >';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Nombre de personnes: ' . $reservation->nbr_personne . '</p>';
            $html .=                        '</div>';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Type de chambre: ' . $chambre->type . '</p>';
            $html .=                        '</div>';
            $html .=                    '</div>';
            $html .=                    '<hr>';
            $html .=                    '<div class="row" style="align-items: center;">';
            $html .=                        '<div class="col-sm-6">';
            $html .=                            '<p class="card-text" style="color: #777;font-size: 18px;">Prix: ' . $reservation->prix . ' MAD</p>';
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
            return view('chambre.imprimer')->with('html', $html);
        } else {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }
    }

    public function destroy($id)
    {
        Reservation_chambre::where('id',$id)->delete();
        return redirect()->back()->with('success','La reservation a été supprimée avec succès');
    }
}
