
<x-layouts.base>
  <x-navbars.sidebar />

  <div
    class="main-content position-relative max-height-vh-100 h-100 border-radius-lg"
  >
    <x-navbars.navs.auth />

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
                  <a
                    class="nav-link active"
                    data-bs-toggle="tab"
                    href="#assurances"
                    role="tab"
                  >
                    Les Assurances
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    data-bs-toggle="tab"
                    href="#taxes"
                    role="tab"
                  >
                    Taxes Automobiles Annuelles (T.A.A)
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    data-bs-toggle="tab"
                    href="#visites"
                    role="tab"
                  >
                    Les Visites
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    data-bs-toggle="tab"
                    href="#CartesGrise"
                    role="tab"
                  >
                    Les cartes grises
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    data-bs-toggle="tab"
                    href="#cartAutorisation"
                    role="tab"
                  >
                    Les Cartes d'autorisation
                  </a>
                </li>
              </ul>

              <!-- Tab Contents -->
              <div class="tab-content p-3">
                <!-- Assurances -->
                <div class="tab-pane active" id="assurances" role="tabpanel">
                  <div class="mb-4 text-end">
                    <a
                      href="{{ route('assurances.create') }}"
                      class="btn btn-primary mb-3"
                    >
                      <i class="material-icons">add</i> Ajouter
                    </a>
                  </div>
                  <div class="table-responsive mb-4">
                    <table
                      class="table table-striped table-bordered align-items-center"
                    >
                      <thead class="table-light">
                        <tr>
                          <th scope="col">Matricule</th>
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
                        @foreach ($assurances as $assurance)
                        <tr>
                          <td>{{ $assurance->camion->matricule }}</td>
                          <td>{{ $assurance->numero_ordre }}</td>
                          <td>{{ $assurance->numero_police }}</td>
                          <td>{{ $assurance->montant }}</td>
                          <td>{{ $assurance->date_debut }}</td>
                          <td>{{ $assurance->date_fin }}</td>
                          <td>{{ $assurance->entreprise_assurence}}</td>
                          <td>{{ $assurance->intermediaire }}</td>
                          <td>
                            @if ($assurance->assurence_image)
                            <a
                              href="{{ Storage::url($assurance->assurance_image) }}"
                              download
                              class="btn btn-success"
                            >
                              <i class="material-icons">download</i> Télécharger
                            </a>
                            @endif
                          </td>
                          <td>
                            <a
                              href="{{ route('assurances.edit', $assurance->id) }}"
                              class="btn btn-warning"
                            >
                              <i class="material-icons">edit</i>
                            </a>
                            <form
                              action="{{ route('assurances.destroy', $assurance->id) }}"
                              method="POST"
                              style="display: inline"
                            >
                              @csrf @method('DELETE')
                              <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette assurance?')"
                              >
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
                  <div class="mb-4 text-end">
                    <a
                      href="{{ route('taxes.create') }}"
                      class="btn btn-primary mb-3"
                    >
                      <i class="material-icons">add</i> Ajouter
                    </a>
                  </div>
                  <div class="table-responsive mb-4">
                    <table
                      class="table table-striped table-bordered align-items-center"
                    >
                      <thead class="table-light">
                        <tr>
                          <th scope="col">Matricule</th>
                          <th scope="col">Année</th>
                          <th scope="col">Tranche</th>
                          <th scope="col">Montant Principal</th>
                          <th scope="col">Pénalité</th>
                          <th scope="col">Majorations</th>
                          <th scope="col">Montant total</th>
                          <th scope="col">Date paiement</th>
                          <th scope="col">Image</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($taxes as $taxe)
                        <tr>
                          <td>{{ $taxe->camion->matricule }}</td>
                          <td>{{ $taxe->annee }}</td>
                          <td>{{ $taxe->trache}}</td>
                          <td>{{ $taxe->montant_principal }}</td>
                          <td>{{ $taxe->penalite }}</td>
                          <td>{{ $taxe->majorations }}</td>
                          <td>{{ $taxe->montant_total }}</td>
                          <td>{{ $taxe->date_paiement }}</td>
                          <td>
                            @if ($taxe->taxe_image)
                            <a
                              href="{{ Storage::url($taxe->taxe_image) }}"
                              download
                              class="btn btn-success"
                            >
                              <i class="material-icons">download</i> Télécharger
                            </a>
                            @endif
                          </td>
                          <td>
                            <a
                              href="{{ route('taxes.edit', $taxe->id) }}"
                              class="btn btn-warning"
                            >
                              <i class="material-icons">edit</i>
                            </a>
                            <form
                              action="{{ route('taxes.destroy', $taxe->id) }}"
                              method="POST"
                              style="display: inline"
                            >
                              @csrf @method('DELETE')
                              <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette taxe?')"
                              >
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

                <!-- Visites -->
                <div class="tab-pane" id="visites" role="tabpanel">
                  <div class="mb-4 text-end">
                    <a
                      href="{{ route('visites.create') }}"
                      class="btn btn-primary mb-3"
                    >
                      <i class="material-icons">add</i> Ajouter
                    </a>
                  </div>
                  <div class="table-responsive mb-4">
                    <table
                      class="table table-striped table-bordered align-items-center"
                    >
                      <thead class="table-light">
                        <tr>
                          <th scope="col">Matricule</th>
                          <th scope="col">Type De contrôle</th>
                          <th scope="col">Numéro autorisation</th>
                          <th scope="col">Nom du centre</th>
                          <th scope="col">Adresse du centre</th>
                          <th scope="col">Date du contrôle</th>
                          <th scope="col">Date Fin</th>
                          <th scope="col">Résultat</th>
                          <th scope="col">Image</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($visitesTechnique as $visite)
                        <tr>
                          <td>{{ $visite->camion->matricule }}</td>
                          <td>{{ $visite->type }}</td>
                          <td>{{ $visite->numero_autorisation }}</td>
                          <td>{{ $visite->nom_centre }}</td>
                          <td>{{ $visite->address_centre }}</td>
                          <td>{{ $visite->date_debut }}</td>
                          <td>{{ $visite->date_fin }}</td>
                          <td>{{ $visite->resultat }}</td>
                          <td>
                            @if ($visite->visite_image)
                            <a
                              href="{{ asset('storage/images/camions/visites/' . basename($visite->visite_image)) }}"
                              download
                              class="btn btn-success"
                              >Télécharger</a
                            >
                            @endif
                          </td>
                          <td>
                            <a
                              href="{{ route('visites.edit', $visite->id) }}"
                              class="btn btn-warning"
                            >
                              <i class="material-icons">edit</i>
                              <!-- Icon for Edit -->
                            </a>
                            <form
                              action="{{ route('visites.destroy', $visite->id) }}"
                              method="POST"
                              style="display: inline"
                            >
                              @csrf @method('DELETE')
                              <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette visite technique?')"
                              >
                                <i class="material-icons">delete</i>
                                <!-- Icon for Delete -->
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
                <div class="tab-pane" id="CartesGrise" role="tabpanel">
                  <div class="mb-4 text-end">
                    <a
                      href="{{ route('cartesgrise.create') }}"
                      class="btn btn-primary mb-3"
                    >
                      <i class="material-icons">add</i> Ajouter
                    </a>
                  </div>
                  <div class="table-responsive mb-4">
                    <table
                      class="table table-striped table-bordered align-items-center"
                    >
                      <thead class="table-light">
                        <tr>
                          <th scope="col">Matricule</th>

                          <th scope="col">Date Fin</th>
                          <th scope="col">Image</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($cartesGrise as $carte)
                        <tr>
                          <td>{{ $carte->camion->matricule }}</td>

                          <td>{{ $carte->date_fin }}</td>
                          <td>
                            @if ($carte->image_path)
                            <a
                              href="{{ asset('storage/' . $carte->image_path) }}"
                              download
                              class="btn btn-success"
                              >Télécharger</a
                            >
                            @endif
                          </td>

                          <td>
                            <a
                              href="{{ route('cartesgrise.edit', $carte->id) }}"
                              class="btn btn-warning"
                            >
                              <i class="material-icons">edit</i>
                              <!-- Icon for Edit -->
                            </a>
                            <form
                              action="{{ route('cartesgrise.destroy', $carte->id) }}"
                              method="POST"
                              style="display: inline"
                            >
                              @csrf @method('DELETE')
                              <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette carte grise?')"
                              >
                                <i class="material-icons">delete</i>
                                <!-- Icon for Delete -->
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
                  <div class="mb-4 text-end">
                    <a
                      href="{{ route('cartesautorisation.create') }}"
                      class="btn btn-primary mb-3"
                    >
                      <i class="material-icons">add</i> Ajouter
                    </a>
                  </div>
                  <div class="table-responsive mb-4">
                    <table
                      class="table table-striped table-bordered align-items-center"
                    >
                      <thead class="table-light">
                        <tr>
                          <th scope="col">Matricule</th>
                          <th scope="col">Date Début</th>
                          <th scope="col">Date Fin</th>
                          <th scope="col">Image</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($cartesAutorisation as $autorisation)
                        <tr>
                          <td>{{ $autorisation->camion->matricule }}</td>

                          <td>{{ $autorisation->date_debut }}</td>
                          <td>{{ $autorisation->date_fin }}</td>
                          <td>
                            @if ($autorisation->image_path)
                            <a
                              href="{{ asset('storage/' . $autorisation->image_path) }}"
                              download
                              class="btn btn-success"
                              >Télécharger</a
                            >
                            @endif
                          </td>

                          <td>
                            <a
                              href="{{ route('cartesautorisation.edit', $autorisation->id) }}"
                              class="btn btn-warning"
                            >
                              <i class="material-icons">edit</i>
                              <!-- Icon for Edit -->
                            </a>
                            <form
                              action="{{ route('cartesautorisation.destroy', $autorisation->id) }}"
                              method="POST"
                              style="display: inline"
                            >
                              @csrf @method('DELETE')
                              <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette carte d\'autorisation?')"
                              >
                                <i class="material-icons">delete</i>
                                <!-- Icon for Delete -->
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

    <x-footers.auth />
  </div>

  <x-plugins />
</x-layouts.base>
