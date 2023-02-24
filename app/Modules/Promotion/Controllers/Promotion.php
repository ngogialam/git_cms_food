<?php 
namespace App\Modules\Promotion\Controllers;

use Error;

class Promotion extends BaseController
{
	//--------------------------------------------------------------------
	//Get List Category
	//--------------------------------------------------------------------
	public function listPromotion(){
		$dataUser = $this->dataUserAuthen;

		$get = $this->request->getGet();
		$conditions['status'] 			= 1;
		if(!empty($get)){
			$conditions['started'] 			= $get['started'];
			$conditions['stoped'] 			= $get['stoped'];
			$conditions['namePromotion'] 	= $get['namePromotion'];
			$conditions['status'] 			= $get['status'];
		}
		$dataProduct = $this->promotionModels->getProduct();
		
		$objects = $this->promotionModels->getListPromotion($conditions);
		$objectNew = [];
		$oldPid = 0;
		$i = 1;
		foreach($objects as $key => $item){
			if($item['PID'] == $oldPid && $oldPid != 0 ){
				$objectNew[$key-$i]['SUB_PRODUCT'][] = $item;
				$i++;
			}else{
				$objectNew[$key] = $item;
				$oldPid = $item['ID'];
				$i = 1;
			}
		}
		$reversed = array_reverse($objectNew);
		
		$data['dataProduct'] = $dataProduct;
		$data['promotionModels'] = $this->promotionModels;
		$data['objects'] = $reversed;
		$data['conditions'] = $conditions;
		$data['dataUser'] = $dataUser;
		$data['title'] = 'Quản lý khuyến mãi';
		$data['view'] = 'App\Modules\Promotion\Views\listPromotion';
		return view('layoutKho/layout', $data);
	}

