<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Class_;

class Wallet extends Model
{
    protected $table = 'wallet';
    protected $guarded = ["id"];

    public function getWithDrawTransaction(){
        return $this->belongsTo(WithdrawRequest::class,'transaction_no','transaction_no');
    }
}
