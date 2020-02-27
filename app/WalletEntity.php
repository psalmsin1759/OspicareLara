<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 5/22/2018
 * Time: 8:18 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletEntity extends Model
{

    protected $primaryKey = "id";

    protected $table = "wallet";

    protected $fillable = ["amount", "hospital_id", "created_at"];

}