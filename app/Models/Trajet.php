<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    use HasFactory;

    // Définition des statuts possibles du trajet
    const STATUT_EN_COURS = 'en cours';
    const STATUT_TERMINE = 'terminé';
    const STATUT_ANNULE = 'annulé';

    // Champs mass assignable
    protected $fillable = [
        'titre',
        'prix',
        'kilometrage',
        'camion_id',
        'chauffeur_id',
        'client_id',
        'date_depart',
        'date_arrivee',
        'lieu_depart',
        'lieu_arrivee',
        'statut',
    ];

    /**
     * Relation avec le modèle Camion
     * Un trajet appartient à un camion
     */
    public function camion()
    {
        return $this->belongsTo(Camion::class);
    }

    /**
     * Relation avec le modèle Chauffeur
     * Un trajet appartient à un chauffeur
     */
    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }

    /**
     * Relation avec le modèle Client
     * Un trajet appartient à un client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Vérifie si le trajet est terminé
     *
     * @return bool
     */
    public function estTermine()
    {
        return $this->statut === self::STATUT_TERMINE;
    }

    /**
     * Scope pour récupérer les trajets en cours
     *
     * @param $query
     * @return mixed
     */
    public function scopeEnCours($query)
    {
        return $query->where('statut', self::STATUT_EN_COURS);
    }

    /**
     * Calcul du kilométrage restant avant vidange
     *
     * @return int
     */
    public function kilometrageRestantAvantVidange()
    {
        // Supposons que le camion doit faire une vidange tous les 10,000 km
        $seuilVidange = 10000;

        // Récupérer le camion associé
        $camion = $this->camion;

        // Calculer la distance restant avant la prochaine vidange
        return $seuilVidange - ($camion->totalKilometrage - $camion->kilometrageApresDernierVidange);
    }

    /**
     * Vérifie si une vidange est nécessaire avant d'ajouter un trajet
     *
     * @return bool
     */
    public function necessiteVidange()
    {
        return $this->kilometrageRestantAvantVidange() <= 0;
    }
}
