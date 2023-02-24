<?php 
namespace App\Modules\Category\Models;
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

class CategoryModels extends Model{
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

    public function getListCate($conditions = []){
        $this->builder = $this->db->table('FOOD_CATEGORY');
        $this->builder->select('ID, NAME, BANNER, POPULAR_FLAG, PRODUCT_FLAG, POSITION, STATUS');
        $this->builder->select('TO_CHAR(CREATED_DATE, \'DD/MM/YYYY HH24:MI:SS\') CREATED_DATE');
        $this->builder->select('TO_CHAR(EDITED_DATE, \'DD/MM/YYYY HH24:MI:SS\') EDITED_DATE');
        $this->builder->select('(SELECT USERS.NAME FROM USERS WHERE USERS.ID = FOOD_CATEGORY.CREATED_BY) CREATED_NAME');
        $this->builder->select('(SELECT USERS.NAME FROM USERS WHERE USERS.ID = FOOD_CATEGORY.EDITED_BY) EDITED_NAME');
        $this->builder->select('(SELECT cate2.NAME FROM FOOD_CATEGORY cate2 WHERE cate2.ID = FOOD_CATEGORY.PID) PARENT_NAME');
        if(!empty($conditions['pid'])){
            $this->builder->where('PID', $conditions['pid']);
        }
        if(isset($conditions['status']) && $conditions['status'] != -1){
            $this->builder->where('STATUS', $conditions['status']);
        }else{
            $this->builder->where('STATUS', 1);
        }
        if(!empty($conditions['conditionFlag'])){
            if($conditions['conditionFlag'] == 1){
                $this->builder->where('POPULAR_FLAG', 1);
            }elseif($conditions['conditionFlag'] == 2){
                $this->builder->where('PRODUCT_FLAG', 1);
            }
        }
        if(!empty($conditions['nameCate'])){
            $this->builder->where('UPPER(NAME) like UPPER(\'%'.$conditions['nameCate'].'%\')');
        }
        $this->builder->orderBy('PID', 'ASC');
        $this->builder->orderBy('POSITION', 'ASC');
        // print_r($this->builder->getCompiledSelect());die;
        $result = $this->builder->get()->getResultArray();
        return $result;
    }

    public function createCate($data){
        try {
            $this->builder = $this->db->table('FOOD_CATEGORY');
            $this->builder->set('ID', 'FOOD_CATEGORY_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($data)){
                return true;
            }else{
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_CATEGORY_HOLA: || ' . $th, array(), 'ERRORS');
        }
    }
    
    public function updateCate($id, $data){
        $this->builder = $this->db->table('FOOD_CATEGORY');
        $this->builder->set('EDITED_DATE', 'SYSTIMESTAMP', FALSE);
        $this->builder->where('ID', $id);
        if($this->builder->update($data)){
            return true;
        }else{
            return false;
        }
    }

    public function getCateById($id){
        $this->builder = $this->db->table('FOOD_CATEGORY');
        $this->builder->select('ID as id, PID as pid, NAME as nameCate, BANNER as banner, POPULAR_FLAG as popularFlag, PRODUCT_FLAG as productFlag, POSITION as position, STATUS as statusCate');
        $this->builder->where('ID', $id);
        $result = $this->builder->get()->getResultArray();
        if($result){
            return $result[0];
        }else{
            return [];
        }
    }

    public function disableCate($id, $data){
        $update = 'UPDATE FOOD_CATEGORY SET EDITED_BY = '.$data['EDITED_BY'].', EDITED_DATE = SYSTIMESTAMP, STATUS = '.$data['STATUS'].' WHERE ID IN('.$id.')';
        $results = $this->db->query($update);
        if($results){
            return true;
        }else{
            return false;
        }
    }
    public function checkExistCate($nameCate){
        $this->builder = $this->db->table('FOOD_CATEGORY');
        $this->builder->select('ID')->where('NAME', $nameCate);
        $result = $this->builder->get()->getResultArray();
        return $result;       
    }

}