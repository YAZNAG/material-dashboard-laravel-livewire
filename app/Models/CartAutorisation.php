<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAutorisation extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow Laravel's conventions
    protected $table = 'cart_autorisation';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'camion_id',      // Foreign key referencing the Camion model
        'image_path',     // Image path for the autorisation
        'date_debut',     // Start date for the autorisation
        'date_fin',       // Expiration date for the autorisation
    ];

    /**
     * Get the camion associated with the autorisation.
     */
    public function camion()
    {
        return $this->belongsTo(Camion::class); // Relationship with the Camion model
    }
}
