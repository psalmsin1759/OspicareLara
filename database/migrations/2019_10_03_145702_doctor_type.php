<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DoctorType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("doctor_type", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->string("name",50)->nullable();


            $table->timestamps();
        });



        DB::table('doctor_type')->insert(
            array(
                ['name' => 'Independent'],
                ['name' => 'Hospital']
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
        Schema::drop("doctor_type");
    }
}
