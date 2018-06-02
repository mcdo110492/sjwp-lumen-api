<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{

    protected  $table = 'productCategories';

    protected  $fillable = [
         'name', 'parent_id'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }


}
