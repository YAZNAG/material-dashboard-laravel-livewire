<?php

namespace App\Http\Controllers;

use App\Models\Assurance;
use App\Models\Camion;
use Illuminate\Http\Request;

class AssuranceController extends Controller
{
public function show($id)
{
    // Récupérer l'assurance par son ID
    $assurance = Assurance::findOrFail($id);

    // Retourner la vue pour afficher les détails de l'assurance
    return view('livewire.camions.assurance.show', compact('assurance'));
}


    public function create()
    {

     $camions = Camion::all();
        return view('livewire.camions.assurance.create',compact('camions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'camion_id' => 'required',
            'numero_police' => 'required',
            'montant' => 'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'entreprise_assurence' => 'required|string',
            'intermediaire' => 'required|string',
            'assurence_image' => 'nullable|image|max:1024',
            'numero_ordre' => 'required|string', // Validation pour numero_ordre
        ]);

        // Stocker l'image dans le dossier
        $imagePath = $request->file('assurence_image')
            ? $request->file('assurence_image')->store('images/camions/assurance', 'public')
            : null;

        // Créer l'enregistrement de l'assurance
        Assurance::create([
            'camion_id' => $request->camion_id,
            'numero_police' => $request->numero_police,
            'montant' => $request->montant,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'entreprise_assurence' => $request->entreprise_assurence,
            'intermediaire' => $request->intermediaire,
            'assurence_image' => $imagePath,
            'numero_ordre' => $request->numero_ordre, // Ajouter ici
        ]);

        session()->flash('message', 'Assurance ajoutée avec succès.');
        return redirect()->route('documents.index');
    }

    public function edit($id)
    {
        $assurance = Assurance::findOrFail($id);
        return view('livewire.camions.assurance.edit', compact('assurance'));
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'numero_police' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'entreprise_assurence' => 'required|string',
            'intermediaire' => 'required|string',
            'assurence_image' => 'nullable|image|max:1024',  // Image validation
            'numero_ordre' => 'required|integer', // Validation pour numero_ordre
        ]);

        // Récupération de l'assurance existante
        $assurance = Assurance::findOrFail($id);

        // Si une nouvelle image est fournie, la traiter
        $imagePath = $assurance->assurence_image; // Chemin existant par défaut

        if ($request->hasFile('assurence_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($assurance->assurence_image) {
                \Storage::delete($assurance->assurence_image);
            }
            // Stocker la nouvelle image
            $imagePath = $request->assurence_image->store('images/camions/assurance', 'public');
        }

        // Mettre à jour les données de l'assurance
        $assurance->update([
            'numero_police' => $request->numero_police,
            'montant' => $request->montant,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'entreprise_assurence' => $request->entreprise_assurence,
            'intermediaire' => $request->intermediaire,
            'assurence_image' => $imagePath,
            'numero_ordre' => $request->numero_ordre, // Ajout de numero_ordre
        ]);

        session()->flash('message', 'Assurance mise à jour avec succès.');
        return redirect()->route('documents.index');
    }

    public function destroy($id)
    {
        $assurance = Assurance::findOrFail($id);
        $assurance->delete();

        return redirect()->route('documents.index')->with('success', 'Assurance supprimée avec succès.');
    }
}
