<?php
namespace App\Modules\FRM_Barcode\Models;
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

class BarcodeModels extends Model
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
    public function getProductDetail($productId){
        $this->builder = $this->db->table('FOOD_PRODUCTS');
            $this->builder->select('
                                    FOOD_PRODUCTS.ID,
                                    FOOD_PRODUCTS.PRODUCT_TYPE, 
                                    FOOD_PRODUCTS.SAPO, 
                                    FOOD_PRODUCTS.CONTENT, 
                                    FOOD_PRODUCTS.NUTRITION, 
                                    FOOD_PRODUCTS.EFFECTUAL, 
                                    FOOD_PRODUCTS.PROCESSING, 
                                    FOOD_PRODUCTS.PRESERVE, 
                                    FOOD_PRODUCTS.SEASONAL, 
                                    FOOD_PRODUCTS.PRODUCT_CODE, 
                                    FOOD_PRODUCTS.NAME, 
                                    FOOD_PRODUCTS.PROMOTION_FLAG, 
                                    FOOD_PRODUCTS.BEST_SELL_FLAG, 
                                    FOOD_PRODUCTS.STATUS, 
                                    FOOD_GOODS.NAME AS TYPENAME,
                                    FOOD_PRODUCTS.AREA'
                                );
            $this->builder->join('FOOD_GOODS', 'FOOD_GOODS.ID = FOOD_PRODUCTS.PRODUCT_TYPE','LEFT');
            $this->builder->where('FOOD_PRODUCTS.ID', $productId);
            // $this->builder->where('FOOD_PRODUCTS.STATUS', 1);
            $this->builder->orderBy('FOOD_PRODUCTS.ID', 'DESC');
            $results = $this->builder->get()->getResultObject();
            return $results[0];
    }
    public function insertProductShow($dataInsert){
                try {
            $this->builder = $this->db->table('FOOD_SHOW_PRODUCT');
            $this->builder->set('ID', 'FOOD_SHOW_PRODUCT_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($dataInsert)){
                $this->logger->info('INSERT_PRODUCT_SHOW: || '.json_encode($dataInsert,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('INSERT_PRODUCT_SHOW_FAIL: || '.json_encode($dataInsert,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_INSERT_PRODUCT_SHOW: || ' . $th, array(), 'ERRORS');
        }
    }

    public function getListProductShow(){
        $this->builder = $this->db->table('FOOD_SHOW_PRODUCT');
        $this->builder->select('FOOD_SHOW_PRODUCT.*');
        $this->builder->where('FOOD_SHOW_PRODUCT.TYPE_PRODUCT', 1);
        $this->builder->orderBy('FOOD_SHOW_PRODUCT.ID', 'DESC');
        $results = $this->builder->get()->getResultArray();
        return $results;

    }
    public function getDetailItem($idItem){
        $this->builder = $this->db->table('FOOD_SHOW_PRODUCT');
        $this->builder->select('FOOD_SHOW_PRODUCT.*');
        $this->builder->where('FOOD_SHOW_PRODUCT.ID', $idItem);
        $this->builder->orderBy('FOOD_SHOW_PRODUCT.ID', 'DESC');
        $results = $this->builder->get()->getResultArray();
        if(!empty($results)){
            return $results[0];
        }
        return [];
    }
    public function updateProductShow($dataUpdate, $productId){
        try {
            $this->builder = $this->db->table('FOOD_SHOW_PRODUCT');
            $this->builder->where('ID', $productId);
            if($this->builder->update($dataUpdate)){
                $this->logger->info('UPDATE_PRODUCT_SHOW:'.$productId.' || '.json_encode($dataUpdate,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('UPDATE_PRODUCT_FALSE:'.$productId.' || '.json_encode($dataUpdate,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_UPDATE_PRODUCT_HOLA:'.$productId.' || '.json_encode($dataUpdate,JSON_UNESCAPED_UNICODE) .'', array(), 'ERRORS');
        }
    }
}
?>