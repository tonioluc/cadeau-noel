<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommissionSite extends Model
{
    protected $table = 'commission_site';
    protected $primaryKey = 'id_commission';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'montant_commission' => 'decimal:2',
        'date_commission' => 'datetime',
    ];

    public function depot(): BelongsTo
    {
        return $this->belongsTo(Depot::class, 'id_depot');
    }
}
