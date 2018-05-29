<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Marriage extends Model
{

    protected  $table = 'marriage';

    protected  $fillable = [
        'husband_id', 'wife_id', 'dateMarried', 'book', 'page', 'entry', 'minister_id'
    ];

    public static $husbandWifeRules = [
        'firstName' => 'required|max:50',
        'middleName' => 'required|max:50',
        'lastName' => 'required|max:50',
        'nameExt' => 'max:50',
        'birthdate' => 'required|date',
        'religion' => 'max:150',
        'residence' => 'max:150',
        'fatherName' => 'required|max:150',
        'motherName' => 'required|max:150',
    ];

    public static $marriageRules = [
        'dateMarried' => 'required|date',
        'book' => 'required|numeric',
        'page' => 'required|numeric',
        'entry' => 'required|numeric',
        'minister_id' => 'required|integer'
    ];

    public static $rules = [
        'husband.firstName' => 'required|max:50',
        'husband.middleName' => 'required|max:50',
        'husband.lastName' => 'required|max:50',
        'husband.nameExt' => 'max:50',
        'husband.birthdate' => 'required|date',
        'husband.religion' => 'max:150',
        'husband.residence' => 'max:150',
        'husband.fatherName' => 'required|max:150',
        'husband.motherName' => 'required|max:150',

        'wife.firstName' => 'required|max:50',
        'wife.middleName' => 'required|max:50',
        'wife.lastName' => 'required|max:50',
        'wife.birthdate' => 'required|date',
        'wife.religion' => 'max:150',
        'wife.residence' => 'max:150',
        'wife.fatherName' => 'required|max:150',
        'wife.motherName' => 'required|max:150',

        'dateMarried' => 'required|date',
        'book' => 'required|numeric',
        'page' => 'required|numeric',
        'entry' => 'required|numeric',
        'minister_id' => 'required|integer',
        'sponsors.*.sponsor' => 'sometimes|required|max:150'
    ];



    public function minister()
    {
        return $this->belongsTo('App\Ministers');
    }

    public function husband()
    {
        return $this->belongsTo('App\MarriageHusband','husband_id');
    }

    public function wife()
    {
        return $this->belongsTo('App\MarriageWife','wife_id');
    }

    public function sponsors()
    {
        return $this->hasMany('App\MarriageSponsor');
    }


    public function setDateMarriedAttribute($value)
    {
        $this->attributes['dateMarried'] = Carbon::parse($value)->toDateString();
    }

}
