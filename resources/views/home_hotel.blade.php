@extends('layouts.app_hotel')

@section('content')
    <div class="container" style="margin-top: 30px;">
        <div class="hero parallax-content"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/225363/sterling-davis-4iXagiKXn3Y-unsplash-min.jpg" alt="Photo of city during a sunset by Sterling Davis"/>
            <div class="hero__title">
                <h1>Votre Voyages Notre Passion !</h1>
                <p>Planifiez votre voyage avec le meilleur conseiller touristique</p>
            </div>
        </div>
        <div class="main-content">
            <div class="scroll-icon-container">
                <svg class="icon--down-arrow" viewBox="0 0 24 24">
                    <path d="M11,4H13V16L18.5,10.5L19.92,11.92L12,19.84L4.08,11.92L5.5,10.5L11,16V4Z"></path>
                </svg>
            </div>
        </div>
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
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Mes hôtels') }}</div>
        <hr>
        <div class="recomondation-site">
            @if(isset($hotels) && count($hotels) > 0)
                <div class="row row-cols-1">
                    @foreach ($hotels as $hotel)
                        <div class="col-md-4">
                            <div class="mb-4">
                                <figure class="image-block mb-4 shadow mb-4 bg-white" style="max-width:400px; height:400px">
                                    <h1>{{ $hotel->nom_hotel }}</h1>
                                    <img src="{{ asset('image/' . $hotel->image_hotel) }}" alt="" />
                                    <figcaption class="figcaption-home-hotel">
                                        <h3>
                                            Plus d'informations
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    Pays Hôtel: {{ $hotel->pays_hotel }}<br>
                                                    Ville Hôtel: {{ $hotel->ville_hotel }}<br>
                                                    Adresse Hôtel: {{ $hotel->adresse_hotel }}<br>
                                                    Numéro de téléphone: {{ $hotel->num_tel_hotel }}<br>
                                                    Type d'hôtel: {{ $hotel->type_hotel }}<br>
                                                    Nombre d'étoiles: {{ $hotel->nbr_etoil_hotel }} <i class="fas fa-star"></i><br>
                                                    Prix: {{ $hotel->prix_hotel }} MAD
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <a class="btn btn-secondary col-12" href="{{ route('home.hotel.edit',$hotel->id) }}" role="button">MODIFIER</a>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 5px">
                                                <button class="btn btn-danger col-12" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal-{{ $hotel->id }}">SUPPRIMER</button>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 5px">
                                                <a class="btn btn-primary col-12" href="{{ route('home.hotel.chambre.gestion', $hotel->id) }}" role="button">Les chambres</a>
                                            </div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>

                        <div class="modal fade" style="margin-top:300px" id="confirm-delete-modal-{{ $hotel->id }}" tabindex="-1" aria-labelledby="confirm-delete-modal-label-{{ $hotel->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="confirm-delete-modal-label-{{ $hotel->id }}">Confirmation de suppression</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer ce hotel ? Cette action est irréversible.
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <form style="box-shadow: none" method="POST" action="{{ route('home.hotel.destroy', $hotel->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h2>Aucun hotel trouvé</h2>
            @endif
        </div>
    </div>
@endsection
