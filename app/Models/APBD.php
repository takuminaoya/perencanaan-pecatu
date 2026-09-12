<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class APBD extends Model
{
    
    protected $table = 'ep_apbds';
    protected $guarded = ["id"];

    public function kasFlows() : HasMany {
        return $this->hasMany(APBDKasFlow::class, 'apbd_id');
    }

    public function perubahans() : HasMany {
        return $this->hasMany(APBDPerubahan::class, 'apbd_id');
    }
}
