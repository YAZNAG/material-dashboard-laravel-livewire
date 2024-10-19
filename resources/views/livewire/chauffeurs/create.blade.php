<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <h1 class="text-center mb-4">Ajouter un Chauffeur</h1>

            <form action="{{ route('chauffeurs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cin" class="form-label">CIN</label>
                        <input type="text" class="form-control" id="cin" name="cin" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="date_naissance" class="form-label">Date de Naissance</label>
                        <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cin_image" class="form-label">Image du CIN</label>
                        <input type="file" class="form-control" id="cin_image" name="cin_image" accept="image/*" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="certificat_medical_image" class="form-label">Certificat Médical</label>
                        <input type="file" class="form-control" id="certificat_medical_image" name="certificat_medical_image" accept="image/*" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Ajouter Chauffeur</button>
                <a href="{{ route('chauffeurs.index') }}" class="btn btn-secondary">Retour</a>
            </form>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>
</x-layouts.base>
