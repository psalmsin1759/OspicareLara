<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 10/3/2019
 * Time: 3:29 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalAdmin  extends Model
{
    protected $primaryKey = "id";

    protected $table = "hospital_admin";

    protected $fillable = ["names", "email","phone_number", "password", "status", "token", "image_path", "code", "firebase_android", "firebase_ios", "hospital_id", "created_at"];

}