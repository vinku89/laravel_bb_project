<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FcmpushNotifications extends Model
{
    protected $table = 'fcmpushNotifications';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id','user_id', 'telephone', 'success_status', 'failure_status', 'message', 'message_type', 'created_at'
    ];
}
