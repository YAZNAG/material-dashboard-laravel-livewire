<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'type',
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'contrat_id',
    ];

    // Relation avec le modèle Contrat
    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id');
    }

    // Validation des règles pour les clients
    public static function rules()
    {
        return [
            'type' => 'required|in:personne,societe',
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email',
            'telephone' => 'required|string|max:50',
            'adresse' => 'required|string',
            'contrat_id' => 'nullable|exists:contrats,id',
        ];
    }
}
