<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 1/15/2020
 * Time: 7:40 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $primaryKey = "id";

    protected $table = "recommendation";

    protected $fillable = ["doctor_id", "patient_id", "title", "body","created_at"];

}
