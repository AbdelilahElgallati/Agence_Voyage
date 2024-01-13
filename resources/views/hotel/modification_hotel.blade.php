@extends('layouts.app_hotel')

@section('content')
    <div class="container" >
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

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="form col-md-12" >
                    <div class="form-toggle"></div>
                    <div class="form-panel one">
                        <div class="form-header">
                            <h1>Modification d'hotel</h1>
                        </div>
                        <div class="form-content">
                            <form method="POST" action="{{ route('home.hotel.update',$hotel->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="nom_hotel">Nom d'hotel</label>
                                        <input type="text" value="{{ $hotel->nom_hotel }}" class="form-control" id="nom_hotel" name="nom_hotel" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pays_hotel">Pays d'hotel</label>
                                        <input type="text" value="{{ $hotel->pays_hotel }}" class="form-control" id="pays_hotel" name="pays_hotel" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ville_hotel">Ville d'hotel</label>
                                        <input type="text" value="{{ $hotel->ville_hotel }}" class="form-control" id="ville_hotel" name="ville_hotel" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="adresse_hotel">Adresse d'hotel</label>
                                        <input type="text" value="{{ $hotel->adresse_hotel }}" class="form-control" id="adresse_hotel" name="adresse_hotel" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="type_hotel">Type d'hotel</label>
                                        <select class="form-select" id="type_hotel" name="type_hotel" required>
                                            <option value="">Sélectionnez le type d'hôtel</option>
                                            <option value="Hôtel de luxe" @if($hotel->type_hotel == 'Hôtel de luxe') selected @endif>Hôtel de luxe</option>
                                            <option value="Hôtel de charme" @if($hotel->type_hotel == 'Hôtel de charme') selected @endif>Hôtel de charme</option>
                                            <option value="Hôtel familial" @if($hotel->type_hotel == 'Hôtel familial') selected @endif>Hôtel familial</option>
                                            <option value="Hôtel de plage" @if($hotel->type_hotel == 'Hôtel de plage') selected @endif>Hôtel de plage</option>
                                            <option value="Auberge de jeunesse" @if($hotel->type_hotel == 'Auberge de jeunesse') selected @endif>Auberge de jeunesse</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-md-6" style="flex: 0 0 auto;">
                                        <label for="num_tel_hotel">Numéro de téléphone d'hotel</label>
                                        <input type="tel" value="{{ $hotel->num_tel_hotel }}" class="form-control" id="num_tel_hotel" name="num_tel_hotel" pattern="[0-9]{10}" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="image_hotel">Image</label>
                                        <input type="file" class="form-control" multiple id="image_hotel" name="image_hotel[]" accept="image/*" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email-register">Contrat d'hotel</label>
                                        <input type="file" class="form-control" id="contrat_hotel" name="contrat_hotel" accept=".pdf" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="type_hotel">Nombre d'étoile d'hotel</label>
                                        <select id="nbr_etoil_hotel"  class="form-select" name="nbr_etoil_hotel" required>
                                            <option value="">Sélectionnez le nombre d'étoiles</option>
                                            <option value="1" @if($hotel->nbr_etoil_hotel == '1') selected @endif>1 étoile</option>
                                            <option value="2" @if($hotel->nbr_etoil_hotel == '2') selected @endif>2 étoiles</option>
                                            <option value="3" @if($hotel->nbr_etoil_hotel == '3') selected @endif>3 étoiles</option>
                                            <option value="4" @if($hotel->nbr_etoil_hotel == '4') selected @endif>4 étoiles</option>
                                            <option value="5" @if($hotel->nbr_etoil_hotel == '5') selected @endif>5 étoiles</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="prix_hotel">Prix d'hotel</label>
                                        <input type="number" value="{{ $hotel->prix_hotel }}" class="form-control" id="prix_hotel" name="prix_hotel" style="margin-bottom:19px" required/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="col-3 btn btn-primary">Modifier</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
