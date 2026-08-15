<?php

namespace App\Models;

use App\Models\RencanaKerjaKegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RencanaKerjaKegiatanBidangDetail extends Model
{
    protected $table = 'ep_rencana_kerja_kegiatan_bidang_details';
    protected $guarded = ["id"];


    public function rkp() : BelongsTo {
        return $this->belongsTo(RencanaKerjaKegiatan::class, 'rkp_id');
    }

    public function bidang() : BelongsTo {
        return $this->belongsTo(RencanaKerjaKegiatanBidang::class, 'bidang_id');
    }

    public function kegiatan() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'kegiatan_id');
    }
}
