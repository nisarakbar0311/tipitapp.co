<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";
    protected $guarded = ['id'];

    public function getUser(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
