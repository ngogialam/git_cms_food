<?php

namespace App\Modules\MenusFood\Controllers;

class Menus extends BaseController
{
    public function listDish($page = 1)
    {
        $dataUser = $this->dataUserAuthen;
        $token = $dataUser->token;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];


        $getParams = $this->request->getGet();

        $dataCallApi = [
            'status' => $getParams['status'] ?? -1,
            'page' => $page,
            'size' => PERPAGE,
            'name' => $getParams['name'] ?? '',
            'restaurantId' => $getParams['restaurant'] ?? -1
        ];

        $total = 0;
        $data['page']              = $page;
        $data['perPage']           = PERPAGE;
        $data['pager']             = $this->pager;

        $listRestaurant = $this->menusModels->callApiGetListRestaurant($headers);
        if (!empty($listRestaurant) && $listRestaurant->status === 200) {
            $data['listRestaurant'] = $listRestaurant->data;
        } else {
            $data['listRestaurant'] = [];
        }

        $res = $this->menusModels->callApiGetListDish($dataCallApi, $headers);

        if (!empty($res) && $res->status === 200) {
            $total = $res->data->totalRecords;
            $data['listDish'] = $res->data->data;
        } else {
            $data['listDish'] = [];
        }

        $defaultOpeningTime = [];
        $resultDefaultOpeningTime = $this->menusModels->getOpeningTime(ID_RESTAURANT, $headers);
        if ($resultDefaultOpeningTime->status == 200) {
            $defaultOpeningTime = $resultDefaultOpeningTime->data[0];
            $data['restaurant'] = ID_RESTAURANT;
        }

        // Set return data
        $data['statusGet'] = $getParams['status'] ?? null;
        $data['restaurant'] = $getParams['restaurant'] ?? null;
        $data['nameGet'] = $getParams['name'] ?? null;

