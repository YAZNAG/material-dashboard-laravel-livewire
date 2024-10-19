<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ContratsClients;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Afficher la liste des clients
    public function index()
    {
        $clients = Client::with('contrats')->get(); // Charger les clients avec leurs contrats
        return view('livewire.clients.index', compact('clients'));
    }

    // Afficher le formulaire de création d'un client
    public function create()
    {
        return view('livewire.clients.create');
    }

    // Enregistrer un nouveau client
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email',
            'telephone' => 'required|string|max:50',
            'adresse' => 'required|string',
            'type' => 'required|in:personne,societe', // Assurez-vous que 'person' est remplacé par 'personne'
            // Ajoutez d'autres validations selon vos besoins
        ]);

        $client = Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }

    // Afficher le formulaire d'édition d'un client
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('livewire.clients.edit', compact('client'));
    }

    // Mettre à jour un client
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email,' . $id,
            'telephone' => 'required|string|max:50',
            'adresse' => 'required|string',
            'type' => 'required|in:personne,societe', // Assurez-vous que 'person' est remplacé par 'personne'
            // Ajoutez d'autres validations selon vos besoins
        ]);

        $client = Client::findOrFail($id);
        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    // Supprimer un client
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }

    // Stocker un contrat pour un client
    public function storeContratClient(Request $request, $clientId)
    {
        $request->validate([
            'contrat_id' => 'required|exists:contrats,id',
            // Ajoutez d'autres validations selon vos besoins
        ]);

        $contratsClients = new ContratsClients();
        $contratsClients->client_id = $clientId;
        $contratsClients->contrat_id = $request->contrat_id;
        $contratsClients->save();

        return redirect()->route('clients.show', $clientId)->with('success', 'Contrat associé au client avec succès.');
    }

    // Mettre à jour un contrat associé à un client
    public function updateContratsClient(Request $request, $clientId, $contratId)
    {
        $request->validate([
            'contrat_id' => 'required|exists:contrats,id',
            // Ajoutez d'autres validations selon vos besoins
        ]);

        $contratsClient = ContratsClients::where('client_id', $clientId)->where('contrat_id', $contratId)->firstOrFail();
        $contratsClient->contrat_id = $request->contrat_id; // Mettre à jour les détails si nécessaire
        $contratsClient->save();

        return redirect()->route('clients.show', $clientId)->with('success', 'Contrat mis à jour avec succès.');
    }

    // Supprimer un contrat associé à un client
    public function destroyContratClient($clientId, $contratId)
    {
        $contratsClient = ContratsClients::where('client_id', $clientId)->where('contrat_id', $contratId)->firstOrFail();
        $contratsClient->delete();

        return redirect()->route('clients.show', $clientId)->with('success', 'Contrat supprimé avec succès.');
    }
}
