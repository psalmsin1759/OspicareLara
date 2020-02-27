<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatientType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name",50)->nullable();
            $table->timestamps();
        });

        
        DB::table('patient_type')->insert(
            array(
                ['name' => 'general health'],
                ['name' => 'labor ward'],
                ['name' => 'Antenatal ward']
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
        Schema::dropIfExists('patient_type');
    }
}
