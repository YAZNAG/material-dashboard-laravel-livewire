<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camion extends Model
{
    use HasFactory;

    // Define the table if it doesn't follow Laravel's naming convention
    protected $table = 'camions';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'matricule',
        'antérieure_matricule',
        'camion_title',
        'modele',
        'type',
        'date_imma',
        'date_mec',
        'genre',
        'marque',
        'type_carburant',
        'numero_chassais',
        'nombre_cylindres',
        'ptac',
        'type_usage',
        'poids_vide',
        'puissance_fiscale',
    ];

    // Relationships

    /**
     * Get the images associated with the camion.
     */
    public function images()
        {
            return $this->hasMany(Images::class);
    }

    /**
     * Get the cart grises associated with the camion.
     */
    public function cartGrises()
    {
        return $this->hasMany(CartGrise::class);
    }

    /**
     * Get the cart autorisations associated with the camion.
     */
    public function cartAutorisations()
    {
        return $this->hasMany(CartAutorisation::class);
    }

    /**
     * Get the assurances associated with the camion.
     */
    public function assurances()
    {
        return $this->hasMany(Assurance::class);
    }

    /**
     * Get the special annual taxes associated with the camion.
     */
    public function taxesSpecialeAnnuelles()
    {
        return $this->hasMany(TaxeSpecialeAnnuel::class);
    }

    /**
     * Get the visits associated with the camion.
     */
    public function visites()
    {
        return $this->hasMany(Visite::class);
    }
}
