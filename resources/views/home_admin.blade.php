@extends('layouts.app_admin')

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
                                    <form class="input-barresea" method="POST" action="{{ route('admin.hotel.search') }}" >
                                        @csrf
                                        @method('POST')
                                        <div class="col-md-12 text-center mb-3">
                                            <input type="hidden" name="ville_hotel" value="{{ $hotelCount->ville_hotel }}">
                                            <button type="submit" class="col-12 btn btn-primary">Détails</button>
                                        </div>
                                    </form>
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
                                <figure class="image-block mb-4 shadow mb-4 bg-white" style="max-width:400px; height:400px">
                                    <h1>{{ $hotel->nom_hotel }}</h1>
                                    <img src="{{ asset('image/' . $hotel->image_hotel) }}" alt="" />
                                    <figcaption class="figcaption-hotel-admin">
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
                                            <div class="col-md-12">
                                                <form style="box-shadow: none" method="POST" action="{{ route('home.hotel.destroy', $hotel->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger col-12">Supprimer</button>
                                                </form>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 10px">
                                                <a class="btn btn-primary col-12" href="{{ route('home.admin.hotel.chambre.gestion', $hotel->id) }}" role="button">Les chambres</a>
                                            </div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12 text-center">
                    <form class="input-barresea" method="POST" action="{{ route('admin.hotel.search') }}" >
                        @csrf
                        @method('POST')
                        <div class="col-md-12 text-center mb-3">
                            <input type="hidden" name="pays_hotel" value="{{ $hotel->pays_hotel }}">
                            <button type="submit" class="btn btn-primary">Voir plus</button>
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
                            <figure class="image-block mb-4 shadow mb-4 bg-white" style="max-width:400px; height:400px">
                                <h1>{{ $hotel->nom_hotel }}</h1>
                                <img src="{{ asset('image/' . $hotel->image_hotel) }}" alt="" />
                                <figcaption class="figcaption-hotel-admin">
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
                                        <div class="col-md-12">
                                            <form style="box-shadow: none" method="POST" action="{{ route('home.hotel.destroy', $hotel->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger col-12">Supprimer</button>
                                            </form>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px">
                                            <a class="btn btn-primary col-12" href="{{ route('home.admin.hotel.chambre.gestion', $hotel->id) }}" role="button">Les chambres</a>
                                        </div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-12 text-center">
                    <a class="btn btn-primary" href="{{ route('home.admin.hotel') }}" role="button">Voir plus</a>
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
                                <figure class="image-block mb-4 shadow mb-4 bg-white" style="max-width:400px; height:400px">
                                    <h1>{{ $voyage->ville_voyage }}</h1>
                                    <img src="{{ asset('image/' . $voyage->image_voyage) }}" alt="" />
                                    <figcaption class="figcaption-voyage-admin">
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
                                            <div class="col-md-12">
                                                <a class="btn btn-secondary col-12" href="{{ route('home.voyage.edit',$voyage->id) }}" role="button">Modifier</a>
                                            </div>
                                            <div class="col-md-12" style="margin-top: 10px">
                                                <form style="box-shadow: none" method="POST" action="{{ route('home.voyage.destroy', $voyage->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger col-12">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12 text-center">
                    <a class="btn btn-primary" href="{{ route('home.admin.voyage') }}" role="button">Voir plus</a>
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
