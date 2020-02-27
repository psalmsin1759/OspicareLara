<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabourPartographTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labour_partograph', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("fetal_heart_rate")->nullable();
            $table->unsignedinteger("cervix")->nullable();
            $table->unsignedInteger("descent")->nullable();
            $table->text("liquor")->nullable();
            $table->string("moulding")->nullable();
            $table->unsignedinteger("contraction_per_10_min")->nullable();
            $table->unsignedInteger("oxytocin")->nullable();
            $table->string("ul")->nullable();
            $table->unsignedinteger("drops_per_min")->nullable();
            // $table->boolean("blood_pressure")->default(false);
            $table->string("systolic")->nullable();
            $table->string("diastolic")->nullable();
            $table->float("temperature")->nullable();
            $table->unsignedInteger("heartrate")->nullable();
            // $table->unsignedInteger("urine")->default('0');
            $table->float("urine_amount")->nullable();
            $table->float("protein")->nullable();
            $table->float("acetone")->nullable();
            $table->longText("assessment")->nullable();
            $table->longText("actions")->nullable();
            $table->longText("recommendation")->nullable();
            $table->dateTimeTz("next_assessment")->nullable();

            $table->unsignedInteger("patient_id");
            $table->foreign("patient_id")->references('id')->on('patient')->onDelete('cascade');


            $table->unsignedInteger("hospital_id");
            $table->foreign("hospital_id")->references('id')->on('hospital')->onDelete('cascade');

            $table->unsignedInteger("doctor_id");
            $table->foreign("doctor_id")->references('id')->on('doctor')->onDelete('cascade');

            $table->unsignedInteger("hospital_admin_id");
            $table->foreign("hospital_admin_id")->references('id')->on('hospital_admin')->onDelete('cascade');

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
        Schema::dropIfExists('labour_partograph');
    }
}
