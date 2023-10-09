<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('request_money', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('sender_id')->default(0);
                $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('receiver_id')->default(0);
                $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
                $table->enum('status',['success','fail','decline','approved','pending'])->nullable();

                $table->string('message')->nullable();
                $table->decimal('amount',8,2)->default(0);
                $table->string('transaction_number')->nullable();
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
        Schema::table('request_money', function (Blueprint $table) {
            //
        });
    }
}
