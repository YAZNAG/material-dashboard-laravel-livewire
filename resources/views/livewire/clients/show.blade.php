<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Détails du Client</h1>

                    <div class="card">
                        <div class="card-body">
                            <!-- Détails du client -->
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Nom :</strong> {{ $client->nom }}</li>
                                <li class="list-group-item"><strong>Type :</strong> {{ $client->type }}</li>
                                <li class="list-group-item"><strong>Email :</strong> {{ $client->email }}</li>
                                <li class="list-group-item"><strong>Téléphone :</strong> {{ $client->telephone }}</li>
                                <li class="list-group-item"><strong>Adresse :</strong> {{ $client->adresse }}</li>
                                @if($client->contrat)
                                    <li class="list-group-item"><strong>Contrat associé :</strong> {{ $client->contrat->nom_contrat }}</li>
                                @endif
                            </ul>
                            <!-- Boutons d'action -->
                            <div class="mt-4 text-end">
                                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Retour à la liste</a>
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Modifier</a>
                            </div>
                        </div>
                    </div>

                </div>
            <!-- Section pour les Contrats et Permis -->
                            <div class="row mt-5">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Section des données</h4>

                                            <!-- Boutons pour créer  Contrat -->
                                            <div class="mb-4 text-end">

                                                <button class="btn btn-secondary" onclick="toggleDiv('createContractclient')">Créer un Contrat</button>
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

                                            </ul>

                                            <div class="tab-content">
                                                <!-- Table des Contrats -->
                                                <div class="tab-pane active p-3" id="contracts" role="tabpanel">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Date de Début</th>
                                                                <th scope="col">Date de Fin</th>
                                                                <th scope="col">Document</th>
                                                                <th scope="col">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($client->contratsClients as $contrat) <!-- Afficher les contrats associés au client -->
                                                                <tr>
                                                                    <td>{{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/Y') }}</td>
                                                                    <td>
                                                                        @if($contrat->contrat_pdf)
                                                                            <a href="{{ Storage::url($contrat->contrat_pdf) }}" target="_blank" class="btn btn-link">Voir le Document</a>
                                                                        @else
                                                                            Aucun document
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                    <button class="btn btn-secondary" onclick="toggleDiv('editContractclient')"><i class="fas fa-edit"></i></button>


                                                                        <form action="{{ route('clients.deleteContratsClients', ['clientId' => $client->id, 'contratId' => $contrat->id]) }}" method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat?')" title="Supprimer">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>


                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>



                                                <!-- Table des Trajets -->
                                                <div class="tab-pane p-3" id="trajets" role="tabpanel">
                                                    <!-- Content omitted for brevity -->
                                                </div>
                                            </div>

                                          <!-- Formulaire de création de Contrat -->
                                          <div id="createContractclient" class="form-container" style="display:none;">
                                              <span class="close-btn" onclick="toggleDiv('createContractclient')">&times;</span> <!-- Close button -->
                                              <h4>Créer un Contrat</h4>
                                              <form action="{{ route('clients.storeContratsClients', $client->id) }}" method="POST" enctype="multipart/form-data">
                                                  @csrf
                                                  <div class="mb-3">
                                                      <label for="client_id" class="form-label">Client :</label>
                                                      <input type="text" class="form-control" value="{{ $client->nom }}" readonly> <!-- Nom du client -->
                                                      <input type="hidden" name="client_id" value="{{ $client->id }}"> <!-- ID du client -->
                                                  </div>

                                                  <div class="mb-3">
                                                      <label for="date_debut" class="form-label">Date de Début :</label>
                                                      <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                                                      @error('date_debut')
                                                          <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                  </div>

                                                  <div class="mb-3">
                                                      <label for="date_fin" class="form-label">Date de Fin :</label>
                                                      <input type="date" name="date_fin" id="date_fin" class="form-control" required>
                                                      @error('date_fin')
                                                          <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                  </div>

                                                  <div class="mb-3">
                                                      <label for="contrat_pdf" class="form-label">Télécharger le PDF du Contrat :</label>
                                                      <input type="file" name="contrat_pdf" id="contrat_pdf" class="form-control" accept="application/pdf">
                                                      @error('contrat_pdf')
                                                          <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                  </div>

                                                  <button type="submit" class="btn btn-primary">Ajouter le Contrat</button>
                                              </form>
                                          </div>
<!-- Formulaire de modification de Contrat -->
<div id="editContractclient" class="form-container" style="display:none;">
    <span class="close-btn" onclick="toggleDiv('editContractclient')">&times;</span> <!-- Close button -->
    <h4>Modifier le Contrat</h4>

    <!-- Vérifier s'il y a un contrat à modifier -->
    @if($contratsClient)
        <form action="{{ route('clients.updateContratsClients', [$client->id, $contratsClient->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Utilisation de la méthode PUT pour la mise à jour -->

            <div class="mb-3">
                <label for="client_id" class="form-label">Client :</label>
                <input type="text" class="form-control" value="{{ $client->nom }}" readonly> <!-- Nom du client -->
                <input type="hidden" name="client_id" value="{{ $client->id }}"> <!-- ID du client -->
            </div>

            <div class="mb-3">
                <label for="date_debut" class="form-label">Date de Début :</label>
                <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ $contratsClient->date_debut }}" required>
                @error('date_debut')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="date_fin" class="form-label">Date de Fin :</label>
                <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ $contratsClient->date_fin }}" required>
                @error('date_fin')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="contrat_pdf" class="form-label">Télécharger le PDF du Contrat :</label>
                <input type="file" name="contrat_pdf" id="contrat_pdf" class="form-control" accept="application/pdf">
                @error('contrat_pdf')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                @if($contratsClient->contrat_pdf)
                    <p>Fichier actuel: <a href="{{ asset('storage/'.$contratsClient->contrat_pdf) }}" target="_blank">Voir le contrat PDF</a></p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour le Contrat</button>
        </form>
    @else
        <p>Aucun contrat à éditer.</p>
    @endif
</div>





                                        </div>
                                    </div>
                                </div>
                            </div>
            </div>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Include any necessary plugins -->
</x-layouts.base>
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
    top: -36%;
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
