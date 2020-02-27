<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Hospital extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("hospital", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->string("health_centre_name",200)->nullable();
            $table->string("address",200)->nullable();
            $table->string("city",50)->nullable();
            $table->string("state",50)->nullable();
            $table->string("status",15)->nullable();
            $table->string("code",50)->nullable();

            $table->timestamps();

        });

        DB::table('hospital')->insert(
            array(
                'health_centre_name' => 'Default Healthcare',
                'address' => 'Default Address',
                'city' => 'Default City',
                'state' => 'Default State',
                'code' => 'Default Code'
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
        Schema::drop("hospital");
    }
}
