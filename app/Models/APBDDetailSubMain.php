<?php

namespace App\Models;

use App\Models\AnggaranPendapatanBelanjaDesa;
use App\Models\APBDDetailSub;
use App\Models\ParameterKas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class APBDDetailSubMain extends Model
{
    protected $table = 'ep_apbd_detail_sub_mains';
    protected $guarded = ["id"];

    public function apbd() : BelongsTo {
        return $this->belongsTo(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
    }

    public function kas() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'parameter_kas_id');
    }

    public function main() : BelongsTo {
        return $this->belongsTo(APBDDetailMain::class, 'apbdm_id');
    }

    public function subs() : HasMany {
        return $this->hasMany(APBDDetailSub::class, 'apbdsm_id');
    }

    public function totalSum($tipe = 'semula') {
        return APBDRincianSubUtama::where('apbdsm_id', $this->id)->sum($tipe);
    }
}
