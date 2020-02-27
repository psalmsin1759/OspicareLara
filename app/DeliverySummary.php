<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverySummary extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'delivery_summary';

    protected $fillable = [
        'delivery_time',
        'g_a',
        'parity',
        'delivery_mode',
        'augmentation',
        'baby_status',
        'sex',
        'apgar_1_min',
        'apgar_5_min',
        'apgar_10_min',
        'apgar_20_min',
        'resuscitation',
        'weight',
        'placenta',
        'manual_evacution',
        'bloodloss_estimate',
        'bp',
        'hr',
        'referral_required',
        'fluid_resuscitation',
        'blood_transfer',
        'anti_shock',
        'cpr',
        'oxytocin',
        'misoprostol',
        'uterine',
        'tamponade',
        'other_intervention',
        'bloodloss_source',
        'arrest_bleeding',
        'bleeding_referral',
        'baby_risk',
        'baby_risk_intervention',
        'mother_final_action',
        'baby_final_action',
        'patient_id',
        'hospital_id',
        'doctor_id',
        'hospital_admin_id'
    ];
}
