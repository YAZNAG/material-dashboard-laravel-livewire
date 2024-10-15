<!-- resources/views/chauffeurs/index.blade.php -->
<x-layouts.base>
    <x-navbars.sidebar />

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth />

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Liste des Chauffeurs</h1>

                    <div class="mb-4 text-end">
                        <a href="{{ route('chauffeurs.create') }}" class="btn btn-primary">Ajouter un Chauffeur</a>
                    </div>

                    <div class="table-responsive">
                        <table id="chauffeursTable" class="table table-striped table-bordered align-items-center">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">CIN</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chauffeurs as $chauffeur)
                                    <tr>
                                        <td>{{ $chauffeur->nom }}</td>
                                        <td>{{ $chauffeur->prenom }}</td>
                                        <td>{{ $chauffeur->cin }}</td>
                                        <td>{{ $chauffeur->telephone }}</td>
                                        <td>
                                            <a href="{{ route('chauffeurs.show', $chauffeur->id) }}" class="btn btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('chauffeurs.edit', $chauffeur->id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                              <form action="{{ route('chauffeurs.destroy', $chauffeur->id) }}" method="POST" style="display:inline;">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce chauffeur?')" title="Supprimer">
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
            </div>
        </div>

        <x-footers.auth />
    </div>

    <x-plugins />
</x-layouts.base>
