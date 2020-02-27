<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialHistory extends Model
{
    protected $primaryKey = "id";

    protected $table = "social_history";

    protected $fillable = ["marital_status", "responsible_partner","employment_status","substance_abuse", "substance_abuse_type", "smoker", "hiv_status",  "patient_id","hospital_id", "doctor_id", "hospital_admin_id", "patient_type_id", "created_at"];

}
