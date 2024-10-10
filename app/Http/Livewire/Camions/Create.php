<?php
// app/Http/Livewire/Camions/Create.php
namespace App\Http\Livewire\Camions;

use Livewire\Component;
use App\Models\Camion;

class Create extends Component
{
    public $matricule;
    public $antérieure_matricule;
    public $camion_title;
    public $modele;
    public $type;
    public $date_imma;
    public $date_mec;
    public $genre;
    public $marque;
    public $type_carburant;
    public $numero_chassais;
    public $nombre_cylindres;
    public $ptmct;
    public $type_usage;
    public $poids_vide;
    public $puissance_fiscale;

    protected $rules = [
        'matricule' => 'required|string|max:255',
        'antérieure_matricule' => 'nullable|string|max:255',
        'camion_title' => 'required|string|max:255',
        'modele' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'date_imma' => 'required|date',
        'date_mec' => 'required|date',
        'genre' => 'required|string|max:255',
        'marque' => 'required|string|max:255',
        'type_carburant' => 'required|string|max:255',
        'numero_chassais' => 'required|string|max:255',
        'nombre_cylindres' => 'required|integer',
        'ptmct' => 'required|numeric',
        'type_usage' => 'required|string|max:255',
        'poids_vide' => 'required|numeric',
        'puissance_fiscale' => 'required|numeric',
    ];

    public function createCamion()
    {
        $this->validate();

        Camion::create([
            'matricule' => $this->matricule,
            'antérieure_matricule' => $this->antérieure_matricule,
            'camion_title' => $this->camion_title,
            'modele' => $this->modele,
            'type' => $this->type,
            'date_imma' => $this->date_imma,
            'date_mec' => $this->date_mec,
            'genre' => $this->genre,
            'marque' => $this->marque,
            'type_carburant' => $this->type_carburant,
            'numero_chassais' => $this->numero_chassais,
            'nombre_cylindres' => $this->nombre_cylindres,
            'ptmct' => $this->ptmct,
            'type_usage' => $this->type_usage,
            'poids_vide' => $this->poids_vide,
            'puissance_fiscale' => $this->puissance_fiscale,
        ]);

        session()->flash('message', 'Camion créé avec succès.');

        return redirect()->route('camions.index'); // Redirect to the list page
    }

    public function render()
    {
        return view('livewire.camions.create');
    }
}
