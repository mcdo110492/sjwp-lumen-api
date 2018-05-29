<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfirmationSponsor extends Model
{

    protected  $table = 'confirmationSponsors';

    protected  $fillable = [
        'confirmation_id', 'sponsor'
    ];

    public function setSponsorAttribute($value)
    {
        $this->attributes['sponsor'] = strtoupper($value);
    }

}
