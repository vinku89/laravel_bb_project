<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Left_menu extends Model {

    protected $table = 'left_menu';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_menu_id', 'menu', 'menu_link', 'class_type', 'status', 'menu_order'];

   

}
