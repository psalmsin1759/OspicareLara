<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabourAssessment extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'labour_assessment';

    protected $fillable = [
        'bp',
        'heart_rate',
        'temperature',
        'respiration',
        'o2_saturation',
        'symphisotudal_height',
        'lie',
        'presentation',
        'position',
        'descent',
        'fetal_heart_rate',
        'patient_id',
        'hospital_id',
        'doctor_id',
        'hospital_admin_id'
    ];
}
