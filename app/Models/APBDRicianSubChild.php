<?php

namespace App\Models;

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\ParameterKas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class APBDRicianSubChild extends Model
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

    protected $table = 'ep_apbd_rincian_sub_children';
    protected $guarded = ["id"];

    public function kas() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'kas_id');
    }

    public function apbd() : BelongsTo {
        return $this->belongsTo(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
    }

    public function apbdsu() : BelongsTo {
        return $this->belongsTo(APBDRincianSubUtama::class, 'apbdsu_id');
    }

    public function apbdcd() : HasMany {
        return $this->hasMany(APBDRicianChildDetail::class, 'apbdsc_id');
    }
}
