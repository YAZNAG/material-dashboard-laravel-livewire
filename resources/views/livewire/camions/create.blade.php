<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Créer un Nouveau Camion</h1>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('camions.store') }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow" style="background-color: #f7f9fc; border: 1px solid #dee2e6;">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule</label>
                                <input type="text" name="matricule" id="matricule" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="antérieure_matricule" class="form-label">Ancienne Matricule</label>
                                <input type="text" name="antérieure_matricule" id="antérieure_matricule" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="camion_title" class="form-label">Titre du Camion</label>
                                <input type="text" name="camion_title" id="camion_title" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modele" class="form-label">Modèle</label>
                                <input type="text" name="modele" id="modele" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type</label>
                                <input type="text" name="type" id="type" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_imma" class="form-label">Date d'Immatriculation</label>
                                <input type="date" name="date_imma" id="date_imma" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_mec" class="form-label">Date de Maintenance</label>
                                <input type="date" name="date_mec" id="date_mec" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="genre" class="form-label">Genre</label>
                                <input type="text" name="genre" id="genre" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marque" class="form-label">Marque</label>
                                <input type="text" name="marque" id="marque" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type_carburant" class="form-label">Type de Carburant</label>
                                <input type="text" name="type_carburant" id="type_carburant" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="numero_chassais" class="form-label">Numéro de Châssis</label>
                                <input type="text" name="numero_chassais" id="numero_chassais" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre_cylindres" class="form-label">Nombre de Cylindres</label>
                                <input type="number" name="nombre_cylindres" id="nombre_cylindres" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="PTAC" class="form-label">P.T.A.C</label>
                                <input type="number" name="PTAC" id="PTAC" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type_usage" class="form-label">Type d'Usage</label>
                                <input type="text" name="type_usage" id="type_usage" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="poids_vide" class="form-label">Poids Vide</label>
                                <input type="number" name="poids_vide" id="poids_vide" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="puissance_fiscale" class="form-label">Puissance Fiscale</label>
                                <input type="number" name="puissance_fiscale" id="puissance_fiscale" class="form-control" style="background-color: #ffffff; border: 1px solid #ced4da;" min="0">
                            </div>
                            <div class="col-md-12 mb-3">
                              <label for="images" class="form-label">Images</label>
                                          <input type="file" class="form-control" name="images[]" multiple>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Créer le Camion</button>
                            <a href="{{ route('camions.index') }}" class="btn btn-secondary ml-2">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Include any necessary plugins -->
</x-layouts.base>
