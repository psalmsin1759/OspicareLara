<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $table = "medical_history";


    protected $fillable = ["hypertension", "previous_hyper_in_preg","diabetes_mellitus","previous_dm_in_preg", "heart_disease", "pre_eclampsia", "still_birth", "post_partum_haemorrhage", "ante_partum_haemorrhage", "two_more_miscarriages", "h_macrosomia_45kg", "h_low_birth_weight", "h_birth_defects", "history_of_clot", "myomectomy", "previous_c_s", "number_of_c_s", "epileptic", "asthmatic", "patient_id","hospital_admin_id", "hospital_id", "doctor_id", "patient_type_id", "created_at"];

}
