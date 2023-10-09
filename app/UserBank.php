<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    protected $table  = "userBank";
    protected $guarded = ['id'];

    public function getBankName(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }
}
