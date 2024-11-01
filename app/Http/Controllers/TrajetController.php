<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Camion;
use App\Models\Chauffeur;
use App\Models\Client;
use Illuminate\Http\Request;

class TrajetController extends Controller
{
    /**
     * Afficher la liste des trajets.
     */
    public function index()
    {
        $trajets = Trajet::with(['camion', 'chauffeur', 'client'])->get();
        return view('livewire.trajets.index', compact('trajets'));
    }

    /**
     * Afficher le formulaire de création d'un nouveau trajet.
     */
    public function create()
    {
        $camions = Camion::all();
        $chauffeurs = Chauffeur::all();
        $clients = Client::all();
        return view('livewire.trajets.create', compact('camions', 'chauffeurs', 'clients'));
    }

    /**
     * Enregistrer un nouveau trajet.
     */
    public function store(Request $request)
    {
        // Validation des champs du formulaire
        $request->validate([
            'titre' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'kilometrage' => 'required|integer',
            'camion_id' => 'required|exists:camions,id',
            'chauffeur_id' => 'required|exists:chauffeurs,id',
            'client_id' => 'required|exists:clients,id',
            'date_depart' => 'required|date',
            'date_arrivee' => 'required|date',
            'lieu_depart' => 'required|string|max:255',
            'lieu_arrivee' => 'required|string|max:255',
            'statut' => 'required|string|in:en cours,terminé,annulé',
        ]);

        // Récupérer le camion
        $camion = Camion::findOrFail($request->camion_id);

        // Vérifier si le kilométrage après le dernier vidange dépasse 10 000 km
        if ($camion->kilometrageApresDernierVidange + $request->kilometrage > 10000) {
            return redirect()->back()->withErrors([
                'message' => 'Ce camion a dépassé 10 000 km après son dernier vidange. Veuillez effectuer un vidange avant d\'ajouter un nouveau trajet.'
            ]);
        }

        // Si tout est bon, créer le trajet
        $trajet = new Trajet();
        $trajet->titre = $request->titre;
        $trajet->prix = $request->prix;
        $trajet->kilometrage = $request->kilometrage;
        $trajet->camion_id = $request->camion_id;
        $trajet->chauffeur_id = $request->chauffeur_id;
        $trajet->client_id = $request->client_id;
        $trajet->date_depart = $request->date_depart;
        $trajet->date_arrivee = $request->date_arrivee;
        $trajet->lieu_depart = $request->lieu_depart;
        $trajet->lieu_arrivee = $request->lieu_arrivee;
        $trajet->statut = $request->statut;
        $trajet->save();

        // Mettre à jour le kilométrage du camion si le trajet est terminé
        if ($trajet->statut == 'terminé') {
            $camion->totalKilometrage += $trajet->kilometrage;
            $camion->kilometrageApresDernierVidange += $trajet->kilometrage;
            $camion->save();
        }

        return redirect()->route('trajets.index')->with('success', 'Trajet créé avec succès');
    }

    /**
     * Afficher les détails d'un trajet.
     */
    public function show($id)
    {
        $trajet = Trajet::with(['camion', 'chauffeur', 'client'])->findOrFail($id);
        return view('livewire.trajets.show', compact('trajet'));
    }

    /**
     * Afficher le formulaire d'édition d'un trajet.
     */
    public function edit($id)
    {
        $trajet = Trajet::findOrFail($id);
        $camions = Camion::all();
        $chauffeurs = Chauffeur::all();
        $clients = Client::all();
        return view('livewire.trajets.edit', compact('trajet', 'camions', 'chauffeurs', 'clients'));
    }

    /**
     * Mettre à jour un trajet existant.
     */
    public function update(Request $request, $id)
    {
        $trajet = Trajet::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'kilometrage' => 'required|integer',
            'camion_id' => 'required|exists:camions,id',
            'chauffeur_id' => 'required|exists:chauffeurs,id',
            'client_id' => 'required|exists:clients,id',
            'date_depart' => 'required|date',
            'date_arrivee' => 'nullable|date',
            'lieu_depart' => 'required|string|max:255',
            'lieu_arrivee' => 'required|string|max:255',
            'statut' => 'required|string|in:en cours,terminé,annulé',
        ]);

        $camion = Camion::findOrFail($validated['camion_id']);

        // Vérifier si le camion nécessite une vidange avant la mise à jour
        if ($camion->necessiteVidange() && $trajet->statut !== Trajet::STATUT_TERMINE) {
            return redirect()->back()->withErrors(['error' => 'Le camion sélectionné nécessite une vidange.']);
        }

        // Mettre à jour les informations du trajet et le kilométrage du camion
        $camion->totalKilometrage -= $trajet->kilometrage;
        $camion->totalKilometrage += $validated['kilometrage'];
        $camion->save();

        $trajet->update($validated);

        return redirect()->route('trajets.index')->with('success', 'Trajet mis à jour avec succès.');
    }

    /**
     * Supprimer un trajet.
     */
    public function destroy($id)
    {
        $trajet = Trajet::findOrFail($id);
        $camion = $trajet->camion;

        // Retirer le kilométrage du trajet du camion avant de le supprimer
        $camion->totalKilometrage -= $trajet->kilometrage;
        $camion->save();

        $trajet->delete();

        return redirect()->route('trajets.index')->with('success', 'Trajet supprimé avec succès.');
    }
}
