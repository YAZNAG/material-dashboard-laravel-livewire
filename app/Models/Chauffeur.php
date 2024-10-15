<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
use App\Models\Trajet;

class Chauffeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'cin',
        'cin_image',
        'certificat_medical_image',
        'permis_image',
        'type_permis',
        'date_naissance',
        'telephone',
        'adresse',
    ];
   public function contrats()
   {
       return $this->hasMany(Contract::class);
   }

    public function trajets()
    {
    return $this->hasMany(Trajet::class);
     }

}
