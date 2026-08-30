<?php

namespace App\Models;

use App\Models\APBDRincianSubUtama;
use App\Models\ParameterKas;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class APBDRincianUtama extends Model
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

    protected $table = 'ep_apbd_rincian_utamas';
    protected $guarded = ["id"];

    public function apbdrsu() : HasMany {
        return $this->hasMany(APBDRincianSubUtama::class, 'apbdru_id');
    }

    public function apbdcd() : HasMany {
        return $this->hasMany(APBDRicianChildDetail::class, 'apbdru_id');
    }

    public function kas() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'kas_id');
    }

    public function bidang() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'bidang_id');
    }

    public function dibuatOleh() : BelongsTo {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function apbd() : BelongsTo {
        return $this->belongsTo(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
    }

    public function apbdm() : BelongsTo {
        return $this->belongsTo(APBDDetailMain::class, 'apbdm_id');
    }

    public function apbdsm() : BelongsTo {
        return $this->belongsTo(APBDDetailSubMain::class, 'apbdsm_id');
    }
}
