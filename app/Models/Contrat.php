<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'chauffeur_id',
        'salaire',
        'date_debut',              // Date de début du contrat
        'date_fin',                // Date de fin du contrat
        'contrat_pdf',             // Chemin vers le PDF du contrat
    ];

    // Relation avec le modèle Chauffeur
    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }
}
