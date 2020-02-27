<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Doctor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("doctor", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->string("names",50)->nullable();
            $table->string("email",50)->nullable();
            $table->string("sex",10)->nullable();
            $table->string("phone_number",20)->nullable();
            $table->string("address_street",100)->nullable();
            $table->string("address_lga",50)->nullable();
            $table->string("address_state",50)->nullable();
            $table->string("password",100)->nullable();
            $table->string("status",10)->nullable();
            $table->string("specialty",100)->nullable();
            $table->string("level",100)->nullable();
            $table->unsignedInteger("availability")->default(1);
            $table->string("online_consultation_fee",20)->nullable();
            $table->string("onsite_consultation_fee",20)->nullable();
            $table->mediumText("profile")->nullable();
            $table->string("image_path",200)->nullable();
            $table->string("code",50)->nullable();
            $table->boolean("is_independent",10)->default(1);
            $table->string("registering_body",50)->nullable();
            $table->string("registration_number",50)->nullable();
            $table->text("firebase_android")->nullable();
            $table->text("firebase_ios")->nullable();

            $table->unsignedInteger("doctor_type_id");
            $table->foreign("doctor_type_id")->references('id')->on('doctor_type')->onDelete('cascade');

            $table->timestamps();

        });

        DB::table('doctor')->insert(
            array(
                'names' => 'Ifenna',
                'email' => 'okoyeifenna24@gmail.com',
                'sex' => 'female',
                'phone_number' => '07034352681',
                'address_street' => 'Aguda',
                'address_lga' => 'Surulere',
                'address_state' => 'Lagos',
                'status' => 'enable',
                'password' => hash('sha256', '1234'),
                'specialty' => 'General health',
                'level' => 'resident',
                'is_independent' => false,
                'online_consultation_fee' => '5000',
                'onsite_consultation_fee' => '7500',
                'profile' => 'Graduate of Havards, PhD in Pyschology, Msc in Health',
                'code' => md5('okoyeifenna24@gmail.com'),
                'doctor_type_id' => 2
            )
        );

        DB::table('doctor')->insert(
            array(
                'names' => 'Aisha',
                'email' => 'Aisha@gmail.com',
                'sex' => 'female',
                'phone_number' => '12345678909',
                'address_street' => 'Celesium',
                'address_lga' => 'Garki',
                'address_state' => 'Abuja',
                'status' => 'enable',
                'password' => hash('sha256', '1234'),
                'specialty' => 'Labour',
                'level' => 'Lead doctor',
                // 'availability' => 'enable',
                'online_consultation_fee' => '23900',
                'onsite_consultation_fee' => '18650',
                'profile' => 'Yale graduate, Harvard PhD, Msc in Health',
                'code' => md5('Aisha@gmail.com'),
                'doctor_type_id' => 1
            )
        );


        DB::table('doctor')->insert(
            array(
                'names' => 'Daniel',
                'email' => 'daniel@gmail.com',
                'sex' => 'male',
                'phone_number' => '12345678909',
                'address_street' => 'Adele',
                'address_lga' => 'Waterlines',
                'address_state' => 'PortHarcourt',
                'status' => 'enable',
                'password' => hash('sha256', '1234'),
                'specialty' => 'Antenatal',
                'level' => 'Partner doctor',
                // 'availability' => 'enable',
                'online_consultation_fee' => '63000',
                'onsite_consultation_fee' => '75800',
                'profile' => 'Oxford grad, PhD in Browns, Msc in Advanced Cardiology and physics',
                'code' => md5('daniel@gmail.com'),
                'doctor_type_id' => 1
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
        Schema::drop("doctor_table");
    }
}
