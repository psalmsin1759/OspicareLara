<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabourVaginalExamination extends Model
{
    protected $primaryKey = "id";

    protected $table = "labour_vaginal_examination";

    protected $fillable = ["remark", "pelvic_assess_req","cervical_dilation","impression", "plan", "patient_id","hospital_admin_id", "hospital_id", "doctor_id", "patient_type_id", "created_at"];

}
