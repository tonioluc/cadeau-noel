<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailChoixValide extends Model
{
    protected $table = 'detail_choix_valide';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;

    protected $guarded = [];

    public function choix(): BelongsTo
    {
        return $this->belongsTo(ChoixValide::class, 'id_choix');
    }

    public function cadeau(): BelongsTo
    {
        return $this->belongsTo(Cadeau::class, 'id_cadeau');
    }
}
