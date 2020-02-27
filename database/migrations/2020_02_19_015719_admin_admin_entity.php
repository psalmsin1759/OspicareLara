<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminAdminEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("admin_admin", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->string("names",50)->nullable();
            $table->string("email",50)->nullable();
            $table->string("phone_number",20)->nullable();
            $table->string("password",100)->nullable();
            $table->string("status",10)->nullable();
            $table->string("token",50)->nullable();
            $table->string("image_path",200)->nullable();
            $table->string("code",50)->nullable();
            $table->text("firebase_android")->nullable();
            $table->text("firebase_ios")->nullable();


            $table->unsignedInteger("hospital_id");
            $table->foreign("hospital_id")->references('id')->on('hospital')->onDelete('cascade');


            $table->timestamps();
        });

        DB::table('admin_admin')->insert(
            array(
                'names' => 'Admin',
                'email' => 'admin@ospicare.com',
                'phone_number' => '12345678909',
                'status' => 'enable',
                'password' => hash('sha256', 'admin'),
                'token' => md5('admin@ospicare.com'),
                'hospital_id' => 1
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
        Schema::drop("admin_admin");
    }
}
