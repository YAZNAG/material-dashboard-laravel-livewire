<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assurance extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's conventions
    protected $table = 'assurances';

    // Fillable attributes for mass assignment
    protected $fillable = [
            'camion_id',
            'numero_police',
            'montant',
            'date_debut',
            'date_fin',
            'entreprise_assurence',
            'intermediaire',
            'assurence_image',
            'numero_ordre', // Ajouter ici
        ];
    /**
     * Get the camion associated with the assurance.
     */
    public function camion()
    {
        return $this->belongsTo(Camion::class); // Relationship with the Camion model
    }
}
