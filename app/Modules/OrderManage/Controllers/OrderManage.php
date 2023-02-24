<?php

namespace App\Modules\OrderManage\Controllers;

use stdClass;

class OrderManage extends BaseController
{
	public function listOrders($page = 1)
	{
		$dataUser = $this->dataUserAuthen;
		$username = $dataUser->username;
		$token = $dataUser->token;
		$title = 'Danh sách đơn hàng';
		$arraySearch = [
			'status' => 1
		];
		//Pagination
		$page 					= ($this->page) ? $this->page : 1;
		$data['page'] 			= $page;
		$data['perPage'] 		= PERPAGE;
		$data['pager'] 			= $this->pager;
		$data['total'] 			= 0;
		$data['uri'] = $this->uri;
		$conditions['OFFSET'] = (($page - 1) * $data['perPage']);
		$conditions['LIMIT']  = $data['perPage'];
		$dataCall = [
			'keyword' => '',
			'status' => -1,
			'fromDate' => "",
			'toDate' => "",
			'page' => $page,
			'pagesize' => PERPAGE
		];
		$get = $this->request->getGet();
		if (!empty($get)) {
			$dataCall = [
				'keyword' => $get['keySearch'],
				'status' => $get['status'],
				'fromDate' => $get['started'],
				'toDate' => $get['stoped'],
				'page' => $page,
				'pagesize' => PERPAGE
			];
		}
		$headers = [
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: ' . $token,
		];
		$listOrder = [];
		$resultListOrders = $this->orderManageModels->getListOrders($dataCall, $headers, $username);
		$getTotalProducts = 0;
		if ($resultListOrders->status == 200) {
			$listOrder = $resultListOrders->data;
			$getTotalProducts = $listOrder->numOfRecords;
		}
		$data['total'] = $getTotalProducts;
		$data['arrStatus'] = $this->arrStatus;
		$data['get'] = $get;
		$data['objects'] = $listOrder;
		$data['title'] = $title;
		$data['dataUser'] = $dataUser;
		$data['view'] = 'App\Modules\OrderManage\Views\listOrders';
		return view('layoutKho/layout', $data);
	}
	public function detailOrders($orderCode)
	{
		$dataUser = $this->dataUserAuthen;
		$username = $dataUser->username;
		$userId = $dataUser->userId;
		$token = $dataUser->token;
		$title = 'Chi tiết đơn hàng';
		if ($orderCode == '') {
			setcookie("__order", 'false^_^Có lỗi khi lấy chi tiết đơn hàng1', time() + (60 * 5), '/');
			header("Location: " . base_url('/don-hang/danh-sach-don-hang'));
			die;
		}
		$dataCall = [
			'orderCode' => $orderCode
		];
		$headers = [
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: ' . $token,
		];
		$dataDetailOrder = [];
		$getDetailOrder = $this->orderManageModels->getDetailOrder($dataCall, $headers);
		if ($getDetailOrder->status == 200) {
			$dataDetailOrder = $getDetailOrder->data;
		} else {
			setcookie("__order", 'false^_^Có lỗi khi lấy chi tiết đơn hàng2', time() + (60 * 5), '/');
			header("Location: " . base_url('/don-hang/danh-sach-don-hang'));
			die;
		}

		// print_r($dataDetailOrder);die;

		if (empty($dataDetailOrder)) {
			setcookie("__order", 'false^_^Có lỗi khi lấy chi tiết đơn hàng3', time() + (60 * 5), '/');
			header("Location: " . base_url('/don-hang/danh-sach-don-hang'));
			die;
		}
		$resultGetBox = $this->orderManageModels->getBox($headers, $username);
		if ($resultGetBox->status == 200) {
			$listBox = $resultGetBox->data;
		}
		$listProvinces = $this->orderManageModels->getListProvinces();
		if ($listProvinces->status == 200) {
			$list_province = $listProvinces->data;
		}
		$provinceReceiver = $dataDetailOrder->provinceCode;
		if ($provinceReceiver != '') {
			$dataDistrict = $this->orderManageModels->getListDistrict($provinceReceiver);
			if ($dataDistrict->status == 200) {
				$list_district = $dataDistrict->data;
			} else {
				$list_district = [];
			}
		} else {
			$list_district = [];
		}

		$districtReceiver = $dataDetailOrder->districtCode;
		if ($districtReceiver != '') {
			$dataWards = $this->orderManageModels->getListDistrict($districtReceiver);
			if ($dataWards->status == 200) {
				$list_wards = $dataWards->data;
			} else {
				$list_wards = [];
			}
		} else {
			$list_wards = [];
		}

		$resultMethods = $this->orderManageModels->getMethods();
		$arrMethods = [];
		if ($resultMethods->status == 200) {
			$arrMethods = $resultMethods->data;
		}
		$data['title'] = $title;
		$data['arrMethods'] = $arrMethods;
		$data['listBox'] = $listBox;
		$data['dataDetailOrder'] = $dataDetailOrder;
		$data['list_province'] = $list_province;
		$data['list_district'] = $list_district;
		$data['list_wards'] = $list_wards;
		$data['dataUser'] = $dataUser;
		$data['view'] = 'App\Modules\OrderManage\Views\detailOrder';
		return view('layoutKho/layout', $data);
	}

