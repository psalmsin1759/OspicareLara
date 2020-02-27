<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientType extends Model
{
    protected $primaryKey = "id";

    protected $table = "patient_type";

    protected $fillable = [ "names","created_at"];

}
