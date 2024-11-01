<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camion extends Model
{
    use HasFactory;

    protected $table = 'camions';

    protected $fillable = [
        'matricule',
        'antérieure_matricule',
        'camion_title',
        'modele',
        'type',
        'date_imma',
        'date_mec',
        'genre',
        'marque',
        'type_carburant',
        'numero_chassais',
        'nombre_cylindres',
        'ptac',
        'type_usage',
        'poids_vide',
        'puissance_fiscale',
        'totalKilometrage',
        'kilometrageApresDernierVidange',
    ];

    // Relations

     public function images()
       {
           return $this->hasMany(Images::class);
       }

       /**
        * Get the cart grises associated with the camion.
        */
       public function cartGrises()
       {
           return $this->hasMany(CartGrise::class);
       }

       /**
        * Get the cart autorisations associated with the camion.
        */
       public function cartAutorisations()
           {
               return $this->hasMany(CartAutorisation::class, 'camion_id');
           }

       /**
        * Get the assurances associated with the camion.
        */
       public function assurances()
       {
           return $this->hasMany(Assurance::class);
       }

       /**
        * Get the special annual taxes associated with the camion.
        */
       public function taxesSpecialeAnnuelles()
       {
           return $this->hasMany(TaxeSpecialeAnnuelle::class);
       }

       /**
        * Get the visits associated with the camion.
        */
       public function visites()
       {
           return $this->hasMany(Visite::class);
       }

       public function necessiteVidange()
           {
               // Par exemple, on suppose qu'une vidange est nécessaire tous les 10 000 km
               $seuilVidange = 10000;

               return $this->kilometrageApresDernierVidange >= $seuilVidange;
           }
}
