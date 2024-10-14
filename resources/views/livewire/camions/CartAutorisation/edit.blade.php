<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Modifier la Carte d'Autorisation</h1>

                    <!-- Form for editing an existing Carte d'Autorisation -->
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('cartesautorisation.update', $autorisation->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Camion Selection -->
                                <div class="mb-3">
                                    <label for="camion_id" class="form-label">Camion</label>
                                    <select name="camion_id" id="camion_id" class="form-control" required>
                                        <option value="">Sélectionner un camion</option>
                                        @foreach($camions as $camion)
                                            <option value="{{ $camion->id }}" {{ $camion->id == $autorisation->camion_id ? 'selected' : '' }}>
                                                {{ $camion->matricule }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Current Carte d'Autorisation Image Display -->
                                <div class="mb-3">
                                    <label class="form-label">Image Actuelle</label>
                                    @if($autorisation->image_path)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $autorisation->image_path) }}" alt="Carte d'Autorisation Image" class="img-fluid mb-3" style="max-width: 200px;">
                                            <a href="{{ asset('storage/' . $autorisation->image_path) }}" target="_blank" class="btn btn-info">Voir l'image</a>
                                            <a href="{{ asset('storage/' . $autorisation->image_path) }}" download class="btn btn-success">Télécharger</a>
                                        </div>
                                    @else
                                        <p>Aucune image disponible.</p>
                                    @endif
                                </div>

                                <!-- Date de Début -->
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de Début</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ old('date_debut', $autorisation->date_debut) }}" required>
                                </div>

                                <!-- Date de Fin -->
                                <div class="mb-3">
                                    <label for="date_fin" class="form-label">Date de Fin</label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ old('date_fin', $autorisation->date_fin) }}" required>
                                </div>

                                <!-- Upload New Image (optional) -->
                                <div class="mb-3">
                                    <label for="image_path" class="form-label">Changer l'image (optionnel)</label>
                                    <input type="file" class="form-control" id="image_path" name="image_path" accept="image/*">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
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
