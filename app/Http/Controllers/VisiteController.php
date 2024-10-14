<?php

namespace App\Http\Controllers;

use App\Models\Visite;
use App\Models\Camion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisiteController extends Controller
{
    // Show the form for creating a new visit
    public function create()
    {
        $camions = Camion::all(); // Fetch all camions to be shown in the dropdown
        return view('livewire.camions.visites.create', compact('camions')); // Pass camions to the view
    }

    // In your VisiteController

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'type' => 'required|string|max:255',
            'numero_autorisation' => 'nullable|string|max:255',
            'nom_centre' => 'nullable|string|max:255',
            'address_centre' => 'nullable|string|max:255',
            'resultat' => 'nullable|string',
            'visite_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
            'camion_id' => 'required|exists:camions,id',
        ]);

        // Store the image if it's uploaded
        $imagePath = $request->file('visite_image')
            ? $request->file('visite_image')->store('images/camions/visites', 'public')
            : null;

        // Create a new visit record
        $visite = Visite::create([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'type' => $request->type,
            'numero_autorisation' => $request->numero_autorisation,
            'nom_centre' => $request->nom_centre,
            'address_centre' => $request->address_centre,
            'resultat' => $request->resultat,
            'visite_image' => $imagePath, // Store the path of the uploaded image
            'camion_id' => $request->camion_id,
        ]);

        // Redirect or return a response
        return redirect()->route('documents.index')->with('success', 'Visite created successfully!');
    }


    // Show the form for editing the specified visit
    public function edit($id)
    {
        // Retrieve the visit record by ID or fail if not found
        $visite = Visite::findOrFail($id);
        $camions = Camion::all(); // Fetch all camions for the dropdown

        // Return the edit view with the visit data and camions
        return view('livewire.camions.visites.edit', compact('visite', 'camions'));
    }

    // Update the specified visit in storage
    public function update(Request $request, $id)
    {
        // Validate the request inputs
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'type' => 'required|string',
            'numero_autorisation' => 'nullable|string',
            'nom_centre' => 'nullable|string',
            'address_centre' => 'nullable|string',
            'resultat' => 'nullable|string',
            'visite_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'camion_id' => 'required|exists:camions,id',
        ]);

        $visite = Visite::findOrFail($id);
        $visite->date_debut = $request->date_debut;
        $visite->date_fin = $request->date_fin;
        $visite->type = $request->type;
        $visite->numero_autorisation = $request->numero_autorisation;
        $visite->nom_centre = $request->nom_centre;
        $visite->address_centre = $request->address_centre;
        $visite->resultat = $request->resultat;
        $visite->camion_id = $request->camion_id;

        // Handle the image upload
        if ($request->hasFile('visite_image')) {
            // Delete the old image if it exists
            if ($visite->visite_image) {
                Storage::delete('public/images/camions/visites/' . basename($visite->visite_image));
            }

            // Store the new image
            $path = $request->file('visite_image')->store('images/camions/visites', 'public');
            $visite->visite_image = $path;
        }

        $visite->save();

        return redirect()->route('documents.index')->with('success', 'Visite mise à jour avec succès.');
    }

    // Remove the specified visit from storage
    public function destroy($id)
    {
        // Find the visit record by ID
        $visite = Visite::findOrFail($id);

        // Delete the associated image if it exists
        if ($visite->visite_image) {
            $imagePath = public_path('storage/images/camions/visites/' . basename($visite->visite_image));
            if (file_exists($imagePath)) {
                unlink($imagePath); // Remove the image file from the storage
            }
        }

        // Delete the visit record from the database
        $visite->delete();

        // Redirect back with a success message
        return redirect()->route('documents.index')->with('success', 'Visite supprimée avec succès.');
    }
}
