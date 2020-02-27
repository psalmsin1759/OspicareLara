<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 2/26/19
 * Time: 3:26 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $primaryKey = "id";

    protected $table = "doctor";

    protected $fillable = ["online_consultation_fee", "onsite_consultation_fee","doctor_type_id", "address_street", "address_lga", "address_state", "availability", "specialty", "profile", "names", "email","phone_number", "sex", "level","password", "status", "token", "image_path", "code",  "is_independent","firebase_android", "firebase_ios", "registering_body", "registration_number", "created_at"];

}