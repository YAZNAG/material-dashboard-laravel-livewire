<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Ajouter une Carte d'Autorisation</h1>

                    <!-- Form for creating a new carte d'autorisation -->
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('cartesautorisation.store') }}" method="POST" enctype="multipart/form-data">
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

                                <!-- Numéro d'Inscription -->
                                <div class="mb-3">
                                    <label for="numero_inscription" class="form-label">Numéro d'Inscription</label>
                                    <input type="text" class="form-control" id="numero_inscription" name="numero_inscription" required>
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

                                <!-- Image Upload -->
                                <div class="mb-3">
                                    <label for="image_path" class="form-label">Image de la Carte d'Autorisation</label>
                                    <input type="file" class="form-control" id="image_path" name="image_path" accept="image/*">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Ajouter Carte d'Autorisation</button>
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
