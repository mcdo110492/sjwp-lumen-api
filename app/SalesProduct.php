<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesProduct extends Model
{

    protected  $table = 'salesProduct';

    protected  $fillable = [
         'product_id' ,'price', 'quantity', 'sales_id'
    ];

    public function product()
    {
        return $this->belongsTo('App\Products','product_id');
    }


}
