<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Recent_movies_images extends Model
{
	protected $table = 'recent_movies_images';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','movie_image','movie_link', 'status'
    ];


}
