<?php 
namespace App\Modules\Banners\Models;
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

class BannersModels extends Model{
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

    public function getAllCateBanners($pid = 0, $level = 0, $value = []){
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
                $str .= $this->getAllCateBanners($result['ID'],$level, $value);
            }
        }
        return $str;
    }

    public function getListBanners($conditions = []){
        $this->builder = $this->db->table('FOOD_BANNERS');
        $this->builder->select('ID, CATEGORY_ID, NAME, CONTENT, LINK, IMAGE, STATUS');
        $this->builder->select('TO_CHAR(CREATED_DATE, \'DD/MM/YYYY HH24:MI:SS\') CREATED_DATE');
        $this->builder->select('TO_CHAR(EDITED_DATE, \'DD/MM/YYYY HH24:MI:SS\') EDITED_DATE');
        $this->builder->select('(SELECT USERS.NAME FROM USERS WHERE USERS.ID = FOOD_BANNERS.CREATED_BY) CREATED_NAME');
        $this->builder->select('(SELECT USERS.NAME FROM USERS WHERE USERS.ID = FOOD_BANNERS.EDITED_BY) EDITED_NAME');
        $this->builder->select('(SELECT FOOD_CATEGORY.NAME FROM FOOD_CATEGORY WHERE FOOD_CATEGORY.ID = FOOD_BANNERS.CATEGORY_ID) CATEGORY_NAME');
        if(!empty($conditions['pid'])){
            $this->builder->where('CATEGORY_ID IN ('.$conditions['pid'].')');
        }
        if(isset($conditions['status']) && $conditions['status'] != -1){
            $this->builder->where('STATUS', $conditions['status']);
        }
        if(!empty($conditions['nameBanners'])){
            $this->builder->where('UPPER(NAME) like UPPER(\'%'.$conditions['nameBanners'].'%\')');
        }
        $this->builder->orderBy('ID', 'ASC');
        // print_r($this->builder->getCompiledSelect());die;
        $result = $this->builder->get()->getResultArray();
        return $result;
    }

    // public function createBanners($data){
    //     $this->builder = $this->db->table('FOOD_BANNERS');
    //     $this->builder->set('ID', 'FOOD_BANNERS_SEQ.NEXTVAL', FALSE);
        
    //     if($this->builder->insert($data)){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    public function createBanners($data){
        try {
            $this->builder = $this->db->table('FOOD_BANNERS');
            $this->builder->set('ID', 'FOOD_BANNERS_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($data)){
                return true;
            }else{
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_BANNER_HOLA: || ' . $th, array(), 'ERRORS');
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

    public function disableBanners($id, $data){
        $update = 'UPDATE FOOD_BANNERS SET EDITED_BY = '.$data['EDITED_BY'].', EDITED_DATE = SYSTIMESTAMP, STATUS = '.$data['STATUS'].' WHERE ID IN('.$id.')';
        $results = $this->db->query($update);
        if($results){
            return true;
        }else{
            return false;
        }
    }
    public function checkExistBanner($nameStatus){
        $this->builder = $this->db->table('FOOD_BANNERS');
        $this->builder->select('ID')->where('NAME', $nameStatus);
        $result = $this->builder->get()->getResultArray();
        return $result;       
    }
}