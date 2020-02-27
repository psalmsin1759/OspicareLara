<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MedicalHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("hypertension")->default(0);
            $table->unsignedInteger("previous_hyper_in_preg")->default(0);
            $table->unsignedInteger("diabetes_mellitus")->default(0);
            $table->unsignedInteger("previous_dm_in_preg")->default(0);
            $table->unsignedInteger("heart_disease")->default(0);
            $table->unsignedInteger("pre_eclampsia")->default(0);
            $table->unsignedInteger("still_birth")->default(0);
            $table->unsignedInteger("post_partum_haemorrhage")->default(0);
            $table->unsignedInteger("ante_partum_haemorrhage")->default(0);
            $table->unsignedInteger("two_more_miscarriages")->default(0);
            $table->unsignedInteger("h_macrosomia_45kg")->default(0);
            $table->unsignedInteger("h_low_birth_weight")->default(0);
            $table->unsignedInteger("h_birth_defects")->default(0);
            $table->unsignedInteger("history_of_clot")->default(0);
            $table->unsignedInteger("myomectomy")->default(0);
            $table->unsignedInteger("previous_c_s")->default(0);
            $table->unsignedInteger("number_of_c_s")->default(0);
            $table->unsignedInteger("epileptic")->default(0);
            $table->unsignedInteger("asthmatic")->default(0);

            $table->unsignedInteger("patient_id");
            $table->foreign("patient_id")->references('id')->on('patient')->onDelete('cascade');


            $table->unsignedInteger("hospital_id");
            $table->foreign("hospital_id")->references('id')->on('hospital')->onDelete('cascade');

            $table->unsignedInteger("doctor_id");
            $table->foreign("doctor_id")->references('id')->on('doctor')->onDelete('cascade');

            $table->unsignedInteger("hospital_admin_id");
            $table->foreign("hospital_admin_id")->references('id')->on('hospital_admin')->onDelete('cascade');

            $table->unsignedInteger("patient_type_id");
            $table->foreign("patient_type_id")->references('id')->on('patient_type')->onDelete('cascade');
            $table->timestamps();
        });
	
	DB::table('medical_history')->insert(
            array(
                "patient_id" => 2,
                "hospital_id" => 1,
                "doctor_id" => 2,
                "hospital_admin_id" => 1,
                "patient_type_id" => 2
            )
        );

        DB::table('medical_history')->insert(
            array(
                // "hypertension",
                // "previous_hyper_in_preg",
                // "diabetes_mellitus",
                // "previous_dm_in_preg",
                // "heart_disease",
                // "pre_eclampsia",
                // "still_birth",
                // "post_partum_haemorrhage",
                "patient_id" => 3,
                "hospital_id" => 1,
                "doctor_id" => 3,
                "hospital_admin_id" => 1,
                "patient_type_id" => 3
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_history');
    }
}
