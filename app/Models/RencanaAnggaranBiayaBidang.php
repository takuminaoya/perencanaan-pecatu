<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class RencanaAnggaranBiayaBidang extends Model
{
    protected $table = 'ep_rencana_anggaran_biaya_bidangs';
    protected $guarded = ["id"];

    public function uraians() : HasMany {
        return $this->hasMany(RencanaAnggaranBiayaUraian::class, 'rabb_id');
    }

    public function uraian_details() : HasMany {
        return $this->hasMany(RencanaAnggaranBiayaUraianDetail::class, 'rabb_id');
    }

    public function apbd() : BelongsTo {
        return $this->belongsTo(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
    }

    public function apbdrsu() : BelongsTo {
        return $this->belongsTo(APBDRincianSubUtama::class, 'apbdrsu_id');
    }

    public function main() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'main_bidang_id');
    }

    public function ssub() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'sub_bidang_id');
    }

    public function skegiatan() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'bidang_id');
    }
}
