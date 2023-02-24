<?php

namespace App\Modules\MenusFood\Controllers;

class OrderDish extends BaseController
{

    public function listOrderMenuFood($page = 1)
    {
        $dataUser = $this->dataUserAuthen;

        $page                     = ($this->page) ? $this->page : 1;
        $data['page']             = $page;
        $data['pageStatistic']             = 1;
        $data['perPage']         = PERPAGE;
        $data['perPageStatistic']         = 5;
        $data['pager']             = $this->pager;
        $data['total']             = 0;
        $data['uri'] = $this->uri;
        $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
        $conditions['LIMIT']  = $data['perPage'];
        $dataCall = [
            'keyword' => '',
            'status' => 0,
            'from' => "",
            'to' => "",
            'page' => $page,
            'restaurantId' => 0,
            'partnerId' => 0,
            'size' => PERPAGE
        ];
        $dataCallStatistic = [
            'keyword' => '',
            'status' => 0,
            'from' => "",
            'to' => "",
            'page' => $page,
            'restaurantId' => 0,
            'partnerId' => 0,
            'size' => 5
        ];
        $get = $this->request->getGet();
        if (!empty($get)) {
            $dataCall = [
                'keyword' => $get['keyWord'],
                'status' => $get['status'],
                'from' => $get['started'],
                'to' => $get['stoped'],
                'page' => $page,
                'restaurantId' => $get['restaurantId'],
                'partnerId' => $get['partnerId'],
                'size' => PERPAGE
            ];
        }
        $token = $dataUser->token;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];

        $resultObjects = $this->menusModels->getHistoryDishOrder($headers, $dataCall);
        $objects = [];
        $listStatistic = [];
        $total = 0;
        $totalStatistic = 0;
        if ($resultObjects->status == 200) {
            $objects = $resultObjects->data->historyList;
            $total = $resultObjects->data->totalRecords;
        }
        $resultStatistic = $this->menusModels->getStatisticDishOrder($headers, $dataCall);
        if ($resultStatistic->status == 200) {
            $listStatistic = $resultStatistic->data;
            $totalStatistic = count($listStatistic);
        }
        $listStatus = [];
        $resultListStatus = $this->menusModels->getListStatus($headers);
        if ($resultListStatus->status == 200) {
            $listStatus = $resultListStatus->data->statusList;
        }

        $listRestaurant = [];
        $resultListRestaurant = $this->menusModels->getListRestaurant($headers);

        if ($resultListRestaurant->status == 200) {
            $listRestaurant = $resultListRestaurant->data;
        }
        $listPartner = [];
        $resultListPartner = $this->menusModels->getListPartner($headers);
        if ($resultListPartner->status == 200) {
            $listPartner = $resultListPartner->data;
        }

