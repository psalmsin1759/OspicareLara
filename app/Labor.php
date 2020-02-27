<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 1/31/2020
 * Time: 3:57 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{

    protected $primaryKey = "id";

    protected $table = "labor";

    protected $fillable = ["hospital_admin_id", "patient_id", "assessment", "Impression", "pelvic_assessment", "cervical_dilation", "plan", "Complaints", "remarks", "request_review", "created_at"];
}