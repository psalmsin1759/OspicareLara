<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DischargeSummary extends Model
{
    protected $table = 'discharge_summary';

    protected $primaryKey = 'id';

    protected $fillable = [
        'mother_bp',
        'mother_hr',
        'mother_temperature',
        'mother_respiration',
        'mother_saturation',
        'baby_bp',
        'baby_saturation',
        'baby_hr',
        'baby_temperature',
        'baby_respiration',
        'next_appointment',
        'patient_id',
        'hospital_id',
        'doctor_id',
        'hospital_admin_id'
    ];
}
