<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;

use DateTime;

use App\Mail\SendEmail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use App\Verify_admin_otp;
use App\CoinListing;
use App\AdminAuditInfo;
use Illuminate\Support\Facades\Redirect;
use App\BaseCurrencyPairing;
use Session;
use DB;
use Memcached;
use App\Library\Memcache;
class AppController extends Controller 
{
	protected $mem;
	public function __construct()
    {
        $this->mem=Memcache::memcached();
    }
}