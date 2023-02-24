<?php 
namespace App\Modules\Backend\Config\Models;

use CodeIgniter\Model;

class ConfigModel extends Model{
	public function __construct() {
        parent::__construct();
    }

    public function getConfigs(){
        $this->builder = $this->db->table('taq_configs');
        $this->builder->select('*');
        $result = $this->builder->get()->getResultArray();        
        return $result[0];
    }

    public function updateConfigs($data){
        $this->builder = $this->db->table('taq_configs');
        $this->builder->where('id', 1);
        if($this->builder->update($data)){
            return true;
        }else{
            return false;
        }
    }
}