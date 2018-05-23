<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaptismSponsor extends Model
{

    protected  $table = 'baptismSponsors';

    protected  $fillable = [
        'baptism_id', 'sponsor'
    ];

}
