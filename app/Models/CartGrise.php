<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartGrise extends Model
{
    use HasFactory;

     protected $table = 'cart_grise';
    // Fillable attributes for mass assignment
    protected $fillable = [
        'camion_id',         // Foreign key referencing the Camion model
        'image_path',        // Image path for the carte grise
        'date_fin',          // Expiration date for the carte grise
    ];

    /**
     * Get the camion associated with the carte grise.
     */
    public function camion()
    {
        return $this->belongsTo(Camion::class); // Relationship with the Camion model
    }
}
