<?php

namespace App\Modules\SetProducts\Controllers;

use stdClass;

class SetProducts extends BaseController
{
    public function listSetProduct($page = 1)
    {
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        if (!empty($username)) {
            $title = 'Danh sách set sản phẩm';
            $arrSearch = [
                "name" => '',
                "type" => '',
                "area" => '',
                "isBestSellFlag" => '',
                "isPromotionFlag" => '',
                "status" => '',
                "categoryId" => ID_SET,
                "page" => 0,
                "size" => PERPAGE
            ];
            //Pagination
            $page                     = ($this->page) ? $this->page : 1;
            $data['page']             = $page;
            $data['perPage']         = PERPAGE;
            $data['pager']             = $this->pager;
            $data['total']             = 10;
            $data['uri'] = $this->uri;
            $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
            $conditions['LIMIT']  = $data['perPage'];

            $listCate = $this->productModels->getAllCate();
            $listArea = $this->productModels->getListArea();
            $listCooking = $this->productModels->getListCooking();
            $listProductType = $this->setProductsModels->getListProductType(SET_TYPE);
            $arrSeasonal = json_decode(GROUP_SEASONAL);

            $get = $this->request->getGet();
            if (!empty($get)) {
                $bestSellFlag = $get['bestSellFlag'];
                $promotionFlag = $get['promotionFlag'];
                $status = $get['status'];
                $areaApply = $get['areaApply']; 

                // print_r($get);die;
                if ($promotionFlag == '-1')
                    $promotionFlag = '';

                if ($bestSellFlag == '-1')
                    $bestSellFlag = '';

                if ($status == '-1')
                    $status = '';

                if ($areaApply == '0')
                    $areaApply = '';

                $arrSearch = [
                    "name" => $get['name'],
                    "type" => '',
                    "area" => $areaApply,
                    "isBestSellFlag" => $bestSellFlag,
                    "isPromotionFlag" => $promotionFlag,
                    "status" =>  $status,
                    "categoryId" => ID_SET,
                    "page" => $page,
                    "size" => PERPAGE
                ];
            }

            // getProductsToCreateSet
            $token = $dataUser->token;
            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: ' . $token,
            ];


            // get all set
            $listSetProducts = $this->setProductsModels->getAllSet($arrSearch, $headers); 

            $data['get'] = $get;
            $data['total'] = $listSetProducts->data->numOfRecords;
            $data['productModels'] = $this->productModels;
            $data['listSetProducts'] = $listSetProducts->data->setProducts;
            $data['title'] = $title;
            $data['arrSeasonal'] = $arrSeasonal;
            $data['listProductType'] = $listProductType;
            $data['listCooking'] = $listCooking;
            $data['listArea'] = $listArea;
            $data['listCate'] = $listCate;
            $data['dataUser'] = $dataUser;
            $data['view'] = 'App\Modules\SetProducts\Views\listSetProduct';
            return view('layoutKho/layout', $data);
        } else {
            setcookie("__product", 'false^_^Vui lòng đăng nhập.', time() + (60 * 5), '/');
            return redirect()->to('/dang-xuat');
        }
    }

    public function createSet()
    {
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $title = 'Thêm set sản phẩm';
        $arrSearch = [];
        //Pagination

        $token = $dataUser->token;
        $username = $dataUser->username;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];
        $listCate = $this->setProductsModels->getAllCateSet();
        $listArea = $this->productModels->getListArea();
        $listCooking = $this->productModels->getListCooking();
        $listProductType = $this->setProductsModels->getListProductType(SET_TYPE);
        $arrSeasonal = json_decode(GROUP_SEASONAL);

        $reponseListProducts = $this->setProductsModels->getProductsToCreateSet($dataCall = [], $headers);
        if ($reponseListProducts->status == 200) {
            $listProducts = $reponseListProducts->data;
        } else {
            $listProducts = [];
        }
        $post = $this->request->getPost();
        if (!empty($post)) {
            $imagesProduct = $post['inputImg'];
            $imagesThumb = $post['imgThumbnailProduct'];
            $listProductsPack = $post['pack'];
            $listCook = $post['cook'];
            $listAreas = $post['areaApply'];
            // echo '<pre>';
            // print_r($listAreas);die;
            $listSeasons = $post['seasonal'];
            $listCategory = $post['setCate'];
            $setPrice = $post['setPrice'];
            $this->validation->setRules([
                'setCate' => [
                    'label' => 'Label.txtCategory',
                    'rules' => 'required',
                    'errors' => []
                ],
                
                'positionProduct' => [
                    'label' => 'Label.positionProduct',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.positionProduct'
                    ]
                ],
                'goodsType' => [
                    'label' => 'Label.txtGoodsType',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
                'setName' => [
                    'label' => 'Label.txtProductName',
                    'rules' => 'required',
                    'errors' => []
                ],
                'sapoSetProduct' => [
                    'label' => 'Label.txtSapoProduct',
                    'rules' => 'required',
                    'errors' => []
                ],
                'contentSetProduct' => [
                    'label' => 'Label.txtContentProduct',
                    'rules' => 'required',
                    'errors' => []
                ],
                'preserve' => [
                    'label' => 'Label.preserve',
                    'rules' => 'required',
                    'errors' => []
                ],
                'imgThumbnailProduct' => [
                    'label' => 'Label.imgThumbnailProduct',
                    'rules' => 'required',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
                'setPrice' => [
                    'label' => 'Label.setPrice',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.setPrice'
                    ]
                ]
            ]);
            $productImg = 1;
            if (!isset($post['inputImg'])) {
                $productImg = 0;
            }
            $checkPack = 0;
            if (isset($listProductsPack)) {
                foreach ($listProductsPack as $keyPack => $valuePack) {
                    // echo '<pre>';
                    // print_r($valuePack);die;
                    if ($valuePack['product'] == '') {
                        $errorPack[$keyPack]['checkProduct'] = 'Sản phẩm không được để trống';
                        $checkPack = 1;
                    }
                    if ($valuePack['productPrice'] == '') {
                        $errorPack[$keyPack]['checkProductPrice'] = 'Quy cách không được để trống';
                        $checkPack = 1;
                    }
                    if ($valuePack['setQuantity'] == '') {
                        $errorPack[$keyPack]['checkQuantity'] = 'Số lượng không được để trống';
                        $checkPack = 1;
                    }
                    if ($valuePack['productPosition'] < 1) {
                        $errorPack[$keyPack]['checkProductPosition'] = 'Vị trí phải lớn hơn 0';
                        $checkPack = 1;
                    }
                    if ($valuePack['isDefault'] == 1) {
                        if ($valuePack['setQuantityDefault'] == '') {
                            $errorPack[$keyPack]['checkQuantityDefault'] = 'Số lượng mặc định không được để trống';
                            $checkPack = 1;
                        }
                    }
                }
            }
            $checkArea = 1;
            if (!isset($listAreas) || empty($listAreas)) {
                $checkArea = 0;
            }
            $checkSeasons = 1;
            if (!isset($listSeasons)) {
                $checkSeasons = 0;
            }
            $checkCook = 1;
            if (!isset($listCook)) {
                $checkCook = 0;
            }

            if (!$this->validation->withRequest($this->request)->run() || $productImg == 0 || $checkPack == 1 || $checkSeasons == 0 || $checkCook == 0 || $checkArea == 0) {
                $getErrors = $this->validation->getErrors();
                if ($productImg == 0) {
                    $getErrors['inputImg'] = 'Ảnh sản phẩm không được để trống';
                }
                if ($checkPack == 1) {
                    $getErrors['checkPack'] = $errorPack;
                }
                if ($checkArea == 0) {
                    $getErrors['checkArea'] = 'Khu vực áp dụng không được để trống';
                }
                if ($checkSeasons == 0) {
                    $getErrors['checkSeasons'] = 'Thời vụ gieo trồng không được để trống';
                }
                if ($checkCook == 0) {
                    $getErrors['checkCook'] = 'Công thức nấu ăn không được để trống';
                }
                $productChosen = $post['pack'];
                foreach ($productChosen as $keyProduct => $item) {
                    $dataCallPrice = [
                        'productId' => $item['product']
                    ];
                    $resultPrice = $this->setProductsModels->getProductPricesToCreateSet($dataCallPrice, $headers);
                    if ($resultPrice->status == 200) {
                        $post['pack'][$keyProduct]['prices'] = $resultPrice->data;
                    }
                }
                $category = [];
                if (!empty($post['setCate'])) {
                    foreach ($post['setCate'] as $itemCate) {
                        $cateObj = new \stdClass;
                        $cateObj->id = (int) $itemCate;
                        array_push($category, $cateObj);
                    }
                }
                // echo '<pre>';
                //    print_r($getErrors);die;
                $listCate = $this->setProductsModels->getAllCateSet(203, 0, $category);
                $data['listProducts'] = $listProducts;
                $data['getErrors'] = $getErrors;
                $data['post'] = $post;
                $data['title'] = $title;
                $data['arrSeasonal'] = $arrSeasonal;
                $data['listProductType'] = $listProductType;
                $data['listCooking'] = $listCooking;
                $data['listArea'] = $listArea;
                $data['listCate'] = $listCate;
                $data['dataUser'] = $dataUser;
                $data['view'] = 'App\Modules\SetProducts\Views\addProduct';
                return view('layoutKho/layout', $data);
            } else {

                $productItem = [];
                $images = [];
                $cook = [];
                $areas = [];
                $seasons = [];
                $categories = [];
                //Product
                foreach ($listProductsPack as $product) {
                    $arrPriceProductObject = new \stdClass;
                    $arrPriceProductObject->productId = (int) $product['product'];
                    $arrPriceProductObject->priceId = (int) $product['productPrice'];
                    $arrPriceProductObject->quantity = (int) $product['setQuantity'];
                    $arrPriceProductObject->isDefault = (int) $product['isDefault'] ?? 0;
                    $arrPriceProductObject->defaultQuantity = (int) $product['setQuantityDefault'] ?? 0;
                    $arrPriceProductObject->positionProduct = (int) $product['productPosition'];
                    array_push($productItem, $arrPriceProductObject);
                }

                //Images
                foreach ($imagesProduct as $imageItem) {
                    $imageObj = new \stdClass;
                    $imageObj->path = $imageItem;
                    $imageObj->isThumbnail = 0;
                    array_push($images, $imageObj);
                }
                $imagesThumObj = new \stdClass;
                $imagesThumObj->path = $imagesThumb;
                $imagesThumObj->isThumbnail = 1;
                //Cook
                foreach ($listCook as $itemCook) {
                    $cookObj = new \stdClass;
                    $cookObj->id = (int) $itemCook;
                    array_push($cook, $cookObj);
                }

                //Areas
                
                foreach ($listAreas as $itemArea) {
                    $areaObj = new \stdClass;
                    $areaObj->area = $itemArea;
                    array_push($areas, $areaObj);
                }

                // $seasons
                foreach ($listSeasons as $itemSeason) {
                    $seasonObj = new \stdClass;
                    $seasonObj->season = $itemSeason;
                    array_push($seasons, $seasonObj);
                }
                // $category
                foreach ($listCategory as $itemCate) {
                    $cateObj = new \stdClass;
                    $cateObj->categoryId = (int) $itemCate;
                    array_push($categories, $cateObj);
                }


                array_push($images, $imagesThumObj);

                $dataCallCreateSet = [
                    'price' => (int) str_replace(array(',', '.', '  ', '   '), '', $post['setPrice']),
                    'name' => $post['setName'],
                    'sapo' => $post['sapoSetProduct'],
                    'content' => $post['contentSetProduct'],
                    'nutrition' => $post['setNutrition'],
                    'effectual' => $post['setEffectual'],
                    'processing' => $post['setProcessing'],
                    'promotionFlag' => (int) $post['promotionFlag'],
                    'bestSellFlag' => (int) $post['bestSellFlag'],
                    'positionSet' => (int) $post['positionProduct'],
                    'preserve' => $post['preserve'],
                    'images' => $images,
                    'products' => $productItem,
                    'categories' => $categories,
                    'areas' => $areas,
                    'seasons' => $seasons,
                    'cooks' => $cook,
                    'status' => (int) $post['status'],
                ];
                $reponseListProducts = $this->setProductsModels->createSet($dataCallCreateSet, $headers, $username);
                if ($reponseListProducts->status == 200) {
                    setcookie("__product", 'success^_^Tạo set thành công', time() + (60 * 5), '/');
                    return redirect()->to('/set-san-pham/danh-sach-set-san-pham');
                    die;
                } else if ($reponseListProducts->status == 305 || $reponseListProducts->status == 612) {
                    $productChosen = $post['pack'];
                    foreach ($productChosen as $keyProduct => $item) {
                        $dataCallPrice = [
                            'productId' => $item['product']
                        ];
                        $resultPrice = $this->setProductsModels->getProductPricesToCreateSet($dataCallPrice, $headers);
                        if ($resultPrice->status == 200) {
                            $post['pack'][$keyProduct]['prices'] = $resultPrice->data;
                        }
                    }
                    $category = [];
                    if (!empty($post['setCate'])) {
                        foreach ($post['setCate'] as $itemCate) {
                            $cateObj = new \stdClass;
                            $cateObj->id = (int) $itemCate;
                            array_push($category, $cateObj);
                        }
                    }
                    $listCate = $this->setProductsModels->getAllCateSet(203, 0, $category);
                    setcookie("__product", 'false^_^' . $reponseListProducts->message, time() + (20), '/');
                    $checkFail = 1;
                    $messageFail = $reponseListProducts->message;
                    // echo 111;die;
                    $data['checkFail'] = $checkFail;
                    $data['messageFail'] = $messageFail;
                    $data['listProducts'] = $listProducts;
                    $data['post'] = $post;
                    $data['title'] = $title;
                    $data['arrSeasonal'] = $arrSeasonal;
                    $data['listProductType'] = $listProductType;
                    $data['listCooking'] = $listCooking;
                    $data['listArea'] = $listArea;
                    $data['listCate'] = $listCate;
                    $data['dataUser'] = $dataUser;
                    $data['view'] = 'App\Modules\SetProducts\Views\addProduct';
                    return view('layoutKho/layout', $data);
                } else {
                    setcookie("__product", 'false^_^' . $reponseListProducts->message, time() + (60 * 5), '/');
                    return redirect()->to('/set-san-pham/danh-sach-set-san-pham');
                    die;
                }
            }
        }

        $getTotalProducts = $this->productModels->getTotalProducts($arrSearch, $username);
        $data['checkFail'] = 0;
        $data['messageFail'] = '';
        $data['listProducts'] = $listProducts;
        $data['total'] = $getTotalProducts;
        $data['title'] = $title;
        $data['arrSeasonal'] = $arrSeasonal;
        $data['listProductType'] = $listProductType;
        $data['listCooking'] = $listCooking;
        $data['listArea'] = $listArea;
        $data['listCate'] = $listCate;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\SetProducts\Views\addProduct';
        return view('layoutKho/layout', $data);
    }
    public function getProductPrice()
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
                'productId' => $post['productId']
            ];

            $responseProductPrices = $this->setProductsModels->getProductPricesToCreateSet($dataCall, $headers);
            if ($responseProductPrices->status == 200) {
                $dataProductPrices = $responseProductPrices->data;
                $str = '<option value="">Chọn cách đóng gói</option>';
                foreach ($dataProductPrices as $key => $value) {
                    $str .= '<option price="'.$value->price.'" value="' . $value->id . '">' . $value->weight . ' ' . $value->unit . '</option>';
                }
                echo json_encode(array('success' => true, 'data' => $str));
                die;
            } else {
                echo json_encode(array('success' => false));
                die;
            }
        } else {
            echo json_encode(array('success' => false));
            die;
        }
    }
    public function addProductPrice()
    {
        $post = $this->request->getPost();
        $dataProduct = $this->setProductsModels->getProduct();

        if (!empty($post)) {
            $html = '<div class="form-group row pdn setProductPlusItem" count="' . $post['total'] . '">';
                $html .= '<div class="col-md-4">';
                    $html .= '<label for="setProductPlus">Sản phẩm theo set <span style="color: red">(*)</span></label>';
                    $html .= '<select class="form-control chosen-select setProductPlusKey-' . $post['total'] . ' setProductPlus" key="' . $post['total'] . '" name="setProductPlus">';
                        $html .= '<option value="">Chọn sản phẩm theo set</option>';
                        $html .= $dataProduct;
                    $html .= '</select>';
                $html .= '</div>';
                $html .= '<div class="col-md-6">';
                    $html .= '<label for="setProductPrice">Quy cách đóng gói <span style="color: red">(*)</span></label>';
                    $html .= '<select class="form-control chosen-select setProductPriceKey-' . $post['total'] . ' setProductPrice" name="setProductPrice">';
                        $html .= '<option value="0">Chọn quy cách đóng gói</option>';
                    $html .= '</select>';
                $html .= '</div>';
            $html .= '</div>';
            echo json_encode(array('success' => true, 'data' => $html));
            die;
        }
    }
    public function addProductToSet()
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

            $reponseListProducts = $this->setProductsModels->getProductsToCreateSet($dataCall = [], $headers);
            if ($reponseListProducts->status == 200) {
                $listProducts = $reponseListProducts->data;
            } else {
                $listProducts = [];
            }

            $key = $post['total'];
            $html = '';
            $html .=  '<div class="wrapProduct row setProductPlusItem">';
                $html .= '<div class="col-md-1 rowPaddingFirst">';
                    $html .= '<label for="productPrice"> Default </label>';
                    $html .= '<input class="check-action isDefaultAction isDefault_' . $key . '" key="' . $key . '" value="1" name="pack[' . $key . '][isDefault]" type="checkbox">';
                $html .= '</div>';

                $html .= '<div class="col-md-2 setProductPlusDiv-' . $key . ' rowPadding">';
                    $html .= '<label for="setProductPlus">Sản phẩm theo set <span style="color: red">(*)</span></label>';
                    $html .= '<select class="form-control chosen-select setProductPlusKey-' . $key . ' setProductPlus" key="' . $key . '" name="pack[' . $key . '][product]">';
                    $html .= '<option value="">Chọn sản phẩm theo set</option>';
                    if (!empty($listProducts)) {
                        foreach ($listProducts as $item) {
                            $html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
                        }
                    }
                    $html .= '</select>';
                    $html .= '<span class="error_text errSetProductPlus-' . $key . '"></span>';
                $html .= '</div>';

                $html .= '<div class="col-md-2 setProductPriceKeyDiv-' . $key . ' rowPadding">';
                    $html .= '<label for="setProductPrice">Quy cách đóng gói <span style="color: red">(*)</span></label>';
                    $html .= '<select key="' . $key . '" class="form-control chosen-select setProductPriceKey-' . $key . ' setProductPrice" name="pack[' . $key . '][productPrice]">';
                    $html .= '<option value="0">Chọn quy cách đóng gói</option>';
                    $html .= '</select>';
                    $html .= '<span class="error_text errSetProductPrice-' . $key . '"></span>';
                $html .= '</div>';

                $html .= '<div class="col-md-3 setProductQuantityDiv-' . $key . ' rowPadding">';
                    $html .= '<label for="setQuantity"> Số lượng <span style="color: red">(*)</span></label>';
                    $html .= '<input type="text" key="' . $key . '" name="pack[' . $key . '][setQuantity]" class="form-control setQuantity setQuantity-' . $key . '" placeholder="Số lượng" value="">';
                    $html .= '<span class="error_text errSetQuantity errSetQuantity-' . $key . '"></span>';
                $html .= '</div>';
                
                $html .= '<div class="col-md-2 totalMoneyDiv-' . $key . ' rowPadding">';
                    $html .= '<label for="totalMoney"> Thành tiền </label>';
                    $html .= '<input type="text" name="pack[' . $key . '][totalMoney]" class="form-control totalMoney totalMoney-' . $key . '"disabled placeholder="Thành tiền" value="">';
                    $html .= '<span class="error_text errTotalMoney errTotalMoney-0"></span>';
                    $html .= '<input type="hidden" name="pack[' . $key . '][totalMoney]" class="totalMoneyPost-' . $key . '" />';
                $html .= '</div>';

                $html .= '<div class="col-md-1 setProductPositionDiv-' . $key . ' rowPadding">';
                    $html .= '<label for="productPrice"> Thứ tự <span style="color: red">(*)</span></label>';
                    $html .= '<input type="text" name="pack[' . $key . '][productPosition]" class="form-control productPosition productPosition-' . $key . '" placeholder="Thứ tự SP" value="">';
                    $html .= '<span class="error_text errProductPosition errProductPosition-' . $key . '"></span>';
                $html .= '</div>';

                $html .= '<div class="col-md-1">';
                    $html .= '<label for="removeProductPlus" class="blRemoveProductPlus"></label>';
                    $html .= '<button type="button" class="btn btn-danger removeProductPlus removeProductPlus-' . $key . '"><span><i class="mdi mdi-minus-circle-outline"></i></span></button>';
                $html .= '</div>';
            $html .= '</div>';
            echo json_encode(array('success' => true, 'data' => $html));
            die;
        } else {
            echo json_encode(array('success' => false, 'data' => ''));
            die;
        }
    }
    public function editSet($id)
    {
        $title = 'Sửa set sản phẩm';
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $userId = $dataUser->userId;
        $token = $dataUser->token;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];
        $dataCall = [
            'setId' => $id
        ];
        $reponseSetDetail = $this->setProductsModels->getSetDetail($dataCall, $headers);
        if ($reponseSetDetail->status == 200) {
            $setDetail = $reponseSetDetail->data;
            $cateChosen = $setDetail->categories;
            $listCate = $this->setProductsModels->getAllCateSet(ID_SET, 0, $cateChosen);
            $listArea = $this->productModels->getListArea();
            $listCooking = $this->productModels->getListCooking();
            $listProductType = $this->setProductsModels->getListProductType(SET_TYPE);
            $arrSeasonal = json_decode(GROUP_SEASONAL);
            $reponseListProducts = $this->setProductsModels->getProductsToCreateSet($dataCall = [], $headers);
            if ($reponseListProducts->status == 200) {
                $listProducts = $reponseListProducts->data;
            } else {
                $listProducts = [];
            }
            $post = $this->request->getPost();
            if (!empty($post)) {
                $imagesProduct = $post['inputImg'];
                $imagesThumb = $post['imgThumbnailProduct'];
                $listProductsPack = $post['pack'];
                $listCook = $post['cook'];
                $listAreas = $post['areaApply'];
                $listSeasons = $post['seasonal'];
                $listCategory = $post['setCate'];
                $setPrice = $post['setPrice'];
                $this->validation->setRules([
                    'setCate' => [
                        'label' => 'Label.txtCategory',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'goodsType' => [
                        'label' => 'Label.txtGoodsType',
                        'rules' => 'required|checkGreater',
                        'errors' => [
                            'checkGreater' => 'Validation.checkGreater'
                        ]
                    ],
                    'setName' => [
                        'label' => 'Label.txtProductName',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'sapoSetProduct' => [
                        'label' => 'Label.txtSapoProduct',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'contentSetProduct' => [
                        'label' => 'Label.txtContentProduct',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'imgThumbnailProduct' => [
                        'label' => 'Label.imgThumbnailProduct',
                        'rules' => 'required',
                        'errors' => [
                            'checkGreater' => 'Validation.checkGreater'
                        ]
                    ],
                    'positionProduct' => [
                        'label' => 'Label.positionProduct',
                        'rules' => 'required',
                        'errors' => [
                            'checkGreater' => 'Validation.checkGreater'
                        ]
                    ],
                    'setPrice' => [
                        'label' => 'Label.setPrice',
                        'rules' => 'required|checkGreater',
                        'errors' => [
                            'checkGreater' => 'Validation.setPrice'
                        ]
                        ],
                        'preserve' => [
                        'label' => 'Label.preserve',
                        'rules' => 'required',
                        'errors' => []
                    ],
                ]);
                $productImg = 1;
                if (!isset($post['inputImg'])) {
                    $productImg = 0;
                }
                $checkPack = 0;
                if (isset($listProductsPack)) {
                    foreach ($listProductsPack as $keyPack => $valuePack) {
                        if ($valuePack['product'] == '') {
                            $errorPack[$keyPack]['checkProduct'] = 'Sản phẩm không được để trống';
                            $checkPack = 1;
                        }
                        if ($valuePack['productPrice'] == '') {
                            $errorPack[$keyPack]['checkProductPrice'] = 'Quy cách không được để trống';
                            $checkPack = 1;
                        }
                        if ($valuePack['setQuantity'] == '') {
                            $errorPack[$keyPack]['checkQuantity'] = 'Số lượng không được để trống';
                            $checkPack = 1;
                        }
                        if ($valuePack['isDefault'] == 1) {
                            if ($valuePack['setQuantityDefault'] == '') {
                                $errorPack[$keyPack]['checkQuantityDefault'] = 'Số lượng mặc định không được để trống';
                                $checkPack = 1;
                            }
                        }
                    }
                }
                $checkArea = 1;
                if (!isset($listAreas)) {
                    $checkArea = 0;
                }
                $checkSeasons = 1;
                if (!isset($listSeasons)) {
                    $checkSeasons = 0;
                }
                $checkCook = 1;
                if (!isset($listCook)) {
                    $checkCook = 0;
                }

                if (!$this->validation->withRequest($this->request)->run() || $productImg == 0 || $checkPack == 1 || $checkSeasons == 0 || $checkCook == 0 || $checkArea == 0) {
                    $getErrors = $this->validation->getErrors();
                    if ($productImg == 0) {
                        $getErrors['inputImg'] = 'Ảnh sản phẩm không được để trống';
                    }
                    if ($checkPack == 1) {
                        $getErrors['checkPack'] = $errorPack;
                    }

                    if ($checkArea == 0) {
                        $getErrors['checkArea'] = 'Khu vực áp dụng không được để trống';
                    }
                    if ($checkSeasons == 0) {
                        $getErrors['checkSeasons'] = 'Thời vụ gieo trồng không được để trống';
                    }
                    if ($checkCook == 0) {
                        $getErrors['checkCook'] = 'Công thức nấu ăn không được để trống';
                    }
                    $setDetailOld = $this->buildMessageEdit($post);
                    $data['listProducts'] = $listProducts;
                    $data['getErrors'] = $getErrors;
                    $data['post'] = $post;
                    $data['setId'] = $id;
                    $data['title'] = $title;
                    $data['arrSeasonal'] = $arrSeasonal;
                    $data['listProductType'] = $listProductType;
                    $data['listCooking'] = $listCooking;
                    $data['listArea'] = $listArea;
                    $data['listCate'] = $listCate;
                    $data['setId'] = $id;
                    $data['setDetail'] = $setDetailOld;
                    $data['dataUser'] = $dataUser;
                    $data['view'] = 'App\Modules\SetProducts\Views\editProduct';
                    return view('layoutKho/layout', $data);
                } else {
                    $productItem = [];
                    $images = [];
                    $cook = [];
                    $areas = [];
                    $seasons = [];
                    $categories = [];
                    //Product
                    foreach ($listProductsPack as $product) {
                        $arrPriceProductObject = new \stdClass;
                        $arrPriceProductObject->productId = (int) $product['product'];
                        $arrPriceProductObject->priceId = (int) $product['productPrice'];
                        $arrPriceProductObject->quantity = (int) $product['setQuantity'];
                        $arrPriceProductObject->isDefault = (int) $product['isDefault'] ?? 0;
                        $arrPriceProductObject->defaultQuantity = (int) $product['setQuantityDefault'] ?? 0;
                        $arrPriceProductObject->positionProduct = (int) $product['productPosition'];
                        array_push($productItem, $arrPriceProductObject);
                    }

                    //Images
                    foreach ($imagesProduct as $imageItem) {
                        $imageObj = new \stdClass;
                        $imageObj->path = $imageItem;
                        $imageObj->isThumbnail = 0;
                        array_push($images, $imageObj);
                    }
                    $imagesThumObj = new \stdClass;
                    $imagesThumObj->path = $imagesThumb;
                    $imagesThumObj->isThumbnail = 1;
                    //Cook
                    foreach ($listCook as $itemCook) {
                        $cookObj = new \stdClass;
                        $cookObj->id = (int) $itemCook;
                        array_push($cook, $cookObj);
                    }

                    //Areas
                    foreach ($listAreas as $itemArea) {
                        $areaObj = new \stdClass;
                        $areaObj->area = $itemArea;
                        array_push($areas, $areaObj);
                    }

                    // $seasons
                    foreach ($listSeasons as $itemSeason) {
                        $seasonObj = new \stdClass;
                        $seasonObj->season = $itemSeason;
                        array_push($seasons, $seasonObj);
                    }
                    // $category
                    foreach ($listCategory as $itemCate) {
                        $cateObj = new \stdClass;
                        $cateObj->categoryId = (int) $itemCate;
                        array_push($categories, $cateObj);
                    }


                    array_push($images, $imagesThumObj);

                    $dataCallEditSet = [
                        'setId' => (int) $post['setId'],
                        'price' => (int) str_replace(array(',', '.', '  ', '   '), '', $post['setPrice']),
                        'name' => $post['setName'],
                        'sapo' => $post['sapoSetProduct'],
                        'content' => $post['contentSetProduct'],
                        'nutrition' => $post['setNutrition'],
                        'effectual' => $post['setEffectual'],
                        'processing' => $post['setProcessing'],
                        'promotionFlag' => (int) $post['promotionFlag'],
                        'bestSellFlag' => (int) $post['bestSellFlag'],
                        'positionSet' => (int) $post['positionProduct'],
                        'preserve' => $post['preserve'],
                        'images' => $images,
                        'products' => $productItem,
                        'categories' => $categories,
                        'areas' => $areas,
                        'seasons' => $seasons,
                        'cooks' => $cook,
                        'status' => (int) $post['status'],
                    ];
                    $reponseListProducts = $this->setProductsModels->editSet($dataCallEditSet, $headers, $username);
                    if ($reponseListProducts->status == 200) {
                        setcookie("__product", 'success^_^Sửa set thành công', time() + (60 * 5), '/');
                        return redirect()->to('/set-san-pham/danh-sach-set-san-pham');
                        die;
                    } else if ($reponseListProducts->status == 305) {
                        setcookie("__product", 'false^_^' . $reponseListProducts->message, time() + (60 * 5), '/');
                        $setDetailOld = $this->buildMessageEdit($post);

                        $data['listProducts'] = $listProducts;
                        $data['post'] = $post;
                        $data['setId'] = $id;
                        $data['title'] = $title;
                        $data['arrSeasonal'] = $arrSeasonal;
                        $data['listProductType'] = $listProductType;
                        $data['listCooking'] = $listCooking;
                        $data['listArea'] = $listArea;
                        $data['listCate'] = $listCate;
                        $data['setId'] = $id;
                        $data['setDetail'] = $setDetailOld;
                        $data['dataUser'] = $dataUser;
                        $data['view'] = 'App\Modules\SetProducts\Views\editProduct';
                        return view('layoutKho/layout', $data);
                    } else {
                        setcookie("__product", 'false^_^' . $reponseListProducts->message, time() + (60 * 5), '/');
                    }
                }
            }
            $data['setId'] = $id;
            $data['listProducts'] = $listProducts;
            $data['arrSeasonal'] = $arrSeasonal;
            $data['listProductType'] = $listProductType;
            $data['listCooking'] = $listCooking;
            $data['listArea'] = $listArea;
            $data['listCate'] = $listCate;
            $data['setDetail'] = $setDetail;
            $data['dataUser'] = $dataUser;
            $data['view'] = 'App\Modules\SetProducts\Views\editProduct';
            return view('layoutKho/layout', $data);
        } else {
            setcookie("__product", 'false^_^Có lỗi khi lấy chi tiết set', time() + (60 * 5), '/');
            return redirect()->to('/set-san-pham/danh-sach-set-san-pham');
            die;
        }
    }

    public function buildMessageEdit($post)
    {
        $dataUser = $this->dataUserAuthen;
        //Pagination

        $token = $dataUser->token;
        $username = $dataUser->username;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];
        $setDetailOld = new \stdClass;
        $productChosen = $post['pack'];
        $productArr = [];
        foreach ($productChosen as $keyProduct => $item) {
            $dataCallPrice = [
                'productId' => $item['product']
            ];
            $resultPrice = $this->setProductsModels->getProductPricesToCreateSet($dataCallPrice, $headers);
            if ($resultPrice->status == 200) {
                $productArr[$keyProduct] = new \stdClass;
                $productArr[$keyProduct]->productId = $item['product'];
                $productArr[$keyProduct]->productPriceId = $item['productPrice'];
                $productArr[$keyProduct]->quantity = $item['setQuantity'];
                $productArr[$keyProduct]->positionProduct = $item['productPosition'];
                $productArr[$keyProduct]->price = $item['totalMoney'];
                if (isset($item['isDefault'])) {
                    $productArr[$keyProduct]->isDefault = $item['isDefault'];
                    $productArr[$keyProduct]->defaultQuantity = $item['setQuantityDefault'];
                } else {
                    $productArr[$keyProduct]->isDefault = 0;
                    $productArr[$keyProduct]->defaultQuantity = 0;
                }
                $productArr[$keyProduct]->prices = $resultPrice->data;
            }
        }

        // $setDetailOld
        $setDetailOld->setId = $post['setId'];
        $setDetailOld->setType = $post['goodsType'];
        $setDetailOld->price = str_replace(array(',', '.', '  ', '   '), '', $post['setPrice']);
        $setDetailOld->setName = $post['setName'];
        $setDetailOld->sapo = $post['sapoSetProduct'];
        $setDetailOld->content = $post['contentSetProduct'];
        $setDetailOld->nutrition = $post['setNutrition'];
        $setDetailOld->effectual = $post['setEffectual'];
        $setDetailOld->processing = $post['setProcessing'];
        if(isset($post['seasonal'])){
            $setDetailOld->seasonal = implode(',', $post['seasonal']);
        }
        $setDetailOld->promotionFlag = $post['promotionFlag'];
        $setDetailOld->bestSellFlag = $post['bestSellFlag'];
        $setDetailOld->preserve = $post['preserve'];
        $setDetailOld->setProducts = $productArr;
        $setDetailOld->thumbnailImage = $post['imgThumbnailProduct'];
        $setDetailOld->status = $post['status'];
        $setDetailOld->positionSet = $post['positionProduct'];
        $cook = [];
        if (!empty($post['cook'])) {
            foreach ($post['cook'] as $itemCook) {
                $cookObj = new \stdClass;
                $cookObj->id = (int) $itemCook;
                array_push($cook, $cookObj);
            }
        }
        $setDetailOld->cooks = $cook;

        $areas = [];
        if (!empty($post['areaApply'])) {
            foreach ($post['areaApply'] as $itemArea) {
                $areaObj = new \stdClass;
                $areaObj->code = $itemArea;
                array_push($areas, $areaObj);
            }
        }
        $setDetailOld->areas = $areas;

        $category = [];
        if (!empty($post['setCate'])) {
            foreach ($post['setCate'] as $itemCate) {
                $cateObj = new \stdClass;
                $cateObj->id = (int) $itemCate;
                array_push($category, $cateObj);
            }
        }

        $image = [];
        if (!empty($post['inputImg'])) {
            foreach ($post['inputImg'] as $itemImg) {
                $imgObj = new \stdClass;
                if (strpos($itemImg, URL_IMAGE_SHOW) !== false) {

                    $imgObj->path = $itemImg;
                } else {
                    $imgObj->path = URL_IMAGE_SHOW . $itemImg;
                }
                array_push($image, $imgObj);
            }
        }
        $setDetailOld->categories = $category;
        $setDetailOld->images = $image;
        return $setDetailOld;
    }

    public function removeMultiSet(){
        $post = $this->request->getPost(); 
        if(!empty($post)){ 
            $ids = $post['ids'];   
            $dataCallApi = [
                'sets' => $ids
            ];

            $dataUser = $this->dataUserAuthen;
            $token = $dataUser->token;
            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: ' . $token,
            ];
          
            $resultUpdateProducts = $this->setProductsModels->removeMultiSet($dataCallApi, $headers);
            if($resultUpdateProducts){
                setcookie ("__product",'success^_^Thay đổi trạng thái thành công',time()+ (60*5) , '/');
                echo json_encode(array('success' => true, 'status' => $resultUpdateProducts->status));die;
            }else{
                setcookie ("__product",'false^_^Thay đổi trạng thái không thành công',time()+ (60*5) , '/');
                echo json_encode(array('success' => false, 'status' => $resultUpdateProducts->status));die;
            }
        }else{
            setcookie ("__product",'false^_^Thay đổi trạng thái không thành công',time()+ (60*5) , '/');
                echo json_encode(array('success' => false));die;
        }
    }
}
