<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Input;
use \App\library\Common;
use App\Models\letcoinModel;
use Session;
use Carbon\Carbon;
class registerModel extends Model {

	public static function getuserpwd($username) {

        $value = DB::table('users AS ur')->
                where('ur.user_id', $username)->
                //where('ur.user_role', 1)->
                select('ur.user_id', 'ur.password','ur.registration_date','email_verify')->
                first();
        if ($value) {
            return $value;
        } else {
            return false;
        }
    }
    // Verifying User login and return result set
    public static function checkuserlogin($user_id, $new_password1) {
        $matchThese = ['user_id' => $user_id, 'password' => $new_password1];
        $user = DB::table('users')
                        ->where($matchThese)->first();      
        if ($user) {
            
                $userData = [ 'user_id' => $user->user_id, 'username' => $user->username, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email, 'telephone' => $user->telephone, 'status' => $user->status];
                return $userData;
           
            
        } else {
            return false;
        }
    }

    public static function getCurrentUserInfo($userid) {
        $sqlquery = DB::table('user_registration')->where('user_id', '=', $userid)->first();
        return $sqlquery;
    }
    public static function updateUserRegistration($userid,$update)
        {
            $result = DB::table('users')->where('rec_id','=',$userid)->update($update);
            return $result;
        }
    public static function getUserInfoByUsername($username) {
        $matchThese = ['username' => $username,'user_role'=>1];
        $user = DB::table('admin_users')
                        ->where($matchThese)->first();
        return $user;
    }
     public static function insertResetPasswordData($data=array()){
          $value = DB::table('reset_password_history')->insertGetId($data);
          return $value;
      }
      public static function getResetPasswordData($userid,$fp_id){
        $rs = DB::table('reset_password_history')->select('*')->where('user_id', $userid)->where('rec_id', $fp_id)->first();
        
         if($rs){
            return $rs;
          }else{
            return false;
          }

     }
     public static function updateData($table = '', $coulmn = '', $id, $data = array()) {
        $value = DB::table($table)
                ->where($coulmn, $id)
                ->update($data);
        return $value;
    }
    public static function getUserInfo($user_id) {
        $matchThese = ['user_id' => $user_id];
        $user = DB::table('admin_users')
                        ->where($matchThese)->first();
        $usercount = DB::table('admin_users')
                        ->where($matchThese)->exists();                
        if ($usercount == true) {
            return $user;
        } else {
            return false;
        }
    }
    public static function insert($table = '', $data = array()) {
        $value = DB::table($table)->insert($data);
        return $value;
    }
    public static function getRWAmount($user_id) {
        $matchThese = ['user_id' => $user_id];
        $user = DB::table('register_wallet')
                        ->where($matchThese)->first();
        return $user->amount;
    }
    public static function getBTCAmount($user_id) {
        $matchThese = ['user_id' => $user_id];
        $user = DB::table('btc_wallet')
                        ->where($matchThese)->first();
        return $user->amount;
    }
    public static function getDEWAmount($user_id) {
        $matchThese = ['user_id' => $user_id];
        $user = DB::table('daily_earnings_wallet')
                        ->where($matchThese)->first();
        return $user->amount;
    }
    public static function getCountriesList()
    {
        $query = "SELECT * FROM `country` WHERE reg_status=1 ORDER BY country_name ASC";
        $results = DB::select(DB::raw($query));
        return $results;
    }
    public static function getCurrencyCode($countryId)
    {
        
        $today_bal_query = "SELECT currencycode,country_name from country where countryid='$countryId'";
        $query = $result = DB::select(DB::raw($today_bal_query));
        return $query;
    }

    /*** Generate UserId ***/
    public static function userid()
    {
        $query = "SELECT MAX(user_id) AS uid FROM user_registration";
        $results = DB::select(DB::raw($query));
        $new_userid = $results[0]->uid+1;
        return $new_userid;
    }

    public static function checkUserName($uname)
    {
       $results = DB::table('users')
        ->select('rec_id','user_id','first_name','last_name','password','email_verify','refferallink_text')
        ->where('user_id', '=', $uname)->orWhere('rec_id', '=', $uname)
        ->first();
        $rowCount = DB::table('users')
        ->select('user_id')
        ->where('user_id', '=', $uname)->orWhere('rec_id', '=', $uname)
        ->exists();
        
        return (array("rowCount"=>$rowCount,"userDetails"=>$results));
    }

