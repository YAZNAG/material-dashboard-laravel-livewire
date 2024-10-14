<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Liste des Camions</h1>

                    <!-- Buttons for adding new items -->
                    <div class="mb-4 text-end">
                        <a href="{{ route('camions.create') }}" class="btn btn-primary">Ajouter un Camion</a>

                    </div>

                    <!-- Camions Table -->
                    <div class="table-responsive">
                        <table id="camionsTable" class="table table-striped table-bordered align-items-center">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Matricule</th>
                                    <th scope="col">Genre</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Marque</th>
                                    <th scope="col">Type Carburant</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($camions as $camion)
                                    <tr>
                                        <td>{{ $camion->camion_title }}</td>
                                        <td>{{ $camion->matricule }}</td>
                                        <td>{{ $camion->genre }}</td>
                                        <td>{{ $camion->type }}</td>
                                        <td>{{ $camion->marque }}</td>
                                        <td>{{ $camion->type_carburant }}</td>
                                        <td>
                                            <!-- View, Edit, Delete actions -->
                                            <a href="{{ route('camions.show', $camion->id) }}" class="btn btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('camions.edit', $camion->id) }}" class="btn btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('camions.destroy', $camion->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce camion?')" title="Supprimer">
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
                $('#camionsTable').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.5/dataTables.french.json' // Include French language support
                    }
                });
            });
        </script>
    @endsection
</x-layouts.base>
