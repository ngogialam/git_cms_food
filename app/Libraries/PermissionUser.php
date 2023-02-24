<?php
namespace App\Libraries;
/**
 * PHP Redis Custom
 * 
 * Create by QTA
 * Date: 2021-07-06 20:50:00
 */

use App\Libraries\Credis;
use App\Libraries\CallServer; 
use Psr\Log\LoggerInterface;

class PermissionUser
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
    public function getPermission($dataUser, $dataParamPerrmission)
    {
        $token = $dataUser->token;
		$headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization:' . $token,
        ];
        $this->logger->info('USERNAME: '.$dataUser->username .' - CHECK_PERMISSION ||  '. json_encode($dataParamPerrmission,JSON_UNESCAPED_UNICODE) , array(), 'CHECK_PERMISSION');
        $result = $this->callServer->PostJson(URL_API_PRIVATE.'permission', $dataParamPerrmission ,$headers)['data'];
        $this->logger->info('USERNAME: '.$dataUser->username .' - RESPONSE_CHECK_PERMISSION || ' . json_encode($result,JSON_UNESCAPED_UNICODE), array(), 'CHECK_PERMISSION');
        if($result->status == 100){
			return redirect()->to('/dang-xuat');
		}
        return $result;
    }
}
?>