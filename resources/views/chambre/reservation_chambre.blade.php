@extends('layouts.app')

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
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les reservations de chambres') }}</div>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ville</th>
                    <th>Nom hotel</th>
                    <th>Type de chambre</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Nombre de personne</th>
                    <th>Numéro de téléphone</th>
                    <th>Prix</th>
                    <th>Statue</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($reservations) > 0)
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->ville_hotel }}</td>
                            <td>{{ $reservation->nom_hotel }}</td>
                            <td>{{ $reservation->type }}</td>
                            <td>{{ $reservation->date_debut }}</td>
                            <td>{{ $reservation->date_fin }}</td>
                            <td>{{ $reservation->nbr_personne }}</td>
                            <td>{{ $reservation->num_tel }}</td>
                            <td>{{ $reservation->prix }} MAD</td>
                            <td>
                                @if($reservation->status == 'acceptée')
                                    <span class="badge bg-success">{{ $reservation->status }}</span>
                                @elseif($reservation->status == 'refusée')
                                    <span class="badge bg-danger">{{ $reservation->status }}</span>
                                @else
                                    <span class="badge bg-primary">{{ $reservation->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a data-bs-toggle="modal" data-bs-target="#confirm-delete-modal-{{ $reservation->id }}" style="color: #f90606;font-family: monospace;font-weight: bold;font-size: large;text-decoration: none">Annuler</a>
                                <div class="modal fade" style="margin-top:300px" id="confirm-delete-modal-{{ $reservation->id }}" tabindex="-1" aria-labelledby="confirm-delete-modal-label-{{ $reservation->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirm-delete-modal-label-{{ $reservation->id }}">Confirmation d'annulation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir annuler cette reservation ? Cette action est irréversible.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form style="box-shadow: none" method="POST" action="{{ route('home.hotel.chambre.reservation.destroy',$reservation->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($reservation->status == 'acceptée')
                                    <form action="{{ route('imprimer.reservation.chambre') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                        <button type="submit" style="color: #3344c7;font-family: monospace;font-weight: bold;font-size: large;text-decoration: none; border: none;background-color: transparent;">Imprimer</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="11">
                        <center><span style="color:red">Il existe aucun reservation de chambre</span></center>
                    </td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
