<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RencanaAnggaranBiayaUraian extends Model
{
    protected $table = 'ep_rencana_anggaran_biaya_uraians';
    protected $guarded = ["id"];

    public function rabb() : BelongsTo {
        return $this->belongsTo(RencanaAnggaranBiayaBidang::class, 'rabb_id');
    }

    public function rabud() : HasMany {
        return $this->hasMany(RencanaAnggaranBiayaUraianDetail::class, 'rabu_id');
    }
}
