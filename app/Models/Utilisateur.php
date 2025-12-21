<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Utilisateur extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id_utilisateur';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'solde' => 'decimal:2',
        'date_creation' => 'datetime',
    ];

    public function depots(): HasMany
    {
        return $this->hasMany(Depot::class, 'id_utilisateur');
    }

    public function choixValides(): HasMany
    {
        return $this->hasMany(ChoixValide::class, 'id_utilisateur');
    }
}
