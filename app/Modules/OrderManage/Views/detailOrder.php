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
                        <div class="
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
                        <input type="hidden" value="<?php echo $dataDetailOrder->orderCode; ?>" name="orderId" class="orderId">
                        <input type="hidden" value="<?php echo $dataDetailOrder->status; ?>" name="orderStatus" class="orderStatus">
                        <!-- Th??ng tin h??ng ho?? -->
                        <div class="info-order-detail">
                            <div class="info-order-detail-1 pst-rlt">
                                <div>
                                    <b>Th??ng tin ????n h??ng</b>
                                </div>
                                <?php
                                $arrEdit = ['1002', '1003'];
                                if (in_array($dataDetailOrder->status, $arrEdit)) :
                                ?>
                                    <div class="mg-tp10">
                                        <button class="btn btn-success btn-delivery" onclick="addProductToOrder()">
                                            <i class="mdi mdi-cart-plus"></i>
                                            <span>Th??m s???n ph???m</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
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
                                                <?php
                                                $arrEdit = ['1002', '1003'];
                                                if (in_array($dataDetailOrder->status, $arrEdit)) :
                                                ?>
                                                    <th width="5%" class="pro-subtotal"></th>
                                                <?php endif; ?>

                                            </tr>
                                        </thead>
                                        <tbody class="appendNewProductTable">
                                            <?php if ($dataDetailOrder->orderDetails != '') {
                                                foreach ($dataDetailOrder->orderDetails as $keyProduct => $historyDetail) {
                                                    $priceProduct = $historyDetail->prices;
                                                    $promotionProducts = $historyDetail->promotionProducts;
                                                    $setProducts = $historyDetail->setProducts;
                                            ?>
                                                    <tr keyMain="<?php echo $keyProduct; ?>" class="productMainId-<?php echo $historyDetail->productID ?> productMainId-<?php echo $historyDetail->productID . '-' . $historyDetail->priceId ?> productId-<?php echo $historyDetail->productID . '-' . $historyDetail->priceId ?>">
                                                        <td class="pro-title">
                                                            <img class="img-fluid" src="<?= $historyDetail->productImage ?>" alt="Product">
                                                            <?= $historyDetail->productName ?>

                                                        </td>
                                                        <td class="pro-packing">
                                                            <?php if ($historyDetail->type == 1) {
                                                                if (!empty($setProducts)) {
                                                                    echo '1 Set'; ?> 
                                                                    <input type="hidden" class="setPrice setPrice-<?php echo $keyProduct; ?>" value="<?php echo $historyDetail->price ?>" />
                                                                    <input type="hidden" value="<?php echo $historyDetail->priceId; ?>" name="priceIdSet-<?php echo $keyProduct; ?>" class="priceIdSet-<?php echo $keyProduct; ?>">
                                                                    <?php
                                                                } else { ?>
                                                                    <select class="form-control chosen-select weightProduct weightProduct-<?php echo $keyProduct; ?>" key="<?php echo $keyProduct; ?>" productId="<?php echo $historyDetail->productID ?>" name="weightProduct" data-placeholder="Quy c??ch ????ng g??i">
                                                                        <?php foreach ($priceProduct as $itemPrice) : ?>
                                                                            <option <?php echo ($itemPrice->id == $historyDetail->priceId) ? 'selected' : ''; ?> keyStock="<?php echo $itemPrice->stock; ?>" keyPrice="<?php echo $itemPrice->price; ?>" value="<?php echo $itemPrice->id ?>">
                                                                                <?php echo $itemPrice->weight . ' ' . $itemPrice->unit ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <input type="hidden" class="setPrice setPrice-<?php echo $keyProduct; ?>" value="0" />
                                                                <?php }
                                                            } else { ?>
                                                                <span class=""><?= $historyDetail->weight >= 1000 ? $historyDetail->weight : $historyDetail->weight ?>
                                                                </span>
                                                                <?= $historyDetail->unit ?>
                                                            <?php } ?>
                                                            <input type="hidden" class="checkSet checkSet-<?php echo $keyProduct; ?>" value="<?php echo (!empty($setProducts)) ? 1 : 0 ?>" />
                                                            
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
                                                            <input type="number" min="0" key="<?php echo $keyProduct; ?>" class="form-control quantity quantity-<?php echo $keyProduct; ?>" name="quantity-<?php echo $keyProduct; ?>" value="<?= number_format($historyDetail->quantity, 0) ?>">

                                                        </td>
                                                        <?php
                                                        $arrPrepare = ['100', '1002', '1003'];
                                                        if (!in_array($dataDetailOrder->status, $arrPrepare)) :
                                                        ?>
                                                            <td>
                                                                <span><?= $historyDetail->realWeight >= 1000 ? $historyDetail->realWeight / 1000 : $historyDetail->realWeight ?>
                                                                    <?= ($historyDetail->realWeight >= 1000) ? ' kg' : $historyDetail->unit; ?>
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
                                                        <input type="hidden" value="<?php echo $historyDetail->productName; ?>" name="productName-<?php echo $keyProduct; ?>" class="productName-<?php echo $keyProduct; ?>">
                                                        <input type="hidden" value="<?php echo $historyDetail->productID; ?>" name="productId-<?php echo $keyProduct; ?>" class="productId-<?php echo $keyProduct; ?>">
                                                        <input type="hidden" value="<?php echo $historyDetail->priceId; ?>" name="priceId-<?php echo $keyProduct; ?>" class="priceId-<?php echo $keyProduct; ?>">
                                                        <input type="hidden" value="<?php echo $historyDetail->quantity; ?>" name="quantityId-<?php echo $keyProduct; ?>" class="quantityId-<?php echo $keyProduct; ?>">
                                                    </tr>
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
                                                                        <span><?= $promotion->realWeight >= 1000 ? $promotion->realWeight / 1000 : $promotion->realWeight ?>
                                                                            <?= ($promotion->realWeight >= 1000) ? ' kg' : $promotion->unit; ?>
                                                                    </td>

                                                                <?php endif; ?>
                                                                <td class="pro-subtotal">
                                                                    <span>0</span> ??
                                                                </td>
                                                                <?php
                                                                $arrEdit = ['1002', '1003'];
                                                                if (in_array($dataDetailOrder->status, $arrEdit)) :
                                                                ?>
                                                                    <td></td>
                                                                <?php endif; ?>

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

                                                                    <span class=""><?= $promotion->weight ?>
                                                                    </span>
                                                                    <?= $promotion->unit ?>
                                                                </td>
                                                                <td class="pro-price">
                                                                    <span><?= number_format($promotion->price, 0) ?></span>
                                                                    ??/
                                                                    <span><?= $promotion->weight ?>
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

                                                                <?php endif; ?>
                                                                <td class="pro-subtotal">
                                                                    <span><?= number_format($promotion->toMoney, 0) ?></span> ??
                                                                </td>
                                                                <?php
                                                                $arrEdit = ['1002', '1003'];
                                                                if (in_array($dataDetailOrder->status, $arrEdit)) :
                                                                ?>
                                                                    <td></td>
                                                                <?php endif; ?>

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
                        <!-- C?????c ph?? -->
                        <div class="info-fee order-detail-info">
                            <div class="info-order-detail-1 pst-rlt" style="margin-bottom:15px;">
                                <b>Th??ng tin chi ti???t</b>
                                <?php
                                $arrEditMethod = ['1002', '1003'];
                                if (in_array($dataDetailOrder->status, $arrEditMethod)) :
                                ?>
                                    <img data-toggle="modal" data-target="#editMethodInfo" class="cursorPointer pst-ab-r float-right" alt=" " title="Ch???nh s???a ph????ng th???c" src="<?php echo base_url('public/assets/images/icons/icEdit.svg'); ?>">
                                <?php endif; ?>

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
                                        T???ng ti???n ????n h??ng: <b class="info-fee-icon-2">
                                            <span class="totalMoney"><?= number_format($dataDetailOrder->originTotalOrder) ?>
                                            </span>
                                        </b> ??

                                        <img src="<?php echo base_url('public/images/line5.png'); ?>" alt="" class="info-fee-line">
                                    </div>
                                    <div class="info-fee-change-cod">
                                        Gi???m gi??:
                                        <b class="info-fee-icon-2 "> <span class="promotionFee"><?= number_format($dataDetailOrder->promotionTotalOrder) ?></span></b>
                                        ??

                                        <img src="<?php echo base_url('public/images/line5.png'); ?>" alt="" class="info-fee-line">
                                    </div>

                                    <div class="info-fee-change-cod">
                                        T???ng ph??:
                                        <b class="info-fee-icon-2 "> <span class="totalFee"><?= number_format($dataDetailOrder->totalFee) ?></span></b>
                                        ??

                                        <img src="<?php echo base_url('public/images/line5.png'); ?>" alt="" class="info-fee-line">
                                    </div>

                                    <div class="info-fee-cod ">
                                        T???ng ti???n thu: <b class="info-fee-icon-1">
                                            <span class="totalPayment">
                                                <?= number_format($dataDetailOrder->totalPayment) ?> </span>
                                        </b> ??
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
                                        <?php
                                        $arrEditInfo = ['1002', '1003', '100', '101'];
                                        if (in_array($dataDetailOrder->status, $arrEditInfo)) :
                                        ?>
                                            <img data-toggle="modal" data-target="#editReceiverInfo" class="cursorPointer pst-ab-r float-right" alt=" " title="Ch???nh s???a th??ng tin ng?????i nh???n" src="<?php echo base_url('public/assets/images/icons/icEdit.svg'); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="info-order-detail-2">
                                    </div>
                                </div>
                                <div class="d-flex info-detail-sender-2">
                                    <i class=" detailIcon mdi mdi-account"></i>
                                    <div>
                                        <span><?= $dataDetailOrder->receiverName . ' - ' . $dataDetailOrder->receiverPhone ?></span>
                                    </div>
                                </div>

                                <div class="d-flex info-detail-sender-2 ">
                                    <i class=" detailIcon mdi mdi-map-marker"></i>
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
                                <div class="d-flex info-detail-sender-2 ">
                                    <i class=" detailIcon mdi mdi-calendar"></i>
                                    <div>
                                        <span> Ng??y nh???n mong mu???n:
                                            <?php
                                            echo ($dataDetailOrder->expectDeliveryDate) ? $dataDetailOrder->expectDeliveryDate : '';
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex info-detail-sender-2 ">
                                    <i class="detailIcon mdi mdi-message-text"></i>
                                    <div>
                                        <span>Ghi ch??:
                                            <?php
                                            echo ($dataDetailOrder->note) ? $dataDetailOrder->note : '';
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-right" style="margin-top:1rem">
                            <div class="col-sm-12">
                                <a type="button" href="<?php echo base_url('/don-hang/danh-sach-don-hang') ?>" id="goBack" class="btn btn-danger">Quay l???i</a>
                                <?php
                                $arrPrintOrder = ['100', '1002', '1003'];
                                if (in_array($dataDetailOrder->status, $arrPrintOrder)) :
                                ?>
                                    <button type="button" id="btn-delivery" class="btn btn-primary btn-delivery" onclick="printExportOnly('<?php echo base_url('/don-hang/printExportOrder?orderCode=' . $dataDetailOrder->orderCode . '&type=1'); ?>')">In
                                        ????n ?????t h??ng</button>
                                <?php endif; ?>

                                <?php
                                $arrPrintExport = ['100', '1002', '1003'];
                                if (!in_array($dataDetailOrder->status, $arrPrintExport)) :
                                ?>
                                    <button type="button" id="btn-delivery" class="btn btn-primary btn-delivery" onclick="printExportOnly('<?php echo base_url('/don-hang/printExportOrder?orderCode=' . $dataDetailOrder->orderCode . '&type=2'); ?>')">In
                                        phi???u xu???t kho</button>
                                <?php endif; ?>

                                <?php
                                if ($dataDetailOrder->status == 101) { ?>
                                    <button type="button" id="btn-delivery" class="btn btn-primary btn-delivery" onclick="changeDelivery(<?php echo $dataDetailOrder->orderCode; ?>)">Chuy???n ????n v???
                                        v???n chuy???n</button>
                                <?php } else if ($dataDetailOrder->status == 100) { ?>
                                    <a class="btn btn-primary btn-confirmPrepare" href="<?php echo base_url('don-hang/chuan-bi-don-hang?orderId=' . $dataDetailOrder->orderCode) ?>">
                                        Chu???n b??? h??ng </a>
                                <?php } ?>

                                <?php
                                $arConfirm???der = [1002];
                                if (in_array($dataDetailOrder->status, $arConfirm???der)) :
                                ?>
                                    <button type="button" id="btn-delivery" class="btn btn-primary btn-delivery" onclick="confirmOrder(<?php echo $dataDetailOrder->orderCode ?>, 1)">X??c nh???n ????n
                                        h??ng</button>
                                <?php endif; ?>
                                <?php
                                $arrPrepareOrder = [1003];
                                if (in_array($dataDetailOrder->status, $arrPrepareOrder)) :
                                ?>
                                    <button type="button" id="btn-delivery" class="btn btn-primary btn-delivery" onclick="confirmOrder(<?php echo $dataDetailOrder->orderCode ?>, 2)">Chuy???n kho
                                        chu???n b??? ????n h??ng</button>
                                <?php endif; ?>
                                <?php
                                $arrEdit = ['1002', '1003'];
                                if (in_array($dataDetailOrder->status, $arrEdit)) :
                                ?>
                                    <button type="button" id="btn-delivery" class="btn btn-primary btn-delivery" onclick="editOrder(<?php echo $dataDetailOrder->orderCode ?>, 0)">S???a ????n
                                        h??ng</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- onclick="submitOrder(<?php //echo $dataDetailOrder->orderCode ; 
                                                    ?>)" -->
                        <!--End th??ng tin ng?????i nh???n, g???i  -->
                    </div>

                    <!-- <div class="order-detail-right col-md-6">
                    </div> -->
                </section>
            </div>
        </div>

    </div>
</div>
<div class="modal " id="addProductToOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title promotionOrder" id="myModalLabel">Th??m s???n ph???m</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row pdn">
                    <div class="col-12">
                        <label for="typePromotionOrder">T??m ki???m s???n ph???m</label>
                        <input type="text" class="form-control namePromotionOrder" placeholder="Nh???p t??n s???n ph???m c???n t??m" id="searchProduct" data-toggle="dropdown" autocomplete="off" aria-haspopup="true" aria-expanded="false" onkeyup="getProductSearch()">
                        <div class="dropdown-menu" aria-labelledby="searchProduct" id="modal-add-product-detail" style="width: 97%;">
                            <div class="row" id="all-select-product-add-new">

                            </div>
                        </div>
                    </div>
                    <div class="col-12 mg-tp10">
                        <button class="btn btn-success" type="button" onclick="addProductOrder()"> <i class="mdi mdi-plus"></i> Th??m s???n ph???m</button>
                    </div>
                </div>

                <div class="appendNewProduct">
                    <input type="hidden" value="0" name="keyProduct" class="keyProduct">

                </div>
            </div>
            <input type="hidden" class="promotionOrderId" id="promotionOrderId" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-success btn-ok addNewProductItems">Th??m m???i</button>
            </div>
        </div>
    </div>
</div>

<div class="modal " id="editMethodInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title promotionOrder" id="myModalLabel">S???a ph????ng th???c</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row pdn">
                    <div class="col-6 position-relative">
                        <label for="receiverPhone"> Ph????ng th???c ?????t h??ng <span style="color: red">(*)</span></label>
                        <!-- length -->
                        <select id="orderMethod" name="orderMethod" class="form-control form-control-inverse chosen-select orderMethod " data-placeholder="Ch???n ph????ng th???c ?????t h??ng">
                            <?php
                            if (!empty($arrMethods)) :
                                $orderMethods = $arrMethods->orderMethod;
                                foreach ($orderMethods as $object) :
                            ?>
                                    <option value="<?php echo $object->id ?>" <?php echo ($object->id == $dataDetailOrder->orderMethodID) ? 'selected="selected"' : ""; ?>>
                                        <?php echo $object->method; ?> </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                        <br>
                        <span class=" err_messages err_orderMethod"> </span>
                    </div>
                    <div class="col-6 position-relative">
                        <label for="receiverPhone"> Ph????ng th???c v???n chuy???n <span style="color: red">(*)</span></label>
                        <!-- length -->
                        <select id="shippingMethod" name="shippingMethod" class="form-control form-control-inverse chosen-select shippingMethod " data-placeholder="Ch???n ph????ng th???c v???n chuy???n">
                            <?php
                            if (!empty($arrMethods)) :
                                $shippingMethods = $arrMethods->shippingMethod;
                                foreach ($shippingMethods as $object) :
                            ?>
                                    <option value="<?php echo $object->id ?>" <?php echo ($object->id == $dataDetailOrder->shippingMethodID) ? 'selected="selected"' : ""; ?>>
                                        <?php echo $object->method; ?> </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                        <br>
                        <span class=" err_messages err_shippingMethod"> </span>
                    </div>
                </div>

                <div class="form-group row pdn">

                    <div class="col-6 position-relative">
                        <label for="receiverPhone"> Ph????ng th???c giao h??ng <span style="color: red">(*)</span></label>
                        <select id="deliveryMethod" name="deliveryMethod" class="form-control form-control-inverse chosen-select deliveryMethod " data-placeholder="Ch???n ph????ng th???c giao h??ng">
                            <?php
                            if (!empty($arrMethods)) :
                                $deliveryMethods = $arrMethods->deliveryMethod;
                                foreach ($deliveryMethods as $object) :
                            ?>
                                    <option value="<?php echo $object->id ?>" <?php echo ($object->id == $dataDetailOrder->deliveryMethodID) ? 'selected="selected"' : ""; ?>>
                                        <?php echo $object->method; ?> </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                        <br>
                        <span class=" err_messages err_deliveryMethod"> </span>
                    </div>
                    <div class="col-6 position-relative">
                        <label for="receiverPhone"> Ph????ng th???c thanh to??n <span style="color: red">(*)</span></label>
                        <select id="paymentMethod" name="paymentMethod" class="form-control form-control-inverse chosen-select paymentMethod " data-placeholder="Ch???n ph????ng th???c thanh to??n">
                            <?php
                            if (!empty($arrMethods)) :
                                $paymentMethods = $arrMethods->paymentMethod;
                                foreach ($paymentMethods as $object) :
                            ?>
                                    <option value="<?php echo $object->id ?>" <?php echo ($object->id == $dataDetailOrder->paymentMethodID) ? 'selected="selected"' : ""; ?>>
                                        <?php echo $object->method; ?> </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                        <br>
                        <span class=" err_messages err_paymentMethod"> </span>
                    </div>
                </div>

            </div>
            <input type="hidden" class="promotionOrderId" id="promotionOrderId" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-success btn-ok changeMethodReceiver" onclick="changeMethodReceiver(<?php echo $dataDetailOrder->orderCode ?> )">C???p nh???t</button>
            </div>
        </div>
    </div>
</div>
<div class="modal " id="editReceiverInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title promotionOrder" id="myModalLabel">S???a th??ng tin ng?????i nh???n</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row pdn">
                    <input type="hidden" class="orderId" value="<?= $dataDetailOrder->orderCode ?>">
                    <div class="col-6 position-relative">
                        <label for="receiverName"> T??n ng?????i nh???n <span style="color: red">(*)</span></label>
                        <!-- length -->
                        <input value="<?= $dataDetailOrder->receiverName ?>" class=" form-control receiverNameChange mt-2" type="text" placeholder="T??n ng?????i nh???n">
                        <br>
                        <span class=" err_messages err_receiverNameChange"> </span>
                    </div>
                    <div class="col-6 position-relative">
                        <label for="receiverPhone"> S??? ??i???n tho???i ng?????i nh???n <span style="color: red">(*)</span></label>
                        <!-- length -->
                        <input value="<?= $dataDetailOrder->receiverPhone ?>" class="form-control receiverPhoneChange mt-2" type="text">
                        <br>
                        <span class=" err_messages err_receiverPhoneChange"> </span>
                    </div>
                </div>
                <div class="form-group row pdn">
                    <div class="col-12 position-relative">
                        <label for="receiverPhone"> ?????a ch??? ng?????i nh???n <span style="color: red">(*)</span></label>
                        <input value="<?= $dataDetailOrder->receiverAddress ?>" class=" form-control productSize mt-2 receiverAddressChange" type="text" placeholder="?????a ch???">
                        <br>
                        <span class=" err_messages err_receiverAddressChange"> </span>
                    </div>
                </div>

                <div class="form-group row pdn">

                    <div class="col-4 position-relative">
                        <label for="receiverPhone"> T???nh/ Th??nh ph??? <span style="color: red">(*)</span></label>
                        <!-- length -->
                        <select id="sender_province_code" name="sender_province_code" class="form-control form-control-inverse chosen-select sender_province_code " data-placeholder="Ch???n Th??nh ph???">
                            <option value="0" class=""></option>
                            <?php
                            if (!empty($list_province)) :
                                foreach ($list_province as $province) :
                            ?>
                                    <option value="<?php echo $province->code ?>" <?php echo ($province->code == $dataDetailOrder->provinceCode) ? 'selected="selected"' : ""; ?>>
                                        <?php echo $province->name; ?> </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                        <br>
                        <span class=" err_messages err_sender_province_code"> </span>
                    </div>
                    <div class="col-4 position-relative">
                        <label for="receiverPhone"> Qu???n/ Huy???n <span style="color: red">(*)</span></label>
                        <!-- length -->
                        <select id="sender_district_code" name="sender_district_code" class="form-control form-control-inverse chosen-select sender_district_code " data-placeholder="Ch???n Qu???n">
                            <option value="0" class=""></option>
                            <?php
                            if (!empty($list_district)) :
                                foreach ($list_district as $district) :
                            ?>
                                    <option value="<?php echo $district->code ?>" <?php echo ($district->code == $dataDetailOrder->districtCode) ? 'selected="selected"' : ""; ?>>
                                        <?php echo $district->name; ?> </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                        <br>
                        <span class=" err_messages err_sender_district_code"> </span>
                    </div>
                    <div class="col-4 position-relative">
                        <label for="receiverPhone"> Ph?????ng/ X?? <span style="color: red">(*)</span></label>
                        <select id="sender_ward_code" name="sender_ward_code" class="form-control form-control-inverse chosen-select sender_ward_code " data-placeholder="Ch???n Ph?????ng/ X??">
                            <option value="0" class=""></option>
                            <?php
                            if (!empty($list_wards)) :
                                foreach ($list_wards as $ward) :
                            ?>
                                    <option value="<?php echo $ward->code ?>" <?php echo ($ward->code == $dataDetailOrder->wardCode) ? 'selected="selected"' : ""; ?>>
                                        <?php echo $ward->name; ?> </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                        <br>
                        <span class=" err_messages err_sender_ward_code"> </span>
                    </div>

                </div>
            </div>
            <input type="hidden" class="promotionOrderId" id="promotionOrderId" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-success btn-ok changeInfoReceiver" onclick="changeInfoReceiver(<?php echo $dataDetailOrder->orderCode ?> )">C???p nh???t</button>
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

<script>
    var arrProduct = [];
    var indexRow = 0;
    $(document).ready(function() {
        $.ajax({
            url: '/don-hang/searchProduct',
            type: 'post',
            dataType: 'json',
            data: {
                'key': ''
            },
            success: function(res) {
                arrProduct = res.arrProducts;
            },
            error: function() {}
        });
    });
</script>