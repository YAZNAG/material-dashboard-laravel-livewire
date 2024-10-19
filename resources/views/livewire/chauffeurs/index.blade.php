<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Liste des Chauffeurs</h1>
                    <div class="mb-4 text-end">

                        <a href="{{ route('chauffeurs.create') }}" class="btn btn-primary">Ajouter un Chauffeur</a>
                    </div>

                    <!-- Chauffeurs Table -->
                    <div class="table-responsive">
                        <table id="chauffeursTable" class="table table-striped table-bordered align-items-center">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">CIN</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Action</th>
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
                                            <a href="{{ route('chauffeurs.edit', $chauffeur->id) }}" class="btn btn-warning" title="Modifier">
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

        <x-footers.auth /> <!-- Footer component -->
    </div>

    <x-plugins /> <!-- Include any necessary plugins -->

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#chauffeursTable').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.5/dataTables.french.json' // Include French language support
                    }
                });
            });
        </script>
    @endsection
</x-layouts.base>
