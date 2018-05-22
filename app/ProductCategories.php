<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\BinaryUuid\HasBinaryUuid;

class ProductCategories extends Model
{

    use HasBinaryUuid;

    protected  $table = 'productCategories';

    protected  $fillable = [
         'name', 'price', 'parent_id'
    ];

}