        $data['defaultOpeningTime'] = $defaultOpeningTime;
        $data['get'] = $get;
        $data['dataUser'] = $dataUser;
        $data['total'] = $total;
        $data['title'] = 'Danh sách món ăn';
        $data['view'] = 'App\Modules\MenusFood\Views\listMenus';
        return view('layoutKho/layout', $data);
    }

    public function editDish()
    {
        $dataUser = $this->dataUserAuthen;
        $token = $dataUser->token;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];
        $post = $this->request->getPost();
        if (!empty($post)) {
            $imgArr = explode('|', $post['imageDish']);
            $listImgs = [];
            if (!empty($imgArr)) {
                foreach ($imgArr as $key => $itemProduct) {
                    $productDetail = new \stdClass;
                    $productDetail->imageDishPath = $itemProduct;
                    //Set Items Detail
                    $listImgs[$key] = $productDetail;
                }
            }
            if ($post['position'] == '') {
                $position = 1;
            } else {
                $position = $post['position'];
            }
            $dataUpdate = [
                "id" => $post['idDish'],
                "name" => $post['name'],
                "originalPrice" => str_replace(array(',', '.', '  ', '   '), '', $post['originalPrice']),
                "sellingPrice" => str_replace(array(',', '.', '  ', '   '), '', $post['sellingPrice']),
                "content" => $post['contentDish'],
                "expectedTime" => 15,
                "isBestSelling" => 1,
                "isFavorite" => 1,
                "position" => $position,
                "thumbnailImage" => $post['thumbnailImage'],
                "imageDish" => $listImgs,
                "stock" => $post['stock'],
                "restaurantId" => $post['restaurantId'],
                "status" => $post['status'],
            ];

            $res = $this->menusModels->updateDishDetail($headers, $dataUpdate);
            if ($res->status == 200) {
                setcookie("__notiCate", 'success^_^Sửa món ăn thành công', time() + (60 * 5), '/');
                echo json_encode(array('success' => true, 'status' => $res->status, 'message' => 'Sửa món ăn thành công'));
                die;
            } else if ($res->status == 208) {
                echo json_encode(array('success' => false, 'status' => $res->status, 'message' => $res->message));
                die;
            } else {
                setcookie("__notiCate", 'false^_^' . $res->message, time() + (60 * 5), '/');
                echo json_encode(array('success' => false, 'status' => $res->status, 'message' => 'Sửa món ăn thất bại'));
                die;
            }
        }

        $data['dataUser'] = $dataUser;
        $data['title'] = 'Sửa món ăn';
        $data['view'] = 'App\Modules\MenusFood\Views\listMenus';
        return view('layoutKho/layout', $data);
    }
    public function getDetailDish()
    {
        $dataUser = $this->dataUserAuthen;
        $token = $dataUser->token;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];
        $post = $this->request->getPost();
        if (!empty($post)) {
            $idDish = $post['idDish'];
            $responseGetDetailDish = $this->menusModels->getDetailDish($headers, $idDish);
            if ($responseGetDetailDish->status == 200) {
                $detailDish = $responseGetDetailDish->data;

                $htmlImg = '';
                $imgArr = $detailDish->imageDish;
                if (!empty($imgArr)) {
                    foreach ($imgArr as $keyImg => $itemImg) {
                        $keyImgNew = $keyImg + 1;
                        $htmlImg .= '<div class="wrapImgAppend wrapImgAppend_' . $keyImgNew . '">';
                        $htmlImg .= '<span class="spanClose" onclick="removeImgAppend(' . $keyImgNew . ',1)">x</span>';
                        $htmlImg .= '<img class="imgAppend inputImgBs_' . $keyImgNew . '" src="' . URL_IMAGE_SHOW . $itemImg->imageDishPath . '" alt="">';
                        $htmlImg .= '<input type="hidden" class="inputImgBs inputImgValueBs_' . $keyImgNew . '" value="' . $itemImg->imageDishPath . '" name="inputImg[]">';
                        $htmlImg .= '</div>';
                    }
                }
                $countImg = count($imgArr);
                echo json_encode(array('success' => true, 'data' => $detailDish, 'htmlImg' => $htmlImg, 'countImg' => $countImg));
            } else {
                setcookie("__notiCate", 'false^_^Lấy chi tiết món ăn thất bại.', time() + (60 * 5), '/');
                echo json_encode(array('success' => false, 'data' => ''));
                die;
            }
        } else {
            setcookie("__notiCate", 'false^_^Lấy chi tiết món ăn thất bại.', time() + (60 * 5), '/');
            echo json_encode(array('success' => false, 'data' => ''));
            die;
        }
    }


    public function addNewDish()
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

            $imgArr = explode('|', $post['imageDish']);
            $listImgs = [];
            if (!empty($imgArr)) {
                foreach ($imgArr as $key => $itemProduct) {
                    $productDetail = new \stdClass;
                    $productDetail->imageDishPath = $itemProduct;
                    //Set Items Detail
                    $listImgs[$key] = $productDetail;
                }
            }
            if ($post['position'] == '') {
                $position = 1;
            } else {
                $position = $post['position'];
            }
            $dataAddNewDish = [
                "name" => $post['name'],
                "originalPrice" => str_replace(array(',', '.', '  ', '   '), '', $post['originalPrice']),
                "sellingPrice" => str_replace(array(',', '.', '  ', '   '), '', $post['sellingPrice']),
                "contentDish" => $post['contentDish'],
                "expectedTime" => 15,
                "isBestSelling" => 1,
                "isFavorite" => 1,
                "position" => $position,
                "thumbnailImage" => $post['thumbnailImage'],
                "imageDish" => $listImgs,
                "stock" => $post['stock'],
                "restaurantId" => $post['restaurantId'],
                "status" => $post['status'],
            ];
            $res = $this->menusModels->callApiAddNewDish($dataAddNewDish, $headers);

            if ($res->status == 200) {
                setcookie("__notiCate", 'success^_^Thêm mới món ăn thành công', time() + (60 * 5), '/');
                echo json_encode(array('success' => true, 'message' => 'Thêm mới món ăn thành công'));
                die;
            } else if ($res->status == 208) {
                echo json_encode(array('success' => false, 'status' => $res->status, 'message' => $res->message));
                die;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Thêm mới món ăn thất bại'));
                setcookie("__notiCate", 'false^_^' . $res->message, time() + (60 * 5), '/');
                die;
            }
        } else {
        }
    }

    public function changeTimeSale()
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

            $data = [
                "idRestaurant" => $post['id'],
                "timeOrderFrom" => $post['timeStart'],
                "timeOrderTo" => $post['timeEnd'],
            ];

            $res = $this->menusModels->callApiChangeTimeSale($data, $headers);

            if ($res->status == 200) {
                echo json_encode(array('success' => true, 'message' => 'Thay đổi thời gian mở bán thành công'));
                die;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Thay đổi thời gian mở bán thất bại'));
                die;
            }
        }
    }

    public function checkTimeOpening()
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

            $res = $this->menusModels->getOpeningTime($post['id'], $headers);
            if ($res->status == 200) {
                echo json_encode(array('success' => true, 'data' => $res));
                die;
            } else {
                echo json_encode(array('success' => false, 'data' => $res));
                die;
            }
        }
    }

    public function changeStatusDish()
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
            $idsArr = explode(',', $post['ids']);
            $ids = [];
            foreach ($idsArr as $key => $id) {
                $ids[$key] = $id;
            }
            $dataCallApi = [
                'status' => $post['statusChange'],
                'orderCode' => $ids
            ];
            $responseChangeStatusDish = $this->menusModels->changeStatusDish($headers, $dataCallApi);

            if ($responseChangeStatusDish->status == 200) {
                setcookie("__notiCate", 'success^_^Cập nhật trạng thái món ăn thành công', time() + (60 * 5), '/');
                echo json_encode(array('success' => true));
                die;
            } else {
                setcookie("__notiCate", 'false^_^Cập nhật trạng thái món ăn không thành công', time() + (60 * 5), '/');
                echo json_encode(array('success' => false));
                die;
            }
        }
    }
    public function changeStockDish()
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
            $dataCallApi = [
                'stock' => $post['stockDish'],
                'id' => $post['idDish']
            ];
            $responseChangeStockDish = $this->menusModels->changeStockDish($headers, $dataCallApi);

            if ($responseChangeStockDish->status == 200) {
                setcookie("__notiCate", 'success^_^Cập nhật số lượng món ăn thành công', time() + (60 * 5), '/');
                echo json_encode(array('success' => true));
                die;
            } else {
                setcookie("__notiCate", 'false^_^Cập nhật số lượng món ăn không thành công', time() + (60 * 5), '/');
                echo json_encode(array('success' => false));
                die;
            }
        }
    }
}
