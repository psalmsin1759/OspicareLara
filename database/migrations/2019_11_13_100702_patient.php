
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Patient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient', function (Blueprint $table) {
            $table->increments('id');
            $table->string("patient_id",100)->nullable();
            $table->string("names",50)->nullable();
            $table->string("phone_number",20)->nullable();
            $table->string("dob",20)->nullable();
            $table->string("age",10)->nullable();
            $table->string("sex",10)->nullable();
            $table->string("address",100)->nullable();
            $table->string("status",10)->nullable();
            $table->string("image_path",200)->nullable();;
            $table->string("assigned_doctor",10)->nullable();
            $table->string("patient_category",100)->nullable();
            $table->unsignedInteger("monitoring_status")->default(0);

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

	DB::table('patient')->insert(
            array(
                'patient_id' => '123',
                'names' => 'Invictus Obi',
                'sex' => 'male',
                'phone_number' => '12345678909',
                'dob' => '08-12-19',
                'age' => '34',
                'address' => 'Aguda, Lagos',
                'status' => 'enable',
                'monitoring_status' => 1,
                'doctor_id' => 2,
                'hospital_id' => 1,
                'hospital_admin_id' => 1,
                'patient_type_id' => 1
            )
        );

        DB::table('patient')->insert(
            array(
                'patient_id' => '419',
                'names' => 'Buhari',
                'sex' => 'male',
                'phone_number' => '12345678909',
                'dob' => '08-12-19',
                'age' => '78',
                'address' => 'FCT, Abuja',
                'status' => 'enable',
                'monitoring_status' => 0,
                'doctor_id' => 1,
                'hospital_id' => 1,
                'hospital_admin_id' => 1,
                'patient_type_id' => 2
            )
        );

        
        DB::table('patient')->insert(
            array(
                'patient_id' => '69',
                'names' => 'Glory Saavage',
                'sex' => 'female',
                'phone_number' => '12345678909',
                'dob' => '08-12-19',
                'age' => '26',
                'address' => 'Lekki, Lagos',
                'status' => 'enable',
                'monitoring_status' => 1,
                'doctor_id' => 3,
                'hospital_id' => 1,
                'hospital_admin_id' => 1,
                'patient_type_id' => 3
            )
        );

        DB::table('patient')->insert(
            array(
                'patient_id' => '4040',
                'names' => 'Regina Daniels',
                'sex' => 'female',
                'phone_number' => '12345678909',
                'dob' => '08-12-19',
                'age' => '22',
                'address' => 'Sapele, Delta',
                'status' => 'enable',
                'monitoring_status' => 1,
                'doctor_id' => 3,
                'hospital_id' => 1,
                'hospital_admin_id' => 1,
                'patient_type_id' => 3
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
        Schema::dropIfExists('patient');
    }
}
