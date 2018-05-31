<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{

    protected  $table = 'products';

    protected  $fillable = [
         'code' ,'description', 'price', 'category_id'
    ];

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ucfirst($value);
    }


}
