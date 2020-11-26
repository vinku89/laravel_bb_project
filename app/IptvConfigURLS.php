<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class IptvConfigURLS extends Model
{
	protected $table = 'iptv_config_urls';
	protected $primaryKey = 'rec_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id','proxy_streaming','proxy_vod','proxy_catchup','iptv_live','iptv_player','iptv_vod', 'iptv_catchup','status'
    ];


}
