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
    <form class="input-barresea" method="POST" action="{{ route('admin.voyage.search') }}" >
        @csrf
        @method('POST')
        <div class="row shadow p-2 mb-4" id="filtrage" style="background-color: #f1eded;border-radius: 10px;">
            <div class="col-md-3 mb-3">
                <label for="ville" class="form-label">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" placeholder="Entrez une ville">
            </div>
            <div class="col-md-3 mb-3">
                <label for="pays" class="form-label">Pays</label>
                <input type="text" class="form-control" id="pays" name="pays" placeholder="Entrez une ville">
            </div>
            <div class="col-md-3 mb-3">
                <label for="date_debut" class="form-label">Date de début</label>
                <input type="date" class="form-control" id="date_debut" name="date_debut" placeholder="Date de début">
            </div>
            <div class="col-md-3 mb-3">
                <label for="date_fin" class="form-label">Date de fin</label>
                <input type="date" class="form-control" id="date_fin" name="date_fin" placeholder="Date de fin">
            </div>
            <div class="col-md-4 mb-3">
                <label for="prix" class="form-label">Prix minimal</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="prix_min" id="prix" placeholder="Entrez un prix minimal">
                    <span class="input-group-text">MAD</span>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="prix" class="form-label">Prix maximum</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="prix_max" id="prix" placeholder="Entrez un prix maximum">
                    <span class="input-group-text">MAD</span>
                </div>
            </div>
            <div class="col-md-4 mb-3 align-self-end">
                <button type="submit" class="btn btn-secondary w-100">Filtrer</button>
            </div>
        </div>
    </form>


    <hr>
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les voyages') }}</div>
    <hr>
    @if ($voyages and count($voyages)>0)
        <div class="row " >
            @foreach ($voyages as $voyage)
                <div class="col-md-4">
                    <div class="mb-4">
                        <figure class="image-block mb-4 shadow mb-4 bg-white" style="max-width:400px; height:400px">
                            <h1>{{ $voyage->ville_voyage }}</h1>
                            <img src="{{ asset('image/' . $voyage->image_voyage) }}" alt="" />
                            <figcaption class="figcaption-voyage-admin">
                                <h3>
                                    Plus d'informations
                                </h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            Pays voyage: {{ $voyage->pays_voyage }}<br>
                                            Ville Hôtel: {{ $voyage->ville_voyage }}<br>
                                            Date début: {{ $voyage->date_debut_voyage }}<br>
                                            Date fin: {{ $voyage->date_fin_voyage }}<br>
                                            Type d'hébergement: {{ $voyage->type_hibergement }}<br>
                                            Numéro de téléphone: <i class="fas fa-phone"></i> {{ $voyage->numero_tel_voyage }}<br>
                                            Nombre de personnes: {{ $voyage->nbr_personne_voyage }} ({{ $voyage->nbr_place_reste_voyage }} place(s) restante(s))<br>
                                            Prix: {{ $voyage->prix_voyage }} MAD
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a class="btn btn-secondary col-12" href="{{ route('home.voyage.edit',$voyage->id) }}" role="button">Modifier</a>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px">
                                        <button class="btn btn-danger col-12"  data-bs-toggle="modal" data-bs-target="#confirm-delete-modal-{{ $voyage->id }}">Supprimer</button>
                                        {{-- <form style="box-shadow: none" method="POST" action="{{ route('home.voyage.destroy', $voyage->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger col-12">Supprimer</button>
                                        </form> --}}
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>

                <div class="modal fade" style="margin-top:300px" id="confirm-delete-modal-{{ $voyage->id }}" tabindex="-1" aria-labelledby="confirm-delete-modal-label-{{ $voyage->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirm-delete-modal-label-{{ $voyage->id }}">Confirmation de suppression</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer cette voyage? Cette action est irréversible.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <form style="box-shadow: none" method="POST" action="{{ route('home.voyage.destroy', $voyage->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger col-12">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <h1>Aucun voyage trouvé</h1>
    @endif
</div>
@endsection
