<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ministers extends Model
{

    protected  $table = 'minister';

    protected  $fillable = [
        'name', 'active'
    ];

}
