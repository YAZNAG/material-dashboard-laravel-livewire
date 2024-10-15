<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    // Si le nom de la table n'est pas 'contracts' par défaut, spécifiez-le ici
    protected $table = 'contracts';  // Facultatif, si votre table est bien nommée 'contracts'

    // Champs modifiables via des affectations de masse
    protected $fillable = [
        'chauffeur_id',   // Référence à l'ID du chauffeur
        'date_debut',     // Date de début du contrat
        'date_fin',       // Date de fin du contrat
        'salaire',        // Salaire ou rémunération du chauffeur
        'description',    // Description du contrat ou des conditions
        'contrat_pdf'     // Fichier PDF du contrat
    ];

    // Relation avec le modèle Chauffeur
    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }

    // Fonction pour vérifier si un contrat est actif
    public function estActif()
    {
        return \Carbon\Carbon::now()->lessThanOrEqualTo($this->date_fin);
    }
}
