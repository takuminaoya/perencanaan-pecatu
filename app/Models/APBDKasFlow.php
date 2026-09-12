<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class APBDKasFlow extends Model
{
    protected $table = 'ep_apbd_kas_flows';
    protected $guarded = ["id"];
    protected $casts = [
        'detail_paket' => 'array'
    ];

    public function apbd() : BelongsTo {
        return $this->belongsTo(APBD::class, 'apbd_id');
    }

    public function utama() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'utama_id');
    }

    public function subUtama() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'sub_utama_id');
    }

    public function subSutama() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'sub_sutama_id');
    }

    public function subSSutama() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'sub_ssutama_id');
    }

    public function sumberDana() : BelongsTo {
        return $this->belongsTo(ParameterSumberDana::class, 'sumber_id');
    }

    public function perubahans() : HasMany {
        return $this->hasMany(APBDPerubahanKasFlow::class, 'kas_flow_id');
    }

    public function getPerubahanBasedOnPerubahanID($perubahan_id) {
        return APBDPerubahanKasFlow::where('kas_flow_id', $this->id)->where('perubahan_id', $perubahan_id)->first();
    }
}
