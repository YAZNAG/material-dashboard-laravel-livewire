<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Modifier la Visite</h1>

                    <!-- Form for editing an existing visit -->
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('visites.update', $visite->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- PUT method for updating -->

                                <!-- Camion Selection -->
                                <div class="mb-3">
                                    <label for="camion_id" class="form-label">Camion</label>
                                    <select name="camion_id" id="camion_id" class="form-control" required>
                                        <option value="">Sélectionner un camion</option>
                                        @foreach($camions as $camion)
                                            <option value="{{ $camion->id }}" {{ $visite->camion_id == $camion->id ? 'selected' : '' }}>
                                                {{ $camion->matricule }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date de Début -->
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de Début</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ $visite->date_debut }}" required>
                                </div>

                                <!-- Date de Fin -->
                                <div class="mb-3">
                                    <label for="date_fin" class="form-label">Date de Fin</label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ $visite->date_fin }}" required>
                                </div>

                                <!-- Type de Visite -->
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type de Visite</label>
                                    <input type="text" class="form-control" id="type" name="type" value="{{ $visite->type }}" required>
                                </div>

                                <!-- Numéro d'Autorisation -->
                                <div class="mb-3">
                                    <label for="numero_autorisation" class="form-label">Numéro d'Autorisation</label>
                                    <input type="text" class="form-control" id="numero_autorisation" name="numero_autorisation" value="{{ $visite->numero_autorisation }}">
                                </div>

                                <!-- Nom du Centre -->
                                <div class="mb-3">
                                    <label for="nom_centre" class="form-label">Nom du Centre d'Inspection</label>
                                    <input type="text" class="form-control" id="nom_centre" name="nom_centre" value="{{ $visite->nom_centre }}">
                                </div>

                                <!-- Adresse du Centre -->
                                <div class="mb-3">
                                    <label for="address_centre" class="form-label">Adresse du Centre d'Inspection</label>
                                    <input type="text" class="form-control" id="address_centre" name="address_centre" value="{{ $visite->address_centre }}">
                                </div>

                                <!-- Résultat de la Visite -->
                                <div class="mb-3">
                                    <label for="resultat" class="form-label">Résultat de la Visite</label>
                                    <textarea class="form-control" id="resultat" name="resultat">{{ $visite->resultat }}</textarea>
                                </div>

                                <!-- Image Upload (existing image shown if available) -->
                                <div class="mb-3">
                                    <label for="visite_image" class="form-label">Image de la Visite</label>
                                    <input type="file" class="form-control" id="visite_image" name="visite_image" accept="image/*">
                                    @if($visite->image_path)
                                        <img src="{{ asset('storage/' . $visite->image_path) }}" alt="Visite Image" class="img-thumbnail mt-2" style="width: 150px;">
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Mettre à jour la Visite</button>
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
