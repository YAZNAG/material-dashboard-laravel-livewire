<x-layouts.base>
    <x-navbars.sidebar />
    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth />

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Modifier la Taxe Spéciale Annuelle</h1>

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('taxes.update', $taxe->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Année -->
                                <div class="mb-3">
                                    <label for="annee" class="form-label">Année</label>
                                    <select name="annee" id="annee" class="form-control" required>
                                        <option value="">Sélectionner une année</option>
                                        @for ($i = 2000; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}" {{ $taxe->annee == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Tranche -->
                                <div class="mb-3">
                                    <label for="trache" class="form-label">Tranche</label>
                                    <select name="trache" id="trache" class="form-control" required>
                                        <option value="">Sélectionner une tranche</option>
                                        <option value="1/1" {{ $taxe->trache == '1/1' ? 'selected' : '' }}>1/1</option>
                                        <option value="1/2" {{ $taxe->trache == '1/2' ? 'selected' : '' }}>1/2</option>
                                        <option value="2/2" {{ $taxe->trache == '2/2' ? 'selected' : '' }}>2/2</option>
                                    </select>
                                </div>

                                <!-- Montant Principal -->
                                <div class="mb-3">
                                    <label for="montant_principal" class="form-label">Montant Principal</label>
                                    <input type="number" class="form-control" id="montant_principal" name="montant_principal" value="{{ $taxe->montant_principal }}" required min="0">
                                </div>

                                <!-- Pénalité -->
                                <div class="mb-3">
                                    <label for="penalite" class="form-label">Pénalité</label>
                                    <input type="number" class="form-control" id="penalite" name="penalite" value="{{ $taxe->penalite }}" min="0">
                                </div>

                                <!-- Majorations -->
                                <div class="mb-3">
                                    <label for="majorations" class="form-label">Majorations</label>
                                    <input type="number" class="form-control" id="majorations" name="majorations" value="{{ $taxe->majorations }}" min="0">
                                </div>

                                <!-- Montant Total -->
                                <div class="mb-3">
                                    <label for="montant_total" class="form-label">Montant Total</label>
                                    <input type="number" class="form-control" id="montant_total" name="montant_total" value="{{ $taxe->montant_total }}" required min="0" readonly>
                                </div>

                                <!-- Date de Paiement -->
                                <div class="mb-3">
                                    <label for="date_paiement" class="form-label">Date de Paiement</label>
                                    <input type="date" class="form-control" id="date_paiement" name="date_paiement" value="{{ $taxe->date_paiement }}">
                                </div>

                                <!-- Camion Selection -->
                                <div class="mb-3">
                                    <label for="camion_id" class="form-label">Camion</label>
                                    <select name="camion_id" id="camion_id" class="form-control" required>
                                        <option value="">Sélectionner un camion</option>
                                        @foreach($camions as $camion)
                                            <option value="{{ $camion->id }}" {{ $taxe->camion_id == $camion->id ? 'selected' : '' }}>
                                                {{ $camion->matricule }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Image -->
                                <div class="mb-3">
                                    <label for="taxe_image" class="form-label">Image de la Taxe</label>
                                    <input type="file" class="form-control-file" id="taxe_image" name="taxe_image" accept="image/*">
                                    @if ($taxe->taxe_image)
                                        <p>Image actuelle : <a href="{{ asset('storage/images/camions/taxes/' . basename($taxe->taxe_image)) }}" download>Télécharger</a></p>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Mettre à jour la Taxe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footers.auth />
    </div>
    <x-plugins />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to calculate Montant Total
            function calculateMontantTotal() {
                const montantPrincipal = parseFloat(document.getElementById('montant_principal').value) || 0;
                const penalite = parseFloat(document.getElementById('penalite').value) || 0;
                const majorations = parseFloat(document.getElementById('majorations').value) || 0;

                // Calculate total
                const montantTotal = montantPrincipal + penalite + majorations;

                // Update the Montant Total input field
                document.getElementById('montant_total').value = montantTotal.toFixed(2);
            }

            // Add event listeners to the inputs
            document.getElementById('montant_principal').addEventListener('input', calculateMontantTotal);
            document.getElementById('penalite').addEventListener('input', calculateMontantTotal);
            document.getElementById('majorations').addEventListener('input', calculateMontantTotal);
        });
    </script>
</x-layouts.base>
