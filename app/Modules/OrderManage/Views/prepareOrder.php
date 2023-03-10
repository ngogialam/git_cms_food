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

                    <!--Chi ti???t ????n h??ng -->
                    <div class="order-detail-left col-12 ">
                        <div class="row order-detail-bd-title">
                            <div class="code-orders-detail col-7">
                                <div id="orders" class="jn-if-left-tt">
                                    <span>M?? s???n ph???m: </span>
                                    <b class="code-order-detail">
                                        <?php
                                        echo $dataDetailOrder->orderCode;
                                        ?>
                                    </b>
                                </div>
                            </div>
                        </div>

                        <!-- Th??ng tin h??ng ho?? -->
                        <div class="info-order-detail">
                            <div class="info-order-detail-1 pst-rlt">
                                <div>
                                    <b>Th??ng tin ????n h??ng</b>
                                </div>
                                <div class="info-order-detail-2">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="15%" class="pro-title"> <span class="pl-3">S???n ph???m </span>
                                                </th>
                                                <th width="15%" class="pro-packing"> ????ng g??i </th>
                                                <th width="15%" class="pro-price">Gi?? / kh???i l?????ng</th>

                                                <th width="15%" class="pro-quantity">S??? l?????ng</th>
                                                <?php
                                                $arrPrepare = ['100', '1002', '1003'];
                                                if (!in_array($dataDetailOrder->status, $arrPrepare)) :
                                                ?>
                                                    <th width="15%" class="pro-quantity">Kh???i l?????ng t???nh</th>

                                                <?php endif; ?>
                                                <th width="15%" class="pro-subtotal">Th??nh ti???n</th>

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
                                                                ??/
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
                                                            ??
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

                                                    <!-- S???n ph???m trong set (n???u c??) -->
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
                                                                    ??/
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
                                                                    <span>0 </span> ??
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
                                                                    ??/
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
                                                                    <span><?= number_format($promotion->toMoney, 0) ?></span> ??
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

                        <!-- End th??ng tin h??ng ho?? -->
                        <div class="row">
                            <div class="col-5">

                                <!-- C?????c ph?? -->
                                <div class="info-fee order-detail-info">
                                    <div class="info-order-detail-1 pst-rlt" style="margin-bottom:15px;">
                                        <b>Th??ng tin chi ti???t</b>
                                    </div>
                                    <div class="d-flex">
                                        <div class="info-fee-3">
                                            <i class="mdi mdi-shape-plus menu-icon"></i>
                                            <!-- <img src="<?php //echo base_url('public/images/tien.svg');
                                                            ?>" alt=""> -->
                                        </div>

                                        <div class="info-fee-4 w-100">
                                            <div class="info-fee-cod">
                                                Ph????ng th???c ?????t h??ng: <b class="info-fee-icon-1">
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
                                                Ph????ng th???c v???n chuy???n: <b class="info-fee-icon-1">
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
                                                Ph????ng th???c giao h??ng: <b class="info-fee-icon-1">
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
                                                Ph????ng th???c thanh to??n: <b class="info-fee-icon-1">
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
                                                T???ng ti???n ????n h??ng: <b class="info-fee-icon-1">
                                                    <?= number_format($dataDetailOrder->originTotalOrder) ?></b> ??

                                                <img src="<?php echo base_url('public/images/line5.png'); ?>" alt="" class="info-fee-line">
                                            </div>

                                            <div class="info-fee-cod ">
                                                Gi???m gi??: <b class="info-fee-icon-2">
                                                    <?= number_format($dataDetailOrder->promotionTotalOrder) ?></b> ??

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="info-fee-3">
                                            <img src="<?php echo base_url('public/images/tien.svg'); ?>" alt="">
                                        </div>

                                        <div class="info-fee-4 w-100">

                                            <div class="info-fee-cod">
                                                T???ng ph??: <b class="info-fee-icon-2"><?= number_format($dataDetailOrder->totalFee) ?></b>
                                                ??

                                                <img src="<?php echo base_url('public/images/line5.png'); ?>" alt="" class="info-fee-line">
                                            </div>
                                            <div class="info-fee-cod ">
                                                T???ng ti???n thu: <b class="info-fee-icon-2">
                                                    <?= number_format($dataDetailOrder->totalPayment) ?></b> ??

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End c?????c ph?? -->
                                <!-- Th??ng tin ng?????i nh???n, ng?????i g???i -->
                                <div class="order-detail-info">

                                    <div class="info-detail-recipient">
                                        <div class="info-order-detail-1 pst-rlt">
                                            <div>
                                                <b>Th??ng tin ng?????i nh???n</b>
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

                            <!-- //Qu??t QR -->
                            <div class="col-7">
                                <div class="info-fee order-detail-info notifacation-wrapper" style="min-height:295px">
                                    <!-- <div class="notification-container" id="notification-container">
                                        <div class="notification notificationMessage notification-danger  ">
                                        </div>
                                    </div> -->
                                    <div class="info-order-detail-1 pst-rlt" style="margin-bottom:15px;">
                                        <b>Qu??t m?? Barcode chu???n b??? s???n ph???m</b>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- <input type="radio" id="buyProduct" name="typeProduct" value="1" checked="">
                                            <label for="buyProduct" class="fz13" style="margin-right:15px">S???n ph???m
                                                mua</label>

                                            <input type="radio" id="promotionProduct" name="typeProduct" value="2">
                                            <label class="fz13" for="promotionProduct">S???n ph???m t???ng k??m</label> -->
                                        </div>
                                        <div class="col-6">
                                            <p class="fz13">M?? tr???ng g?? 1 h???p 06 qu???: 1003706</p>
                                            <p class="fz13">M?? tr???ng g?? 1 h???p 10 qu???: 1003710</p>
                                        </div>
                                    </div>

                                    <div class="mg-bt10">

                                    </div>

                                    <div class="info-order-detail-1 pst-rlt" style="margin-bottom:15px;">
                                        <input type="text" id="prepareOrderQR" onchange="prepareOrderQR(<?php echo $dataDetailOrder->orderCode; ?>)" class="prepareOrderQR form-control">
                                    </div>
                                    <div class="mg-bt10">
                                        <p class="fz13">T???ng s???n ph???m ???? qu??t:
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
                                                        <th width="40%" class="upperTable pro-title"> <span class="pl-3">S???n ph???m </span></th>
                                                        <th width="25%" class="upperTable pro-subtotal">Kh???i l?????ng th???c
                                                            t???</th>
                                                        <th width="30%" class="upperTable pro-subtotal">Th??nh ti???n</th>
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
                                                                    <button class="btn btn-danger btn-icon-custom" type="button" onclick="removePrepareProduct(<?php echo $item->id; ?>, <?php echo $dataDetailOrder->orderCode; ?>)" title="X??a">
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
                                    <select class="form-control chosen-select sizeBox" id="sizeBox" name="sizeBox" data-placeholder="Ch???n lo???i ph????ng th???c">
                                        <option value="0"> Ch???n k??ch c??? th??ng</option>
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
                                <a type="button" href="<?php echo base_url('/don-hang/danh-sach-don-hang') ?>" id="goBack" class="btn btn-danger">Quay l???i</a>
                                <button type="button" id="btn-confirmPrepare" disabled class="btn btn-primary btn-confirmPrepare">Chu???n b??? xong</button>
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