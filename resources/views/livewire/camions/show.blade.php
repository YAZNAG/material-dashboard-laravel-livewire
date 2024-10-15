<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Détails du Camion</h1>

                    <div class="row">
                        <!-- Left Section: Image Gallery -->
                        <div class="col-md-6">
                            <div class="main-image mb-3" style="height: 80%;">
                                @if ($camion->images->isNotEmpty())
                                    <img id="mainImage" src="{{ asset('storage/' . $camion->images->first()->image_path) }}"
                                        class="img-fluid w-100" alt="{{ $camion->matricule }}" style="height: 100%; object-fit: cover;">
                                @else
                                    <p>Aucune image disponible pour ce camion.</p>
                                @endif
                            </div>

                            <div class="row">
                                @foreach ($camion->images as $image)
                                    <div class="col-3 mb-2">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail small-image"
                                                style="cursor: pointer; height: 100px; object-fit: cover;"
                                                onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')"
                                                alt="{{ $camion->matricule }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Right Section: Truck Information -->
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end mb-4">
                                <a href="{{ route('camions.index') }}" class="btn btn-secondary me-2">Retour à la liste</a>
                                <a class="btn btn-primary" href="{{ route('camions.edit', ['camion' => $camion->id]) }}">Modifier</a>
                            </div>
                            <h2>{{ $camion->camion_title }}</h2>
                            <p><strong>Matricule:</strong> {{ $camion->matricule }}</p>
                            <p><strong>Date d'Immatriculation:</strong> {{ $camion->date_imma }}</p>
                            <p><strong>Date de Maintenance:</strong> {{ $camion->date_mec }}</p>
                            <p><strong>Genre:</strong> {{ $camion->genre }}</p>
                            <p><strong>Marque:</strong> {{ $camion->marque }}</p>
                            <p><strong>Type de Carburant:</strong> {{ $camion->type_carburant }}</p>
                            <p><strong>Numéro de Châssis:</strong> {{ $camion->numero_chassais }}</p>
                            <p><strong>Nombre de Cylindres:</strong> {{ $camion->nombre_cylindres }}</p>
                            <p><strong>PTAC:</strong> {{ $camion->PTAC}}</p>
                            <p><strong>Poids Vide:</strong> {{ $camion->poids_vide }}</p>
                            <p><strong>Type d'Usage:</strong> {{ $camion->type_usage }}</p>


                        </div>
                    </div>

                    <!-- Data Section: Assurances, Taxes, etc. -->
                    <div class="container-fluid py-4">
                        <h1 class="text-center mb-4">Documents des Camions</h1>

                        <!-- Data Section: Assurances, Taxes, etc. -->
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Données Associées</h4>
                                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#assurances" role="tab">Les Assurances</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#taxes" role="tab">Taxes Automobiles Annuelles (T.A.A)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#visites" role="tab">Les Visites</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#cartes-grises" role="tab">Les cartes grises</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#cartAutorisation" role="tab">Les Cartes d'autorisation</a>
                                            </li>
                                        </ul>

                                        <!-- Tab Contents -->
                                        <div class="tab-content p-3">
                                            <!-- Assurances -->
                                            <div class="tab-pane active" id="assurances" role="tabpanel">
                                                <div class="table-responsive mb-4">
                                                    <table class="table table-striped table-bordered align-items-center">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col">Numéro d'ordre</th>
                                                                <th scope="col">Numéro de Police</th>
                                                                <th scope="col">Montant</th>
                                                                <th scope="col">Date Début</th>
                                                                <th scope="col">Date Fin</th>
                                                                <th scope="col">Entreprise d'assurance</th>
                                                                <th scope="col">Intermédiaire</th>
                                                                <th scope="col">Image</th>
                                                                <th scope="col">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($camion->assurances as $assurance) <!-- Affichage des assurances liées à ce camion -->
                                                                <tr>
                                                                    <td>{{ $assurance->numero_ordre }}</td>
                                                                    <td>{{ $assurance->numero_police }}</td>
                                                                    <td>{{ $assurance->montant }}</td>
                                                                    <td>{{ $assurance->date_debut }}</td>
                                                                    <td>{{ $assurance->date_fin }}</td>
                                                                    <td>{{ $assurance->entreprise_assurence }}</td>
                                                                    <td>{{ $assurance->intermediaire }}</td>
                                                           <td>
                                                                                                                                                                                            @if ($assurance->assurence_image)
                                                                                                                                                                                            <a href="{{ Storage::url($assurance->assurence_image) }}" download class="btn btn-success">Télécharger</a>
                                                                                                                                                                                            @endif
                                                                                                                                                                                        </td>
                                                                    <td>
                                                                        <a href="{{ route('assurances.edit', $assurance->id) }}" class="btn btn-warning">
                                                                            <i class="material-icons">edit</i>
                                                                        </a>
                                                                        <form action="{{ route('assurances.destroy', $assurance->id) }}" method="POST" style="display: inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette assurance?')">
                                                                                <i class="material-icons">delete</i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Taxes -->
                                            <div class="tab-pane" id="taxes" role="tabpanel">
                                              <table class="table">
                                                  <thead>
                                                      <tr>
                                                          <th>Année</th>
                                                          <th>Tranche</th>
                                                          <th>Montant Principal</th>
                                                          <th>Pénalité</th>
                                                          <th>Majoration</th>
                                                          <th>Montant Total</th>
                                                          <th>Date de Paiement</th>
                                                          <th>Image</th>
                                                          <th>Actions</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      @foreach ($camion->taxesSpecialeAnnuelles as $taxe)
                                                      <tr>
                                                          <td>{{ $taxe->annee }}</td>
                                                          <td>{{ $taxe->trache }}</td>
                                                          <td>{{ $taxe->montant_principal }}</td>
                                                          <td>{{ $taxe->penalite }}</td>
                                                          <td>{{ $taxe->majorations }}</td>
                                                          <td>{{ $taxe->montant_total }}</td>
                                                          <td>{{ $taxe->date_paiement }}</td>
                                                          <td>
                                                              @if ($taxe->taxe_image)
                                                              <a href="{{ Storage::url($taxe->taxe_image) }}" download class="btn btn-success">Télécharger</a>
                                                              @endif
                                                          </td>
                                                       <td>
                                                                                                                              <a href="{{ route('taxes.edit', $taxe->id) }}" class="btn btn-warning">
                                                                                                                                  <i class="material-icons">edit</i>
                                                                                                                              </a>
                                                                                                                              <form action="{{ route('taxes.destroy', $taxe->id) }}" method="POST" style="display: inline">
                                                                                                                                  @csrf
                                                                                                                                  @method('DELETE')
                                                                                                                                  <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette assurance?')">
                                                                                                                                      <i class="material-icons">delete</i>
                                                                                                                                  </button>
                                                                                                                              </form>
                                                                                                                          </td>
                                                      </tr>
                                                      @endforeach
                                                  </tbody>
                                              </table>
                                            </div>

                                            <!-- Visites -->
                                            <div class="tab-pane" id="visites" role="tabpanel">
                                                <div class="table-responsive mb-4">
                                                    <table class="table table-striped table-bordered align-items-center">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col">Type de Visite</th>
                                                                <th scope="col">Date Début</th>
                                                                <th scope="col">Date Fin</th>
                                                                <th scope="col">Numéro d'autorisation</th>
                                                                <th scope="col">Nom du Centre</th>
                                                                <th scope="col">Adresse du Centre</th>
                                                                <th scope="col">Résultat</th>
                                                                <th scope="col">Image</th>
                                                                <th scope="col">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($camion->visites as $visite) <!-- Affichage des visites liées à ce camion -->
                                                                <tr>
                                                                    <td>{{ $visite->type }}</td>
                                                                    <td>{{ $visite->date_debut }}</td>
                                                                    <td>{{ $visite->date_fin }}</td>
                                                                    <td>{{ $visite->numero_autorisation }}</td>
                                                                    <td>{{ $visite->nom_centre }}</td>
                                                                    <td>{{ $visite->address_centre }}</td>
                                                                    <td>{{ $visite->resultat }}</td>
                                                                    <td>
                                                                        @if ($visite->visite_image)
                                                                            <a href="{{ Storage::url($visite->visite_image) }}" download class="btn btn-success">
                                                                                <i class="material-icons">download</i> Télécharger
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('visites.edit', $visite->id) }}" class="btn btn-warning">
                                                                            <i class="material-icons">edit</i>
                                                                        </a>
                                                                        <form action="{{ route('visites.destroy', $visite->id) }}" method="POST" style="display: inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette visite?')">
                                                                                <i class="material-icons">delete</i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


