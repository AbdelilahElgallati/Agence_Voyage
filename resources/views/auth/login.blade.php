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
        {{-- <div class="col-md-4">
            <div class="card shadow p-4 mb-4 bg-primary">
                <div class="card-body d-flex align-items-center justify-content-center" style="height: 300px;">
                    <h1 class="text-center text-white">Connexion d'administration</h1>
                </div>
                <div class="card-footer bg-primary">
                    <form action="{{ route('login.administration') }}" method="post">
                        @csrf
                        <button type="submit" class="col-12 btn btn-primary">{{ __('Connexion') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow p-4 mb-4 bg-dark">
                <div class="card-body d-flex align-items-center justify-content-center" style="height: 300px;">
                    <h1 class="text-center text-white">Connexion d'utilisateurs</h1>
                </div>
                <div class="card-footer bg-dark">
                    <form action="{{ route('login.users') }}" method="post">
                        @csrf
                        <button type="submit" class="col-12 btn btn-dark">{{ __('Connexion') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow p-4 mb-4 bg-white">
                <div class="card-body d-flex align-items-center justify-content-center" style="height: 300px;">
                    <h1 class="text-center">Connexion d'hôtel</h1>
                </div>
                <div class="card-footer bg-white">
                    <form action="{{ route('login.hotels') }}" method="get">
                        @csrf
                        <button type="submit" class="col-12 btn btn-light">{{ __('Connexion') }}</button>
                    </form>
                </div>
            </div>
        </div> --}}

        <div class="btn-group col-12" role="group" aria-label="Basic outlined example">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginAdminModal1">Connexion d'administration</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginUserModal1">Connexion d'utilisateurs</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginHotelModal1">Connexion d'hôtel</button>
        </div>

        <div class="modal fade" id="loginAdminModal1" tabindex="-1" aria-labelledby="loginAdminModal1Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="margin-top: 250px;">
                    <div class="modal-header form-header">
                        <h1 class="modal-title" id="reservationModalLabel">Formulaire de connexion d'administration</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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

        <div class="modal fade" id="loginUserModal1" tabindex="-1" aria-labelledby="loginUserModal1Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="margin-top: 250px;">
                    <div class="modal-header form-header">
                        <h1 class="modal-title" id="reservationModalLabel">Formulaire de connexion d'utilisateur</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('login.user') }}">
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

        <div class="modal fade" id="loginHotelModal1" tabindex="-1" aria-labelledby="loginHotelModal1Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="margin-top: 250px;">
                    <div class="modal-header form-header">
                        <h1 class="modal-title" id="reservationModalLabel">Formulaire de connexion d'hôtel</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('login.hotel') }}">
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.1/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                $(".btn-reservation").click(function() {
                    var voyage_id = $(this).data('voyage-id');
                    $("#voyage_id").val(voyage_id);
                    $('#reservationModal').modal('show');
                });
            });
        </script>
</div>
@endsection
