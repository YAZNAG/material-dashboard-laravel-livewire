<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Modifier Chauffeur</h1>

                    <form action="{{ route('chauffeurs.update', $chauffeur->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Utiliser PUT pour la mise à jour -->

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" id="nom" value="{{ old('nom', $chauffeur->nom) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" id="prenom" value="{{ old('prenom', $chauffeur->prenom) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="cin" class="form-label">CIN</label>
                            <input type="text" name="cin" class="form-control" id="cin" value="{{ old('cin', $chauffeur->cin) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="cin_image" class="form-label">Image CIN</label>
                            <input type="file" name="cin_image" class="form-control" id="cin_image">
                            @if ($chauffeur->cin_image)
                                <a href="{{ Storage::url($chauffeur->cin_image) }}" class="btn btn-info mt-2" download>Télécharger Image CIN</a>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="certificat_medical_image" class="form-label">Certificat Médical</label>
                            <input type="file" name="certificat_medical_image" class="form-control" id="certificat_medical_image">
                            @if ($chauffeur->certificat_medical_image)
                                <a href="{{ Storage::url($chauffeur->certificat_medical_image) }}" class="btn btn-info mt-2" download>Télécharger Certificat Médical</a>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="permis_image" class="form-label">Image Permis</label>
                            <input type="file" name="permis_image" class="form-control" id="permis_image">
                            @if ($chauffeur->permis_image)
                                <a href="{{ Storage::url($chauffeur->permis_image) }}" class="btn btn-info mt-2" download>Télécharger Image Permis</a>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="type_permis" class="form-label">Type de Permis</label>
                            <input type="text" name="type_permis" class="form-control" id="type_permis" value="{{ old('type_permis', $chauffeur->type_permis) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_naissance" class="form-label">Date de Naissance</label>
                            <input type="date" name="date_naissance" class="form-control" id="date_naissance" value="{{ old('date_naissance', $chauffeur->date_naissance) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" id="telephone" value="{{ old('telephone', $chauffeur->telephone) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" id="adresse" value="{{ old('adresse', $chauffeur->adresse) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Include any necessary plugins -->
</x-layouts.base>
