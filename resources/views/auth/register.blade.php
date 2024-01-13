@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 7rem!important;">
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success:</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row justify-content-center">
        {{-- <div class="col-md-6">
            <div class="card shadow p-4 mb-4 bg-dark">
                <div class="card-body d-flex align-items-center justify-content-center" style="height: 300px;">
                    <h1 class="text-center" style="color: #fff">Inscription d'utilisateurs</h1>
                </div>
                <div class="card-footer bg-dark">
                    <form action="{{ route('inscription.users') }}" method="get">
                        <button type="submit" class="col-12 btn btn-dark">{{ __('Inscription') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow p-4 mb-4 bg-white">
                <div class="card-body d-flex align-items-center justify-content-center" style="height: 300px;">
                    <h1 class="text-center">Inscription d'hôtel</h1>
                </div>
                <div class="card-footer bg-white">
                    <form action="{{ route('inscription.hotel') }}" method="get">
                        <button type="submit" class="col-12 btn btn-light">{{ __('Inscription') }}</button>
                    </form>
                </div>
            </div>
        </div> --}}

        <div class="btn-group col-12" role="group" aria-label="Basic outlined example">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerUserModal1">Inscription d'utilisateurs</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerHotelModal1">Inscription d'hôtel</button>
        </div>

        <div class="modal fade" id="registerUserModal1" tabindex="-1" aria-labelledby="registerUserModal1Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="margin-top: 250px;">
                    <div class="modal-header form-header">
                        <h1 class="modal-title" id="reservationModalLabel">Formulaire d'inscription d'utilisateur</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nom_complete">Nom complet</label>
                                    <input class="form-control" type="text" id="nom_complete" name="nom_complete" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="adresse">Adresse</label>
                                    <input class="form-control" type="text" id="adresse" name="adresse" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="num_tel">Numéro de téléphone</label>
                                    <input class="form-control" type="tel" id="num_tel" name="num_tel" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email-register">Email</label>
                                    <input class="form-control" type="email" id="email-register" name="email" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password">Mot de passe</label>
                                    <input class="form-control" type="password" id="password" name="password" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Mot de passe confirmé</label>
                                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" style="margin-bottom: 19px;" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit">Inscription</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="registerHotelModal1" tabindex="-1" aria-labelledby="registerHotelModal1Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="margin-top: 50px;">
                    <div class="modal-header form-header">
                            <h1 class="modal-title">Formulaire d'inscription d'hôtel</h1>
                        {{-- <h5 class="modal-title" id="reservationModalLabel">Formulaire d'inscription d'hôtel</h5> --}}
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('home.demande-hotel.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nom_complete">Nom complet</label>
                                    <input type="text" class="form-control" id="nom_complete" name="nom_complete" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" class="form-control" id="adresse" name="adresse" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="num_tel">Numéro de téléphone</label>
                                    <input type="tel" class="form-control" id="num_tel" name="num_tel" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email-register">Email</label>
                                    <input class="form-control" type="email" id="email-register" name="email" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password">Mot de passe</label>
                                    <input class="form-control" type="password" id="password" name="password" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Mot de passe confirmé</label>
                                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nom_hotel">Nom d'hotel</label>
                                    <input class="form-control" type="text" id="nom_hotel" name="nom_hotel" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pays_hotel">Pays d'hotel</label>
                                    <input class="form-control" type="text" id="pays_hotel" name="pays_hotel" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ville_hotel">Ville d'hotel</label>
                                    <input class="form-control" type="text" id="ville_hotel" name="ville_hotel" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="adresse_hotel">Adresse d'hotel</label>
                                    <input class="form-control" type="text" id="adresse_hotel" name="adresse_hotel" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="type_hotel">Type d'hotel</label>
                                    <select id="type_hotel" class="form-select" name="type_hotel" required>
                                        <option value="">Sélectionnez le type d'hotel</option>
                                        <option value="Hôtel de luxe ">Hôtel de luxe </option>
                                        <option value="Hôtel de charme">Hôtel de charme</option>
                                        <option value="Hôtel familial">Hôtel familial</option>
                                        <option value="Hôtel de plage">Hôtel de plage</option>
                                        <option value="Auberge de jeunesse">Auberge de jeunesse</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="num_tel_hotel">Numéro de téléphone d'hotel</label>
                                    <input class="form-control" type="tel" id="num_tel_hotel" name="num_tel_hotel" pattern="[0-9]{10}" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image_hotel">Image</label>
                                    <input class="form-control" type="file" multiple id="image_hotel" name="image_hotel[]" accept="image/*" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email-register">Contrat d'hotel</label>
                                    <input class="form-control" type="file" id="contrat_hotel" name="contrat_hotel" accept=".pdf" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="type_hotel">Nombre d'étoile d'hotel</label>
                                    <select id="nombre-etoiles-hotel" class="form-select" name="nbr_etoil_hotel" required>
                                        <option value="">Sélectionnez le nombre d'étoiles</option>
                                        <option value="1">1 étoile</option>
                                        <option value="2">2 étoiles</option>
                                        <option value="3">3 étoiles</option>
                                        <option value="4">4 étoiles</option>
                                        <option value="5">5 étoiles</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="prix_hotel">Prix d'hotel</label>
                                    <input class="form-control" type="number" id="prix_hotel" name="prix_hotel" style="margin-bottom:19px" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit">Inscription</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
