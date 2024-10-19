<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermisController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'chauffeur_id' => 'required|exists:chauffeurs,id',
            'type_permis' => 'required|string',
            'image_permis' => 'required|image',
            'date_delivration' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_delivration',
        ]);

        // Enregistrement de l'image
        $imagePath = $request->file('image_permis')->store('permis_images', 'public');

        Permis::create([
            'chauffeur_id' => $validatedData['chauffeur_id'],
            'type_permis' => $validatedData['type_permis'],
            'image_permis' => $imagePath,
            'date_delivration' => $validatedData['date_delivration'],
            'date_fin' => $validatedData['date_fin'],
        ]);

        return redirect()->route('chauffeurs.show', $validatedData['chauffeur_id'])->with('success', 'Permis créé avec succès.');
    }

}
