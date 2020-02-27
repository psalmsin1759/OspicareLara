<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LabourComplaint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labour_complaint', function (Blueprint $table) {
            $table->increments('id');
            $table->text("complaint")->nullable();

            $table->text("impression")->nullable();

            $table->text("action_taken")->nullable();

            $table->unsignedInteger("request_review")->default(0);

            $table->string("doctor_to_review", 10)->nullable();

            $table->unsignedInteger("urgency_status")->default(0);

            $table->unsignedInteger("review_status")->default(0);



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

        DB::table('labour_complaint')->insert(
            array(
                "complaint" => "The midwives were just there gisting about Zeeworld",
                "impression" => "Discomfort",
                "action_taken" => "Quick shot for uneasiness",
                "urgency_status" => 6,
                "patient_id" => 4,
                "hospital_id" => 1,
                "doctor_id" => 3,
                "hospital_admin_id" => 1,
                "patient_type_id" => 2
            )
        );

        DB::table('labour_complaint')->insert(
            array(
                "complaint" => "No AC in the delivery room",
                "impression" => "Anger and disappointment",
                "action_taken" => "Taking deep breaths",
                "request_review" => 1,
                "urgency_status" => 6,
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
        Schema::dropIfExists('labour_complaint');
    }
}
