@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 50px;">

    <form class="input-barresea" method="POST" action="{{ route('home.voyage.search') }}" >
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
        <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Les voyages') }}</div>
    <hr>
    @if ($voyages and count($voyages)>0)
        <div class="row row-cols-1" >
            @foreach ($voyages as $voyage)
                <div class="col-md-4">
                    <div class="mb-4">
                        <figure class="image-block mb-4 shadow mb-4 bg-white" style="max-width:400px; height:400px">
                            <h1>{{ $voyage->ville_voyage }}</h1>
                            <img src="{{ asset('image/' . $voyage->image_voyage) }}" alt="" />
                            <figcaption class="figcaption-voyage">
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
                                    @if ($voyage->nbr_place_reste_voyage = 0)
                                        <h2 style="color: red">Indisponible</h2>
                                    @else
                                        <div class="col-md-12 text-center">
                                            <button type="button" id="btn" class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#reservationModal{{ $voyage->id }}">
                                                Réserver
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>

                <div class="modal fade" id="reservationModal{{ $voyage->id }}" tabindex="-1" aria-labelledby="reservationModal{{ $voyage->id }}Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="margin-top: 70px;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reservationModalLabel">Formulaire de réservation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('home.voyage.reservation.save') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $voyage->id }}" name="voyage_id" id="voyage_id">
                                <input type="hidden" value="{{ Auth()->user()->id }}" name="user_id" id="user_id">
                                <input type="hidden" value="{{ $voyage->prix_voyage }}" name="prix" id="prix">
                                <div class="form-group">
                                    <label for="nom_complete"><span class="fw-bold">Nom complet:</span></label>
                                    <p class="card-text" style="margin-left:10px">{{ Auth()->user()->nom_complete }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="nom_complete"><span class="fw-bold">Ville:</span></label>
                                    <p class="card-text" style="margin-left:10px">{{ $voyage->ville_voyage }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="email"><span class="fw-bold">Adresse email:</span></label>
                                    <p class="card-text" style="margin-left:10px">{{ Auth()->user()->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="telephone"><span class="fw-bold">Numéro de téléphone:</span></label>
                                    <p class="card-text" style="margin-left:10px">{{ Auth()->user()->num_tel }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="prix"><span class="fw-bold">Prix:</span></label>
                                    <p class="card-text" style="margin-left:10px">à partir de {{ $voyage->prix_voyage }}MAD / personne</p>
                                </div>
                                <div class="form-group">
                                    <label for="date_debut"><span class="fw-bold">Date de début:</span></label>
                                    <p class="card-text" style="margin-left:10px">{{ $voyage->date_debut_voyage }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="date_fin"><span class="fw-bold">Date de fin:</span></label>
                                    <p class="card-text" style="margin-left:10px">{{ $voyage->date_fin_voyage }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="nombre_personnes">Nombre de personnes :</label>
                                    <input type="number" name="nombre_personnes" class="form-control" min="1" max="{{ $voyage->nbr_personne_voyage }}" required>
                                </div>
                                <div class="modal-footer" style="justify-content: space-between">
                                    <button type="button" class="col-5 btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="col-5 btn btn-primary">Réserver</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach


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
    @else
        <h1>Aucun voyage trouvé</h1>
    @endif
</div>
@endsection
