<?php

namespace App\Modules\FRM_Barcode\Controllers;

use App\Libraries\QRCode;
use App\Libraries\generateBarcode;
use stdClass;

class Barcode extends BaseController
{
    public function printProduct()
    {
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $post = $this->request->getPost();
        if (!empty($post)) {
            $orderId = $post['orderId'];
            $checkOrder = new stdClass;
            $checkOrder->status = 200;
            if ($checkOrder->status == 200) {
                $printUrl = base_url('/trang-trai/previewPrint/' . $orderId);
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Thành công',
                        'printUrl' => $printUrl
                    )
                );
                die;
            } else {
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => $checkOrder->message,
                    )
                );
                die;
            }
        }
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\FRM_Barcode\Views\scanBarcodeProduct';
        return view('layoutKho/layout', $data);
    }
    public function previewPrint($productId = '')
    {
        $data['view'] = 'App\Modules\FRM_Barcode\Views\printProduct';
        return view('layoutPrint/layoutPrintProduct', $data);
    }
    public function generateQRCode()
    {
        $x = (isset($_GET["x"])     ? $_GET["x"] : "1");
        $y = (isset($_GET["y"])     ? $_GET["y"] : "1");
        $this->generateBarcode            = new QRCode();
        $text           = (isset($_GET["text"])         ? $_GET["text"] : "0");
        $qr = QRCode::getMinimumQRCode($text, QR_ERROR_CORRECT_LEVEL_L);
        $barCode = $qr->createImage($x, 1);
        header("Content-type: image/gif");
        imagegif($barCode);

        imagedestroy($barCode);
        return $barCode;
    }
    public function generateBarcode()
    {
        $this->generateBarcode            = new generateBarcode();
        $text           = (isset($_GET["text"])         ? $_GET["text"] : "0");
        $size           = (isset($_GET["size"])         ? $_GET["size"] : "20");
        $sizefactor     = (isset($_GET["sizefactor"])   ? $_GET["sizefactor"] : "1");
        $barCode        = $this->generateBarcode->barcode($filepath = "", $text, $size, $orientation = "horizontal", $code_type = "code128", $print = false, $sizefactor);

        return $barCode;
    }
    public function printProductNew()
    {
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $post = $this->request->getPost();
        if (!empty($post)) {
            $productID = date('ymd', time()) . random_int(100000, 999999);
            $productName = $post['productName'];
            $areaProduct = $post['areaProduct'];
            $soLo = $post['soLo'];
            $baoQuan = $post['baoQuan'];
            $ndg = $post['ndg'];
            $hsd = $post['bqcd'];
            $weight = $post['weight'];
            $price = $post['price'];
            $thanhTien = $post['thanhTien'];
            $unit = $post['unit'];
            $viTri = $post['viTri'];
            $ngt = $post['ngt'];
            $nth = $post['nth'];


            $dataInsert['PRODUCT_NAME'] = $productName;
            $dataInsert['AREA_PRODUCT'] = $areaProduct;
            $dataInsert['VI_TRI'] = $viTri;
            $dataInsert['NGAY_THU_HOACH'] = $nth;
            $dataInsert['NGAY_GIEO_TRONG'] = $ngt;
            $dataInsert['NGAY_DONG_GOI'] = $ndg;
            $dataInsert['HAN_SU_DUNG'] = $hsd;
            $dataInsert['SO_LO'] = $soLo;
            $dataInsert['KHOI_LUONG'] = $weight;
            $dataInsert['GIA_TIEN'] = $price;
            $dataInsert['THANH_TIEN'] = $thanhTien;
            $dataInsert['BAO_QUAN'] = $baoQuan;
            $dataInsert['DON_VI_TINH'] = $unit;
            $dataInsert['PRODUCT_ID'] = $productID;
            $insertProductShow = $this->barcodeModels->insertProductShow($dataInsert);

            $checkOrder = new stdClass;
            $checkOrder->status = 200;
            if ($checkOrder->status == 200) {
                $printUrl = base_url('/trang-trai/previewPrintProduct?productName=' . $productName . '&areaProduct=' . $areaProduct . '&soLo=' . $soLo . '&baoQuan=' . $baoQuan . '&ndg=' . $ndg . '&hsd=' . $hsd . '&weight=' . $weight . '&price=' . $price . '&thanhTien=' . $thanhTien . '&unit=' . $unit . '&productID=' . $productID);
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Thành công',
                        'printUrl' => $printUrl
                    )
                );
                die;
            } else {
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => $checkOrder->message,
                    )
                );
                die;
            }
        }
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\FRM_Barcode\Views\barcodeProductNew';
        return view('layoutKho/layout', $data);
    }
    public function previewPrintProduct()
    {
        $get = $this->request->getGet();
        $data['dataProduct'] = [];
        if (!empty($get)) {
            $data['dataProduct'] = $get;
        }
        $data['view'] = 'App\Modules\FRM_Barcode\Views\printProductNew';
        return view('layoutPrint/layoutPrintProduct', $data);
    }

    public function printBarcodeNew()
    {
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $post = $this->request->getPost();
        if (!empty($post)) {
            $this->validation->setRules([
                'productName' => [
                    'label' => 'Tên tem',
                    'rules' => 'required',
                    'errors' => []
                ]
            ]);

            if (!$this->validation->withRequest($this->request)->run()) {
                $getErrors = $this->validation->getErrors();
                $data['post'] = $post;
                $data['getErrors'] = $getErrors;
                $data['dataUser'] = $dataUser;
                $data['view'] = 'App\Modules\FRM_Barcode\Views\printBarcodeNew';
                return view('layoutKho/layout', $data);
            } else {
                $productId = $post['productID'];
                $dataInsert['PRODUCT_NAME'] = $post['productName'];
                $dataInsert['AREA_PRODUCT'] = $post['areaProduct'];
                $dataInsert['HAN_SU_DUNG'] = $post['hsd'];
                $dataInsert['THONG_TIN_SAN_PHAM'] = $post['infoProduct'];
                $dataInsert['HUONG_DAN_SU_DUNG'] = $post['hdsd'];
                $dataInsert['BAO_QUAN'] = $post['baoQuan'];
                $dataInsert['TYPE_PRODUCT'] = 1;
                if($productId == ''){
                    $insertProductShow = $this->barcodeModels->insertProductShow($dataInsert);
                }else{
                    $insertProductShow = $this->barcodeModels->updateProductShow($dataInsert,$productId);
                }
                if ($insertProductShow) {
                    if($productId == ''){
                        setcookie("__barcode", 'success^_^Tạo thành công', time() + (60 * 5), '/');
                    }else{
                        setcookie("__barcode", 'success^_^Cập nhật thành công', time() + (60 * 5), '/');
                    }
                } else {
                    if($productId == ''){
                        setcookie("__barcode", 'success^_^Tạo không thành công', time() + (60 * 5), '/');
                    }else{
                        setcookie("__barcode", 'success^_^Cập nhật không thành công', time() + (60 * 5), '/');
                    }
                }
                return redirect()->to('/trang-trai/in-tem-mau-moi');
            }
        }

        $listObject = $this->barcodeModels->getListProductShow();
        $data['listObject'] = $listObject;
        $data['dataUser'] = $dataUser;
        $data['view'] = 'App\Modules\FRM_Barcode\Views\printBarcodeNew';
        return view('layoutKho/layout', $data);
    }
    public function getDetailProduct(){
        $post = $this->request->getPost();
        if(!empty($post)){
            $idBarCodeNew = $post['idBarCodeNew'];
            $dataItem = $this->barcodeModels->getDetailItem($idBarCodeNew);
            if(!empty($dataItem)){
                echo json_encode(
                    array(
                        'success' => true,
                        'data' => $dataItem,
                    )
                );
                die;
            }else{
                echo json_encode(
                    array(
                        'success' => false,
                        'data' => '',
                    )
                );
                die;
            }
        }else{
            echo json_encode(
                array(
                    'success' => false,
                    'data' => '',
                )
            );
            die;
        }
    }

    public function previewPrintBarCodeNew()
    {
        $get = $this->request->getGet();
        $data['object'] = [];
        if (!empty($get)) {
            $idBarCodeNew = $get['idBarCodeNew'];
            $dataItem = $this->barcodeModels->getDetailItem($idBarCodeNew);
            // echo '<pre>';
            // print_r($dataItem);die;
            $data['object'] = $dataItem;
        }
        $data['view'] = 'App\Modules\FRM_Barcode\Views\previewBarcodeNew';
        return view('layoutPrint/layoutPrintProduct', $data);
    }
}
