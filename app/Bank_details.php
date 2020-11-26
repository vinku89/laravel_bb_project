<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Bank_details extends Model
{
	protected $table = 'bank_details';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_rec_id','bank_name', 'bank_holder','account_number','swift_code','bank_address_one','bank_address_two','country','state','zip_code','created_at','updated_at'
    ];


}
