<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parametre extends Model
{
    protected $table = 'parametres';
    protected $primaryKey = 'id_parametre';
    public $timestamps = false;

    protected $guarded = [];

    public function historiques(): HasMany
    {
        return $this->hasMany(HistoriqueParametre::class, 'id_parametre');
    }
}
