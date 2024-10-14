<?php

namespace App\Http\Controllers;

use App\Models\Camion;
use App\Models\TaxeSpecialeAnnuelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaxeSpecialeAnnuelleController extends Controller
{
    // Show the form for creating a new tax
    public function create()
    {
        $camions = Camion::all(); // Fetch all camions to be shown in the dropdown
        return view('livewire.camions.taxes.create', compact('camions')); // Pass camions to the view
    }

    public function store(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'annee' => 'required|integer|min:2000|max:' . date('Y'),
            'trache' => 'required|string',
            'montant_principal' => 'required|numeric|min:0',
            'penalite' => 'nullable|numeric|min:0',
            'majorations' => 'nullable|numeric|min:0',
            'camion_id' => 'required|exists:camions,id',
            'taxe_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Store the image if it is provided
        $imagePath = $request->file('taxe_image')
            ? $request->file('taxe_image')->store('images/camions/taxes', 'public')
            : null;

        // Calculate montant_total
        $montant_total = $request->montant_principal + $request->penalite + $request->majorations;

        // Create a new TaxeSpecialeAnnuelle record
        TaxeSpecialeAnnuelle::create([
            'annee' => $request->annee,
            'trache' => $request->trache,
            'montant_principal' => $request->montant_principal,
            'penalite' => $request->penalite,
            'majorations' => $request->majorations,
            'montant_total' => $montant_total,
            'date_paiement' => $request->date_paiement,
            'camion_id' => $request->camion_id,
            'taxe_image' => $imagePath,  // Save the image path
        ]);

        // Redirect or return a response
        return redirect()->route('documents.index')->with('success', 'Taxe créée avec succès.');
    }
     public function edit($id)
        {
            // Retrieve the tax record by ID or fail if not found
            $taxe = TaxeSpecialeAnnuelle::findOrFail($id);

            // Retrieve all camions for the dropdown
            $camions = Camion::all();

            // Return the edit view with the tax data and camions
            return view('livewire.camions.taxes.edit', compact('taxe', 'camions'));
        }
    public function update(Request $request, $id)
    {
        $request->validate([
            'annee' => 'required|integer|min:2000|max:' . date('Y'),
            'trache' => 'required|string',
            'montant_principal' => 'required|numeric|min:0',
            'penalite' => 'nullable|numeric|min:0',
            'majorations' => 'nullable|numeric|min:0',
            'montant_total' => 'required|numeric|min:0',
            'date_paiement' => 'nullable|date',
            'camion_id' => 'required|exists:camions,id',
            'taxe_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $TaxeSpecialeAnnuelle = TaxeSpecialeAnnuelle::findOrFail($id);
        $TaxeSpecialeAnnuelle->annee = $request->annee;
        $TaxeSpecialeAnnuelle->trache = $request->trache;
        $TaxeSpecialeAnnuelle->montant_principal = $request->montant_principal;
        $TaxeSpecialeAnnuelle->penalite = $request->penalite;
        $TaxeSpecialeAnnuelle->majorations = $request->majorations;
        $TaxeSpecialeAnnuelle->montant_total = $request->montant_total;
        $TaxeSpecialeAnnuelle->date_paiement = $request->date_paiement;
        $TaxeSpecialeAnnuelle->camion_id = $request->camion_id;

        // Handle the image upload
        if ($request->hasFile('taxe_image')) {
            // Delete the old image if it exists
            if ($TaxeSpecialeAnnuelle->taxe_image) {
                Storage::delete('public/images/camions/taxes/' . basename($TaxeSpecialeAnnuelle->taxe_image));
            }

            // Store the new image
            $path = $request->file('taxe_image')->store('images/camions/taxes', 'public');
            $TaxeSpecialeAnnuelle->taxe_image = $path;
        }

        $TaxeSpecialeAnnuelle->save();

        return redirect()->route('documents.index')->with('success', 'Taxe mise à jour avec succès.');
    }


public function destroy($id)
{
    // Find the tax record by ID
    $taxe = TaxeSpecialeAnnuelle::findOrFail($id);

    // Delete the associated image if it exists
    if ($taxe->taxe_image) {
        $imagePath = public_path('storage/images/camions/taxes/' . basename($taxe->taxe_image));
        if (file_exists($imagePath)) {
            unlink($imagePath); // Remove the image file from the storage
        }
    }

    // Delete the tax record from the database
    $taxe->delete();

    // Redirect back with a success message
    return redirect()->route('documents.index')->with('success', 'Taxe supprimée avec succès.');
}


}
