<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Modifier Carte Grise</h1>

                    <!-- Form for editing an existing "Carte Grise" -->
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('cartesgrise.update', $carte->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Camion Selection -->
                                <div class="mb-3">
                                    <label for="camion_id" class="form-label">Camion</label>
                                    <select name="camion_id" id="camion_id" class="form-control" required>
                                        <option value="">Sélectionner un camion</option>
                                        @foreach($camions as $camion)
                                            <option value="{{ $camion->id }}" {{ $carte->camion_id == $camion->id ? 'selected' : '' }}>
                                                {{ $camion->matricule }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date de Fin -->
                                <div class="mb-3">
                                    <label for="date_fin" class="form-label">Date de Fin</label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ old('date_fin', $carte->date_fin) }}" required>
                                </div>

                                <!-- Current Carte Grise Image Display -->
                                <div class="mb-3">
                                    <label class="form-label">Image Actuelle</label>
                                    @if($carte->image_path)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $carte->image_path) }}" alt="Carte Grise Image" class="img-fluid mb-3" style="max-width: 200px;">
                                            <a href="{{ asset('storage/' . $carte->image_path) }}" target="_blank" class="btn btn-info">Voir l'image</a>
                                            <a href="{{ asset('storage/' . $carte->image_path) }}" download class="btn btn-success">Télécharger</a>
                                        </div>
                                    @else
                                        <p>Aucune image disponible.</p>
                                    @endif
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