	public function changeStatus()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$token = $dataUser->token;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$orderId = $post['orderId'];
			$dataCall = [
				'orderCode' => $orderId
			];
			$resultChangeStatus = $this->orderManageModels->changeStatus($dataCall, $headers, $username);
			if ($resultChangeStatus->status == 200) {
				setcookie("__order", 'success^_^Cập nhật đơn hàng thành công', time() + (60 * 5), '/');
			} else {
				setcookie("__order", 'false^_^' . $resultChangeStatus->message, time() + (60 * 5), '/');
			}
			$url = base_url('/don-hang/danh-sach-don-hang');
			echo json_encode(array('success' => true, 'href' => $url));
			die;
		}
	}
	public function cancelOrder()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$token = $dataUser->token;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$orderId = $post['orderId'];
			$dataCall = [
				'orderCode' => $orderId
			];
			$resultCancelOrder = $this->orderManageModels->cancelOrder($dataCall, $headers, $username);
			if ($resultCancelOrder->status == 200) {
				setcookie("__order", 'success^_^Hủy đơn hàng thành công', time() + (60 * 5), '/');
			} else {
				setcookie("__order", 'false^_^' . $resultCancelOrder->message, time() + (60 * 5), '/');
			}
			$url = base_url('/don-hang/danh-sach-don-hang');
			echo json_encode(array('success' => true, 'href' => $url));
			die;
		}
	}
	public function confirmNetWeight()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$userId = $dataUser->userId;
			$token = $dataUser->token;
			$dataCallNetWeight = new stdClass;
			$dataCallNetWeight->orderCode = $post['confirmOrder']['orderId'];
			$arrPlus = $post['confirmOrder']['arrPlus'];
			$arrOrderDetail = [];
			foreach ($arrPlus as $orderDetail) {
				$dataOrderDetail = new stdClass;
				$dataOrderDetail->orderDetailId = $orderDetail['orderDetailId'];
				$dataOrderDetail->weight = str_replace(array(',', '.', '  ', '   '), '', $orderDetail['weight']);
				array_push($arrOrderDetail, $dataOrderDetail);
			}
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$dataCallNetWeight->wrapperOrderDetails = $arrOrderDetail;
			$dataCallNetWeight->boxId = $post['confirmOrder']['sizeBox'];
			$resultWrapperOrder = $this->orderManageModels->wrapperOrder($dataCallNetWeight, $headers, $username);
			if ($resultWrapperOrder->status == 200) {
				setcookie("__order", 'success^_^Cập nhật đơn hàng thành công', time() + (60 * 5), '/');
				// echo json_encode(array('success' => true ,'message' => $resultWrapperOrder->message));die;
			} else {
				setcookie("__order", 'false^_^Cập nhật đơn hàng thất bại', time() + (60 * 5), '/');
				// echo json_encode(array('success' => false,'message' => $resultWrapperOrder->message));die;
			}
			$url = base_url('/don-hang/danh-sach-don-hang');
			echo json_encode(array('success' => true, 'href' => $url));
			die;
		}
	}
	public function prepareOrder()
	{
		$get = $this->request->getGet();
		if (!empty($get)) {
			$orderId = $get['orderId'];
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$userId = $dataUser->userId;
			$token = $dataUser->token;
			$title = 'Chuẩn bị đơn hàng';

			$dataCall = [
				'orderCode' => $orderId
			];
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$dataDetailOrder = [];
			$getDetailOrder = $this->orderManageModels->getDetailOrder($dataCall, $headers);
			if ($getDetailOrder->status == 200) {
				$dataDetailOrder = $getDetailOrder->data;
			}
			$resultGetBox = $this->orderManageModels->getBox($headers, $username);
			if ($resultGetBox->status == 200) {
				$listBox = $resultGetBox->data;
			}
			$dataAllItemOrder = [];
			$getAllItemInOrder = $this->orderManageModels->findAllItemInOrder($dataCall, $headers);
			if ($getAllItemInOrder->status == 200) {
				$dataAllItemOrder = $getAllItemInOrder->data;
			}
			if ($dataDetailOrder->status != 100) {
				setcookie("__order", 'false^_^Trạng thái không phù hợp', time() + (60 * 5), '/');
				header("Location: " . base_url('/don-hang/danh-sach-don-hang'));
				die;
			}
			$data['dataAllItemOrder'] = $dataAllItemOrder;
			$data['title'] = $title;
			$data['listBox'] = $listBox;
			$data['dataDetailOrder'] = $dataDetailOrder;
			$data['dataUser'] = $dataUser;
			$data['view'] = 'App\Modules\OrderManage\Views\prepareOrder';
			return view('layoutKho/layout', $data);
		} else {
			setcookie("__order", 'false^_^Có lỗi khi lấy chi tiết đơn hàng', time() + (60 * 5), '/');
			header("Location: " . base_url('/don-hang/danh-sach-don-hang'));
			die;
		}
	}
	public function prepareOrderWeightAjax()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$prepareOrderQR = $post['prepareOrderQR'];
			$orderId = $post['orderId'];
			$lengPrepare = strlen($prepareOrderQR);
			if ($lengPrepare == 13) {
				$productOrder = substr($prepareOrderQR, 2, 5);
				$weightProduct = substr($prepareOrderQR, 7, 5);
			} else {
				$productOrder = substr($prepareOrderQR, 0, 5);
				$weightProduct = substr($prepareOrderQR, 5);
			}
			$dataUser = $this->dataUserAuthen;
			$token = $dataUser->token;
			$username = $dataUser->username;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$dataCallApi = [
				"productCode" => $productOrder,
				"orderCode" => $orderId,
				"weight" => $weightProduct,
				// "type" => $post['typeProduct'],
				"itemCode" => $prepareOrderQR,
			];

			$responseApi = $this->orderManageModels->prepareOrder($dataCallApi, $headers, $username);
			if ($responseApi->status == 200) {
				$dataItem = $responseApi->data;
				$html = '';
				$html .= '<tr class="qrItem prepare-' . $dataItem->id . '">';
				$html .= '<td class="pro-title">';
				$html .= '<img class="img-fluid" src="' . $dataItem->productImg . '" alt="Product">';
				$html .= '<span>' . $dataItem->productName . '</span>';
				$html .= '</td>';
				$html .= '<td class="pro-quantity text-center">' . $dataItem->tempWeight . ' ' . $dataItem->unit . '</td>';
				$html .= '<td class="pro-subtotal text-center">' . number_format($dataItem->totalMoney) . '</td>';
				$html .= '<td>';
				$html .= '<button class="btn btn-danger btn-icon-custom" type="button" onclick="removePrepareProduct(' . $dataItem->id . ', ' . $orderId . ')" title="Xóa" >';
				$html .= '<i class="mdi mdi-close-circle-outline"></i>';
				$html .= '</button>';
				$html .= '</td>';
				$html .= '</tr>';
				$moneyItem = $dataItem->totalMoney;
				echo json_encode(array('success' => true, 'moneyItem' => $moneyItem, 'html' => $html));
				die;
			} else {
				echo json_encode(array('success' => false, 'message' => $responseApi->message));
				die;
			}
		}
	}
	public function wrapperOrderQR()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$token = $dataUser->token;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$orderCode = $post['orderCode'];
			$boxId = $post['boxId'];
			$dataCall = [
				'orderCode' => $orderCode,
				'boxId' => $boxId
			];
			$resultChangeStatus = $this->orderManageModels->wrapperOrder($dataCall, $headers, $username);
			if ($resultChangeStatus->status == 200) {
				setcookie("__order", 'success^_^Cập nhật đơn hàng thành công', time() + (60 * 5), '/');
			} else {
				setcookie("__order", 'false^_^' . $resultChangeStatus->message, time() + (60 * 5), '/');
			}
			$urlPrint = base_url('/don-hang/printExportOrder?orderCode=' . $orderCode . '&type=' . $post['type']);
			$url = base_url('/don-hang/danh-sach-don-hang');
			echo json_encode(array('success' => true, 'href' => $url, 'printUrl' => $urlPrint, 'status' => $resultChangeStatus->status));
			// echo json_encode(array('success' => true, 'href' => $url, 'printUrl' => $urlPrint, 'status' => 200));
			die;
		} else {
			setcookie("__order", 'success^_^Cập nhật đơn hàng không thành công. Liên hệ admin', time() + (60 * 5), '/');
			$url = base_url('/don-hang/danh-sach-don-hang');
			echo json_encode(array('success' => false, 'href' => $url));
			die;
		}
	}
	public function printExportOrder()
	{
		$get = $this->request->getGet();
		$dataUser = $this->dataUserAuthen;
		$token = $dataUser->token;
		// $orderCode = 220308135864;
		$orderCode = $get['orderCode'];

		$dataCall = [
			'orderCode' => $orderCode
		];
		$headers = [
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: ' . $token,
		];
		$dataAllItemOrder = [];
		$type = $get['type'];
		if ($type == 2) {
			$getAllItemInOrder = $this->orderManageModels->findAllItemTotalInOrder($dataCall, $headers);
		} else {
			$getAllItemInOrder = $this->orderManageModels->getDetailOrder($dataCall, $headers);
		}
		if ($getAllItemInOrder->status == 200) {
			$dataAllItemOrder = $getAllItemInOrder->data;
		}
		$data['objects'] = $dataAllItemOrder;
		$data['type'] = $type;
		$data['view'] = 'App\Modules\OrderManage\Views\viewA5';
		return view('layoutPrint/layout_printa5', $data);
	}
	// =======Thêm sản phẩm vào đơn hàng============
	public function searchProduct($type = 1)
	{
		if ($this->request->getPost()) {
			$post = $this->request->getPost();
			if ($type == 2) {
				$key = '';
			} else {

				$key = $post['key'];
			}
			// print_r($post);die;
			$dataCallAPI = [
				'keyword' => $key,
				'page' => 1,
				'pagesize' => 1000,
				'sorted' => 1,
			];
			$respon =  $this->orderManageModels->searchProduct($dataCallAPI);
			// echo '<pre>';
			// print_r($respon);die;
			$html = '';
			if ($respon->status == 200) {
				if ($type == 2) {
					// foreach($respon->data->products as $item){
					// 	$objectsList[] = (array)$item;
					// }
					return $respon->data->products;
				}
				if ($respon->data->numOfRecords == 0) {
					echo json_encode(array('success' => false, 'message' => 'Không tìm thấy sản phẩm'));
					die;
				}

				foreach ($respon->data->products as $index => $value) {
					$html .= '
                        <div class="col-6">
                            <div class="product-search-modal" onclick="chooseProduct(' . $value->id . ')">
                                <img src="' . $value->image . '" alt="">
                                <div class="product-search-modal-detail-1">
                                    <span>' . $value->name . '</span>
                                    <span>' . $value->stock . ' sản phẩm có sẵn</span>
                                </div>
                                <div class="product-search-modal-detail-2">
                                    <div>
                                        <span>' . number_format($value->unitPrice, 0) . '</span>
                                        <span>đ / ' . $value->weight . ' ' . $value->unit . '</span>
                                    </div>
                                    <div> &nbsp</div>
                                </div>
                            </div>
                    </div>
                    ';
				}

				echo json_encode(array('success' => true, 'message' => 'Lấy thành công data search', 'html' => $html, 'arrProducts' => $respon->data->products));
				die;
			}
		}
	}
	public function addNewProductToOrder()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataCallPromotion = [];
			$arrPlus = $post['newProducts']['arrPlus'];
			$i = 0;
			$dataUser = $this->dataUserAuthen;
			$token = $dataUser->token;
			$username = $dataUser->username;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$dataRemove = [];
			$promotionRemove = [];
			foreach ($arrPlus as $value) {
				$productItem = new \stdClass;
				$productItem->productId = $value['productNamePlus'];
				$productItem->priceId = $value['weightProduct'];
				$productItem->quantity = $value['quantityProduct'];
				$productItem->duplicateProduct = $value['duplicateProduct'];
				$dataCallPromotion[$i] = $productItem;
				$i++;
				if ($value['duplicateProduct'] == 1) {
					$dataRemove[$i]['keyRemove'] = $value['productNamePlus'] . '-' . $value['weightProduct'];
					$promotionRemove[$i]['keyRemove'] = $value['productNamePlus'];
				}
			}
			$dataRequest = [
				'orderCode' => $post['newProducts']['orderCode'],
				'products' => $dataCallPromotion
			];
			$resultCallPromotion = $this->orderManageModels->getPromotion($dataRequest);
			$dataProducts = $this->searchProduct(2);
			$keyProductView = $post['newProducts']['keyTotal'];
			// $keyTotal = $post['newProducts']['keyTotal'];
			// echo $keyTotal;

			if ($resultCallPromotion->status == 200) {
				$objects = $resultCallPromotion->data->products;
				$html = '';
				foreach ($objects as $item) {
					$dataProductKey = array_search($item->productId, array_column($dataProducts, 'id'));
					if ($dataProductKey !== false) {

						$setProduct = $item->setProducts;
						$objectProduct = $dataProducts[$dataProductKey];
						$html .= '<tr keyMain="' . $keyProductView . '" class="productMainId-' . $item->productId . ' productMainId-' . $objectProduct->productPriceID . '-' . $item->priceId . ' productId-' . $objectProduct->productPriceID . '-' . $item->priceId . ' itemProduct-' . $keyProductView . '">';
						$html .= '<td class="pro-title">';
						$html .= '<img class="img-fluid" src="' . $objectProduct->image . '" alt="Product"> ';
						$html .= $objectProduct->name;
						$html .= '</td>';

						$html .= '<td class="pro-packing">';
						if (empty($setProduct)) {
							$html .= '<select class="form-control chosen-select weightProduct weightProduct-' . $keyProductView . '" key="' . $keyProductView . '" name="weightProduct" data-placeholder="Quy cách đóng gói">';
							foreach ($objectProduct->prices as $itemPrice) {
								if ($item->priceId == $itemPrice->id) {
									$priceFirst = $itemPrice;
									$selected = 'selected';
									// $html .='<option selected keystock="'.$itemPrice->stock.'" keyprice="'.$itemPrice->price.'" value="'.$itemPrice->id.'">'.$itemPrice->weight.' '.$itemPrice->unit.'</option>';
								} else {
									$selected = '';
									// $html .='<option keystock="'.$itemPrice->stock.'" keyprice="'.$itemPrice->price.'" value="'.$itemPrice->id.'">'.$itemPrice->weight.' '.$itemPrice->unit.'</option>';
								}
								$html .= '<option ' . $selected . ' keystock="' . $itemPrice->stock . '" keyprice="' . $itemPrice->price . '" value="' . $itemPrice->id . '">' . $itemPrice->weight . ' ' . $itemPrice->unit . '</option>';
							}
							$html .= '</select>';
							$html .= '<input type="hidden" class="checkSet checkSet-' . $keyProductView . '" value="0" />';
							$html .= '<input type="hidden" class="setPrice setPrice-' . $keyProductView . '" value="0" />';
						} else {
							$html .= '<span>1 Set</span>';
							$priceFirst = end($objectProduct->prices);
							$html .= '<input type="hidden" class="checkSet checkSet-' . $keyProductView . '" value="1" />';
							
								$priceSet = $priceFirst->price * $priceFirst->weight;
								$html .= '<input type="hidden" class="setPrice 123 setPrice-' . $keyProductView . '" value="' . $priceSet . '" />';
								$html .= '<input type="hidden" value="'.$priceFirst->id.'" name="priceIdSet-' . $keyProductView . '" class="priceIdSet-' . $keyProductView . '">';
						}
						$html .= '</td>';

						$html .= '<td class="pro-price">';
						$html .= '<span class="priceWeight-' . $keyProductView . '">' . number_format($priceFirst->price) . ' đ/ ' . $priceFirst->weight . ' ' . $priceFirst->unit . '</span>';
						$html .= '</td>';

						$html .= '<td class="pro-quantity">';
						$html .= '<input type="number" key="' . $keyProductView . '" class="form-control quantity quantity-' . $keyProductView . '" name="quantity-' . $keyProductView . '" value="' . $item->quantity . '" >';
						$html .= '</td>';

						$html .= '<td class="pro-subtotal">';
						$html .= '<span class="price-' . $keyProductView . '">' . number_format($priceFirst->price * $item->quantity) . ' đ</span>';
						$html .= '</td>';

						$html .= '<td>';
						$onclick = "removeProduct('" . $objectProduct->productPriceID . '-' . $item->priceId . "')";
						$html .= '<span> <button type="button" onclick="' . $onclick . '" class="btn btn-danger removeProductPlus removeProductPlus-' . $keyProductView . '"> <span><i class="mdi mdi-minus-circle-outline"></i></span> </button> </span>';
						$html .= '</td>';

						$html .= '<input type="hidden" value="' . $objectProduct->name . '" name="productName-' . $keyProductView . '" class="productName-' . $keyProductView . '">';
						$html .= '<input type="hidden" value="' . $item->productId . '" name="productId-' . $keyProductView . '" class="productId-' . $keyProductView . '">';
						$html .= '<input type="hidden" value="' . $item->priceId . '" name="priceId-' . $keyProductView . '" class="1233 priceId-' . $keyProductView . '">';
						$html .= '<input type="hidden" value="' . $item->quantity . '" name="quantityId-' . $keyProductView . '" class="quantityId-' . $keyProductView . '">';

						$html .= '</tr>';
						if (!empty($setProduct)) {
							foreach ($setProduct as $itemSet) {
								$promotionkey = $keyProductView + 1;
								$html .= '<tr class=" promotion promotion-' . $item->productId . ' productId-' . $objectProduct->productPriceID . '-' . $item->priceId . ' itemProduct-' . $keyProductView . '">';
								$html .= '<td class="pro-title">';
								$html .= '<img class="img-fluid" src="' . URL_IMAGE_SHOW . $itemSet->productImage . '" alt="Product"> ';
								$html .= $itemSet->productName;
								$html .= '</td>';

								$html .= '<td class="pro-packing">';
								$html .= '<span> ' . $itemSet->weight . ' ' . $itemSet->unit . ' </span>';
								$priceSet = $item->price * $item->quantity;
								$html .= '<input type="hidden" class="checkSet checkSet-' . $item->productId . '" value="1" />';
								$html .= '<input type="hidden" class="setPrice setPrice-' . $item->productId . '" value="' . $priceSet . '" />';
								$html .= '</td>';
								$html .= '<td class="pro-price">';
								$html .= '<span>' . number_format($itemSet->price) . ' đ/ ' . $itemSet->weight . ' ' . $itemSet->unit . '</span>';
								$html .= '</td>';

								$html .= '<td class="pro-quantity">';
								$html .= '<span>' . $itemSet->quantity . '</span>';
								$html .= '</td>';

								$html .= '<td class="pro-subtotal">';
								$html .= '<span>0 đ</span>';
								$html .= '</td>';

								$html .= '<td>';
								$html .= '</td>';
								$html .= '</tr>';
							}
						}
						$promotionDetails = $item->promotionDetails;
						if (!empty($promotionDetails)) {
							foreach ($promotionDetails as $promotionDetail) {

								$promotionkey = $keyProductView + 1;

								$html .= '<tr class=" promotion promotion-' . $item->productId . ' productId-' . $objectProduct->productPriceID . '-' . $item->priceId . ' itemProduct-' . $keyProductView . '">';
								$html .= '<td class="pro-title">';
								$html .= '<img class="img-fluid" src="' . $promotionDetail->productImage . '" alt="Product"> ';
								$html .= $promotionDetail->productName;
								$html .= '</td>';

								$html .= '<td class="pro-packing">';
								$html .= '<span> ' . $promotionDetail->weight . ' ' . $promotionDetail->unit . ' </span>';
								$html .= '<input type="hidden" class="checkSet checkSet-' . $promotionDetail->productId . '" value="0" />';
								$html .= '<input type="hidden" class="setPrice setPrice-' . $promotionDetail->productId . '" value="0" />';
								$html .= '</td>';
								$html .= '<td class="pro-price">';
								$html .= '<span>' . number_format($promotionDetail->price) . ' đ/ ' . $promotionDetail->weight . ' ' . $promotionDetail->unit . '</span>';
								$html .= '</td>';

								$html .= '<td class="pro-quantity">';
								$html .= '<span>' . $promotionDetail->quantity . '</span>';
								$html .= '</td>';

								$html .= '<td class="pro-subtotal 123">';
								// $html .= '<span>' . number_format($promotionDetail->price * $promotionDetail->quantity) . ' đ</span>';
								$html .= '<span> 0 đ</span>';
								$html .= '</td>';

								$html .= '<td>';
								$html .= '</td>';
								$html .= '</tr>';
							}
						}
					}
					
					$keyProductView++;
				}
				echo json_encode(array('success' => true, 'message' => 'Lấy thành công data search', 'html' => $html, 'totalProduct' => $keyProductView, 'dataRemove' => $dataRemove, 'promotionRemove' => $promotionRemove));
				die;
			} else {
				setcookie("__order", 'false^_^' . $resultCallPromotion->message, time() + (60 * 5), '/');
				echo json_encode(array('success' => false, 'message' => 'Có lỗi trong quá trình sửa đơn'));
				die;
			}
		}
	}
	public function getPromotion()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$productItem = new \stdClass;
			$productItem->productId = $post['productId'];
			$productItem->priceId = $post['priceId'];
			$productItem->quantity = $post['quantityId'];
			$productItem->duplicateProduct = 0;
			$dataCallPromotion[0] = $productItem;
			$oldPriceId = $post['oldPriceId'];
			$dataRequest = [
				'orderCode' => $post['orderId'],
				'products' => $dataCallPromotion
			];
			$resultCallPromotion = $this->orderManageModels->getPromotion($dataRequest);
			$removePromotion = '';
			if ($resultCallPromotion->status == 200) {
				$objects = $resultCallPromotion->data->products;
				$html = '';
				$keyProductView = $post['keyTotal'];
				foreach ($objects as $item) {
					$keyProductView++;
					$promotionDetails = $item->promotionDetails;
					$setProduct = $item->setProducts;
					if (!empty($setProduct)) {
						foreach ($setProduct as $itemSet) {
							$promotionkey = $keyProductView + 1;
							$html .= '<tr class=" promotion promotion-' . $item->productId . ' itemProduct-' . $keyProductView . '">';
							$html .= '<td class="pro-title">';
							$html .= '<img class="img-fluid" src="' . URL_IMAGE_SHOW . $itemSet->productImage . '" alt="Product"> ';
							$html .= $itemSet->productName;
							$html .= '</td>';

							$html .= '<td class="pro-packing">';
							$html .= '<span> ' . $itemSet->weight . ' ' . $itemSet->unit . ' </span>';
							$priceSet = $item->price * $item->quantity;
							$html .= '<input type="hidden" class="checkSet checkSet-' . $item->productId . '" value="1" />';
							$html .= '<input type="hidden" class="setPrice setPrice-' . $item->productId . '" value="' . $priceSet . '" />';
							$html .= '</td>';
							$html .= '<td class="pro-price">';
							$html .= '<span>' . number_format($itemSet->price) . ' đ/ ' . $itemSet->weight . ' ' . $itemSet->unit . '</span>';
							$html .= '</td>';

							$html .= '<td class="pro-quantity">';
							$html .= '<span>' . $itemSet->quantity . '</span>';
							$html .= '</td>';

							$html .= '<td class="pro-subtotal">';
							$html .= '<span>0 đ</span>';
							$html .= '</td>';

							$html .= '<td>';
							$html .= '</td>';
							$html .= '</tr>';
						}
					}
					if (!empty($promotionDetails)) {
						foreach ($promotionDetails as $promotionDetail) {
							$html .= '<tr class=" promotion promotion-' . $post['productId'] . ' productId-' . $promotionDetail->productID . '-' . $oldPriceId . ' itemProduct-' . $keyProductView . '">';
							$html .= '<td class="pro-title">';
							$html .= '<img class="img-fluid" src="' . $promotionDetail->productImage . '" alt="Product"> ';
							$html .= $promotionDetail->productName;
							$html .= '</td>';

							$html .= '<td class="pro-packing">';
							$html .= '<span> ' . $promotionDetail->weight . ' ' . $promotionDetail->unit . ' </span>';
							$html .= '<input type="hidden" class="checkSet checkSet-' . $promotionDetail->productId . '" value="0" />';
							$html .= '<input type="hidden" class="setPrice setPrice-' . $promotionDetail->productId . '" value="0" />';
							$html .= '</td>';
							$html .= '<td class="pro-price">';
							$html .= '<span>' . number_format($promotionDetail->price) . ' đ/ ' . $promotionDetail->weight . ' ' . $promotionDetail->unit . '</span>';
							$html .= '</td>';

							$html .= '<td class="pro-quantity">';
							$html .= '<span>' . $promotionDetail->quantity . '</span>';
							$html .= '</td>';

							$html .= '<td class="pro-subtotal">';
							// $html .= '<span>' . number_format($promotionDetail->price * $promotionDetail->quantity) . ' đ</span>';
							$html .= '<span>0 đ</span>';
							$html .= '</td>';
							$arrEdit = ['1002', '1003'];
							if (in_array($post['orderStatus'], $arrEdit)) {
								$html .= '<td></td>';
							}

							$html .= '</tr>';
						}
					}
					$removePromotion = $post['productId'];
				}
				echo json_encode(array('success' => true, 'message' => 'Lấy thành công data search', 'html' => $html, 'totalProduct' => $keyProductView, 'productId' => $post['productId'], 'removePromotion' => $removePromotion));
				die;
			}
		}
	}
	public function getWeightProduct()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$productId = $post['productId'];
			$key = $post['key'];
			$dataCall = [
				'id' => $productId,
				'sortedVote' => 1
			];
			$html = '';
			$responseProduct = $this->orderManageModels->getProductDetail($dataCall);
			if ($responseProduct->status == 200) {
				$productPackages = $responseProduct->data->productPackages;
				foreach ($productPackages as $package) {
					$html .= '<option key="' . $key . '" keyStock="' . $package->available . '" keyPrice="' . $package->price . '" value="' . $package->id . '">' . $package->weight . ' ' . $package->unit . '</option>';
				}
				$priceFirst = $productPackages[0];
				$priceFirst = $priceFirst->price;
				$stockFirst = $priceFirst->available;

				echo json_encode(array('success' => true, 'message' => 'Lấy thành công data search', 'html' => $html, 'priceFirst' => $priceFirst, 'stockFirst' => $stockFirst));
				die;
			}
			echo '<pre>';
			print_r($responseProduct);
			die;
		}
	}
	public function confirmOrder()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$token = $dataUser->token;
			$username = $dataUser->username;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$orderCode = $post['orderCode'];
			$type = $post['type'];
			$dataCall = [
				'orderCode' => $orderCode,
				'type' 		=> $type
			];
			$href = base_url('/don-hang/danh-sach-don-hang');
			$responseProduct = $this->orderManageModels->confirmOrder($dataCall, $headers, $username);
			if ($responseProduct->status == 200) {
				setcookie("__order", 'success^_^Cập nhật đơn hàng thành công', time() + (60 * 5), '/');
				echo json_encode(array('success' => true, 'href' => $href));
				die;
			} else {
				setcookie("__order", 'false^_^' . $responseProduct->message, time() + (60 * 5), '/');
				echo json_encode(array('success' => false, 'href' => $href));
				die;
			}
		}
	}
	public function updateOrder()
	{

		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$userId = $dataUser->userId;
			$token = $dataUser->token;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];

			$dataPost = $post['newProducts'];
			$orderCode = $dataPost['orderCode'];
			$arrPlus = $dataPost['arrPlus'];
			$i = 0;
			foreach ($arrPlus as $value) {
				$productItem = new \stdClass;
				$productItem->priceId = $value['priceId'];
				$productItem->productId = $value['productID'];
				$productItem->productName = $value['productName'];
				$productItem->quantity = $value['quantity'];
				$dataCallPromotion[$i] = $productItem;
				$i++;
			}

			$dataCallUpdate = [
				'orderCode' => $orderCode,
				'details' => $dataCallPromotion
			];
			$href = base_url('/don-hang/danh-sach-don-hang');
			$resultUpdateOrder = $this->orderManageModels->updateOrder($dataCallUpdate, $headers, $username);
			if ($resultUpdateOrder->status == 200) {
				setcookie("__order", 'success^_^Cập nhật đơn hàng thành công', time() + (60 * 5), '/');
				echo json_encode(array('success' => true, 'href' => $href));
				die;
			} else {
				setcookie("__order", 'false^_^' . $resultUpdateOrder->message, time() + (60 * 5), '/');
				echo json_encode(array('success' => false, 'href' => $href));
				die;
			}
		}
	}

	public function ajaxGetDistrictByProvince()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {

			$provinceCode = $post['province'];
			if ($provinceCode != '' || $provinceCode != 0) {
				$dataDistrict = $this->orderManageModels->getListDistrict($provinceCode);
				if ($dataDistrict->status == 200) {
					$listDistrict = $dataDistrict->data;
					$district_list_html = '<option value="0">Chọn Quận</option>';
					foreach ($listDistrict as $key => $row) {
						$district_list_html .= '<option value="' . $row->code . '"> ' . $row->name . ' </option>';
					}
					echo json_encode(array('success' => true, 'message' => 'Thành công', 'data' => $district_list_html));
					die;
				} else {
					echo json_encode(array('success' => false, 'message' => 'Lấy thông tin quận thất bại', 'data' => ''));
					die;
				}
			} else {
				echo json_encode(array('success' => false, 'message' => 'Lấy thông tin quận thất bại', 'data' => ''));
				die;
			}
		}
	}
	public function ajaxGetWardsByDistrict()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$districtCode = $post['district'];
			if ($districtCode != '' || $districtCode != 0) {
				$dataWards = $this->orderManageModels->getListDistrict($districtCode);
				if ($dataWards->status == 200) {
					$listWards = $dataWards->data;
					$ward_list_html = '<option value="0">Chọn Phường/ Xã</option>';
					foreach ($listWards as $key => $row) {
						$ward_list_html .= '<option value="' . $row->code . '"> ' . $row->name . ' </option>';
					}
					echo json_encode(array('success' => true, 'message' => 'Thành công', 'data' => $ward_list_html));
					die;
				} else {
					echo json_encode(array('success' => false, 'message' => 'Lấy thông tin phường/xã thất bại', 'data' => ''));
					die;
				}
			} else {
				echo json_encode(array('success' => false, 'message' => 'Lấy thông tin phường/xã thất bại', 'data' => ''));
				die;
			}
		}
	}

	public function changeInfoReceiver()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$token = $dataUser->token;

			$dataChangeInfo = [
				"orderCode" => $post['orderId'],
				"name" => $post['receiverNameChange'],
				"phone" => $post['receiverPhoneChange'],
				"address" => $post['receiverAddressChange'],
				"provinceCode" => $post['province'],
				"districtCode" => $post['district'],
				"wardCode" => $post['ward'],
			];
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];

			$resultChangeInfoReceiver = $this->orderManageModels->changeInfoReceiver($dataChangeInfo, $headers, $username);
			if ($resultChangeInfoReceiver->status == 200) {
				setcookie("__order", 'success^_^Cập nhật đơn hàng thành công', time() + (60 * 5), '/');
				echo json_encode(array('success' => true));
				die;
			} else {
				setcookie("__order", 'false^_^' . $resultChangeInfoReceiver->message, time() + (60 * 5), '/');
				echo json_encode(array('success' => false));
				die;
			}
			// $dataChangeMethod = [
			// 	"orderCode" => "",
			// 	"paymentMethod" => "",
			// 	"orderMethod" => "",
			// 	"deliveryMethod" => "",
			// 	"shippingMethod" => "",
			// ];
		} else {
			setcookie("__order", 'false^_^Có lỗi xảy ra khi cập nhật.', time() + (60 * 5), '/');
			echo json_encode(array('success' => false));
			die;
		}
	}

	public function changeMethodInfo()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$token = $dataUser->token;

			$dataChangeMethod = [
				"orderCode" => $post['orderId'],
				"paymentMethod" => $post['paymentMethod'],
				"orderMethod" => $post['orderMethod'],
				"deliveryMethod" => $post['deliveryMethod'],
				"shippingMethod" => $post['shippingMethod'],
			];
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];

			$resultChangeMethodsInfo = $this->orderManageModels->changeMethodInfo($dataChangeMethod, $headers, $username);
			if ($resultChangeMethodsInfo->status == 200) {
				setcookie("__order", 'success^_^Cập nhật đơn hàng thành công', time() + (60 * 5), '/');
				echo json_encode(array('success' => true));
				die;
			} else {
				setcookie("__order", 'false^_^' . $resultChangeMethodsInfo->message, time() + (60 * 5), '/');
				echo json_encode(array('success' => false));
				die;
			}
		} else {
			setcookie("__order", 'false^_^Có lỗi xảy ra khi cập nhật.', time() + (60 * 5), '/');
			echo json_encode(array('success' => false));
			die;
		}
	}
	public function getNewPrice()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$username = $dataUser->username;
			$userId = $dataUser->userId;
			$token = $dataUser->token;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];

			$dataPost = $post['newProducts'];
			$orderCode = $dataPost['orderCode'];
			$arrPlus = $dataPost['arrPlus'];
			$i = 0;
			foreach ($arrPlus as $value) {
				$productItem = new \stdClass;
				$productItem->productId = $value['productID'];
				$productItem->priceId = $value['priceId'];
				$productItem->quantity = $value['quantity'];
				$productItem->duplicateProduct = 0;
				$dataCallPromotion[$i] = $productItem;
				$i++;
			}
			$dataRequest = [
				'orderCode' => $orderCode,
				'products' => $dataCallPromotion
			];
			echo '<pre>';
			print_r($dataRequest);
			print_r($post);die;
			$resultUpdateOrder = $this->orderManageModels->getPromotion($dataRequest, $headers, $username);
			if ($resultUpdateOrder->status == 200) {
				echo json_encode(array('success' => true, 'value' => number_format($resultUpdateOrder->data->originValue), 'promotionFee' => number_format($resultUpdateOrder->data->promotionValue), 'deliveryFee' => number_format($resultUpdateOrder->data->deliveryFee), 'total' => number_format($resultUpdateOrder->data->total)));
				die;
			} else {
				setcookie("__order", 'false^_^' . $resultUpdateOrder->message, time() + (60 * 5), '/');
				echo json_encode(array('success' => false));
				die;
			}
		}
	}
	public function exportExcelOrder()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$token = $dataUser->token;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$dataCall = [
				'keyword' => $post['keySearch'],
				'status' => $post['status'],
				"from" => $post['started'],
				"to" => $post['stoped'],
				"isReality" => $post['isReality'],
			];
			$resultExportExcel = $this->orderManageModels->exportExcelOrder($dataCall, $headers);
			if ($resultExportExcel['status'] == 200) {
				if ($post['isReality'] == 1) {
					$fileName = 'DU_LIEU_DON_HANG_THUC_TE_' . date('d/m/Y');
				} else {
					$fileName = 'DU_LIEU_DON_HANG_TAM_TINH_' . date('d/m/Y');
				}
				$response =  array(
					'href' => base_url('/don-hang/danh-sach-don-hang'),
					'name' => $fileName,
					'status' => '200',
					'file' => "data:application/vnd.ms-excel;base64," . base64_encode($resultExportExcel['data'])
				);
				$this->logger->info('Kết thúc xuất EXCEL');
				die(json_encode($response));
			} else {
			}
		}
	}

	public function exportExcelOrderGet()
	{
	}
	public function deleteItemInOrder()
	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			$dataUser = $this->dataUserAuthen;
			$token = $dataUser->token;
			$prepareId = $post['idPrepare'];
			$orderCode = $post['orderCode'];
			$dataCall = [
				'id' => $prepareId,
				'orderCode' => $orderCode
			];
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
			$resultDeleteItemInOrder = $this->orderManageModels->deleteItemInOrder($dataCall, $headers);
			if ($resultDeleteItemInOrder->status == 200) {
				echo json_encode(array('success' => true));
				die;
			} else {

				echo json_encode(array('success' => false));
				die;
			}
		}
	}
}
