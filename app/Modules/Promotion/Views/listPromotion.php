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

                        <div class="menubar">
                            <div class="row mgbt tab-status">
                                <div class="col-md-3 col-sm-6 col-xs-12  pdr-menu">
                                    <a href="<?= base_url('khuyen-mai/danh-sach-khuyen-mai-san-pham-tang-kem') ?>" class=" tab-menu btn btn-inverse-primary btn-fw  <?php echo ($link_active == 'danh-sach-khuyen-mai-san-pham-tang-kem') ? ' activeStatus' : '' ?>">
                                        Danh sách sản phẩm tặng kèm <span></span></a>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12  pdr-menu">
                                    <a href="<?= base_url('khuyen-mai/danh-sach-khuyen-mai-don-hang') ?>" class=" tab-menu btn btn-inverse-primary btn-fw  <?php echo ($link_active == 'danh-sach-khuyen-mai-don-hang') ? ' activeStatus' : '' ?>">
                                        Danh sách khuyến mại đơn hàng <span></span></a>
                                </div>

                            </div>
                        </div>

                        <div class="row searchBar">
                            <div class="form-group col-md-6 pdr-menu ">
                                <input type="text" value="<?php echo (isset($conditions['namePromotion'])) ? $conditions['namePromotion'] : '' ?>" name="namePromotion" class="form-control" placeholder="Tên khuyến mãi">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" placeholder="Bắt đầu" name="started" value="<?php echo (isset($conditions['started'])) ? $conditions['started'] : '' ?>" autocomplete="off">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" placeholder="Kết thúc" name="stoped" value="<?php echo (isset($conditions['stoped'])) ? $conditions['stoped'] : '' ?>" autocomplete="off">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="status" data-placeholder="" id="status">
                                    <option <?php echo ($conditions['status'] == -1) ? 'selected' : '' ?> value="-1" selected>Tất cả</option>
                                    <option <?php echo ($conditions['status'] == 1) ? 'selected' : '' ?> value="1">
                                        Hoạt động</option>
                                    <option <?php echo ($conditions['status'] == 0) ? 'selected' : '' ?> value="0">
                                        Không hoạt động</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-6 pdr-menu">
                                <div class="d-flex align-items-center">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text" onclick="addPromotion()">Thêm sản phẩm tặng kèm</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-primary btn-icon-text" onclick="addSetPromotion()">Thêm sản phẩm tặng kèm cho set</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text" id="searchListOrder">Tìm kiếm</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text" href="<?= base_url('/khuyen-mai/danh-sach-khuyen-mai-san-pham-tang-kem') ?> ">Bỏ
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
                                                <input class="checkAll check-action" id="checkAll" value="all-order" name="check[]" type="checkbox">
                                                <button type="button" class="btn btn-success btn-icon-custom" onclick="activeRowAllPromotion(1)" title="Active">
                                                    <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon-custom" onclick="disableRowAllPromotion(1)" title="Disable">
                                                    <i class="mdi mdi-close-circle-outline"></i>
                                                </button>
                                            </th>
                                            <th class="vertical text-bold" width="10%">Khuyến mãi</th>
                                            <th class="vertical text-bold" width="10%">Sản phẩm</th>
                                            <th class="vertical text-bold" width="10%">Giới hạn<br>Max</th>
                                            <th class="vertical text-bold" width="5%">Điều kiện</th>
                                            <th class="vertical text-bold" width="25%">Sản phẩm tặng kèm<br>Tên sản phẩm
                                                | Quy cách/Giá | Số lượng</th>
                                            <th class="vertical text-bold" width="10%">Thời gian <br>áp dụng</th>
                                            <th class="vertical text-bold" width="10%">Ngày tạo</th>
                                            <th class="vertical text-bold" width="10%">Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php
                                        if (!empty($objects)) {
                                            foreach ($objects as $row) {
                                                if (isset($row['SUB_PRODUCT']) && !empty($row['SUB_PRODUCT'])) {
                                                    $countRow = count($row['SUB_PRODUCT']) + 1;
                                                } else {
                                                    $countRow = 1;
                                                }
                                        ?>
                                                <tr>
                                                    <td class="text-center th-action" rowspan="<?php echo $countRow ?>">
                                                        <input style="padding: 5px 9px;" type="checkbox" name="check[]" class="checkSingle check-action" value="<?php echo $row['ID'] ?>" />
                                                        <button type="button" class="btn btn-success btn-icon-custom" onclick="activeRowPromotion(<?php echo $row['ID'] ?>, 1)" title="Active">
                                                            <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-icon-custom" type="button" onclick="disableRowPromotion(<?php echo $row['ID'] ?>, 1)" title="Disable">
                                                            <i class="mdi mdi-close-circle-outline"></i>
                                                        </button>
                                                    </td>
                                                    <td rowspan="<?php echo $countRow ?>"><?php echo $row['NAME'] ?></td>
                                                    <td><?php echo (!isset($row['SUB_PRODUCT']) && empty($row['SUB_PRODUCT'])) ? $row['PRODUCT_NAME'] : 'SET';  ?></td>
                                                    <td>
                                                        <span>LIMIT:
                                                            <?php echo ($row['LIMIT_APPLY']) ? number_format($row['LIMIT_APPLY']) : '<span style="font-size: 20px;">&#8734;</span>' ?></span><br>
                                                        <span>Max: <?php echo $row['QUANTITY_MAX'] ?></span>
                                                    </td>
                                                    <td class="text-center"><?php echo number_format($row['CONDITION']) ?>
                                                        <?php echo ($row['MEASURE_CONDITION'] == 1) ? 'gr' : 'đ'; ?>
                                                    </td>
                                                    <td rowspan="<?php echo $countRow ?>">
                                                        <table class="table table-borderless" style="width: 100%;">
                                                            <?php
                                                            $dataPlus = $promotionModels->getListPromotionDetail($row['ID']);
                                                            foreach ($dataPlus as $key => $valPlus) { ?>
                                                                <tr>
                                                                    <td style="width: 50%; text-align: left;">&#164;
                                                                        <?php echo $valPlus['NAME'] ?></td>
                                                                    <td style="width: 30%; text-align: right;">
                                                                        <?php echo number_format($valPlus['WEIGHT']) ?>
                                                                        gr/<?php echo number_format($valPlus['PRICE']) ?> đ</td>
                                                                    <td style="width: 20%; text-align: right;">
                                                                        <?php echo number_format($valPlus['QUANTITY']) ?></td>
                                                                </tr>
                                                            <?php }
                                                            ?>
                                                        </table>
                                                    </td>
                                                    <td class="text-center" rowspan="<?php echo $countRow ?>">
                                                        <span>BĐ: <?php echo $row['STARTED_DATE'] ?></span><br>
                                                        <span>KT: <?php echo $row['STOPPED_DATE'] ?></span>
                                                    </td>
                                                    <td rowspan="<?php echo $countRow ?>"> 
                                                        <span><?php echo $row['CREATED_NAME'] ?></span><br>
                                                        <span><?php echo $row['CREATED_DATE'] ?></span>
                                                    </td>
                                                    <td class="text-center" pid="<?php echo $row['ID'] ?>" rowspan="<?php echo $countRow ?>">
                                                        <?php echo ($row['STATUS'] == 1) ? 'Hoạt động' : 'Không hoạt động'; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                if (isset($row['SUB_PRODUCT']) && !empty($row['SUB_PRODUCT'])) :
                                                    $subProducts = $row['SUB_PRODUCT'];
                                                    foreach ($subProducts as $subItem) :
                                                ?>
                                                        <tr>
                                                            <td><?php echo $subItem['PRODUCT_NAME'] ?></td>
                                                            <td>
                                                                <span>LIMIT:
                                                                    <?php echo ($subItem['LIMIT_APPLY']) ? number_format($subItem['LIMIT_APPLY']) : '<span style="font-size: 20px;">&#8734;</span>' ?></span><br>
                                                                <span>Max: <?php echo $subItem['QUANTITY_MAX'] ?></span>
                                                            </td>
                                                            <td class="text-center"><?php echo number_format($subItem['CONDITION']) ?>
                                                                <?php echo ($subItem['MEASURE_CONDITION'] == 1) ? 'gr' : 'đ'; ?>
                                                            </td>
                                                            <td>
                                                                <table class="table table-borderless" style="width: 100%;">
                                                                    <?php
                                                                    $dataPlus = $promotionModels->getListPromotionDetail($subItem['ID']);
                                                                    foreach ($dataPlus as $key => $valPlus) { ?>
                                                                        <tr>
                                                                            <td style="width: 50%; text-align: left;">&#164;
                                                                                <?php echo $valPlus['NAME'] ?></td>
                                                                            <td style="width: 30%; text-align: right;">
                                                                                <?php echo number_format($valPlus['WEIGHT']) ?>
                                                                                gr/<?php echo number_format($valPlus['PRICE']) ?> đ</td>
                                                                            <td style="width: 20%; text-align: right;">
                                                                                <?php echo number_format($valPlus['QUANTITY']) ?></td>
                                                                        </tr>
                                                                    <?php }
                                                                    ?>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                                <?php $i++; ?>
                                            <?php   }
                                        } else { ?>
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

<div class="modal modalCloseReload" id="addPromotion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Thêm banners</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row pdn">
                    <div class="col-md-6">
                        <label for="products">Sản phẩm <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select products" id="products" name="products">
                            <option value="">Chọn sản phẩm</option>
                            <?php echo $dataProduct ?>
                        </select>
                        <span class="error_text errProducts"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="nameCate"> Tên khuyến mãi <span style="color: red">(*)</span></label>
                        <input type="text" name="namePromotion" class="form-control namePromotion" id="namePromotion" onchange="checkExistPromotion(1, 'namePromotion')" placeholder="Tên khuyến mãi" value="<?= $post['namePromotion'] ?>">
                        <span class="error_text errNamePromotion"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-3">
                        <label for="measure">Đơn vị tính <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select measure" id="measure" name="measure" data-placeholder="Đơn vị tính">
                            <option value="1">Gram</option>
                            <option value="2">Đồng</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="condition"> Điều kiện áp dụng <span style="color: red">(*)</span></label>
                        <input type="text" name="condition" class="form-control condition" id="condition" placeholder="Điều kiện áp dụng" value="<?= $post['condition'] ?>">
                        <span class="error_text errCondition"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="limitApply">Giới hạn áp dụng</label>
                        <input type="text" name="limitApply" class="form-control limitApply" id="limitApply" placeholder="Điều kiện áp dụng" value="<?= $post['limitApply'] ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="quantityMax"> Số lượng Max / 1 đơn hàng <span style="color: red">(*)</span></label>
                        <input type="text" name="quantityMax" class="form-control quantityMax" id="quantityMax" placeholder="Số lượng Max / 1 đơn hàng" value="<?= $post['quantityMax'] ?>">
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-3">
                        <label for="started">Ngày bắt đầu <span style="color: red">(*)</span></label>
                        <input type="text" name="started" class="form-control started datepicker" id="started" placeholder="Ngày bắt đầu" value="<?= $post['started'] ?>" autocomplete="off">
                        <span class="error_text errStarted"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="stoped">Ngày kết thúc <span style="color: red">(*)</span></label>
                        <input type="text" name="stoped" class="form-control stoped datepicker" id="stoped" placeholder="Ngày kết thúc" value="<?= $post['stoped'] ?>" autocomplete="off">
                        <span class="error_text errStoped"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="status"> Trạng thái <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select status" id="status" name="status">
                            <option value="0">Không hoạt động</option>
                            <option class="statusYes" value="1">Hoạt động</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-9">
                    </div>
                    <div class="col-md-3 text-right">
                        <button type="button" class="btn btn-success btn-ok addProductPlus" count="0"><span><i class="mdi mdi-plus-circle-outline"></i></span> Thêm sản phẩm tặng kèm</button>
                    </div>
                </div>
                <div class="form-group row pdn productPlusItem">
                    <div class="col-md-4">
                        <label for="productPlus">Sản phẩm tặng kèm <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select productPlusKey-0 productPlus" key="0" name="productPlus">
                            <option value="">Chọn sản phẩm tặng kèm</option>
                            <?php echo $dataProduct ?>
                        </select>
                        <span class="error_text errProductPlus-0"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="productPrice">Quy cách đóng gói <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select productPriceKey-0 productPrice" name="productPrice">
                            <option value="0">Chọn quy cách đóng gói</option>
                        </select>
                        <span class="error_text errProductPrice-0"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="quantity">Số lượng <span style="color: red">(*)</span></label>
                        <input type="text" name="quantity" class="form-control quantity quantityKey-0" value="1">
                        <span class="error_text errQuantity-0"></span>
                    </div>
                    <!-- <div class="col-md-2">
                        <label for="pricePlus">Giá <span style="color: red">(*)</span></label>
                        <input type="text" name="pricePlus" class="form-control pricePlusKey-0 pricePlus" value="0">
                        <span class="error_text errPricePlus-0"></span>
                    </div> -->
                    <div class="col-md-1">
                        <label for="removeProductPlus" class="blRemoveProductPlus"></label>
                        <button type="button" class="btn btn-danger removeProductPlus removeProductPlus-0"><span><i class="mdi mdi-minus-circle-outline"></i></span></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success btn-ok savePromotion" disabled>Thêm mới</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCloseReload" id="addPromotionOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <select class="form-control chosen-select typePromotionOrder" id="typePromotionOrder" name="typePromotionOrder" data-placeholder="Loại khuyến mại">
                            <option value="1">Giảm tiền hàng</option>
                            <option value="2">Giảm phí ship</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="measurePromotionOrder">Đơn vị tính <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select measurePromotionOrder" id="measurePromotionOrder" name="measurePromotionOrder" data-placeholder="Đơn vị tính">
                            <option value="1">Theo %</option>
                            <option value="2">Đồng</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="namePromotionOrder"> Tên khuyến mãi <span style="color: red">(*)</span></label>
                        <input type="text" name="namePromotionOrder" class="form-control namePromotionOrder" id="namePromotionOrder" placeholder="Tên khuyến mãi" value="<?= $post['namePromotion'] ?>">
                        <span class="error_text errNamePromotionOrder"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-6">
                        <label for="conditionPromotionOrder"> Điều kiện áp dụng <span style="color: red">(*)</span></label>
                        <input type="text" name="conditionPromotionOrder" class="form-control conditionPromotionOrder" id="conditionPromotionOrder" placeholder="Điều kiện áp dụng: 400.000" value="<?= $post['conditionPromotionOrder'] ?>">
                        <span class="error_text errConditionOrder "></span>
                    </div>
                    <div class="col-md-3">
                        <label for="discountValuePromotionOrder">Giá trị / đơn vị tính <span style="color: red">(*)</span></label>
                        <input type="text" name="discountValuePromotionOrder" class="form-control discountValuePromotionOrder" id="discountValuePromotionOrder" placeholder="Giá trị" value="<?= $post['discountValuePromotionOrder'] ?>">
                        <span class="error_text errDiscountValuePromotionOrder "></span>
                    </div>
                    <div class="col-md-3">
                        <label for="discountMaxPromotionOrder"> Giá trị max / 1 đơn hàng </label>
                        <input type="text" name="discountMaxPromotionOrder" class="form-control discountMaxPromotionOrder" id="discountMaxPromotionOrder" placeholder="Giá trị max / 1 đơn hàng" value="<?= $post['discountMaxPromotionOrder'] ?>">
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-3">
                        <label for="startedPromotionOrder">Ngày bắt đầu <span style="color: red">(*)</span></label>
                        <input type="text" name="startedPromotionOrder" class="form-control startedPromotionOrder datepicker" id="startedPromotionOrder" placeholder="Ngày bắt đầu" value="<?= $post['startedPromotionOrder'] ?>" autocomplete="off">
                        <span class="error_text errStartedPromotionOrder"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="stopedPromotionOrder">Ngày kết thúc <span style="color: red">(*)</span></label>
                        <input type="text" name="stopedPromotionOrder" class="form-control stopedPromotionOrder datepicker" id="stopedPromotionOrder" placeholder="Ngày kết thúc" value="<?= $post['stopedPromotionOrder'] ?>" autocomplete="off">
                        <span class="error_text errStopedPromotionOrder"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="statusPromotionOrder"> Trạng thái <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select statusPromotionOrder" id="statusPromotionOrder" name="statusPromotionOrder">
                            <option value="0">Không hoạt động</option>
                            <option class="statusPromotionOrderYes" value="1">Hoạt động</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success btn-ok savePromotionOrder">Thêm mới</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCloseReload" id="addSetPromotion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Thêm khuyến mãi cho set</h4>
                <!-- <div class="row rdoWrapTypePromotions">
                    <input type="radio" class="typePromotion" id="buyProduct" name="typePromotion" value="1" checked="">
                    <label for="buyProduct" class="fz13" style="margin-right:15px">Sản phẩm</label>

                    <input type="radio" class="typePromotion" id="promotionProduct" name="typePromotion" value="2">
                    <label class="fz13" for="promotionProduct">Set sản phẩm</label>
                </div> -->
            </div>
            <div class="modal-body">
                <div class="form-group row pdn appendSetProduct">
                    <div class="col-md-6 ">
                        <label for="namePromotionSet"> Tên khuyến mãi <span style="color: red">(*)</span></label>
                        <input type="text" name="namePromotionSet" class="form-control namePromotionSet" id="namePromotionSet" onchange="checkExistPromotion(1, 'namePromotionSet')" placeholder="Tên khuyến mãi" value="<?= $post['namePromotionSet'] ?>">
                        <span class="error_text errNamePromotionSet"></span>
                    </div>
                    <div class="col-md-6 text-right btnAddProductSet">
                        <label for="" class="blRemoveProductPlus"></label>
                        <button type="button" class="btn btn-success btn-ok addProductSetPlus" count="0"><span><i class="mdi mdi-plus-circle-outline"></i></span> Thêm sản phẩm set</button>
                    </div>
                </div>

                <div class="wrapperProductSet">
                    <div class="form-group row pdn setProductPlusItem">
                        <div class="col-md-4">
                            <label for="setProductPlus">Sản phẩm set <span style="color: red">(*)</span></label>
                            <select class="form-control chosen-select setProductPlusKey-0 setProductPlus" key="0" name="setProductPlus">
                                <option value="">Chọn sản phẩm set</option>
                                <?php echo $dataProduct ?>
                            </select>
                            <span class="error_text errSetProductPlus-0"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="measureSet-0">Đơn vị tính <span style="color: red">(*)</span></label>
                            <select class="form-control chosen-select measureSet-0" id="measureSet-0" name="measureSet-0" data-placeholder="Đơn vị tính">
                                <option value="1">Gram</option>
                                <option value="2">Đồng</option>
                            </select>
                            <span class="error_text errMeasureSet-0"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="conditionSet-0"> Điều kiện áp dụng <span style="color: red">(*)</span></label>
                            <input type="text" name="conditionSet-0" class="form-control conditionSet-0" id="conditionSet-0" placeholder="Điều kiện áp dụng" value="<?= $post['conditionSet'] ?>">
                            <span class="error_text errConditionSet-0"></span>
                        </div>
                        <div class="col-md-1">
                            <label for="removeProductPlus" class="blRemoveSetProductPlus blRemoveProductPlus"></label>
                            <button type="button" class="btn btn-danger removeProductPlus removeProductPlus-0"><span><i class="mdi mdi-minus-circle-outline"></i></span></button>
                        </div>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-3">
                        <label for="startedSet">Ngày bắt đầu <span style="color: red">(*)</span></label>
                        <input type="text" name="startedSet" class="form-control startedSet datepicker" id="startedSet" placeholder="Ngày bắt đầu" value="<?= $post['startedSet'] ?>" autocomplete="off">
                        <span class="error_text errStartedSet"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="stopedSet">Ngày kết thúc <span style="color: red">(*)</span></label>
                        <input type="text" name="stopedSet" class="form-control stopedSet datepicker" id="stopedSet" placeholder="Ngày kết thúc" value="<?= $post['stopedSet'] ?>" autocomplete="off">
                        <span class="error_text errStopedSet"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="limitApplySet">Giới hạn áp dụng</label>
                        <input type="text" name="limitApplySet" class="form-control limitApplySet" id="limitApplySet" placeholder="Điều kiện áp dụng" value="<?= $post['limitApplySet'] ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="quantityMaxSet"> Số lượng Max / 1 đơn hàng <span style="color: red">(*)</span></label>
                        <input type="text" name="quantityMaxSet" class="form-control quantityMaxSet" id="quantityMaxSet" placeholder="Số lượng Max / 1 đơn hàng" value="<?= $post['quantityMaxSet'] ?>">
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-6">
                        <label for="statusSet"> Trạng thái <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select statusSet" id="statusSet" name="statusSet">
                            <option value="0">Không hoạt động</option>
                            <option class="statusSetYes" value="1">Hoạt động</option>
                        </select>
                    </div>
                    <div class="col-md-6 text-right">
                        <label for="" class="blRemoveProductPlus"></label>
                        <button type="button" class="btn btn-success btn-ok addProductPlusForSet" count="0"><span><i class="mdi mdi-plus-circle-outline"></i></span> Thêm sản phẩm tặng kèm</button>
                    </div>
                </div>
                <div class="form-group row pdn productPlusItemSet">
                    <div class="col-md-4">
                        <label for="productSetPlus">Sản phẩm tặng kèm <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select productSetPlusKey-0 productSetPlus" key="0" name="productPlus">
                            <option value="">Chọn sản phẩm tặng kèm</option>
                            <?php echo $dataProduct ?>
                        </select>
                        <span class="error_text errProductPlus-0"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="productSetPrice">Quy cách đóng gói <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select productSetPriceKey-0 productSetPrice" name="productSetPrice">
                            <option value="0">Chọn quy cách đóng gói</option>
                        </select>
                        <span class="error_text errProductSetPrice-0"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="quantitySet">Số lượng <span style="color: red">(*)</span></label>
                        <input type="text" name="quantitySet" class="form-control quantitySet quantitySetKey-0" value="1">
                        <span class="error_text errQuantitySet-0"></span>
                    </div>
                    <!-- <div class="col-md-2">
                        <label for="priceSetPlus">Giá <span style="color: red">(*)</span></label>
                        <input type="text" name="priceSetPlus" class="form-control priceSetPlusKey-0 priceSetPlus" value="0">
                        <span class="error_text errPriceSetPlus-0"></span>
                    </div> -->
                    <div class="col-md-1">
                        <label for="removeProductSetPlus" class="blRemoveProductPlus"></label>
                        <button type="button" class="btn btn-danger removeProductSetPlus removeProductSetPlus-0"><span><i class="mdi mdi-minus-circle-outline"></i></span></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success btn-ok saveSetPromotion" disabled>Thêm mới</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteRow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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