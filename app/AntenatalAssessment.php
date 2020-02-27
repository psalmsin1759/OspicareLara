<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntenatalAssessment extends Model
{
    protected $primaryKey = "id";

    protected $table = "antenatal_baseline_assessment";

    protected $fillable = ["blood_pressure", "heart_rate","temperature","symphysis_fundal_height", "fetal_heart_tone", "fetal_heart_rate", "lie", "presentation", "position", "descent",  "patient_id","hospital_admin_id", "hospital_id", "doctor_id", "patient_type_id", "created_at"];

}
