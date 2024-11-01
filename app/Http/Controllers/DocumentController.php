<?php

namespace App\Http\Controllers;

use App\Models\Assurance;
use App\Models\TaxeSpecialeAnnuelle;
use App\Models\Visite;
use App\Models\CartAutorisation;
use Illuminate\Http\Request;
use App\Models\CartGrise;

class DocumentController extends Controller
{
    public function index()
    {
        $assurances = Assurance::all();
        $taxes = TaxeSpecialeAnnuelle::all();
        $visitesTechnique = Visite::all();
        $cartesGrise = CartGrise::all(); // Correction ici, enlevé la parenthèse en trop
        $cartesAutorisation = CartAutorisation::all();

        return view('livewire.camions.documents.index', compact('assurances', 'taxes', 'cartesGrise', 'visitesTechnique', 'cartesAutorisation'));
    }
}