        $data['total'] = $total;
        $data['get'] = $get;
        $data['totalStatistic'] = $totalStatistic;
        $data['listStatus'] = $listStatus;
        $data['listRestaurant'] = $listRestaurant;
        $data['listStatistic'] = $listStatistic;
        $data['listPartner'] = $listPartner;
        $data['objects'] = $objects;
        $data['conditions'] = $conditions;
        $data['dataUser'] = $dataUser;
        $data['title'] = 'Danh sách đơn hàng';
        $data['view'] = 'App\Modules\MenusFood\Views\listOrderFood';
        return view('layoutKho/layout', $data);
    }

    public function listStatistic($page = 1)
    {

        $dataUser = $this->dataUserAuthen;

        $page                     = ($this->page) ? $this->page : 1;
        $data['page']             = $page;
        $data['perPage']         = PERPAGE;
        $data['pager']             = $this->pager;
        $data['total']             = 0;
        $data['uri'] = $this->uri;
        $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
        $conditions['LIMIT']  = $data['perPage'];
        $dataCall = [
            'keyword' => '',
            'status' => 0,
            'from' => "",
            'to' => "",
            'page' => $page,
            'restaurantId' => 0,
            'partnerId' => 0,
            'size' => PERPAGE
        ];

        $get = $this->request->getGet();
        if (!empty($get)) {
            $dataCall = [
                'keyword' => $get['keyWord'],
                'status' => $get['status'],
                'from' => $get['started'],
                'to' => $get['stoped'],
                'page' => $page,
                'restaurantId' => $get['restaurantId'],
                'partnerId' => $get['partnerId'],
                'size' => PERPAGE
            ];
        }
        $token = $dataUser->token;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];

        $listStatistic = [];
        $total = 0;
        $totalStatistic = 0;
        $resultStatistic = $this->menusModels->getStatisticDishOrder($headers, $dataCall);
        if ($resultStatistic->status == 200) {
            $listStatistic = $resultStatistic->data;
            $totalStatistic = count($listStatistic);
        }
        $listStatus = [];
        $resultListStatus = $this->menusModels->getListStatus($headers);
        if ($resultListStatus->status == 200) {
            $listStatus = $resultListStatus->data->statusList;
        }

        $listRestaurant = [];
        $resultListRestaurant = $this->menusModels->getListRestaurant($headers);

        if ($resultListRestaurant->status == 200) {
            $listRestaurant = $resultListRestaurant->data;
        }
        $listPartner = [];
        $resultListPartner = $this->menusModels->getListPartner($headers);
        if ($resultListPartner->status == 200) {
            $listPartner = $resultListPartner->data;
        }

        $data['total'] = $total;
        $data['get'] = $get;
        $data['totalStatistic'] = $totalStatistic;
        $data['listStatus'] = $listStatus;
        $data['listRestaurant'] = $listRestaurant;
        $data['listStatistic'] = $listStatistic;
        $data['listPartner'] = $listPartner;
        $data['conditions'] = $conditions;
        $data['dataUser'] = $dataUser;
        $data['title'] = 'Tổng hợp đơn đặt hàng';
        $data['view'] = 'App\Modules\MenusFood\Views\listStatistic';
        return view('layoutKho/layout', $data);
    }
    public function changeStatusDishOrder()
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

            $ids = $post['ids'];
            $typeDish = $post['typeDish'];
            $idArr = explode(',', $ids);
            $listOLrder = [];
            foreach ($idArr as $key => $itemProduct) {
                $productDetail = new \stdClass;
                $productDetail->orderCode = $itemProduct;
                //Set Items Detail
                $listOLrder[$key] = $productDetail;
            }
            $dataUpdate = [
                'status' => $typeDish,
                'orders' => $listOLrder
            ];
            $responseChangeStatus = $this->menusModels->changeStatusOrder($headers, $dataUpdate);
            if ($responseChangeStatus->status == 200) {
                setcookie("__changeStatus", 'success^_^Cập nhật thành công', time() + (60 * 5), '/');
            } else {
                setcookie("__changeStatus", 'false^_^' . $responseChangeStatus->message, time() + (60 * 5), '/');
            }
            echo json_encode(
                array(
                    'success' => true,
                    'data' => '',
                )
            );
            die;
        }
    }
    public function exportExcelListOrders()
    {
        $post = $this->request->getPost();
        if (!empty($post)) {
            $dataUser = $this->dataUserAuthen;
            $dataCall = [
                'keyword' => $post['nameDish'],
                'status' => $post['statusOrder'],
                'from' => $post['started'],
                'to' => $post['stoped'],
                'page' => 1,
                'restaurantId' => $post['restaurantId'],
                'partnerId' => $post['partnerId'],
                'size' => 10000
            ];
            $token = $dataUser->token;
            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: ' . $token,
            ];

            $reponseDataExcel = $this->menusModels->exportExcel($headers, $dataCall);
            if ($reponseDataExcel['status'] == 200) {
                $fileName = 'Danh sách đơn hàng' . $post['started'] . '_' . $post['stoped'];
                $response =  array(
                    'href' => base_url('/mon-an/danh-sach-don-hang-food'),
                    'name' => $fileName,
                    'status' => '200',
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($reponseDataExcel['data'])
                );
                $this->logger->info('Kết thúc xuất EXCEL');
                die(json_encode($response));
            }
        }
    }
    // lay danh sach nguoi dung 
    public function listAccount($page = 1)
    {
        $dataUser = $this->dataUserAuthen;
        $token = $dataUser->token;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];

        //paginate       
        $page                     = ($this->page) ? $this->page : 1;
        $data['page']             = $page;
        $data['perPage']         = PERPAGE;
        $data['pager']             = $this->pager;
        $data['total']             = 0;
        $data['uri'] = $this->uri;
        $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
        $conditions['LIMIT']  = $data['perPage'];
        $dataCallApi = [
            'page' => $page,
            'find' => '',
            'idPartner' => '',
            'size' => PERPAGE,
        ];
        $get = $this->request->getGet();
        if (!empty($get)) {
            $dataCallApi = [
                'find' =>  $get['find'],
                'page' => $page,
                'idPartner' => $get['idPartner'],
                'size' => PERPAGE,
            ];
        }
        //listPartner
        $listPartner = $this->menusModels->callApiGetListPartner($headers);
        if (!empty($listPartner) && $listPartner->status === 200) {
            $data['listPartner'] = $listPartner->data->partnerList;
        } else {
            $data['listPartner'] = [];
        }
        // list Auto
        $listAuto = $this->menusModels->getAutoComplete($headers);

        if (!empty($listAuto) && $listAuto->status === 200) {
            $data['listAuto'] = $listAuto->data->userList;
        } else {
            $data['listAuto'] = [];
        }
        // print_r($listPartner);
        // die;
        $getTotal = 0;
        $res = $this->menusModels->callApiGetUserListPartner($dataCallApi, $headers);

        if (!empty($res) && $res->status === 200) {
            $getTotal = $res->data->totalRecord;
            $data['listUser'] = $res->data->dataList;
        } else {
            $data['listUser'] = [];
        }

        $data['total'] = $getTotal;
        $data['dataUser'] = $dataUser;
        $data['get'] = $get;
        $data['title'] = 'Danh sách tài khoản đối tác';
        $data['view'] = 'App\Modules\MenusFood\Views\listAccount';
        return view('layoutKho/layout', $data);
    }
    // them moi tai khoan doi tac
    public function addAccount()
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

            $dataAddAccount = [
                "idPartner" => $post['idPartner'],
                "userPhone" => $post['userPhone'],
                "status" => $post['status'],
            ];

            $res = $this->menusModels->callApiAddAccount($dataAddAccount, $headers);
            if ($res->status == 200) {
                setcookie("__notiCate", 'success^_^Thêm tài khoản đối tác thành công', time() + (10), '/');
                echo json_encode(array('success' => true, 'message' => 'Thêm tài khoản đối tác thành công'));
                die;
            } else if ($res->status == 208) {
                echo json_encode(array('success' => false, 'status' => $res->status, 'message' => $res->message));
                die;
            } else if ($res->status == 400) {
                echo json_encode(array('success' => false, 'status' => $res->status, 'message' => $res->message, 'data' => $res->data));
                die;
            } else if ($res->status == 405) {
                echo json_encode(array('success' => false, 'status' => $res->status, 'message' => $res->message, 'data' => $res->data));
                die;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Thêm tài khoản đối tác thất bại'));
                setcookie("__notiCate", 'false^_^' . $res->message, time() + (10), '/');
                die;
            }
        } else {
        }
    }
    // chinh sua tai khoan doi tac
    public function editAccount()
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

            $dataEditAccount = [
                "partnerId" => (int)$post['partnerId'],
                "mapperId" => (int)$post['mapperId'],
            ];
            $res = $this->menusModels->editAccount($dataEditAccount, $headers);
            if ($res->status == 200) {
                setcookie("__notiCate", 'success^_^Thay thế khoản đối tác thành công', time() + (10), '/');
                echo json_encode(array('success' => true, 'message' => 'Thay thế tài khoản đối tác thành công'));
                die;
            } else if ($res->status == 208) {
                echo json_encode(array('success' => false, 'status' => $res->status, 'message' => $res->message));
                die;
            } else if ($res->status == 400) {
                echo json_encode(array('success' => false, 'status' => $res->status, 'message' => $res->message));
                die;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Thay thế khoản đối tác thất bại'));
                setcookie("__notiCate", 'false^_^' . $res->message, time() + (10), '/');
                die;
            }
        } else {
        }
    }
    // xoa doi tac
    public function deletePartner()
    {
        $post = $this->request->getPost();
        if (!empty($post)) {
            $dataCallApi = [
                'mapperId' => (int)$post['mapperId']
            ];

            $dataUser = $this->dataUserAuthen;
            $token = $dataUser->token;
            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: ' . $token,
            ];
            $delete = $this->menusModels->deletePartner($dataCallApi, $headers);

            if ($delete->status == 200) {
                setcookie("__notiCate", 'success^_^Xóa tài khoản đối tác thành công', time() + (60 * 5), '/');
                echo json_encode(array('success' => true, 'message' => 'Xóa tài khoản đối tác thành công'));
                die;
            } else if ($delete->status == 208) {
                echo json_encode(array('success' => false, 'status' => $delete->status, 'message' => $delete->message));
                die;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Xóa tài khoản đối tác thất bại'));
                setcookie("__notiCate", 'false^_^' . $delete->message, time() + (60 * 5), '/');
                die;
            }
        } else {
        }
    }
    // check sdt hop le
    public function checkPhone()
    {
        $dataUser = $this->dataUserAuthen;
        $token = $dataUser->token;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];
        // $get = $this->request->getGet();
        // if (!empty($get)) {
        //     $dataCallApi = [
        //         'phone' => $get['phone']
        //     ];
        // }
        // $res = $this->menusModels->getAutoComplete($headers);

        // if (!empty($res) && $res->status === 200) {
        //     $data['listAuto'] = $res->data->userList;
        // } else {
        //     $data['listAuto'] = [];
        // }
    }
}
