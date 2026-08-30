<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class AnggaranPendapatanBelanjaDesa extends Model
{
    use SoftDeletes;
    
    protected $table = 'ep_anggaran_pendapatan_belanja_desas';
    protected $guarded = ["id"];

    public function mains() : HasMany {
        return $this->hasMany(APBDDetailMain::class, 'apbd_id');
    }

    public function subs() : HasMany {
        return $this->hasMany(APBDDetailSubMain::class, 'apbd_id');
    }

    public function rincianSubUtamas() : HasMany {
        return $this->hasMany(APBDRincianSubUtama::class, 'apbd_id');
    }

    public function groupOfRincianUtama() {
        return DB::table('ep_apbd_rincian_utamas')
            ->select('apbdm_id')
            ->where('apbd_id', $this->id)
            ->groupBy('apbdm_id')
            ->get(); 
    }

    public function groupOfRincianUtamaBasedOnMainBidang() {
        return DB::table('ep_apbd_rincian_utamas')
            ->select('main_id')
            ->where('apbd_id', $this->id)
            ->where('tipe', 'keluar')
            ->groupBy('main_id')
            ->get(); 
    }

    public function rincian_utama() : HasMany {
        return $this->hasMany(APBDRincianUtama::class, 'apbd_id');
    }

    public function rincianBasedOnTipe(string $tipe) {
        $this->rincian_utama()->where('tipe', $tipe)->get();
    }
}
