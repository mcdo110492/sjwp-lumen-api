<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ministers extends Model
{

    protected  $table = 'ministers';

    protected  $fillable = [
        'name', 'active'
    ];


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
}
