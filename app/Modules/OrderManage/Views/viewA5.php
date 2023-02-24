<link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
<style type="text/css">
    .footerExport {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        flex-wrap: wrap;
        flex-direction: column;
        align-content: flex-end;
        margin-top: 20px;
    }

    .table {
        display: block;
        max-width: 100%;
    }

    .textAlighEnd {
        text-align: end;
    }

    .textAlighCenter {
        text-align: center;
    }

    .textUper {
        text-transform: uppercase;
    }

    .logoImg {
        width: 110px;
        margin-left: 10%;
        margin-top: 5%;
    }

    .textHeader {
        text-align: center;
        margin-top: 2%;
    }

    .infoOrder {
        margin: 10px 0;
    }

    .infoAdd {
        margin-top: 10px;
    }

    .table {
        color: black !important;
    }

    #wrapper-print {
        color: black !important;
        margin: 20px 0;
    }

    #wrapper-print .container {
        max-width: 1030px !important;
        padding: 0;
    }

    .tableOrder {
        border: none;

    }
</style>
<!-- Đơn nhỏ -->
<?php

if ($type == 2) {
    $detailObject = $objects->detail;
    if (!empty($detailObject)) {
?>
        <div class="container wrap-print-product content-print" style="page-break-after: always;">
            <div class="headerExport">
                <div class="row">
                    <div class="col-2">
                        <img class="logoImg" src="<?php echo base_url('public/images/logoHolaFood.png'); ?>" alt="">
                    </div>
                    <div class="col-10 textHeader">
                        <h3 class="textUper">Phiếu xuất kho đơn hàng</h3>
                        <p><?php echo date('d/m/Y'); ?></p>
                    </div>
                </div>
                <div class="infoOrder">
                    <div class="row">
                        <div class="col-6">
                            <p>Người đặt hàng: <?php echo $objects->orderName ?></p>
                        </div>
                        <div class="col-6">
                            <p>Số điện thoại: <?php echo $objects->orderPhone ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p> <strong> Người nhận hàng: <?php echo $objects->receiverName ?></strong></p>
                        </div>
                        <div class="col-6">
                            <p> <strong> Số điện thoại: <?php echo $objects->receiverPhone ?></strong></p>
                        </div>
                    </div>
                    <div class="row infoAdd">
                        <div class="col-12">
                            <p>Địa chỉ người nhận:
                                <?php echo $objects->receiverAddress . ', ' . $objects->wardName . ', ' . $objects->districtName . ', ' . $objects->provinceName   ?>
                            </p>
                        </div>
                        <div class="col-12">
                            <p>Hình thức thanh toán: <?php echo $objects->paymentMethodName ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered tableOrder checkTable">
                <thead>
                    <tr class="text-center">
                        <th class="vertical" width="10%"><strong> STT</strong></th>
                        <th class="vertical" width="30%"><strong> Danh sách<br> đặt hàng</strong></th>
                        <th class="vertical" width="10%"><strong> Khối lượng <br> hàng đặt </strong></th>
                        <th class="vertical" width="10%"><strong> Mã vạch <br> sản phẩm</strong></th>
                        <th class="vertical" width="10%"><strong> Đơn giá <br> (VND)</strong></th>
                        <th class="vertical" width="10%"><strong> Khối lượng <br> thực tế </strong></th>
                        <th class="vertical" width="10%"><strong> Thành tiền <br> (VND)</strong></th>
                        <th class="vertical" width="10%"><strong> Ghi chú</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    foreach ($detailObject as $object) : ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $object->productName; ?></td>
                            <td class="textAlighEnd"><?php echo $object->weight . ' ' . $object->tempUnit; ?></td>
                            <td class="textAlighEnd">
                                <?php
                                $itemCodes = $object->itemCodes;
                                foreach ($itemCodes as $itemCode) {
                                    echo $itemCode . '<br>';
                                }
                                ?>
                            </td>
                            <td class="textAlighEnd"><?php echo ($object->price != 0) ? number_format($object->price) : '0'; ?></td>
                            <td class="textAlighEnd"><?php echo $object->tempWeight . ' ' . $object->tempUnit; ?></td>
                            <td class="textAlighEnd">
                                <?php echo ($object->totalMoney != 0) ? number_format($object->totalMoney) : '0'; ?></td>
                            <td></td>
                        </tr>
                        <?php
                        if (!empty($object->setProducts)) {
                            foreach ($object->setProducts as $key => $value) {
                                $i++;
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $value->productName; ?></td>
                                    <td class="textAlighEnd"><?php echo $value->weight . ' ' . $value->tempUnit; ?></td>
                                    <td class="textAlighEnd">
                                        <?php
                                        $itemCodes = $value->itemCodes;
                                        foreach ($itemCodes as $itemCode) {
                                            echo $itemCode . '<br>';
                                        }
                                        ?>
                                    </td>
                                    <td class="textAlighEnd"><?php echo ($value->price != 0) ? number_format($value->price) : '0'; ?></td>
                                    <td class="textAlighEnd"><?php echo $value->tempWeight . ' ' . $value->tempUnit; ?></td>
                                    <td class="textAlighEnd">0</td>
                                    <td></td>
                                </tr>
                        <?php  }
                        } ?>

                        <?php
                        if (!empty($object->promotionProducts)) {
                            foreach ($object->promotionProducts as $key => $value) {
                                $i++;
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $value->productName; ?></td>
                                    <td class="textAlighEnd"><?php echo $value->weight . ' ' . $value->tempUnit; ?></td>
                                    <td class="textAlighEnd">
                                        <?php
                                        $itemCodes = $value->itemCodes;
                                        foreach ($itemCodes as $itemCode) {
                                            echo $itemCode . '<br>';
                                        }
                                        ?>
                                    </td>
                                    <td class="textAlighEnd"><?php echo ($value->price != 0) ? number_format($value->price) : '0'; ?></td>
                                    <td class="textAlighEnd"><?php echo $value->tempWeight . ' ' . $value->tempUnit; ?></td>
                                    <td class="textAlighEnd">0</td>
                                    <td></td>
                                </tr>
                        <?php  }
                        } ?>
                    <?php $i++;
                    endforeach; ?>




                    <tr>
                        <td><?php echo $i; ?></td>
                        <td colspan="3" class="textAlighCenter">Thùng đóng gói
                            (<?php echo $objects->length . 'x' . $objects->width . 'x' . $objects->height ?>)</td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->boxPrice != 0) ? number_format($objects->boxPrice) : '0'; ?></td>
                        <td class="textAlighEnd"><?php echo ''; ?></td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->boxPrice != 0) ? number_format($objects->boxPrice) : '0';; ?></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $i += 1; ?></td>
                        <td colspan="3" class="textAlighCenter">Tiền giao hàng</td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->fee != 0) ? number_format($objects->fee) : '0'; ?></td>
                        <td class="textAlighEnd"><?php echo ''; ?></td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->fee != 0) ? number_format($objects->fee) : '0';; ?></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $i += 1; ?></td>
                        <td colspan="3" class="textAlighCenter">Tiền giảm giá</td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->discountMoney != 0) ? number_format($objects->discountMoney) : '0'; ?></td>
                        <td></td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->discountMoney != 0) ? number_format($objects->discountMoney) : '0';; ?></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $i += 1; ?></td>
                        <td colspan="5" class="textAlighCenter"><strong>Tổng tiền (VNĐ)</strong></td>
                        <td class="textAlighEnd"><strong>
                                <?php echo ($objects->total != 0) ? number_format($objects->total) : '0'; ?> </strong></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="footerExport">
                <p>Hà Nội, ngày <?php echo date('d') . ' tháng ' . date('m') . ' năm ' . date('Y') ?> </p>
                <p><strong> Người đóng hàng </strong></p>
            </div>
        </div>
    <?php
    }
} else { ?>
    <div class="container wrap-print-product content-print" style="page-break-after: always;">
        <div class="headerExport">
            <div class="row">
                <div class="col-2">
                    <img class="logoImg" src="<?php echo base_url('public/images/logoHolaFood.png'); ?>" alt="">
                </div>
                <div class="col-10 textHeader">
                    <h3 class="textUper">Phiếu in đơn đặt hàng</h3>
                </div>
            </div>
            <div class="infoOrder">
                <div class="row">
                    <div class="col-6">
                        <p>Người đặt hàng: <?php echo $objects->orderName ?></p>
                    </div>
                    <div class="col-6">
                        <p>Số điện thoại: <?php echo $objects->orderPhone ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p> <strong> Người nhận hàng: <?php echo $objects->receiverName ?></strong></p>
                    </div>
                    <div class="col-6">
                        <p> <strong> Số điện thoại: <?php echo $objects->receiverPhone ?></strong></p>
                    </div>
                </div>
                <div class="row infoAdd">
                    <div class="col-12">
                        <p>Địa chỉ người nhận:
                            <?php echo $objects->receiverAddress . ', ' . $objects->wardName . ', ' . $objects->districtName . ', ' . $objects->provinceName   ?>
                        </p>
                    </div>
                    <div class="col-12">
                        <p>Hình thức thanh toán: <?php echo $objects->paymentMethodName ?></p>
                    </div>
                </div>
            </div>

            <table class="table table-bordered tableOrder checkTable">
                <thead>
                    <tr class="text-center">
                        <th class="vertical" width="5%"><strong> STT</strong></th>
                        <th class="vertical" width="35%"><strong> Danh sách <br> đặt hàng</strong></th>
                        <th class="vertical" width="10%"><strong> Khối lượng <br> đóng gói </strong></th>
                        <th class="vertical" width="10%"><strong> Số lượng </strong></th>
                        <th class="vertical" width="15%"><strong> Đơn giá <br> (VND)</strong></th>
                        <th class="vertical" width="15%"><strong> Thành tiền <br> (VND)</strong></th>
                        <th class="vertical" width="20%"><strong> Ghi chú</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    $detailObject = $objects->orderDetails;
                    foreach ($detailObject as $object) :
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $object->productName; ?></td>
                            <td class="textAlighEnd">
                                <?php
                                if (!empty($object->setProducts))
                                    echo '1 Set';
                                else
                                    echo $object->weight . ' ' . $object->unit; ?>
                            </td>
                            <td><?php echo $object->quantity ?></td>
                            <td class="textAlighEnd"><?php echo ($object->price != 0) ? number_format($object->price) : '0'; ?>
                            </td>
                            <td class="textAlighEnd">
                                <?php echo ($object->toMoney != 0) ? number_format($object->toMoney) : '0'; ?></td>
                            <td></td>
                        </tr>
                        <?php

                        // Sản phẩm trong set (nếu có)
                        $setProducts = $object->setProducts;
                        if (!empty($setProducts)) {
                            foreach ($setProducts as $promotionProduct) :
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $promotionProduct->productName; ?></td>
                                    <td class="textAlighEnd"><?php echo $promotionProduct->weight . ' ' . $promotionProduct->unit; ?></td>
                                    <td><?php echo $promotionProduct->quantity ?></td>
                                    <td class="textAlighEnd"><?php echo number_format($promotionProduct->price) ?>
                                    </td>
                                    <td class="textAlighEnd"> 0</td>
                                    <td></td>
                                </tr>
                            <?php
                            endforeach;
                            $i++;
                        }

                        // Sản phẩm tặng kèm (nếu có)
                        $promotionProducts = $object->promotionProducts;
                        if (!empty($promotionProducts)) {
                            foreach ($promotionProducts as $promotionProduct) :
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $promotionProduct->productName; ?></td>
                                    <td class="textAlighEnd"><?php echo $promotionProduct->weight . ' ' . $promotionProduct->unit; ?></td>
                                    <td><?php echo $promotionProduct->quantity ?></td>
                                    <td class="textAlighEnd"><?php echo ($promotionProduct->price != 0) ? number_format($promotionProduct->price) : '0'; ?>
                                    </td>
                                    <td class="textAlighEnd">
                                        <?php echo ($promotionProduct->toMoney != 0) ? number_format($promotionProduct->toMoney) : '0'; ?></td>
                                    <td></td>
                                </tr>
                    <?php
                            endforeach;
                        }

                    endforeach;
                    ?>
                    <tr>
                        <td><?php echo $i += 1; ?></td>
                        <td colspan="3" class="textAlighCenter">Tiền giao hàng</td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->totalFee != 0) ? number_format($objects->totalFee) : '0'; ?></td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->totalFee != 0) ? number_format($objects->totalFee) : '0';; ?></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $i += 1; ?></td>
                        <td colspan="3" class="textAlighCenter">Tiền giảm giá</td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->promotionTotalOrder != 0) ? number_format($objects->promotionTotalOrder) : '0'; ?></td>
                        <td class="textAlighEnd">
                            <?php echo ($objects->promotionTotalOrder != 0) ? number_format($objects->promotionTotalOrder) : '0';; ?></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $i += 1; ?></td>
                        <td colspan="4" class="textAlighCenter"><strong>Tổng tiền (VNĐ)</strong></td>
                        <td class="textAlighEnd"><strong>
                                <?php echo ($objects->totalPayment != 0) ? number_format($objects->totalPayment) : '0'; ?> </strong></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="footerExport">
                <p>Hà Nội, ngày <?php echo date('d') . ' tháng ' . date('m') . ' năm ' . date('Y') ?> </p>
                <p><strong> Người đóng hàng </strong></p>
            </div>
        </div>
    </div>

<?php } ?>