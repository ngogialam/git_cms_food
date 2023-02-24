<?php

namespace App\Modules\Users\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Users extends BaseController
{
    public function listUsers(){
        $dataUser = $this->dataUserAuthen;
        $role = $dataUser->role;
		$arrRole = explode('_', $role);
		if(!in_array('ADMIN', $arrRole)){
			$krd = setcookie ("__wkrd",null, -1, '/'); 
        	return redirect()->to(URL_LOGIN);
		}
        $username = $dataUser->username;
        $arrSearch = [];
        $data = [];
        $get = $this->request->getGet();
        if(!empty($get)){
            $fullName = $get['fullName'];
            $phone = $get['phone'];
            $permission = $get['permission'];
            $status = $get['status'];
            $arrSearch = [
                'fullName' => $fullName,
                'phone' => $phone,
                'permission' => $permission,
                'status' => $status,
            ];
        }
        $arrPermission = json_decode(GROUP_PERMISSION);
        
        $page 					= ($this->page)? $this->page : 1;
        $data['page'] 			= $page;
        $data['perPage'] 		= PERPAGE;
        $data['pager'] 			= $this->pager;
        $data['total'] 			= 0;
        $data['uri'] = $this->uri;
        $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
        $conditions['LIMIT']  = $data['perPage'];

        $listUsers = $this->usersModels->getListUser($arrSearch, $conditions, $username);
        
        $getTotalUsers = $this->usersModels->getTotalUsers($arrSearch, $conditions, $username);
        $data['total'] = $getTotalUsers;
        $data['arrPermission'] = (array) $arrPermission;
        $data['dataOld'] = $get;
        // echo '<pre>';
        // print_r($data['dataOld']);die;
        $data['listUsers'] = $listUsers;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\Users\Views\listUsers';
        return view('layoutKho/layout', $data);
    }

