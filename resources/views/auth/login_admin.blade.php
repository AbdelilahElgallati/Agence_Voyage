@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 10rem!important;">
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
    <div class="form col-md-12" >
        <div class="form-toggle"></div>
        <div class="form-panel one">
            <div class="form-header">
                <h1>Connexion d'administration</h1>
            </div>
            <div class="form-content">
                <form method="POST" action="{{ route('login.administrations') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="email-login">Email</label>
                        <input type="text" class="form-control" id="email-login" name="email" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="password-login">Mot de passe</label>
                        <input type="password" class="form-control" id="password-login" name="password" required="required"/>
                    </div>
                    <div class="form-group">
                        <label class="form-remember">
                        <input type="checkbox"/>Remember Me
                        </label><a class="form-recovery" href="#">Mot de passe oublié ?</a>
                    </div>
                    <div class="form-group">
                        <button type="submit">Connexion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
