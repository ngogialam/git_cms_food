<!-- partial:partials/_navbar.html -->
<?php
$requestUri = explode("/", $_SERVER['REQUEST_URI'])[2];
$link_active = explode("?", $requestUri)[0];
?>

<div class="main-panel">
    <div class="content-wrapper">
        <form method="get" action="">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-content-title"><?php echo $title ?></h3>
                    <form action="" id="formSearchListOrdersWare" method="GET" class="notifacation-wrapper">
                        <?php
                        $checkNoti = get_cookie('__changeStatus');
                        $checkNoti = explode('^_^', $checkNoti);
                        setcookie("__changeStatus", '', time() + (1), '/');
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

                        <div class="row searchBar">
                            <div class="form-group col-md-3 pdr-menu ">
                                <input type="text" id="nameDish" class="form-control nameDish" name="keyWord" value="<?php echo $get['keyWord'] ?>" placeholder="M?? ????n, S??T...">
                            </div>

                            <div class="form-group col-md-3 pdr-menu">
                                <select class="form-control pdm chosen-select status" name="status" data-placeholder="Ch???n tr???ng th??i" id="permission">
                                    <option value="0">Ch???n tr???ng th??i</option>
                                    <?php
                                    if (!empty($listStatus)) :
                                        foreach ($listStatus as $itemStatus) :
                                    ?>
                                            <option <?php echo ($itemStatus->status == $get['status']) ? 'selected' : ''; ?> value="<?php echo $itemStatus->status ?>"><?php echo $itemStatus->message ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3 pdr-menu">
                                <select class="form-control pdm chosen-select restaurantId" name="restaurantId" data-placeholder="Danh m???c cha" id="permission">
                                    <option value="0">Ch???n c???a h??ng</option>
                                    <?php
                                    if (!empty($listRestaurant)) :
                                        foreach ($listRestaurant as $itemRestaurant) :
                                    ?>
                                            <option <?php echo ($itemRestaurant->id == $get['restaurantId']) ? 'selected' : ''; ?> value="<?php echo $itemRestaurant->id ?>"><?php echo $itemRestaurant->name ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 pdr-menu">
                                <select class="form-control pdm chosen-select partnerId" name="partnerId" data-placeholder="Danh m???c cha" id="permission">
                                    <option value="0">Ch???n ?????i t??c</option>
                                    <?php
                                    if (!empty($listPartner)) :
                                        foreach ($listPartner as $itemPartner) :
                                    ?>
                                            <option <?php echo ($itemPartner->id == $get['partnerId']) ? 'selected' : ''; ?> value="<?php echo $itemPartner->id ?>"><?php echo $itemPartner->name ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>


                            <div class="form-group col-md-3 pdr-menu">
                                <input type="text" class="datepicker form-control started" data-date-format="dd/mm/yyyy" placeholder="Th???i gian t???o ????n t???" name="started" value="<?php echo $get['started'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group col-md-3 pdr-menu">
                                <input type="text" class="datepicker form-control stoped" data-date-format="dd/mm/yyyy" placeholder="Th???i gian t???o ????n t???i" name="stoped" value="<?php echo $get['stoped'] ?>" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-6 pdl-menu">
                                <div class="d-flex align-items-center ">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-info bth-canel bctn-icon-text" href="<?= base_url('/mon-an/tong-hop-don-dat-hang') ?> ">T???ng h???p ????n ?????t h??ng</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text" id="searchListOrder">T??m ki???m</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text" href="<?= base_url('/mon-an/danh-sach-don-hang-food') ?> ">B??? l???c</a>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" name="excel" value="1" class="btn btn-info btn-excel" onclick="exportExcelListOrders()">
                                            Xu???t Excel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="main-body">

                        <div class="mt-2">

                            <button type="button" class="btn btn-primary" onclick="changeStatusDishOrder(100)">X??c nh???n ????n</button>
                            <button type="button" class="btn btn-info" onclick="changeStatusDishOrder(105)">Chu???n b??? h??ng</button>
                            <button type="button" class="btn btn-info" onclick="changeStatusDishOrder(200)">Chu???n b??? h??ng xong</button>
                            <button type="button" class="btn btn-success" onclick="changeStatusDishOrder(500)">Giao cho shipper</button>
                            <button type="button" class="btn btn-success" onclick="changeStatusDishOrder(501)">Giao th??nh c??ng</button>
                            <button type="button" class="btn btn-danger" onclick="changeStatusDishOrder(107)">Hu??? ????n</button>
                        </div>

                        <div class="card mt-2">
                            <div class="table-responsive tbl-statistic-order">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="vertical th-action" width="7%">
                                                <div class="d-flex" style="justify-content: center;">
                                                    <input style="width:20px;" class="checkAll check-action" id="checkAll" value="all-order" name="check[]" type="checkbox">
                                                    <!-- <button type="button" class="btn btn-success btn-icon-custom" onclick="activeRowAllMenus()" title="Active">
                                                        <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-icon-custom" onclick="disableRowAllMenus()" title="Disable">
                                                        <i class="mdi mdi-close-circle-outline"></i>
                                                    </button> -->
                                                </div>
                                            </th>
                                            <th class="" width="7%">Ph?????ng</th>
                                            <th class="" width="7%">?????i t??c</th>
                                            <th class="" width="7%">Nh?? h??ng</th>
                                            <th class="" width="7%">M?? ????n h??ng</th>
                                            <th class="" width="7%">S??T ng?????i ?????t</th>
                                            <th class="" width="7%">Ng?????i nh???n</th>
                                            <th class="" width="7%">S??T ng?????i nh???n</th>
                                            <th class="" width="7%">?????a ch??? ng?????i nh???n</th>
                                            <th class="" width="7%">Su???t ??n</th>
                                            <th class="" width="7%">Ti???n h??ng</th>
                                            <th class="" width="7%">Ph?? giao h??ng</th>
                                            <th class="" width="7%">T???ng ti???n</th>
                                            <th class="" width="7%">Ph????ng th???c thanh to??n</th>
                                            <th class="" width="7%">Ghi ch??</th>
                                            <th class="" width="7%">Th???i gian t???o ????n</th>
                                            <th class="" width="7%">Tr???ng th??i ????n</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($objects)) {
                                            foreach ($objects as $item) { ?>
                                                <tr>
                                                    <td class="text-center th-action">
                                                        <input style="padding: 5px 9px;" type="checkbox" name="check[]" class="checkSingle check-action checkValueAction" value="<?= $item->orderCode ?>" />
                                                        <!-- <button class="btn btn-primary btn-icon-custom" type="button" title="Edit">
                                                            <i class="mdi mdi-pen"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-icon-custom" type="button" title="Disable">
                                                            <i class="mdi mdi-close-circle-outline"></i>
                                                        </button> -->
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->wardName ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->partnerName ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->restaurantName ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->orderCode ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->orderPhone ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->receiverName ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->receiverPhone ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->address ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if (!empty($item->orderDetail)) {
                                                            foreach ($item->orderDetail as $itemOrder) {
                                                                echo '- ' . $itemOrder . '<br>';
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= number_format($item->money) . ' VND' ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= number_format($item->deliveryFee) . ' VND' ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= number_format($item->totalMoney) . ' VND' ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->paymentMethod ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->orderNote ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->createdDate ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $item->status; ?>
                                                    </td>

                                                </tr>
                                            <?php   }
                                        } else { ?>
                                            <tr>
                                                <td style="padding: 20px 10px!important;" colspan="9">Kh??ng t??m th???y d???
                                                    li???u ph?? h???p.</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pagination" style="justify-content: flex-end;">
                            <?php if ($pager) : ?>
                                <?php
                                if (isset($uri) && $uri[0] != '') {
                                    echo $pager->makeLinks($page, $perPage, $total, 'default_full', 3);
                                } else {
                                    echo $pager->makeLinks($page, PERPAGE, $total, 'default_full', 4);
                                }
                                ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal modalCloseReload fade" id="modalDish" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body confirmBody">
                <p>B???n c?? ch???c ch???n x??c nh???n?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-danger btn-ok btnDeleteRow">X??a</button>
            </div>
        </div>
    </div>
</div>

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