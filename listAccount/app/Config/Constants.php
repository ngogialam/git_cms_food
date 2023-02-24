<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//Define time 
define('TIME_DEVICE', '315360000');
define('TIME_REMEMBER_LOGIN', '604800');
define('TIME_LOGIN', '86400');
define('TIME_ORDER_DRAFT', '72000');
define('TIME_DATA_ORDER', '300');
define('PERPAGE', '20');
define('CONFIG_FEE_WITHDRAW', '3300');
define('CUSTOMER_NAME_VA', 'CONG TY CO PHAN CONG NGHE VA DICH VU IMEDIA');
define('MAX_OTP_TO_DAY', '3');
define('FILE_NAME_IMPORT_EXCEL_NEW', 'HLS280721');

//Link API 
define('URL_API_PUBLIC', 'https://haloship.imediatech.com.vn/warehouse/api/public/');
// define('URL_API_PRIVATE','http://192.168.100.190:8027/api/');

// Api partner 
define('URL_API_ACCOUNT', 'http://192.168.100.197:2108/dish/api/manager/');
//end 
define('URL_API_PUBLIC_PROVINCE', 'http://192.168.100.190:2000/');
define('URL_API_PRIVATE', 'https://haloship.imediatech.com.vn/warehouse/api/');
define('HOTLINE', '1900 2345 39');
define('KHO_IN', '75x80');
define('COVID', '');
define('GROUP_PERMISSION', '{"FOOD_ADMIN":"ADMIN","FOOD_MANAGER":"Quản lý sản phẩm","FARM_MANAGER":"Quản lý trang trại","FACTORY_MANAGER":"Quản lý chế biến" }');
define('GROUP_SEASONAL', '{"Mùa Xuân":"Mùa Xuân","Mùa Hạ":"Mùa Hạ","Mùa Thu":"Mùa Thu","Mùa Đông":"Mùa Đông","Quanh năm":"Quanh năm"}');
define('METHODS_TYPE', '{"1":"PHƯƠNG THỨC ĐẶT HÀNG","2":"PHƯƠNG THỨC GIAO HÀNG","3":"CÁCH THỨC VẬN CHUYỂN","4":"PHƯƠNG THỨC THANH TOÁN"}');
define('PRICE_TYPE', '{"1":"Gram","2":"Quả","3":"Chiếc","4":"Bó","5":"Con","6":"Cái","7":"Túi","8":"Bao","9":"Thùng","10":"ml","11":"Bộ","12":"Chai","13":"Hũ","14":"Hộp"}');
//connect DB

define('USER', 'holaship3');
define('PASS', 'Test#123');
define('CONNECTION_STRING', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.100.196)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=holatest)))');
define('DB_NAME', 'HOLASHIP3');
define('PASSWORD_USER_DEFAULT', 'Imedia123!@#');
define('PID_DANH_MUC_SAN_PHAM', '1');
define('PID_COOKING_RECIPE', '3');
define('URL_API_UPLOADIMG', 'https://haloship.imediatech.com.vn/');
// define('URL_LOGIN','https://192.168.100.170:8010/');
define('URL_LOGIN', 'https://192.168.100.133:8072');
define('URL_CMS_KHO', 'https://192.168.100.133:8072/danh-sach-don-hang/tat-ca');

define('CATEGORY_BANNERS', '103');
define('URL_IMAGE_CMS', 'https://192.168.100.133:8072');
define('URL_IMAGE_SHOW', 'https://haloship.imediatech.com.vn/');

define('URL_API_FOOD_FE', 'http://192.168.100.190:2000/food/api/public/');
define('URL_API_FOOD', 'http://192.168.100.190:2022/food-cms/api/public/');
define('URL_API_FOOD_PRIVATE', 'http://192.168.100.190:2022/food-cms/api/');

// ID Set

define('ID_SET', 203);
define('SET_TYPE', 4);
define('ID_SET_USER', 204);
define('URL_API_DISH', 'http://192.168.100.197:2108/dish/api/');
define('ID_RESTAURANT', 4);
