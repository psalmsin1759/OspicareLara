<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WalletEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("wallet", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->unsignedInteger("amount");

            $table->unsignedInteger("hospital_id");
            $table->foreign("hospital_id")->references('id')->on('hospital')->onDelete('cascade');

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
        Schema::drop("wallet");
    }
}
