<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 2/19/2020
 * Time: 2:59 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminAdmin extends Model
{
    protected $primaryKey = "id";

    protected $table = "admin_admin";

    protected $fillable = ["names", "email","phone_number", "password", "status", "token", "image_path", "code", "firebase_android", "firebase_ios", "hospital_id", "created_at"];

}