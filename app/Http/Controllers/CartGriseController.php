<?php

namespace App\Http\Controllers;

use App\Models\CartGrise;
use App\Models\Camion;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class CartGriseController extends Controller
{
    /**
     * Show the form for creating a new carte grise.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch all camions for the dropdown
        $camions = Camion::all();

        return view('livewire.camions.CartGrise.create', compact('camions'));
    }

    /**
     * Store a newly created carte grise in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form inputs
        $validated = $request->validate([
            'camion_id' => 'required|exists:camions,id',
            'date_fin' => 'required|date',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure a valid image
        ]);

        // Storing the uploaded image
        $imagePath = $request->file('image_path')
            ? $request->file('image_path')->store('images/camions/Carte_Grise', 'public')
            : null;

        // Create a new Carte Grise record
        CartGrise::create([
            'camion_id' => $validated['camion_id'],
            'date_fin' => $validated['date_fin'],
            'image_path' => $imagePath,  // Store the image path in the DB
        ]);

        // Redirect with success message
        return redirect()->route('documents.index')->with('success', 'Carte Grise ajoutée avec succès.');
    }

    /**
     * Show the form for editing the specified carte grise.
     *
     * @param  \App\Models\CartGrise  $cartGrise
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Fetch the specific Carte Grise by ID
        $carte = CartGrise::findOrFail($id);

        // Fetch the list of camions (for the camion selection dropdown)
        $camions = Camion::all(); // Assuming you have a Camion model

        // Pass the Carte Grise data and camions list to the view
        return view('livewire.camions.CartGrise.edit', compact('carte', 'camions'));
    }
    /**
     * Update the specified carte grise in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartGrise  $cartGrise
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
   {
       $carte = CartGrise::findOrFail($id);

       // Validate form inputs
       $request->validate([
           'camion_id' => 'required|exists:camions,id',
           'date_fin' => 'required|date',
           'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate new image if uploaded
       ]);

       // Handle image upload
       if ($request->hasFile('image_path')) {
           // Delete the old image if exists
           if ($carte->image_path) {
               Storage::delete('public/' . $carte->image_path);
           }

           // Store the new image
           $imagePath = $request->file('image_path')->store('images/camions/cartesgrise', 'public');
           $carte->image_path = $imagePath;
       }

       // Update other details
       $carte->camion_id = $request->input('camion_id');
       $carte->date_fin = $request->input('date_fin');
       $carte->save();

       return redirect()->route('documents.index')->with('success', 'Carte grise mise à jour avec succès.');
   }

    /**
     * Remove the specified carte grise from storage.
     *
     * @param  \App\Models\CartGrise  $cartGrise
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the Carte Grise by ID
        $carte = CartGrise::findOrFail($id);

        // Check if the image exists and delete it from storage
        if ($carte->image_path) {
            Storage::disk('public')->delete($carte->image_path);
        }

        // Delete the Carte Grise record
        $carte->delete();

        // Redirect back with a success message
        return redirect()->route('documents.index')->with('success', 'Carte Grise deleted successfully.');
    }

}
