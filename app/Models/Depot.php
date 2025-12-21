<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Depot extends Model
{
    protected $table = 'depot';
    protected $primaryKey = 'id_depot';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'montant_demande' => 'decimal:2',
        'montant_credit' => 'decimal:2',
        'commission_applique' => 'decimal:2',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function statut(): BelongsTo
    {
        return $this->belongsTo(StatutDepot::class, 'id_statut_depot');
    }

    public function commission(): HasOne
    {
        return $this->hasOne(CommissionSite::class, 'id_depot');
    }

    public function historiques(): HasMany
    {
        return $this->hasMany(HistoriqueStatutDepot::class, 'id_depot');
    }
}
