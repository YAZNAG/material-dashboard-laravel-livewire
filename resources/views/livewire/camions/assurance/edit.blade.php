<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <h1 class="text-center mb-4">Éditer l'Assurance</h1>

            <div class="row">
                <div class="col-12">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form action="{{ route('assurances.update', $assurance->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
<div class="mb-3">
    <label for="numero_ordre" class="form-label">Numéro d'Ordre</label>
    <input type="number" class="form-control @error('numero_ordre') is-invalid @enderror" id="numero_ordre" name="numero_ordre" value="{{ old('numero_ordre', $assurance->numero_ordre) }}" required>
    @error('numero_ordre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                        <div class="mb-3">
                            <label for="numero_police" class="form-label">Numéro de Police</label>
                            <input type="text" class="form-control @error('numero_police') is-invalid @enderror" id="numero_police" name="numero_police" value="{{ old('numero_police', $assurance->numero_police) }}" required>
                            @error('numero_police')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="montant" class="form-label">Montant</label>
                            <input type="number" class="form-control @error('montant') is-invalid @enderror" id="montant" name="montant" value="{{ old('montant', $assurance->montant) }}" required>
                            @error('montant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de Début</label>
                            <input type="date" class="form-control @error('date_debut') is-invalid @enderror" id="date_debut" name="date_debut" value="{{ old('date_debut', $assurance->date_debut) }}" required>
                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de Fin</label>
                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" name="date_fin" value="{{ old('date_fin', $assurance->date_fin) }}" required>
                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="entreprise_assurence" class="form-label">Entreprise d'Assurance</label>
                            <input type="text" class="form-control @error('entreprise_assurence') is-invalid @enderror" id="entreprise_assurence" name="entreprise_assurence" value="{{ old('entreprise_assurence', $assurance->entreprise_assurence) }}" required>
                            @error('entreprise_assurence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="intermediaire" class="form-label">Intermédiaire</label>
                            <input type="text" class="form-control @error('intermediaire') is-invalid @enderror" id="intermediaire" name="intermediaire" value="{{ old('intermediaire', $assurance->intermediaire) }}" required>
                            @error('intermediaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="assurence_image" class="form-label">Image de l'Assurance</label>
                            <input type="file" class="form-control @error('assurence_image') is-invalid @enderror" id="assurence_image" name="assurence_image">
                            @error('assurence_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($assurance->assurence_image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $assurance->assurence_image) }}" alt="Image d'Assurance" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                        <a href="{{ route('assurances.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Include any necessary plugins -->
</x-layouts.base>
