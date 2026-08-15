<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterBidang extends Model
{
    protected $table = 'ep_parameter_bidangs';
    protected $primaryKey = 'id';

    public function getParent() {
        if($this->parent_kode != null){
            return ParameterBidang::where('kode', $this->parent_kode)->first();
        } else {
            return null;
        }
    }
}
