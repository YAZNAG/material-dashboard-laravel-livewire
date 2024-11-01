<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Créer un nouveau trajet</h1>

                    <!-- Affichage des erreurs -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Affichage du message spécifique pour le vidange -->
                    @if (session('errors') && session('errors')->has('message'))
                        <div class="alert alert-warning">
                            {{ session('errors')->first('message') }}
                        </div>
                    @endif

                    <!-- Formulaire de création -->
                    <form action="{{ route('trajets.store') }}" method="POST">
                        @csrf

                        <!-- Titre du trajet -->
                        <div class="form-group mb-3">
                            <label for="titre">Titre</label>
                            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre') }}" required>
                        </div>

                        <!-- Prix du trajet -->
                        <div class="form-group mb-3">
                            <label for="prix">Prix</label>
                            <input type="number" name="prix" id="prix" class="form-control" value="{{ old('prix') }}" required>
                        </div>

                        <!-- Kilométrage -->
                        <div class="form-group mb-3">
                            <label for="kilometrage">Kilométrage</label>
                            <input type="number" name="kilometrage" id="kilometrage" class="form-control" value="{{ old('kilometrage') }}" required>
                        </div>

                        <!-- Camion -->
                        <div class="form-group mb-3">
                            <label for="camion_id">Camion</label>
                            <select name="camion_id" id="camion_id" class="form-control" required>
                                <option value="">Sélectionnez un camion</option>
                                @foreach($camions as $camion)
                                    <option value="{{ $camion->id }}" {{ old('camion_id') == $camion->id ? 'selected' : '' }}>
                                        {{ $camion->matricule }} (Kilométrage: {{ $camion->totalKilometrage }} km)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Chauffeur -->
                        <div class="form-group mb-3">
                            <label for="chauffeur_id">Chauffeur</label>
                            <select name="chauffeur_id" id="chauffeur_id" class="form-control" required>
                                <option value="">Sélectionnez un chauffeur</option>
                                @foreach($chauffeurs as $chauffeur)
                                    <option value="{{ $chauffeur->id }}" {{ old('chauffeur_id') == $chauffeur->id ? 'selected' : '' }}>
                                        {{ $chauffeur->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Client -->
                        <div class="form-group mb-3">
                            <label for="client_id">Client</label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="">Sélectionnez un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date de départ -->
                        <div class="form-group mb-3">
                            <label for="date_depart">Date de départ</label>
                            <input type="date" name="date_depart" id="date_depart" class="form-control" value="{{ old('date_depart') }}" required>
                        </div>

                         <!-- Date d'arrivée -->
                         <div class="form-group mb-3">
                              <label for="date_arrivee">Date d'arrivée</label>
                              <input type="date" name="date_arrivee" id="date_arrivee" class="form-control" value="{{ old('date_arrivee') }}" required>
                         </div>

                        <!-- Lieu de départ -->
                        <div class="form-group mb-3">
                            <label for="lieu_depart">Lieu de départ</label>
                            <input type="text" name="lieu_depart" id="lieu_depart" class="form-control" value="{{ old('lieu_depart') }}" required>
                        </div>

                        <!-- Lieu d'arrivée -->
                        <div class="form-group mb-3">
                            <label for="lieu_arrivee">Lieu d'arrivée</label>
                            <input type="text" name="lieu_arrivee" id="lieu_arrivee" class="form-control" value="{{ old('lieu_arrivee') }}" required>
                        </div>

                        <!-- Statut -->
                        <div class="form-group mb-3">
                            <label for="statut">Statut</label>
                            <select name="statut" id="statut" class="form-control" required>
                                <option value="en cours" {{ old('statut') == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminé" {{ old('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                                <option value="annulé" {{ old('statut') == 'annulé' ? 'selected' : '' }}>Annulé</option>
                            </select>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary">Créer le trajet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Plugins inclus si nécessaire -->

</x-layouts.base>
