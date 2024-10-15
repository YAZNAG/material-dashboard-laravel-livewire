<?php

namespace App\Http\Controllers;

use App\Models\Camion;
use App\Models\CartAutorisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartAutorisationController extends Controller
{
    // Show the form for creating a new carte d'autorisation
    public function create()
    {
        $camions = Camion::all(); // Fetch all camions
        return view('livewire.camions.CartAutorisation.create', compact('camions'));
    }

    // Store a newly created carte d'autorisation in storage
    public function store(Request $request)
    {
        $request->validate([
            'camion_id' => 'required|exists:camions,id',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'numero_inscription' => 'required|string|max:255', // Validation du numéro d'inscription

        ]);

        // Store the image if uploaded
        $imagePath = $request->file('image_path')
            ? $request->file('image_path')->store('images/camions/carte_autorisation', 'public')
            : null;

        CartAutorisation::create([
            'camion_id' => $request->camion_id,
            'image_path' => $imagePath,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'numero_inscription' => $request->numero_inscription, // Sauvegarde du numéro d'inscription

        ]);

        return redirect()->route('documents.index')->with('success', 'Carte d\'Autorisation ajoutée avec succès.');
    }

    // Show the form for editing the specified carte d'autorisation
    public function edit($id)
        {
            // Fetch the specific Carte Autorisation
            $autorisation = CartAutorisation::findOrFail($id);

            // Fetch all Camions
            $camions = Camion::all();

            // Pass the data to the view
            return view('livewire.camions.CartAutorisation.edit', compact('autorisation', 'camions'));
        }

    // Update the specified carte d'autorisation in storage
     /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Models\CartAutorisation  $autorisation
         * @return \Illuminate\Http\Response
         */
     public function update(Request $request, $id)
     {
         // Find the Carte d'Autorisation by ID
         $autorisation = CartAutorisation::findOrFail($id);

         // Validate form inputs
         $request->validate([
             'camion_id' => 'required|exists:camions,id',
             'date_debut' => 'required|date',
             'date_fin' => 'required|date|after_or_equal:date_debut',
             'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate new image if uploaded
              'numero_inscription' => 'required|string|max:255', // Validation du numéro d'inscription

         ]);

         // Handle image upload
         if ($request->hasFile('image_path')) {
             // Delete the old image if it exists
             if ($autorisation->image_path) {
                 Storage::delete('public/' . $autorisation->image_path);
             }

             // Store the new image
             $imagePath = $request->file('image_path')->store('images/camions/autorisations', 'public');
             $autorisation->image_path = $imagePath;
         }

         // Update other details
         $autorisation->camion_id = $request->input('camion_id');
         $autorisation->date_debut = $request->input('date_debut');
         $autorisation->date_fin = $request->input('date_fin');
         $autorisation->numero_inscription = $request->input('numero_inscription'); // Mise à jour du numéro d'inscription

         $autorisation->save(); // Save the changes to the database

         return redirect()->route('documents.index')->with('success', 'Carte d\'Autorisation mise à jour avec succès.');
     }


    // Remove the specified carte d'autorisation from storage
   public function destroy($id)
   {
       // Find the Carte d'Autorisation by ID
       $autorisation = CartAutorisation::findOrFail($id);

       // Delete the associated image file if it exists
       if ($autorisation->image_path) {
           Storage::delete('public/' . $autorisation->image_path);
       }

       // Delete the Carte d'Autorisation record from the database
       $autorisation->delete();

       return redirect()->route('documents.index')->with('success', 'Carte d\'Autorisation supprimée avec succès.');
   }

}
