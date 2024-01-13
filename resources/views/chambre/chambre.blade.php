@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 50px;">
    <form class="input-barresea" method="POST" action="{{ route('home.hotel.chambre.search',$hotel->id) }}" >
        @csrf
        @method('POST')
        <div class="row shadow p-2 mb-4" id="filtrage" style="background-color: #f1eded;border-radius: 10px;">
            <div class="col-md-4 mb-3">
                <label for="type" class="form-label">Type de chambre</label>
                <select class="form-select" id="type" name="type">
                    <option value="">Toutes les types</option>
                    <option value="Chambre double">Chambre double</option>
                    <option value="Chambre triple">Chambre triple</option>
                    <option value="Suite">Suite</option>
                    <option value="Chambre familiale">Chambre familiale</option>
                    <option value="Chambre communicante">Chambre communicante</option>
                    <option value="Chambre de luxe ">Chambre de luxe </option>
                    <option value="Chambre avec vue ">Chambre avec vue </option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="occupation_maximale" class="form-label">Occupation maximale</label>
                <input type="number" placeholder="Occupation maximale" class="form-control" id="occupation_maximale" name="occupation_maximale">
            </div>
            <div class="col-md-4 mb-3">
                <label for="type_lit" class="form-label">Type de lit</label>
                <select class="form-select" id="type_lit" name="type_lit">
                    <option value="">Tous les type</option>
                    <option value="Lit simple">Lit simple</option>
                    <option value="Lit double ">Lit double </option>
                    <option value="Lit king">Lit king</option>
                    <option value="Lit queen">Lit queen</option>
                    <option value="Lit superposé">Lit superposé</option>
                    <option value="Canapé-lit">Canapé-lit</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="taille" class="form-label">Taille</label>
                <input type="number" placeholder="taille de chambre" class="form-control" id="taille" name="taille">
            </div>
            <div class="col-md-4 mb-3">
                <label for="filter-price" class="form-label">Prix de chambre</label>
                <input type="number" placeholder="Prix de chambre" class="form-control" id="filter-price" name="prix_chambre" min="0">
            </div>
            <div class="col-md-4 mb-3 align-self-end">
                <button type="submit" class="btn btn-secondary w-100">Filtrer</button>
            </div>
        </div>
    </form>


    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: absolute; margin-top: -4rem; margin-left: 12%; width: 65%;">
            <strong>Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute; margin-top: -4rem; margin-left: 12%; width: 65%;">
            <strong>Success:</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="col-md-12">
        <div class="card shadow mb-4 bg-white" id="card-recommandation">
            <div class="row">
                <div class="col-sm-6">
                    <img style="height: -webkit-fill-available; max-height: 300px;" src="{{ asset('image/' . $hotel->image_hotel) }}" class="card-img-top" alt="">
                </div>
                <div class="col-sm-6">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les chambres') }}</div>
    <hr>
    @if ($chambres and count($chambres)>0)
        <div class="row row-cols-1" style="width: 100%; justify-content: space-between; --bs-gutter-x: 0rem;">
            @foreach ($chambres as $chambre)
                <div class="card mb-4 shadow mb-4 bg-white" style="max-width: 620px;">
                    <div class="col-md-6" style="width:100%">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach(explode('|', $chambre->image) as $key => $image)
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner">
                                @foreach(explode('|', $chambre->image) as $key => $image)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ asset('image/' . $image) }}" class="d-block w-100" alt="image {{ $key + 1 }}" style="height: 250px">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $chambre->type }}</h5>
                        <p class="card-text" style="height: 173px;overflow-x: auto;">{{ $chambre->description }}</p>
                        <hr>
                        <ul class="list-group mb-3">
                            <li class="list-group-item">Occupation maximale: {{ $chambre->occupation_maximale }}</li>
                            <li class="list-group-item">Lits: {{ $chambre->type_lit }}</li>
                            <li class="list-group-item">Surface de la chambre: {{ $chambre->taille }} m²</li>
                        </ul>
                        <div class="row">
                            <div class="col-sm-6">
                            <p class="card-text"><span class="fw-bold">Prix:</span> à partir de {{ $chambre->prix_chambre }}MAD / nuit</p>
                            </div>
                            <div class="col-sm-6 text-end">
                                @if ($chambre->status == 'disponible' or $chambre->status == 'Disponible' )
                                    <button type="button" class="btn btn-primary" id="btn" data-bs-toggle="modal" data-bs-target="#reservationModal{{ $chambre->id }}">
                                        Réserver
                                    </button>
                                @else
                                    <H3 style="color: red">Indisponible</H3>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="reservationModal{{ $chambre->id }}" tabindex="-1" aria-labelledby="reservationModal{{ $chambre->id }}Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="margin-top: 70px;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reservationModalLabel">Formulaire de réservation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('home.hotel.chambre.reservation.save') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" value="{{ $hotel->user_id }}" name="posteur_id" id="posteur_id">
                                    <input type="hidden" value="{{ $chambre->id }}" name="chambre_id" id="chambre_id">
                                    <input type="hidden" value="{{ Auth()->user()->id }}" name="user_id" id="user_id">
                                    <input type="hidden" value="{{ $chambre->prix_chambre }}" name="prix" id="prix">
                                    <div class="form-group">
                                        <label for="nom_complete"><span class="fw-bold">Nom complet:</span></label>
                                        <p class="card-text" style="margin-left:10px">{{ Auth()->user()->nom_complete }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><span class="fw-bold">Adresse email:</span></label>
                                        <p class="card-text" style="margin-left:10px">{{ Auth()->user()->email }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone"><span class="fw-bold">Numéro de téléphone:</span></label>
                                        <p class="card-text" style="margin-left:10px">{{ Auth()->user()->num_tel }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="prix"><span class="fw-bold">Prix:</span></label>
                                        <p class="card-text" style="margin-left:10px">à partir de {{ $chambre->prix_chambre }}MAD / nuit</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_debut"><span class="fw-bold">Date de début:</span></label>
                                        <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_fin"><span class="fw-bold">Date de fin:</span></label>
                                        <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre_personnes"><span class="fw-bold">Nombre de personnes:</span></label>
                                        <input type="number" name="nombre_personnes" class="form-control" min="1" max="{{ $chambre->occupation_maximale }}" required>
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
            @endforeach

            <script>
                $(document).ready(function() {
                    $(".btn-reservation").click(function() {
                        var chambre_id = $(this).data('chambre-id');
                        $("#chambre_id").val(chambre_id);
                        $('#reservationModal').modal('show');
                    });
                });
            </script>

        </div>
    @else
        <h1>Aucun chambre touvé</h1>
    @endif
</div>
@endsection
