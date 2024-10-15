<?php
namespace App\Http\Controllers;

use App\Models\Chauffeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChauffeurController extends Controller
{
    public function index()
    {
        $chauffeurs = Chauffeur::all();
        return view('livewire.chauffeurs.index', compact('chauffeurs'));
    }

    public function create()
    {
        return view('livewire.chauffeurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:255|unique:chauffeurs,cin',
            'cin_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'certificat_medical_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'permis_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type_permis' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'telephone' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
        ]);

        $cinImagePath = $request->file('cin_image')
            ? $request->file('cin_image')->store('images/chauffeurs/cin', 'public')
            : null;

        $certificatMedicalImagePath = $request->file('certificat_medical_image')
            ? $request->file('certificat_medical_image')->store('images/chauffeurs/certificat', 'public')
            : null;

        $permisImagePath = $request->file('permis_image')
            ? $request->file('permis_image')->store('images/chauffeurs/permis', 'public')
            : null;

        Chauffeur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'cin' => $request->cin,
            'cin_image' => $cinImagePath,
            'certificat_medical_image' => $certificatMedicalImagePath,
            'permis_image' => $permisImagePath,
            'type_permis' => $request->type_permis,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);

        return redirect()->route('chauffeurs.index')->with('success', 'Le chauffeur a été ajouté avec succès.');
    }

   public function edit($id)
   {
       // Récupérer le chauffeur à éditer
       $chauffeur = Chauffeur::findOrFail($id);

       // Retourner la vue avec le chauffeur
       return view('livewire.chauffeurs.edit', compact('chauffeur'));
   }
    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:255|unique:chauffeurs,cin,' . $id,
            'cin_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certificat_medical_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'permis_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type_permis' => 'required|string',
            'date_naissance' => 'required|date',
            'telephone' => 'required|string|max:15',
            'adresse' => 'required|string|max:255',
        ]);

        // Trouver le chauffeur par ID
        $chauffeur = Chauffeur::findOrFail($id);

        // Mettre à jour les données du chauffeur
        $chauffeur->nom = $request->input('nom');
        $chauffeur->prenom = $request->input('prenom');
        $chauffeur->cin = $request->input('cin');
        $chauffeur->type_permis = $request->input('type_permis');
        $chauffeur->date_naissance = $request->input('date_naissance');
        $chauffeur->telephone = $request->input('telephone');
        $chauffeur->adresse = $request->input('adresse');

        // Gestion des images
        if ($request->hasFile('cin_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($chauffeur->cin_image) {
                Storage::disk('public')->delete($chauffeur->cin_image);
            }
            // Stocker la nouvelle image
            $chauffeur->cin_image = $request->file('cin_image')->store('images/cheffeur/cin', 'public');
        }

        if ($request->hasFile('certificat_medical_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($chauffeur->certificat_medical_image) {
                Storage::disk('public')->delete($chauffeur->certificat_medical_image);
            }
            // Stocker la nouvelle image
            $chauffeur->certificat_medical_image = $request->file('certificat_medical_image')->store('images/cheffeur/certificat', 'public');
        }

        if ($request->hasFile('permis_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($chauffeur->permis_image) {
                Storage::disk('public')->delete($chauffeur->permis_image);
            }
            // Stocker la nouvelle image
            $chauffeur->permis_image = $request->file('permis_image')->store('images/cheffeur/permis', 'public');
        }

        // Enregistrer les modifications dans la base de données
        $chauffeur->save();

        // Rediriger avec un message de succès
        return redirect()->route('chauffeurs.index')->with('success', 'Chauffeur mis à jour avec succès !');
    }
       public function show($id)
     {
        // Retrieve the chauffeur by ID

        $chauffeur = Chauffeur::with(['contrats', 'trajets'])->find($id);


    // Return the view with the chauffeur's details
    return view('livewire.chauffeurs.show', compact('chauffeur'));
}

   public function destroy($id)
   {
       // Retrieve the chauffeur by ID
       $chauffeur = Chauffeur::findOrFail($id);

       // Optionally, you can delete the related images from storage
       if ($chauffeur->cin_image) {
           Storage::disk('public')->delete($chauffeur->cin_image);
       }
       if ($chauffeur->certificat_medical_image) {
           Storage::disk('public')->delete($chauffeur->certificat_medical_image);
       }
       if ($chauffeur->permis_image) {
           Storage::disk('public')->delete($chauffeur->permis_image);
       }

       // Delete the chauffeur record
       $chauffeur->delete();

       // Redirect to the index page with a success message
       return redirect()->route('chauffeurs.index')->with('success', 'Chauffeur supprimé avec succès.');
   }
}
