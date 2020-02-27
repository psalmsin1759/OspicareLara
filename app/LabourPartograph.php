<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabourPartograph extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'labour_partograph';

    protected $fillable = [
        'fetal_heart_rate', 
        'cervix', 
        'descent', 
        'liquor', 
        'moulding', 
        'contraction_per_10_min', 
        'oxytocin', 
        'u/l', 
        'drops_per_min', 
        // 'blood_pressure', 
        'temperature',
        'heartrate',
        // 'urine',
        'urine_amount',
        'protein',
        'acetone',
        'assessment',
        'actions',
        'recommendation',
        'next_assessment'
    ];
}
