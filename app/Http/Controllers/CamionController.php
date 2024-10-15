<?php

namespace App\Http\Controllers;

use App\Models\Camion;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class CamionController extends Controller
{
    /**
     * Display a listing of the camions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $camions = Camion::all(); // Fetch all camions
        return view('livewire.camions.index', compact('camions')); // Return the view with camions
    }

    /**
     * Show the form for creating a new camion.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('livewire.camions.create'); // Return the form view for creating a camion
    }

    /**
     * Store a newly created camion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
        {
            // Validate the request
            $request->validate([
                'matricule' => 'required|string|max:191|unique:camions',
                'antérieure_matricule' => 'required|string|max:100|unique:camions',
                'camion_title' => 'required|string|max:255',
                'modele' => 'nullable|string',
                'type' => 'nullable|string',
                'date_imma' => 'required|date',
                'date_mec' => 'nullable|date',
                'genre' => 'nullable|string',
                'marque' => 'nullable|string',
                'type_carburant' => 'nullable|string',
                'numero_chassais' => 'nullable|string',
                'nombre_cylindres' => 'nullable|integer|min:0',
                'PTAC' => 'nullable|numeric|min:0',
                'type_usage' => 'nullable|string',
                'poids_vide' => 'nullable|numeric|min:0',
                'puissance_fiscale' => 'nullable|numeric|min:0',
                'images.*' => 'image|max:1024', // Validate each image (1MB max)
            ]);

           // Create the new Camion entry in the database
               $camion = Camion::create($request->except('images')); // Exclude images from the camion creation

               // Handle the image uploads
               if ($request->hasFile('images')) {
                   foreach ($request->file('images') as $image) {
                       // Generate a unique name for each image
                       $imageName = time() . '_' . \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();
                       // Move the image to the specified folder
                       $image->move(public_path('storage/images/camions/'), $imageName);
                       // Save the image path in the 'images' table with the associated 'camion_id'
                       Images::create([
                           'image_path' => 'images/camions/' . $imageName,
                           'camion_id' => $camion->id, // Lier l'image au camion
                       ]);
                   }
               }



        // Redirect back with success message
        return redirect()->route('camions.index')->with('success', 'Camion created successfully.');
    }

    /**
     * Display the specified camion.
     *
     * @param  Camion  $camion
     * @return \Illuminate\View\View
     */
  public function show($id)
     {
         // Récupérer le camion avec ses relations
         $camion = Camion::with(['images', 'cartGrises', 'cartAutorisations', 'assurances', 'taxesSpecialeAnnuelles', 'visites'])->findOrFail($id);

         // Retourner la vue avec les détails du camion
         return view('livewire.camions.show', compact('camion'));
     }


    /**
     * Show the form for editing the specified camion.
     *
     * @param  Camion  $camion
     * @return \Illuminate\View\View
     */
    public function edit(Camion $camion)
    {
        return view('livewire.camions.edit', compact('camion')); // Return the form view for editing a camion
    }

    /**
     * Update the specified camion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Camion  $camion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Camion $camion)
    {
        // Validate the request
        $request->validate([
            'matricule' => 'required|string|max:191|unique:camions,matricule,' . $camion->id,
            'antérieure_matricule' => 'required|string|max:100|unique:camions,antérieure_matricule,' . $camion->id,
            'camion_title' => 'required|string|max:255',
            'modele' => 'nullable|string',
            'type' => 'nullable|string',
            'date_imma' => 'required|date',
            'date_mec' => 'nullable|date',
            'genre' => 'nullable|string',
            'marque' => 'nullable|string',
            'type_carburant' => 'nullable|string',
            'numero_chassais' => 'nullable|string',
            'nombre_cylindres' => 'nullable|integer|min:0',
            'PTAC' => 'nullable|numeric|min:0',
            'type_usage' => 'nullable|string',
            'poids_vide' => 'nullable|numeric|min:0',
            'puissance_fiscale' => 'nullable|numeric|min:0',
            'images.*' => 'image|max:1024',
         ]);

         // Update the camion
            $camion->update($request->except('images')); // Exclude images from the camion update

            // Handle the image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Generate a unique name for each image
                    $imageName = time() . '_' . \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();
                    // Move the image to the specified folder
                    $image->move(public_path('storage/images/camions/'), $imageName);
                    // Save the image path in the 'images' table with the associated 'camion_id'
                    Images::create([
                        'image_path' => 'images/camions/' . $imageName,
                        'camion_id' => $camion->id, // Lier l'image au camion
                    ]);
                }
            }


        return redirect()->route('camions.index')->with('success', 'Camion updated successfully.');
    }

    /**
     * Remove the specified camion from storage.
     *
     * @param  Camion  $camion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Camion $camion)
    {
        // Delete images associated with the camion
        $camion->images()->delete(); // Ensure to delete images before deleting the camion

        $camion->delete(); // Delete the camion

        return redirect()->route('camions.index')->with('success', 'Camion deleted successfully.');
    }
}
