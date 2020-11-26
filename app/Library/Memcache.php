<?php
namespace App\Library;
use Memcached;
class Memcache{
	public static function memcached(){
		$mem = new Memcached();
		$mem->addServer("127.0.0.1", 11211);
		return $mem;
	}
}
