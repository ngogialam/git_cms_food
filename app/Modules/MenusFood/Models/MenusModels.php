<?php

namespace App\Modules\MenusFood\Models;

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

class MenusModels extends Model
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

    public function callApiAddNewDish($data, $header)
    {
        try {
            $this->logger->info('========DATA CALL API =====:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('========HEADER CALL API =====:' . json_encode($header, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_DISH . 'createDish', $data, $header)['data'];
            $this->logger->info('========DATA RESPON CALL API =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function callApiChangeTimeSale($data, $header)
    {
        try {
            $this->logger->info('========DATA CALL API =====:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('========HEADER CALL API =====:' . json_encode($header, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_DISH . 'changeOpeningTime', $data, $header)['data'];
            $this->logger->info('========DATA RESPON CALL API =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function callApiGetListDish($data, $header)
    {
        try {
            $this->logger->info('========DATA CALL API GET DISH=============' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('========HEADER CALL API GET DISH===========:' . json_encode($header, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_DISH . 'listDish', $data, $header)['data'];
            $this->logger->info('========DATA RESPON CALL API GET DISH =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function callApiGetListRestaurant($header)
    {
        $data = [];
        try {
            $this->logger->info('========DATA CALL API GET LIST RESTAURANT=============' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('========HEADER CALL API GET LIST RESTAURANT===========:' . json_encode($header, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_DISH . 'getListRestaurant', $data, $header)['data'];
            $this->logger->info('========DATA RESPON CALL API GET LIST RESTAURANT =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function getOpeningTime($id, $header)
    {
        try {
            $result = $this->callServer->Get(URL_API_DISH . 'getOpeningTime/' . $id, [], $header)['data'];
            $this->logger->info('========DATA RESPON CALL API =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function getHistoryDishOrder($header, $dataCallList)
    {
        try {
            $this->logger->info('========DATA REQUEST LIST HISTORY =====:' . json_encode($dataCallList, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_DISH . 'history/list', $dataCallList, $header)['data'];
            $this->logger->info('========DATA RESPON LIST HISTORY =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function getStatisticDishOrder($header, $dataCallList)
    {
        try {
            $this->logger->info('========DATA RESPON LIST STATISTIC =====:' . json_encode($dataCallList, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_DISH . 'history/statistic', $dataCallList, $header)['data'];
            $this->logger->info('========DATA RESPON LIST STATISTIC =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function getListStatus($header)
    {
        try {
            $result = $this->callServer->Get(URL_API_DISH . 'status/list', $dataCallList = [], $header)['data'];
            $this->logger->info('========DATA RESPON LIST STATISTIC =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }

    public function changeStatusOrder($header, $dataCallApi)
    {
        try {
            $this->logger->info('========DATA CHANGE STATUS ORDER  =====:' . json_encode($dataCallApi, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_DISH . 'status/update', $dataCallApi, $header)['data'];
            $this->logger->info('========DATA RESPON CHANGE STATUS ORDER =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION CHANGE STATUS ORDER ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function updateDishDetail($header, $dataCallApi)
    {
        try {
            $this->logger->info('========DATA UPDATE DISH DETAIL  =====:' . json_encode($dataCallApi, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_DISH . 'editDish', $dataCallApi, $header)['data'];
            $this->logger->info('========DATA RESPON UPDATE DISH DETAIL =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION UPDATE DISH DETAIL ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function getListRestaurant($header)
    {
        try {
            $result = $this->callServer->Get(URL_API_DISH . 'getListRestaurant', $dataCallList = [], $header)['data'];
            $this->logger->info('========DATA RESPON LIST RESTAURANT =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function getListPartner($header)
    {
        try {
            $result = $this->callServer->Get(URL_API_DISH . 'history/getListPartner', $dataCallList = [], $header)['data'];
            $this->logger->info('========DATA RESPON LIST PARTNER =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function getDetailDish($header, $idDish)
    {
        try {
            $result = $this->callServer->Get(URL_API_DISH . 'getDishDetailById/' . $idDish, [], $header)['data'];
            $this->logger->info('========DATA RESPON DETAIL DISH =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function changeStatusDish($header, $dataCallApi)
    {
        try {
            $this->logger->info('========DATA CHANGE STATUS DISH  =====:' . json_encode($dataCallApi, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_DISH . 'changeStatusDish', $dataCallApi, $header)['data'];
            $this->logger->info('========DATA RESPON CHANGE STATUS DISH =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION CHANGE STATUS DISH ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function changeStockDish($header, $dataCallApi)
    {
        try {
            $this->logger->info('========DATA CHANGE STOCK DISH  =====:' . json_encode($dataCallApi, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_DISH . 'changeStockDish', $dataCallApi, $header)['data'];
            $this->logger->info('========DATA RESPON CHANGE STOCK DISH =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION CHANGE STOCK DISH ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function exportExcel($header, $dataCallApi)
    {
        try {
            $this->logger->info(' - GET_DATA_EXCEL_LIST_ORDER || ' . json_encode($dataCallApi, JSON_UNESCAPED_UNICODE), array(), 'CALLAPI');
            $result = $this->callServer->GetByte(URL_API_DISH . 'history/excel', $dataCallApi, $header);
            $this->logger->info(' - RESPONSE_EXCEL_LIST_ORDER || ' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALLAPI');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('ORDER-MANAGER - ===GET_DATA_EXCEL_LIST_ORDER - || ' . $th, array(), 'ERRORS');
        }
    }
    public function callApiAddAccount($data, $header)
    {
        try {
            $this->logger->info('========DATA CALL API POST =====:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('========HEADER CALL API =====:' . json_encode($header, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_ACCOUNT . 'mapUserPartner', $data, $header)['data'];
            $this->logger->info('========DATA RESPON CALL API =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function callApiGetUserListPartner($data, $header)
    {
        try {
            $this->logger->info('========DATA CALL API GET USER PARTNER=============' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('========HEADER CALL API GET USER PARTNER===========:' . json_encode($header, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_ACCOUNT . 'listuserpartner', $data, $header)['data'];
            $this->logger->info('========DATA RESPON CALL API GET USER PARTNER =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function callApiGetListPartner($header)
    {
        $data = [];
        try {
            $this->logger->info('========HEADER CALL API GET LIST PARTNER===========:' . json_encode($header, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_ACCOUNT . 'listpartner', $data, $header)['data'];
            $this->logger->info('========DATA RESPON LIST PARTNER =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function getAutoComplete($header)
    {
        $data = [];
        try {
            $this->logger->info('========HEADER CALL API USER AUTO COMPLETE===========:' . json_encode($header, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->Get(URL_API_ACCOUNT . 'getalluser', $data, $header)['data'];
            $this->logger->info('========DATA RESPON AUTO COMPLETE =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function deletePartner($data, $header)
    {
        try {
            $this->logger->info('============CALL API DELETE PARTNER====================:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('DATA CALL DELETE PARTNER==========================' . json_encode($data, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $this->logger->info('HEADER CALL DELETE PARTNER========================' . json_encode($header, JSON_UNESCAPED_UNICODE) . '', array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_ACCOUNT . 'deletemapper', $data, $header)['data'];
            $this->logger->info('============END CALL API DELETE PARTNER================:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
            $this->logger->info('======EXCEPTION_RESULT_DELETE PARTNER:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'ERRORS');
            $this->logger->info('DATA ========== ' . $th, array(), 'ERRORS');
        }
    }
    public function editAccount($data, $header)
    {
        try {
            $this->logger->info('========DATA CALL API EDIT ACCOUNT =====:' . json_encode($data, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $this->logger->info('========HEADER CALL API EDIT ACCOUNT =====:' . json_encode($header, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            $result = $this->callServer->PostJson(URL_API_ACCOUNT . 'changepartner', $data, $header)['data'];
            $this->logger->info('========DATA RESPON CALL API =====:' . json_encode($result, JSON_UNESCAPED_UNICODE), array(), 'CALL_API');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('EXCEPTION ========== ' . $th, array(), 'ERRORS');
        }
    }
}
