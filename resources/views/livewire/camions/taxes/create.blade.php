<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Ajouter une Taxe Spéciale Annuelle</h1>

                    <!-- Form for creating new taxe -->
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('taxes.store') }}" method="POST" enctype="multipart/form-data">
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

                                <!-- Année -->
                                <div class="mb-3">
                                    <label for="annee" class="form-label">Année</label>
                                    <select name="annee" id="annee" class="form-control" required>
                                        <option value="">Sélectionner une année</option>
                                        @for ($year = 2000; $year <= date('Y'); $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Tranche -->
                                <div class="mb-3">
                                    <label for="trache" class="form-label">Tranche</label>
                                    <select name="trache" id="trache" class="form-control" required>
                                        <option value="">Sélectionner une tranche</option>
                                        <option value="1/1">1/1</option>
                                        <option value="1/2">1/2</option>
                                        <option value="2/2">2/2</option>
                                    </select>
                                </div>


                                <!-- Montant Principal -->
                                <div class="mb-3">
                                    <label for="montant_principal" class="form-label">Montant Principal</label>
                                    <input type="number" class="form-control" id="montant_principal" name="montant_principal" min="0" value="0" required oninput="calculateTotal()">
                                </div>

                                <!-- Pénalité -->
                                <div class="mb-3">
                                    <label for="penalite" class="form-label">Pénalité</label>
                                    <input type="number" class="form-control" id="penalite" name="penalite" min="0" value="0" oninput="calculateTotal()">
                                </div>

                                <!-- Majorations -->
                                <div class="mb-3">
                                    <label for="majorations" class="form-label">Majorations</label>
                                    <input type="number" class="form-control" id="majorations" name="majorations" min="0" value="0" oninput="calculateTotal()">
                                </div>

                                <!-- Montant Total -->
                                <div class="mb-3">
                                    <label for="montant_total" class="form-label">Montant Total</label>
                                    <input type="number" class="form-control" id="montant_total" name="montant_total" readonly>
                                </div>


                                <!-- Date de Paiement -->
                                <div class="mb-3">
                                    <label for="date_paiement" class="form-label">Date de Paiement</label>
                                    <input type="date" class="form-control" id="date_paiement" name="date_paiement">
                                </div>

                               <!-- Image Upload -->
                                   <div class="mb-3">
                                       <label for="taxe_image" class="form-label">Image de la Taxe</label>
                                       <input type="file" class="form-control" id="taxe_image" name="taxe_image" accept="image/*">
                                   </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Ajouter Taxe</button>
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
