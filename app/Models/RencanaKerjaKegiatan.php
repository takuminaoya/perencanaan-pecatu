<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class RencanaKerjaKegiatan extends Model
{
    use SoftDeletes;

    protected $table = 'ep_rencana_kerja_kegiatans';
    protected $guarded = ["id"];

    public function rab() : BelongsTo {
        return $this->belongsTo(RencanaAnggaranBiaya::class, 'rab_id');
    }

    public function bidangs() : HasMany {
        return $this->hasMany(RencanaKerjaKegiatanBidang::class, 'rkp_id');
    }

    public function kegiatans() : HasMany {
        return $this->hasMany(RencanaKerjaKegiatanBidangDetail::class, 'rkp_id');
    }
}
