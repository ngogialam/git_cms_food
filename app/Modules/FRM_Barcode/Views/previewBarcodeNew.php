<link rel="stylesheet" href="<?= base_url('public/css/print75.css')?>">
<!-- Đơn nhỏ -->

<div class="container wrap-print-product" style="page-break-after: always;">
    <div class="row wrapperInfo" >
        <div class="col-sm-12 colLeft">
            <ul style="padding-left:15px;margin:0px">
                <li class="productNameTitle"><strong><?php echo ' '. $object['PRODUCT_NAME']; ?></strong></li>
                <li><strong>Nguồn gốc xuất xứ:</strong> <?php echo $object['AREA_PRODUCT'] ?></li>
                <li style="list-style-type:none"> <?php echo $object['THONG_TIN_SAN_PHAM'] ?></li>
                <li><strong>HDSD:</strong> <?php echo $object['HUONG_DAN_SU_DUNG'] ?></li>
                <li><strong>Bảo quản:</strong> <?php echo $object['BAO_QUAN'] ?></li>
                <li><strong>Ngày SX/HSD (PRD&EXP):</strong> <?php echo $object['HAN_SU_DUNG'] ?></li>
            </ul>
        </div>
    </div>
</div>
<?php //} ?>