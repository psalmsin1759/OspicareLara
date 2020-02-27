<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LabourVaginalExamination extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labour_vaginal_examination', function (Blueprint $table) {
            $table->increments('id');
            $table->text("remark")->nullable();


            $table->unsignedInteger("pelvic_assess_req")->default(0);

            $table->string("cervical_dilation", 20)->nullable();

            $table->string("impression", 20)->nullable();

            $table->string("plan", 20)->nullable();


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

        DB::table('labour_vaginal_examination')->insert(
            array(
                "remark" => "looking good",
                "pelvic_assess_req" => 1,
                "cervical_dilation" => "2.7",
                "impression" => "Healthy pulsations",
                "patient_id" => 4,
                "hospital_id" => 1,
                "doctor_id" => 3,
                "hospital_admin_id" => 1,
                "patient_type_id" => 2
            )
        );

        DB::table('labour_vaginal_examination')->insert(
            array(
                "remark" => "satisfactory",
                "pelvic_assess_req" => 0,
                "cervical_dilation" => "4.2",
                "impression" => "Almost time",
                "patient_id" => 3,
                "hospital_id" => 1,
                "doctor_id" => 3,
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
        Schema::dropIfExists('labour_vaginal_examination');
    }
}
