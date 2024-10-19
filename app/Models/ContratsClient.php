<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratsClient extends Model
{
    use HasFactory;

    protected $table = 'contrats_clients';

    protected $fillable = [
        'contrat_id',
        'client_id',
    ];

    // Relation avec le modèle Client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // Relation avec le modèle Contrat
    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id');
    }
}
