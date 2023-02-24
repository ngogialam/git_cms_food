<?php
namespace App\Modules\Products\Models;
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

class ProductsModels extends Model
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

    public function getListProducts($arrSearch, $username, $conditions){
       
        try {
            $this->builder = $this->db->table('FOOD_PRODUCTS');
            $this->builder->select('FOOD_PRODUCTS.ID, FOOD_PRODUCTS.PRODUCT_CODE, FOOD_PRODUCTS.NAME, FOOD_PRODUCTS.PROMOTION_FLAG, FOOD_PRODUCTS.BEST_SELL_FLAG, FOOD_PRODUCTS.STATUS, FOOD_GOODS.NAME AS TYPENAME,
            FOOD_PRODUCTS.AREA, FOOD_MAPS_PRODUCT_CATE.PRODUCT_CATE_ID, 
            (SELECT FOOD_CATEGORY.NAME FROM FOOD_CATEGORY WHERE FOOD_CATEGORY.ID = FOOD_MAPS_PRODUCT_CATE.PRODUCT_CATE_ID) AS CATE_NAME
            ');
            $this->builder->join('FOOD_GOODS', 'FOOD_GOODS.ID = FOOD_PRODUCTS.PRODUCT_TYPE','LEFT');
            $this->builder->join('FOOD_MAPS_PRODUCT_CATE', 'FOOD_MAPS_PRODUCT_CATE.PRODUCT_ID = FOOD_PRODUCTS.ID','LEFT');
            $this->builder->join('FOOD_CATEGORY', 'FOOD_CATEGORY.ID = FOOD_MAPS_PRODUCT_CATE.PRODUCT_CATE_ID','LEFT');
            $this->builder->orderBy('FOOD_PRODUCTS.ID', 'DESC');
            $this->builder->where('FOOD_PRODUCTS.TYPE', 1);
            if(isset($arrSearch['name']) && $arrSearch['name'] != ''){
                $this->builder->where("UPPER(FOOD_PRODUCTS.NAME) LIKE UPPER('%".$arrSearch['name']."%')");
            }
            
            if(isset($arrSearch['goodsType']) && $arrSearch['goodsType'] != 0){
                $this->builder->where('FOOD_PRODUCTS.PRODUCT_TYPE', $arrSearch['goodsType']);
            }

            if( isset($arrSearch['areaApply']) && $arrSearch['areaApply'] != '0'){
                $this->builder->where("UPPER(FOOD_PRODUCTS.AREA) LIKE UPPER('%".$arrSearch['areaApply']."%')");
            }

            if(isset($arrSearch['promotionFlag']) && $arrSearch['promotionFlag'] != '-1'){
                $this->builder->where('FOOD_PRODUCTS.PROMOTION_FLAG', $arrSearch['promotionFlag']);
            }
            if(isset($arrSearch['bestSellFlag']) && $arrSearch['bestSellFlag'] != '-1'){
                $this->builder->where('FOOD_PRODUCTS.BEST_SELL_FLAG', $arrSearch['bestSellFlag']);
            }
            if(isset($arrSearch['cateId']) && $arrSearch['cateId'] != '-1'){
                $this->builder->where('FOOD_MAPS_PRODUCT_CATE.PRODUCT_CATE_ID', $arrSearch['cateId']);
            }
            if(isset($arrSearch['status']) && $arrSearch['status'] != '-1'){
                $this->builder->where('FOOD_PRODUCTS.STATUS', $arrSearch['status']);
            }else{
                $this->builder->where('FOOD_PRODUCTS.STATUS', 1);
            }
            if(isset($arrSearch['area']) && $arrSearch['area'] != '-1'){
                $this->builder->where("UPPER(FOOD_PRODUCTS.AREA) LIKE UPPER('%".$arrSearch['area']."%')");
            }
            $sql = $this->builder->getCompiledSelect();
            if (!empty($conditions['LIMIT'])) {
                $sql = $this->builder->limit($sql,$conditions['LIMIT'], $conditions['OFFSET']);
            }
            $results = $this->db->query($sql)->getResultObject();
            return $results;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_GROUP_PERMISSION: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function getTotalProducts($arrSearch, $username){
        $this->builder = $this->db->table('FOOD_PRODUCTS');
        $this->builder->select("COUNT(*) AS TOTAL");
        $this->builder->where('FOOD_PRODUCTS.TYPE', 1);
        if(isset($arrSearch['name']) && $arrSearch['name'] != ''){
            $this->builder->where("UPPER(FOOD_PRODUCTS.NAME) LIKE UPPER('%".$arrSearch['name']."%')");
        }
        
        if(isset($arrSearch['goodsType']) && $arrSearch['goodsType'] != 0){
            $this->builder->where('FOOD_PRODUCTS.PRODUCT_TYPE', $arrSearch['goodsType']);
        }

        if( isset($arrSearch['areaApply']) && $arrSearch['areaApply'] != '0'){
            $this->builder->where("UPPER(FOOD_PRODUCTS.AREA) LIKE UPPER('%".$arrSearch['areaApply']."%')");
        }

        if(isset($arrSearch['promotionFlag']) && $arrSearch['promotionFlag'] != '-1'){
            $this->builder->where('FOOD_PRODUCTS.PROMOTION_FLAG', $arrSearch['promotionFlag']);
        }
        if(isset($arrSearch['bestSellFlag']) && $arrSearch['bestSellFlag'] != '-1'){
            $this->builder->where('FOOD_PRODUCTS.BEST_SELL_FLAG', $arrSearch['bestSellFlag']);
        }
        if(isset($arrSearch['cateId']) && $arrSearch['cateId'] != '-1'){
            $this->builder->where('FOOD_MAPS_PRODUCT_CATE.PRODUCT_CATE_ID', $arrSearch['cateId']);
        }
        if(isset($arrSearch['status']) && $arrSearch['status'] != '-1'){
            $this->builder->where('FOOD_PRODUCTS.STATUS', $arrSearch['status']);
        }else{
            $this->builder->where('FOOD_PRODUCTS.STATUS', 1);
        }
        if(isset($arrSearch['area']) && $arrSearch['area'] != '-1'){
            $this->builder->where("UPPER(FOOD_PRODUCTS.AREA) LIKE UPPER('%".$arrSearch['area']."%')");
        }
        // else{
        //     $this->builder->where('FOOD_PRODUCTS.STATUS', 1);
        // }
        // $result = $this->builder->getCompiledSelect();
        //     print_r($result);die;
        $result = $this->builder->get()->getResultArray();
        return $result[0]['TOTAL'];
    }
    public function getPriceProduct($productId){
        // $this->builder = $this->db->table('FOOD_PRODUCTS');
        // $this->builder->select(
        //     "FOOD_PRODUCTS.ID,
        //     FOOD_PRODUCT_PRICE.WEIGHT,
        //     FOOD_PRODUCT_PRICE.PRICE
        //     "
        // );
        //     // CASE WHEN FOOD_PRODUCT_PRICE.AREA = 'ALL' THEN 'TOÀN QUỐC' ELSE PROVINCES.NAME END NAME
        // $this->builder->join('FOOD_PRODUCT_PRICE', 'FOOD_PRODUCT_PRICE.PRODUCT_ID = FOOD_PRODUCTS.ID','LEFT');
        // $this->builder->join('PROVINCES', 'PROVINCES.CODE = FOOD_PRODUCT_PRICE.AREA','LEFT');
        // $this->builder->where('FOOD_PRODUCTS.ID', $productId);
        // $this->builder->where('FOOD_PRODUCTS.STATUS', 1);
        // $this->builder->orderBy('FOOD_PRODUCTS.ID', 'DESC');
        // $results = $this->builder->get()->getResultObject();
        // return $results;
        $sql = 'SELECT 
        ID,
        WEIGHT,
        PRICE,
        STOCK,
        TYPE,UNIT,
        NVL((SELECT COUNT(FOOD_PRODUCT_ITEM.ID) FROM FOOD_PRODUCT_ITEM WHERE FOOD_PRODUCT_ITEM.PRODUCT_PRICE_ID = FOOD_PRODUCT_PRICE.ID), 0) QUANTITY
    FROM FOOD_PRODUCT_PRICE
    WHERE PRODUCT_ID = '.$productId.' AND STATUS = 1';
            $results = $this->db->query($sql)->getResultObject();
            return $results;

    }
    public function getImagesProduct($productId){
        $this->builder = $this->db->table('FOOD_PRODUCTS');
        $this->builder->select('FOOD_PRODUCTS.ID, FOOD_PRODUCT_IMAGES.IMAGE, FOOD_PRODUCT_IMAGES.IS_THUMBNAIL');
        $this->builder->join('FOOD_PRODUCT_IMAGES', 'FOOD_PRODUCT_IMAGES.PRODUCT_ID = FOOD_PRODUCTS.ID','LEFT');
        $this->builder->where('FOOD_PRODUCTS.ID', $productId);
        // $this->builder->where('FOOD_PRODUCTS.STATUS', 1);
        $this->builder->orderBy('IS_THUMBNAIL', 'DESC');
        $this->builder->orderBy('ID', 'DESC');
        $results = $this->builder->get()->getResultObject();
        return $results;
    }
    public function getAllCate( $pid = PID_DANH_MUC_SAN_PHAM, $level = 0, $value = []){
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
    public function getListArea(){
        $this->builder = $this->db->table('PROVINCES');
        $this->builder->select('ID,NAME, STATUS, CODE');
        $this->builder->where('STATUS', 1);
        $results = $this->builder->get()->getResultArray();
        return $results;
    }

    public function uploadImage($username, $dataUploadImgBack, $token, $headers){
        try {
            $this->logger->info('USERNAME: '.$username .' - UPLOADIMG || ' . json_encode($dataUploadImgBack,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('USERNAME: '.$username .' - UPLOADIMG_URL || ' . json_encode(URL_API_UPLOADIMG.'imedia/auth/media/upload_file'), array(), 'CALL_API');
            $result = $this->callServer->PostUploadImage(URL_API_UPLOADIMG.'imedia/auth/media/upload_file', $dataUploadImgBack,'', $token);
            $this->logger->info('USERNAME: '.$username .' - RESPONSE_UPLOADIMG || ' . json_encode($result,JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;

        } catch (\Throwable $th) {
            $this->clog->info('LIST_ORDERS','UPLOADIMG_ERRORS:'.$username,$th);
            $this->logger->info('LIST_ORDERS - UPLOADIMG - USERNAME_ERRORS: '.$username .'|| ' . $th, array(), 'CALL_API');
        }
    }

    public function getListCooking(){
        $this->builder = $this->db->table('FOOD_NEWS');
        $this->builder->select('ID,NEWS_TITLE');
        $this->builder->where('STATUS', 1);
        $this->builder->where('NEWS_CATE_ID', PID_COOKING_RECIPE);
        $this->builder->orderBy('ID', 'DESC');
        $results = $this->builder->get()->getResultArray();
        return $results;
    }

    public function getListProductType(){
        $this->builder = $this->db->table('FOOD_GOODS');
        $this->builder->select('ID,NAME');
        $this->builder->where('STATUS', 1);
        $this->builder->orderBy('ID', 'DESC');
        $results = $this->builder->get()->getResultArray();
        return $results;
    }
    public function getListProductCode(){
        $this->builder = $this->db->table('FOOD_PRODUCTS');
        $this->builder->select('PRODUCT_CODE');
        $this->builder->orderBy('ID', 'DESC');
        $results = $this->builder->get()->getResultArray();
        $data = [];
        if($results){
            foreach($results as $product_code){
                array_push($data,$product_code['PRODUCT_CODE']);
            }
            return $data;
        }
        return $results;
    }
    public function getMaxProductCode(){
        $this->builder = $this->db->table('FOOD_PRODUCTS');
        $this->builder->select('MAX(PRODUCT_CODE) PRODUCT_CODE');
        $result = $this->builder->get()->getResultArray();
        return $result[0]['PRODUCT_CODE'];
    }
    public function createProduct($dataCreate, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCTS');
            $this->builder->set('ID', 'FOOD_PRODUCTS_SEQ.NEXTVAL', FALSE);
            // $this->builder->set('PRODUCT_CODE', 'SELECT MAX(PRODUCT_CODE) + 1', FALSE);
            if($this->builder->insert($dataCreate)){
                $this->logger->info('CREATE_PRODUCTS_HOLA: '.$username .'|| '.json_encode($dataCreate,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                $sqlMax = 'select FOOD_PRODUCTS_SEQ.CURRVAL from DUAL';
                $results = $this->db->query($sqlMax)->getResultArray();
                return $results[0];
            }else{
                $this->logger->info('CREATE_PRODUCTS_HOLA_FAIL: '.$username .'|| '.json_encode($dataCreate,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCTS_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function createProductImg($dataImg, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_IMAGES');
            $this->builder->set('ID', 'FOOD_PRODUCT_IMAGES_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($dataImg)){
                $this->logger->info('CREATE_PRODUCT_IMAGE_HOLA: '.$username .'|| '.json_encode($dataImg,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_PRODUCT_IMAGE_HOLA_FAIL: '.$username .'|| '.json_encode($dataImg,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_IMAGE_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function createProductPrice($dataPrice, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_PRICE');
            $this->builder->set('ID', 'FOOD_PRODUCT_PRICE_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($dataPrice)){
                $this->logger->info('CREATE_PRODUCT_PRICE_HOLA: '.$username .'|| '.json_encode($dataPrice,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_PRODUCT_PRICE_HOLA_FAIL: '.$username .'|| '.json_encode($dataPrice,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_PRICE_HOLA: '.$username .'|| '.json_encode($dataPrice,JSON_UNESCAPED_UNICODE) , array(), 'ERRORS');
            $this->logger->info('ERROR_CREATE_PRODUCT_PRICE_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function createProductCate($dataCate, $username){
        try {
            $this->builder = $this->db->table('FOOD_MAPS_PRODUCT_CATE');
            $this->builder->set('ID', 'FOOD_MAPS_PRODUCT_CATE_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($dataCate)){
                $this->logger->info('CREATE_PRODUCT_MAPS_CATE_HOLA: '.$username .'|| '.json_encode($dataCate,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_PRODUCT_MAPS_CATE_HOLA_FAIL: '.$username .'|| '.json_encode($dataCate,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_MAPS_CATE_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function createProductCookNews($dataCookNews, $username){
        try {
            $this->builder = $this->db->table('FOOD_MAPS_PRODUCT_NEWS');
            $this->builder->set('ID', 'FOOD_MAPS_PRODUCT_NEWS_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($dataCookNews)){
                $this->logger->info('CREATE_PRODUCT_MAPS_NEWS_HOLA: '.$username .'|| '.json_encode($dataCookNews,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_PRODUCT_MAPS_NEWS_HOLA_FAIL: '.$username .'|| '.json_encode($dataCookNews,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_MAPS_NEWS_HOLA: '.$username .'|| '.json_encode($dataCookNews,JSON_UNESCAPED_UNICODE) .'', array(), 'ERRORS');
            $this->logger->info('ERROR_CREATE_PRODUCT_MAPS_NEWS_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }

    public function getProvinceName($code){
        try {
            $data = [
                'code'=>'',
                'filterString'=>$code
            ];
            $result = $this->callServer->Get(URL_API_FOOD_FE.'addressCode',$data)['data'];
            if($result->status == 200){
                return $result->data;
            }
                
            return $result;

        } catch (\Throwable $th) {
            $this->logger->info('ORDER-MANAGER - ===DATA_DETAIL_ORDER - USERNAME_ERRORS: || ' . $th, array(), 'ERRORS');
        }
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
                                    FOOD_PRODUCTS.AREA,
                                    FOOD_PRODUCTS.POSITION_PRODUCT
                                    '
                                );
            $this->builder->join('FOOD_GOODS', 'FOOD_GOODS.ID = FOOD_PRODUCTS.PRODUCT_TYPE','LEFT');
            $this->builder->where('FOOD_PRODUCTS.ID', $productId);
            // $this->builder->where('FOOD_PRODUCTS.STATUS', 1);
            $this->builder->orderBy('FOOD_PRODUCTS.ID', 'DESC');
            $results = $this->builder->get()->getResultObject();
            return $results[0];
    }
    public function getCategoryProduct($productId){
        $this->builder = $this->db->table('FOOD_MAPS_PRODUCT_CATE');
        $this->builder->select('PRODUCT_CATE_ID');
        $this->builder->where('PRODUCT_ID', $productId);
        $this->builder->orderBy('ID', 'DESC');
        $results = $this->builder->get()->getResultArray();
        return $results;
    }

    public function getNewsProduct($productId){
        $this->builder = $this->db->table('FOOD_MAPS_PRODUCT_NEWS');
        $this->builder->select('NEWS_ID');
        $this->builder->where('PRODUCT_ID', $productId);
        $this->builder->orderBy('ID', 'DESC');
        $results = $this->builder->get()->getResultArray();
        return $results;
    }
    public function updateProduct($data, $productId, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCTS');
            $this->builder->where('ID', $productId);
            if($this->builder->update($data)){
                $this->logger->info('UPDATE_PRODUCT_HOLA: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('UPDATE_MAPS_FAIL: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_UPDATE_PRODUCT_HOLA: '.$username .'|| '.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'ERRORS');
            $this->logger->info('ERROR_UPDATE_PRODUCT_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function removeProductImg($productId){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_IMAGES');
            $this->builder->where('PRODUCT_ID', $productId);
            $result = $this->builder->delete();
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_IMAGE_HOLA:|| ' . $th, array(), 'ERRORS');
        }
    }
    public function updateProductImg($dataImg, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_IMAGES');
            $this->builder->set('ID', 'FOOD_PRODUCT_IMAGES_SEQ.NEXTVAL', FALSE);
            if($this->builder->insert($dataImg)){
                $this->logger->info('CREATE_PRODUCT_IMAGE_HOLA: '.$username .'|| '.json_encode($dataImg,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('CREATE_PRODUCT_IMAGE_HOLA_FAIL: '.$username .'|| '.json_encode($dataImg,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_IMAGE_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function removeProductPrice($productId, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_PRICE');
            $this->builder->where('PRODUCT_ID', $productId);
            $data = [
                'STATUS' => 0
            ];
            if($this->builder->update($data)){
                $this->logger->info('UPDATE_PRICE_HOLA: '.$username .'|| PRODUCT_ID:'.json_encode($productId,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('UPDATE_PRICE_HOLA_FALSE: '.$username .'|| PRODUCT_ID:'.json_encode($productId,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_IMAGE_HOLA:|| ' . $th, array(), 'ERRORS');
        }
    }

    public function removeProductCateMap($productId){
        try {
            $this->builder = $this->db->table('FOOD_MAPS_PRODUCT_CATE');
            $this->builder->where('PRODUCT_ID', $productId);
            $result = $this->builder->delete();
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_IMAGE_HOLA:|| ' . $th, array(), 'ERRORS');
        }
    }
    public function removeProductNewsMap($productId){
        try {
            $this->builder = $this->db->table('FOOD_MAPS_PRODUCT_NEWS');
            $this->builder->where('PRODUCT_ID', $productId);
            $result = $this->builder->delete();
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR_CREATE_PRODUCT_IMAGE_HOLA:|| ' . $th, array(), 'ERRORS');
        }
    }

    public function removeProduct($username, $productId, $status){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCTS');
            $this->builder->where('ID', $productId);
            $data = ['STATUS' => $status];
            if($this->builder->update($data)){
                $this->getSetId($username);
                $this->logger->info('REMOVE_PRODUCT_HOLA: '.$username .'|| PRODUCT_ID:'.json_encode($productId,JSON_UNESCAPED_UNICODE) .'|| STATUS:' .$status , array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('REMOVE_PRODUCT_HOLA_FALSE: '.$username .'|| PRODUCT_ID:'.json_encode($productId,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_UPDATE_PRODUCT_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    
    public function getSetId($username){
        $sqlGetListSetProduct  = 'SELECT
            id,
            sum( CASE WHEN status = 1 THEN 1 ELSE 0 END ) AS total_avail,
            sum( CASE WHEN substt = 1 THEN 1 ELSE 0 END ) AS total_inact 
            FROM
                (
                SELECT
                    a.*,
                    t3.STATUS AS substt 
                FROM
                    (
                    SELECT
                        t1.id,
                        t2.product_id,
                        t1.STATUS 
                    FROM
                        FOOD_PRODUCTS t1
                        INNER JOIN FOOD_SET_PRODUCT t2 ON t1.id = t2.set_id 
                    WHERE
                        TYPE = 2 
                        AND t1.STATUS = 1 
                    ORDER BY
                        t1.id 
                    ) A
                    JOIN FOOD_PRODUCTS t3 ON A.PRODUCT_ID = t3.id 
                ) 
            GROUP BY
                id 
            ORDER BY
                id';
        $resultsListSetProduct = $this->db->query($sqlGetListSetProduct)->getResultObject();
        if(!empty($resultsListSetProduct)){
            $strSetActive = '';
            $strSetInactive = '';
            foreach($resultsListSetProduct as $item){
                if($item->TOTAL_AVAIL == $item->TOTAL_INACT){
                    $strSetActive .= $item->ID.',' ;
                }else{
                    $strSetInactive .= $item->ID.',' ;
                }
            }
            $this->changeStatusSetProduct($strSetActive, 1, $username);
            $this->changeStatusSetProduct($strSetInactive, 0, $username);
        }
    }
    public function updateProductPrice($data, $idPrice, $username){
        try {
            $this->builder = $this->db->table('FOOD_PRODUCT_PRICE');
            $this->builder->where('ID', $idPrice);
            if($this->builder->update($data)){
                $this->logger->info('UPDATE_PRICE_HOLA: '.$username .'|| PRODUCT_ID:'.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return true;
            }else{
                $this->logger->info('UPDATE_PRICE_HOLA_FALSE: '.$username .'|| PRODUCT_ID:'.json_encode($data,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
                return false;
            }

        } catch (\Throwable $th) {
            $this->logger->info('ERROR_UPDATE_PRICE_HOLA: '.$username .'|| ' . $th, array(), 'ERRORS');
        }
    }
    public function checkExistProductName($productName){
        $this->builder = $this->db->table('FOOD_PRODUCTS');
        $this->builder->select('ID')->where('NAME', $productName);
        $result = $this->builder->get()->getResultArray();
        return $result;
    }
    public function getListCate(){
        $this->builder = $this->db->table('FOOD_CATEGORY');
        $this->builder->select('ID,NAME, STATUS');
        $this->builder->where('STATUS', 1);
        $this->builder->orderBy('ID', 'ASC');
        $results = $this->builder->get()->getResultArray();
        return $results;
    }
    public function exportExcelItemsScale($status){
        $sql = 'SELECT p.ID AS PRODUCT_ID , p.NAME, p.PRODUCT_CODE,pp.PRICE,pp.ID AS PRICE_ID, pp.WEIGHT as WEIGHT, pp.UNIT as UNIT
        FROM FOOD_PRODUCTS p
        LEFT JOIN ( SELECT pp.*,RANK () OVER ( PARTITION BY pp.PRODUCT_ID ORDER BY PRICE ASC ) PRICE_RANK 
        FROM FOOD_PRODUCT_PRICE pp WHERE pp.STATUS = 1) pp ON pp.PRODUCT_ID = p.ID
        WHERE pp.PRICE_RANK = 1 
        AND p.TYPE = 1
        AND p.STATUS = '.$status.'
        ORDER BY PRODUCT_CODE DESC;';
        $results = $this->db->query($sql)->getResultObject();
        return $results;
    }
    public function removeMultiProducts($ids, $status, $username){
        $data= [
            'STATUS'=> $status
        ];
        $arrId = explode(',',$ids);
        $this->builder = $this->db->table('FOOD_PRODUCTS');
        $this->builder->whereIn('ID', $arrId);
        if($this->builder->update($data)){
            $this->getSetId($username);
            $this->logger->info('REMOVE_STATUS_PRODUCT_MULTI: '.$username .'||STATUS:'.$status.' || PRODUCT_ID:'.json_encode($ids,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return true;
        }else{
            $this->logger->info('REMOVE_STATUS_PRODUCT_MULTI: '.$username .'||STATUS:'.$status.' || PRODUCT_ID:'.json_encode($ids,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return false;
        }
    }
    public function changeStatusSetProduct($ids, $status, $username){
        $data = [
            'STATUS'=> $status
        ];
        $arrId = explode(',', substr($ids, 0, -1));
        $this->builder = $this->db->table('FOOD_PRODUCTS');
        $this->builder->whereIn('ID', $arrId);
        if($this->builder->update($data)){
            $this->logger->info('UPDATE_STATUS_SET_PRODUCT: '.$username .'||STATUS:'.$status.' || PRODUCT_ID:'.json_encode($ids,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return true;
        }else{
            $this->logger->info('UPDATE_STATUS_SET_PRODUCT: '.$username .'||STATUS:'.$status.' || PRODUCT_ID:'.json_encode($ids,JSON_UNESCAPED_UNICODE) .'', array(), 'CALL_API');
            return false;
        }
    }
}
