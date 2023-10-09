<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestMoney extends Model
{
    protected $table = 'request_money';
    protected $guarded = ['id'];

    public function senderUser(){
        return $this->belongsTo(User::class,'sender_id','id')->withTrashed();;
    }

    public function receiverUser(){
        return $this->belongsTo(User::class,'receiver_id','id')->withTrashed();;
    }
}
