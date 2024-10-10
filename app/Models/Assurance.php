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
        'numero_ordre',           // Order number for the insurance
        'date_debut',             // Start date of the insurance
        'date_fin',               // End date of the insurance
        'montant',                // Amount of the insurance
        'entreprise_assurence',   // Insurance company
        'intermediaire',          // Intermediary (optional)
        'assurence_image',        // Image of the insurance document (optional)
        'camion_id',              // Foreign key referencing the Camion model
        'numero_police',          // Policy number (optional)
    ];

    /**
     * Get the camion associated with the assurance.
     */
    public function camion()
    {
        return $this->belongsTo(Camion::class); // Relationship with the Camion model
    }
}
