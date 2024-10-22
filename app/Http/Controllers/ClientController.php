<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ContratsClients;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Afficher la liste des clients
    public function index()
    {
        $clients = Client::all();// Charger les clients avec leurs contrats
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
            'type' => 'required|in:personne,societe',

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
      public function show($id)
      {
          // Charger le client et ses contrats
          $client = Client::with('contratsClients')->findOrFail($id);

          // Option : Sélectionner un contrat particulier (ex. : le premier contrat)
          $contratsClient = $client->contratsClients->first(); // Récupérer le premier contrat du client

          return view('livewire.clients.show', compact('client', 'contratsClient'));
      }

      public function storeContratsClients(Request $request, $clientId)
      {
          // Valider les données du formulaire
          try {
              $request->validate([
                  'date_debut' => 'required|date',
                  'date_fin' => 'required|date|after_or_equal:date_debut',
                  'contrat_pdf' => 'nullable|file|mimes:pdf|max:5000', // Validation du fichier PDF
              ]);
          } catch (\Illuminate\Validation\ValidationException $e) {
              return redirect()->back()->withErrors($e->validator)->withInput();
          }

          // Créer un nouvel enregistrement dans la table contrats_clients
          $contratsClients = new ContratsClients();
          $contratsClients->client_id = $clientId; // ID du client passé depuis la route
          $contratsClients->date_debut = $request->date_debut;
          $contratsClients->date_fin = $request->date_fin;

          // Gestion du PDF s'il est présent
          if ($request->hasFile('contrat_pdf')) {
              $contratsClients->contrat_pdf = $request->file('contrat_pdf')->store('clients/contrats', 'public');
          }

          // Sauvegarder dans la base de données
          if ($contratsClients->save()) {
              return redirect()->route('clients.show', $clientId)
                               ->with('success', 'Contrat associé au client avec succès.');
          } else {
              return redirect()->back()->with('error', 'Erreur lors de l\'ajout du contrat. Veuillez réessayer.');
          }
      }



     public function updateContratsClients(Request $request, $clientId, $contratId)
        {
            // Valider les données
            $request->validate([
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
                'contrat_pdf' => 'nullable|file|mimes:pdf|max:5000',
            ]);

            // Récupérer le contrat à modifier
            $contratClient = ContratsClients::where('client_id', $clientId)->findOrFail($contratId);

            // Mettre à jour les informations du contrat
            $contratClient->date_debut = $request->date_debut;
            $contratClient->date_fin = $request->date_fin;

            // Si un nouveau fichier PDF est téléchargé
            if ($request->hasFile('contrat_pdf')) {
                // Supprimer l'ancien fichier s'il existe
                if ($contratClient->contrat_pdf) {
                    Storage::disk('public')->delete($contratClient->contrat_pdf); // Utiliser Storage
                }
                // Enregistrer le nouveau fichier
                $contratClient->contrat_pdf = $request->file('contrat_pdf')->store('clients/contrats', 'public');
            }

            // Sauvegarder les modifications
            $contratClient->save();

            return redirect()->route('clients.show', $clientId)->with('success', 'Contrat mis à jour avec succès.');
        }

        public function deleteContratsClients($clientId, $contratId)
            {
                // Récupérer le contrat à supprimer
                $contratClient = ContratsClients::where('client_id', $clientId)->findOrFail($contratId);

                // Vérifier si un fichier PDF est associé et le supprimer
                if ($contratClient->contrat_pdf) {
                    Storage::disk('public')->delete($contratClient->contrat_pdf); // Supprimer le fichier PDF
                }

                // Supprimer l'enregistrement du contrat
                $contratClient->delete();

                // Rediriger avec un message de succès
                return redirect()->route('clients.show', $clientId)->with('success', 'Contrat supprimé avec succès.');
            }
}
