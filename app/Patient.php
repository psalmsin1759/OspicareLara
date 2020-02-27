<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $primaryKey = "id";

    protected $table = "patient";

    protected $fillable = ["assigned_doctor", "dob", "age", "sex","patient_type_id","hospital_admin_id", "hospital_id", "doctor_id", "patient_id", "names", "phone_number", "address", "status","image_path","created_at"];

}
