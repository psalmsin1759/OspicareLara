<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 1/30/2020
 * Time: 9:11 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antenatal extends Model
{

    protected $primaryKey = "id";

    protected $table = "antenatal";

    protected $fillable = [ "patient_id", "assessment", "Impression", "Investigation", "Complaints", "ActionTaken", "request_review", "created_at"];
}