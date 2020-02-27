<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LaborEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("labor", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");

            $table->text("assessment")->nullable();

            $table->text("Impression")->nullable();

            $table->string("pelvic_assessment",20)->nullable();

            $table->string("cervical_dilation",20)->nullable();

            $table->string("plan",50)->nullable();

            $table->text("Complaints")->nullable();

            $table->text("remarks")->nullable();

            $table->string("request_review",10)->nullable();


            $table->unsignedInteger("patient_id");
            $table->foreign("patient_id")->references('id')->on('patient')->onDelete('cascade');

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
        Schema::dropIfExists('labor');
    }
}
