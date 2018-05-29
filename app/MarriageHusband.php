<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MarriageHusband extends Model
{

    protected  $table = 'marriageHusband';

    protected  $fillable = [
        'firstName', 'middleName', 'lastName', 'nameExt', 'birthdate', 'religion', 'residence', 'fatherName', 'motherName'
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['firstName'] = strtoupper($value);
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middleName'] = strtoupper($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['lastName'] = strtoupper($value);
    }

    public function setBirthdateAttribute($value)
    {
        $this->attributes['birthdate'] = Carbon::parse($value)->toDateString();
    }

    public function setFatherNameAttribute($value)
    {
        $this->attributes['fatherName'] = strtoupper($value);
    }

    public function setMotherNameAttribute($value)
    {
        $this->attributes['motherName'] = strtoupper($value);
    }


}
