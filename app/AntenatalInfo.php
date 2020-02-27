<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntenatalInfo extends Model
{
    protected $primaryKey = "id";

    protected $table = "antenatal_info";

    protected $fillable = ["last_menstrual_period", "gestational_age","gravidity","parity", "patient_id","hospital_admin_id", "hospital_id", "doctor_id", "patient_type_id", "created_at"];

}