<!-- Cartes Grises -->
<div class="tab-pane" id="cartes-grises" role="tabpanel">
    <div class="table-responsive mb-4">
        <table class="table table-striped table-bordered align-items-center">
            <thead class="table-light">
                <tr>

                    <th scope="col">Date de Fin</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($camion->cartGrises ?? [] as $carteGrise) <!-- Affichage des cartes grises liées à ce camion -->
                    <tr>

                        <td>{{ $carteGrise->date_fin }}</td>
                        <td>
                            @if ($carteGrise->image_path)
                                <a href="{{ Storage::url($carteGrise->image_path) }}" download class="btn btn-success">
                                    <i class="material-icons">download</i> Télécharger
                                </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('cartesgrise.edit', $carteGrise->id) }}" class="btn btn-warning">
                                <i class="material-icons">edit</i>
                            </a>
                            <form action="{{ route('cartesgrise.destroy', $carteGrise->id) }}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette carte grise?')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
 <!-- Cartes d'Autorisation -->
 <div class="tab-pane" id="cartAutorisation" role="tabpanel">
     <div class="table-responsive mb-4">
         <table class="table table-striped table-bordered align-items-center">
             <thead class="table-light">
                 <tr>
                     <th scope="col">Numéro d'Autorisation</th>

                     <th scope="col">Date d'Obtention</th>
                     <th scope="col">Date d'Expiration</th>
                     <th scope="col">Image</th>
                     <th scope="col">Actions</th>
                 </tr>
             </thead>
             <tbody>
                @foreach ($camion->cartAutorisations as $cartAutorisation)
                    <tr>
                        <td>{{ $cartAutorisation->numero_inscription }}</td>

                        <td>{{ $cartAutorisation->date_debut }}</td>
                        <td>{{ $cartAutorisation->date_fin }}</td>
                        <td>
                            @if ($cartAutorisation->image_path)
                                <a href="{{ Storage::url($cartAutorisation->image_path) }}" download class="btn btn-success">
                                    <i class="material-icons">download</i> Télécharger
                                </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('cartesautorisation.edit', $cartAutorisation->id) }}" class="btn btn-warning">
                                <i class="material-icons">edit</i>
                            </a>
                            <form action="{{ route('cartesautorisation.destroy', $cartAutorisation->id) }}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette carte d\'autorisation?')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

             </tbody>
         </table>
     </div>
 </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Include necessary plugins -->

    @section('scripts')
        <script>
            // Image switcher functionality
            function changeImage(newSrc) {
                document.getElementById('mainImage').src = newSrc;
            }

            // Initialize DataTable
            $(document).ready(function() {
                $('#camionsTable').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.5/dataTables.french.json'
                    }
                });
            });
        </script>
    @endsection
</x-layouts.base>