    public static function getStatement($wallet_id, $id) {

        error_reporting(0);
        $url = url("/") . "/public/assets/images/brand/";
        $wallets = array('one' => 'Register Wallet', 'two' => 'Earnings Wallet');

        $sums_debit = DB::select(DB::raw("select sum(credit_amt) as total_credit,sum(debit_amt) as total_debit from credit_debit where user_id = '$id' and ewallet_used_by='" . $wallets[$wallet_id] . "'"));
        $total_earnings = $sums_debit[0]->total_credit - $sums_debit[0]->total_debit;
        $qrer = DB::select(DB::raw("select * from user_registration where user_id='$id'"));
        if (!empty($qrer[0]->acc_name)) {
            $acname = $qrer[0]->acc_name;
        } else {
            $acname = '---';
        }
        if (!empty($qrer[0]->ac_no)) {
            $acno = $qrer[0]->ac_no;
        } else {
            $acno = '---';
        }
        if (!empty($qrer[0]->address)) {
            $address = $qrer[0]->address . "<br>";
        } else {
            $address = '';
        }
        if (!empty($qrer[0]->country)) {
            $country = $qrer[0]->country;
        } else {
            $country = '---';
        }
        $main_bal = 0;
        $Reg_date = date('d M Y', strtotime($qrer[0]->registration_date));
        $cur_date = date('d M Y', strtotime(date('Y-m-d')));
        $result = DB::select(DB::raw("select ur.user_id,ur.username as sender_name,ur1.username as receiver_name,cd.ttype,cd.credit_amt,cd.debit_amt,cd.ewallet_used_by,cd.TranDescription,cd.receive_date from credit_debit cd 
        	left join user_registration ur on cd.sender_id =ur.user_id 
        	left join user_registration ur1 on cd.receiver_id =ur1.user_id where ewallet_used_by='" . $wallets[$wallet_id] . "' and cd.user_id='$id' order by cd.id asc"));

        $head = '<body style="font-family:arial;"><div class="container"> <table style="width:100%; margin-bottom: 50px;overflow:wrap;"> <tr> <td> <img src="' . $url . 'report-logo.png"> <br><br>' . ucwords($qrer[0]->first_name) . ' ' . ucwords($qrer[0]->last_name) . ' <br>' . wordwrap($address, 50, "<br />\n") . $country . '</td><td align="right"> <table style="solid black; margin-top:20px;"> <tr> <td style="padding:10px;">User Name: <b>' . ucwords($qrer[0]->username) . '</b> <br>Account Number: <b>' . $qrer[0]->user_id . '</b><br>Name: <b>' . ucwords($qrer[0]->first_name) . " " . ucwords($qrer[0]->last_name) . '</b> <br><br>Your Account Statement from <br>' . $Reg_date . ' to Till Now</td></tr></table> </td></tr></table> <table style="border:1px solid black; width:100%; border-collapse:collapse;"> <thead>';
        $html = $head . '<tr style="border:1px solid black; padding:5px;"> <th style="border:1px solid black; padding:5px;">Date</th> <th style="border:1px solid black; padding:5px;">Description</th> <th style="border:1px solid black; padding:5px;">US$ In</th> <th style="border:1px solid black; padding:5px;">US$ Out</th><th style="border:1px solid black; padding:5px;">Balance</th> </tr></thead><tbody>';
        $i = 1;
        $total_debit = 0;
        $total_credit = 0;
        $previous = '';
//$tot_bal1 =0;
        foreach ($result as $row) {
            if($row->credit_amt == 0.00 && $row->debit_amt == 0.00){
                continue;
            }
            $sender = $row->sender_name;
            $receiver = $row->receiver_name;
            if (!empty($row->credit_amt)) {
                $credit = $row->credit_amt;
                $tot_bal = $tot_bal + $credit;
            } else {
                $credit = '';
            }
            if (!empty($row->debit_amt)) {
                $debit = $row->debit_amt;
                $tot_bal = $tot_bal - $debit;
            } else {
                $debit = '';
            }
            $description = $row->TranDescription;
            $date = date('d/m/Y', strtotime($row->receive_date));
            //$strtotime = strtotime($date);
            $classdate = date('dmY', strtotime($row->receive_date));
            $classes[$classdate] = array($classdate);

            $current = $classdate;
            $html .= '<tr style="font-size:12px;padding:5px;border:1px solid black; border-left:1px solid #000;border-right:1px solid #000;"><td class="td' . $classdate . '" style="0; padding:5px; border-bottom:2px;width:13%;">' . $date . '</td><td style="border-left:1px solid black; border-right:0px solid black; padding:5px;width:42%;">' . stripslashes($description) . '</td><td style="width:15%;border-left:1px solid black; border-right:1px solid black; padding:5px 5px 5px 5px;" align="right">' . number_format($credit, 2) . '</td><td style="width:15%;border-left:1px solid black; border-right:1px solid black; padding:5px 5px 5px 5px;" align="right">' . number_format($debit, 2) . '</td><td style="width:15%;border-left:1px solid black; border-right:1px solid black; padding:5px 5px 5px 5px;" align="right"><b>' . number_format($tot_bal, 2) . '</b></td></tr>';
            $i++;
            //$tot_bal += 
            $total_credit += $row->credit_amt;
            $total_debit += $row->debit_amt;
            $previous = $current;
        }
        $html .= '<tr style="font-size:12px;border:1px solid black; padding:5px;"><td style="border:0; padding:5px;">&nbsp;</td><td style="border:0; padding:5px 15px 5px 5px;"><b>Total Balance</b></td><td style="padding:5px;" align="right">'.number_format($total_credit,2).'</td><td style="padding:5px;" align="right">'.number_format($total_debit,2).'</td><td style="padding:5px;" align="right">&nbsp;</td></tr>';
        $html .= '</tbody></table></div></body>';
        return $html;
    }

    public static function getLevelUsers($user_id,$level){

        $res = DB::table('matrix_downline1 AS m')
        ->where('m.income_id', '=', $user_id)
        ->where('level', '=', $level)
        ->join('user_registration AS u', 'u.user_id', '=', 'm.down_id')
        ->join('package_purchased_list AS p', 'p.user_id', '=', 'm.down_id')
        ->select('u.user_id','u.username','u.first_name','u.last_name','u.registration_date')
        ->groupBy('p.user_id')->get();
            return $res;
    }

    public static function getLevelUsersAmount($user_id,$level){

        // $res = DB::table('matching_bonus_on_earnings')
        // ->where('user_id', '=', $user_id)
        // ->where('level', '=', $level)
        // ->sum('matching_bonus');
        //     return $res;
        $res = DB::table('matrix_downline1 AS m')
        ->join('package_purchased_list AS p', 'p.user_id', '=', 'm.down_id')
        ->where('m.income_id', '=', $user_id)
        ->where('m.level', '=', $level)
        ->sum('p.package_name');
            return $res;
    }

    public static function requestTac($userid,$username,$mobile){

            $otp = mt_rand(100000, 999999);
            $generated_date = date('Y-m-d H:i:s');

            $otp_text = (string)$otp; 
            $arr = str_split($otp_text, "3"); 
            $otp_new_text = implode("-", $arr);
            if ($otp) {
                $datas = json_encode(array(
                    "ClientCode" => 'Eagle Star',
                    "MobileNo" => $mobile,
                    "UserName" => $username,
                    "TokenId" => $otp_new_text
                ));

                $mystatus = array('Status'=>'Success', 'VCode'=>$otp);

                return $mystatus;
            }else{
                return array();
            }
        }   

    public static function selMemberVerify($userid){
            $quy = DB::table('member_verify')->where('user_id','=',$userid)->first();
            return $quy;
        }       
        
    public static function updateMemberVerify($userid,$updat){
        $qry = DB::table('member_verify')->where('user_id', '=', $userid)->update($updat);
        return $qry;
    }
    
    public static function insertMemberVerify($indat){
        $qey = DB::table('member_verify')->insert($indat);
        return $qey;
    }
    
    public static function insertMemberVerifyId($insdat){
        $qy = DB::table('member_verify')->insertGetId($insdat);
        return $qy;
    }

    public static function getMonthlyEarningPayouts(){
       
        $fdt = date('Y-m-d', strtotime('-11 months'));
        $from_date = date('Y-m-01', strtotime($fdt));
        $to_date = date('Y-m-t');

        $res = DB::table('daily_earnings_settings')
        ->select(\DB::raw('SUM(earnings_percentage) as sum,earnings_perc_for_date'))
        ->whereBetween('earnings_perc_for_date', [$from_date,$to_date])
        ->orderBy('earnings_perc_for_date', 'ASC')
        ->groupBy(DB::raw("MONTH(earnings_perc_for_date)"),DB::raw("YEAR(earnings_perc_for_date)"))->get();

        return $res;    
    }

}