<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ApplicationSettings extends Model
{
	protected $table = 'application_settings';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setting_name','setting_value'
    ];


}
