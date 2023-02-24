<?php

namespace App\Modules\Products\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use stdClass;

class Products extends BaseController
{
    public function listProduct($page = 1){
        
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $userId = $dataUser->userId;
        $title = 'Danh sách sản phẩm';
        $arrSearch = [];
        //Pagination
        $page 					= ($this->page)? $this->page : 1;
        
        $data['page'] 			= $page;
        $data['perPage'] 		= PERPAGE;
        $data['pager'] 			= $this->pager;
        $data['total'] 			= 0;
        $data['uri'] = $this->uri;
        $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
        $conditions['LIMIT']  = $data['perPage'];
        
        
        $listArea = $this->productModels->getListArea();
        $listCooking = $this->productModels->getListCooking();
        $listProductType = $this->productModels->getListProductType();
        $arrSeasonal = json_decode(GROUP_SEASONAL);
        $arrCate = [];
        $get = $this->request->getGet();
        if(!empty($get)){
            $arrSearch = [
                'name' =>$get['name'],
                'goodsType' =>$get['goodsType'],
                'areaApply' =>$get['areaApply'],
                'promotionFlag' =>$get['promotionFlag'],
                'bestSellFlag' =>$get['bestSellFlag'],
                'status' =>$get['status'],
                'cateId' =>$get['cateId']
            ];            
			$arrCate = explode(',', $get['cateId']);
        }
        $listCate = $this->productModels->getAllCate( $pid = PID_DANH_MUC_SAN_PHAM, $level = 0, $arrCate);
        $listProducts = $this->productModels->getListProducts($arrSearch, $username, $conditions);
        $getTotalProducts = $this->productModels->getTotalProducts($arrSearch, $username);
        $arrPriceType = json_decode(PRICE_TYPE);

        $data['arrPriceType'] = (array) $arrPriceType;
        $data['get'] = $get;
        $data['total'] = $getTotalProducts;
        $data['productModels'] = $this->productModels;
        $data['listProducts'] = $listProducts;
        
        $data['title'] = $title;
        $data['arrSeasonal'] = $arrSeasonal;
        $data['listProductType'] = $listProductType;
        $data['listCooking'] = $listCooking;
        $data['listArea'] = $listArea;
        $data['listCate'] = $listCate;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\Products\Views\listProduct';
		return view('layoutKho/layout', $data);
    }
    public function editProduct($id){
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $userId = $dataUser->userId;
        $title = 'Sửa sản phẩm';
        $data['productModels'] = $this->productModels;
        $productDetail = $this->productModels->getProductDetail($id);
    
        $arrPriceType = json_decode(PRICE_TYPE);
        if(empty($productDetail)){
            setcookie ("__product",'false^_^Không tìm thấy sản phẩm',time()+ (60*5) , '/');
            return redirect()->to('/san-pham/danh-sach-san-pham');
        }
        //Get price Table
        $getPriceProduct = $this->productModels->getPriceProduct($id, $username);
        $productDetail->priceProduct= $getPriceProduct;
        //Get image Table
        $getImagesProduct = $this->productModels->getImagesProduct($id, $username);
        $imagesThumbnail = [];
        $imagesProducts = [];
        if(!empty($getImagesProduct)){
            foreach($getImagesProduct as $imagesProduct){
                if($imagesProduct->IS_THUMBNAIL == 1){
                    array_push($imagesThumbnail,$imagesProduct->IMAGE);
                }else{
                    array_push($imagesProducts,$imagesProduct->IMAGE);
                }
            }
        }
        $productDetail->imagesThumbnail= $imagesThumbnail;
        $productDetail->imagesProducts= $imagesProducts;
        //Get cate Table
        $getCateProduct = $this->productModels->getCategoryProduct($id, $username);
        $listCateProduct = [];
        if(!empty($getCateProduct)){
            foreach($getCateProduct as $cateProduct){
                array_push($listCateProduct,$cateProduct['PRODUCT_CATE_ID']);
            }
        }
        $productDetail->listCateProduct = $listCateProduct;
        $getNewsProduct = $this->productModels->getNewsProduct($id, $username);

        $listNewsProduct = [];
        if(!empty($getNewsProduct)){
            foreach($getNewsProduct as $newsProduct){
                array_push($listNewsProduct,$newsProduct['NEWS_ID']);
            }
        }
        $productDetail->listNewsProduct = $listNewsProduct;
        $productDetail->AREA = explode(",",$productDetail->AREA);
        $listCate = $this->productModels->getAllCate(PID_DANH_MUC_SAN_PHAM, 0, $productDetail->listCateProduct);
        $listArea = $this->productModels->getListArea();
        $listCooking = $this->productModels->getListCooking();
        $listProductType = $this->productModels->getListProductType();
        $arrSeasonal = json_decode(GROUP_SEASONAL);
        $listArea = $this->productModels->getListArea();
        $post = $this->request->getPost();
        if(!empty($post)){
            $goodsType = $post['goodsType'];
            $category = $post['category'];
            $productName = $post['productName'];
            $imgThumbnailProduct = $post['imgThumbnailProduct'];
            $sapoProduct = $post['sapoProduct'];
            $contentProduct = $post['contentProduct'];
            $newContent = str_replace( array( 'src="/ckfinder/userfiles/files'), 'src="'.URL_IMAGE_CMS.'/ckfinder/userfiles/files', $contentProduct);
            $contentProduct = $newContent;
            // var_dump(htmlspecialchars($test));
            // die;
            $nutrition = $post['nutrition'];
            $effectual = $post['effectual'];
            $processing = $post['processing'];
            $preserve = $post['preserve'];
            $seasonal = $post['seasonal'];
            $promotionFlag = $post['promotionFlag'];
            $bestSellFlag = $post['bestSellFlag'];
            $inputImg = $post['inputImg'];
            $package = $post['pack'];
            $areaApply = $post['areaApply'];
            $status = $post['status'];
            $cook = [];
            if(isset($post['cook'])){
                $cook = $post['cook'];
            }
            // $weight = $post['weight'];
            // $price = $post['price'];
            // $areaApply = $post['areaApply'];
            $this->validation->setRules([
                'category'=> [
                    'label' => 'Label.txtCategory',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'goodsType'=> [
                    'label' => 'Label.txtGoodsType',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
                'productName'=> [
                    'label' => 'Label.txtProductName',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'sapoProduct'=> [
                    'label' => 'Label.txtSapoProduct',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'contentProduct'=> [
                    'label' => 'Label.txtContentProduct',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'imgThumbnailProduct'=> [
                    'label' => 'Label.imgThumbnailProduct',
                    'rules' => 'required',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ]
            ]);
            $productImg = 1;
            if(!isset($post['inputImg'])){
                $productImg = 0;
            }
            // $checkWeight = 1;
            // if(isset($package) && $package[0]['weight'] == ''){
            //     $checkWeight = 0;
            // }
            // $checkPrice = 1;
            // if(isset($package) && $package[0]['price'] == ''){
            //     $checkPrice = 0;
            // }
            // $checkQuantity = 1;
            // if(isset($package) && $package[0]['quantity'] == ''){
            //     $checkQuantity = 0;
            // }

            $checkPack = 0;
            if(isset($package)){
                foreach($package as $keyPack => $valuePack){
                    if($valuePack['weight'] == ''){
                        $errorPack[$keyPack]['checkWeight'] = 'Quy cách đóng gói không được để trống';
                    $checkPack = 1;
                    }
                    if($valuePack['price'] == ''){
                        $errorPack[$keyPack]['checkPrice'] = 'Giá theo quy cách không được để trống';
                    $checkPack = 1;
                    }
                    if($valuePack['quantity'] == ''){
                        $errorPack[$keyPack]['checkQuantity'] = 'Số lượng không được để trống';
                    $checkPack = 1;
                    }
                    if($valuePack['priceType'] == 0){
                        $errorPack[$keyPack]['checkPriceType'] = 'Loại đóng gói không được để trống';
                        $checkPack = 1;
                    }
                }
            }

            $checkArea = 1;
            if(!isset($areaApply) ){
                $checkArea = 0;
            }
            if(!$this->validation->withRequest($this->request)->run() || $productImg == 0 || $checkPack == 1 )
            {
                $getErrors = $this->validation->getErrors();
                if($productImg == 0){
                    $getErrors['inputImg'] = 'Ảnh sản phẩm không được để trống';
                }
                // if($checkWeight == 0){
                //     $getErrors['checkWeight'] = 'Quy cách đóng gói không được để trống';
                // }
                // if($checkPrice == 0){
                //     $getErrors['checkPrice'] = 'Giá theo quy cách không được để trống';
                // }
                // if($checkQuantity == 0){
                //     $getErrors['checkQuantity'] = 'Số lượng không được để trống';
                // }
                if($checkPack == 1){
                    $getErrors['checkPack'] = $errorPack;
                }

                if($checkArea == 0){
                    $getErrors['checkArea'] = 'Khu vực áp dụng không được để trống';
                }
                $newProductDetail = new stdClass;
                $newProductDetail->PRODUCT_TYPE = $post['goodsType'];
                $newProductDetail->SAPO = $post['sapoProduct'];
                $newProductDetail->CONTENT = $post['contentProduct'];
                $newProductDetail->NUTRITION = $post['nutrition'];
                $newProductDetail->EFFECTUAL = $post['effectual'];
                $newProductDetail->PROCESSING = $post['processing'];
                $newProductDetail->PRESERVE = $post['preserve'];
                $newProductDetail->NAME = $post['productName'];
                $newProductDetail->PROMOTION_FLAG = $post['promotionFlag'];
                $newProductDetail->BEST_SELL_FLAG = $post['bestSellFlag'];
                $newProductDetail->STATUS = $post['status'];
                $newProductDetail->POSITION_PRODUCT = $post['positionProduct'];
                $priceProduct = $post['pack'];
                $arrPriceProduct = [];
                // if($priceProduct[0]['weight'] != '' && $priceProduct[0]['price'] != ''){
                //     foreach($priceProduct as $keyPrice => $price){
                //         $arrPriceProductObject = new \stdClass;
                //         $arrPriceProductObject->WEIGHT = str_replace( array( ',', '.', '  ', '   '), '', $price['weight']);
                //         $arrPriceProductObject->PRICE = str_replace( array( ',', '.', '  ', '   '), '', $price['price']);
                //         $arrPriceProductObject->STOCK = str_replace( array( ',', '.', '  ', '   '), '', $price['quantity']);
                //         array_push($arrPriceProduct, $arrPriceProductObject);
                //     }
                // }
                if(isset($priceProduct)){
                    foreach($priceProduct as $keyPrice => $price){
                        $arrPriceProductObject = new \stdClass;
                        $arrPriceProductObject->WEIGHT = str_replace( array( ',', '.', '  ', '   '), '', $price['weight']);
                        $arrPriceProductObject->PRICE = str_replace( array( ',', '.', '  ', '   '), '', $price['price']);
                        $arrPriceProductObject->STOCK = str_replace( array( ',', '.', '  ', '   '), '', $price['quantity']);
                        $arrPriceProductObject->TYPE = str_replace( array( ',', '.', '  ', '   '), '', $price['priceType']);
                        $arrPriceProductObject->UNIT = str_replace( array( ',', '.', '  ', '   '), '', $price['priceType']);
                        array_push($arrPriceProduct, $arrPriceProductObject);
                    }
                }
                // echo '<pre>';
                // print_r($arrPriceProduct);die;
                $arrImageThumbnail[] =  $post['imgThumbnailProduct'];
                $newProductDetail->priceProduct = $arrPriceProduct;

                $newProductDetail->imagesThumbnail = $arrImageThumbnail;
                $newProductDetail->imagesProducts = $post['inputImg'];
                $newProductDetail->listCateProduct = $post['category'];
                $newProductDetail->listNewsProduct = $cook;
                $newProductDetail->AREA = $post['areaApply'];
                $seasonal= '';
                if(isset($post['seasonal'])){
                    $seasonal = implode(',',$post['seasonal']);
                }
                $newProductDetail->SEASONAL = $seasonal;
                $data['arrPriceType'] = (array) $arrPriceType;
                $data['title'] = $title;
                $data['getErrors'] = $getErrors;
                $data['productDetail'] = $newProductDetail;
                $data['arrSeasonal'] = $arrSeasonal;
                $data['listProductType'] = $listProductType;
                $data['listCooking'] = $listCooking;
                $data['listArea'] = $listArea;
                $data['listCate'] = $listCate;
                $data['dataUser'] = $dataUser;
                $data['view'] = 'App\Modules\Products\Views\editProduct';
                return view('layoutKho/layout', $data);
            }else{
                $slug = $this->convertString->to_slug($productName);
                $newSeasonal= '';
                if(isset($post['seasonal'])){
                    $newSeasonal = implode(',',$post['seasonal']);
                }
                $dataProduct = [
                    'PRODUCT_TYPE' => $goodsType,
                    'NAME' => $productName,
                    'SAPO' => $sapoProduct,
                    'CONTENT' => $contentProduct,
                    'NUTRITION' => $nutrition,
                    'EFFECTUAL' => $effectual,
                    'PROCESSING' => $processing,
                    'PRESERVE' => $preserve,
                    'SEASONAL' => $newSeasonal,
                    'PROMOTION_FLAG' => $promotionFlag,
                    'BEST_SELL_FLAG' => $bestSellFlag,
                    'SLUG' => $slug,
                    'AREA' => implode(',',$areaApply),
                    'EDITED_BY' => $userId,
                    'STATUS' => $status,
                    'POSITION_PRODUCT' => $post['positionProduct'],
                ];
                
                // $dataPrice['AREA'] = implode(',',$pack['areaApply']);
                $resultCreateProduct = $this->productModels->updateProduct($dataProduct, $id, $username);
                if($resultCreateProduct){
                    //CREATE THUMBNAIL
                    $dataImgThumbnail = [
                        'PRODUCT_ID' => $id,
                        'IMAGE' => $imgThumbnailProduct,
                        'STATUS' => 1,
                        'IS_THUMBNAIL' => 1,
                        'CREATED_BY' => $userId
                    ];
                    $resultRemoveProductThumb = $this->productModels->removeProductImg($id);
                    $resultUpdateProductThumb = $this->productModels->createProductImg($dataImgThumbnail, $username);
                    //CREATE IMG PRODUCT
                    foreach($inputImg as $img){
                        $dataImg = [
                            'PRODUCT_ID' => $id,
                            'IMAGE' => $img,
                            'STATUS' => 1,
                            'IS_THUMBNAIL' => 0,
                            'CREATED_BY' => $userId
                        ];
                        $resultCreateProductImg = $this->productModels->createProductImg($dataImg, $username);
                    }
                    
                //     //CREATE PRICE PRODUCT
                //     // package
                    $removeProductPrice = $this->productModels->removeProductPrice($id, $username);
                    foreach ($package as $keyPackage => $pack){
                        $dataPrice = [];
                        $dataPrice['PRODUCT_ID'] = $id;
                        $dataPrice['WEIGHT'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['weight']);
                        $dataPrice['PRICE'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['price']);
                        $dataPrice['STOCK'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['quantity']);
                        $dataPrice['TYPE'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['priceType']);
                        $dataPrice['UNIT'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['priceType']);
                        $dataPrice['CREATED_BY'] = $userId;
                        $dataPrice['STATUS'] = 1;
                        if(!isset($pack['idPrice'])){
                            $resultCreateProductPrice = $this->productModels->createProductPrice($dataPrice, $username);
                        }else{
                            $idPrice = $pack['idPrice'];
                            $resultCreateProductPrice = $this->productModels->updateProductPrice($dataPrice,$idPrice, $username);
                        }
                    }

                //     //CREATE PRODUCT CATE MAP
                    $removeProductCate = $this->productModels->removeProductCateMap($id);
                    
                    $countCate = count($category);
                    $dataCate = [];
                    for($i = 0; $i < $countCate; $i++){
                        $dataCate[$i]['PRODUCT_CATE_ID'] = $category[$i];
                        $dataCate[$i]['PRODUCT_ID'] = $id;
                        $dataCate[$i]['CREATED_BY'] = $userId;
                        $dataCate[$i]['STATUS'] = 1;
                        $resultCreateProductCate = $this->productModels->createProductCate($dataCate[$i], $username);
                    }

                //     //CREATE PRODUCT NEWS MAP
                $removeProductNews = $this->productModels->removeProductNewsMap($id);
                    $countCookNews = count($cook);
                    $dataCookNews = [];
                    for($i = 0; $i < $countCookNews; $i++){
                        $dataCookNews[$i]['NEWS_ID'] = $cook[$i];
                        $dataCookNews[$i]['PRODUCT_ID'] = $id;
                        $dataCookNews[$i]['CREATED_BY'] = $userId;
                        $dataCookNews[$i]['STATUS'] = 1;
                        $resultCreateProductCookNews = $this->productModels->createProductCookNews($dataCookNews[$i], $username);
                    }
                    $this->productModels->getSetId($username);
                    setcookie ("__product",'success^_^Sửa thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__product",'false^_^Sửa không thành công',time()+ (60*5) , '/');
                }
                return redirect()->to('/san-pham/danh-sach-san-pham');
            }
        }
        $data['title'] = $title;
        $data['productDetail'] = $productDetail;
        $data['arrSeasonal'] = $arrSeasonal;
        $data['listProductType'] = $listProductType;
        $data['arrPriceType'] = (array) $arrPriceType;
        $data['listCooking'] = $listCooking;
        $data['listArea'] = $listArea;
        $data['listCate'] = $listCate;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\Products\Views\editProduct';
		return view('layoutKho/layout', $data);
    }
    public function addProduct(){
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $userId = $dataUser->userId;
        $arrPriceType = json_decode(PRICE_TYPE);
        
        $listCate = $this->productModels->getAllCate();
        $listArea = $this->productModels->getListArea();
        $listCooking = $this->productModels->getListCooking();
        $listProductType = $this->productModels->getListProductType();
        $arrSeasonal = json_decode(GROUP_SEASONAL);
        
        $title = 'Tạo sản phẩm';
        $post = $this->request->getPost();
        if(!empty($post)){
            $goodsType = $post['goodsType'];
            $category = $post['category'];
            $productName = $post['productName'];
            $imgThumbnailProduct = $post['imgThumbnailProduct'];
            $sapoProduct = $post['sapoProduct'];
            $contentProduct = $post['contentProduct'];
            $nutrition = $post['nutrition'];
            $effectual = $post['effectual'];
            $processing = $post['processing'];
            $preserve = $post['$preserve'];
            $seasonal = $post['seasonal'];
            $promotionFlag = $post['promotionFlag'];
            $bestSellFlag = $post['bestSellFlag'];
            $inputImg = $post['inputImg'];
            $package = $post['pack'];
            $areaApply = $post['areaApply'];
            $status = $post['status'];
            $cook = [];
            if(isset($post['cook'])){
                $cook = $post['cook'];
            }
            $seasonal = [];
            if(isset($post['seasonal'])){
                $seasonal = $post['seasonal'];
            }
            
            $this->validation->setRules([
                'category'=> [
                    'label' => 'Label.txtCategory',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'goodsType'=> [
                    'label' => 'Label.txtGoodsType',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
                'productName'=> [
                    'label' => 'Label.txtProductName',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'sapoProduct'=> [
                    'label' => 'Label.txtSapoProduct',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'contentProduct'=> [
                    'label' => 'Label.txtContentProduct',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'imgThumbnailProduct'=> [
                    'label' => 'Label.imgThumbnailProduct',
                    'rules' => 'required',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ]
            ]);
            $productImg = 1;
            if(!isset($post['inputImg'])){
                $productImg = 0;
            }
            $checkPack = 0;
            if(isset($package)){
                foreach($package as $keyPack => $valuePack){
                    if($valuePack['weight'] == ''){
                        $errorPack[$keyPack]['checkWeight'] = 'Quy cách đóng gói không được để trống';
                        $checkPack = 1;
                    }
                    if($valuePack['price'] == ''){
                        $errorPack[$keyPack]['checkPrice'] = 'Giá theo quy cách không được để trống';
                        $checkPack = 1;
                    }
                    if($valuePack['quantity'] == ''){
                        $errorPack[$keyPack]['checkQuantity'] = 'Số lượng không được để trống';
                        $checkPack = 1;
                    }
                    if($valuePack['priceType'] == 0){
                        $errorPack[$keyPack]['checkPriceType'] = 'Loại đóng gói không được để trống';
                        $checkPack = 1;
                    }
                }
            }

            $checkArea = 1;
            if(!isset($areaApply) ){
                $checkArea = 0;
            }
            if(!$this->validation->withRequest($this->request)->run() || $productImg == 0 || $checkPack == 1 )
            {
                $getErrors = $this->validation->getErrors();
                if($productImg == 0){
                    $getErrors['inputImg'] = 'Ảnh sản phẩm không được để trống';
                }
                if($checkPack == 1){
                    $getErrors['checkPack'] = $errorPack;
                }
                
                if($checkArea == 0){
                    $getErrors['checkArea'] = 'Khu vực áp dụng không được để trống';
                }
                $listCate = $this->productModels->getAllCate(PID_DANH_MUC_SAN_PHAM, 0, $category);
                $data['getErrors'] = $getErrors;
                $data['title'] = $title;
                $data['post'] = $post;
                $data['arrSeasonal'] = $arrSeasonal;
                $data['listProductType'] = $listProductType;
                $data['listCooking'] = $listCooking;
                $data['listArea'] = $listArea;
                $data['listCate'] = $listCate;
                $data['arrPriceType'] = (array) $arrPriceType;
                $data['dataUser'] = $dataUser;
                $data['view'] = 'App\Modules\Products\Views\addProduct';
                return view('layoutKho/layout', $data);
            }else{
                if(isset($post['cook'])){
                    $cook = $post['cook'];
                }
                $slug = $this->convertString->to_slug($productName);

                $seasonal= '';
                if(isset($post['seasonal'])){
                    $newSeasonal = implode(',',$post['seasonal']);
                }
                // $newSeasonal = implode(',',$seasonal);
                $productCode = $this->productModels->getMaxProductCode();
                $newContent = str_replace( array( 'src="/ckfinder/userfiles/files'), 'src="'.URL_IMAGE_CMS.'/ckfinder/userfiles/files', $contentProduct);
                $dataProduct = [
                    'PRODUCT_CODE' => $productCode + 1,
                    'PRODUCT_TYPE' => $goodsType,
                    'NAME' => $productName,
                    'SAPO' => $sapoProduct,
                    'CONTENT' => $newContent,
                    'NUTRITION' => $nutrition,
                    'EFFECTUAL' => $effectual,
                    'PROCESSING' => $processing,
                    'PRESERVE' => $preserve,
                    'SEASONAL' => $newSeasonal,
                    'PROMOTION_FLAG' => $promotionFlag,
                    'BEST_SELL_FLAG' => $bestSellFlag,
                    'SLUG' => $slug,
                    'AREA' => implode(',',$areaApply),
                    'CREATED_BY' => $userId,
                    'STATUS' => $status,
                    'POSITION_PRODUCT' => $post['positionProduct']
                ];
                
                // $dataPrice['AREA'] = implode(',',$pack['areaApply']);
                $resultCreateProduct = $this->productModels->createProduct($dataProduct, $username);
                
                if(!empty($resultCreateProduct)){
                    $productId = $resultCreateProduct['CURRVAL'];
                    //CREATE THUMBNAIL
                    $dataImgThumbnail = [
                        'PRODUCT_ID' => $productId,
                        'IMAGE' => $imgThumbnailProduct,
                        'STATUS' => 1,
                        'IS_THUMBNAIL' => 1,
                        'CREATED_BY' => $userId
                    ];
                    $resultCreateProductImg = $this->productModels->createProductImg($dataImgThumbnail, $username);
                    //CREATE IMG PRODUCT
                    foreach($inputImg as $img){
                        $dataImg = [
                            'PRODUCT_ID' => $productId,
                            'IMAGE' => $img,
                            'STATUS' => 1,
                            'IS_THUMBNAIL' => 0,
                            'CREATED_BY' => $userId
                        ];
                        $resultCreateProductImg = $this->productModels->createProductImg($dataImg, $username);
                    }
                    //CREATE PRICE PRODUCT
                    foreach ($package as $keyPackage => $pack){
                        $dataPrice = [];
                        $dataPrice['WEIGHT'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['weight']);
                        $dataPrice['PRICE'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['price']);
                        $dataPrice['STOCK'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['quantity']);
                        $dataPrice['TYPE'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['priceType']);
                        $dataPrice['UNIT'] = str_replace( array( ',', '.', '  ', '   '), '', $pack['priceType']);
                        $dataPrice['CREATED_BY'] = $userId;
                        $dataPrice['PRODUCT_ID'] = $productId;
                        $dataPrice['STATUS'] = 1;
                        $resultCreateProductPrice = $this->productModels->createProductPrice($dataPrice, $username);
                    }

                    //CREATE PRODUCT CATE MAP
                    $countCate = count($category);
                    $dataCate = [];
                    for($i = 0; $i < $countCate; $i++){
                        $dataCate[$i]['PRODUCT_CATE_ID'] = $category[$i];
                        $dataCate[$i]['PRODUCT_ID'] = $productId;
                        $dataCate[$i]['CREATED_BY'] = $userId;
                        $dataCate[$i]['STATUS'] = 1;
                        $resultCreateProductCate = $this->productModels->createProductCate($dataCate[$i], $username);
                    }

                    //CREATE PRODUCT NEWS MAP
                    $countCookNews = count($cook);
                    $dataCookNews = [];
                    for($i = 0; $i < $countCookNews; $i++){
                        $dataCookNews[$i]['NEWS_ID'] = $cook[$i];
                        $dataCookNews[$i]['PRODUCT_ID'] = $productId;
                        $dataCookNews[$i]['CREATED_BY'] = $userId;
                        $dataCookNews[$i]['STATUS'] = 1;
                        $resultCreateProductCookNews = $this->productModels->createProductCookNews($dataCookNews[$i], $username);
                    }
                    setcookie ("__product",'success^_^Tạo thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__user",'false^_^Tạo không thành công',time()+ (60*5) , '/');
                }
                return redirect()->to('/san-pham/danh-sach-san-pham');
            }

        }

        $data['title'] = $title;
        $data['arrSeasonal'] = $arrSeasonal;
        $data['arrPriceType'] = (array) $arrPriceType;
        $data['listProductType'] = $listProductType;
        $data['listCooking'] = $listCooking;
        $data['listArea'] = $listArea;
        $data['listCate'] = $listCate;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\Products\Views\addProduct';
		return view('layoutKho/layout', $data);
    }
    public function removeProduct(){
        $post = $this->request->getPost();
        if(!empty($post)){
            $dataUser = $this->dataUserAuthen;
            $username = $dataUser->username;
            $userId = $dataUser->userId;
            $idProduct = $post['idProduct'];
            $status = 0;
            if($post['active'] == 1){
                $status = 1;
            }
            $removeProduct = $this->productModels->removeProduct($username, $idProduct,$status);
            if($removeProduct){
                setcookie ("__product",'success^_^Thay đổi trạng thái thành công',time()+ (60*5) , '/');
                echo json_encode(array('success' => true, 'status' => $status,));die;
            }else{
                setcookie ("__product",'false^_^Thay đổi trạng thái không thành công',time()+ (60*5) , '/');
                echo json_encode(array('success' => false, 'status' => $status,));die;
            }
        }else{
            echo json_encode(array('success' => false, 'status' => '0',));die;
        }
    }
    public function appendPackProduct(){
        $listArea = $this->productModels->getListArea();
        $post = $this->request->getPost();
        $checkId = $post['checkID'] + 1;
        $currentId = $post['checkID'];
        $keyId = $post['keyId'] +1;
        $html = '';
        $arrPriceType = (array) json_decode(PRICE_TYPE);
        $html .= '<div class="row countAppendPack packProduct pack_'.$keyId.' pdt">';
            $html .= '<div class="col-2">';
                $html .= '<label for="priceType">Loại đóng gói <span
                style="color: red">(*)</span></label>';
                $html .= '<select class="form-control chosen-select priceType" name="pack['.($keyId ).'][priceType]">';
                    $html .= '<option value="0">Chọn loại đóng gói</option>';
                    if(!empty($arrPriceType)):
                        foreach($arrPriceType as $key => $priceType):
                            $html .= '<option value="'.$key.'">'.$priceType.'</option>';
                        endforeach;
                    endif;
                $html .= '</select>';
            $html .= '</div>';
            $html .= '<div class="col-3">';
                $html .= '<label for="exampleInputUsername1">Quy cách đóng gói <span
                style="color: red">(*)</span></label>';
                $html .= '<input type="text" name="pack['.($keyId ).'][weight]" class="form-control" onkeypress="return isNumber(event)" autocomplete="off" placeholder="Quy cách đóng gói: 100" value="">';
            $html .= '</div>';

            $html .= '<div class="col-3">';
                $html .= '<label for="exampleInputUsername1">Giá theo quy cách <span
                style="color: red">(*)</span></label>';
                $keyPress = "'pack_price_".$keyId."'";
                
                $html .= '<input type="text" name="pack['.($keyId ).'][price]" onkeyup="number_format('.$keyPress.', 1)" class="form-control pack_price_'.$keyId.'" onkeypress="return isNumber(event)" autocomplete="off" placeholder="Giá theo quy cách" value="">';
            $html .= '</div>';

            $html .= '<div class="col-3">';
                $html .= '<label for="exampleInputUsername1">Số lượng <span
                style="color: red">(*)</span></label>';
                $html .= '<input type="text" name="pack['.($keyId ).'][quantity]" class="form-control" onkeypress="return isNumber(event)" autocomplete="off" placeholder="Số lượng" value="">';
            $html .= '</div>';

            $html .= '<div class="col-1 dspl">';
                $html .= '<div class="floatLeftRowSmall">';
                    $html .= '<a class="nav-link btnAppend btnAppend_'.$keyId.' fz35" title="Thêm quy cách" href="javascript:void(0)" onclick="appendPack('.$keyId.')">';
                        $html .= '<i class="mdi mdi-plus-circle"></i>';
                    $html .= '</a>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
        echo json_encode(array('success' => true, 'html' => $html));die;
    }

    public function uploadImgs(){
        $text = '{"final_status":200,"request_id":null,"message":"SUCCESS","token":null,"contract_image":null,"list_total_record":null,"account_info":null,"one_time_pass":null,"account_properties":null,"file_url":"imedia/auth/media/files/1640833884704.png","file_type":"image/png","file_size":343,"list_product":null,"list_grou';
        if(!empty($_FILES)){
            $dataUser = $this->dataUserAuthen;
            $username = $dataUser->username;
            $fileImage = $_FILES['file'];
            $token = $dataUser->token;
            $dataUploadImgBack = [
                'file' => $fileImage['tmp_name'],
                'username' => $username,
                'file_type' => '1',
                'type' => $fileImage['type'],
            ];
            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization:'.$token
            ];
            $responseUploadBack = $this->productModels->uploadImage($username, $dataUploadImgBack, $token, $headers);
            if($responseUploadBack['status'] == 200){
                $headerBack = $responseUploadBack['data'];
                $previewPath = $headerBack->file_url; 
                
                echo json_encode(array('success' => true,'message' =>'succcess', 'status' => $responseUploadBack['status'], 'data' => $previewPath));die;
            }else{
                $headerBack = json_decode($responseUploadBack['header']);
                echo json_encode(array('success' => false,'message' =>'false', 'status' =>  $responseUploadBack['status'], 'data' => $headerBack->message));die;
            }
        }else{
            echo json_encode(array('success' => false,'message' =>'false', 'status' => '', 'data' => ''));die;
        }
        die;
    }

    public function uploadImgsCK(){
        $text = '{"final_status":200,"request_id":null,"message":"SUCCESS","token":null,"contract_image":null,"list_total_record":null,"account_info":null,"one_time_pass":null,"account_properties":null,"file_url":"imedia/auth/media/files/1640833884704.png","file_type":"image/png","file_size":343,"list_product":null,"list_grou';
        if(!empty($_FILES)){
            $dataUser = $this->dataUserAuthen;
            $username = $dataUser->username;
            $fileImage = $_FILES['upload'];
            $token = $dataUser->token;
            $dataUploadImgBack = [
                'file' => $fileImage['tmp_name'],
                'username' => $username,
                'file_type' => '1',
                'type' => $fileImage['type'],
            ];
            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization:'.$token
            ];
            $responseUploadBack = $this->productModels->uploadImage($username, $dataUploadImgBack, $token, $headers);
            if($responseUploadBack['status'] == 200){
                $headerBack = $responseUploadBack['data'];
                $previewPath = $headerBack->file_url; 
                
                echo json_encode(array('success' => true,'message' =>'succcess', 'status' => $responseUploadBack['status'], 'data' => $previewPath));die;
            }else{
                $headerBack = json_decode($responseUploadBack['header']);
                echo json_encode(array('success' => false,'message' =>'false', 'status' =>  $responseUploadBack['status'], 'data' => $headerBack->message));die;
            }
        }else{
            echo json_encode(array('success' => false,'message' =>'false', 'status' => '', 'data' => ''));die;
        }
        die;
    }
    public function checkExistProductName(){
        $post = $this->request->getPost();
        if(!empty($post)){
            $checkExistProductName = $post['checkExistProductName'];
            $checkExist = $this->productModels->checkExistProductName($checkExistProductName);
            if(empty($checkExist)){
                echo json_encode(array('success' => true, 'status' => '1',));die;
            }else{
                echo json_encode(array('success' => false, 'status' => '0',));die;
            }
        }else{
            echo json_encode(array('success' => false, 'status' => '0',));die;
        }
    }

    public function exportExcelItemsScale(){
        $post = $this->request->getPost();
        $status = $post['status'];
        $resultGetListProducts = $this->productModels->exportExcelItemsScale($status);
        $fileTitle              = 'PLU';
        $fileNameExcel          =  $fileTitle . '.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        if(!empty($resultGetListProducts)){
            $arrPriceType = (array) json_decode(PRICE_TYPE);
            $sheet->setCellValue('A' . (1), 'Number');
            $sheet->setCellValue('B' . (1), 'Name');
            $sheet->setCellValue('C' . (1), 'Price');
            $sheet->setCellValue('D' . (1), 'Unit');
            $sheet->setCellValue('E' . (1), 'Item Code');
            $sheet->setCellValue('F' . (1), 'Index Barcode');
            $sheet->setCellValue('G' . (1), 'Quy cách');
            $sheet->setCellValue('H' . (1), 'Đơn vị');
            $j=0;
            // $countOrder = count($dataOrder);
            foreach($resultGetListProducts as $object){
                $unitType = '';
                if(isset($arrPriceType[$object->UNIT])){
                    $unitType = $arrPriceType[$object->UNIT];
                }else{
                    $unitType = 'gram';
                }
                $price = ($object->PRICE != '' ) ? round($object->PRICE / 1000) : 0;
                $sheet->setCellValue('A' . ($j + 2), $j+1);
                $sheet->setCellValue('B' . ($j + 2), $object->NAME);
                $sheet->setCellValue('C' . ($j + 2), $price);
                $sheet->setCellValue('D' . ($j + 2), '1');
                $sheet->setCellValue('E' . ($j + 2), $object->PRODUCT_CODE);
                $sheet->setCellValue('F' . ($j + 2), "89");
                $sheet->setCellValue('G' . ($j + 2), $object->WEIGHT);
                $sheet->setCellValue('H' . ($j + 2), $unitType);
                $j++;
            }
    
            $startJ = 2;
            $endJ = $j + 1;
    
            $styleArray = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'wrapText' => [
                    'wrapText' => 'true',
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'inside' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $spreadsheet->getActiveSheet()->getStyle("A".$startJ.":Z".$endJ)->applyFromArray($styleArray);
    
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $fileNameExcel .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            ob_start();
            $writer->save('php://output');
            $xlsData = ob_get_contents();
            ob_end_clean();
            setcookie ("__product",'success^_^Xuất file thành công.',time()+ (60*10) , '/');
            $response =  array(
                    'status' => '200',
                    'href' => base_url('/san-pham/danh-sach-san-pham'),
                    'dataRespon' => 	$resultGetListProducts,
                    'fileNameExcel'=> $fileNameExcel,
                    'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );
                    
            // echo json_encode(array('success' => true, 'dataRespon' => 	$dataCallListOrder));
            die(json_encode($response));
        }
    }
    public function removeMultiProducts(){
        $post = $this->request->getPost();
        
        if(!empty($post)){
            $dataUser = $this->dataUserAuthen;
            $username = $dataUser->username;
            $ids = $post['ids'];
            $type = $post['type'];
            $status = 0;
            if($type == 1){
                $status = 1;
            }
            $resultUpdateProducts = $this->productModels->removeMultiProducts($ids, $status, $username);
            if($resultUpdateProducts){
                setcookie ("__product",'success^_^Thay đổi trạng thái thành công',time()+ (60*5) , '/');
                echo json_encode(array('success' => true, 'status' => $status));die;
            }else{
                setcookie ("__product",'false^_^Thay đổi trạng thái không thành công',time()+ (60*5) , '/');
                echo json_encode(array('success' => false, 'status' => $status));die;
            }
        }else{
            setcookie ("__product",'false^_^Thay đổi trạng thái không thành công',time()+ (60*5) , '/');
                echo json_encode(array('success' => false));die;
        }
    }
}