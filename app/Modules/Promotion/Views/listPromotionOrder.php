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
                                        Danh s??ch s???n ph???m t???ng k??m <span></span></a>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12  pdr-menu">
                                    <a href="<?= base_url('khuyen-mai/danh-sach-khuyen-mai-don-hang') ?>"
                                        class=" tab-menu btn btn-inverse-primary btn-fw  <?php echo ($link_active == 'danh-sach-khuyen-mai-don-hang') ? ' activeStatus' : '' ?>">
                                        Danh s??ch khuy???n m???i ????n h??ng <span></span></a>
                                </div>

                            </div>
                        </div>

                        <div class="row searchBar">
                            <div class="form-group col-md-4 pdr-menu ">
                                <input type="text"
                                    value="<?php echo (isset($conditions['namePromotion'])) ? $conditions['namePromotion'] : '' ?>"
                                    name="namePromotion" class="form-control" placeholder="T??n khuy???n m??i">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="type" data-placeholder=""
                                    id="type">
                                    <option value="-1" selected>Lo???i khuy???n m???i</option>
                                    <option <?php echo ($conditions['type'] == 2 ) ? 'selected' : '' ?> value="2">
                                        Gi???m ph?? ship</option>
                                    <option <?php echo ($conditions['type'] == 1) ? 'selected' : '' ?> value="1">
                                        Gi???m ti???n h??ng</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy"
                                    placeholder="B???t ?????u" name="started"
                                    value="<?php echo (isset($conditions['started'])) ? $conditions['started'] : '' ?>"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy"
                                    placeholder="K???t th??c" name="stoped"
                                    value="<?php echo (isset($conditions['stoped'])) ? $conditions['stoped'] : '' ?>"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="status" data-placeholder=""
                                    id="status">
                                    <option value="-1" selected>T???t c???</option>
                                    <option <?php echo ($conditions['status'] === 1 ) ? 'selected' : '' ?> value="1">
                                        Ho???t ?????ng</option>
                                    <option <?php echo ($conditions['status'] === 0) ? 'selected' : '' ?> value="0">
                                        Kh??ng ho???t ?????ng</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-6 pdr-menu">
                                <div class="d-flex align-items-center">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text"
                                            onclick="addPromotionOrder()">Th??m khuy???n m??i ????n h??ng</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text"
                                            id="searchListOrder">T??m ki???m</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text"
                                            href="<?= base_url('/khuyen-mai/danh-sach-khuyen-mai-don-hang') ?> ">B???
                                            l???c</a>
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
                                            <th class="vertical text-bold" width="10%">Lo???i khuy???n m???i</th>
                                            <th class="vertical text-bold" width="10%">????n v??? t??nh</th>
                                            <th class="vertical text-bold" width="20%">T??n khuy???n m???i</th>
                                            <th class="vertical text-bold" width="10%">??i???u ki???n</th>
                                            <th class="vertical text-bold" width="10%">Gi?? tr???/????n v??? t??nh</th>
                                            <th class="vertical text-bold" width="10%">Gi?? tr??? max/????n h??ng</th>
                                            <th class="vertical text-bold" width="10%">Th???i gian <br>??p d???ng</th>
                                            <th class="vertical text-bold" width="10%">Ng??y t???o</th>
                                            <th class="vertical text-bold" width="10%">Tr???ng th??i</th>
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
                                                    title="S???a">
                                                    <i class="mdi mdi-pen"></i>
                                                </button>
                                            </td>
                                            <td><?php echo ($row['TYPE'] == 1 ) ? 'Gi???m ti???n h??ng' : 'Gi???m ph?? ship'; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo ($row['MEASURE_CONDITION'] == 1) ? 'Theo %' : '?????ng'; ?></td>
                                            <td> <span><?php echo $row['NAME']; ?></span> </td>
                                            <td class="text-center"><?php echo number_format($row['CONDITION']) ?> ??
                                            </td>
                                            <td class="text-center"> <?php echo number_format($row['DISCOUNT_VALUE']) ?>
                                                <?php echo ($row['MEASURE_CONDITION'] == 1) ? '%' : '??' ?> </td>
                                            <td class="text-center"> <?php echo number_format($row['DISCOUNT_MAX']) ?> ??
                                            </td>

                                            <td class="text-center">
                                                <span>B??: <?php echo $row['STARTED_DATE'] ?></span><br>
                                                <span>KT: <?php echo $row['STOPPED_DATE'] ?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $row['CREATED_NAME'] ?></span><br>
                                                <span><?php echo $row['CREATED_DATE'] ?></span>
                                            </td>
                                            <td class="text-center" pid="<?php echo $row['ID'] ?>">
                                                <?php echo ($row['STATUS'] == 1) ? 'Ho???t ?????ng' : 'Kh??ng ho???t ?????ng'; ?>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                        <?php   } 
                                                }else{ ?>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title promotionOrder" id="myModalLabel">Th??m khuy???n m??i ????n h??ng</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row pdn">
                    <div class="col-md-3">
                        <label for="typePromotionOrder">Lo???i khuy???n m???i <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select typePromotionOrder" id="typePromotionOrder"
                            name="typePromotionOrder" data-placeholder="Lo???i khuy???n m???i">
                            <option value="1">Gi???m ti???n h??ng</option>
                            <option value="2">Gi???m ph?? ship</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="measurePromotionOrder">????n v??? t??nh <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select measurePromotionOrder" id="measurePromotionOrder"
                            name="measurePromotionOrder" data-placeholder="????n v??? t??nh">
                            <option value="1">Theo %</option>
                            <option value="2">?????ng</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="namePromotionOrder"> T??n khuy???n m??i <span style="color: red">(*)</span></label>
                        <input type="text" name="namePromotionOrder" class="form-control namePromotionOrder" onchange="checkExistPromotion(2, 'namePromotionOrder')"
                            id="namePromotionOrder" placeholder="T??n khuy???n m??i" value="<?= $post['namePromotion'] ?>">
                        <span class="error_text errNamePromotionOrder errNamePromotion"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-6">
                        <label for="conditionPromotionOrder"> ??i???u ki???n ??p d???ng <span
                                style="color: red">(*)</span></label>
                        <input type="text" name="conditionPromotionOrder" onkeypress="return isNumber(event)"
                            class="form-control conditionPromotionOrder" id="conditionPromotionOrder"
                            placeholder="??i???u ki???n ??p d???ng: 400.000"
                            onkeyup="number_format('conditionPromotionOrder', 1)"
                            value="<?= $post['conditionPromotionOrder'] ?>">
                        <span class="error_text errConditionOrder "></span>
                    </div>
                    <div class="col-md-3">
                        <label for="discountValuePromotionOrder">Gi?? tr??? / ????n v??? t??nh <span
                                style="color: red">(*)</span></label>
                        <input type="text" name="discountValuePromotionOrder"
                            class="form-control discountValuePromotionOrder" onkeypress="return isNumber(event)"
                            id="discountValuePromotionOrder" placeholder="Gi?? tr???"
                            value="<?= $post['discountValuePromotionOrder'] ?>">
                        <span class="error_text errDiscountValuePromotionOrder "></span>
                    </div>
                    <div class="col-md-3">
                        <label for="discountMaxPromotionOrder"> Gi?? tr??? max / 1 ????n h??ng </label>
                        <input type="text" name="discountMaxPromotionOrder" onkeypress="return isNumber(event)"
                            class="form-control discountMaxPromotionOrder" id="discountMaxPromotionOrder"
                            placeholder="Gi?? tr??? max / 1 ????n h??ng" value="<?= $post['discountMaxPromotionOrder'] ?>">
                    </div>
                </div>

                <div class="form-group row pdn">
                    <div class="col-md-3">
                        <label for="startedPromotionOrder">Ng??y b???t ?????u <span style="color: red">(*)</span></label>
                        <input type="text" name="startedPromotionOrder"
                            class="form-control startedPromotionOrder datepicker" id="startedPromotionOrder"
                            placeholder="Ng??y b???t ?????u" value="<?= $post['startedPromotionOrder'] ?>" autocomplete="off">
                        <span class="error_text errStartedPromotionOrder"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="stopedPromotionOrder">Ng??y k???t th??c <span style="color: red">(*)</span></label>
                        <input type="text" name="stopedPromotionOrder"
                            class="form-control stopedPromotionOrder datepicker" id="stopedPromotionOrder"
                            placeholder="Ng??y k???t th??c" value="<?= $post['stopedPromotionOrder'] ?>" autocomplete="off">
                        <span class="error_text errStopedPromotionOrder"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="statusPromotionOrder"> Tr???ng th??i <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select statusPromotionOrder" id="statusPromotionOrder"
                            name="statusPromotionOrder">
                            <option value="0">Kh??ng ho???t ?????ng</option>
                            <option class="statusPromotionOrderYes" value="1">Ho???t ?????ng</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" class="promotionOrderId" id="promotionOrderId" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-success btn-ok savePromotionOrder savePromotion" disabled>Th??m m???i</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCloseReload fade" id="confirmDeleteRow" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body confirmBody">
                <p>B???n c?? ch???c ch???n mu???n x??a.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-danger btn-ok btnDeleteRow" data-dismiss="modal">X??a</button>
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