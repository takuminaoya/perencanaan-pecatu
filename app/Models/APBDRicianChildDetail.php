<?php

namespace App\Models;

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\MasterJabatan;
use App\Models\ParameterKas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class APBDRicianChildDetail extends Model
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

    protected $table = 'ep_apbd_rincian_child_details';
    protected $guarded = ["id"];

    public function jabatan() : BelongsTo {
        return $this->belongsTo(MasterJabatan::class, 'pelaksana_id');
    }

    public function apbdru() : BelongsTo {
        return $this->belongsTo(APBDRincianUtama::class, 'apbdru_id');
    }

    public function kas() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'kas_id');
    }

    public function sumber() : BelongsTo {
        return $this->belongsTo(ParameterSumberDana::class, 'sumber_id');
    }

    public function apbd() : BelongsTo {
        return $this->belongsTo(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
    }

    public function main() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'main_id');
    }

    public function sub() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'sub_id');
    }

    public function kegiatan() : BelongsTo {
        return $this->belongsTo(ParameterBidang::class, 'kegiatan_id');
    }
}
