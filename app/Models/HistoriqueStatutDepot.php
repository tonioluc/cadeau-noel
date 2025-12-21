<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriqueStatutDepot extends Model
{
    protected $table = 'historique_statut_depot';
    protected $primaryKey = 'id_historique';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'date_changement' => 'datetime',
    ];

    public function depot(): BelongsTo
    {
        return $this->belongsTo(Depot::class, 'id_depot');
    }

    public function statut(): BelongsTo
    {
        return $this->belongsTo(StatutDepot::class, 'id_statut_depot');
    }
}
