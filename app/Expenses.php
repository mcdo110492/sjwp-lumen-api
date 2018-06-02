<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{

    protected  $table = 'expenses';

    protected  $fillable = [
         'refNumber', 'dateIssued', 'status','remarks'
    ];

    public function details()
    {
        return $this->hasMany('App\ExpenseDetails','expense_id');
    }

}
