<!-- partial:partials/_navbar.html -->
<?php 
  $requestUri = explode("/",$_SERVER['REQUEST_URI'])[2];
  $link_active = explode("?",$requestUri)[0];
?>

<div class="main-panel">
    <div class="content-wrapper">
        <form method="get" action="">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-content-title"><?php echo $title ?></h2>
                    <form action="" id="formSearchListOrdersWare" method="GET" class="notifacation-wrapper">
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
                                }else {
                                    echo $checkNoti[1];
                                }
                            } else if ($checkNoti[0] == 'false') {
                                if (!empty($checkNoti[2])) {
                                    echo $checkNoti[2];
                                }else {
                                    echo $checkNoti[1];
                                }
                            }
                        ?>
                            </div>
                        </div>

                        <div class="row searchBar">
                            <div class="form-group col-md-4 pdr-menu ">
                                <input type="text"
                                    value="<?php echo (isset($get['keySearch'])) ? $get['keySearch'] : '' ?>"
                                    name="keySearch" class="form-control keySearch" placeholder="Mã đơn hàng, sđt,..."
                                    id="keySearch">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select status" name="status" data-placeholder=""
                                    id="status">
                                    <option <?php echo (isset($get['status']) && $get['status'] == -1) ? 'selected' : ''; ?> value="-1"> Chọn trạng thái </option>
                                    <?php
                                        foreach($arrStatus as $keyStatus => $status){ ?>
                                            <option <?php echo (isset($get['status']) && $get['status'] == $keyStatus) ? 'selected' : ''; ?> value="<?php echo $keyStatus ?>"> <?php echo $status ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2 pdr-menu">
                                <input type="text" class="datepicker form-control started" data-date-format="dd/mm/yyyy" placeholder="Bắt đầu" name="started" 
                                value="<?php echo (isset($get['started'])) ? $get['started'] : '' ?>" autocomplete="off">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <input type="text" class="datepicker form-control stoped" data-date-format="dd/mm/yyyy" placeholder="Kết thúc" name="stoped" 
                                value="<?php echo (isset($get['stoped'])) ? $get['stoped'] : '' ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-4 pdr-menu">
                                
                            </div>
                            <div class="form-group col-md-8 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text" onclick="exportExcelOrder(1)"
                                            id="searchListOrder">Xuất excel thực tế</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text" onclick="exportExcelOrder(0)"
                                            id="searchListOrder">Xuất excel tạm tính</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text"
                                            id="searchListOrder">Tìm kiếm</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text"
                                            href="<?= base_url('/don-hang/danh-sach-don-hang') ?> ">Bỏ lọc</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="main-body">
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="vertical" rowspan="2" width="7%">
                                                <input class="checkAll check-action" id="checkAll" value="all-order" name="check[]" type="checkbox">
                                                    <button type="button" class="btn btn-success btn-icon-custom" onclick="changeDeliveryAll(1)" title="Đẩy sang đơn vị vận chuyển">
                                                        <i class="mdi mdi-package-up"></i>
                                                    </button>
                                                </th>
                                                <th class="vertical" rowspan="2" width="8%">Mã đơn hàng</th>
                                                <th class="vertical" rowspan="2" width="5%">SĐT người đặt</th>
                                                <th class="vertical" rowspan="2" width="10%">Người nhận</th>
                                                <th class="vertical" rowspan="2" width="8%">SĐT người nhận</th>
                                                <th class="vertical" rowspan="2" width="10%">Địa chỉ người nhận</th>
                                                <th class="vertical" colspan="3" width="10%">Tổng tiền</th>
                                                <th class="vertical"rowspan="2" width="10%">Ngày tạo đơn</th>
                                                <th class="vertical"rowspan="2" width="10%">Ghi chú</th>
                                                <th class="vertical"rowspan="2" width="10%">Thời gian mong muốn</th>
                                                <th class="vertical"rowspan="2" width="10%">Trạng thái</th>
                                            </tr>
                                            <tr>
                                                <th>COD</th>
                                                <th>Tổng phí</th>
                                                <th>Tổng tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php 
                                            if(!empty($objects->historyOrders)){
                                            foreach ($objects->historyOrders as $item) { ?>
                                            <tr>
                                                <td>
                                                    <?php if($item->status == 101): ?>
                                                        <input style="padding: 5px 9px;" type="checkbox" name="check[]" class="checkSingle check-action" value="<?php echo $item->orderCode ?>" />
                                                    <button class="btn btn-success btn-icon-custom" type="button" onclick="changeDelivery(<?php echo $item->orderCode ?>)" title="Đẩy sang đơn vị vận chuyển">
                                                    <i class="mdi mdi-package-up"></i>
                                                    </button>
                                                    <?php endif; ?>

                                                    <?php $arrCancel = ['100','1002','1003']; if( in_array($item->status, $arrCancel)): ?>
                                                    <button class="btn btn-danger btn-icon-custom" type="button" onclick="cancelOrder(<?php echo $item->orderCode ?>)" title="Hủy đơn hàng">
                                                    <i class="mdi mdi-close-circle-outline"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                    <?php $arPackage = ['100,1002']; if( in_array($item->status, $arPackage)): ?>
                                                    <a class="btn btn-info btn-icon-custom" href="<?php echo base_url('/don-hang/chuan-bi-don-hang?orderId='.$item->orderCode) ?>" title="Chuẩn bị đơn hàng"> <i class="mdi mdi-package-variant"></i> </a>
                                                    <?php endif; ?>

                                                    <?php $arConfirm = ['1002']; if( in_array($item->status, $arConfirm)): ?>
                                                        <button class="btn btn-success btn-icon-custom" type="button" onclick="confirmOrder(<?php echo $item->orderCode ?>,1)" title="Xác nhận đơn hàng">
                                                        <i class="mdi mdi-check"></i>
                                                    <?php endif; ?>
                                                    <?php $arConfirm = ['1003']; if( in_array($item->status, $arConfirm)): ?>
                                                        <button class="btn btn-success btn-icon-custom" type="button" onclick="confirmOrder(<?php echo $item->orderCode ?>,2)" title="Chuyển đơn chuẩn bị hàng">
                                                        <i class="mdi mdi-cloud-upload"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td><a href="<?php echo base_url('don-hang/chi-tiet-don-hang/'.$item->orderCode) ?>"><?php echo $item->orderCode; ?></a></td>
                                                <td><?php echo $item->orderPhone ?></td>
                                                <td>
                                                    <?php echo $item->receiverName ?>
                                                </td>
                                                <td><?php echo $item->receiverPhone ?></td>
                                                <td><?php echo $item->receiverAddress; ?></td>
                                                <td><?php echo number_format($item->totalOrder); ?></td>
                                                <td><?php echo number_format($item->totalFee); ?></td>
                                                <td><?php echo number_format($item->totalPayment); ?></td>
                                                <td><?php echo $item->createdDate; ?></td>
                                                <td><?php echo $item->note; ?></td>
                                                <td><?php echo $item->expectDeliveryDate; ?></td>
                                                <td><?php echo $item->message; ?></td>
                                            </tr>
                                            <?php $i++; ?>
                                            <?php   } 
                                                }else{ ?>
                                            <tr>
                                                <td style="padding: 20px 10px!important;" colspan="10">Không tìm thấy dữ liệu phù hợp.</td>
                                            </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="pagination" style="justify-content: flex-end;">
                            <?php if ($pager): ?>
                            <?php 
                    if(isset($uri) && $uri[0] !=''){
                        echo $pager->makeLinks($page, $perPage, $total, 'default_full', 3);
                    }else{
                        echo $pager->makeLinks($page, PERPAGE, $total, 'default_full', 4); 
                    }
                    ?>
                            <?php endif?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal modalCloseReload fade" id="confirmChangeDelivery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn chuyển cho đơn vị vận chuyển các đơn hàng đã chọn?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary btn-ok" onclick="changeDeliveryAll(1)" data-dismiss="modal">Chuyển đơn vị vận chuyển</button>
            </div>
        </div>
    </div>
</div>
<div class="modal modalCloseReload fade" id="confirmCancelOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger btn-ok confirmCalcelOrder" onclick="confirmCalcelOrder()" data-dismiss="modal">Hủy đơn hàng</button>
            </div>
        </div>
    </div>
</div>

<?php if ($checkNoti) {?>
<script>
$(document).ready(function() {
    $(".notification-container").fadeIn();

    // Set a timeout to hide the element again
    setTimeout(function() {
        $(".notification-container").fadeOut();
    }, 5000);
});
</script>
<?php }?>