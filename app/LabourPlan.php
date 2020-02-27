<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabourPlan extends Model
{
    protected $primaryKey = "id";

    protected $table = "labour_plan";

    protected $fillable = ["plan", "phase","responsible_partner","employment_status", "substance_abuse", "substance_abuse_type", "smoker","hiv_status", "patient_id","hospital_admin_id", "hospital_id", "doctor_id", "patient_type_id", "created_at"];

}
