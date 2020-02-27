<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralHealth extends Model
{
    protected $primaryKey = "id";

    protected $table = "general_health";

    protected $fillable = ["respiratory_rate_value", "respiratory_rate_value_score","saturation_scale_one_value","saturation_scale_one_score","saturation_scale_two_value","saturation_scale_two_score","alertness_value","alertness_value_score","temperature_value","temperature_value_score","heart_rate_value","heart_rate_value_score", "systolic_pressure_score", "systolic_pressure_value", "diastolic_pressure_score", "diastolic_pressure_value", "is_action_taken", "action_taken", "hospital_id", "hospital_admin_id", "patient_id", "created_at"];


}
