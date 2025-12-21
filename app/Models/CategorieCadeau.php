<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorieCadeau extends Model
{
    protected $table = 'categorie_cadeau';
    protected $primaryKey = 'id_categorie_cadeau';
    public $timestamps = false;

    protected $guarded = [];

    public function cadeaux(): HasMany
    {
        return $this->hasMany(Cadeau::class, 'id_categorie_cadeau');
    }
}
