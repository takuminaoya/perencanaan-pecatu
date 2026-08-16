<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RencanaAnggaranBiayaBidang extends Model
{
    protected $table = 'ep_rencana_anggaran_biaya_bidangs';
    protected $guarded = ["id"];

    public function uraians() : HasMany {
        return $this->hasMany(RencanaAnggaranBiayaUraian::class, 'rabb_id');
    }

    public function rkkbd() : BelongsTo {
        return $this->belongsTo(RencanaKerjaKegiatanBidangDetail::class, 'rkkbd_id');
    }
}
