<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarriageSponsor extends Model
{

    protected  $table = 'marriageSponsors';

    protected  $fillable = [
        'marriage_id', 'sponsor'
    ];

    public function setSponsorAttribute($value)
    {
        $this->attributes['sponsor'] = strtoupper($value);
    }

}
