<link rel="stylesheet" href="<?= base_url('public/css/print75.css')?>">
<!-- Đơn nhỏ -->
<?php 
  
    // $i = 0;
    // foreach($dataOrder as $order){
    // $i++;
    // $ORDER_ID = $order->orderDetailCode; 
    // $barCode = '';
    // $QRCode = '';
    //     if ($ORDER_ID != '') {
            $QRCode = base_url('generateQRCode?text=https://food.holaship.vn/?sanpham=211231000001&x=2&y=2');
    //     }
?>

<div class="container wrap-print-product" style="page-break-after: always;">
    <div class="row wrapperPoduct">
        <div class="wrapperTitle">
            <p class="titleProduct"> Thịt lợn rừng </p>
            <p class="titleSource">holafarm - Tự nhiên</p>
        </div>
        <div class="qrCode">
            <?php if($QRCode != ''): ?>
            <img src="<?php echo $QRCode ?>" title="QRCode orderID" class="imgQR" />
            <?php endif; ?>
        </div>
    </div>
    <div class="row wrapperInfo">
        <div class="col-sm-6 colLeft">
            <p class="fz10">Số lô: <span class="valueProduct">20122021-001</span></p>
            <p class="fz10">Ngày ĐG: <span class="valueProduct">27/12/2021 </span></p>
            <p class="fz10">Bảo quản tươi: <span class="valueProduct">từ 2 - 5 độ C </span></p>
            <p class="fz10">Bảo quản cấp đông: <span class="valueProduct">30/12/2021 </span></p>
        </div>
        <div class="col-sm-6 colRight">
            <p class="fz10">KL: <span class="valueProduct"></span></p>
            <p class="fz10 bdd10" style="line-height: 20px;">Giá: <span class="valueProduct"> </span></p>
            <p class="fz10" style="line-height: 20px;">Thành tiền: <span class="valueProduct"></span></p>
        </div>
    </div>
</div>
<?php //} ?>