<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nom',
        'type',
        'email',
        'telephone',
        'adresse',
    ];

    // Un Client a plusieurs contrats
    public function contratsClients()
    {
        return $this->hasMany(ContratsClients::class);
    }


}
