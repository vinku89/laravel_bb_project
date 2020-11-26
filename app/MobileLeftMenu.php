<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileLeftMenu extends Model {

    protected $table = 'mobile_left_menu';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_menu_id', 'menu_name', 'menu_link', 'menu_icon', 'status', 'menu_order', 'display_location'];

   

}
