<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 1/22/2020
 * Time: 10:41 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{

    protected $primaryKey = "id";

    protected $table = "proforma";

    protected $fillable = ["complaint", "past_medical_history","medical_history", "drug_allergy", "social_history", "established_sign", "review_of_symptoms", "review_of_symptoms", "general_examination", "examination_of_relevant_system", "working_diagnosis", "others", "patient_id", "created_at"];

}