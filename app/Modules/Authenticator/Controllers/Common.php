<?php

namespace App\Modules\Authenticator\Controllers;

use PhpOffice\PhpSpreadsheet\Reader\Xls\MD5;

class Common extends BaseController {

    public function generateDeviceId($key = 'deviceId'){
        echo 'inherer';
        helper("cookie");
        $keyVariable = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
        $getToken = $this->setCookie($key,$keyVariable);

        $getTokenResult = $this->getCookie($key);
        return $getTokenResult;
    }
    public function getCookie($key){
        helper("cookie");
        return get_cookie($key);
    }
    public function setCookie($key, $value){
        set_cookie($key, $value, time()+60*60*24*365, '', false,false);
        return  true;
        // return set_cookie($key, $value, time()+60*60*24*365);
    }    
    public function verifyOTP(){
        // $getGet = $this->request->getGet();
        $phone = get_cookie('__phone_tmp');
        $dataList = [
            'phone' => $phone,
            'username' => $phone
        ];
        $post = $this->request->getPost();
        if(!empty($post) && isset($post['otp']) || !empty($dataGG)){
            $loginGG = '';
            if(!empty($dataGG)){
                $post = $dataGG;
                $loginGG = $post['loginGG'];
            }
            $otp = $post['otp'];
            $phone = $post['phone'];
            $deviceId = $this->getCookie('__dvc');
            // $krdTmp = get_cookie('__krd');
            $krdTmp = $this->generateKrd($phone, $deviceId);
            $lgn = get_cookie('__lgn');
            $this->logger->info('DATA_CALL_API : '. json_encode($krdTmp), array(), 'CALL_API');
            if($otp!=''){
                $dataApiGenerateOtp = [
                    'username' => $phone,
                    'otpCode' => $otp,
                    'deviceId' => $deviceId,
                ];
                $dataCALL_API = $this->redis->get('tmp_'.$krdTmp);
                $this->logger->info('DATA_CALL_API_krdtmp : '. json_encode($dataCALL_API), array(), 'CALL_API');

                $this->logger->info('=====VERIFY OTP=======', array(), 'CALL_API');
                $this->logger->info('DATA_CALL_API : '. json_encode($dataApiGenerateOtp), array(), 'CALL_API');
                $otpSMS =  $this->callServer->PostJson(URL_API_PUBLIC.'verifyOTP',$dataApiGenerateOtp)['data'];
                $this->logger->info('RESULT_API : '. json_encode($otpSMS), array(), 'CALL_API');
                
                if($otpSMS->status == 200){
                    $result = $this->callServer->PostJson(URL_API_PUBLIC.'authenticate',json_decode($dataCALL_API));
                    $result = $result['data'];
                    $this->logger->info('DATA_RESPONSE_OTP : '. json_encode($result), array(), 'CALL_API');
                    $this->logger->info('lgn : '. $lgn, array(), 'CALL_API');
                    if($result->status == 200){
                        $setKrd = setcookie ("__krd",$krdTmp,time()+ TIME_LOGIN , '/');
                         echo json_encode(array('success' => true,'status'=> 200, 'message' => 'Xac thuc OTP thanh cong', 'data' => lang('Label.err_'.$result->status) ) );die;
                    }else{
                        echo json_encode(array('success' => false,'status'=> $result->status, 'message' => '', 'data' => lang('Label.err_'.$result->status)));die;
                    }
                    
                }else{
                    $this->logger->info('DATA_RESPONSE_OTP : FALSE', array(), 'CALL_API');
                    echo json_encode(array('success' => false, 'message' => '', 'data' => lang('Label.err_'.$otpSMS->status)));die;
                }
            }
        }
        $title = " Xác thực số điện thoại";
        $data['title'] = $title;
        $data['data'] = $dataList;
        $data['view'] = 'App\Modules\Authenticator\Views\otp';
        return view('layout/layout', $data);
    }
    public function generateKrd($username,$deviceId){
        return md5($username.'_'.$deviceId);
    }
}