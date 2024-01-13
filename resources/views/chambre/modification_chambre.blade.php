@extends('layouts.app_hotel')

@section('content')
    <div class="container">
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
                            <h1>Modification de chambre</h1>
                        </div>
                        <div class="form-content">
                            <form method="POST" action="{{ route('home.hotel.chambre.update',$chambre->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="type">Type :</label>
                                        <select class="form-select" id="type" name="type">
                                            <option value="">Toutes les types</option>
                                            <option value="Chambre double" @if($chambre->type == 'Chambre double') selected @endif>Chambre double</option>
                                            <option value="Chambre triple" @if($chambre->type == 'Chambre triple') selected @endif>Chambre triple</option>
                                            <option value="Suite" @if($chambre->type == 'Suite') selected @endif>Suite</option>
                                            <option value="Chambre familiale" @if($chambre->type == 'Chambre familiale') selected @endif>Chambre familiale</option>
                                            <option value="Chambre communicante" @if($chambre->type == 'Chambre communicante') selected @endif>Chambre communicante</option>
                                            <option value="Chambre de luxe" @if($chambre->type == 'Chambre de luxe') selected @endif>Chambre de luxe </option>
                                            <option value="Chambre avec vue" @if($chambre->type == 'Chambre avec vue') selected @endif>Chambre avec vue </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" multiple id="image" name="image[]" accept="image/*" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="description">Description</label>
                                        <textarea class="form-control"   name="description" id="" required>{{ $chambre->description }}</textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="occupation_maximale">Occupation maximale</label>
                                        <input type="number" class="form-control" value="{{ $chambre->occupation_maximale }}" id="occupation_maximale" name="occupation_maximale" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="type_lit">Type de lit :</label>
                                        <select class="form-select" id="type_lit" name="type_lit">
                                            <option value="">Tous les type</option>
                                            <option value="Lit simple" @if($chambre->type_lit == 'Lit simple') selected @endif>Lit simple</option>
                                            <option value="Lit double" @if($chambre->type_lit == 'Lit double') selected @endif>Lit double </option>
                                            <option value="Lit king" @if($chambre->type_lit == 'Lit king') selected @endif>Lit king</option>
                                            <option value="Lit queen" @if($chambre->type_lit == 'Lit queen') selected @endif>Lit queen</option>
                                            <option value="Lit superposé" @if($chambre->type_lit == 'Lit superposé') selected @endif>Lit superposé</option>
                                            <option value="Canapé-lit" @if($chambre->type_lit == 'Canapé-lit') selected @endif>Canapé-lit</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="taille">Taille</label>
                                        <input type="number" class="form-control" value="{{ $chambre->taille }}" id="taille" name="taille" required/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="prix_chambre">Prix</label>
                                        <input type="number" class="form-control" value="{{ $chambre->prix_chambre }}" id="prix_chambre" name="prix_chambre" required/>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="status">Statue :</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="">Tous les type</option>
                                            <option value="Disponible" @if($chambre->status == 'Disponible' or $chambre->status == 'disponible') selected @endif>Disponible</option>
                                            <option value="Indisponible" @if($chambre->status == 'Indisponible') selected @endif>Indisponible </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <input type="hidden" name="user_id" value="{{ $chambre->user_id  }}">
                                        <input type="hidden" name="hotel_id" value="{{ $chambre->hotel_id }}">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="col-12 btn btn-primary" style="margin-top: 23px">Modifier</button>
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
