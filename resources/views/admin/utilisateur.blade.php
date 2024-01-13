@extends('layouts.app_admin')

@section('content')
<div class="container" style="margin-top: 60px">
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
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les utilisateurs') }}</div>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>Numéro de téléphone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->nom_complete }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->adresse }}</td>
                        <td>{{ $user->num_tel }}</td>
                        <td>
                            <button  data-bs-toggle="modal" data-bs-target="#confirm-delete-modal-{{ $user->id }}" style="color: #f90606;font-family: monospace;font-weight: bold;font-size: large;text-decoration: none; border: none;background-color: transparent;">Supprimer</button>
                            {{-- <a href="{{ route('home.user.destroy', $user->id) }}" style="color: #f90606;font-family: monospace;font-weight: bold;font-size: large;text-decoration: none">Supprimer</a> --}}
                        </td>
                    </tr>

                    <div class="modal fade" style="margin-top:300px" id="confirm-delete-modal-{{ $user->id }}" tabindex="-1" aria-labelledby="confirm-delete-modal-label-{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirm-delete-modal-label-{{ $user->id }}">Confirmation de suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer ce utilisateur ? Cette action est irréversible.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <form style="box-shadow: none" method="POST" action="{{ route('home.user.destroy', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
