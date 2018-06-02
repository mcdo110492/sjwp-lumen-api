<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseDetails extends Model
{

    protected  $table = 'expenseDetails';

    protected  $fillable = [
         'expense_id' ,'category_id', 'amount'
    ];

    public function categories()
    {
        return $this->belongsTo('App\ExpenseCategories','category_id');
    }


}
