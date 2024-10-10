<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's conventions
    protected $table = 'visites';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'date_debut',             // Start date of the visit
        'date_fin',               // End date of the visit
        'type',                   // Type of visit
        'numero_autorisation',    // Authorization number (optional)
        'nom_centre',             // Name of the inspection center (optional)
        'address_centre',         // Address of the inspection center (optional)
        'resultat',               // Result of the visit (optional)
        'visite_image',           // Image related to the visit (optional)
        'camion_id',              // Foreign key referencing the Camion model
    ];

    /**
     * Get the camion associated with the visit.
     */
    public function camion()
    {
        return $this->belongsTo(Camion::class); // Relationship with the Camion model
    }
}
