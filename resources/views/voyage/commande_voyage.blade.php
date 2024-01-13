@extends('layouts.app_admin')

@section('content')
<div class="container" style="margin-top: 50px;">

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: absolute; margin-top: 1rem; margin-left: 12%; width: 65%;">
            <strong>Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute; margin-top: 1rem; margin-left: 12%; width: 65%;">
            <strong>Success:</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <hr>
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les commandes de voyages') }}</div>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Ville</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Nombre de personne</th>
                    <th>Nombre de place reste</th>
                    <th>Numéro de téléphone</th>
                    <th>Prix</th>
                    <th>Statue</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($commandes) > 0)
                    @foreach($commandes as $commande)
                        <tr>
                            <td>{{ $commande->nom_complete }}</td>
                            <td>{{ $commande->ville_voyage }}</td>
                            <td>{{ $commande->date_debut_voyage }}</td>
                            <td>{{ $commande->date_fin_voyage }}</td>
                            <td>{{ $commande->nombre_personnes }}</td>
                            <td>{{ $commande->nbr_place_reste_voyage }}</td>
                            <td>{{ $commande->num_tel }}</td>
                            <td>{{ $commande->prix }} MAD</td>
                            <td>
                                @if($commande->status == 'acceptée')
                                    <span class="badge bg-success">{{ $commande->status }}</span>
                                @elseif($commande->status == 'refusée')
                                    <span class="badge bg-danger">{{ $commande->status }}</span>
                                @else
                                    <span class="badge bg-primary">{{ $commande->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a data-bs-toggle="modal" data-bs-target="#confirm-accepte-modal-{{ $commande->id }}" style="color:  #00703c;font-family: monospace;font-weight: bold;font-size: large;text-decoration: none"> Accepter</a>
                                <div class="modal fade" style="margin-top:300px" id="confirm-accepte-modal-{{ $commande->id }}" tabindex="-1" aria-labelledby="confirm-accepte-modal-label-{{ $commande->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="confirm-accepte-modal-label-{{ $commande->id }}">Confirmation d'acceptation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir accepter cette commande ? Cette action est irréversible.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('home.voyage.reservation.update') }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="nbr_personnes" value="{{ $commande->nombre_personnes }}">
                                                <input type="hidden" name="nbr_place_reste" value="{{ $commande->nbr_place_reste_voyage }}">
                                                <input type="hidden" name="commande_id" value="{{ $commande->id }}">
                                                <input type="hidden" name="voyage_id" value="{{ $commande->voyage_id }}">
                                                <input type="hidden" name="user_id" value="{{ $commande->user_id }}">
                                                <button type="submit" name="accepter" class="btn btn-primary">Accepter</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a data-bs-toggle="modal" data-bs-target="#confirm-delete-modal-{{ $commande->id }}" style="color: #f90606;font-family: monospace;font-weight: bold;font-size: large;text-decoration: none"> Refuser</a>
                                    <div class="modal fade" style="margin-top:300px" id="confirm-delete-modal-{{ $commande->id }}" tabindex="-1" aria-labelledby="confirm-delete-modal-label-{{ $commande->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="confirm-delete-modal-label-{{ $commande->id }}">Confirmation de refus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            Êtes-vous sûr de vouloir refuser cette commande ? Cette action est irréversible.
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <form  action="{{ route('home.voyage.reservation.update') }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="nbr_personnes" value="{{ $commande->nombre_personnes }}">
                                                <input type="hidden" name="nbr_place_reste" value="{{ $commande->nbr_place_reste_voyage }}">
                                                <input type="hidden" name="commande_id" value="{{ $commande->id }}">
                                                <input type="hidden" name="voyage_id" value="{{ $commande->voyage_id }}">
                                                <input type="hidden" name="user_id" value="{{ $commande->user_id }}">
                                                <button type="submit" name="refuser" class="btn btn-primary">Refuser</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="11">
                        <center><span style="color:red">Il existe aucun commande de voyage</span></center>
                    </td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
