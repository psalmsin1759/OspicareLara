<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntenatalInvestigation extends Model
{
    protected $primaryKey = "id";

    protected $table = "antenatal_baseline_investigation";

    protected $fillable = ["hiv", "HBrAg","HCV","blood_group", "hemoglobin", "urinalysis",  "patient_id","hospital_admin_id", "hospital_id", "doctor_id", "patient_type_id", "created_at"];

}
