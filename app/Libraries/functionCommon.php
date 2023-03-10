<?php
namespace App\Libraries;
/**
 * PHP Custom Logger 
 * Write to Redis
 * Create by QTA
 * Date: 2021-07-06 20:50:00
 */

class functionCommon
{
    function replace_special_char($string)
    {
        $newStr = str_replace( array( '~', '@', '#', '$', '%', '^', '&', '*', '`', '\'', '"', '\\', '|', '/', '  ', '   '), '', $string);
        return trim($newStr);
    }
    function replace_money_char($string)
    {
        // Replace nhung ky tu nay
        $newStr = str_replace( array( ',', '.', '  ', '   '), '', $string);

        return trim($newStr);
    }
    function checkCharXSS($string)
    {
        if(stristr($string, "'") != FALSE)
            return TRUE;
        elseif(stristr($string, "\"") != FALSE)
            return TRUE; 
        elseif(stristr($string, "`") != FALSE)
            return TRUE;
        elseif(stristr($string, "~") != FALSE)
            return TRUE;
        elseif(stristr($string, "-") != FALSE)
            return TRUE;
        elseif(stristr($string, ";") != FALSE)
            return TRUE;
        elseif(stristr($string, "<") != FALSE)
            return TRUE;
        elseif(stristr($string, ">") != FALSE)
            return TRUE;
        elseif(stristr($string, ",") != FALSE)
            return TRUE;
        elseif(stristr($string, "|") != FALSE)
            return TRUE;
        elseif(stristr($string, "&") != FALSE)
            return TRUE;
        elseif(stristr($string, "!") != FALSE)
            return TRUE;
        elseif(stristr($string, "#") != FALSE)
            return TRUE;
        elseif(stristr($string, "$") != FALSE)
            return TRUE;
        elseif(stristr($string, "%") != FALSE)
            return TRUE;
        elseif(stristr($string, "^") != FALSE)
            return TRUE;        
        elseif(stristr($string, "*") != FALSE)
            return TRUE;
        elseif(stristr($string, "(") != FALSE)
            return TRUE;
        elseif(stristr($string, ")") != FALSE)
            return TRUE;        
        elseif(stristr($string, "+") != FALSE)
            return TRUE;
        elseif(stristr($string, "=") != FALSE)
            return TRUE;
        elseif(stristr($string, "[") != FALSE)
            return TRUE;
        elseif(stristr($string, "]") != FALSE)
            return TRUE;
        elseif(stristr($string, "{") != FALSE)
            return TRUE;
        elseif(stristr($string, "}") != FALSE)
            return TRUE;        
        elseif(stristr($string, "\\") != FALSE)
            return TRUE;
        elseif(stristr($string, ":") != FALSE)
            return TRUE;        
        elseif(stristr($string, "?") != FALSE)
            return TRUE;
        elseif(stristr($string, "/") != FALSE)
            return TRUE;
        return FALSE;	
    }
    function dvvc_name($package_ship){
        $name = '';
        switch ($package_ship){
            case '0201': case '0205': case '0203': case 'KNT': case '48H': $name = 'Chuy???n ph??t Kerry'; break;
            case 'GTK': 'Chuy???n ph??t GHTK'; break;
            case 'PTN': case 'PHS': case 'PHT': case 'VCN': case 'VBK': case 'VBD': case 'VBD_NEW': $name = 'Chuy???n ph??t Viettelpost'; break;
            case '1': case '2': $name = 'Chuy???n ph??t VNPost'; break;
            case 'CHU': $name = 'Chuy???n ph??t Chu???n GHN'; break;
            default : $name = '';
        }
        return $name;
    }
    function array_htmlspecialchars($array = array()){
        if(!empty($array)){
            foreach ($array as $key => $value)
            {
                $array[$key] = @htmlspecialchars($value, ENT_QUOTES);
            }
        }
        return $array;
    }
    function cut_string($str, $length, $char=" ..."){
    	//N???u chu???i c???n c???t nh??? h??n $length th?? return lu??n
    	$strlen	= mb_strlen($str, "UTF-8");
    	if($strlen <= $length) return $str;
    	
    	//C???t chi???u d??i chu???i $str t???i ??o???n c???n l???y
    	$substr	= mb_substr($str, 0, $length, "UTF-8");
    	if(mb_substr($str, $length, 1, "UTF-8") == " ") return $substr . $char;
    	
    	//X??c ?????nh d???u " " cu???i c??ng trong chu???i $substr v???a c???t
    	$strPoint= mb_strrpos($substr, " ", "UTF-8");
    	
    	//Return string
    	if($strPoint < $length - 20) return $substr . $char;
    	else return mb_substr($substr, 0, $strPoint, "UTF-8") . $char;
    }
    function number_roundup100($number = 0){
        $n = $number;
        $hs = 0;
        $nd = $n%100;
        if($nd > 0) $hs = 1;
        return floor($n/100)*100 + $hs*100;
    }
    function number_roundup1000($number = 0){
        $n = $number;
        $hs = 0;
        $nd = $n%1000;
        if($nd > 0) $hs = 1;
        return floor($n/1000)*1000 + $hs*1000;
    }
    function removeSign($str){
        $coDau=array("??","??","???","???","??","??","???","???","???","???","???","??",
        "???","???","???","???","???",
        "??","??","???","???","???","??","???" ,"???","???","???","???",
        "??","??","???","???","??",
        "??","??","???","???","??","??","???","???","???","???","???","??"
        ,"???","???","???","???","???",
        "??","??","???","???","??","??","???","???","???","???","???",
        "???","??","???","???","???",
        "??",
        "??","??","???","???","??","??","???","???","???","???","???","??"
        ,"???","???","???","???","???",
        "??","??","???","???","???","??","???","???","???","???","???",
        "??","??","???","???","??",
        "??","??","???","???","??","??","???","???","???","???","???","??"
        ,"???","???","???","???","???",
        "??","??","???","???","??","??","???","???","???","???","???",
        "???","??","???","???","???",
        "??","??","??","??");
    
        $khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
        "e","e","e","e","e","e","e","e","e","e","e",
        "i","i","i","i","i",
        "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
        "u","u","u","u","u","u","u","u","u","u","u",
        "y","y","y","y","y",
        "d",
        "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
        "E","E","E","E","E","E","E","E","E","E","E",
        "I","I","I","I","I",
        "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
        "U","U","U","U","U","U","U","U","U","U","U",
        "Y","Y","Y","Y","Y",
        "D","e","u","a");
        return str_replace($coDau,$khongDau,$str);
    }
    function getClientIP(){
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');        
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        
        return $ipaddress;
    }
    function string_limiter($str, $n = 500, $endchar = '...')
    {
        if (strlen($str) < $n)
        {
            return $str;
        }
        else{
            return substr($str, 0, $n).$endchar;
        }
    }
    function decodeReUrl($url)
    {
        return base64_decode(urldecode($url));
    }
    function encodeReUrl($url)
    {
        return urlencode(base64_encode($url));
    }
}
?>