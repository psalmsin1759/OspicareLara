<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 10/3/2019
 * Time: 2:36 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $primaryKey = "id";

    protected $table = "hospital";

    protected $fillable = ["health_centre_name", "address","city", "state", "status", "code", "created_at"];

}