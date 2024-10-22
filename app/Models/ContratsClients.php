<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratsClients extends Model
{
    protected $table = 'contrats_clients';

    protected $fillable = [
        'client_id',
        'contrat_id',
        'date_debut',
        'date_fin',
        'contrat_pdf', // Assurez-vous d'inclure le PDF
    ];

    // Un ContratsClients appartient à un client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
