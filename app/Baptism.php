<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baptism extends Model
{

    protected  $table = 'baptism';

    protected  $fillable = [
        'firstName', 'middleName', 'lastName', 'nameExt', 'birthdate', 'birthPlace', 'baptismDate', 'book', 'page', 'entry',
        'fatherName', 'motherName', 'minister_id'
    ];

}
