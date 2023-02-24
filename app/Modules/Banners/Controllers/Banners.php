<?php 
namespace App\Modules\Banners\Controllers;

class Banners extends BaseController
{
	//--------------------------------------------------------------------
	//Get List Category
	//--------------------------------------------------------------------
	public function listBanners(){
		$dataUser = $this->dataUserAuthen;
		$get = $this->request->getGet();
		$conditions['pid'] = '';
		if(!empty($get)){
			$conditions['pid'] 				= $get['pid'];
			$conditions['nameBanners'] 		= $get['nameBanners'];
			$conditions['status'] 			= $get['status'];
		}
		$objects = $this->bannersModels->getListBanners($conditions);
		
		$dataCate = $this->bannersModels->getAllCateBanners(CATEGORY_BANNERS, 0 , array($conditions['pid']));
		
		$data['objects'] = $objects;
		$data['conditions'] = $conditions;
		$data['dataCate'] = $dataCate;
		$data['dataUser'] = $dataUser;
		$data['title'] = 'Quản lý Banners';
		$data['view'] = 'App\Modules\Banners\Views\listBanners';
		return view('layoutKho/layout', $data);
	}

	//--------------------------------------------------------------------
	//Create Category
	//--------------------------------------------------------------------
	public function addBanners(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$nameBanners = $post['nameBanners'];
			$linkBanners = $post['linkBanners'];
			$this->validation->setRules([
				'linkBanners'=> [
					'label' => 'Label.txtLinkBanners',
					'rules' => 'required',
					'errors' => [
					]
				],
				'nameBanners'=> [
					'label' => 'Label.txtNameBanners',
					'rules' => 'required',
					'errors' => [
					]
				],
			]);

			if(!$this->validation->withRequest($this->request)->run()  ){
				$getErrors = $this->validation->getErrors();
				echo json_encode(array('success' => false, 'data' => $getErrors));die;
			}else{

				$dataInsert['NAME'] = $nameBanners;
				$dataInsert['LINK'] = $linkBanners;
				$dataInsert['CATEGORY_ID'] = $post['parentCate'];
				$dataInsert['CONTENT'] = $post['contentBanners'];
				$dataInsert['CREATED_BY'] = $dataUser->userId;
				$dataInsert['IMAGE'] = $post['imgThumbnail'];
				$dataInsert['STATUS'] = $post['status'];
			}
			$resultInsert = $this->bannersModels->createBanners($dataInsert);
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
	public function editBanners(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post) && $post['getData'] == 1){
			$getMenusById = $this->bannersModels->getBannersById($post['id']);
			$dataCate = $this->productsModels->getAllCate(CATEGORY_BANNERS, 0 , array($getMenusById['categoryId']));
			$str = '<option value=""> Chọn danh mục</option>';
			$str .= $dataCate;
			if($getMenusById){
				echo json_encode(array('success' => true, 'data' => $getMenusById, 'dataCate' => $str));die;
			}else{
				setcookie ("__notiCate",'false^_^Không tồn tại banners muốn sửa',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}
		}
		if(!empty($post) && $post['getData'] == 0){
			$nameBanners = $post['nameBanners'];
			$this->validation->setRules([
				'nameBanners'=> [
					'label' => 'Label.txtNameBanners',
					'rules' => 'required',
					'errors' => [
					]
				],
			]);

			if(!$this->validation->withRequest($this->request)->run()  ){
				$getErrors = $this->validation->getErrors();
				echo json_encode(array('false' => true, 'data' => $getErrors));die;
			}else{
				$dataUpdate['CATEGORY_ID'] = $post['parentCate'];
				$dataUpdate['NAME'] = $nameBanners;
				$dataUpdate['LINK'] = $post['linkBanners'];
				$dataUpdate['CONTENT'] = $post['contentBanners'];
				$dataUpdate['EDITED_BY'] = $dataUser->userId;
				$dataUpdate['IMAGE'] = $post['imgThumbnail'];
				$dataUpdate['STATUS'] = $post['status'];
			}
			$resultInsert = $this->bannersModels->updateBanners($post['id'], $dataUpdate);
			if($resultInsert){
				setcookie ("__notiCate",'success^_^Sửa banners thành công',time()+ (60*5) , '/');
			}else{
				setcookie ("__notiCate",'false^_^Sửa banners thất bại',time()+ (60*5) , '/');
			}
			echo json_encode(array('success' => true));die;
		}
	}

	public function deleteBanners(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$data = [
				'EDITED_BY' => $dataUser->userId,
				'STATUS' => $post['status']
			];
			$result = $this->bannersModels->disableBanners($post['id'], $data);
			if($result){
				setcookie ("__notiCate",'success^_^Thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => true));die;
			}else{
				setcookie ("__notiCate",'false^_^Không thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}
		}
	}
	public function checkExistBanner(){
		$post = $this->request->getPost();
		if(!empty($post)){
			$nameStatus = $post['nameBanners'];
			$resultCheckExistMenu = $this->bannersModels->checkExistBanner($nameStatus);
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
