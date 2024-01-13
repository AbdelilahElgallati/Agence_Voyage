@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 60px">
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
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <h4 class="mb-0">{{ __('Informations de compte') }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="nom_complete" class="form-label">Nom complet :</label>
                        <p class="mb-0">{{ $user->nom_complete }}</p>
                    </div>
                    <div class="col-sm-6">
                        <label for="adresse" class="form-label">Adresse :</label>
                        <p class="mb-0">{{ $user->adresse }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="email" class="form-label">Email :</label>
                        <p class="mb-0">{{ $user->email }}</p>
                    </div>
                    <div class="col-sm-6">
                        <label for="num_tel" class="form-label">Numéro de téléphone :</label>
                        <p class="mb-0">{{ $user->num_tel }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" style="margin-top: 40px">
        <hr>
            <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les hotels personnel') }}</div>
        <hr>
        <div class="card-body">
                @if ($hotels and count($hotels)>0)
                    <div class="row">
                        @foreach ($hotels as $hotel)
                            <div class="col-md-6">
                                <div class="card mb-4 " id="card-recommandation" style="max-width:620px">
                                    <img style="width: 100.1%;height:250px" src="{{ asset('image/' . $hotel->image_hotel) }}" class="card-img-top" alt="">
                                    <div class="card-body">
                                        <h3 class="card-title col-sm-12 text-center" id="nom-hotel" name="nom_hotel">{{ $hotel->nom_hotel }}</h3>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="card-text" id="ville-hotel" name="ville_hotel"><i class="fas fa-map-marker-alt"></i> {{ $hotel->ville_hotel }} - {{ $hotel->pays_hotel }}</p>
                                            </div>
                                            <div class="col-sm-6 text-end">
                                                <p class="card-text"><i class="fas fa-star"></i> {{ $hotel->nbr_etoil_hotel }} étoiles</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row" style="align-items: center;">
                                            <div class="col-sm-6">
                                                <p class="card-text"><strong>Type d'hotel : </strong>{{ $hotel->type_hotel }}</p>
                                            </div>
                                            <div class="col-sm-6 text-end">
                                                <p class="card-text">À partir de <span class="fw-bold">{{ $hotel->prix_hotel }} MAD</span></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p class="card-text"><i class="fas fa-map-marker-alt"></i> {{ $hotel->adresse_hotel }}</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <p class="card-text"><i class="fas fa-phone"></i> {{ $hotel->num_tel_hotel }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <a class="btn btn-primary" href="{{ route('admin.hotel.chambre.detail', $hotel->id) }}">Les chambres</a>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <form style="box-shadow: none" method="POST" action="{{ route('home.hotel.destroy', $hotel->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h1>Aucun hotel trouvé</h1>
                @endif
        </div>

        <hr>
            <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les commandes de chambres') }}</div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Nom hotel</th>
                        <th>Type de chambre</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Nombre de personne</th>
                        <th>Numéro de téléphone</th>
                        <th>Prix</th>
                        <th>Statue</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($commandes) > 0)
                        @foreach($commandes as $commande)
                            @if($commande->nombre_personnes <= $commande->nbr_place_reste_voyage)
                                <tr>
                                    <td>{{ $commande->nom_complete }}</td>
                                    <td>{{ $commande->ville_hotel }}</td>
                                    <td>{{ $commande->nom_hotel }}</td>
                                    <td>{{ $commande->type }}</td>
                                    <td>{{ $commande->date_debut }}</td>
                                    <td>{{ $commande->date_fin }}</td>
                                    <td>{{ $commande->nombre_personnes }}</td>
                                    <td>{{ $commande->telephone }}</td>
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
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr><td colspan="12">
                            <center><span style="color:red">Il existe aucun commande de chambre</span></center>
                        </td></tr>
                    @endif

                </tbody>
            </table>
        </div>
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
                                <td>{{ $reservation->nombre_personnes }}</td>
                                <td>{{ $reservation->telephone }}</td>
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
        <hr>
            <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les reservation de voyages') }}</div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Ville</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Nombre de personne</th>
                        <th>Numéro de téléphone</th>
                        <th>Prix</th>
                        <th>Statues</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($reservations_voyage) > 0)
                        @foreach($reservations_voyage as $reservation)
                            <tr>
                                <td>{{ $reservation->nom_complete }}</td>
                                <td>{{ $reservation->email }}</td>
                                <td>{{ $reservation->ville }}</td>
                                <td>{{ $reservation->date_debut }}</td>
                                <td>{{ $reservation->date_fin }}</td>
                                <td>{{ $reservation->nombre_personnes }}</td>
                                <td>{{ $reservation->telephone }}</td>
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
</div>
@endsection
