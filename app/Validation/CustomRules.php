<?php
namespace App\Validation;

class CustomRules{
  // public 
  // Rule is to validate mobile number digits
  // protected static $validation  =  \Config\Services::validation();

    public function checkGreater($str = null, string $param = null){
        if($str == '0'){
            return false;
        }else if($str == ''){
            return false;
        }else{
            return true;
        }
    }

    public function phoneValidate(string $str, string &$error = null): bool
    {
        $phone =$str;
        if(preg_match('/(0[0])+([0-9]{9})\b/',$phone)){     
            return false;
        }else if(!preg_match('/^[0-9]+$/',$phone) && !preg_match('/(\+84)+([0-9]{9})\b|(0[2])+([0-9]{9})\b/',$phone) ){   
            return false;
        }else if (!preg_match('/(0[2|3|5|7|8|9])+([0-9]{8})\b|(\+84)+([0-9]{9})\b|(0[2])+([0-9]{9})\b/', $phone)) {    
            return false;
        }
        return true;
    }

    public function passwordValidate(string $str, string &$errors = null): bool
    {
        $password = $str;
        // echo $password;die;
        if(preg_match('/^(?=.{8,15}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/',$password)){
            return true;
        }
        return false;

    }
    
}