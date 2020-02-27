<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDischargeSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discharge_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mother_bp')->nullable();
            $table->string('mother_hr')->nullable();
            $table->string('mother_temperature')->nullable();
            $table->string('mother_respiration')->nullable();
            $table->string('mother_saturation')->nullable();
            
            $table->string('baby_bp')->nullable();
            $table->string('baby_saturation')->nullable();
            $table->string('baby_hr')->nullable();
            $table->string('baby_temperature')->nullable();
            $table->string('baby_respiration')->nullable();

            $table->dateTime('next_appointment')->nullable();

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
        Schema::dropIfExists('discharge_summary');
    }
}
