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
                    <h3 class="card-content-title"><?php echo $title ?></h3>
                    <form action="" id="formSearchListOrdersWare" method="GET" class="notifacation-wrapper">
                        <?php
                            $checkNoti = get_cookie('__notiCate');
                            $checkNoti = explode('^_^', $checkNoti);
                            setcookie("__notiCate", '', time() + (1), '/');
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

                        <div class="menubar">
                            <div class="row mgbt tab-status">
                                <div class="col-md-3 col-sm-6 col-xs-12  pdr-menu">
                                    <a href="<?= base_url('khuyen-mai/danh-sach-khuyen-mai-san-pham-tang-kem') ?>"
                                        class=" tab-menu btn btn-inverse-primary btn-fw  <?php echo ($link_active == 'danh-sach-khuyen-mai-san-pham-tang-kem') ? ' activeStatus' : '' ?>">
                                        Danh sách sản phẩm tặng kèm <span></span></a>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12  pdr-menu">
                                    <a href="<?= base_url('khuyen-mai/danh-sach-khuyen-mai-don-hang') ?>"
                                        class=" tab-menu btn btn-inverse-primary btn-fw  <?php echo ($link_active == 'danh-sach-khuyen-mai-don-hang') ? ' activeStatus' : '' ?>">
                                        Danh sách khuyến mại đơn hàng <span></span></a>
                                </div>

                            </div>
                        </div>

                        <div class="row searchBar">
                            <div class="form-group col-md-4 pdr-menu ">
                                <input type="text"
                                    value="<?php echo (isset($conditions['namePromotion'])) ? $conditions['namePromotion'] : '' ?>"
                                    name="namePromotion" class="form-control" placeholder="Tên khuyến mãi">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="type" data-placeholder=""
                                    id="type">
                                    <option value="-1" selected>Loại khuyến mại</option>
                                    <option <?php echo ($conditions['type'] == 2 ) ? 'selected' : '' ?> value="2">
                                        Giảm phí ship</option>
                                    <option <?php echo ($conditions['type'] == 1) ? 'selected' : '' ?> value="1">
                                        Giảm tiền hàng</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy"
                                    placeholder="Bắt đầu" name="started"
                                    value="<?php echo (isset($conditions['started'])) ? $conditions['started'] : '' ?>"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy"
                                    placeholder="Kết thúc" name="stoped"
                                    value="<?php echo (isset($conditions['stoped'])) ? $conditions['stoped'] : '' ?>"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="status" data-placeholder=""
                                    id="status">
                                    <option value="-1" selected>Tất cả</option>
                                    <option <?php echo ($conditions['status'] === 1 ) ? 'selected' : '' ?> value="1">
                                        Hoạt động</option>
                                    <option <?php echo ($conditions['status'] === 0) ? 'selected' : '' ?> value="0">
                                        Không hoạt động</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-6 pdr-menu">
                                <div class="d-flex align-items-center">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text"
                                            onclick="addPromotionOrder()">Thêm khuyến mãi đơn hàng</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text"
                                            id="searchListOrder">Tìm kiếm</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text"
                                            href="<?= base_url('/khuyen-mai/danh-sach-khuyen-mai-don-hang') ?> ">Bỏ
                                            lọc</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="main-body">
                        <div class="card mt-2">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="vertical th-action" width="10%">
                                                <input class="checkAll check-action" id="checkAll" value="all-order"
                                                    name="check[]" type="checkbox">
                                                <button type="button" class="btn btn-success btn-icon-custom"
                                                    onclick="activeRowAllPromotion(2)" title="Active">
                                                    <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon-custom"
                                                    onclick="disableRowAllPromotion(2)" title="Disable">
                                                    <i class="mdi mdi-close-circle-outline"></i>
                                                </button>
                                            </th>
                                            <th class="vertical text-bold" width="10%">Loại khuyến mại</th>
                                            <th class="vertical text-bold" width="10%">Đơn vị tính</th>
                                            <th class="vertical text-bold" width="20%">Tên khuyến mại</th>
                                            <th class="vertical text-bold" width="10%">Điều kiện</th>
                                            <th class="vertical text-bold" width="10%">Giá trị/đơn vị tính</th>
                                            <th class="vertical text-bold" width="10%">Giá trị max/đơn hàng</th>
                                            <th class="vertical text-bold" width="10%">Thời gian <br>áp dụng</th>
                                            <th class="vertical text-bold" width="10%">Ngày tạo</th>
                                            <th class="vertical text-bold" width="10%">Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php 
                                            if(!empty($objects)){
                                                foreach ($objects as $row) { ?>
                                        <tr>
                                            <td class="text-center th-action">
                                                <input style="padding: 5px 9px;" type="checkbox" name="check[]"
                                                    class="checkSingle check-action" value="<?php echo $row['ID'] ?>" />
                                                <button type="button" class="btn btn-success btn-icon-custom"
                                                    onclick="activeRowPromotion(<?php echo $row['ID'] ?>, 2)"
                                                    title="Active">
                                                    <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                </button>
                                                <button class="btn btn-danger btn-icon-custom" type="button"
                                                    onclick="disableRowPromotion(<?php echo $row['ID'] ?>, 2)"
                                                    title="Disable">
                                                    <i class="mdi mdi-close-circle-outline"></i>
                                                </button>
                                                <button class="btn btn-primary btn-icon-custom" type="button"
                                                    onclick="editRowPromotionOrder(<?php echo $row['ID'] ?>)"
                                                    title="Sửa">
                                                    <i class="mdi mdi-pen"></i>
                                                </button>
                                            </td>
                                            <td><?php echo ($row['TYPE'] == 1 ) ? 'Giảm tiền hàng' : 'Giảm phí ship'; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo ($row['MEASURE_CONDITION'] == 1) ? 'Theo %' : 'Đồng'; ?></td>
                                            <td> <span><?php echo $row['NAME']; ?></span> </td>
                                            <td class="text-center"><?php echo number_format($row['CONDITION']) ?> đ
                                            </td>
                                            <td class="text-center"> <?php echo number_format($row['DISCOUNT_VALUE']) ?>
                                                <?php echo ($row['MEASURE_CONDITION'] == 1) ? '%' : 'đ' ?> </td>
                                            <td class="text-center"> <?php echo number_format($row['DISCOUNT_MAX']) ?> đ
                                            </td>

                                            <td class="text-center">
                                                <span>BĐ: <?php echo $row['STARTED_DATE'] ?></span><br>
                                                <span>KT: <?php echo $row['STOPPED_DATE'] ?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $row['CREATED_NAME'] ?></span><br>
                                                <span><?php echo $row['CREATED_DATE'] ?></span>
                                            </td>
                                            <td class="text-center" pid="<?php echo $row['ID'] ?>">
                                                <?php echo ($row['STATUS'] == 1) ? 'Hoạt động' : 'Không hoạt động'; ?>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                        <?php   } 
                                                }else{ ?>
                                        <tr>
                                            <td style="padding: 20px 10px!important;" colspan="9">Không tìm thấy dữ
                                                liệu phù hợp.</td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
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

<div class="modal modalCloseReload" id="addPromotionOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title promotionOrder" id="myModalLabel">Thêm khuyến mãi đơn hàng</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row pdn">
                    <div class="col-md-3">
                        <label for="typePromotionOrder">Loại khuyến mại <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select typePromotionOrder" id="typePromotionOrder"
                            name="typePromotionOrder" data-placeholder="Loại khuyến mại">
                            <option value="1">Giảm tiền hàng</option>
                            <option value="2">Giảm phí ship</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="measurePromotionOrder">Đơn vị tính <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select measurePromotionOrder" id="measurePromotionOrder"
                            name="measurePromotionOrder" data-placeholder="Đơn vị tính">
                            <option value="1">Theo %</option>
                            <option value="2">Đồng</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="namePromotionOrder"> Tên khuyến mãi <span style="color: red">(*)</span></label>
                        <input type="text" name="namePromotionOrder" class="form-control namePromotionOrder" onchange="checkExistPromotion(2, 'namePromotionOrder')"
                            id="namePromotionOrder" placeholder="Tên khuyến mãi" value="<?= $post['namePromotion'] ?>">
                        <span class="error_text errNamePromotionOrder errNamePromotion"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-6">
                        <label for="conditionPromotionOrder"> Điều kiện áp dụng <span
                                style="color: red">(*)</span></label>
                        <input type="text" name="conditionPromotionOrder" onkeypress="return isNumber(event)"
                            class="form-control conditionPromotionOrder" id="conditionPromotionOrder"
                            placeholder="Điều kiện áp dụng: 400.000"
                            onkeyup="number_format('conditionPromotionOrder', 1)"
                            value="<?= $post['conditionPromotionOrder'] ?>">
                        <span class="error_text errConditionOrder "></span>
                    </div>
                    <div class="col-md-3">
                        <label for="discountValuePromotionOrder">Giá trị / đơn vị tính <span
                                style="color: red">(*)</span></label>
                        <input type="text" name="discountValuePromotionOrder"
                            class="form-control discountValuePromotionOrder" onkeypress="return isNumber(event)"
                            id="discountValuePromotionOrder" placeholder="Giá trị"
                            value="<?= $post['discountValuePromotionOrder'] ?>">
                        <span class="error_text errDiscountValuePromotionOrder "></span>
                    </div>
                    <div class="col-md-3">
                        <label for="discountMaxPromotionOrder"> Giá trị max / 1 đơn hàng </label>
                        <input type="text" name="discountMaxPromotionOrder" onkeypress="return isNumber(event)"
                            class="form-control discountMaxPromotionOrder" id="discountMaxPromotionOrder"
                            placeholder="Giá trị max / 1 đơn hàng" value="<?= $post['discountMaxPromotionOrder'] ?>">
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-3">
                        <label for="startedPromotionOrder">Ngày bắt đầu <span style="color: red">(*)</span></label>
                        <input type="text" name="startedPromotionOrder"
                            class="form-control startedPromotionOrder datepicker" id="startedPromotionOrder"
                            placeholder="Ngày bắt đầu" value="<?= $post['startedPromotionOrder'] ?>" autocomplete="off">
                        <span class="error_text errStartedPromotionOrder"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="stopedPromotionOrder">Ngày kết thúc <span style="color: red">(*)</span></label>
                        <input type="text" name="stopedPromotionOrder"
                            class="form-control stopedPromotionOrder datepicker" id="stopedPromotionOrder"
                            placeholder="Ngày kết thúc" value="<?= $post['stopedPromotionOrder'] ?>" autocomplete="off">
                        <span class="error_text errStopedPromotionOrder"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="statusPromotionOrder"> Trạng thái <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select statusPromotionOrder" id="statusPromotionOrder"
                            name="statusPromotionOrder">
                            <option value="0">Không hoạt động</option>
                            <option class="statusPromotionOrderYes" value="1">Hoạt động</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" class="promotionOrderId" id="promotionOrderId" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success btn-ok savePromotionOrder savePromotion" disabled>Thêm mới</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCloseReload fade" id="confirmDeleteRow" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body confirmBody">
                <p>Bạn có chắc chắn muốn xóa.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger btn-ok btnDeleteRow" data-dismiss="modal">Xóa</button>
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