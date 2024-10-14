<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Ajouter une Assurance</h1>

                    <!-- Form for creating new assurance -->
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('assurances.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Camion Selection -->
                                <div class="mb-3">
                                    <label for="camion_id" class="form-label">Camion</label>
                                    <select name="camion_id" id="camion_id" class="form-control" required>
                                        <option value="">Sélectionner un camion</option>
                                        @foreach($camions as $camion)
                                            <option value="{{ $camion->id }}">{{ $camion->matricule }}</option>
                                        @endforeach
                                    </select>
                                </div>
<div class="mb-3">
    <label for="numero_ordre" class="form-label">Numéro d'Ordre</label>
    <input type="text" name="numero_ordre" id="numero_ordre" class="form-control" required>
</div>

                                <!-- Police Number -->
                                <div class="mb-3">
                                    <label for="numero_police" class="form-label">Numéro de Police</label>
                                    <input type="text" class="form-control" id="numero_police" name="numero_police" required>
                                </div>

                                <!-- Montant -->
                                <div class="mb-3">
                                    <label for="montant" class="form-label">Montant</label>
                                    <input type="number" class="form-control" id="montant" name="montant" required>
                                </div>

                                <!-- Date de Début -->
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de Début</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                                </div>

                                <!-- Date de Fin -->
                                <div class="mb-3">
                                    <label for="date_fin" class="form-label">Date de Fin</label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                                </div>

                                <!-- Entreprise Assurance -->
                                <div class="mb-3">
                                    <label for="entreprise_assurence" class="form-label">Entreprise d'Assurance</label>
                                    <input type="text" class="form-control" id="entreprise_assurence" name="entreprise_assurence" required>
                                </div>

                                <!-- Intermédiaire -->
                                <div class="mb-3">
                                    <label for="intermediaire" class="form-label">Intermédiaire</label>
                                    <input type="text" class="form-control" id="intermediaire" name="intermediaire" required>
                                </div>

                                <!-- Assurance Image -->
                                <div class="mb-3">
                                    <label for="assurence_image" class="form-label">Image de l'Assurance</label>
                                    <input type="file" class="form-control-file" id="assurence_image" name="assurence_image" accept="image/*">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Ajouter Assurance</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Include any necessary plugins -->
</x-layouts.base>
