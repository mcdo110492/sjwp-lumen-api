<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategories extends Model
{

    protected  $table = 'expenseCategories';

    protected  $fillable = [
         'name', 'parent_id'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }


}
