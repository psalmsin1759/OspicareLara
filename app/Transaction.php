<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 1/31/2020
 * Time: 10:55 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = "id";

    protected $table = "transaction";

    protected $fillable = ["amount", "channel", "hospital_id", "doctor_id", "hospital_admin_id", "patient_id","created_at"];

}
