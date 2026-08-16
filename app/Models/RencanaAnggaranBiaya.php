<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RencanaAnggaranBiaya extends Model
{
    use SoftDeletes;

    protected $table = 'ep_rencana_anggaran_biayas';
    protected $guarded = ["id"];

    public function rkk() : BelongsTo {
        return $this->belongsTo(RencanaKerjaKegiatan::class, 'rkk_id');
    }

    public function rabBidangs() : HasMany {
        return $this->hasMany(RencanaAnggaranBiayaBidang::class, 'rab_id');
    }
}
