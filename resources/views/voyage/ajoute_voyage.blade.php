@extends('layouts.app_admin')

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

        <div class="form col-md-12" >
            <div class="form-toggle"></div>
            <div class="form-panel one">
                <div class="form-header">
                    <h1>Ajoute de voyage</h1>
                </div>
                <div class="form-content">
                    <form method="POST" action="{{ route('home.voyage.save') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="pays_voyage">Pays</label>
                                <input class="form-control" type="text" id="pays_voyage" name="pays_voyage" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ville_voyage">Ville</label>
                                <input class="form-control" type="text" id="ville_voyage" name="ville_voyage" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date_debut_voyage">Date de début</label>
                                <input class="form-control" type="date" id="date_debut_voyage" name="date_debut_voyage" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date_fin_voyage">Date de fin</label>
                                <input class="form-control" type="date" id="date_fin_voyage" name="date_fin_voyage" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nbr_personne_voyage">Nombre de personne</label>
                                <input class="form-control" type="number" id="nbr_personne_voyage" name="nbr_personne_voyage" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="numero_tel_voyage">Numéro de téléphone</label>
                                <input class="form-control" type="tel" id="numero_tel_voyage" name="numero_tel_voyage" pattern="[0-9]{10}" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type_hibergement">Type d'hébergement</label>
                                <input class="form-control" type="text" id="type_hibergement" name="type_hibergement" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="prix_voyage">Prix</label>
                                <input class="form-control" type="number" id="prix_voyage" name="prix_voyage" required/>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="image_voyage">Image</label>
                                <input class="form-control" type="file" multiple id="image_voyage" name="image_voyage[]" accept="image/*" style="margin-bottom: 19px;" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
