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

}
