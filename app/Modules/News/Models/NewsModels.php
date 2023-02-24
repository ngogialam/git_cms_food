<?php
namespace App\Modules\News\Models;
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

class NewsModels extends Model
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
    public function getListNews($arrSearch, $conditions){
        $this->builder = $this->db->table('FOOD_NEWS FN');
        $this->builder->select('FN.ID, FN.NEWS_CATE_ID, FN.NEWS_TITLE, FN.NEWS_SAPO, FN.NEWS_CONTENT, FN.NEWS_IMG, FN.CREATED_BY, FN.STATUS, FC.NAME AS CATE_NAME');
        $this->builder->join('FOOD_CATEGORY FC', 'FC.ID = FN.NEWS_CATE_ID','LEFT');
        // $this->builder->where('FN.STATUS', $data['status']);

        if(isset($arrSearch['titleNews']) && $arrSearch['titleNews'] != ''){
            $this->builder->where("UPPER(FN.NEWS_TITLE) LIKE UPPER('%".$arrSearch['titleNews']."%')");
        }

        if(isset($arrSearch['category']) && $arrSearch['category'] != '0'){
            $this->builder->where("FN.NEWS_CATE_ID", $arrSearch['category']);
        }

        if(isset($arrSearch['status']) && $arrSearch['status'] != '-1'){
            $this->builder->where('FN.STATUS', $arrSearch['status']);
        }

        $this->builder->orderBy('FN.ID', 'DESC');
        $sql = $this->builder->getCompiledSelect();
        if (!empty($conditions['LIMIT'])) {
            $sql = $this->builder->limit($sql,$conditions['LIMIT'], $conditions['OFFSET']);
        }
        // echo $sql;die;
        $results = $this->db->query($sql)->getResultArray();
        return $results;
    }

    public function getTotalNews($arrSearch){
        $this->builder = $this->db->table('FOOD_NEWS FN');
        $this->builder->select("COUNT(*) AS TOTAL");

        if(isset($arrSearch['titleNews']) && $arrSearch['titleNews'] != ''){
            $this->builder->where("UPPER(FN.NEWS_TITLE) LIKE UPPER('%".$arrSearch['titleNews']."%')");
        }

        if(isset($arrSearch['category']) && $arrSearch['category'] != '0'){
            $this->builder->where("FN.NEWS_CATE_ID", $arrSearch['category']);
        }

        if(isset($arrSearch['status']) && $arrSearch['status'] != '-1'){
            $this->builder->where('FN.STATUS', $arrSearch['status']);
        }
        
        $result = $this->builder->get()->getResultArray();
        return $result[0]['TOTAL'];
    }


    public function createNews($data, $username, $userId){
        
        try {
            $this->builder = $this->db->table('FOOD_NEWS');
            $this->builder->set('ID', 'FOOD_NEWS_SEQ.NEXTVAL', FALSE);
            $this->builder->set('CREATED_BY', $userId, FALSE);
            if($this->builder->insert($data)){
                $this->logger->info('CREATE_NEWS_HOLA: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_NEWS_HOLA_FAIL: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_NEWS_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function createNewsApi($data, $username, $header){
        try {
            $this->logger->info('CREATE_NEWS: ' . $username . '|| ' . json_encode($data, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE . 'createNews', $data, $header)['data'];
            $this->logger->info('========RESULT_CREATE_NEWS=====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION_RESULT_CREATE_NEWS:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function updateNewsApi($data, $username, $header){
        try {
            $this->logger->info('UPDATE_NEWS: ' . $username . '|| ' . json_encode($data, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE . 'editNews', $data, $header)['data'];
            $this->logger->info('========RESULT_UPDATE_NEWS=====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION_RESULT_UPDATE_NEWS:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
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
        $this->builder->select('ID, NAME')->where('STATUS', 1);
        $this->builder->orderBy('ID', 'ASC');
        $result = $this->builder->get()->getResultArray();
        return $result;
    }
    public function getAllCate( $pid = 0, $level = 0, $value = []){
        $this->builder = $this->db->table('FOOD_CATEGORY');
        $this->builder->select('ID,NAME, STATUS, PID');
        $this->builder->where('PID', $pid);
        $this->builder->where('STATUS', 1);
        $this->builder->orderBy('ID', 'ASC');
        $results = $this->builder->get()->getResultArray();
        $str = '';
        if($results) {
        $strlevel='';
            for($i=1;$i<=$level;$i++){
                if($i==1)
                    $strlevel .= '&nbsp;&nbsp;|--';
                else
                    $strlevel ='&nbsp;&nbsp;&nbsp;&nbsp;'.$strlevel;
            }
            $level++;
            foreach($results as $key => $result) {
                if(empty($value)){
                    $str .= "<option value=\"".$result['ID']."\">".$strlevel.$result['NAME']."</option>";
                }else{
                    $str .= "<option value=\"".$result['ID']."\"".(in_array($result['ID'],$value)?" selected":"").">".$strlevel.$result['NAME']."</option>";
                }
                $str .= $this->getAllCate($result['ID'],$level, $value);
            }
        }
        return $str;
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
    public function getNewsById($newsId){
        $this->builder = $this->db->table('FOOD_NEWS FN');
        $this->builder->select('FN.ID, FN.NEWS_CATE_ID, FN.NEWS_TITLE, FN.NEWS_SAPO, FN.NEWS_CONTENT, FN.NEWS_IMG, FN.CREATED_BY, FN.STATUS, FC.NAME AS CATE_NAME');
        $this->builder->join('FOOD_CATEGORY FC', 'FC.ID = FN.NEWS_CATE_ID','LEFT');
        $this->builder->where('FN.ID', $newsId);
        $this->builder->orderBy('FN.ID', 'DESC');
        $result = $this->builder->get()->getResultArray();
        return $result[0];
    }
}
?>