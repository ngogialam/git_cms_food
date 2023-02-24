<?php
if (!function_exists('encodeReUrl')) {
    function encodeReUrl($url)
    {
        return urlencode(base64_encode($url));
    }
}

if (!function_exists('decodeReUrl')) {
    function decodeReUrl($url)
    {
        return base64_decode(urldecode($url));
    }
}
if (!function_exists('string_limiter')) {
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
}

if(!function_exists('getClientIP')){
    /**
     * @return ip
     * @author: Thuongnv
     */
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
}

if (!function_exists('removeSign')) {
    function removeSign($str){
        $coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
        "ằ","ắ","ặ","ẳ","ẵ",
        "è","é","ẹ","ẻ","ẽ","ê","ề" ,"ế","ệ","ể","ễ",
        "ì","í","ị","ỉ","ĩ",
        "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
        "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
        "ỳ","ý","ỵ","ỷ","ỹ",
        "đ",
        "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
        "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
        "Ì","Í","Ị","Ỉ","Ĩ",
        "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
        "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
        "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
        "Đ","ê","ù","à");
    
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
}
if (!function_exists('number_roundup1000')){
    function number_roundup1000($number = 0){
        $n = $number;
        $hs = 0;
        $nd = $n%1000;
        if($nd > 0) $hs = 1;
        return floor($n/1000)*1000 + $hs*1000;
    }
}    
if (!function_exists('number_roundup100')){
    function number_roundup100($number = 0){
        $n = $number;
        $hs = 0;
        $nd = $n%100;
        if($nd > 0) $hs = 1;
        return floor($n/100)*100 + $hs*100;
    }
}
if (!function_exists('cut_string')){
    function cut_string($str, $length, $char=" ..."){
    	//Nếu chuỗi cần cắt nhỏ hơn $length thì return luôn
    	$strlen	= mb_strlen($str, "UTF-8");
    	if($strlen <= $length) return $str;
    	
    	//Cắt chiều dài chuỗi $str tới đoạn cần lấy
    	$substr	= mb_substr($str, 0, $length, "UTF-8");
    	if(mb_substr($str, $length, 1, "UTF-8") == " ") return $substr . $char;
    	
    	//Xác định dấu " " cuối cùng trong chuỗi $substr vừa cắt
    	$strPoint= mb_strrpos($substr, " ", "UTF-8");
    	
    	//Return string
    	if($strPoint < $length - 20) return $substr . $char;
    	else return mb_substr($substr, 0, $strPoint, "UTF-8") . $char;
    }
}
if(!function_exists('array_htmlspecialchars')){ // Chuyển ký tự từ ứng dụng sang thực thể HTML
    function array_htmlspecialchars($array = array()){
        if(!empty($array)){
            foreach ($array as $key => $value)
            {
                $array[$key] = @htmlspecialchars($value, ENT_QUOTES);
            }
        }
        return $array;
    }
}
if(!function_exists('dvvc_name')){ // Lấy tên đơn vị vận chuyển theo mã
    function dvvc_name($package_ship){
        $name = '';
        switch ($package_ship){
            case '0201': case '0205': case '0203': case 'KNT': case '48H': $name = 'Chuyển phát Kerry'; break;
            case 'GTK': 'Chuyển phát GHTK'; break;
            case 'PTN': case 'PHS': case 'PHT': case 'VCN': case 'VBK': case 'VBD': case 'VBD_NEW': $name = 'Chuyển phát Viettelpost'; break;
            case '1': case '2': $name = 'Chuyển phát VNPost'; break;
            case 'CHU': $name = 'Chuyển phát Chuẩn GHN'; break;
            default : $name = '';
        }
        return $name;
    }
}

if ( ! function_exists('checkCharXSS'))
{
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
}

if ( ! function_exists('replace_special_char'))
{
    function replace_special_char($string)
    {
        //        $string = "10 cây Mai Con (2 cam, 4 cúc, 4 trắng) giá 45k/1 cây = 450k miễn ship + tặng 1 cây.\\";
//        echo $string . '<br><br>';
        
        // Tat ca ky tu dac biet
//        $title = str_replace( array( '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '`', '-', '=', '[', ']', '{', '}', ';', ':', '\'', '"', '\\', '|', ',', '<', '.', '>', '/', '?' ), ' ', $string);
        
        // Cho phep nhung ky tu nay
//        $title = str_replace( array( '!', '(', ')', '_', '+', '-', '=', '[', ']', '{', '}', ';', ':', ',', '<', '.', '>', '?' ), ' ', $string);
        
        // Replace nhung ky tu nay
        $newStr = str_replace( array( '~', '@', '#', '$', '%', '^', '&', '*', '`', '\'', '"', '\\', '|', '/', '  ', '   '), ' ', $string);
//        echo $title;die();        

        return trim($newStr);
    }
}

if ( ! function_exists('replace_money_char'))
{
    function replace_money_char($string)
    {
        //        $string = "10 cây Mai Con (2 cam, 4 cúc, 4 trắng) giá 45k/1 cây = 450k miễn ship + tặng 1 cây.\\";
//        echo $string . '<br><br>';
        
        // Tat ca ky tu dac biet
//        $title = str_replace( array( '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '`', '-', '=', '[', ']', '{', '}', ';', ':', '\'', '"', '\\', '|', ',', '<', '.', '>', '/', '?' ), ' ', $string);
        
        // Cho phep nhung ky tu nay
//        $title = str_replace( array( '!', '(', ')', '_', '+', '-', '=', '[', ']', '{', '}', ';', ':', ',', '<', '.', '>', '?' ), ' ', $string);
        
        // Replace nhung ky tu nay
        $newStr = str_replace( array( ',', '.', '  ', '   '), ' ', $string);
//        echo $title;die();        

        return trim($newStr);
    }
}
?>