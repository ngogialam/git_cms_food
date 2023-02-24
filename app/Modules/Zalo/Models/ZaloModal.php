<?php

namespace App\Modules\Zalo\Models;

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

class ZaloModal extends Model
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
    public function getTempl($data, $header)
    {
        $this->logger->info('DATA : ' . json_encode($data), array(), 'CALL_API');
        try {
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE . 'getTemplateList', $data, $header)['data'];
            $this->logger->info('RESPON : ' . json_encode($result), array(), 'RESPON');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR-----------' . $th, array(), 'ERRORS');
        }
    }
    public function activeTemplModels($data, $header)
    {
        try {
            $result = $this->callServer->PostJson(URL_API_FOOD_PRIVATE . 'changeStatus', $data, $header)['data'];
            $this->logger->info('activeTemplModels : ' . json_encode($data), array(), 'REQUEST');
            $this->logger->info('activeTemplModels : ' . json_encode($result), array(), 'RESPON');
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR-----------' . $th, array(), 'ERRORS');
        }
    }

    public function exportExcelZalo($data, $header)
    {
        try {
            $result = $this->callServer->GetByte(URL_API_FOOD_PRIVATE . 'exportExcel', $data, $header)['data'];  
            return $result;
        } catch (\Throwable $th) {
            $this->logger->info('ERROR-----------' . $th, array(), 'ERRORS');
        }
    }
}
