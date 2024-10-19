<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permis extends Model
{
    use HasFactory;

    protected $fillable = [
        'chauffeur_id',            // Référence à l'ID du chauffeur
        'type_permis',             // Type de permis
        'image_permis',            // Chemin vers l'image du permis
        'date_delivration',        // Date de délivrance du permis
        'date_fin',                // Date de fin de validité du permis
    ];

    // Relation avec le modèle Chauffeur
    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }
}
