<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected  $table = 'profile';

    protected  $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'birthdate',
        'uuid',
        'fatherName',
        'motherName',
        'birthPlace',
        'residence'
    ];

}
