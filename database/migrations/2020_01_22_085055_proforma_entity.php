<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProformaEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("proforma", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");

            $table->text("complaint")->nullable();

            $table->text("past_medical_history")->nullable();

            $table->text("medical_history")->nullable();

            $table->text("drug_allergy")->nullable();

            $table->text("social_history")->nullable();

            $table->text("established_sign")->nullable();

            $table->text("review_of_symptoms")->nullable();

            $table->text("general_examination")->nullable();

            $table->text("examination_of_relevant_system")->nullable();

            $table->text("working_diagnosis")->nullable();

            $table->text("others")->nullable();



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
        Schema::dropIfExists('proforma');
    }
}
