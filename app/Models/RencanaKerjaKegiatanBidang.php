<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RencanaKerjaKegiatanBidang extends Model
{
    protected $table = 'ep_rencana_kerja_kegiatan_bidangs';
    protected $guarded = ["id"];


    public function rkp() : BelongsTo {
        return $this->belongsTo(RencanaKerjaKegiatan::class, 'rkp_id');
    }

    public function bidang() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'bidang_id');
    }

    public function kegiatans() : HasMany {
        return $this->hasMany(RencanaKerjaKegiatanBidangDetail::class, 'bidang_id');
    }
}
