<x-layouts.base>
    <x-navbars.sidebar />

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth />

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Ajouter un Chauffeur</h1>

                    <form action="{{ route('chauffeurs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cin" class="form-label">CIN</label>
                            <input type="text" name="cin" id="cin" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cin_image" class="form-label">Image CIN</label>
                            <input type="file" name="cin_image" id="cin_image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="certificat_medical_image" class="form-label">Certificat Médical</label>
                            <input type="file" name="certificat_medical_image" id="certificat_medical_image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="permis_image" class="form-label">Image Permis</label>
                            <input type="file" name="permis_image" id="permis_image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="type_permis" class="form-label">Type de Permis</label>
                            <input type="text" name="type_permis" id="type_permis" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_naissance" class="form-label">Date de Naissance</label>
                            <input type="date" name="date_naissance" id="date_naissance" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" name="telephone" id="telephone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea name="adresse" id="adresse" class="form-control" required></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <x-footers.auth />
    </div>
</x-layouts.base>
