<?php
namespace App\Modules\Users\Models;
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

class UsersModels extends Model
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
    public function getListUser($arrSearch, $conditions, $username){
        try {
            $this->builder = $this->db->table('USERS');
            $this->builder->select("USERS.NAME,USERS.ID,USERS.USERNAME, USERS.PHONE, GROUPS.CODE, 
                TO_CHAR(USERS.CREATED_TIME, 'DD/MM/YYYY HH24:MI:SS') AS CREATED_TIME,
                TO_CHAR(USERS.UPDATED_TIME, 'DD/MM/YYYY HH24:MI:SS') AS UPDATED_TIME,
                USERS.STATUS, c.NAME AS FULLNAME_CREATOR ");
            $this->builder->join('USER_GROUPS_HOLA ', 'USER_GROUPS_HOLA.USER_ID = USERS.ID','LEFT');
            $this->builder->join('GROUPS', 'GROUPS.ID = USER_GROUPS_HOLA.GROUP_ID','LEFT');
            $this->builder->join('USERS c', 'c.ID = USERS.CREATOR_ID','LEFT');
            $this->builder->where('GROUPS.STATUS', 1);
            $this->builder->where('GROUPS.IS_DELETED', 0);
            if(isset($arrSearch['searchKey']) && $arrSearch['searchKey'] != -1){
                $this->builder->where('USERS.STATUS', $arrSearch['status']);
            }
            if(isset($arrSearch['status']) && $arrSearch['status'] != -1){
                $this->builder->where('USERS.STATUS', $arrSearch['status']);
            }
            
            if(isset($arrSearch['permission']) && $arrSearch['permission'] != '0'){
                $this->builder->like('GROUPS.CODE', $arrSearch['permission']);
            }else{
                $this->builder->like('GROUPS.CODE', 'FOOD');
            }
            if(isset($arrSearch['fullName']) && $arrSearch['fullName'] != ''){
                $this->builder->where("UPPER(USERS.NAME) LIKE UPPER('%".$arrSearch['fullName']."%')");
            }

            if(isset($arrSearch['phone']) && $arrSearch['phone'] != ''){
                $this->builder->where('(USERS.PHONE = '. $arrSearch['phone'] .')');
            }
            $sql = $this->builder->getCompiledSelect();
            if (!empty($conditions['LIMIT'])) {
                $sql = $this->builder->limit($sql,$conditions['LIMIT'], $conditions['OFFSET']);
            }
            // echo $sql;die;
            $results = $this->db->query($sql)->getResultArray();

            // $result = $this->builder->getCompiledSelect();
            // print_r($results);
            // die;
            // $result = $this->builder->get()->getResultArray();
            return $results;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_GROUP_PERMISSION: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function getTotalUsers($arrSearch, $username){
        $this->builder = $this->db->table('USERS');
        $this->builder->select("COUNT(*) AS TOTAL");
        $this->builder->join('USER_GROUPS_HOLA ', 'USER_GROUPS_HOLA.USER_ID = USERS.ID','LEFT');
        $this->builder->join('GROUPS', 'GROUPS.ID = USER_GROUPS_HOLA.GROUP_ID','LEFT');
        if(isset($arrSearch['searchKey']) && $arrSearch['searchKey'] != -1){
            $this->builder->where('USERS.STATUS', $arrSearch['status']);
        }
        if(isset($arrSearch['status']) && $arrSearch['status'] != -1){
            $this->builder->where('USERS.STATUS', $arrSearch['status']);
        }
        if(isset($arrSearch['permission']) && $arrSearch['permission'] != '0'){
            $this->builder->like('GROUPS.CODE', $arrSearch['permission']);
        }else{
            $this->builder->like('GROUPS.CODE', 'FOOD');
        }
        if(isset($arrSearch['fullName']) && $arrSearch['fullName'] != ''){
            $this->builder->where("UPPER(USERS.NAME) LIKE UPPER('%".$arrSearch['fullName']."%')");
        }

        if(isset($arrSearch['phone']) && $arrSearch['phone'] != ''){
            $this->builder->where('(USERS.PHONE = '. $arrSearch['phone'] .')');
        }
        $result = $this->builder->get()->getResultArray();
        return $result[0]['TOTAL'];
    }
    public function getListGroupUsers($username){
        try {
            $this->builder = $this->db->table('GROUPS');
            $this->builder->select('ID, NAME');
            $this->builder->where('STATUS', 1);
            $this->builder->where('IS_DELETED', 0);
            $this->builder->like('CODE', 'FOOD');
            $this->builder->orderBy('ID', 'ASC');
            $result = $this->builder->get()->getResultArray();
            return $result;

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_GROUP_PERMISSION: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function addUser($data, $username){
        try {
            $sql = "
            INSERT INTO \"USERS\" (
                ID,
                NAME,
                DOB,
                EMAIL,
                PHONE,
                USERNAME,
                PASSWORD_HASH,
                CREATOR_ID,
                CREATED_TIME,
                EDITOR_ID,
                UPDATED_TIME,
                IS_SUPER_ADMIN,
                RECEIVE_2FA,
                STATUS,
                IS_PARTNER,
                IS_DELETED,
                FAILURE_LOGIN_TIMES,
                LAST_TIME_CHANGE_PASSWORD,
                IS_LOGIN_FIRST_TIME,
                IS_SEND_EMAIL,
                SALT,
                PASSWORD_MD5 
            )
            VALUES
                (
                    USERS_SEQ.NEXTVAL,
                    '".$data['NAME']."',
                    to_date('".$data['DOB']."','YYYY-MM-DD HH24:MI:SS'),
                    '".$data['EMAIL']."',
                    '".$data['PHONE']."',
                    '".$data['PHONE']."',
                    '".$data['PASSWORD_HASH']."',
                    '".$data['CREATOR_ID']."',
                    to_date('".$data['CREATED_TIME']."','YYYY-MM-DD HH24:MI:SS'),
                    '".$data['CREATOR_ID']."',
                    to_date('".$data['UPDATED_TIME']."','YYYY-MM-DD HH24:MI:SS'),
                    0,
                    0,
                    '".$data['STATUS']."',
                    0,
                    0,
                    0,
                    to_date('".$data['LAST_TIME_CHANGE_PASSWORD']."','YYYY-MM-DD HH24:MI:SS'),
                    0,
                    0,
                    '".$data['SALT']."',
                    '".$data['PASSWORD_HASH']."' 
                )
            ";
            $results = $this->db->query($sql);
            if($results){
                $this->logger->info('CREATE_USER: '.$username .'|| '.json_encode($sql,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                $sqlMax = 'select USERS_SEQ.CURRVAL from DUAL';
                $results = $this->db->query($sqlMax)->getResultArray();
                return $results[0];
            }else{
                $this->logger->info('CREATE_USER_FAIL: '.$username .'|| '.json_encode($sql,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_USER: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function insertGroupUsers($data,$username){
        try {
            $this->builder = $this->db->table('USER_GROUPS_HOLA');
            $this->builder->set('ID', 'USER_GROUPS_HOLA_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($data)){
                $this->logger->info('CREATE_GROUP_USER_HOLA: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_GROUP_USER_HOLA_FAIL: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_GROUP_PERMISSION: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function checkExistPhone($data){
        $this->builder = $this->db->table('USERS');
        $this->builder->select('PHONE')->where('PHONE', $data);
        $result = $this->builder->get()->getResultArray();
        return $result;
    }

    public function addGroup($data, $username){
        try {
            $this->builder = $this->db->table('GROUPS');
            $this->builder->set('ID', 'GROUPS_SEQ.NEXTVAL', FALSE);
            $this->builder->set('CREATED_TIME', 'SYSDATE', FALSE);
            if($this->builder->insert($data)){
                $this->logger->info('CREATE_GROUP_USER: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_GROUP_USER_FAIL: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_GROUP_PERMISSION: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function deleteUser($id, $username){
        $this->builder = $this->db->table('USERS');
        $this->builder->where('ID', $id);
        $data = ['STATUS' => 0];
        if($this->builder->update($data)){
            $this->logger->info('DELETE_USERS: '.$username .'|| '.json_encode($id,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return true;
        }else{
            $this->logger->info('DELETE_USERS_FAIL: '.$username .'|| '.json_encode($id,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return false;
        }
    }
    public function resetPassword($id, $password, $salt, $username){
        $this->builder = $this->db->table('USERS');
        $this->builder->where('ID', $id);
        $data['PASSWORD_HASH'] = $password;
        $data['PASSWORD_MD5'] = $password;
        $data['SALT'] = $salt;
        if($this->builder->update($data)){
            $this->logger->info('RESET_PASSWORD_USERS: '.$username .'|| '.json_encode($id,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return true;
        }else{
            $this->logger->info('RESET_PASSWORD_USERS_FAIL: '.$username .'|| '.json_encode($id,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return false;
        }
    }
    public function getDetailUser($id){
        $this->builder = $this->db->table('USERS');
        $this->builder->select("USERS.ID ,USERS.NAME ,TO_CHAR(USERS.DOB, 'DD/MM/YYYY') AS DOB ,USERS.EMAIL ,USERS.USERNAME ,USERS.PHONE ,USERS.STATUS, GROUPS.ID AS GROUP_ID, USER_GROUPS_HOLA.ID as USER_GROUPS_HOLA_ID");

        $this->builder->join('USER_GROUPS_HOLA ', 'USER_GROUPS_HOLA.USER_ID = USERS.ID','LEFT');
        $this->builder->join('GROUPS', 'GROUPS.ID = USER_GROUPS_HOLA.GROUP_ID','LEFT');
        $this->builder->join('USERS c', 'c.ID = USERS.CREATOR_ID','LEFT');
        $this->builder->where('USERS.ID', $id);
        $result = $this->builder->get()->getResultArray();
        return $result[0];
    }

    public function updateUsers($id, $groupHolaId, $dataUpdate, $dataGroup, $username){
        $sql = " UPDATE \"USERS\" SET
         NAME = '".$dataUpdate['NAME']."', 
         DOB = to_date( '".$dataUpdate['DOB']."', 'YYYY-MM-DD HH24:MI:SS' ) ,
         EMAIL = '".$dataUpdate['EMAIL']."',
         EDITOR_ID = '".$dataUpdate['EDITOR_ID']."',
         STATUS = '".$dataUpdate['STATUS']."',
         UPDATED_TIME = SYSDATE
         WHERE ID = ".$id."
         ";
         $results = $this->db->query($sql);
         if($results){
            $this->logger->info('UPDATE_USER: '.$username .'|| '.json_encode($id,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            $this->builderHola = $this->db->table('USER_GROUPS_HOLA');
            $this->builderHola->where('ID', $groupHolaId);
            $this->builderHola->update($dataGroup);
            return true;
         }else{
             $this->logger->info('UPDATE_USER_FAIL: '.$username .'|| '.json_encode($sql,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
             return false;
         }
    }
}
?>