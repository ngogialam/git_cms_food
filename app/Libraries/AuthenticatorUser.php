<?php
namespace App\Libraries;
/**
 * PHP Redis Custom
 * 
 * Create by QTA
 * Date: 2021-07-06 20:50:00
 */

use App\Libraries\Credis;
class AuthenticatorUser
{
    public function getAuthenticator()
    {
        $this->redis = new Credis();
        $krd = get_cookie('__wkrd');
        if(!$krd){
            header("Location: ".URL_LOGIN);
			die;
        }
        $result = $this->redis->get($krd);
        
        if(empty($result)){
            $krd = setcookie ("__wkrd",null, -1, '/'); 
            header("Location: ".URL_LOGIN);
			die;
        }
        return json_decode($result);
    }

    public function redirectPage(){
        $this->redis = new Credis();
        $krd = get_cookie('__wkrd');
        if(!$krd){
            header("Location: ".URL_LOGIN);
			die;
        }
        $result = json_decode($this->redis->get($krd));
        $role = $result->role;
        $arrRole = explode('_', $role);
		if($role != 'ADMIN'){
			if(is_array($arrRole) && !in_array('FOOD',$arrRole) && !in_array('FARM',$arrRole) && !in_array('FACTORY',$arrRole)){
				header("Location: ".URL_CMS_KHO);
				die;
			}
		}
    }

}
?>