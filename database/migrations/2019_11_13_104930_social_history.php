<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SocialHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string("marital_status", 15)->nullable();
            $table->unsignedInteger("responsible_partner")->default(0);
            $table->string("employment_status", 20)->nullable(0);
            $table->unsignedInteger("substance_abuse")->default(0);
            $table->string("substance_abuse_type", 200)->default('none');
            $table->unsignedInteger("smoker")->default(0);
            $table->string("hiv_status")->default(0);

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

	DB::table('social_history')->insert(
            array(
                "marital_status" => "married",
                "responsible_partner" => 1,
                "employment_status" => "prosident",
                "patient_id" => 2,
                "hospital_id" => 1,
                "doctor_id" => 2,
                "hospital_admin_id" => 1,
                "patient_type_id" => 2
            )
        );

        DB::table('social_history')->insert(
            array(
                "marital_status" => "married",
                "responsible_partner" => 1,
                "employment_status" => "architect",
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
        Schema::dropIfExists('social_history');
    }
}
