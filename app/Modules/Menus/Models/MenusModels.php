<?php 
namespace App\Modules\Menus\Models;
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

class MenusModels extends Model{
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

    public function getAllMenus($pid = 0, $level = 0, $value = []){
        $this->builder = $this->db->table('FOOD_MENUS');
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
                $str .= $this->getAllMenus($result['ID'],$level, $value);
            }
        }
        return $str;
    }

    public function getListMenus($conditions = []){
        $this->builder = $this->db->table('FOOD_MENUS');
        $this->builder->select('ID, NAME, BANNER, LINK, CATEGORY_ID, POSITION, STATUS, PID');
        $this->builder->select('TO_CHAR(CREATED_DATE, \'DD/MM/YYYY HH24:MI:SS\') CREATED_DATE');
        $this->builder->select('TO_CHAR(EDITED_DATE, \'DD/MM/YYYY HH24:MI:SS\') EDITED_DATE');
        $this->builder->select('(SELECT USERS.NAME FROM USERS WHERE USERS.ID = FOOD_MENUS.CREATED_BY) CREATED_NAME');
        $this->builder->select('(SELECT USERS.NAME FROM USERS WHERE USERS.ID = FOOD_MENUS.EDITED_BY) EDITED_NAME');
        $this->builder->select('(SELECT FOOD_CATEGORY.NAME FROM FOOD_CATEGORY WHERE FOOD_CATEGORY.ID = FOOD_MENUS.CATEGORY_ID) CATEGORY_NAME');
        $this->builder->select('(SELECT menus2.NAME FROM FOOD_MENUS menus2 WHERE menus2.ID = FOOD_MENUS.PID) PARENT_NAME');
        if(!empty($conditions['pid'])){
            $this->builder->where('PID', $conditions['pid']);
        }
        if(isset($conditions['status']) && $conditions['status'] != -1){
            $this->builder->where('STATUS', $conditions['status']);
        }
        if(!empty($conditions['nameMenus'])){
            $this->builder->where('UPPER(NAME) like UPPER(\'%'.$conditions['nameMenus'].'%\')');
        }
        $this->builder->orderBy('PID', 'ASC');
        $this->builder->orderBy('POSITION', 'ASC');
        // print_r($this->builder->getCompiledSelect());die;
        $result = $this->builder->get()->getResultArray();
        return $result;
    }

    public function createMenus($data){
        $this->builder = $this->db->table('FOOD_MENUS');
        $this->builder->set('ID', 'FOOD_MENUS_SEQ.NEXTVAL', FALSE);
        if($this->builder->insert($data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function updateMenus($id, $data){
        $this->builder = $this->db->table('FOOD_MENUS');
        $this->builder->set('EDITED_DATE', 'SYSTIMESTAMP', FALSE);
        $this->builder->where('ID', $id);
        if($this->builder->update($data)){
            return true;
        }else{
            return false;
        }
    }

    public function getMenusById($id){
        $this->builder = $this->db->table('FOOD_MENUS');
        $this->builder->select('ID as id, PID as pid, NAME as nameMenus, BANNER as banner, CATEGORY_ID as categoryId, LINK as link, POSITION as position, STATUS as statusMenus');
        $this->builder->where('ID', $id);
        $result = $this->builder->get()->getResultArray();
        if($result){
            return $result[0];
        }else{
            return [];
        }
    }

    public function disableMenus($id, $data){
        $update = 'UPDATE FOOD_MENUS SET EDITED_BY = '.$data['EDITED_BY'].', EDITED_DATE = SYSTIMESTAMP, STATUS = '.$data['STATUS'].' WHERE ID IN('.$id.')';
        $results = $this->db->query($update);
        if($results){
            return true;
        }else{
            return false;
        }
    }

    public function checkExistMenus($nameStatus){
        $this->builder = $this->db->table('FOOD_MENUS');
        $this->builder->select('ID')->where('NAME', $nameStatus);
        $result = $this->builder->get()->getResultArray();
        return $result;       
    }
}