<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 10/3/2019
 * Time: 4:11 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalDoctor extends Model
{
    protected $primaryKey = "id";

    protected $table = "hospital_doctor";

    protected $fillable = ["hospital_id", "doctor_id", "created_at"];

}