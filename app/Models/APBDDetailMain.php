<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class APBDDetailMain extends Model
{
    protected $table = 'ep_apbd_detail_mains';
    protected $guarded = ["id"];

    public function apbd() : BelongsTo {
        return $this->belongsTo(AnggaranPendapatanBelanjaDesa::class, 'apbd_id');
    }

    public function kas() : BelongsTo {
        return $this->belongsTo(ParameterKas::class, 'kas_id');
    }

    public function subs() : HasMany {
        return $this->hasMany(APBDDetailSubMain::class, 'apbdm_id');
    }

    public function apbdru() : HasMany {
        return $this->hasMany(APBDRincianUtama::class, 'apbdm_id');
    }
}
