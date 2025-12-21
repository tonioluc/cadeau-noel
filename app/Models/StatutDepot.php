<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatutDepot extends Model
{
    protected $table = 'statut_depot';
    protected $primaryKey = 'id_statut_depot';
    public $timestamps = false;

    protected $guarded = [];

    public function depots(): HasMany
    {
        return $this->hasMany(Depot::class, 'id_statut_depot');
    }

    public function historiques(): HasMany
    {
        return $this->hasMany(HistoriqueStatutDepot::class, 'id_statut_depot');
    }
}
