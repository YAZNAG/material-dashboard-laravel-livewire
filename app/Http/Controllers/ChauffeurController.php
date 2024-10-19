<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use App\Models\Permis;
use App\Models\Contrat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChauffeurController extends Controller
{
    // Afficher la liste des chauffeurs
    public function index()
    {
        $chauffeurs = Chauffeur::all();
        return view('livewire.chauffeurs.index', compact('chauffeurs'));
    }

    // Afficher le formulaire de création d'un chauffeur
    public function create()
    {
        return view('livewire.chauffeurs.create');
    }

    // Stocker un nouveau chauffeur
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'telephone' => 'required|string|max:15',
            'adresse' => 'required|string|max:255',
            'cin_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'certificat_medical_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $chauffeur = Chauffeur::create($request->all());

        // Handle file uploads
        if ($request->hasFile('cin_image')) {
            $chauffeur->cin_image = $request->file('cin_image')->store('images/chauffeurs', 'public');
        }

        if ($request->hasFile('certificat_medical_image')) {
            $chauffeur->certificat_medical_image = $request->file('certificat_medical_image')->store('images/chauffeurs', 'public');
        }

        $chauffeur->save();

        return redirect()->route('chauffeurs.index')->with('success', 'Chauffeur créé avec succès.');
    }

  public function show($id)
  {
      // Charger le chauffeur avec ses relations 'contrats', 'trajets' et 'permis'
      $chauffeur = Chauffeur::with(['contrats', 'trajets', 'permis'])->find($id);

      // Si le chauffeur n'est pas trouvé, rediriger avec un message d'erreur
      if (!$chauffeur) {
          return redirect()->route('chauffeurs.index')->with('error', 'Chauffeur non trouvé.');
      }

      // Supposons que vous voulez éditer un permis spécifique
      $permisItem = $chauffeur->permis->first();
       $contrat = $chauffeur->contrats->first();
       $permis = $chauffeur->permis;

      // Retourner la vue avec les données du chauffeur et du permis
      return view('livewire.chauffeurs.show', compact('chauffeur', 'permisItem','contrat','permis'));
  }




    // Afficher le formulaire d'édition d'un chauffeur
    public function edit($id)
    {
        $chauffeur = Chauffeur::findOrFail($id);
        return view('livewire.chauffeurs.edit', compact('chauffeur'));
    }

    // Mettre à jour un chauffeur
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'telephone' => 'required|string|max:15',
            'adresse' => 'required|string|max:255',
            'cin_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'certificat_medical_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $chauffeur = Chauffeur::findOrFail($id);
        $chauffeur->update($request->all());

        // Handle file uploads
        if ($request->hasFile('cin_image')) {
            // Delete old image if it exists
            if ($chauffeur->cin_image) {
                Storage::delete('public/' . $chauffeur->cin_image);
            }
            $chauffeur->cin_image = $request->file('cin_image')->store('images/chauffeurs', 'public');
        }

        if ($request->hasFile('certificat_medical_image')) {
            // Delete old image if it exists
            if ($chauffeur->certificat_medical_image) {
                Storage::delete('public/' . $chauffeur->certificat_medical_image);
            }
            $chauffeur->certificat_medical_image = $request->file('certificat_medical_image')->store('images/chauffeurs', 'public');
        }

        $chauffeur->save();

        return redirect()->route('chauffeurs.index')->with('success', 'Chauffeur mis à jour avec succès.');
    }

    // Supprimer un chauffeur
    public function destroy($id)
    {
        $chauffeur = Chauffeur::findOrFail($id);

        // Delete images if they exist
        if ($chauffeur->cin_image) {
            Storage::delete('public/' . $chauffeur->cin_image);
        }
        if ($chauffeur->certificat_medical_image) {
            Storage::delete('public/' . $chauffeur->certificat_medical_image);
        }

        $chauffeur->delete();

        return redirect()->route('chauffeurs.index')->with('success', 'Chauffeur supprimé avec succès.');
    }

   // Méthodes pour gérer les permis
   public function storePermis(Request $request, $chauffeurId)
   {
       // Validation des données
       $request->validate([
           'type_permis' => 'required|string|in:AM,A1,A,B,C,D,EB,EC,ED', // Types de permis acceptés
           'image_permis' => 'image|mimes:jpeg,png,jpg|max:2048',
           'date_delivration' => 'required|date',
           'date_fin' => 'required|date|after_or_equal:date_delivration',
       ]);

       // Créer une nouvelle instance de Permis
       $permis = new Permis();
       $permis->chauffeur_id = $chauffeurId;
       $permis->type_permis = $request->type_permis;
       $permis->date_delivration = $request->date_delivration;
       $permis->date_fin = $request->date_fin;

       // Enregistrer l'image du permis dans le dossier approprié
       if ($request->hasFile('image_permis')) {
           $imagePath = $request->file('image_permis')->store('images/chauffeurs/permis', 'public');
           $permis->image_permis = $imagePath;
       }

       // Sauvegarder le permis
       $permis->save();

       // Rediriger avec un message de succès
       return redirect()->route('chauffeurs.show', $chauffeurId)->with('success', 'Permis ajouté avec succès.');
   }

