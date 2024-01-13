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
                            <h1>Ajoute de chambre</h1>
                        </div>
                        <div class="form-content">
                            <form method="POST" action="{{ route('home.hotel.chambre.save') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="type">Type :</label>
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
                                    <div class="form-group col-md-6">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" multiple id="image" name="image[]" accept="image/*" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="description">Description</label>
                                        <textarea class="form-control"  name="description" id="description" required></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="occupation_maximale">Occupation maximale</label>
                                        <input type="number" class="form-control" id="occupation_maximale" name="occupation_maximale" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="type_lit">Type de lit :</label>
                                        <select id="type_lit" name="type_lit" class="form-select" >
                                            <option value="">Tous les type</option>
                                            <option value="Lit simple">Lit simple</option>
                                            <option value="Lit double ">Lit double </option>
                                            <option value="Lit king">Lit king</option>
                                            <option value="Lit queen">Lit queen</option>
                                            <option value="Lit superposé">Lit superposé</option>
                                            <option value="Canapé-lit">Canapé-lit</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="taille">Taille</label>
                                        <input type="number" class="form-control" id="taille" name="taille" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="prix_chambre">Prix</label>
                                        <input type="number" class="form-control" id="prix_chambre" name="prix_chambre" required/>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="hotel_id" value="{{ $hotel_id }}">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="col-12 btn btn-primary" style="margin-top: 23px">Ajouter</button>
                                        </div>
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
