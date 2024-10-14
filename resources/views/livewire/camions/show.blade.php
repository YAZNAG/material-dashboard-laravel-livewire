<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Détails du Camion</h1>

                    <div class="row">
                        <!-- Left Section: Image Gallery -->
                        <div class="col-md-6">
                            <div class="main-image mb-3" style="height: 80%;">
                                @if ($camion->images->isNotEmpty())
                                    <img id="mainImage" src="{{ asset('storage/' . $camion->images->first()->image_path) }}"
                                        class="img-fluid w-100" alt="{{ $camion->matricule }}" style="height: 100%; object-fit: cover;">
                                @else
                                    <p>Aucune image disponible pour ce camion.</p>
                                @endif
                            </div>

                            <div class="row">
                                @foreach ($camion->images as $image)
                                    <div class="col-3 mb-2">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail small-image"
                                                style="cursor: pointer; height: 100px; object-fit: cover;"
                                                onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')"
                                                alt="{{ $camion->matricule }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Right Section: Truck Information -->
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end mb-4">
                                <a href="{{ route('camions.index') }}" class="btn btn-secondary me-2">Retour à la liste</a>
                                <a class="btn btn-primary" href="{{ route('camions.edit', ['camion' => $camion->id]) }}">Modifier</a>
                            </div>
                            <h2>{{ $camion->camion_title }}</h2>
                            <p><strong>Matricule:</strong> {{ $camion->matricule }}</p>
                            <p><strong>Date d'Immatriculation:</strong> {{ $camion->date_imma }}</p>
                            <p><strong>Date de Maintenance:</strong> {{ $camion->date_mec }}</p>
                            <p><strong>Genre:</strong> {{ $camion->genre }}</p>
                            <p><strong>Marque:</strong> {{ $camion->marque }}</p>
                            <p><strong>Type de Carburant:</strong> {{ $camion->type_carburant }}</p>
                            <p><strong>Numéro de Châssis:</strong> {{ $camion->numero_chassais }}</p>
                            <p><strong>Nombre de Cylindres:</strong> {{ $camion->nombre_cylindres }}</p>
                            <p><strong>PTAC:</strong> {{ $camion->PTAC}}</p>
                            <p><strong>Poids Vide:</strong> {{ $camion->poids_vide }}</p>
                            <p><strong>Type d'Usage:</strong> {{ $camion->type_usage }}</p>

                            <!-- PDF Download Links -->
                            <div class="mt-3">
                                @if ($camion->cart_autorisation)
                                    <a href="{{ asset('storage/' . $camion->cart_autorisation) }}" class="btn btn-info mb-2" download>Télécharger Carte Autorisation</a>
                                @endif
                                @if ($camion->cart_grise)
                                    <a href="{{ asset('storage/' . $camion->cart_grise) }}" class="btn btn-info mb-2" download>Télécharger Carte Grise</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Data Section: Assurances, Taxes, etc. -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Données Associées</h4>
                                    <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#assurances" role="tab">
                                                Les Assurances
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#taxes" role="tab">
                                                Taxes Automobiles Annuelles (T.A.A)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#visites" role="tab">
                                                Les Visites
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Tab Contents -->
                                    <div class="tab-content p-3">
                                        <!-- Assurances -->
                                        <div class="tab-pane active" id="assurances" role="tabpanel">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Numéro D'ordre</th>
                                                        <th>Date Début</th>
                                                        <th>Date Fin</th>
                                                        <th>Montant</th>
                                                        <th>Entreprise Assurance</th>
                                                        <th>Numéro Police</th>
                                                        <th>Intermédiaire</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($assurances && $assurances->isNotEmpty())
                                                        @foreach ($assurances as $assurance)
                                                            <tr>
                                                                <td>{{ $assurance->numero_ordre }}</td>
                                                                <td>{{ $assurance->date_debut }}</td>
                                                                <td>{{ $assurance->date_fin }}</td>
                                                                <td>{{ $assurance->montant }}</td>
                                                                <td>{{ $assurance->entreprise_assurance }}</td>
                                                                <td>{{ $assurance->numero_police }}</td>
                                                                <td>{{ $assurance->intermediaire }}</td>
                                                                <td>
                                                                    @if ($assurance->assurance_pdf)
                                                                        <a href="{{ asset('documents/camions/Assurances/' . $assurance->assurance_pdf) }}"
                                                                           class="btn btn-info" download>Télécharger</a>
                                                                    @endif
                                                                    <form action="{{ route('assurance.delete', $assurance->id) }}" method="POST" style="display:inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger"
                                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette assurance ?');">
                                                                            Supprimer
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="8">Aucune assurance disponible.</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Taxes -->
                                        <div class="tab-pane" id="taxes" role="tabpanel">
                                            <!-- Add your taxes table content here -->
                                        </div>

                                        <!-- Visites -->
                                        <div class="tab-pane" id="visites" role="tabpanel">
                                            <!-- Add your visits table content here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Include necessary plugins -->

    @section('scripts')
        <script>
            // Image switcher functionality
            function changeImage(newSrc) {
                document.getElementById('mainImage').src = newSrc;
            }

            // Initialize DataTable
            $(document).ready(function() {
                $('#camionsTable').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.5/dataTables.french.json'
                    }
                });
            });
        </script>
    @endsection
</x-layouts.base>
