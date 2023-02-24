<?php
namespace App\Modules\Methods\Models;
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

class MethodsModels extends Model
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
    public function getListMethods($arrSearch, $conditions){
        $this->builder = $this->db->table('FOOD_METHOD');
        $this->builder->select("ID, TYPE, METHOD, STATUS, CREATED_BY,
        TO_CHAR(CREATED_DATE, 'DD/MM/YYYY HH24:MI:SS') AS CREATED_DATE,
                TO_CHAR(EDITED_DATE, 'DD/MM/YYYY HH24:MI:SS') AS EDITED_DATE,
         ");
        if(isset($arrSearch['methodsType']) && $arrSearch['methodsType'] != 0){
            $this->builder->where('TYPE', $arrSearch['methodsType']);
        }

        if(isset($arrSearch['status']) && $arrSearch['status'] != -1){
            $this->builder->where('STATUS', $arrSearch['status']);
        }

        if(isset($arrSearch['methodsName']) && $arrSearch['methodsName'] != ''){
            $this->builder->where("UPPER(METHOD) LIKE UPPER('%".$arrSearch['methodsName']."%')");
        }
        $this->builder->orderBy('ID', 'DESC');
        $sql = $this->builder->getCompiledSelect();
        if (!empty($conditions['LIMIT'])) {
            $sql = $this->builder->limit($sql,$conditions['LIMIT'], $conditions['OFFSET']);
        }
        $results = $this->db->query($sql)->getResultArray();
        return $results;
    }

    public function getTotalMethods($arrSearch){
        $this->builder = $this->db->table('FOOD_METHOD');
        $this->builder->select("COUNT(*) AS TOTAL");
        if(isset($arrSearch['methodsType']) && $arrSearch['methodsType'] != 0){
            $this->builder->where('TYPE', $arrSearch['methodsType']);
        }

        if(isset($arrSearch['status']) && $arrSearch['status'] != -1){
            $this->builder->where('STATUS', $arrSearch['status']);
        }

        if(isset($arrSearch['methodsName']) && $arrSearch['methodsName'] != ''){
            $this->builder->where("UPPER(METHOD) LIKE UPPER('%".$arrSearch['methodsName']."%')");
        }
        
        $result = $this->builder->get()->getResultArray();
        return $result[0]['TOTAL'];
    }


    public function createMethods($data, $username, $userId){
        try {
            $this->builder = $this->db->table('FOOD_METHOD');
            $this->builder->set('ID', 'FOOD_METHOD_SEQ.NEXTVAL', FALSE);
            $this->builder->set('CREATED_BY', $userId, FALSE);
            if($this->builder->insert($data)){
                $this->logger->info('CREATE_METHODS_HOLA: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_METHODS_HOLA_FAIL: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_NEWS_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function updateNews($data, $username, $productId){
        try {
            $this->builder = $this->db->table('FOOD_NEWS');
            $this->builder->where('ID', $productId);
            if($this->builder->update($data)){
                $this->logger->info('UPDATE_NEWS_HOLA: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('UPDATE_NEWS_HOLA_FAIL: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_NEWS_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function checkExistTitle($title){
        $this->builder = $this->db->table('FOOD_NEWS');
        $this->builder->select('ID')->where('NEWS_TITLE', $title);
        $result = $this->builder->get()->getResultArray();
        return $result;
    }

    public function getListCateAll(){
        $this->builder = $this->db->table('FOOD_CATEGORY');
        $this->builder->select('ID, NAME')->where('PID', 0);
        $this->builder->orderBy('ID', 'ASC');
        $result = $this->builder->get()->getResultArray();
        return $result;
    }

    public function removeNews($data){
        $this->builder = $this->db->table('FOOD_NEWS');
        $this->builder->where('ID', $data['ID']);
        $this->builder->set('EDITED_BY', $data['USER_ID'], FALSE);
        // $this->builder->set('EDITED_DATE', $data['USER_ID'], FALSE);
        $data = ['STATUS' => 0];
        if($this->builder->update($data)){
            $this->logger->info('DELETE_NEWS: '.$data['USERNAME'] .'|| '.json_encode($data['ID'],JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return true;
        }else{
            $this->logger->info('DELETE_NEWS_FAIL: '.$data['USERNAME'] .'|| '.json_encode($data['ID'],JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return false;
        }
    }
    public function getMethodsById($methodsId){
        $this->builder = $this->db->table('FOOD_METHOD');
        $this->builder->select("ID as id, TYPE as typeMethod, METHOD as method, STATUS as statusMethod, IS_DEFAULT as isDefault");
        $this->builder->where('ID', $methodsId);
        $result = $this->builder->get()->getResultArray();
        return $result[0];
    }
    public function updateMethods($data, $username,$idMethod){
        $this->builder = $this->db->table('FOOD_METHOD');
        $this->builder->set('EDITED_DATE', 'SYSTIMESTAMP', FALSE);
        $this->builder->where('ID', $idMethod);
        if($this->builder->update($data)){
            return true;
        }else{
            return false;
        }
    }
    public function disableMethods($id, $data){
        $update = 'UPDATE FOOD_METHOD SET EDITED_BY = '.$data['EDITED_BY'].', EDITED_DATE = SYSTIMESTAMP, STATUS = '.$data['STATUS'].' WHERE ID IN('.$id.')';
        $results = $this->db->query($update);
        if($results){
            return true;
        }else{
            return false;
        }
    }
    public function removeIsDefault($type){
        $update = 'UPDATE FOOD_METHOD SET IS_DEFAULT = 0 WHERE TYPE = '.$type;
        $results = $this->db->query($update);
        if($results){
            return true;
        }else{
            return false;
        }
    }

    public function checkExistMethod($nameStatus){
        $this->builder = $this->db->table('FOOD_METHOD');
        $this->builder->select('ID')->where('METHOD', $nameStatus);
        $result = $this->builder->get()->getResultArray();
        return $result;  
    }
}
?>