<?php

namespace App\Modules\SetProducts\Models;

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

class SetProductsModels extends Model
{
    /**
     * Constructor.
     *
     * @param LoggerInterface   $logger
     *
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->callServer                = new CallServer();
        $this->clog = new Clogger(\Config\Services::request());
        $this->logger = $logger;
        parent::__construct();
    }

    public function getProductPrice($productId)
    {
        $this->builder = $this->db->table('FOOD_PRODUCT_PRICE');
        $this->builder->select('ID, WEIGHT, TYPE');
        $this->builder->where('STATUS = 1 AND PRODUCT_ID = ' . $productId);
        $this->builder->orderBy('ID', 'ASC');
        $result = $this->builder->get()->getResultArray();

        return $result;
    }
    public function getListProductType($idSet){
        $this->builder = $this->db->table('FOOD_GOODS');
        $this->builder->select('ID,NAME');
        $this->builder->where('ID', $idSet);
        $this->builder->where('STATUS', 1);
        $this->builder->orderBy('ID', 'DESC');
        $results = $this->builder->get()->getResultArray();
        return $results;
    }

    public function getProduct()
    {
        $this->builder = $this->db->table('FOOD_PRODUCTS');
        $this->builder->select('ID, NAME');
        $this->builder->where('STATUS = 1');
        $this->builder->orderBy('NAME', 'ASC');
        $result = $this->builder->get()->getResultArray();
        $str = '';
        foreach ($result as $key => $value) {
            $str .= '<option value="' . $value['ID'] . '">' . $value['NAME'] . '</option>';
        }
        return $str;
    }
    // ========================================

    public function getProductsToCreateSet($data = [], $header)
    {
        try {
            $result = $this->callServer->Get(URL_API_FOOD_PRIVATE . 'getProductsToCreateSet', $data, $header)['data'];
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION:' . json_encode($th, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function getProductPricesToCreateSet($data, $header)
    {
        try {
            $result = $this->callServer->Get(URL_API_FOOD_PRIVATE . 'getProductPricesToCreateSet', $data, $header)['data'];
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION:' . json_encode($th, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function getAllCateSet($pid = ID_SET, $level = 0, $value = [], $setUser = ID_SET_USER)
    {
        $this->builder = $this->db->table('FOOD_CATEGORY');
        $this->builder->select('ID,NAME, STATUS, PID');
        $this->builder->where('PID', $pid);
        $this->builder->where('ID !=', $setUser);
        $this->builder->where('STATUS', 1);
        $this->builder->orderBy('ID', 'ASC');
        $results = $this->builder->get()->getResultArray();
        $str = '';
        if ($results) {
            $strlevel = '';
            for ($i = 1; $i <= $level; $i++) {
                if ($i == 1)
                    $strlevel .= '&nbsp;&nbsp;|--';
                else
                    $strlevel = '&nbsp;&nbsp;&nbsp;&nbsp;' . $strlevel;
            }
            $level++;
            foreach ($results as $key => $result) {
                if (empty($value)) {
                    $str .= "<option value=\"" . $result['ID'] . "\">" . $strlevel . $result['NAME'] . "</option>";
                } else {
                    $keyCate = array_search($result['ID'], array_column($value, 'id'));
                    $selected = '';
                    if ($keyCate !== false) {
                        $selected = 'selected';
                    }
                    $str .= "<option value=\"" . $result['ID'] . "\"" . $selected . ">" . $strlevel . $result['NAME'] . "</option>";
                }
                $str .= $this->getAllCateSet($result['ID'], $level, $value);
            }
        }
        return $str;
    }

    public function createSet($data, $header, $username)
    {
        try {
            $this->logger->info('CREATE_SET_PRODUCT: ' . $username . '|| ' . json_encode($data, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE . 'createSet', $data, $header)['data'];
            $this->logger->info('========RESULT_CREATE_SET_PRODUCT=====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION_RESULT_CREATE_SET_PRODUCT:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function editSet($data, $header, $username)
    {
        try {
            $this->logger->info('EDIT_SET_PRODUCT: ' . $username . '|| ' . json_encode($data, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE . 'editSet', $data, $header)['data'];
            $this->logger->info('========RESULT_EDIT_SET_PRODUCT=====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION_RESULT_EDIT_SET_PRODUCT:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function getSetDetail($data, $header)
    {
        try {
            $result = $this->callServer->Get(URL_API_FOOD_PRIVATE . 'getSetDetail', $data, $header)['data'];
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION:' . json_encode($th, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function getAllSet($data, $header)
    {
        try {
            $this->logger->info('============GET ALL SET====================:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('DATA CALL GET SET==========================' . json_encode($data, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $this->logger->info('HEADER CALL GET SET========================' . json_encode($header, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE . 'getSetProducts', $data, $header)['data'];
            $this->logger->info('============END GET ALL SET================:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION_RESULT_EDIT_SET_PRODUCT:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function removeMultiSet($data, $header)
    {
        try {
            $this->logger->info('============CALL API UNACTIVE MULTI SET====================:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('DATA CALL UNACTIVE MULTI SET==========================' . json_encode($data, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $this->logger->info('HEADER CALL UNACTIVE MULTI SET========================' . json_encode($header, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE . 'deleteSet', $data, $header)['data'];
            $this->logger->info('============END CALL API UNACTIVE MULTI SET================:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION_RESULT_EDIT_SET_PRODUCT:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
        }
    }
}
