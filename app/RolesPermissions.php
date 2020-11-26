<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RolesPermissions extends Model
{
	protected $table = 'roles_permissions';
	protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_name', 'role_type','description','parent_menus','child_menus','status'
    ];


}
