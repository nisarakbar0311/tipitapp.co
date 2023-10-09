<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserBankDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userBank', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('user_id')->default(0);
           $table->unsignedBigInteger('widraw_id')->default(0);
           $table->string('bank_id')->default(0);
           $table->string('bank_routing_no')->nullable();
           $table->string('account_no')->nullable();
           $table->string('account_holder_name')->nullable();
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
        Schema::table('userBank', function (Blueprint $table) {
            //
        });
    }
}
