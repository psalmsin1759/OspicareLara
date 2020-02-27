<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Antenatal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("antenatal", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");

            $table->text("Impression")->nullable();

            $table->text("Investigation")->nullable();

            $table->text("Complaints")->nullable();

            $table->text("ActionTaken")->nullable();

            $table->string("request_review",10)->nullable();


            $table->unsignedInteger("patient_id");
            $table->foreign("patient_id")->references('id')->on('patient')->onDelete('cascade');


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
        Schema::dropIfExists('antenatal');
    }
}
