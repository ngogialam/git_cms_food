<?php
namespace App\Modules\Reviews\Models;
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

class ReviewsModels extends Model
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
    public function getListReviews($arrSearch, $conditions){
        
        $this->builder = $this->db->table('FOOD_PRODUCT_VOTE');
        $this->builder->select("FOOD_PRODUCT_VOTE.ID, FOOD_PRODUCT_VOTE.CUSTOMER_ID, FOOD_PRODUCT_VOTE.SCORES, FOOD_PRODUCT_VOTE.COMMENTS, FOOD_PRODUCT_VOTE.PRODUCT_ID,
        TO_CHAR(FOOD_PRODUCT_VOTE.CREATED_DATE, 'DD/MM/YYYY HH24:MI:SS') AS CREATED_DATE, FOOD_PRODUCT_VOTE.IS_SHOW, FOOD_PRODUCT_VOTE.ORDER_CODE, FOOD_PRODUCT_VOTE.ORDER_ID, FOOD_PRODUCT_VOTE.STATUS, FOOD_PRODUCTS.NAME AS PRODUCT_NAME, FOOD_PRODUCT_VOTE_IMG.IMAGE AS IMAGE
         ");

        $this->builder->join('FOOD_PRODUCTS', 'FOOD_PRODUCTS.ID = FOOD_PRODUCT_VOTE.PRODUCT_ID','LEFT');
        $this->builder->join('FOOD_PRODUCT_VOTE_IMG', 'FOOD_PRODUCT_VOTE.ID = FOOD_PRODUCT_VOTE_IMG.VOTE_ID','LEFT');

        if(isset($arrSearch['methodsType']) && $arrSearch['methodsType'] != 0){
            $this->builder->where('FOOD_PRODUCT_VOTE.PRODUCT_ID', $arrSearch['methodsType']);
        }

        if(isset($arrSearch['status']) && $arrSearch['status'] != -1){
            $this->builder->where('FOOD_PRODUCT_VOTE.STATUS', $arrSearch['status']);
        }

        if(isset($arrSearch['methodsShow']) && $arrSearch['methodsShow'] != -1){
            $this->builder->where('FOOD_PRODUCT_VOTE.IS_SHOW', $arrSearch['methodsShow']);
        }

        if(isset($arrSearch['methodsName']) && $arrSearch['methodsName'] != ''){
            $this->builder->where("UPPER(FOOD_PRODUCT_VOTE.COMMENTS) LIKE UPPER('%".$arrSearch['methodsName']."%')");
        }

        $this->builder->orderBy('IS_SHOW', 'DESC');

        $sql = $this->builder->getCompiledSelect();
        if (!empty($conditions['LIMIT'])) {
            $sql = $this->builder->limit($sql,$conditions['LIMIT'], $conditions['OFFSET']);
        }
 
        $results = $this->db->query($sql)->getResultArray();
        return $results;
    }

 

    public function getTotalReviews($arrSearch){
        $this->builder = $this->db->table('FOOD_PRODUCT_VOTE');
        $this->builder->select("COUNT(*) AS TOTAL");
        
        if(isset($arrSearch['methodsType']) && $arrSearch['methodsType'] != 0){
            $this->builder->where('PRODUCT_ID', $arrSearch['methodsType']);
        }

        if(isset($arrSearch['status']) && $arrSearch['status'] != -1){
            $this->builder->where('STATUS', $arrSearch['status']);
        }

        if(isset($arrSearch['methodsShow']) && $arrSearch['methodsShow'] != -1){
            $this->builder->where('IS_SHOW', $arrSearch['methodsShow']);
        }

        if(isset($arrSearch['methodsName']) && $arrSearch['methodsName'] != ''){
            $this->builder->where("UPPER(COMMENTS) LIKE UPPER('%".$arrSearch['methodsName']."%')");
        }
        
        $result = $this->builder->get()->getResultArray();
        return $result[0]['TOTAL'];
    }

    public function getListProducts($username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCTS');
            $this->builder->select('FOOD_PRODUCTS.ID, FOOD_PRODUCTS.NAME');
            $this->builder->orderBy('FOOD_PRODUCTS.ID', 'DESC');
            $this->builder->where('FOOD_PRODUCTS.STATUS', 1);
            $results = $this->builder->get()->getResultObject();
            return $results;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_GROUP_PERMISSION: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function createReviews($data, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_VOTE');
            $this->builder->set('ID', 'FOOD_PRODUCT_VOTE_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($data)){
                $this->logger->info('CREATE_REVIEWS_HOLA: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                $sqlMax = 'select FOOD_PRODUCT_VOTE_SEQ.CURRVAL from DUAL';
                $results = $this->db->query($sqlMax)->getResultArray();
                return $results[0];
            }else{
                $this->logger->info('CREATE_REVIEWS_HOLA_FAIL: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_REVIEWS_HOLA_DATA: '.$username .'|| ' . json_encode($data,JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('ERROR_CREATE_REVIEWS_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function createReviewsImg($data, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_VOTE_IMG');
            $this->builder->set('ID', 'FOOD_PRODUCT_VOTE_IMG_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($data)){
                $this->logger->info('CREATE_REVIEWS_IMG_HOLA: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_REVIEWS_IMG_HOLA_FAIL: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_REVIEWS_IMG_HOLA_DATA: '.$username .'|| ' . json_encode($data,JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('ERROR_CREATE_REVIEWS_IMG_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function getReviewById($reviewId){
        $this->builder = $this->db->table('FOOD_PRODUCT_VOTE');
        $this->builder->select("FOOD_PRODUCT_VOTE.ID as id, FOOD_PRODUCT_VOTE.PRODUCT_ID as productId, FOOD_PRODUCT_VOTE.SCORES as score, FOOD_PRODUCT_VOTE.STATUS as statusReview, FOOD_PRODUCT_VOTE.COMMENTS as commentReview, FOOD_PRODUCT_VOTE.IS_SHOW as isShow, FOOD_PRODUCT_VOTE_IMG.IMAGE as imageVote");
        $this->builder->join('FOOD_PRODUCT_VOTE_IMG', 'FOOD_PRODUCT_VOTE_IMG.VOTE_ID = FOOD_PRODUCT_VOTE.ID','LEFT');
        $this->builder->where('FOOD_PRODUCT_VOTE.ID', $reviewId);
      
        $result = $this->builder->get()->getResultObject();
       
        return $result[0];
    }


    public function removeVoteImg($voteId,$username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_VOTE_IMG');
            $this->builder->where('VOTE_ID', $voteId);
            
            if($this->builder->delete()){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_IMAGE_HOLA:|| ' . $th, array(), 'ERRORS');
        }
    }

    public function updataReview($arrUpdate, $voteId, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_VOTE');
            $this->builder->where('ID', $voteId);
            if($this->builder->update($arrUpdate)){
                return true;
            }else{
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_REVIEWS_IMG_HOLA_DATA: '.$username .'|| ' . json_encode($arrUpdate,JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('ERROR_CREATE_REVIEWS_IMG_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function disableReviews($voteId, $data){
        $update = "UPDATE FOOD_PRODUCT_VOTE SET STATUS = ".$data["STATUS"]." WHERE ID IN('".$voteId."')";
        $results = $this->db->query($update);
        if($results){
            return true;
        }else{
            return false;
        }
    }

    
}
?>