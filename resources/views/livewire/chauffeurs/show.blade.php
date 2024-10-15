<x-layouts.base>
    <x-navbars.sidebar />

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth />

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Détails du Chauffeur</h1>

                    <div class="container p-5">
                        <div class="row mb-5">
                            <div class="col-md-4 text-center">
                                <img class="rounded-circle" style="height: 250px; width: 250px;" alt="Profile Image"
                                    src="{{ asset('storage/images/chauffeurs/chauffeurs.png') }}">
                            </div>

                            <div class="col-md-5">
                                <div>
                                    <h2>Informations personnelles</h2>
                                    <ul class="list-unstyled">
                                        <li><strong>Nom :</strong> {{ $chauffeur->nom }}</li>
                                        <li><strong>Prénom :</strong> {{ $chauffeur->prenom }}</li>
                                        <li><strong>CIN :</strong> {{ $chauffeur->cin }}</li>
                                        <li><strong>Adresse :</strong> {{ $chauffeur->adresse }}</li>
                                        <li><strong>Téléphone :</strong> {{ $chauffeur->telephone }}</li>
                                        <li><strong>Date de naissance :</strong> {{ $chauffeur->date_naissance }}</li>
                                    </ul>
                                </div>

                                <div class="mt-3">
                                    <h2>Informations sur le permis</h2>
                                    <ul class="list-unstyled">
                                        <li><strong>Date de délivrance du permis :</strong> {{ $chauffeur->date_delivration_permis }}</li>
                                        <li><strong>Date de fin du permis :</strong> {{ $chauffeur->date_fin_permis }}</li>
                                        <li><strong>Type de permis :</strong> {{ $chauffeur->type_permis }}</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-3" style="border-left: 2px solid black;">
                                <h2>Statut du contrat</h2>
                                @if ($chauffeur->contrats && $chauffeur->contrats->isNotEmpty())
                                    @php
                                        $contract = $chauffeur->contrats->first();
                                        $date_fin = $contract->date_fin;
                                    @endphp
                                    @if (\Carbon\Carbon::now()->lessThan($date_fin))
                                        <i class="fas fa-check text-success"></i> Contrat Actif
                                    @else
                                        <i class="fas fa-times text-danger"></i> Contrat Expiré
                                    @endif
                                @else
                                    <i class="fas fa-ban text-warning"></i> Pas de Contrat
                                @endif

                                <div class="mt-4">
                                    @if ($chauffeur->permis_image)
                                        <a href="{{ asset('storage/' . $chauffeur->permis_image) }}" class="btn btn-info mb-2" download>Télécharger Permis</a>
                                    @endif
                                    @if ($chauffeur->cin_image)
                                        <a href="{{ asset('storage/' . $chauffeur->cin_image) }}" class="btn btn-info mb-2" download>Télécharger CIN</a>
                                    @endif
                                    @if ($chauffeur->certificat_medical_image)
                                        <a href="{{ asset('storage/' . $chauffeur->certificat_medical_image) }}" class="btn btn-info mb-2" download>Télécharger Certificat Médical</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Tab Section for Contracts and Trajets -->
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Section des données</h4>
                                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#contracts" role="tab">
                                                    <span class="d-none d-md-block">Les Contrats</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#trajets" role="tab">
                                                    <span class="d-none d-md-block">Les Trajets</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <!-- Contract Table -->
                                            <div class="tab-pane active p-3" id="contracts" role="tabpanel">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Statut du Contrat</th>
                                                            <th>Date Début</th>
                                                            <th>Date Fin</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($chauffeur->contrats as $contract)
                                                            <tr>
                                                                <td>
                                                                    @if (\Carbon\Carbon::now()->lessThan($contract->date_fin))
                                                                        <i class="fas fa-check text-success"></i> Actif
                                                                    @else
                                                                        <i class="fas fa-times text-danger"></i> Expiré
                                                                    @endif
                                                                </td>
                                                                <td>{{ $contract->date_debut }}</td>
                                                                <td>{{ $contract->date_fin }}</td>
                                                                <td>
                                                                    <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                                                    <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center">Aucun contrat trouvé</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Trajet Table -->
                                            <div class="tab-pane p-3" id="trajets" role="tabpanel">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID Trajet</th>
                                                            <th>Titre du Trajet</th>
                                                            <th>Description</th>
                                                            <th>Prix</th>
                                                            <th>Adresse Départ</th>
                                                            <th>Adresse Arrivée</th>
                                                            <th>Date Début</th>
                                                            <th>Date Fin</th>
                                                            <th>Camion Matricule</th>
                                                            <th>Client</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($chauffeur->trajets as $trajet)
                                                            <tr>
                                                                <td>{{ $trajet->id }}</td>
                                                                <td>{{ $trajet->trajet_title }}</td>
                                                                <td>{{ $trajet->description }}</td>
                                                                <td>{{ $trajet->trajet_price }}</td>
                                                                <td>{{ $trajet->address_start }}</td>
                                                                <td>{{ $trajet->address_End }}</td>
                                                                <td>{{ $trajet->date_start }}</td>
                                                                <td>{{ $trajet->date_end }}</td>
                                                                <td>{{ $trajet->camion->matricule ?? 'N/A' }}</td>
                                                                <td>{{ $trajet->client->nom ?? 'N/A' }}</td>
                                                                <td>
                                                                    <a href="{{ route('trajets.edit', $trajet->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                                                    <form action="{{ route('trajets.destroy', $trajet->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="11" class="text-center">Aucun trajet trouvé</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.base>
