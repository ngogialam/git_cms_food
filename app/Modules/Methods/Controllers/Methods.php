<?php 
namespace App\Modules\Methods\Controllers;

class Methods extends BaseController
{
	public function listMethods($page = 1){
		$dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
		$title = 'Danh sách phương thức';
		$arraySearch = [
			
		];
		$arrGroupMethods = json_decode(METHODS_TYPE);
		//Pagination
        $page 					= ($this->page)? $this->page : 1;
        $data['page'] 			= $page;
        $data['perPage'] 		= PERPAGE;
        $data['pager'] 			= $this->pager;
        $data['total'] 			= 0;
        $data['uri'] = $this->uri;
        $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
        $conditions['LIMIT']  = $data['perPage'];

		$get = $this->request->getGet();
		if(!empty($get)){
			$arraySearch = [
				'methodsName' => $get['methodsName'],
				'methodsType' => $get['methodsType'],
				'status' => $get['statusMethods'],
			];
            $data['conditions'] = $arraySearch;
		}
		$resultListMethods = $this->methodsModels->getListMethods($arraySearch, $conditions);
		$getTotal = $this->methodsModels->getTotalMethods($arraySearch, $conditions);
        $data['get'] = $arraySearch;
        $data['total'] = $getTotal;
        $data['arrGroupMethods'] = (array) $arrGroupMethods;
		$data['objects'] = $resultListMethods;
		$data['title'] = $title;
		$data['dataUser'] = $dataUser;
		$data['view'] = 'App\Modules\Methods\Views\listMethods';
        return view('layoutKho/layout', $data);
	}
	public function addMethods(){
		$dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
		$userId = $dataUser->userId;
		$arrGroupMethods = json_decode(METHODS_TYPE);
		$post = $this->request->getPost();
		if(!empty($post)){
			$this->validation->setRules([
                'methodName'=> [
                    'label' => 'Label.txtMethodName',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'methodType'=> [
                    'label' => 'Label.txtMethodType',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
            ]);

            if(!$this->validation->withRequest($this->request)->run()  )
            {
                $getErrors = $this->validation->getErrors();
                echo json_encode(array('success' => false, 'data' => $getErrors));die;
            }else{
                $removeIsDefault = $this->methodsModels->removeIsDefault($post['methodType']);
                $dataInsert = [
					'TYPE' => $post['methodType'],
					'METHOD' => $post['methodName'],
					'STATUS' => $post['status'],
					'IS_DEFAULT' => $post['isDefaultMethod'],
				];
                $resultAddMethods = $this->methodsModels->createMethods($dataInsert, $username, $userId);
                if($resultAddMethods){
                    setcookie ("__methods",'success^_^Tạo thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__methods",'false^_^Tạo không thành công',time()+ (60*5) , '/');
                }
                echo json_encode(array('success' => true));die;
                // return redirect()->to('/phuong-thuc/danh-sach-phuong-thuc');
            }
		}
		$data['arrGroupMethods'] = (array) $arrGroupMethods;
		$data['view'] = 'App\Modules\Methods\Views\addMethods';
        return view('layoutKho/layout', $data);
	}
    public function editMethods(){
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
		$userId = $dataUser->userId;
		$post = $this->request->getPost();
		if(!empty($post) && $post['getData'] == 1){
			$getMethodsById = $this->methodsModels->getMethodsById($post['id']);
            
			if($getMethodsById){
                $arrGroupMethods = (array) json_decode(METHODS_TYPE);
                $htmlTypeMethods = '';
                foreach($arrGroupMethods as $keyGroupMethods => $groupMethods){
                    if($getMethodsById['typeMethod'] == $keyGroupMethods){
                        $htmlTypeMethods .= '<option selected value="'.$keyGroupMethods.'">'.$groupMethods.' </option>';
                    }else{
                        $htmlTypeMethods .= '<option value="'.$keyGroupMethods.'">'.$groupMethods.' </option>';
                    }
                }
				echo json_encode(array('success' => true, 'data' => $getMethodsById, 'htmlOptions' => $htmlTypeMethods));die;
			}else{
				setcookie ("__notiCate",'false^_^Không tồn tại Phương thức muốn sửa',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}			
		}
		if(!empty($post) && $post['getData'] == 0){
			$nameCate = $post['nameCate'];
			$this->validation->setRules([
                'methodName'=> [
                    'label' => 'Label.txtMethodName',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'methodType'=> [
                    'label' => 'Label.txtMethodType',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
            ]);

			if(!$this->validation->withRequest($this->request)->run()  )
            {
                $getErrors = $this->validation->getErrors();
                echo json_encode(array('success' => false, 'data' => $getErrors));die;
            }else{
                $idMethod = $post['idMethod'];
                $removeIsDefault = $this->methodsModels->removeIsDefault($post['methodType']);
                $dataUpdate = [
					'TYPE' => $post['methodType'],
					'METHOD' => $post['methodName'],
					'STATUS' => $post['status'],
					'IS_DEFAULT' => $post['isDefaultMethod'],
					'EDITED_BY' => $userId,
				];
                $resultAddMethods = $this->methodsModels->updateMethods($dataUpdate, $username, $idMethod);
                if($resultAddMethods){
                    setcookie ("__methods",'success^_^Sửa thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__methods",'false^_^Sửa không thành công',time()+ (60*5) , '/');
                }
                echo json_encode(array('success' => true));die;
                // return redirect()->to('/phuong-thuc/danh-sach-phuong-thuc');
            }
		}
    }
    public function deleteMethods(){
        $dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$data = [
				'EDITED_BY' => $dataUser->userId,
				'STATUS' => $post['status']
			];
			$result = $this->methodsModels->disableMethods($post['id'], $data);
			if($result){
				setcookie ("__methods",'success^_^Xóa thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => true));die;
			}else{
				setcookie ("__methods",'false^_^Xóa không thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}
		}
    }
    public function checkExistMethod(){
        $post = $this->request->getPost();
		if(!empty($post)){
			$nameStatus = $post['methodName'];
			$resultCheckExistMethod = $this->methodsModels->checkExistMethod($nameStatus);
			if(empty($resultCheckExistMethod)){
                echo json_encode(array('success' => true, 'status' => '1',));die;
            }else{
                echo json_encode(array('success' => false, 'status' => '0',));die;
            }
        }else{
            echo json_encode(array('success' => false, 'status' => '0',));die;
        }
    }
}
