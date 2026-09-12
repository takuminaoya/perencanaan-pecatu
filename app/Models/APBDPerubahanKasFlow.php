<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class APBDPerubahanKasFlow extends Model
{
    protected $table = 'ep_apbd_perubahan_kas_flows';
    protected $guarded = ["id"];
    protected $casts = [
        'detail_paket' => 'array'
    ];

    public function perubahan() : BelongsTo {
        return $this->belongsTo(APBDPerubahan::class, 'perubahan_id');
    }

    public function kas_flow() : BelongsTo {
        return $this->belongsTo(APBDKasFlow::class, 'kas_flow_id');
    }
}
