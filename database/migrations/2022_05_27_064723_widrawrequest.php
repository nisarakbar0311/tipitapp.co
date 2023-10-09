<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Widrawrequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widrawrequest', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('user_id')->default(0);
           $table->decimal('amount',8,2)->default(0);
           $table->string('transaction_no')->nullable();
           $table->string('transaction_number')->nullable();//for admin use
           $table->timestamp('transaction_date')->nullable();
           $table->enum('withdraw_status',['pending','approve','decline'])->default('pending');
           $table->timestamp('request_date')->nullable();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('widrawrequest', function (Blueprint $table) {
            //
        });
    }
}
