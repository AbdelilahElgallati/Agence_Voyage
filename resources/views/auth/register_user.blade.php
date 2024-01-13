@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 140px">
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
                <h1>Inscription d'utilisateur</h1>
            </div>
            <div class="form-content">
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
@endsection
