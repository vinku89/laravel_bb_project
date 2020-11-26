<?php

namespace App\Http\Middleware;

use Closure;
use App\RolesPermissions;
use App\Left_menu;
use DB;

class PageName 
{
    public function handle($request, Closure $next)
    {
        
		// echo $request->user()->user_role;
		// exit();
		
		$user_role = $request->user()->user_role;
		//$menuname = \$request()->segment(2);
		$menuname = \Request::segment(1);
		
		$menulist = Left_menu::where(['menu_link' => $menuname,'status' => 1])->get();
		//echo '<pre>';print_R($menulist);exit;
		if(@count($menulist)>0){

			$i=0;$j=0;
			foreach($menulist as $menu){
				//echo '<pre>';print_R($menu);exit;
				$menu_id = 	$menu['id'];

				$leaderquery = "SELECT * FROM roles_permissions WHERE FIND_IN_SET($menu_id,parent_menus) AND id=$user_role";
				$result = DB::select(DB::raw($leaderquery));
				
				$i +=count($result);
				//echo 'p'.$i.'-'.count($result);
			}

			foreach($menulist as $menu){
				$menu_id = 	$menu['id'];
			
				$leaderquery1 = "SELECT * FROM roles_permissions WHERE FIND_IN_SET($menu_id,child_menus) AND id=$user_role";
				$result1 = DB::select(DB::raw($leaderquery1));

				$j +=count($result1);
				//echo 'p'.$j.'-'.count($result1);
			}
			
			if($i>0){
				return $next($request);
			}else if($j>0){
				return $next($request);
			}else{
				return redirect('logout');
			}
			
			/*$query = RolesPermissions::where('role_type','=',$user_role)->whereRaw('FIND_IN_SET($menu_id,parent_menus)')->first();
			$query2 = RolesPermissions::where('role_type','=',$user_role)->whereRaw('FIND_IN_SET($menu_id,child_menus)')->first();
			
			if( ($query >0) || ($query2 >0)){
				return $next($request);
			}else{
				return redirect('logout');
			}*/
			
		}else{
			
			//return redirect('logout');
			return $next($request);
		}
       
    }
 
}


        