	//--------------------------------------------------------------------
	//Create Category
	//--------------------------------------------------------------------
	public function addPromotion(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$promotion 		= $post['promotion'];
			
			$dataInsert['PRODUCT_ID'] 			= $promotion['productId'];
			$dataInsert['NAME'] 				= $promotion['namePromotion'];
			$dataInsert['LIMIT_APPLY']			= $promotion['limitApply'];
			$dataInsert['MEASURE_CONDITION'] 	= $promotion['measure'];
			$dataInsert['CONDITION'] 			= $promotion['condition'];
			$dataInsert['QUANTITY_MAX'] 		= $promotion['quantityMax'];
			$dataInsert['STATUS'] 				= $promotion['status'];
			$dataInsert['CREATED_BY'] 			= $dataUser->userId;
			
			$resultInsert = $this->promotionModels->createPromotion($dataInsert, $promotion['started'], $promotion['stoped']);
			if($resultInsert){
				$arrPlus =$promotion['arrPlus'];
				foreach ($arrPlus as $key => $value) {
					$data['PRODUCT_PRICE_ID'] = $value['productPrice'];
					$data['QUANTITY'] = $value['quantity'];
					// $data['PRICE'] = $value['pricePlus'];
					$data['PRICE'] = 0;
					$data['PROMOTION_ID'] = $resultInsert;
					
					$this->promotionModels->createPromotionDetail($data);
				}
				setcookie ("__notiCate",'success^_^Tạo khuyến mãi thành công',time()+ (60*5) , '/');
			}else{
				setcookie ("__notiCate",'false^_^Tạo khuyến mãi thất bại',time()+ (60*5) , '/');
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

	public function deletePromotion(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$data = [
				'EDITED_BY' => $dataUser->userId,
				'STATUS' => $post['status']
			];
			if($post['typeOrder'] == 1){
				$result = $this->promotionModels->disablePromotion($post['id'], $data);
			}else{
				$result = $this->promotionModels->disablePromotionOrder($post['id'], $data);
			}
			if($result){
				setcookie ("__notiCate",'success^_^Thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => true));die;
			}else{
				setcookie ("__notiCate",'false^_^Không thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}
		}
	}

	public function getProductPrice(){
		$post = $this->request->getPost();
		if(!empty($post)){
			$result = $this->promotionModels->getProductPrice($post['productId']);
			echo json_encode(array('success' => true, 'data' => $result));die;
		}
	}

	public function addProductPrice(){
		$post = $this->request->getPost();
		$dataProduct = $this->promotionModels->getProduct();
		if(!empty($post)){
			$html = '<div class="form-group row pdn productPlusItem" count="'.$post['total'].'">';
				$html .= '<div class="col-md-4">';
					$html .= '<label for="productPlus">Sản phẩm tặng kèm <span style="color: red">(*)</span></label>';
					$html .= '<select class="form-control chosen-select productPlusKey-'.$post['total'].' productPlus" key="'.$post['total'].'" name="productPlus">';
						$html .= '<option value="">Chọn sản phẩm tặng kèm</option>';
						$html .= $dataProduct;
					$html .= '</select>';
					$html .= '<span class="error_text errProductPlus-'.$post['total'].'"></span>';
				$html .= '</div>';
				$html .= '<div class="col-md-4">';
					$html .= '<label for="productPrice">Quy cách đóng gói <span style="color: red">(*)</span></label>';
					$html .= '<select class="form-control chosen-select productPriceKey-'.$post['total'].' productPrice" name="productPrice">';
					$html .= '</select>';
					$html .= '<span class="error_text errProductPrice-'.$post['total'].'"></span>';
				$html .= '</div>';
				$html .= '<div class="col-md-3">';
					$html .= '<label for="quantity">Số lượng <span style="color: red">(*)</span></label>';
					$html .= '<input type="text" name="quantity" class="form-control quantityKey-'.$post['total'].' quantity" value="1">';
				$html .= '</div>';
				// $html .= '<div class="col-md-2">';
				// 	$html .= '<label for="pricePlus">Giá <span style="color: red">(*)</span></label>';
				// 	$html .= '<input type="text" name="pricePlus" class="form-control pricePlusKey-'.$post['total'].' pricePlus" value="0">';
				// $html .= '</div>';
				$html .= '<div class="col-md-1">';
					$html .= '<label for="removeProductPlus" class="blRemoveProductPlus"></label>';
					$html .= '<button type="button" class="btn btn-danger removeProductPlus removeProductPlus-'.$post['total'].'"><span><i class="mdi mdi-minus-circle-outline"></i></span></button>';
				$html .= '</div>';
			$html .= '</div>';
			echo json_encode(array('success' => true, 'data' => $html));die;
		}
	}
	public function listPromotionOrder(){
		$dataUser = $this->dataUserAuthen;

		$get = $this->request->getGet();
		if(!empty($get)){
			$conditions['started'] 			= $get['started'];
			$conditions['stoped'] 			= $get['stoped'];
			$conditions['namePromotion'] 	= $get['namePromotion'];
			$conditions['status'] 			= $get['status'];
			$conditions['type'] 			= $get['type'];
		}
		
		$objects = $this->promotionModels->getListPromotionOrder($conditions);
		$data['promotionModels'] = $this->promotionModels;
		$data['objects'] = $objects;
		$data['conditions'] = $conditions;
		$data['dataUser'] = $dataUser;
		$data['title'] = 'Quản lý khuyến mãi';
		$data['view'] = 'App\Modules\Promotion\Views\listPromotionOrder';
		return view('layoutKho/layout', $data);
	}
	public function getPromotionOrder(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post) && $post['getData'] == 1){
			$promotionOrderById = $this->promotionModels->getPromotionOrder($post['promotionID']);
			// echo '<pre>';
			// print_r($promotionOrderById);die;
			if($promotionOrderById){
				echo json_encode(array('success' => true, 'data' => $promotionOrderById[0]));die;
			}else{
				setcookie ("__notiCate",'false^_^Không tồn tại Phương thức muốn sửa',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}
		}
	}

	public function addPromotionOrder(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$promotion 		= $post['promotion'];
			if($promotion['type'] == 1){
				$dataInsert['EDITED_BY'] 			= $dataUser->userId;
				$resultInsert = $this->promotionModels->updatePromotionOrder($promotion['promotionOrderId'], $promotion['startedPromotionOrder'], $promotion['stopedPromotionOrder']);
				if($resultInsert){
					setcookie ("__notiCate",'success^_^Sửa khuyến mãi đơn hàng thành công',time()+ (60*5) , '/');
				}else{
					setcookie ("__notiCate",'false^_^Sửa khuyến mãi đơn hàng thất bại',time()+ (60*5) , '/');
				}
			}else{

				$dataInsert['TYPE'] 				= $promotion['typePromotionOrder'];
				$dataInsert['MEASURE_CONDITION'] 	= $promotion['measurePromotionOrder'];
				$dataInsert['NAME']					= $promotion['namePromotionOrder'];
				$dataInsert['CONDITION'] 			= str_replace( array( ',', '.', '  ', '   '), '', $promotion['conditionPromotionOrder']);
				$dataInsert['DISCOUNT_VALUE'] 		= $promotion['discountValuePromotionOrder'];
				$dataInsert['DISCOUNT_MAX'] 		= $promotion['discountMaxPromotionOrder'];
				$dataInsert['STATUS'] 				= $promotion['statusPromotionOrder'];
				$dataInsert['CREATED_BY'] 			= $dataUser->userId;
				
				$resultInsert = $this->promotionModels->createPromotionOrder($dataInsert, $promotion['startedPromotionOrder'], $promotion['stopedPromotionOrder']);
				if($resultInsert){
					setcookie ("__notiCate",'success^_^Tạo khuyến mãi đơn hàng thành công',time()+ (60*5) , '/');
				}else{
					setcookie ("__notiCate",'false^_^Tạo khuyến mãi đơn hàng thất bại',time()+ (60*5) , '/');
				}
			}
			echo json_encode(array('success' => true));die;
		}
	}
	public function checkExistPromotion(){
		$post = $this->request->getPost();
		if(!empty($post)){
			$nameStatus = $post['namePromotion'];
			$type = $post['type'];
			$resultCheckExist = $this->promotionModels->checkExistPromotion($nameStatus,$type);
			if(empty($resultCheckExist)){
                echo json_encode(array('success' => true, 'status' => '1',));die;
            }else{
                echo json_encode(array('success' => false, 'status' => '0',));die;
            }
        }else{
            echo json_encode(array('success' => false, 'status' => '0',));die;
        }
	}
	public function addSetProductPromotion(){
		$post = $this->request->getPost();

        if (!empty($post)) {
            $html = '';
			$dataProduct = $this->promotionModels->getProduct();
			$key = $post['total'];
			$html .= '<div class="form-group row pdn setProductPlusItem">';

				$html .= '<div class="col-md-4">';
					$html .= '<label for="setProductPlus">Sản phẩm set <span style="color: red">(*)</span></label>';
					$html .= '<select class="form-control chosen-select setProductPlusKey-'.$key.' setProductPlus" key="0" name="setProductPlus">';
						$html .= '<option value="">Chọn sản phẩm set</option>';
						$html .= $dataProduct;
					$html .= '</select>';
					$html .= '<span class="error_text errSetProductPlus-'.$key.'"></span>';
				$html .= '</div>';

				$html .= '<div class="col-md-3">';
					$html .= '<label for="measureSet-'.$key.'">Đơn vị tính <span style="color: red">(*)</span></label>';
					$html .= '<select class="form-control chosen-select measureSet-'.$key.' measureSet" id="measureSet-'.$key.'" name="measureSet-'.$key.'" data-placeholder="Đơn vị tính">';
						$html .= '<option value="1">Gram</option>';
						$html .= '<option value="2">Đồng</option>';
					$html .= '</select>';
					$html .= '<span class="error_text errSetProductPlus-'.$key.'"></span>';
				$html .= '</div>';

				$html .= '<div class="col-md-3">';
					$html .= '<label for="conditionSet-'.$key.'"> Điều kiện áp dụng <span style="color: red">(*)</span></label>';
					$html .= '<input type="text" name="conditionSet-'.$key.'" class="form-control conditionSet-'.$key.'" id="conditionSet-'.$key.'" placeholder="Điều kiện áp dụng" value="">';
					$html .= '<span class="error_text errConditionSet-'.$key.'"></span>';
				$html .= '</div>';
				
				
				$html .= '<div class="col-md-1">';
					$html .= '<label for="removeProductPlus" class="blRemoveSetProductPlus blRemoveProductPlus"></label>';
					$html .= '<button type="button" class="btn btn-danger removeProductPlus removeProductPlus-'.$key.'"><span><i class="mdi mdi-minus-circle-outline"></i></span></button>';
				$html .= '</div>';


			$html .= '</div>';

            echo json_encode(array('success' => true, 'data' => $html));
            die;
        }else {
            echo json_encode(array('success' => false, 'data' => ''));
            die;
        }
	}
	public function addProductSetPrice(){
		$post = $this->request->getPost();
		$dataProduct = $this->promotionModels->getProduct();
		if(!empty($post)){
			$html = '<div class="form-group row pdn productPlusItemSet" count="'.$post['total'].'">';
				$html .= '<div class="col-md-4">';
					$html .= '<label for="productSetPlus">Sản phẩm tặng kèm <span style="color: red">(*)</span></label>';
					$html .= '<select class="form-control chosen-select productSetPlusKey-'.$post['total'].' productSetPlus" key="'.$post['total'].'" name="productSetPlus">';
						$html .= '<option value="">Chọn sản phẩm tặng kèm</option>';
						$html .= $dataProduct;
					$html .= '</select>';
					$html .= '<span class="error_text errProductSetPlus-'.$post['total'].'"></span>';
				$html .= '</div>';
				$html .= '<div class="col-md-4">';
					$html .= '<label for="productSetPrice">Quy cách đóng gói <span style="color: red">(*)</span></label>';
					$html .= '<select class="form-control chosen-select productSetPriceKey-'.$post['total'].' productSetPrice" name="productSetPrice">';
					$html .= '<option value="">Chọn quy cách đóng goi</option>';
					$html .= '</select>';
					$html .= '<span class="error_text errProductSetPrice-'.$post['total'].'"></span>';
				$html .= '</div>';
				$html .= '<div class="col-md-3">';
					$html .= '<label for="quantitySet">Số lượng <span style="color: red">(*)</span></label>';
					$html .= '<input type="text" name="quantitySet" class="form-control quantitySetKey-'.$post['total'].' quantitySet" value="1">';
				$html .= '</div>';
				// $html .= '<div class="col-md-2">';
				// 	$html .= '<label for="priceSetPlus">Giá <span style="color: red">(*)</span></label>';
				// 	$html .= '<input type="text" name="priceSetPlus" class="form-control priceSetPlusKey-'.$post['total'].' priceSetPlus" value="0">';
				// $html .= '</div>';
				
				$html .= '<div class="col-md-1">';
					$html .= '<label for="removeProductSetPlus" class="blRemoveProductPlus"></label>';
					$html .= '<button type="button" class="btn btn-danger removeProductSetPlus removeProductSetPlus-'.$post['total'].'"><span><i class="mdi mdi-minus-circle-outline"></i></span></button>';
				$html .= '</div>';
			$html .= '</div>';
			echo json_encode(array('success' => true, 'data' => $html));die;
		}
	}
	public function addSetPromotion(){
		$dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$token = $dataUser->token;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$promotion 		= $post['promotion'];
			$start = $promotion['started'].' 00:00:00';
			$stop = $promotion['stoped'].' 23:59:59';
			$dataInsert['name'] 			= $promotion['namePromotion'];
			$dataInsert['limit'] 				= $promotion['limitApply'];
			$dataInsert['start'] 				= $start;
			$dataInsert['stop'] 				= $stop;
			$dataInsert['status'] 				= $promotion['status'];
			$dataInsert['max'] 				= $promotion['quantityMax'];
			$subPromotionsPost = $promotion['arrPlusSet'];
			$listSubPromotions = [];
			foreach ($subPromotionsPost as $subpromotion) {
				$subPromotionsObj = new \stdClass;
				$subPromotionsObj->productId = (int) $subpromotion['setProductPlusKey'];
				$subPromotionsObj->measure = (int) $subpromotion['measureSet'];
				$subPromotionsObj->condition = (int) $subpromotion['conditionSet'];
				array_push($listSubPromotions, $subPromotionsObj);
			}
			$dataInsert['subPromotions'] 				= $listSubPromotions;

			$promotionDetailPost = $promotion['arrPlus'];
			$listPromotionDetail = [];
			foreach ($promotionDetailPost as $promotionDetail) {
				$promotionDetailsObj = new \stdClass;
				$promotionDetailsObj->priceId = (int) $promotionDetail['productPrice'];
				$promotionDetailsObj->price = (int) $promotionDetail['pricePlus'];
				$promotionDetailsObj->price = (int) 0;
				$promotionDetailsObj->quantity = (int) $promotionDetail['quantity'];
				array_push($listPromotionDetail, $promotionDetailsObj);
			}
			$dataInsert['promotionDetails'] 				= $listPromotionDetail;
			
			$resultInsert = $this->promotionModels->createSetPromotion($dataInsert, $headers, $username);
			if($resultInsert->status == 200){
				setcookie ("__notiCate",'success^_^Tạo khuyến mãi thành công',time()+ (60*5) , '/');
			}else{
				setcookie ("__notiCate",'false^_^Tạo khuyến mãi thất bại',time()+ (60*5) , '/');
			}
			echo json_encode(array('success' => true));die;
		}
	}
}

