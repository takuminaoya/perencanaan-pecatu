<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class RencanaAnggaranBiaya extends Model
{
    use SoftDeletes;

    protected $table = 'ep_rencana_anggaran_biayas';
    protected $guarded = ["id"];

    public function groupOfMainBidang() {
        return DB::table('ep_rencana_anggaran_biaya_bidangs')
            ->select('main_bidang_id')
            ->where('rab_id', $this->id)
            ->groupBy('main_bidang_id')
            ->get(); 
    }

    public function rabBidangs() : HasMany {
        return $this->hasMany(RencanaAnggaranBiayaBidang::class, 'rab_id');
    }

    public function apbd() : BelongsTo {
        return $this->belongsTo(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
    }
}
