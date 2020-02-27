<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 1/30/2020
 * Time: 8:35 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialMedical extends Model
{

    protected $primaryKey = "id";

    protected $table = "social_medical";

    protected $fillable = [ "patient_id", "social", "medical","created_at"];
}