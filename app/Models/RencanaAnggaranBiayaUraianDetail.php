<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RencanaAnggaranBiayaUraianDetail extends Model
{
    protected $table = 'ep_rencana_anggaran_biaya_uraian_details';
    protected $guarded = ["id"];

    public function uraian() : BelongsTo {
        return $this->belongsTo(RencanaAnggaranBiayaUraian::class, 'rabu_id');
    }
}
