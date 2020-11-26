<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ios_badge_count extends Model
{
    protected $table = 'ios_badge_count';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'badge_count', 'created_date'
    ];
}
