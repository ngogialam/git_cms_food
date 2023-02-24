<?php
namespace App\Modules\Authenticator\Models;
/**
 * PHP Redis Custom
 * 
 * Create by QTA
 * Date: 2021-07-06 20:50:00
 */
use App\Libraries\CallServer;
use App\Libraries\Clogger;

use Psr\Log\LoggerInterface;

class AuthenticatorModels
{
    /**
	 * Constructor.
	 *
	 * @param LoggerInterface   $logger
	 *
	 */
    protected $logger;

    public function __construct(LoggerInterface $logger) {
		$this->callServer    			= new CallServer();
        $this->clog = new Clogger(\Config\Services::request());
        $this->logger = $logger; 
    }

    public function login($username, $data){
        try {
            $this->clog->info('LOGIN','======DATA_LOGIN_USERNAME:'.$username,json_encode($data,JSON_UNESCAPED_UNICODE));
            $this->logger->info('=====LOGIN: '.$username .' - DATA_LOGIN_USERNAME || ' . json_encode($data,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');

            $result = $this->callServer->PostJson(URL_API_PUBLIC.'authenticate',$data)['data'];
            
            $this->clog->info('LOGIN','======RESPONSE_DATA_LOGIN_USERNAME:'.$username,json_encode($result,JSON_UNESCAPED_UNICODE));
            $this->logger->info('=====LOGIN: '.$username .' - RESPONSE_DATA_LOGIN_USERNAME || ' . json_encode($result,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;

        } catch (\Throwable $th) {
            $this->clog->info('LOGIN','===DATA_LOGIN_USERNAME_ERRORS:'.$username,$th);
            $this->logger->info('LOGIN - ===DATA_GET_LOGIN - USERNAME_ERRORS: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
}
?>