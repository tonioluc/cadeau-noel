<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cadeau extends Model
{
    protected $table = 'cadeau';
    protected $primaryKey = 'id_cadeau';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'prix' => 'decimal:2',
        'date_ajout' => 'datetime',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(CategorieCadeau::class, 'id_categorie_cadeau');
    }
}
