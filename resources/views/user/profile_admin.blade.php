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
        <hr>
            <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Profile') }}</div>
        <hr>
        <div class="col-md-12">
            <div class="card shadow p-4 bg-white">
                <div class="card-header text-center" style="font-size: x-large; background:none">{{ __('Informations de compte') }}</div>
                <div class="card-body">
                    <form action="{{ route('home.user.compte.update') }} " method="post" class="orm-demande">
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="nom_complete" class="form-label">Nom complet :</label>
                                <input type="text" value="{{ $user->nom_complete }}" class="form-control" id="nom_complete" name="nom_complete" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="adresse" class="form-label">Adresse :</label>
                                <input type="text" value="{{ $user->adresse }}" class="form-control" id="adresse" name="adresse" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="email" class="form-label">Email :</label>
                                <input type="text" value="{{ $user->email }}" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="num_tel" class="form-label">Numéro de téléphone :</label>
                                <input type="text" value="{{ $user->num_tel }}" class="form-control" id="num_tel" name="num_tel" required>
                            </div>
                        </div>
                        <div class="row mb-3" >
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="col-sm-12 text-center" style="margin-bottom: -25px">
                                <button type="submit" class="col-4 btn btn-primary">Modifier</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card shadow mt-4 p-4 bg-white">
                <div class="card-header text-center" style="font-size: x-large; background:none">{{ __('Modification de mot de passe') }}</div>
                <div class="card-body">
                    <form action="{{ route('home.user.password.update') }} " method="post" class="orm-demande " enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="password_actuelle" class="form-label">Mot de passe actuelle :</label>
                                <input type="password"  class="form-control" id="password_actuelle" name="password_actuelle" required>
                            </div>
                            <div class="col-sm-12">
                                <label for="password" class="form-label">Nouveau mot de passe :</label>
                                <input type="password"  class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="password_confirme" class="form-label">Confirmation de nouveau mot de passe :</label>
                                <input type="password"  class="form-control" id="password_confirme" name="password_confirme" required>
                            </div>
                        </div>
                        <div class="row mb-3" >
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="col-sm-12 text-center" style="margin-bottom: -25px">
                                <button type="submit" class="col-4 btn btn-primary">Modifier</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


