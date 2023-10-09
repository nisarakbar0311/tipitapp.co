<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    protected $table  = "widrawrequest";
    protected $guarded = ['id'];

    public function getUserName(){
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();;
    }

    
    

    public function getMetaInfo(){
        return $this->hasOne(UserBank::class,'widraw_id','id');
    }
}
