<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxeSpecialeAnnuelle extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's conventions
    protected $table = 'taxe_speciale_annuelle';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'annee',                // Year for the tax
        'trache',               // Tax bracket or tranche
        'montant_principal',    // Principal amount of the tax
        'penalite',             // Penalty (if any)
        'majorations',          // Additional charges (if any)
        'montant_total',        // Total amount to be paid
        'date_paiement',        // Payment date (optional)
        'camion_id',            // Foreign key referencing the Camion model
        'taxe_image',           // Image of the tax document (optional)
    ];

    /**
     * Get the camion associated with the tax.
     */
    public function camion()
    {
        return $this->belongsTo(Camion::class); // Relationship with the Camion model
    }
}
