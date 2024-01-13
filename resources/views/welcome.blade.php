@extends('layouts.app')

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
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Destinations qui pourraient vous intéresser') }}</div>
        <hr>
        <div class="container-fluid">
            <div class="row flex-nowrap overflow-auto position-relative">
                @if(isset($hotelCounts) && count($hotelCounts) > 0)
                    @foreach($hotelCounts as $hotelCount)
                        <div class="col-md-3 col-lg-3 col-xxl-2 mb-4" style="min-width:20rem;">
                            <div class="card">
                                @if ($hotelCount->ville_hotel == 'Essaouira')
                                    <img src="image/image-ville/essaouira.jpeg" class="card-img-top" style="height:200px" alt="Essaouira">
                                @elseif ($hotelCount->ville_hotel == 'Marrakech')
                                    <img src="image/image-ville/marrakech.jpeg" class="card-img-top" style="height:200px" alt="Marrakech">
                                @elseif ($hotelCount->ville_hotel == 'Casablanca')
                                    <img src="image/image-ville/casablanca.jpeg" class="card-img-top" style="height:200px" alt="casablanca">
                                @elseif ($hotelCount->ville_hotel == 'Chefchaouen')
                                    <img src="image/image-ville/chefchaouen.jpeg" class="card-img-top" style="height:200px" alt="Chefchaouen">
                                @elseif ($hotelCount->ville_hotel == 'Dubai')
                                    <img src="image/image-ville/dubai.jpg" class="card-img-top" style="height:200px" alt="Dubai">
                                @elseif ($hotelCount->ville_hotel == 'Los angeles')
                                    <img src="image/image-ville/los_angeles.jpeg" class="card-img-top" style="height:200px" alt="Los angeles">
                                @elseif ($hotelCount->ville_hotel == 'Marseille')
                                    <img src="image/image-ville/marseille.jpg" class="card-img-top" style="height:200px" alt="Marseille">
                                @elseif ($hotelCount->ville_hotel == 'Paris')
                                    <img src="image/image-ville/paris.jpeg" class="card-img-top" style="height:200px" alt="Paris">
                                @else
                                    <img src="image/image_site/voyage.jpg" class="card-img-top" style="height:200px" alt="Aléatoire">
                                @endif
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">{{ $hotelCount->ville_hotel }}</h5>
                                        <p class="card-text mb-2"><small class="text-muted">Hôtel disponible: {{ $hotelCount->total }}</small></p>
                                    </div>
                                        @if (Auth::user())
                                            <form class="input-barresea" method="POST" action="{{ route('home.hotel.search') }}" >
                                                @csrf
                                                @method('POST')
                                                <div class="col-md-12 text-center mb-3">
                                                    <input type="hidden" name="ville_hotel" value="{{ $hotelCount->ville_hotel }}">
                                                    <button type="submit" class="col-12 btn btn-primary">Détails</button>
                                                </div>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" id="btn" class="col-12 btn btn-primary">Détails</a>
                                        @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <hr>
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les hôtels au maroc') }}</div>
        <hr>
        <div class="recomondation-site">
            @if(isset($hotel_maroc) && count($hotel_maroc) > 0)
                <div class="row row-cols-1" style="width: 100%; justify-content: space-between; --bs-gutter-x: -2rem;">
                    @foreach ($hotel_maroc as $hotel)
                        <div class="col-md-4">
                            <div class="mb-4">
                                <figure class="image-block mb-4 shadow mb-4 bg-white" style="max-width:400px ;height:400px">
                                    <h1>{{ $hotel->nom_hotel }}</h1>
                                    <img src="{{ asset('image/' . $hotel->image_hotel) }}" alt="" />
                                    <figcaption>
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
                                        <div class="col-md-12 text-center">
                                            @if (Auth::user())
                                                <a class="btn btn-primary col-12" id="btn" href="{{ route('home.hotel.chambre', $hotel->id) }}">Réserver</a>
                                            @else
                                                <a href="{{ route('login') }}" id="btn" class="btn btn-primary col-12">Réserver</a>
                                            @endif
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12 text-center">
                    <form class="input-barresea" method="POST" action="{{ route('home.hotel.search') }}" >
                        @csrf
                        @method('POST')
                        <div class="col-md-12 text-center mb-3">
                            @if (Auth::user())
                                <input type="hidden" name="pays_hotel" value="{{ $hotel->pays_hotel }}">
                                <button type="submit" class="btn btn-primary">Voir plus</button>
                            @else
                                <a href="{{ route('login') }}" id="btn" class="btn btn-primary">Voir plus</a>
                            @endif
                        </div>
                    </form>
                </div>
            @else
                <h2>Aucun hotel trouvé</h2>
            @endif
        </div>
        <hr>
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les hôtels au monde') }}</div>
        <hr>
        <div class="recomondation-site">
            @if(isset($hotel_monde) && count($hotel_monde) > 0)
                <div class="row row-cols-1" style="width: 100%; justify-content: space-between; --bs-gutter-x: -2rem;">
                    @foreach ($hotel_monde as $hotel)
                    <div class="col-md-4">
                        <div class="mb-4">
                            <figure class="image-block mb-4 shadow mb-4 bg-white" style="max-width:400px;  height:400px">
                                <h1>{{ $hotel->nom_hotel }}</h1>
                                <img src="{{ asset('image/' . $hotel->image_hotel) }}" alt="" />
                                <figcaption>
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
                                    <div class="col-md-12 text-center">
                                        @if (Auth::user())
                                            <a class="btn btn-primary col-12" id="btn" href="{{ route('home.hotel.chambre', $hotel->id) }}">Réserver</a>
                                        @else
                                            <a href="{{ route('login') }}" id="btn" class="btn btn-primary col-12">Réserver</a>
                                        @endif
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-12 text-center">
                    <a class="btn btn-primary" id="btn" href="{{ route('home.hotel') }}" role="button">Voir plus</a>
                </div>
            @else
                <h2>Aucun hotel trouvé</h2>
            @endif
        </div>
        <hr>
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Voyages organisés') }}</div>
        <hr>
        <div class="recomondation-site">
            @if(isset($voyages) && count($voyages) > 0)
                <div class="row row-cols-1" style="width: 100%; justify-content: space-between; --bs-gutter-x: -2rem;">
                    @foreach ($voyages as $voyage)
                        <div class="col-md-4">
                            <div class="mb-4">
                                <figure class="image-block " style="max-width:400px;  height:400px">
                                    <h1>{{ $voyage->ville_voyage }}</h1>
                                    <img src="{{ asset('image/' . $voyage->image_voyage) }}" alt="" />
                                    <figcaption class="figcaption-voyage">
                                        <h3>
                                            Plus d'informations
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    Pays voyage: {{ $voyage->pays_voyage }}<br>
                                                    Ville Hôtel: {{ $voyage->ville_voyage }}<br>
                                                    Date début: {{ $voyage->date_debut_voyage }}<br>
                                                    Date fin: {{ $voyage->date_fin_voyage }}<br>
                                                    Type d'hébergement: {{ $voyage->type_hibergement }}<br>
                                                    Numéro de téléphone: <i class="fas fa-phone"></i> {{ $voyage->numero_tel_voyage }}<br>
                                                    Nombre de personnes: {{ $voyage->nbr_personne_voyage }} ({{ $voyage->nbr_place_reste_voyage }} place(s) restante(s))<br>
                                                    Prix: {{ $voyage->prix_voyage }} MAD
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                @if (Auth::user())
                                                    @if ($voyage->nbr_place_reste_voyage = 0)
                                                        <h2 style="color: red">Indisponible</h2>
                                                    @else
                                                        <div class="col-md-12 text-center">
                                                            <button type="button" id="btn" class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#reservationModal{{ $voyage->id }}">
                                                                Réserver
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}"  id="btn" class="btn btn-primary col-12">Réserver</a>
                                                @endif
                                            </div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>

                        </div>
                        @if (Auth::user())
                            <div class="modal fade" id="reservationModal{{ $voyage->id }}" tabindex="-1" aria-labelledby="reservationModal{{ $voyage->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="margin-top: 70px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="reservationModalLabel">Formulaire de réservation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('home.voyage.reservation.save') }}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{ $voyage->id }}" name="voyage_id" id="voyage_id">
                                                <input type="hidden" value="{{ Auth()->user()->id }}" name="user_id" id="user_id">
                                                <input type="hidden" value="{{ $voyage->prix_voyage }}" name="prix" id="prix">
                                                <div class="form-group">
                                                    <label for="nom_complete"><span class="fw-bold">Nom complet :</span></label>
                                                    <p class="card-text" style="margin-left:10px">{{ Auth()->user()->nom_complete }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nom_complete"><span class="fw-bold">Ville :</span></label>
                                                    <p class="card-text" style="margin-left:10px">{{ $voyage->ville_voyage }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email"><span class="fw-bold">Adresse email :</span></label>
                                                    <p class="card-text" style="margin-left:10px">{{ Auth()->user()->email }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="telephone"><span class="fw-bold">Numéro de téléphone :</span></label>
                                                    <p class="card-text" style="margin-left:10px">{{ Auth()->user()->num_tel }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="prix"><span class="fw-bold">Prix :</span></label>
                                                    <p class="card-text" style="margin-left:10px">à partir de {{ $voyage->prix_voyage }}MAD / personne</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="date_debut"><span class="fw-bold">Date d'arrivée :</span></label>
                                                    <p class="card-text" style="margin-left:10px">{{ $voyage->date_debut_voyage }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="date_fin"><span class="fw-bold">Date de départ :</span></label>
                                                    <p class="card-text" style="margin-left:10px">{{ $voyage->date_fin_voyage }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nombre_personnes"><span class="fw-bold">Nombre de personnes :</span></label>
                                                    <input type="number" name="nombre_personnes" class="form-control" min="1" max="{{ $voyage->nbr_personne_voyage }}" required>
                                                </div>
                                                <div class="modal-footer" style="justify-content: space-between">
                                                    <button type="button" class="col-5 btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="col-5 btn btn-primary">Réserver</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-12 text-center">
                    <a class="btn btn-primary" id="btn" href="{{ route('home.voyage') }}" role="button">Voir plus</a>
                </div>
            @else
                <h2>Aucun voyage trouvé</h2>
            @endif
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".btn-reservation").click(function() {
                    var voyage_id = $(this).data('voyage-id');
                    $("#voyage_id").val(voyage_id);
                    $('#reservationModal').modal('show');
                });
            });
        </script>
    </div>
@endsection
