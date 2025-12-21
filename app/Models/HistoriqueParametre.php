<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriqueParametre extends Model
{
    protected $table = 'historique_parametres';
    protected $primaryKey = 'id_historique_parametre';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'date_modification' => 'datetime',
    ];

    public function parametre(): BelongsTo
    {
        return $this->belongsTo(Parametre::class, 'id_parametre');
    }
}
