<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterJabatan extends Model
{
    protected $guarded = ["id"];

    protected $table = 'ek_master_jabatans'; 

    protected $with = [
        'atasan',
        'bawahan'
    ];

    protected $casts = [
        'fungsi' => 'array',
        'tugas_pokok' => 'array'
    ];

    public function atasan() : BelongsTo {
        return $this->belongsTo(MasterJabatan::class, 'atasan_id');
    }

    public function bawahan() : BelongsTo {
        return $this->belongsTo(MasterJabatan::class, 'bawahan_id');
    }

    public function staffs() : HasMany {
        return $this->hasMany(User::class, 'master_jabatan_id');
    }
}
