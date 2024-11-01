<!-- resources/views/livewire/trajets/index.blade.php -->

<x-layouts.base>
    <x-navbars.sidebar /> <!-- Sidebar component -->

    <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth /> <!-- Navbar component -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Liste des Trajets</h1>
                    <div class="mb-4 text-end">
                        <a href="{{ route('trajets.create') }}" class="btn btn-primary">Créer un nouveau trajet</a>
                    </div>

                    <!-- Trajets Table -->
                    <div class="table-responsive">
                        <table id="trajetsTable" class="table table-striped table-bordered align-items-center">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Titre du Trajet</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Camion</th>
                                    <th scope="col">Date de Début</th>
                                    <th scope="col">Date de Fin</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trajets as $trajet)
                                    <tr>
                                        <td>{{ $trajet->titre }}</td>
                                        <td>{{ $trajet->prix }} MAD</td>
                                        <td>{{ $trajet->client->nom }}</td>
                                        <td>{{ $trajet->camion->matricule }}</td>
                                        <td>{{ $trajet->date_depart }}</td>
                                        <td>{{ $trajet->date_arrivee }}</td>
                                        <td>{{ $trajet->statut }}</td>
                                        <td>
                                            <a href="{{ route('trajets.show', $trajet->id) }}" class="btn btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('trajets.edit', $trajet->id) }}" class="btn btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('trajets.destroy', $trajet->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet?')" title="Supprimer">
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
                $('#trajetsTable').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/French.json' // French translation for DataTables
                    }
                });
            });
        </script>
    @endsection
</x-layouts.base>
