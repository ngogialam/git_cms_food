<?php 
namespace App\Modules\Menus\Controllers;

class Menus extends BaseController
{
	//--------------------------------------------------------------------
	//Get List Category
	//--------------------------------------------------------------------
	public function listMenus(){
		$dataUser = $this->dataUserAuthen;
		$conditions['pid'] = '';
		$get = $this->request->getGet();
		if(!empty($get)){
			$conditions['pid'] 				= $get['pid'];
			$conditions['nameMenus'] 		= $get['nameMenus'];
			$conditions['status'] 			= $get['status'];
		}
		$dataMenus = $this->menusModels->getAllMenus(0, 0 , array($conditions['pid']));
		$dataCate = $this->productsModels->getAllCate(0, 0 , array($conditions['pid']));

		$objects = $this->menusModels->getListMenus($conditions);
		
		$data['objects'] = $objects;
		$data['conditions'] = $conditions;
		$data['dataMenus'] = $dataMenus;
		$data['dataCate'] = $dataCate;
		$data['dataUser'] = $dataUser;
		$data['title'] = 'Quản lý Menus';
		$data['view'] = 'App\Modules\Menus\Views\listMenus';
		return view('layoutKho/layout', $data);
	}

	//--------------------------------------------------------------------
	//Create Category
	//--------------------------------------------------------------------
	public function addMenus(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$nameMenus = $post['nameMenus'];
			$linkMenus = $post['linkMenus'];
			$this->validation->setRules([
				'linkMenus'=> [
					'label' => 'Label.txtLinkMenus',
					'rules' => 'required',
					'errors' => [
					]
				],
				'nameMenus'=> [
					'label' => 'Label.txtNameMenus',
					'rules' => 'required',
					'errors' => [
					]
				],
			]);

			if(!$this->validation->withRequest($this->request)->run()  ){
				$getErrors = $this->validation->getErrors();
				echo json_encode(array('success' => false, 'data' => $getErrors));die;
			}else{
				$dataInsert['PID'] = $post['parentMenus'];
				$dataInsert['NAME'] = $nameMenus;
				$dataInsert['LINK'] = $linkMenus;
				$dataInsert['CATEGORY_ID'] = $post['parentCate'];
				$dataInsert['CREATED_BY'] = $dataUser->userId;
				$dataInsert['BANNER'] = $post['imgThumbnail'];
				$dataInsert['POSITION'] = $post['positionMenus'];
				$dataInsert['STATUS'] = $post['status'];
				$dataInsert['SLUG'] = $this->convertString->to_slug($nameMenus);
			}
			$resultInsert = $this->menusModels->createMenus($dataInsert);
			if($resultInsert){
				setcookie ("__notiCate",'success^_^Tạo menus thành công',time()+ (60*5) , '/');
			}else{
				setcookie ("__notiCate",'false^_^Tạo menus thất bại',time()+ (60*5) , '/');
			}
			echo json_encode(array('success' => true));die;
		}
	}

	//--------------------------------------------------------------------
	//Edit Category
	//--------------------------------------------------------------------
	public function editMenus(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post) && $post['getData'] == 1){
			$getMenusById = $this->menusModels->getMenusById($post['id']);
			$dataCate = $this->productsModels->getAllCate(0, 0 , array($getMenusById['categoryId']));
			$str = '<option value=""> Chọn danh mục</option>';
			$str .= $dataCate;
			$dataMenus = $this->menusModels->getAllMenus(0, 0 , array($getMenusById['pid']));
			$strMenus = '<option value="0"> Chọn menus cha</option>';
			$strMenus .= $dataMenus;
			if($getMenusById){
				echo json_encode(array('success' => true, 'data' => $getMenusById, 'dataCate' => $str, 'dataMenus' => $strMenus));die;
			}else{
				setcookie ("__notiCate",'false^_^Không tồn tại menus muốn sửa',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}			
		}
		if(!empty($post) && $post['getData'] == 0){
			$nameMenus = $post['nameMenus'];
			$linkMenus = $post['linkMenus'];
			$this->validation->setRules([
				'linkMenus'=> [
					'label' => 'Label.txtLinkMenus',
					'rules' => 'required',
					'errors' => [
					]
				],
				'nameMenus'=> [
					'label' => 'Label.txtNameMenus',
					'rules' => 'required',
					'errors' => [
					]
				],
			]);

			if(!$this->validation->withRequest($this->request)->run()  ){
				$getErrors = $this->validation->getErrors();
				echo json_encode(array('false' => true, 'data' => $getErrors));die;
			}else{
				$dataUpdate['PID'] = $post['parentMenus'];
				$dataUpdate['NAME'] = $nameMenus;
				$dataUpdate['LINK'] = $linkMenus;
				$dataUpdate['CATEGORY_ID'] = $post['parentCate'];
				$dataUpdate['EDITED_BY'] = $dataUser->userId;
				$dataUpdate['BANNER'] = $post['imgThumbnail'];
				$dataUpdate['POSITION'] = $post['positionMenus'];
				$dataUpdate['STATUS'] = $post['status'];
				$dataUpdate['SLUG'] = $this->convertString->to_slug($nameMenus);
			}
			$resultInsert = $this->menusModels->updateMenus($post['id'], $dataUpdate);
			if($resultInsert){
				setcookie ("__notiCate",'success^_^Sửa menus thành công',time()+ (60*5) , '/');
			}else{
				setcookie ("__notiCate",'false^_^Sửa menus thất bại',time()+ (60*5) , '/');
			}
			echo json_encode(array('success' => true));die;
		}
	}

	public function deleteMenus(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$data = [
				'EDITED_BY' => $dataUser->userId,
				'STATUS' => $post['status']
			];
			$result = $this->menusModels->disableMenus($post['id'], $data);
			if($result){
				setcookie ("__notiCate",'success^_^Thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => true));die;
			}else{
				setcookie ("__notiCate",'false^_^Không thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}
		}
	}
	public function checkExistMenu(){
		$post = $this->request->getPost();
		if(!empty($post)){
			$nameStatus = $post['nameMenus'];
			$resultCheckExistMenu = $this->menusModels->checkExistMenus($nameStatus);
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
