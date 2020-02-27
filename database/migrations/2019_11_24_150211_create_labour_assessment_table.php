<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabourAssessmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labour_assessment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bp')->nullable();
            $table->string('heart_rate')->nullable();
            $table->string('temperature')->nullable();
            $table->string('respiration')->nullable();
            $table->string('o2_saturation')->nullable();
            $table->string('symphisotudal_height')->nullable();
            $table->string('lie')->nullable();
            $table->string('presentation')->nullable();
            $table->string('position')->nullable();
            $table->string('descent')->nullable();
            $table->string('fetal_heart_rate')->nullable();

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
        Schema::dropIfExists('labour_assessment');
    }
}
