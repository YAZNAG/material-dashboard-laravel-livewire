<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $table = 'images';

    protected $fillable = [
        'camion_id',
        'image_path'
    ];

  public $timestamps = false;


    public function camion(){
        return $this->belongsTo(camion::class, 'camion_id');
    }
}
