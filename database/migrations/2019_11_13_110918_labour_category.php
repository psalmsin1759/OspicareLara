<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LabourCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labour_category', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger("risk_status")->default(0);
            $table->string("mode_of_delivery", 30)->nullable();

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

        DB::table('labour_category')->insert(
            array(
                "risk_status" => 2,
                "mode_of_delivery" => "CS",
                "patient_id" => 4,
                "hospital_id" => 1,
                "doctor_id" => 2,
                "hospital_admin_id" => 1,
                "patient_type_id" => 2
            )
        );

        DB::table('labour_category')->insert(
            array(
                "risk_status" => 7,
                "mode_of_delivery" => "Vaginal",
                "patient_id" => 3,
                "hospital_id" => 1,
                "doctor_id" => 2,
                "hospital_admin_id" => 1,
                "patient_type_id" => 2
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
        Schema::dropIfExists('labour_category');
    }
}
