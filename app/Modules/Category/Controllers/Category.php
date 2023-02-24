<?php 
namespace App\Modules\Category\Controllers;

class Category extends BaseController
{
	//--------------------------------------------------------------------
	//Get List Category
	//--------------------------------------------------------------------
	public function listCategory(){
		$dataUser = $this->dataUserAuthen;
		$conditions['pid'] = '';
		$get = $this->request->getGet();
		if(!empty($get)){
			$conditions['pid'] 				= $get['pid'];
			$conditions['nameCate'] 		= $get['nameCate'];
			$conditions['conditionFlag'] 	= $get['conditionFlag'];
			$conditions['status'] 			= $get['status'];
		}
		$dataCate = $this->productsModels->getAllCate(0, 0 , array($conditions['pid']));

		$objects = $this->categoryModels->getListCate($conditions);
		
		$data['objects'] = $objects;
		$data['conditions'] = $conditions;
		$data['dataCate'] = $dataCate;
		$data['dataUser'] = $dataUser;
		$data['title'] = 'Quản lý Danh mục';
		$data['view'] = 'App\Modules\Category\Views\listCategory';
		return view('layoutKho/layout', $data);
	}

	//--------------------------------------------------------------------
	//Create Category
	//--------------------------------------------------------------------
	public function addCategory(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$nameCate = $post['nameCate'];
			$this->validation->setRules([
				'nameCate'=> [
					'label' => 'Label.txtNameCate',
					'rules' => 'required',
					'errors' => [
					]
				],
				'positionCate'=> [
					'label' => 'Label.positionCate',
					'rules' => 'required|checkGreater',
					'errors' => [
					]
				],
			]);

			if(!$this->validation->withRequest($this->request)->run()  ){
				$getErrors = $this->validation->getErrors();
				echo json_encode(array('success' => false, 'data' => $getErrors));die;
			}else{
				$dataInsert['PID'] = $post['parentCate'];
				$dataInsert['NAME'] = $nameCate;
				$dataInsert['CREATED_BY'] = $dataUser->userId;
				$dataInsert['BANNER'] = $post['imgThumbnail'];
				$dataInsert['POSITION'] = $post['positionCate'];
				$dataInsert['STATUS'] = $post['status'];
				$dataInsert['POPULAR_FLAG'] = $post['popularFlag'];
				$dataInsert['PRODUCT_FLAG'] = $post['productFlag'];
				$dataInsert['SLUG'] = $this->convertString->to_slug($post['nameCate']);
			}
			$resultInsert = $this->categoryModels->createCate($dataInsert);
			if($resultInsert){
				setcookie ("__notiCate",'success^_^Tạo danh mục thành công',time()+ (60*5) , '/');
			}else{
				setcookie ("__notiCate",'false^_^Tạo danh mục thất bại',time()+ (60*5) , '/');
			}
			echo json_encode(array('success' => true));die;
		}
	}

	//--------------------------------------------------------------------
	//Edit Category
	//--------------------------------------------------------------------
	public function editCategory(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post) && $post['getData'] == 1){
			$getCateById = $this->categoryModels->getCateById($post['id']);
			$dataCate = $this->productsModels->getAllCate(0, 0 , array($getCateById['pid']));
			$str = '<option value="0"> Chọn danh mục cha</option>';
			$str .= $dataCate;
			if($getCateById){
				echo json_encode(array('success' => true, 'data' => $getCateById, 'dataCate' => $str));die;
			}else{
				setcookie ("__notiCate",'false^_^Không tồn tại Danh mục muốn sửa',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}			
		}
		if(!empty($post) && $post['getData'] == 0){
			$nameCate = $post['nameCate'];
			$this->validation->setRules([
				'nameCate'=> [
					'label' => 'Label.txtNameCate',
					'rules' => 'required',
					'errors' => [
					]
				],
			]);

			if(!$this->validation->withRequest($this->request)->run()  ){
				$getErrors = $this->validation->getErrors();
				echo json_encode(array('false' => true, 'data' => $getErrors));die;
			}else{
				$dataUpdate['PID'] = $post['parentCate'];
				$dataUpdate['NAME'] = $nameCate;
				$dataUpdate['EDITED_BY'] = $dataUser->userId;
				$dataUpdate['BANNER'] = $post['imgThumbnail'];
				$dataUpdate['POSITION'] = $post['positionCate'];
				$dataUpdate['STATUS'] = $post['status'];
				$dataUpdate['POPULAR_FLAG'] = $post['popularFlag'];
				$dataUpdate['PRODUCT_FLAG'] = $post['productFlag'];
				$dataUpdate['SLUG'] = $this->convertString->to_slug($post['nameCate']);
			}
			$resultInsert = $this->categoryModels->updateCate($post['id'], $dataUpdate);
			if($resultInsert){
				setcookie ("__notiCate",'success^_^Sửa danh mục thành công',time()+ (60*5) , '/');
			}else{
				setcookie ("__notiCate",'false^_^Sửa danh mục thất bại',time()+ (60*5) , '/');
			}
			echo json_encode(array('success' => true));die;
		}
	}

	public function deleteCategory(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$data = [
				'EDITED_BY' => $dataUser->userId,
				'STATUS' => $post['status']
			];
			$result = $this->categoryModels->disableCate($post['id'], $data);
			if($result){
				setcookie ("__notiCate",'success^_^Thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => true));die;
			}else{
				setcookie ("__notiCate",'false^_^Không thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}
		}
	}
	public function checkExistCate(){
		$post = $this->request->getPost();
		if(!empty($post)){
			$nameStatus = $post['nameCate'];
			$resultCheckExistMenu = $this->categoryModels->checkExistCate($nameStatus);
			if(empty($resultCheckExistMenu)){
                echo json_encode(array('success' => true, 'status' => '1',));die;
            }else{
                echo json_encode(array('success' => false, 'status' => '0',));die;
            }
        }else{
            echo json_encode(array('success' => false, 'status' => '0',));die;
        }
	}
}
