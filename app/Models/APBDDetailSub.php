<?php

namespace App\Models;

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\ParameterKas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class APBDDetailSub extends Model
{
    protected $table = 'ep_apbd_detail_subs';
    protected $guarded = ["id"];

    public function apbd() : BelongsTo {
        return $this->belongsTo(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
    }

    public function kas() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'kas_id');
    }

    public function sub_main() : BelongsTo {
        return $this->belongsTo(APBDDetailSubMain::class, 'apbdsm_id');
    }

    public function totalSum($tipe = 'semula') {
        return APBDRincianSubUtama::where('apbdsb_id', $this->id)->sum($tipe);
    }
}
