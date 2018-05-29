<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Death extends Model
{

    protected  $table = 'death';

    protected  $fillable = [
        'firstName', 'middleName', 'lastName', 'nameExt', 'residence', 'nativeOf', 'deathDate', 'burialPlace', 'burialDate',
        'book', 'page', 'entry', 'minister_id'
    ];


    public function minister()
    {

        return $this->belongsTo('App\Ministers')->withDefault(['id' => 0,'name' => "No Assigned Minister."]);

    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['firstName'] = ucfirst($value);
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middleName'] = ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['lastName'] = ucfirst($value);
    }

}