// Méthodes pour gérer les permis
public function updatePermis(Request $request, $chauffeurId, $permisId)
{
    // Validation des données
    $request->validate([
        'type_permis' => 'required|string|in:AM,A1,A,B,C,D,EB,EC,ED', // Types de permis acceptés
        'image_permis' => 'image|mimes:jpeg,png,jpg|max:2048',
        'date_delivration' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_delivration',
    ]);

    // Trouver le permis par son ID
    $permis = Permis::find($permisId);

    // Si le permis n'est pas trouvé, rediriger avec un message d'erreur
    if (!$permis) {
        return redirect()->route('chauffeurs.show', $chauffeurId)->with('error', 'Permis non trouvé.');
    }

    // Mettre à jour les champs du permis
    $permis->type_permis = $request->type_permis;
    $permis->date_delivration = $request->date_delivration;
    $permis->date_fin = $request->date_fin;

    // Vérifier si une nouvelle image a été téléchargée
    if ($request->hasFile('image_permis')) {
        // Enregistrer l'image du permis dans le dossier approprié
        $imagePath = $request->file('image_permis')->store('images/chauffeurs/permis', 'public');
        $permis->image_permis = $imagePath;
    }

    // Sauvegarder les modifications du permis
    $permis->save();

    // Rediriger avec un message de succès
    return redirect()->route('chauffeurs.show', $chauffeurId)->with('success', 'Permis mis à jour avec succès.');
}


   // Méthodes pour gérer les contrats
   public function storeContrat(Request $request, $chauffeurId)
   {
       // Validation des données
       $request->validate([
           'date_debut' => 'required|date',
           'date_fin' => 'required|date|after_or_equal:date_debut',
           'salaire' => 'required|numeric',
           'contrat_pdf' => 'required|file|mimes:pdf|max:2048',
       ]);

       // Créer une nouvelle instance de Contrat
       $contrat = new Contrat($request->all());
       $contrat->chauffeur_id = $chauffeurId;

       // Enregistrer le PDF du contrat
       if ($request->hasFile('contrat_pdf')) {
           $contrat->contrat_pdf = $request->file('contrat_pdf')->store('documents/contrats/chauffeur', 'public');
       }

       // Sauvegarder le contrat
       $contrat->save();

       // Rediriger avec un message de succès
       return redirect()->route('chauffeurs.show', $chauffeurId)->with('success', 'Contrat ajouté avec succès.');
   }

   public function updateContrat(Request $request, $chauffeurId, $contratId)
   {
       // Validation des données
       $request->validate([
           'date_debut' => 'required|date',
           'date_fin' => 'required|date|after_or_equal:date_debut',
           'salaire' => 'required|numeric',
           'contrat_pdf' => 'nullable|file|mimes:pdf|max:2048', // PDF n'est pas requis, mais doit être un fichier valide s'il est fourni
       ]);

       // Trouver le contrat existant
       $contrat = Contrat::where('chauffeur_id', $chauffeurId)->findOrFail($contratId);

       // Mise à jour des champs du contrat
       $contrat->date_debut = $request->date_debut;
       $contrat->date_fin = $request->date_fin;
       $contrat->salaire = $request->salaire;

       // Si un nouveau fichier PDF du contrat est soumis, le sauvegarder et remplacer l'ancien
       if ($request->hasFile('contrat_pdf')) {
           // Supprimer l'ancien fichier PDF si nécessaire
           if ($contrat->contrat_pdf && Storage::disk('public')->exists($contrat->contrat_pdf)) {
               Storage::disk('public')->delete($contrat->contrat_pdf);
           }
           // Enregistrer le nouveau PDF
           $contrat->contrat_pdf = $request->file('contrat_pdf')->store('documents/contrats/chauffeur', 'public');
       }

       // Sauvegarder les changements
       $contrat->save();

       // Rediriger avec un message de succès
       return redirect()->route('chauffeurs.show', $chauffeurId)->with('success', 'Contrat mis à jour avec succès.');
   }
public function destroyPermis($chauffeurId, $permisId)
{
    $permis = Permis::find($permisId);

    // Si le permis n'est pas trouvé, rediriger avec un message d'erreur
    if (!$permis) {
        return redirect()->route('chauffeurs.show', $chauffeurId)->with('error', 'Permis non trouvé.');
    }

    // Supprimer l'image du permis si elle existe
    if ($permis->image_permis) {
        Storage::delete('public/' . $permis->image_permis);
    }

    // Supprimer le permis
    $permis->delete();

    return redirect()->route('chauffeurs.show', $chauffeurId)->with('success', 'Permis supprimé avec succès.');
}


    // Supprimer un contrat
    public function destroyContrat($chauffeurId, $contratId)
    {
        $contrat = Contrat::where('chauffeur_id', $chauffeurId)->find($contratId);

        // Si le contrat n'est pas trouvé, rediriger avec un message d'erreur
        if (!$contrat) {
            return redirect()->route('chauffeurs.show', $chauffeurId)->with('error', 'Contrat non trouvé.');
        }

        // Supprimer le fichier PDF du contrat si il existe
        if ($contrat->contrat_pdf) {
            Storage::delete('public/' . $contrat->contrat_pdf);
        }

        $contrat->delete();

        return redirect()->route('chauffeurs.show', $chauffeurId)->with('success', 'Contrat supprimé avec succès.');
    }




    }
