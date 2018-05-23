<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{

    protected  $table = 'confirmation';

    protected  $fillable = [
        'firstName', 'middleName', 'lastName', 'nameExt', 'confirmationDate', 'baptismDate', 'baptizedAt', 'book', 'page',
        'minister_id'
    ];

    public function sponsors()
    {

        return $this->hasMany('App\ConfirmationSponsor');

    }

    public function minister()
    {

        return $this->belongsTo('App\Ministers')->withDefault(['id' => 0,'name' => "No Assigned Minister."]);

    }

}
