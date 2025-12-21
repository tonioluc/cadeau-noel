<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChoixValide extends Model
{
    protected $table = 'choix_valide';
    protected $primaryKey = 'id_choix';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'montant_total' => 'decimal:2',
        'date_choix' => 'datetime',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailChoixValide::class, 'id_choix');
    }
}
