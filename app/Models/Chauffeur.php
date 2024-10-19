<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chauffeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',                     // Nom du chauffeur
        'prenom',                  // Prénom du chauffeur
        'cin',                     // Numéro de carte d'identité
        'cin_image',               // Chemin vers l'image de la carte d'identité
        'certificat_medical_image',// Chemin vers l'image du certificat médical
        'date_naissance',          // Date de naissance
        'telephone',               // Numéro de téléphone
        'adresse',                 // Adresse
    ];
   public function contrats()
      {
          return $this->hasMany(Contrat::class);
      }


    public function trajets() {
        return $this->hasMany(Trajet::class);
    }

    public function permis()
       {
           return $this->hasMany(Permis::class);

       }

}
