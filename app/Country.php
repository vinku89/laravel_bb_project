<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Country extends Model
{
	protected $table = 'country';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'countryid', 'country_name','currencycode','currency','country_status','iso','nationality'
    ];


}
