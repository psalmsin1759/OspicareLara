<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverySummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('delivery_time')->nullable();
            $table->string('g_a')->nullable();
            $table->string('parity')->nullable();
            $table->string('delivery_mode')->nullable();
            $table->boolean('augmentation')->nullable();
            $table->string('baby_status')->nullable();
            $table->string('sex')->nullable();
            $table->string('apgar_1_min')->nullable();
            $table->string('apgar_5_min')->nullable();
            $table->string('apgar_10_min')->nullable();
            $table->string('apgar_20_min')->nullable();
            $table->string('resuscitation')->nullable();
            $table->mediumInteger('weight')->nullable();
            $table->string('placenta')->nullable();
            $table->string('manual_evacution')->nullable();
            $table->string('bloodloss_estimate')->nullable();
            $table->string('bp')->nullable();
            $table->string('hr')->nullable();
            $table->boolean('referral_required')->default(false);
            $table->boolean('fluid_resuscitation')->nullable();
            $table->boolean('blood_transfer')->nullable();
            $table->boolean('anti_shock')->nullable();
            $table->boolean('cpr')->nullable();
            $table->boolean('oxytocin')->nullable();
            $table->boolean('misoprostol')->nullable();
            $table->boolean('uterine')->nullable();
            $table->boolean('tamponade')->nullable();
            $table->string('other_intervention')->nullable();
            $table->longText('bloodloss_source')->nullable();
            $table->boolean('arrest_bleeding')->nullable();
            $table->longText('bleeding_referral')->nullable();
            $table->text('baby_risk')->nullable();
            $table->longText('baby_risk_intervention')->nullable();
            $table->longText('mother_final_action')->nullable();
            $table->longText('baby_final_action')->nullable();

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
        Schema::dropIfExists('delivery_summary');
    }
}
