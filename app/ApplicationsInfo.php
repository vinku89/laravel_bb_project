<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ApplicationsInfo extends Model
{
	protected $table = 'applications_info';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'application_id','application_name','support_email','web_url','main_logo','payformyfriend_black','payformyfriend_white'
    ];


}
