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
    <form class="input-barresea" method="POST" action="{{ route('admin.hotel.search') }}" >
        @csrf
        @method('POST')
        <div class="row shadow p-2 mb-4" id="filtrage" style="background-color: #f1eded;border-radius: 10px;">
            <div class="col-md-3 mb-3">
                <label for="filter-name" class="form-label">Nom de l'hôtel</label>
                <input type="text" placeholder="Nom de l'hôtel" class="form-control" id="filter-name" name="nom_hotel">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filter-city" class="form-label">Ville</label>
                <input type="text" placeholder="Ville de l'hôtel" class="form-control" id="filter-city" name="ville_hotel">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filter-country" class="form-label">Pays</label>
                <input type="text" placeholder="Pays de l'hôtel" class="form-control" id="filter-city" name="pays_hotel">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filter-type" class="form-label">Type d'hôtel</label>
                <select class="form-select" id="filter-type" name="type_hotel">
                    <option value="">Tous les types d'hôtels</option>
                    <option value="Hôtel de luxe ">Hôtel de luxe </option>
                    <option value="Hôtel de charme">Hôtel de charme</option>
                    <option value="Hôtel familial">Hôtel familial</option>
                    <option value="Hôtel de plage">Hôtel de plage</option>
                    <option value="Auberge de jeunesse">Auberge de jeunesse</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="filter-price-min" class="form-label">Prix minimal</label>
                <input type="number" placeholder="Prix minimal" class="form-control" id="filter-price-min" name="prix_hotel_min" min="0">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filter-price-max" class="form-label">Prix maximal</label>
                <input type="number" placeholder="Prix maximal" class="form-control" id="filter-price-max" name="prix_hotel_max" min="0">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filter-stars" class="form-label">Nombre d'étoiles</label>
                <select class="form-select" id="filter-stars" name="nbr_etoil_hotel">
                    <option value="">Toutes les étoiles</option>
                    <option value="1">1 étoile</option>
                    <option value="2">2 étoiles</option>
                    <option value="3">3 étoiles</option>
                    <option value="4">4 étoiles</option>
                    <option value="5">5 étoiles</option>
                </select>
            </div>
            <div class="col-md-3 mb-3 align-self-end">
                <button type="submit" class="btn btn-secondary w-100">Filtrer</button>
            </div>
        </div>
    </form>

    <hr>
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les hotels') }}</div>
    <hr>
    @if ($hotels and count($hotels)>0)
        <div class="row">
            @foreach ($hotels as $hotel)
                <div class="col-md-4">
                    <div class="mb-4">
                        <figure class="image-block mb-4 shadow mb-4 bg-white" style="max-width:400px ; height:400px">
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
                                        <button class="btn btn-danger col-12" role="button"  data-bs-toggle="modal" data-bs-target="#confirm-delete-modal-{{ $hotel->id }}">SUPPRIMER</button>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px">
                                        <a class="btn btn-primary col-12" href="{{ route('home.admin.hotel.chambre.gestion', $hotel->id) }}" role="button">Les chambres</a>
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
                                Êtes-vous sûr de vouloir supprimer ce hotel? Cette action est irréversible.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <form style="box-shadow: none" method="POST" action="{{ route('home.hotel.destroy', $hotel->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger col-12">Supprimer</button>
                                </form>
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
@endsection
