<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{

    protected  $table = 'sales';

    protected  $fillable = [
         'refNumber', 'dateIssued', 'status'
    ];

    public function products()
    {
        return $this->hasMany('App\SalesProduct');
    }


}
