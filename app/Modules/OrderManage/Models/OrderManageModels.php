<?php
namespace App\Modules\OrderManage\Models;
/**
 * PHP Redis Custom
 * 
 * Create by QTA
 * Date: 2021-07-06 20:50:00
 */
use App\Libraries\CallServer;
use App\Libraries\Clogger;
use CodeIgniter\Model;


use App\Libraries\Credis;
use Psr\Log\LoggerInterface;

class OrderManageModels extends Model
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
        parent::__construct();
    }
    public function getListOrders($data , $header = [],$username){
        try {
            $this->logger->info('UPDATE_USER: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'filterHistoryOrder',$data,$header)['data'];
            $this->logger->info('========HISTORY =====:'.json_encode($result,JSON_UNESCAPED_UNICODE).'', array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }

    public function getDetailOrder($data, $header){
        try {
            $this->logger->info('========GET_ORDER_DETAIL =====:'.json_encode($data,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_FOOD_PRIVATE.'getHistoryOrderDetail',$data,$header)['data'];
            $this->logger->info('========RESPONSE_DETAIL_ORDER =====:'.json_encode($result,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }
    public function getBox($header, $username){
            $data = [];
            $result = $this->callServer->Get(URL_API_FOOD_PRIVATE.'boxes',$data,$header)['data'];
            return $result;
    }
    public function wrapperOrder($data, $headers, $username){
        try {
            $this->logger->info('UPDATE_WRAPPER_ORDER: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'wrapperOrder',$data,$headers)['data'];
            $this->logger->info('========RESULT_UPDATE_WRAPPER_ORDER=====:'.json_encode($result,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION-WRAPPER-ORDER:'.json_encode($data,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }
    
    public function changeStatus($data, $headers, $username){
        try {
            $this->logger->info('UPDATE_PUSH_ORDER: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'createOrder',$data,$headers)['data'];
            $this->logger->info('========RESULT_UPDATE_PUSH_ORDER=====:'.json_encode($result,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION-WRAPPER-ORDER:'.json_encode($data,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }
    public function cancelOrder($data, $headers, $username){
        try {
            $this->logger->info('UPDATE_CANCEL_ORDER: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'cancelOrder',$data,$headers)['data'];
            $this->logger->info('========RESULT_UPDATE_CANCEL_ORDER=====:'.json_encode($result,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION-CANCEL-ORDER:'.json_encode($data,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }
    public function prepareOrder($data, $headers, $username){
        try {
            $this->logger->info('PREPARE_ORDER: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'addItemToOrder',$data,$headers)['data'];
            $this->logger->info('========RESULT_PREPARE_ORDER=====:'.json_encode($result,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION-CANCEL-ORDER:'.json_encode($data,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }

    public function findAllItemInOrder($data,$header){
        try {
            $result = $this->callServer->Get(URL_API_FOOD_PRIVATE.'findAllItemsInOrder',$data,$header)['data'];
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }
    public function findAllItemTotalInOrder($data,$header){
        try {
            $this->logger->info('==FIND_ALL_ITEM_TOTAL_ORDER====: || '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_FOOD_PRIVATE.'findAllItemTotalInOrder',$data,$header)['data'];
            $this->logger->info('==RESULT_FIND_ALL_ITEM_TOTAL_ORDER====: || '.json_encode($result,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }

    public function searchProduct($data){
        try {
            $result = $this->callServer->Get(URL_API_FOOD_FE.'findProducts',$data)['data'];
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR ========== '.$th);
        }
    }
    public function getProductDetail($data){
        try {
            $result = $this->callServer->Get(URL_API_FOOD_FE.'getFoodProductDetail',$data)['data'];
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }
    public function confirmOrder($data, $header, $username){
        try {
            $this->logger->info('==CONFIRM_ORDER====: '.$username.' || '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'confirmOrder',$data,$header)['data'];
            $this->logger->info('==RESULT_CONFIRM_ORDER====: '.$username.'|| '.json_encode($result,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('======EXCEPTION-CONFIRM_ORDER======:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
        }
    }
    public function getPromotion($data){
        try {
            $this->logger->info('==GET_PROMOTION__==== || '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD.'getProductPromotionInOrder',$data)['data'];
            $this->logger->info('==RESULT_GET_PROMOTION__==== || '.json_encode($result,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR ========== '.$th);
        }
    }
    public function updateOrder($data, $headers, $username){
        try {
            $this->logger->info('==UPDATE_ORDER====: '.$username.' || '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'updateOrder',$data,$headers)['data'];
            $this->logger->info('==RESULT_UPDATE_ORDER====: '.$username.'|| '.json_encode($result,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('======EXCEPTION-UPDATE_ORDER======:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
        }
    }

    public function getListProvinces(){
        try {
            $headers = [];
            $dataCall = [
                'code'=> '',
                'filterString'=>''
            ];
            $result = $this->callServer->Get(URL_API_PUBLIC.'addressCode',$dataCall,$headers)['data'];
            return $result;

        } catch (\Throwable $th) {
            $this->logger->info('ORDER-MANAGER - ===DATA_CHANGE_DIMENSION_ORDER - USERNAME_ERRORS: || ' . $th, array(), 'ERRORS');
        }
    }
    public function getListDistrict($districtReceiver){
        try {
            $headers = [];
            $dataCall = [
                'code'=> $districtReceiver,
                'filterString'=>''
            ];
            $this->logger->info('USERNAME: - DATA_GET_LIST_DISTRICT || ' . json_encode($dataCall,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_PUBLIC.'addressCode',$dataCall,$headers)['data'];
            return $result;

        } catch (\Throwable $th) {
            $this->logger->info('ORDER-MANAGER - ===DATA_CHANGE_DIMENSION_ORDER - USERNAME_ERRORS: || ' . $th, array(), 'ERRORS');
        }
    }

    public function changeInfoReceiver($dataCall, $headers, $username){
        try {
            $this->logger->info('==UPDATE_INFO_ORDER====: '.$username.' || '.json_encode($dataCall,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'updateOrderInfo',$dataCall,$headers)['data'];
            $this->logger->info('==RESULT_UPDATE_INFO_ORDER====: '.$username.'|| '.json_encode($result,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('======EXCEPTION-UPDATE_INFO_ORDER======:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
        }
    }
    public function changeMethodInfo($dataCall, $headers, $username){
        try {
            $this->logger->info('==UPDATE_METHOD_ORDER====: '.$username.' || '.json_encode($dataCall,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'updateOrderMethod',$dataCall,$headers)['data'];
            $this->logger->info('==RESULT_UPDATE_METHOD_ORDER====: '.$username.'|| '.json_encode($result,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('======EXCEPTION-UPDATE_METHOD_ORDER======:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
        }
    }
    public function getMethods(){
        try {
            $dataCall = [
                'method'=>'ALL',
                'login'=> 1
            ];
            $result = $this->callServer->Get(URL_API_FOOD_FE.'getMethod',$dataCall)['data'];
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('======EXCEPTION-CALL-METHODS======:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
        }
    }
    public function exportExcelOrder($data, $headers){
        try {
            $this->logger->info('==EXPORT_EXCEL_ORDER====: || '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $this->logger->info('==LINK_EXPORT_EXCEL_ORDER====: || '.URL_API_FOOD.'exportReport'.'', array(), 'CALL_API');
            $result = $this->callServer->GetByte(URL_API_FOOD.'exportReport',$data,$headers);
            $this->logger->info('==RESPONSE_EXPORT_EXCEL_ORDER====: || '.json_encode($result,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('======EXCEPTION-CALL-METHODS======:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
        }
    }

    public function deleteItemInOrder($data, $headers){
        try {
            $this->logger->info('==DELETE_ITEM_PREPARE_ORDER==== || '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_FOOD_PRIVATE.'deleteItemInOrder',$data,$headers)['data'];
            $this->logger->info('==RESULT_DELETE_ITEM_PREPARE_ORDER====|| '.json_encode($result,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('======EXCEPTION-DELETE_ITEM_PREPARE_ORDER======:'.json_encode($th,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
        }
    }
    
}
?>