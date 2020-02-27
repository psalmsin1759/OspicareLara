<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndependentDoctor extends Model
{
    protected $primaryKey = "id";

    protected $table = "independent_doctor";

    protected $fillable = [ "doctor_id", "created_at"];
}
