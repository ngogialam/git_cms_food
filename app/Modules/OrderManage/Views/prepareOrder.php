<!-- partial:partials/_navbar.html -->

<link rel="stylesheet" href="<?= base_url('public/css/order.css') ?>">
<?php
$requestUri = explode("/", $_SERVER['REQUEST_URI'])[2];
$link_active = explode("?", $requestUri)[0];
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3 class="card-content-title"><?= $title ?></h3>
                <section id="order-detail" class="row notifacation-wrapper">
                    <?php
                    $checkNoti = get_cookie('__order');
                    $checkNoti = explode('^_^', $checkNoti);
                    setcookie("__order", '', time() + (1), '/');
                    ?>
                    <div class="notification-container" id="notification-container">
                        <div class=" notificationMessage
                                        <?php
                                        if ($checkNoti[0] == 'success') {
                                            echo 'notification notification-info';
                                        } else if ($checkNoti[0] == 'false') {
                                            echo 'notification notification-danger';
                                        }
                                        ?>
                                        ">
                            <?php
                            if ($checkNoti[0] == 'success') {
                                if (!empty($checkNoti[2])) {
                                    echo $checkNoti[2];
                                } else {
                                    echo $checkNoti[1];
                                }
                            } else if ($checkNoti[0] == 'false') {
                                if (!empty($checkNoti[2])) {
                                    echo $checkNoti[2];
                                } else {
                                    echo $checkNoti[1];
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <!--Chi tiết đơn hàng -->
                    <div class="order-detail-left col-12 ">
                        <div class="row order-detail-bd-title">
                            <div class="code-orders-detail col-7">
                                <div id="orders" class="jn-if-left-tt">
                                    <span>Mã sản phẩm: </span>
                                    <b class="code-order-detail">
                                        <?php
                                        echo $dataDetailOrder->orderCode;
                                        ?>
                                    </b>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin hàng hoá -->
                        <div class="info-order-detail">
                            <div class="info-order-detail-1 pst-rlt">
                                <div>
                                    <b>Thông tin đơn hàng</b>
                                </div>
                                <div class="info-order-detail-2">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="15%" class="pro-title"> <span class="pl-3">Sản phẩm </span>
                                                </th>
                                                <th width="15%" class="pro-packing"> Đóng gói </th>
                                                <th width="15%" class="pro-price">Giá / khối lượng</th>

                                                <th width="15%" class="pro-quantity">Số lượng</th>
                                                <?php
                                                $arrPrepare = ['100', '1002', '1003'];
                                                if (!in_array($dataDetailOrder->status, $arrPrepare)) :
                                                ?>
                                                    <th width="15%" class="pro-quantity">Khối lượng tịnh</th>

                                                <?php endif; ?>
                                                <th width="15%" class="pro-subtotal">Thành tiền</th>

                                            </tr>
                                        </thead>
                                        <tbody class="appendNewProductTable">
                                            <?php if ($dataDetailOrder->orderDetails != '') {
                                                foreach ($dataDetailOrder->orderDetails as $keyProduct => $historyDetail) {
                                                    $priceProduct = $historyDetail->prices;
                                                    $promotionProducts = $historyDetail->promotionProducts;
                                                    $setProducts = $historyDetail->setProducts;
                                            ?>
                                                    <tr keyMain="<?php echo $keyProduct; ?>" class=" productMainId-<?php echo $historyDetail->productID ?> productMainId-<?php echo $historyDetail->productID . '-' . $historyDetail->priceId ?> productId-<?php echo $historyDetail->productID . '-' . $historyDetail->priceId ?>">
                                                        <td class="pro-title">
                                                            <img class="img-fluid" src="<?= $historyDetail->productImage ?>" alt="Product">
                                                            <?= $historyDetail->productName ?>

                                                        </td>
                                                        <td class="pro-packing">

                                                            <span class="">
                                                                <?php
                                                                if (!empty($setProducts))
                                                                    echo '1 Set';
                                                                else
                                                                    echo $historyDetail->weight . ' ' . $historyDetail->unit;

                                                                ?>
                                                            </span>
                                                        </td>
                                                        <td class="pro-price">
                                                            <span class="priceWeight-<?php echo $keyProduct; ?>">
                                                                <span><?= number_format($historyDetail->price, 0) ?></span>
                                                                đ/
                                                                <span><?= $historyDetail->weight >= 1000 ? $historyDetail->weight : $historyDetail->weight ?>
                                                                    <?= $historyDetail->unit ?>
                                                                </span>
                                                        </td>

                                                        <td class="pro-quantity">
                                                            <span><?= number_format($historyDetail->quantity, 0) ?></span>
                                                        </td>
                                                        <?php
                                                        $arrPrepare = ['100', '1002', '1003'];
                                                        if (!in_array($dataDetailOrder->status, $arrPrepare)) :
                                                        ?>
                                                            <td>
                                                                <span><?= $historyDetail->realWeight  ?>
                                                                    <?= $historyDetail->realWeight ?>
                                                            </td>

                                                        <?php endif; ?>
                                                        <td class="pro-subtotal">
                                                            <span class="price-<?php echo $keyProduct; ?>"><?= number_format($historyDetail->toMoney, 0) ?></span>
                                                            đ
                                                        </td>
                                                        <?php
                                                        $arrEdit = ['1002', '1003'];
                                                        if (in_array($dataDetailOrder->status, $arrEdit)) :
                                                        ?>
                                                            <td>
                                                                <?php if ($historyDetail->type == 1) { ?>
                                                                    <button type="button" class="btn btn-danger removeProductPlus" onclick="removeProduct('<?php echo $historyDetail->productID . '-' . $historyDetail->priceId ?>')">
                                                                        <span><i class="mdi mdi-minus-circle-outline"></i></span>
                                                                    </button>
                                                                <?php } ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>

                                                    <!-- Sản phẩm trong set (nếu có) -->
                                                    <?php
                                                    if (!empty($setProducts)) :
                                                        foreach ($setProducts as $promotion) :
                                                    ?>
                                                            <tr class=" promotion promotion-<?php echo $historyDetail->productID ?> productId-<?php echo $historyDetail->productID . '-' . $historyDetail->priceId ?>">
                                                                <td class="pro-title">
                                                                    <img class="img-fluid" src="<?= $promotion->productImage ?>" alt="Product">
                                                                    <?= $promotion->productName ?>
                                                                </td>
                                                                <td class="pro-packing">

                                                                    <span class=""><?= $promotion->weight >= 1000 ? $promotion->weight : $promotion->weight ?>
                                                                    </span>
                                                                    <?= $promotion->unit ?>
                                                                </td>
                                                                <td class="pro-price">
                                                                    <span><?= number_format($promotion->price, 0) ?></span>
                                                                    đ/
                                                                    <span><?= $promotion->weight >= 1000 ? $promotion->weight : $promotion->weight ?>
                                                                        <?= $promotion->unit ?>
                                                                </td>

                                                                <td class="pro-quantity">
                                                                    <span><?= number_format($promotion->quantity, 0) ?></span>
                                                                </td>
                                                                <?php
                                                                $arrPrepare = ['100', '1002', '1003'];
                                                                if (!in_array($dataDetailOrder->status, $arrPrepare)) :
                                                                ?>
                                                                    <td>
                                                                        <span><?= $promotion->realWeight ?>
                                                                            <?= $promotion->unit ?>
                                                                    </td>

                                                                <?php endif;
                                                                $countTotalItem += $promotion->quantity; ?>
                                                                <td class="pro-subtotal">
                                                                    <span>0 </span> đ
                                                                </td>

                                                            </tr>
                                                    <?php endforeach;
                                                    endif; ?>

                                                    <?php
                                                    if (!empty($promotionProducts)) :
                                                        foreach ($promotionProducts as $promotion) :
                                                    ?>
                                                            <tr class=" promotion promotion-<?php echo $historyDetail->productID ?> productId-<?php echo $historyDetail->productID . '-' . $historyDetail->priceId ?>">
                                                                <td class="pro-title">
                                                                    <img class="img-fluid" src="<?= $promotion->productImage ?>" alt="Product">
                                                                    <?= $promotion->productName ?>
                                                                </td>
                                                                <td class="pro-packing">

                                                                    <span class=""><?= $promotion->weight >= 1000 ? $promotion->weight : $promotion->weight ?>
                                                                    </span>
                                                                    <?= $promotion->unit ?>
                                                                </td>
                                                                <td class="pro-price">
                                                                    <span><?= number_format($promotion->price, 0) ?></span>
                                                                    đ/
                                                                    <span><?= $promotion->weight >= 1000 ? $promotion->weight : $promotion->weight ?>
                                                                        <?= $promotion->unit ?>
                                                                </td>

                                                                <td class="pro-quantity">
                                                                    <span><?= number_format($promotion->quantity, 0) ?></span>
                                                                </td>
                                                                <?php
                                                                $arrPrepare = ['100', '1002', '1003'];
                                                                if (!in_array($dataDetailOrder->status, $arrPrepare)) :
                                                                ?>
                                                                    <td>
                                                                        <span><?= $promotion->realWeight >= 1000 ? $promotion->realWeight / 1000 : $promotion->realWeight ?>
                                                                            <?= ($promotion->realWeight >= 1000) ? ' kg' : $promotion->unit; ?>
                                                                    </td>

                                                                <?php endif;
                                                                $countTotalItem += $promotion->quantity; ?>
                                                                <td class="pro-subtotal">
                                                                    <span><?= number_format($promotion->toMoney, 0) ?></span> đ
                                                                </td>

                                                            </tr>
                                                    <?php endforeach;
                                                    endif; ?>
                                                <?php } ?>
                                                <input type="hidden" value="<?php echo count($dataDetailOrder->orderDetails); ?>" class="totalAllProducts">
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- End thông tin hàng hoá -->
                        <div class="row">
                            <div class="col-5">

                                <!-- Cước phí -->
                                <div class="info-fee order-detail-info">
                                    <div class="info-order-detail-1 pst-rlt" style="margin-bottom:15px;">
                                        <b>Thông tin chi tiết</b>
                                    </div>
                                    <div class="d-flex">
                                        <div class="info-fee-3">
                                            <i class="mdi mdi-shape-plus menu-icon"></i>
                                            <!-- <img src="<?php //echo base_url('public/images/tien.svg');
                                                            ?>" alt=""> -->
                                        </div>

                                        <div class="info-fee-4 w-100">
                                            <div class="info-fee-cod">
                                                Phương thức đặt hàng: <b class="info-fee-icon-1">
                                                    <?php
                                                    echo $dataDetailOrder->orderMethodName; ?></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="info-fee-3">
                                            <i class="mdi mdi-shape-plus menu-icon"></i>
                                            <!-- <img src="<?php //echo base_url('public/images/tien.svg');
                                                            ?>" alt=""> -->
                                        </div>

                                        <div class="info-fee-4 w-100">
                                            <div class="info-fee-cod">
                                                Phương thức vận chuyển: <b class="info-fee-icon-1">
                                                    <?php
                                                    echo $dataDetailOrder->shippingMethodName; ?></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="info-fee-3">
                                            <i class="mdi mdi-shape-plus menu-icon"></i>
                                            <!-- <img src="<?php //echo base_url('public/images/tien.svg');
                                                            ?>" alt=""> -->
                                        </div>

                                        <div class="info-fee-4 w-100">
                                            <div class="info-fee-cod">
                                                Phương thức giao hàng: <b class="info-fee-icon-1">
                                                    <?php
                                                    echo $dataDetailOrder->deliveryMethodName; ?></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="info-fee-3">
                                            <i class="mdi mdi-shape-plus menu-icon"></i>
                                            <!-- <img src="<?php //echo base_url('public/images/tien.svg');
                                                            ?>" alt=""> -->
                                        </div>

                                        <div class="info-fee-4 w-100">
                                            <div class="info-fee-cod">
                                                Phương thức thanh toán: <b class="info-fee-icon-1">
                                                    <?php
                                                    echo $dataDetailOrder->paymentMethodName; ?></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="info-fee-3">
                                            <img src="<?php echo base_url('public/images/tien.svg'); ?>" alt="">
                                        </div>

                                        <div class="info-fee-4 w-100">
                                            <div class="info-fee-cod ">
                                                Tổng tiền đơn hàng: <b class="info-fee-icon-1">
                                                    <?= number_format($dataDetailOrder->originTotalOrder) ?></b> đ

                                                <img src="<?php echo base_url('public/images/line5.png'); ?>" alt="" class="info-fee-line">
                                            </div>

                                            <div class="info-fee-cod ">
                                                Giảm giá: <b class="info-fee-icon-2">
                                                    <?= number_format($dataDetailOrder->promotionTotalOrder) ?></b> đ

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="info-fee-3">
                                            <img src="<?php echo base_url('public/images/tien.svg'); ?>" alt="">
                                        </div>

                                        <div class="info-fee-4 w-100">

                                            <div class="info-fee-cod">
                                                Tổng phí: <b class="info-fee-icon-2"><?= number_format($dataDetailOrder->totalFee) ?></b>
                                                đ

                                                <img src="<?php echo base_url('public/images/line5.png'); ?>" alt="" class="info-fee-line">
                                            </div>
                                            <div class="info-fee-cod ">
                                                Tổng tiền thu: <b class="info-fee-icon-2">
                                                    <?= number_format($dataDetailOrder->totalPayment) ?></b> đ

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End cước phí -->
                                <!-- Thông tin người nhận, người gửi -->
                                <div class="order-detail-info">

                                    <div class="info-detail-recipient">
                                        <div class="info-order-detail-1 pst-rlt">
                                            <div>
                                                <b>Thông tin người nhận</b>
                                            </div>
                                            <div class="info-order-detail-2">

                                            </div>
                                        </div>
                                        <div class="d-flex info-detail-sender-2">
                                            <img class="info-detail-sender-img" src="<?php echo base_url('public/images/manager.png'); ?>">
                                            <div>
                                                <span><?= $dataDetailOrder->receiverName . ' - ' . $dataDetailOrder->receiverPhone ?></span>
                                            </div>
                                        </div>

                                        <div class="d-flex info-detail-sender-2 ">
                                            <img class=" info-detail-sender-img" src="<?php echo base_url('public/images/place.png'); ?>">
                                            <div>
                                                <span>
                                                    <?php
                                                    echo ($dataDetailOrder->receiverAddress) ? $dataDetailOrder->receiverAddress . ', ' : '';
                                                    echo ($dataDetailOrder->wardName) ? $dataDetailOrder->wardName . ', ' : '';
                                                    echo ($dataDetailOrder->districtName) ? $dataDetailOrder->districtName . ', ' : '';
                                                    echo ($dataDetailOrder->provinceName) ? $dataDetailOrder->provinceName  : '';
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- //Quét QR -->
                            <div class="col-7">
                                <div class="info-fee order-detail-info notifacation-wrapper" style="min-height:295px">
                                    <!-- <div class="notification-container" id="notification-container">
                                        <div class="notification notificationMessage notification-danger  ">
                                        </div>
                                    </div> -->
                                    <div class="info-order-detail-1 pst-rlt" style="margin-bottom:15px;">
                                        <b>Quét mã Barcode chuẩn bị sản phẩm</b>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- <input type="radio" id="buyProduct" name="typeProduct" value="1" checked="">
                                            <label for="buyProduct" class="fz13" style="margin-right:15px">Sản phẩm
                                                mua</label>

                                            <input type="radio" id="promotionProduct" name="typeProduct" value="2">
                                            <label class="fz13" for="promotionProduct">Sản phẩm tặng kèm</label> -->
                                        </div>
                                        <div class="col-6">
                                            <p class="fz13">Mã trứng gà 1 hộp 06 quả: 1003706</p>
                                            <p class="fz13">Mã trứng gà 1 hộp 10 quả: 1003710</p>
                                        </div>
                                    </div>

                                    <div class="mg-bt10">

                                    </div>

                                    <div class="info-order-detail-1 pst-rlt" style="margin-bottom:15px;">
                                        <input type="text" id="prepareOrderQR" onchange="prepareOrderQR(<?php echo $dataDetailOrder->orderCode; ?>)" class="prepareOrderQR form-control">
                                    </div>
                                    <div class="mg-bt10">
                                        <p class="fz13">Tổng sản phẩm đã quét:
                                            <span class="scanedQR"><?php echo (!empty($dataAllItemOrder)) ? count($dataAllItemOrder) : 0; ?>
                                            </span>/<span class="totalItems"><?php echo $dataDetailOrder->totalProduct; ?> </span>
                                        </p>
                                        <input type="hidden" value="<?php echo (!empty($dataAllItemOrder)) ? count($dataAllItemOrder) : 0; ?>" class="countTotalItemsScaned">
                                        <input type="hidden" value="<?php echo $dataDetailOrder->totalProduct ?>" class="countTotalItems">
                                        <input type="hidden" value="<?php echo $dataDetailOrder->orderCode; ?>" class="orderCode">
                                    </div>
                                    <div class="table-wrapper">
                                        <div class="table-scroll">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="40%" class="upperTable pro-title"> <span class="pl-3">Sản phẩm </span></th>
                                                        <th width="25%" class="upperTable pro-subtotal">Khối lượng thực
                                                            tế</th>
                                                        <th width="30%" class="upperTable pro-subtotal">Thành tiền</th>
                                                        <th width="5%" class="upperTable pro-subtotal"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="appendPrepareOrder">
                                                    <?php
                                                    if (!empty($dataAllItemOrder)) :
                                                        foreach ($dataAllItemOrder as $item) :
                                                    ?>
                                                            <tr class="qrItem prepare-<?php echo $item->id; ?>">
                                                                <td class="pro-title">
                                                                    <img class="img-fluid" src="<?php echo $item->productImg ?>" alt="Product">
                                                                    <span><?php echo $item->productName ?> </span>
                                                                </td>
                                                                <td class="pro-quantity text-center">
                                                                    <?php echo number_format($item->tempWeight) . ' ' . $item->unit ?>
                                                                </td>
                                                                <td class="pro-subtotal text-center">
                                                                    <?php echo number_format($item->totalMoney) ?></td>
                                                                <td>
                                                                    <button class="btn btn-danger btn-icon-custom" type="button" onclick="removePrepareProduct(<?php echo $item->id; ?>, <?php echo $dataDetailOrder->orderCode; ?>)" title="Xóa">
                                                                        <i class="mdi mdi-close-circle-outline"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="mg-tp10">
                                    <select class="form-control chosen-select sizeBox" id="sizeBox" name="sizeBox" data-placeholder="Chọn loại phương thức">
                                        <option value="0"> Chọn kích cỡ thùng</option>
                                        <?php
                                        if (!empty($listBox)) :
                                        ?>
                                            <?php foreach ($listBox as $box) : ?>
                                                <option value="<?= $box->id ?>">
                                                    <?= $box->name . '(' . $box->length . '-' . $box->width . '-' . $box->height . ')' ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <p class="error_text errSizeBox "></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-right" style="margin-top:1rem">
                            <div class="col-sm-12">
                                <a type="button" href="<?php echo base_url('/don-hang/danh-sach-don-hang') ?>" id="goBack" class="btn btn-danger">Quay lại</a>
                                <button type="button" id="btn-confirmPrepare" disabled class="btn btn-primary btn-confirmPrepare">Chuẩn bị xong</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>
</div>

<div id="theModalPrint" class="modal fade text-center" style="page-break-after: always;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div id="printTable">
            </div>
        </div>
    </div>
</div>

<!-- main-panel ends -->
<?php if ($checkNoti) { ?>
    <script>
        $(document).ready(function() {
            $(".notification-container").fadeIn();

            // Set a timeout to hide the element again
            setTimeout(function() {
                $(".notification-container").fadeOut();
            }, 5000);
        });
    </script>
<?php } ?>