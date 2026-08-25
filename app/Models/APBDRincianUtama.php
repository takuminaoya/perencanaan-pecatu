<?php

namespace App\Models;

use App\Models\APBDRincianSubUtama;
use App\Models\ParameterKas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class APBDRincianUtama extends Model
{
    protected $table = 'ep_apbd_rincian_utamas';
    protected $guarded = ["id"];

    public function apbdrsu() : HasMany {
        return $this->hasMany(APBDRincianSubUtama::class, 'apbdru_id');
    }

    public function kas() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'kas_id');
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
