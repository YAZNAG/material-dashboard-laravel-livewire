<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->
    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Détails du Chauffeur: {{ $chauffeur->nom }}</h1>

                <!-- Section pour les données du chauffeur -->
                <div class="row mb-5">
                    <div class="col-md-4">
                        <img class="rounded-circle" style="height: 250px; width: 250px;" alt="Profile Image" src="{{ asset('storage/' . $chauffeur->profile_image) }}">
                    </div>
                    <div class="col-md-5">
                        <div>
                            <h1>Informations personnelles</h1>
                            <ul>
                                <li>Nom : {{ $chauffeur->nom }}</li>
                                <li>Prénom : {{ $chauffeur->prenom }}</li>
                                <li>CIN : {{ $chauffeur->cin }}</li>
                                <li>Adresse : {{ $chauffeur->address }}</li>
                                <li>Téléphone : {{ $chauffeur->phone }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3" style="border-left: 2px solid black;">
                        <div>
                            <h1>Statut du contrat</h1>
                            @if ($chauffeur->contrats->isNotEmpty())
                                @php
                                    $contract = $chauffeur->contrats->first();
                                    $date_fin = $contract->date_fin;
                                @endphp
                                @if (\Carbon\Carbon::now()->lessThan($date_fin))
                                    <i class="fas fa-check text-success"></i> Contrat Actif
                                @else
                                    <i class="fas fa-times text-danger"></i> Contrat Expiré
                                @endif
                            @else
                                <i class="fas fa-ban text-warning"></i> Pas de Contrat
                            @endif
                        </div>
                        <div class="mt-4">
                            @if ($chauffeur->cin_image)
                                <a href="{{ asset('storage/' . $chauffeur->cin_image) }}" class="btn btn-info mb-2" download>Télécharger CIN</a>
                            @endif
                            <br>
                            @if ($chauffeur->certificat_medical_image)
                                <a href="{{ asset('storage/' . $chauffeur->certificat_medical_image) }}" class="btn btn-info mb-2" download>Télécharger Certificat</a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Section pour les Contrats et Permis -->
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Section des données</h4>

                                <!-- Boutons pour créer Permis et Contrat -->
                                <div class="mb-4 text-end">
                                    <button class="btn btn-primary" onclick="toggleDiv('createPermis')">Créer un Permis</button>
                                    <button class="btn btn-secondary" onclick="toggleDiv('createContract')">Créer un Contrat</button>
                                </div>

                                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#contracts" role="tab">
                                            <span class="d-none d-md-block">Les Contrats</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#trajets" role="tab">
                                            <span class="d-none d-md-block">Les Trajets</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#permis" role="tab">
                                            <span class="d-none d-md-block">Les Permis</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                   <!-- Table des Contrats -->
                                      <div class="tab-pane active p-3" id="contracts" role="tabpanel">
                                          <table class="table table-striped">
                                              <thead>
                                                  <tr>

                                                      <th scope="col">Date de Début</th>
                                                      <th scope="col">Date de Fin</th>
                                                      <th scope="col">salaire</th>
                                                      <th scope="col">document</th>
                                                      <th scope="col">Actions</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @foreach($chauffeur->contrats as $contrat)
                                                      <tr>
                                                          <td>{{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }}</td>
                                                          <td>{{ \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/Y') }}</td>
                                                          <td>{{ number_format($contrat->salaire, 2, ',', ' ') }} MAD</td>
                                                          <td>
                                                              <a href="{{ asset('storage/' . $contrat->contrat_pdf) }}" download>
                                                                   <i class="fas fa-download" style="font-size: 24px;"></i>
                                                               </a>
                                                           </td>

                                                          <td>
                                                             <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="toggleDiv('updateContract')">Modifier</a>

                                                              <form action="{{ route('contrats.destroy', ['chauffeur' => $chauffeur->id, 'contrat' => $contrat->id]) }}" method="POST" style="display: inline;">
                                                                  @csrf
                                                                  @method('DELETE')
                                                                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?')">Supprimer</button>
                                                              </form>

                                                          </td>
                                                      </tr>
                                                  @endforeach
                                              </tbody>
                                          </table>

                                          @if($chauffeur->contrats->isEmpty())
                                              <div class="alert alert-warning text-center" role="alert">
                                                  Aucun contrat disponible.
                                              </div>
                                          @endif
                                      </div>



                                    <!-- Table des Trajets -->
                                    <div class="tab-pane p-3" id="trajets" role="tabpanel">
                                        <!-- Content omitted for brevity -->
                                    </div>

                                  <!-- Table des Permis -->
                                  <div class="tab-pane p-3" id="permis" role="tabpanel">

                                      <!-- Vérifiez si le chauffeur a des permis -->
                                      @if($chauffeur->permis->isEmpty())
                                          <div class="alert alert-warning text-center" role="alert">
                                              Aucun permis disponible.
                                          </div>
                                      @else
                                          <!-- Table -->
                                          <table class="table table-striped">
                                              <thead>
                                                  <tr>
                                                      <th scope="col">Type de Permis</th>
                                                      <th scope="col">Image</th>
                                                      <th scope="col">Date de delivration</th>
                                                      <th scope="col">Date d'Expiration</th>
                                                      <th scope="col">Actions</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @foreach($chauffeur->permis as $permisItem)
                                                      <tr>
                                                          <td>{{ $permisItem->type_permis }}</td>
                                                          <td>
                                                              <a href="{{ asset('storage/' . $permisItem->image_permis) }}" download>
                                                                  <i class="fas fa-download" style="font-size: 24px;"></i>
                                                              </a>
                                                          </td>

                                                          <td>{{ \Carbon\Carbon::parse($permisItem->date_delivration)->format('d/m/Y') }}</td>
                                                          <td>{{ \Carbon\Carbon::parse($permisItem->date_fin)->format('d/m/Y') }}</td>
                                                          <td>
<a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="toggleDiv('updatePermis')">Modifier</a>

                                                                  <form action="{{ route('permis.destroy', ['chauffeur' => $chauffeur->id, 'permis' => $permisItem->id]) }}" method="POST" style="display: inline;">
                                                                      @csrf
                                                                      @method('DELETE')
                                                                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce permis ?')">Supprimer</button>
                                                                  </form>




                                                          </td>
                                                      </tr>
                                                  @endforeach
                                              </tbody>
                                          </table>
                                      @endif

                                  </div>


                                </div>

                                <!-- Formulaire de création d'un Permis -->
                                <!-- Formulaire de création d'un Permis -->
                                <div id="createPermis" class="form-container" style="display: none;">
                                    <div class="close-btn" onclick="toggleDiv('createPermis')">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <h5 class="text-center mb-4">Créer un Permis</h5>

                                    <form action="{{ route('permis.store', $chauffeur->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="type_permis" class="form-label">Type de Permis</label>
                                            <select class="form-select @error('type_permis') is-invalid @enderror" id="type_permis" name="type_permis" required>
                                                <option value="">-- Sélectionner un type --</option>
                                                <option value="AM" {{ old('type_permis') == 'AM' ? 'selected' : '' }}>AM</option>
                                                <option value="A1" {{ old('type_permis') == 'A1' ? 'selected' : '' }}>A1</option>
                                                <option value="A" {{ old('type_permis') == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ old('type_permis') == 'B' ? 'selected' : '' }}>B</option>
                                                <option value="C" {{ old('type_permis') == 'C' ? 'selected' : '' }}>C</option>
                                                <option value="D" {{ old('type_permis') == 'D' ? 'selected' : '' }}>D</option>
                                                <option value="EB" {{ old('type_permis') == 'EB' ? 'selected' : '' }}>EB</option>
                                                <option value="EC" {{ old('type_permis') == 'EC' ? 'selected' : '' }}>EC</option>
                                                <option value="ED" {{ old('type_permis') == 'ED' ? 'selected' : '' }}>ED</option>
                                            </select>
                                            @error('type_permis')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="image_permis" class="form-label">Image du Permis</label>
                                            <input type="file" class="form-control @error('image_permis') is-invalid @enderror" id="image_permis" name="image_permis" accept="image/*" required>
                                            @error('image_permis')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="date_delivration" class="form-label">Date de Délivrance</label>
                                            <input type="date" class="form-control @error('date_delivration') is-invalid @enderror" id="date_delivration" name="date_delivration" required>
                                            @error('date_delivration')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="date_fin" class="form-label">Date d'Expiration</label>
                                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" name="date_fin" required>
                                            @error('date_fin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <input type="hidden" name="chauffeur_id" value="{{ $chauffeur->id }}">

                                        <button type="submit" class="btn btn-primary w-100">Ajouter le Permis</button>
                                    </form>
                                </div>
                            <div id="updatePermis" class="form-container" style="display: none;">
                                <div class="close-btn" onclick="toggleDiv('updatePermis')">
                                    <i class="fas fa-times"></i>
                                </div>
                                <h5 class="text-center mb-4">Mettre à Jour le Permis</h5>

                                @if($permisItem)
                                    <form action="{{ route('permis.update', ['chauffeurId' => $chauffeur->id, 'permisId' => $permisItem->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="type_permis" class="form-label">Type de Permis</label>
                                            <select class="form-select @error('type_permis') is-invalid @enderror" id="type_permis" name="type_permis" required>
                                                <option value="">-- Sélectionner un type --</option>
                                                @foreach(['AM', 'A1', 'A', 'B', 'C', 'D', 'EB', 'EC', 'ED'] as $type)
                                                    <option value="{{ $type }}" {{ $permisItem->type_permis == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                            @error('type_permis')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="date_delivration" class="form-label">Date de Délivration</label>
                                            <input type="date" class="form-control @error('date_delivration') is-invalid @enderror" id="date_delivration" name="date_delivration" value="{{ \Carbon\Carbon::parse($permisItem->date_delivration)->format('Y-m-d') }}" required>
                                            @error('date_delivration')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="date_fin" class="form-label">Date de Fin</label>
                                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" name="date_fin" value="{{ \Carbon\Carbon::parse($permisItem->date_fin)->format('Y-m-d') }}" required>
                                            @error('date_fin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="image_permis" class="form-label">Image du Permis</label>
                                            <input type="file" class="form-control @error('image_permis') is-invalid @enderror" id="image_permis" name="image_permis">
                                            <small class="text-muted">Laissez vide si vous ne souhaitez pas changer l'image.</small>
                                            @error('image_permis')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">Mettre à jour le Permis</button>
                                    </form>
                                @else
                                    <p>Aucun permis n'est associé à ce chauffeur.</p>
                                @endif
                            </div>




                                <!-- Formulaire de création d'un Contrat -->

                                <!-- Formulaire de création d'un Contrat -->
                                <div id="createContract" class="form-container" style="display: none;">
                                    <div class="close-btn" onclick="toggleDiv('createContract')">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <h5 class="text-center mb-4">Créer un Contrat</h5>
                                    <form action="{{ route('contrats.store', $chauffeur->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="date_debut" class="form-label">Date de Début</label>
                                            <input type="date" class="form-control @error('date_debut') is-invalid @enderror" id="date_debut" name="date_debut" required>
                                            @error('date_debut')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="date_fin" class="form-label">Date de Fin</label>
                                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" name="date_fin" required>
                                            @error('date_fin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="salaire" class="form-label">Salaire</label>
                                            <input type="number" class="form-control @error('salaire') is-invalid @enderror" id="salaire" name="salaire" required>
                                            @error('salaire')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="contrat_pdf" class="form-label">Contrat PDF</label>
                                            <input type="file" class="form-control @error('contrat_pdf') is-invalid @enderror" id="contrat_pdf" name="contrat_pdf" required>
                                            @error('contrat_pdf')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Ajouter le Contrat</button>
                                    </form>
                                </div>
                            <!-- Formulaire de mise à jour d'un Contrat -->
                            <div id="updateContract" class="form-container" style="display: none;">
                                <div class="close-btn" onclick="toggleDiv('updateContract')">
                                    <i class="fas fa-times"></i>
                                </div>
                                <h5 class="text-center mb-4">Modifier un Contrat</h5>
                                @if($contrat)
                                    <form action="{{ route('contrats.update', [$chauffeur->id, $contrat->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') <!-- Utiliser PUT pour la mise à jour -->

                                        <!-- Champs du formulaire pour les détails du contrat -->
                                        <div class="mb-3">
                                            <label for="date_debut" class="form-label">Date de Début</label>
                                            <input type="date" class="form-control @error('date_debut') is-invalid @enderror" id="date_debut" name="date_debut" value="{{ \Carbon\Carbon::parse($contrat->date_debut)->format('Y-m-d') }}" required>
                                            @error('date_debut')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="date_fin" class="form-label">Date de Fin</label>
                                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" name="date_fin" value="{{ \Carbon\Carbon::parse($contrat->date_fin)->format('Y-m-d') }}" required>
                                            @error('date_fin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="salaire" class="form-label">Salaire</label>
                                            <input type="number" class="form-control @error('salaire') is-invalid @enderror" id="salaire" name="salaire" value="{{ $contrat->salaire }}" required>
                                            @error('salaire')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="contrat_pdf" class="form-label">Contrat PDF</label>
                                            <input type="file" class="form-control @error('contrat_pdf') is-invalid @enderror" id="contrat_pdf" name="contrat_pdf">
                                            <small class="text-muted">Laissez vide si vous ne souhaitez pas changer le PDF.</small>
                                            @error('contrat_pdf')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">Mettre à Jour le Contrat</button>
                                    </form>
                                @else
                                    <p>Aucun contrat n'est associé à ce chauffeur.</p>
                                @endif

                            </div>



                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.base>
<script>

</script>
<script>
    function toggleDiv(divId) {
        const permisDiv = document.getElementById('createPermis');
        const updatePermisDiv = document.getElementById('updatePermis'); // Nouveau div pour updatePermis
        const contractDiv = document.getElementById('createContract');
        const updateContractDiv = document.getElementById('updateContract'); // Nouveau div pour updateContract

        // Cacher tous les formulaires au départ
        permisDiv.style.display = 'none';
        updatePermisDiv.style.display = 'none'; // Ajouter la ligne pour cacher updatePermis
        contractDiv.style.display = 'none';
        updateContractDiv.style.display = 'none'; // Cacher updateContract

        // Afficher le formulaire sélectionné
        if (divId === 'createPermis') {
            permisDiv.style.display = 'block';
        } else if (divId === 'updatePermis') { // Ajouter cette condition pour updatePermis
            updatePermisDiv.style.display = 'block';
        } else if (divId === 'createContract') {
            contractDiv.style.display = 'block';
        } else if (divId === 'updateContract') { // Ajouter cette condition pour updateContract
            updateContractDiv.style.display = 'block';
        }
    }
</script>

<script>
    function toggleDiv(divId) {
        const formDiv = document.getElementById(divId);

        // Toggle the display property to show/hide the form
        if (formDiv.style.display === 'block') {
            formDiv.style.display = 'none';  // Hide the form
        } else {
            formDiv.style.display = 'block';  // Show the form
        }
    }
</script>
<style>
/* Container to center form */
.form-container {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 50%;
    height: auto; /* Change to auto for dynamic height */
    transform: translate(-50%, -50%);
    background-color: #ffffff; /* White background for contrast */
    padding: 2rem; /* Space around the content */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Soft shadow */
    border-radius: 8px; /* Rounded corners */
    transition: all 0.3s ease-in-out; /* Smooth transition */
}

/* Close button styling */
.close-btn {
    cursor: pointer;
    position: absolute;
    top: 10px;
    right: 10px;
    color: #ff0000; /* Red color for close button */
}

/* Hover effect */
.form-container:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Darker shadow on hover */
    transform: translate(-50%, -50%) scale(1.05); /* Slight zoom effect */
}

/* Make form responsive */
@media (max-width: 768px) {
    .form-container {
        width: 90%; /* Almost full width on smaller screens */
        height: auto; /* Allow height to grow with content */
    }
}

@media (max-width: 480px) {
    .form-container {
        padding: 1rem; /* Less padding on small screens */
    }
}

</style>
