<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Modifier un Client</h1>

                    <!-- Formulaire de modification de client -->
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Méthode PUT pour la mise à jour -->

                                <!-- Sélection du type de client -->
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type de Client</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="personne" {{ $client->type == 'personne' ? 'selected' : '' }}>Personne</option>
                                        <option value="societe" {{ $client->type == 'societe' ? 'selected' : '' }}>Société</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Champ Nom -->
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $client->nom) }}" required>
                                    @error('nom')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <!-- Champ Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $client->email) }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Champ Téléphone -->
                                <div class="mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $client->telephone) }}" required>
                                    @error('telephone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Champ Adresse -->
                                <div class="mb-3">
                                    <label for="adresse" class="form-label">Adresse</label>
                                    <textarea class="form-control" id="adresse" name="adresse" rows="3" required>{{ old('adresse', $client->adresse) }}</textarea>
                                    @error('adresse')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Bouton de soumission -->
                                <div class="text-end">
                                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Annuler</a>
                                    <button type="submit" class="btn btn-primary">Mettre à jour le Client</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Include any necessary plugins -->

    @section('scripts')
        <script>
            // Masquer le champ "Prénom" si le type de client est "société"
            document.getElementById('type').addEventListener('change', function () {
                const type = this.value;
                const prenomField = document.getElementById('prenomField');
                if (type === 'societe') {
                    prenomField.style.display = 'none';
                } else {
                    prenomField.style.display = 'block';
                }
            });
        </script>
    @endsection
</x-layouts.base>
