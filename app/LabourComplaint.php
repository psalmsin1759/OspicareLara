<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabourComplaint extends Model
{
    protected $primaryKey = "id";

    protected $table = "labour_complaint";

    protected $fillable = ["complaint", "impression","action_taken","request_review", "doctor_to_review", "urgency_status", "review_status", "patient_id","hospital_admin_id", "hospital_id", "doctor_id", "patient_type_id", "created_at"];

}
