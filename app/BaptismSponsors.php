<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaptismSponsors extends Model
{

    protected  $table = 'baptism';

    protected  $fillable = [
        'baptism_id', 'sponsor'
    ];

}
