<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabourCategory extends Model
{
    protected $primaryKey = "id";

    protected $table = "labour_category";

    protected $fillable = ["risk_status", "mode_of_delivery", "patient_id","hospital_admin_id", "hospital_id", "doctor_id", "patient_type_id", "created_at"];

}
