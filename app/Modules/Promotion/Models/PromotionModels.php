<?php 
namespace App\Modules\Promotion\Models;
/**
 * PHP Redis Custom
 * 
 * Create by QTA
 * Date: 2021-07-06 20:50:00
 */
use App\Libraries\CallServer;
use App\Libraries\Clogger;
use CodeIgniter\Model;

use Psr\Log\LoggerInterface;

class PromotionModels extends Model{
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

    public function getListPromotion($conditions = []){
        $this->builder = $this->db->table('FOOD_PROMOTION');
        $this->builder->select('ID, NAME, LIMIT_APPLY, MEASURE_CONDITION, CONDITION, CREATED_BY, STATUS, QUANTITY_MAX, PID');
        $this->builder->select('TO_CHAR(CREATED_DATE, \'DD/MM/YYYY HH24:MI:SS\') CREATED_DATE');
        $this->builder->select('TO_CHAR(STARTED_DATE, \'DD/MM/YYYY\') STARTED_DATE');
        $this->builder->select('TO_CHAR(STOPPED_DATE, \'DD/MM/YYYY\') STOPPED_DATE');
        $this->builder->select('(SELECT USERS.NAME FROM USERS WHERE USERS.ID = FOOD_PROMOTION.CREATED_BY) CREATED_NAME');
        $this->builder->select('(SELECT NAME FROM FOOD_PRODUCTS WHERE FOOD_PRODUCTS.ID = FOOD_PROMOTION.PRODUCT_ID) PRODUCT_NAME');
        if(!empty($conditions['started'])){
            $this->builder->where('STOPPED_DATE BETWEEN TO_DATE(\''.$conditions['started'].'\', \'DD/MM/YYYY\') AND TO_DATE(\''.$conditions['stoped'].'\', \'DD/MM/YYYY\')');
        }
        if(isset($conditions['status']) && $conditions['status'] != -1){
            $this->builder->where('STATUS', $conditions['status']);
        }else{
            
        }
        if(!empty($conditions['namePromotion'])){
            $this->builder->where('(UPPER(NAME) like UPPER(\'%'.$conditions['namePromotion'].'%\') OR PRODUCT_ID IN (SELECT ID FROM FOOD_PRODUCTS WHERE UPPER(NAME) like UPPER(\'%'.$conditions['namePromotion'].'%\')))');
        }
        $this->builder->orderBy('ID', 'ASC');
        // print_r($this->builder->getCompiledSelect());die;
        $results = $this->builder->get()->getResultArray();
        return $results;
    }

    public function getListPromotionDetail($idPromotion) {
        $this->builder = $this->db->table('FOOD_PROMOTION_DETAIL');
        $this->builder->select('FOOD_PROMOTION_DETAIL.PRICE, FOOD_PROMOTION_DETAIL.QUANTITY');
        $this->builder->select('FOOD_PRODUCT_PRICE.WEIGHT, FOOD_PRODUCTS.NAME');
        $this->builder->join('FOOD_PRODUCT_PRICE', 'FOOD_PRODUCT_PRICE.ID = FOOD_PROMOTION_DETAIL.PRODUCT_PRICE_ID','LEFT');
        $this->builder->join('FOOD_PRODUCTS', 'FOOD_PRODUCTS.ID = FOOD_PRODUCT_PRICE.PRODUCT_ID','LEFT');
        $this->builder->where('FOOD_PROMOTION_DETAIL.PROMOTION_ID = '.$idPromotion);
        $this->builder->orderBy('FOOD_PROMOTION_DETAIL.ID', 'ASC');
        // print_r($this->builder->getCompiledSelect());die;
        $result = $this->builder->get()->getResultArray();
        return $result;
    }

    public function getProduct(){
        $this->builder = $this->db->table('FOOD_PRODUCTS');
        $this->builder->select('ID, NAME');
        $this->builder->where('TYPE = 1');
        $this->builder->orderBy('NAME', 'ASC');
        $result = $this->builder->get()->getResultArray();
        $str = '';
        foreach ($result as $key => $value) {
            $str .= '<option value="'.$value['ID'].'">'.$value['NAME'].'</option>';
        }
        return $str;
    }

