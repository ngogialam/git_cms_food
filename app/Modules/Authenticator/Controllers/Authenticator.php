<?php

namespace App\Modules\Authenticator\Controllers;

class Authenticator extends BaseController {

    public static $sdt;
    
    
    public function login(){
        $data = [];
        $post = $this->request->getPost();
        $deviceId = get_cookie('__dvc');
        if(!$deviceId){
			$deviceId = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
			setcookie ("__dvc",$deviceId,time() + ( 365 * 24 * 60 * 60) , '/');
		}
        $krd = get_cookie('__wkrd');
        if($krd){
            $dataUserAuthen = $this->authenticatorUser->getAuthenticator();
            return redirect()->to('/san-pham/danh-sach-san-pham');die;
        }
        if(!empty($post)){
            $username = $post['username'];
            $password = $post['password'];
            //Check Validation form 
            $this->validation->setRules([
                'username'               => [
                    'label' => 'Tài khoản',
                    'rules' => 'required|phoneValidate['.$username.']',
                    'errors' => [
                        'required' => 'Tài khoản không được để trống',
                        'phoneValidate' => 'Số điện thoại không đúng định dạng',
                    ]
                ],
                'password'               => [
                    'label' => 'Mật khẩu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Mật khẩu không được để trống'
                    ]
                ]
            ]);
            if(!$this->validation->withRequest($this->request)->run())
            {
                $data['dataErrors'] = $this->validation->getErrors();
                $data['view'] = 'App\Modules\Authenticator\Views\login';
                return view('layoutLogin/layoutLogin', $data);
            }else{
                $keyAuth = $this->generateKrd($username,$deviceId);
                $dataCALL_API = [
                    'username'      =>  $username,
                    'password'      =>  md5($password),
                    'deviceId'      =>  $deviceId,
                    'key'           =>  $keyAuth,
                    "rememberMe"    =>  0,
                    'requestFrom'   => 'CMS_WAREHOUSE'
                ];

                $requestApi = $this->AuthenticatorModels->login($username, $dataCALL_API);

                if($requestApi->status == 200){
                    $krd = setcookie ("__wkrd",$keyAuth,time()+  TIME_LOGIN , '/');
                    return redirect()->to('/don-hang/danh-sach-don-hang');die;
                }else{
                    $data['dataErrors'] = [
                        'password' => $requestApi->message
                    ];
                    $data['view'] = 'App\Modules\Authenticator\Views\login';
                    return view('layoutLogin/layoutLogin', $data);die;
                }
            }
        }
        // $loginGoogle = $this->google_client->createAuthUrl();
        // $data['loginGoogle'] = $loginGoogle;
        $data['view'] = 'App\Modules\Authenticator\Views\login';
        return view('layoutLogin/layoutLogin', $data);
    }

    public function logout(){
        $krd = setcookie ("__wkrd",null, -1, '/'); 
        return redirect()->to(URL_LOGIN);
    }
    
    public function generateKrd($username,$deviceId){
        return md5($username.'_'.$deviceId);
    }

}