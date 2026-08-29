<?php

namespace App\Models;

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\APBDDetailSubMain;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class APBDRincianSubUtama extends Model
{

    /** 
     * Urutan
     * 1. APBD
     * 2. APBD Detail Main
     * 3. APBD Detail Sub Main
     * 4. APBD Detail Sub
     * 5. APBD Rincian Utama
     * 6. APBD Rincian Sub Utama
     * 7. APBD Rincian Sub Child
     * 8. APBD Rincian Child Detail
    */
    
    protected $table = 'ep_apbd_rincian_sub_utamas';
    protected $guarded = ["id"];

    public function groupOfSubUtama($apbd_id) {
        return DB::table('ep_apbd_rincian_sub_utamas')
            ->select('apbdsm_id')
            ->where('apbd_id', $apbd_id)
            ->groupBy('apbdsm_id')
            ->get();
    }

    
    public function apbd() : BelongsTo {
        return $this->belongsTo(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
    }

    public function kas() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'kas_id');
    }

    public function bidang() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'bidang_id');
    }

    public function kegiatan() : BelongsTo {
        return $this->belongsTo(ParameterKegiatan::class, 'kegiatan_id');
    }

    public function apbdru() : BelongsTo {
        return $this->belongsTo(APBDRincianUtama::class, 'apbdru_id');
    }

    public function apbdsm() : BelongsTo {
        return $this->belongsTo(APBDDetailSubMain::class, 'apbdsm_id');
    }

    public function apbdsb() : BelongsTo {
        return $this->belongsTo(APBDDetailSub::class, 'apbdsb_id');
    }

    public function apbdsc() : HasMany {
        return $this->hasMany(APBDRicianSubChild::class, 'apbdsu_id');
    }

    public function apbdcd() : HasMany {
        return $this->hasMany(APBDRicianChildDetail::class, 'apbdrsu_id');
    }
}