    public function getProductPrice($productId){
        $this->builder = $this->db->table('FOOD_PRODUCT_PRICE');
        $this->builder->select('ID, WEIGHT, STATUS');
        $this->builder->where('PRODUCT_ID = '.$productId);
        // $this->builder->where('STATUS = 1');
        $this->builder->orderBy('ID', 'ASC');
        $result = $this->builder->get()->getResultArray();
        $str = '<option value="">Chọn cách đóng gói</option>';
        foreach ($result as $key => $value) {
            if($value['STATUS'] == 1){
                $status = 'Active';
            }else{
                $status = 'Inactive';
            }
            $str .= '<option value="'.$value['ID'].'">'.$value['WEIGHT'].' Gram - '.$status.'</option>';
        }
        return $str;
    }

    public function createPromotion($data, $started, $stoped){
        try {
            $this->builder = $this->db->table('FOOD_PROMOTION');
            $this->builder->set('ID', 'FOOD_PROMOTION_SEQ.NEXTVAL', FALSE);
            $this->builder->set('STARTED_DATE', 'TO_DATE(\''.$started.'\', \'DD/MM/YYYY\')', FALSE);
            $this->builder->set('STOPPED_DATE', 'TO_DATE(\''.$stoped.'\', \'DD/MM/YYYY\')', FALSE);
            if($this->builder->insert($data)){
                $this->builder = $this->db->table('FOOD_PROMOTION');
                $this->builder->select('MAX(ID) id');
                $result = $this->builder->get()->getResultArray();
                return $result[0]['ID'];
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_UPDATE_PRODUCT_HOLA: || ' . $th, array(), 'ERRORS');
        }
        
    }

    public function createPromotionDetail($data){
        $this->builder = $this->db->table('FOOD_PROMOTION_DETAIL');
        $this->builder->set('ID', 'FOOD_PROMOTION_DETAIL_SEQ.NEXTVAL', FALSE);
        if($this->builder->insert($data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function updateBanners($id, $data){
        $this->builder = $this->db->table('FOOD_BANNERS');
        $this->builder->set('EDITED_DATE', 'SYSTIMESTAMP', FALSE);
        $this->builder->where('ID', $id);
        if($this->builder->update($data)){
            return true;
        }else{
            return false;
        }
    }

    public function getBannersById($id){
        $this->builder = $this->db->table('FOOD_BANNERS');
        $this->builder->select('ID as id, NAME as nameBanners, IMAGE as image, CATEGORY_ID as categoryId, LINK as link, STATUS as statusBanners, CONTENT as contentBanners');
        $this->builder->where('ID', $id);
        $result = $this->builder->get()->getResultArray();
        if($result){
            return $result[0];
        }else{
            return [];
        }
    }

    public function disablePromotion($id, $data){
        try {
            $update = 'UPDATE FOOD_PROMOTION SET EDITED_BY = '.$data['EDITED_BY'].', EDITED_DATE = SYSTIMESTAMP, STATUS = '.$data['STATUS'].' WHERE ID IN('.$id.') OR PID IN('.$id.')';
            $results = $this->db->query($update);
            if($results){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_REMOVE_PROMOTION_HOLA: || ' . $th, array(), 'ERRORS');
        }

    }

    public function disablePromotionOrder($id, $data){
        try {
            $update = 'UPDATE FOOD_PROMOTION_ORDER SET EDITED_BY = '.$data['EDITED_BY'].', EDITED_DATE = SYSTIMESTAMP, STATUS = '.$data['STATUS'].' WHERE ID IN('.$id.')';
            $results = $this->db->query($update);
            if($results){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_REMOVE_PROMOTION_ORDER_HOLA: || ' . $th, array(), 'ERRORS');
        }

    }
    
    public function updatePromotionOrder($id, $started, $stoped){
        $this->builder = $this->db->table('FOOD_PROMOTION_ORDER');
        $this->builder->set('EDITED_DATE', 'SYSTIMESTAMP', FALSE);
        $this->builder->set('STARTED_DATE', 'TO_DATE(\''.$started.' 00:00:00\', \'DD/MM/YYYY HH24:MI:SS\')', FALSE);
        $this->builder->set('STOPPED_DATE', 'TO_DATE(\''.$stoped.' 23:59:59\', \'DD/MM/YYYY HH24:MI:SS\')', FALSE);
        $this->builder->where('ID', $id);
        if($this->builder->update()){
            return true;
        }else{
            return false;
        }
    }

    public function createPromotionOrder($data, $started, $stoped){
        try {
            $this->builder = $this->db->table('FOOD_PROMOTION_ORDER');
            $this->builder->set('ID', 'FOOD_PROMOTION_ORDER_SEQ.NEXTVAL', FALSE);
            $this->builder->set('STARTED_DATE', 'TO_DATE(\''.$started.' 00:00:00\', \'DD/MM/YYYY HH24:MI:SS\')', FALSE);
            $this->builder->set('STOPPED_DATE', 'TO_DATE(\''.$stoped.' 23:59:59\', \'DD/MM/YYYY HH24:MI:SS\')', FALSE);
            if($this->builder->insert($data)){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_UPDATE_PRODUCT_HOLA: || ' . $th, array(), 'ERRORS');
        }
        
    }

    public function getListPromotionOrder($conditions = []){
        $this->builder = $this->db->table('FOOD_PROMOTION_ORDER');
        $this->builder->select('ID, TYPE, MEASURE_CONDITION, NAME, CONDITION, DISCOUNT_VALUE, DISCOUNT_MAX, STATUS');
        $this->builder->select('TO_CHAR(CREATED_DATE, \'DD/MM/YYYY HH24:MI:SS\') CREATED_DATE');
        $this->builder->select('TO_CHAR(STARTED_DATE, \'DD/MM/YYYY\') STARTED_DATE');
        $this->builder->select('TO_CHAR(STOPPED_DATE, \'DD/MM/YYYY\') STOPPED_DATE');
        $this->builder->select('(SELECT USERS.NAME FROM USERS WHERE USERS.ID = FOOD_PROMOTION_ORDER.CREATED_BY) CREATED_NAME');
        if(!empty($conditions['started'])){
            $this->builder->where('STOPPED_DATE BETWEEN TO_DATE(\''.$conditions['started'].'\', \'DD/MM/YYYY\') AND TO_DATE(\''.$conditions['stoped'].'\', \'DD/MM/YYYY\')');
        }
        if(isset($conditions['status']) && $conditions['status'] != -1){
            $this->builder->where('STATUS', $conditions['status']);
        }
        if(isset($conditions['type']) && $conditions['type'] != -1){
            $this->builder->where('TYPE', $conditions['type']);
        }
        if(!empty($conditions['namePromotion'])){
            $this->builder->where('(UPPER(NAME) like UPPER(\'%'.$conditions['namePromotion'].'%\') )');

        }
        $this->builder->orderBy('ID', 'ASC');
        // print_r($this->builder->getCompiledSelect());die;
        $results = $this->builder->get()->getResultArray();
        return $results;
    }

    public function getPromotionOrder($promotionOrderId){
        $this->builder = $this->db->table('FOOD_PROMOTION_ORDER');
        $this->builder->select('ID as id, TYPE as typePromotion, TO_CHAR(STARTED_DATE, \'DD/MM/YYYY\') as started,  TO_CHAR(STOPPED_DATE, \'DD/MM/YYYY\') as stopped, MEASURE_CONDITION as measurePromotion, NAME as namePromotion, CONDITION as conditionPromotion, DISCOUNT_VALUE as discountValue, DISCOUNT_MAX as discountMax, STATUS as statusPromotion');
        $this->builder->where('ID', $promotionOrderId);
        $results = $this->builder->get()->getResultObject();
        return $results;
    }
    public function checkExistPromotion($nameStatus, $type){
        if($type == 1){
            $this->builder = $this->db->table('FOOD_PROMOTION');
        }else{
            $this->builder = $this->db->table('FOOD_PROMOTION_ORDER');
        }
        $this->builder->select('ID')->where('NAME', $nameStatus);
        $result = $this->builder->get()->getResultArray();
        return $result;
    }
    public function createSetPromotion($data, $header, $username){
        try {
            $this->logger->info('CREATE_SET_PROMOTION: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE.'createSetPromotion',$data,$header)['data'];
            $this->logger->info('========RESULT_CREATE_SET_PROMOTION=====:'.json_encode($result,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION_RESULT_CREATE_SET_PROMOTION:'.json_encode($data,JSON_UNESCAPED_UNICODE),array(),'ERRORS');
            $this->logger->info('DATA ========== '.$th, array(),'ERRORS');
        }
    }
}