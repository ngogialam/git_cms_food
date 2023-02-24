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

                            <div class="form-group col-md-3 pdr-menu">
                                <select class="form-control pdm chosen-select restaurantId" name="restaurantId" data-placeholder="Danh mục cha" id="permission">
                                    <option value="0">Chọn cửa hàng</option>
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
                                <select class="form-control pdm chosen-select partnerId" name="partnerId" data-placeholder="Danh mục cha" id="permission">
                                    <option value="0">Chọn đối tác</option>
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
                                <input type="text" class="datepicker form-control started" data-date-format="dd/mm/yyyy" placeholder="Thời gian tạo đơn từ" name="started" value="<?php echo $get['started'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group col-md-3 pdr-menu">
                                <input type="text" class="datepicker form-control stoped" data-date-format="dd/mm/yyyy" placeholder="Thời gian tạo đơn tới" name="stoped" value="<?php echo $get['stoped'] ?>" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-12 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text" id="searchListOrder">Tìm kiếm</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text" href="<?= base_url('/mon-an/tong-hop-don-dat-hang') ?> ">Bỏ lọc</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="main-body">
                        <div class="card mt-2">
                            <div class="table-responsive tbl-statistic-order">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="" width="15%">Phường</th>
                                            <th class="" width="15%">Đối tác</th>
                                            <th class="" width="15%">Nhà hàng</th>
                                            <th class="" width="15%">Món ăn</th>
                                            <th class="" width="15%">Số suất chờ xác nhận</th>
                                            <th class="" width="10%">Số suất đã xác nhận</th>
                                            <th class="" width="10%">Số suất đang chuẩn bị</th>
                                            <th class="" width="10%">Số suất đã chuẩn bị xong</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($listStatistic)) {
                                            foreach ($listStatistic as $itemStatistic) {
                                                $countDetail = count($itemStatistic->details);
                                                $detailOrders = $itemStatistic->details;
                                                $firstItem = $detailOrders[0];
                                                unset($detailOrders[0]);
                                        ?>
                                                <tr>
                                                    <td rowspan="<?php echo $countDetail; ?>"><?php echo $itemStatistic->wardName ?></td>
                                                    <td rowspan="<?php echo $countDetail; ?>"><?php echo $itemStatistic->partnerName ?></td>
                                                    <td rowspan="<?php echo $countDetail; ?>"><?php echo $itemStatistic->restaurantName ?></td>
                                                    <td><?php echo $firstItem->dishName; ?></td>
                                                    <td><?php echo $firstItem->waitingConfirmQuantity; ?></td>
                                                    <td><?php echo $firstItem->confirmedQuantity; ?></td>
                                                    <td><?php echo $firstItem->preparingQuantity; ?></td>
                                                    <td><?php echo $firstItem->alreadyQuantity; ?></td>
                                                </tr>
                                                <?php
                                                foreach ($detailOrders as $itemDetail) :
                                                ?>
                                                    <tr>
                                                        <td><?php echo $itemDetail->dishName; ?></td>
                                                        <td><?php echo $itemDetail->waitingConfirmQuantity; ?></td>
                                                        <td><?php echo $itemDetail->confirmedQuantity; ?></td>
                                                        <td><?php echo $itemDetail->preparingQuantity; ?></td>
                                                        <td><?php echo $itemDetail->alreadyQuantity; ?></td>
                                                    </tr>

                                            <?php endforeach;
                                            }
                                        } else { ?>
                                            <tr>
                                                <td style="padding: 20px 10px!important;" colspan="9">Không tìm thấy dữ
                                                    liệu phù hợp.</td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination" style="justify-content: flex-end;">
                                <?php if ($pager) : ?>
                                    <?php
                                    if (isset($uri) && $uri[0] != '') {
                                        //echo $pager->makeLinks($pageStatistic, $perPageStatistic, $totalStatistic, 'default_full', 3);
                                    } else {
                                        //echo $pager->makeLinks($pageStatistic, 5, $totalStatistic, 'default_full', 4);
                                    }
                                    ?>
                                <?php endif ?>
                            </div>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body confirmBody">
                <p>Bạn có chắc chắn xác nhận?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger btn-ok btnDeleteRow">Xóa</button>
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