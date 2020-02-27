<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecommendationEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("recommendation", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");


            $table->unsignedInteger("doctor_id");
            $table->foreign("doctor_id")->references('id')->on('doctor')->onDelete('cascade');


            $table->unsignedInteger("patient_id");
            $table->foreign("patient_id")->references('id')->on('patient')->onDelete('cascade');


            $table->string("title",200)->nullable();

            $table->text("body")->nullable();

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
        Schema::dropIfExists('recommendation');
    }
}
