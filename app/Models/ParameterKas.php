<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterKas extends Model
{
    protected $table = 'ep_parameter_kas';
    protected $guarded = ["id"];

    public function getParent() {
        if($this->parent_kode != null){
            return ParameterKas::where('kode', $this->parent_kode)->first();
        } else {
            return null;
        }
    }
}
