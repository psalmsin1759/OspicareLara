<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GeneralHealth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_health', function (Blueprint $table) {
            $table->increments('id');
            $table->string("temperature_value",10)->nullable();
            $table->string("temperature_value_score",10)->nullable();

            $table->string("heart_rate_value",10)->nullable();
            $table->string("heart_rate_value_score",10)->nullable();

            $table->string("systolic_pressure_score",10)->nullable();
            $table->string("systolic_pressure_value",10)->nullable();

            $table->string("diastolic_pressure_score",10)->nullable();
            $table->string("diastolic_pressure_value",10)->nullable();

            $table->string("respiratory_rate_value",10)->nullable();
            $table->string("respiratory_rate_value_score",10)->nullable();

            $table->string("saturation_scale_one_value",10)->nullable();
            $table->string("saturation_scale_one_score",10)->nullable();

            $table->string("saturation_scale_two_value",10)->nullable();
            $table->string("saturation_scale_two_score",10)->nullable();

            $table->string("alertness_value",10)->nullable();
            $table->string("alertness_value_score",10)->nullable();

            $table->string("is_action_taken",10)->nullable();

            $table->text("action_taken")->nullable();



            $table->unsignedInteger("hospital_id");
            $table->foreign("hospital_id")->references('id')->on('hospital')->onDelete('cascade');

            $table->unsignedInteger("hospital_admin_id");
            $table->foreign("hospital_admin_id")->references('id')->on('hospital_admin')->onDelete('cascade');

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
        Schema::dropIfExists('general_health');
    }
}
