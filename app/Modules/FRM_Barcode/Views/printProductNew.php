<link rel="stylesheet" href="<?= base_url('public/css/print75.css')?>">
<!-- Đơn nhỏ -->
<?php 
  
    $arrayUnit = [
        '0' => 'Gram',
        '1' => 'Kg',
    ];
    $weightUnit = '';
    if(isset($arrayUnit[$dataProduct['unit']])){
        $weightUnit = $arrayUnit[$dataProduct['unit']];
    }
        $productId = $dataProduct['productID'];
            $QRCode = base_url('generateQRCode?text=https://food.holaship.vn/?sanpham='.$productId.'&x=2&y=2');
?>

<div class="container wrap-print-product" style="page-break-after: always;">
    <div class="row wrapperPoduct">
        <div class="wrapperTitle">
            <p class="titleProduct"> <?php echo $dataProduct['productName']; ?> </p>
            <p class="titleSource"><?php echo $dataProduct['areaProduct']; ?></p>
        </div>
        <div class="qrCode">
            <?php if($QRCode != ''): ?>
            <img src="<?php echo $QRCode ?>" title="QRCode orderID" class="imgQR" />
            <?php endif; ?>
        </div>
    </div>
    <div class="row wrapperInfo">
        <div class="col-sm-6 colLeft">
            <p class="fz10">Số lô: <span class="valueProduct"><?php echo $dataProduct['soLo']; ?></span></p>
            <p class="fz10">Ngày ĐG: <span class="valueProduct"><?php echo $dataProduct['ndg']; ?></span></p>
            <p class="fz10">Bảo quản: <span class="valueProduct"><?php echo $dataProduct['baoQuan']; ?></span></p>
            <p class="fz10">HDSD: <span class="valueProduct"><?php echo $dataProduct['hsd']; ?></span></p>
        </div>
        <div class="col-sm-6 colRight">
            <p class="fz10">KL: <span class="valueProduct"><?php echo ($dataProduct['weight']) ? number_format($dataProduct['weight'],0,",",".") .' '. $weightUnit :''; ?></span></p>
            <p class="fz10 bdd10" style="line-height: 20px;">Giá: <?php echo ($dataProduct['price']) ? number_format($dataProduct['price']) .' đ': ''; ?><span class="valueProduct"> </span></p>
            <p class="fz10" style="line-height: 20px;">Thành tiền: <?php echo ($dataProduct['thanhTien']) ? number_format($dataProduct['thanhTien']) .' đ':''; ?><span class="valueProduct"></span></p>
        </div>
    </div>
</div>
<?php //} ?>