    public function addUsers(){
        $dataUser = $this->dataUserAuthen;
        $role = $dataUser->role;
		$arrRole = explode('_', $role);
		if(!in_array('ADMIN', $arrRole)){
			$krd = setcookie ("__wkrd",null, -1, '/'); 
        	return redirect()->to(URL_LOGIN);
		}
        $username = $dataUser->username;
        $userId = $dataUser->userId;
        $title = 'Tạo người dùng';
        $listGroupUser = $this->usersModels->getListGroupUsers($username);
        $post = $this->request->getPost();
        if(!empty($post)){
            $phoneLogin = $post['phoneLogin'];
            $fullName = $post['fullName'];
            $dob = $post['dob'];
            $email = $post['email'];
            $groupUser = $post['groupUser'];
            $status = $post['status'];
            $this->validation->setRules([
                'phoneLogin'=> [
                    'label' => 'Label.txtPhoneLogin',
                    'rules' => 'required|phoneValidate['.$phoneLogin.']',
                    'errors' => [
                    ]
                ],
                'fullName'=> [
                    'label' => 'Label.txtFullName',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'groupUser'=> [
                    'label' => 'Label.txtCodeGroup',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
            ]);

            if(!$this->validation->withRequest($this->request)->run()  )
            {
                $getErrors = $this->validation->getErrors();
                $data['listGroupUser'] = $listGroupUser;
                $data['post'] = $post;
                $data['dataUser'] = $dataUser;
                $data['getErrors'] = $getErrors;
                $data['title'] = $title;
                $data['view'] = 'App\Modules\Users\Views\addUsers';
                return view('layoutKho/layout', $data);
            }else{
                $salt = substr(md5(mt_rand()), 0, 8);
                $password = md5(PASSWORD_USER_DEFAULT);
                $date = date('Y-m-d H:i:s');
                $dobnew = '';
                if($dob != ''){
                    $dobnew = date('Y-m-d H:i:s', strtotime($dob));
                }
                $data = [
                    'NAME' => $fullName,
                    'DOB' =>  $dobnew,
                    'EMAIL' =>  $email,
                    'PHONE' =>  $phoneLogin,
                    'USERNAME' =>  $phoneLogin,
                    'PASSWORD_HASH' => md5($password.$salt),
                    'CREATOR_ID' => $userId,
                    'CREATED_TIME' => $date,
                    'EDITOR_ID' => $userId,
                    'UPDATED_TIME' => $date,
                    'IS_SUPER_ADMIN' => 0,
                    'RECEIVE_2FA' => 0,
                    'STATUS' => $status,
                    'IS_PARTNER' => 0,
                    'IS_DELETED' => 0,
                    'FAILURE_LOGIN_TIMES' => 0,
                    'LAST_TIME_CHANGE_PASSWORD' => $date,
                    'IS_LOGIN_FIRST_TIME' => 0,
                    'IS_SEND_EMAIL' => 0,
                    'SALT' => $salt,
                    'PASSWORD_MD5' => $password,
                ];
                
                $resultAddUser = $this->usersModels->addUser($data, $username);
                $dataGroupUserHola = [
                    'USER_ID' => $resultAddUser['CURRVAL'],
                    'GROUP_ID' => $groupUser,
                    'IS_MANAGER' => 1,
                ];
                $resultAddUser = $this->usersModels->insertGroupUsers($dataGroupUserHola, $username);
                if($resultAddUser){
                    setcookie ("__user",'success^_^Tạo thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__user",'false^_^Tạo không thành công',time()+ (60*5) , '/');
                }
                return redirect()->to('/user/danh-sach-nguoi-dung');
            }
        }
        $data['listGroupUser'] = $listGroupUser;
        $data['title'] = $title;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\Users\Views\addUsers';
		return view('layoutKho/layout', $data);
    }

    public function addGroup(){
        $dataUser = $this->dataUserAuthen;
        $role = $dataUser->role;
		$arrRole = explode('_', $role);
		if(!in_array('ADMIN', $arrRole)){
			$krd = setcookie ("__wkrd",null, -1, '/'); 
        	return redirect()->to(URL_LOGIN);
		}
        $username = $dataUser->username;
        $userId = $dataUser->userId;
		$dataParamPerrmission = [
			'requestId' => '',
			'action' => 'ORDER/LIST_ORDER',
		];
		// $permission  = $this->permissionUser->getPermission($dataUser,$dataParamPerrmission);
		// $token = $dataUser->token;
        $arrPermission = json_decode(GROUP_PERMISSION);
        $title = 'Tạo nhóm người dùng';
        $post = $this->request->getPost();
        if(!empty($post)){
            $name = $post['name'];
            $description = $post['description'];
            $code = $post['code'];
            $status = $post['status'];
            $this->validation->setRules([
                'name'=> [
                    'label' => 'Label.txtNameGroup',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'description'=> [
                    'label' => 'Label.txtDescriptionGroup',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'code'=> [
                    'label' => 'Label.txtCodeGroup',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
            ]);
            if(!$this->validation->withRequest($this->request)->run()  )
            {
                $getErrors = $this->validation->getErrors();
                $data['arrPermission'] = $arrPermission;
                $data['post'] = $post;
                $data['getErrors'] = $getErrors;
                $data['title'] = $title;
                $data['dataUser'] = $dataUser;
                $data['view'] = 'App\Modules\Users\Views\addGroup';
                return view('layoutKho/layout', $data);
            }else{
                $data = [
                    'NAME' => $name,
                    'DESCRIPTION' => $description,
                    'THEME_ID' => '',
                    'STATUS' => $status,
                    'PARENT_ID' => '',
                    'CREATOR_ID' => $userId,
                    'PORTAL_ID' => 1,
                    'IS_DELETED' => 0,
                    'CODE' => $code,
                ];
                $result = $this->usersModels->addGroup($data, $username);
                if($result){
                    setcookie ("__user",'success^_^Tạo thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__user",'false^_^Tạo không thành công',time()+ (60*5) , '/');
                }
                return redirect()->to('/user/danh-sach-nguoi-dung');
            }
        }

        $data['arrPermission'] = $arrPermission;
        $data['title'] = $title;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\Users\Views\addGroup';
		return view('layoutKho/layout', $data);
    }
    public function checkExistPhone(){
        $post = $this->request->getPost();
        if(!empty($post)){
            $checkExistPhone = $post['checkExistPhone'];
            $checkExist = $this->usersModels->checkExistPhone($checkExistPhone);
            if(empty($checkExist)){
                echo json_encode(array('success' => true, 'status' => '1',));die;
            }else{
                echo json_encode(array('false' => true, 'status' => '0',));die;
            }
        }else{
            echo json_encode(array('false' => true, 'status' => '0',));die;
        }
    }
    public function editUser($id){
        $dataUser = $this->dataUserAuthen;
        $role = $dataUser->role;
		$arrRole = explode('_', $role);
		if(!in_array('ADMIN', $arrRole)){
			$krd = setcookie ("__wkrd",null, -1, '/'); 
        	return redirect()->to(URL_LOGIN);
		}
        $username = $dataUser->username;
        $detailUser = $this->usersModels->getDetailUser($id);
        $post = $this->request->getPost();
        $title = 'Chỉnh sửa người dùng';
        $listGroupUser = $this->usersModels->getListGroupUsers($username);
        if(!empty($post)){
            $fullName = $post['fullName'];
            $dob = $post['dob'];
            $email = $post['email'];
            $groupUser = $post['groupUser'];
            $status = $post['status'];
            $this->validation->setRules([
                
                'fullName'=> [
                    'label' => 'Label.txtFullName',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'groupUser'=> [
                    'label' => 'Label.txtCodeGroup',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
            ]);

            if(!$this->validation->withRequest($this->request)->run()  )
            {
                $detailUserNew = [
                    'USERNAME' => $detailUser['USERNAME'],
                    'NAME' => $post['fullName'],
                    'DOB' => $post['dob'],
                    'EMAIL' => $post['email'],
                    'GROUP_ID' => $post['groupUser'],
                    'STATUS' => $post['status'],
                ];
                $data['detailUser'] = $detailUserNew;
                $getErrors = $this->validation->getErrors();
                $data['listGroupUser'] = $listGroupUser;
                $data['getErrors'] = $getErrors;
                $data['title'] = $title;
                $data['view'] = 'App\Modules\Users\Views\editUser';
                return view('layoutKho/layout', $data);
            }else{
                $userId = $dataUser->userId;
                $dobnew = '';
                if($dob != ''){
                    $dobnew = date('Y-m-d H:i:s', strtotime($dob));
                }
                $dataUpdate = [
                    'NAME' => $fullName,
                    'DOB' =>  $dobnew,
                    'EMAIL' =>  $email,
                    'EDITOR_ID' => $userId,
                    'STATUS' => $status,
                ];

                $dataGroup = [
                    'GROUP_ID' => $groupUser
                ];

                $groupHolaId =  $detailUser['USER_GROUPS_HOLA_ID'];
                
                $resultUpdate = $this->usersModels->updateUsers($id, $groupHolaId, $dataUpdate, $dataGroup, $username );
                if($resultUpdate){
                    setcookie ("__user",'success^_^Cập nhật thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__user",'false^_^Cập nhật không thành công',time()+ (60*5) , '/');
                }
                return redirect()->to('/user/danh-sach-nguoi-dung');
            }


        }
        $data['detailUser'] = $detailUser;
        $data['listGroupUser'] = $listGroupUser;
        $data['title'] = $title;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\Users\Views\editUser';
		return view('layoutKho/layout', $data);

    }
    public function deleteUser($id){
        $dataUser = $this->dataUserAuthen;
        $role = $dataUser->role;
		$arrRole = explode('_', $role);
		if(!in_array('ADMIN', $arrRole)){
			$krd = setcookie ("__wkrd",null, -1, '/'); 
        	return redirect()->to(URL_LOGIN);
		}
        $username = $dataUser->username;
        $result = $this->usersModels->deleteUser($id, $username);
        if($result){
            setcookie ("__user",'success^_^Xóa thành công',time()+ (60*5) , '/');
        }else{
            setcookie ("__user",'false^_^Xóa không thành công',time()+ (60*5) , '/');
        }
        return redirect()->to('/user/danh-sach-nguoi-dung');
    }
    public function resetPassword($id, $newPass){
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $salt = substr(md5(mt_rand()), 0, 8);
        $password = md5($newPass);
        $passwordHash = md5($password.$salt);
        $result = $this->usersModels->resetPassword($id, $passwordHash, $salt, $username);
        if($result){
            setcookie ("__user",'success^_^Cập nhật thành công',time()+ (60*5) , '/');
        }else{
            setcookie ("__user",'false^_^Cập nhật không thành công',time()+ (60*5) , '/');
        }
        return redirect()->to('/user/danh-sach-nguoi-dung');
    }
    public function changePassword(){
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $userId = $dataUser->userId;
        $title = 'Đổi mật khẩu';
        $post = $this->request->getPost();
        if(!empty($post)){
            $passwordNew = $post['password'];
            $this->validation->setRules([
                'password'               => [
                    'label' => 'Label.password',
                    'rules' => 'required|passwordValidate['.$passwordNew.']',
                    'errors' => [

                    ]
                ],
                'rePassword'               => [
                    'label' => 'Label.rePassword',
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Validation.password.required'
                    ]
                ]
            ]);
            if(!$this->validation->withRequest($this->request)->run()  )
            {
                $getErrors = $this->validation->getErrors();
                $data['getErrors'] = $getErrors;
                $data['title'] = $title;
                $data['dataUser'] = $dataUser;
                $data['view'] = 'App\Modules\Users\Views\changePass';
                return view('layoutKho/layout', $data);
            }else{
                $salt = substr(md5(mt_rand()), 0, 8);
                $password = md5($passwordNew);
                $passwordHash = md5($password.$salt);
                $result = $this->usersModels->resetPassword($userId, $passwordHash, $salt, $username);
                if($result){
                    setcookie ("__user",'success^_^Cập nhật thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__user",'false^_^Cập nhật không thành công',time()+ (60*5) , '/');
                }
                return redirect()->to('/user/doi-mat-khau');
            }
        }
        
        $data['title'] = $title;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\Users\Views\changePass';
		return view('layoutKho/layout', $data);
    }

}