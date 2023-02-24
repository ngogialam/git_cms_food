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
                            $checkNoti = get_cookie('__methods');
                            $checkNoti = explode('^_^', $checkNoti);
                            setcookie("__methods", '', time() + (1), '/');
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
                            <div class="form-group col-md-5 pdr-menu ">
                                <input type="text"
                                    value="<?php echo (isset($get['methodsName'])) ? $get['methodsName'] : '' ?>"
                                    name="methodsName" class="form-control" placeholder="Tên phương thức">
                            </div>

                            <div class="form-group col-md-3 pdr-menu">
                                <select class="form-control pdm chosen-select" name="methodsType"
                                    data-placeholder="Chọn loại phương thức" id="methodsType">
                                    <option value="0"> Chọn loại phương thức</option>
                                    <?php
                            if(!empty($arrGroupMethods)):
                        ?>
                                    <?php foreach($arrGroupMethods as $keyGroupMethod => $valueGroupMethod): ?>
                                    <option <?php echo ($keyGroupMethod == $get['methodsType'] ) ? 'selected' : '' ?>
                                        value="<?= $keyGroupMethod ?>"><?= $valueGroupMethod ?></option>
                                    <?php endforeach; ?>
                                    <?php  endif; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="statusMethods" data-placeholder=""
                                    id="statusMethods">
                                    <option value="-1">Tất cả</option>
                                    <option <?php echo (isset($get['status']) && $get['status'] == 1 ) ? 'selected' : '' ?> value="1">Hoạt 
                                        động</option>
                                    <option <?php echo (isset($get['status']) && $get['status'] == 0 ) ? 'selected' : '' ?> value="0">
                                        Không hoạt động</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-4 pdr-menu">
                                <div class="d-flex align-items-center">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text"
                                            onclick="addMethods()">Thêm phương thức</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-8 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text"
                                            id="searchListOrder">Tìm kiếm</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text"
                                            href="<?= base_url('phuong-thuc/danh-sach-phuong-thuc') ?> ">Bỏ lọc</a>
                                    </div>
                                    <!-- <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" name="excel" value="1" class="btn btn-info btn-excel" onclick="exportExcelListOrders()">
                                            Xuất Excel
                                        </button>
                                    </div> -->
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
                                                    onclick="activeRowMethodsAll()" title="Active">
                                                    <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon-custom"
                                                    onclick="disableRowMethodsAll()" title="Disable">
                                                    <i class="mdi mdi-close-circle-outline"></i>
                                                </button>
                                            </th>
                                            <th class="vertical text-bold" width="15%">Tên phương thức</th>
                                            <th class="vertical text-bold" width="10%">Loại phương thức</th>
                                            <th class="vertical text-bold" width="10%">Ngày tạo</th>
                                            <th class="vertical text-bold" width="10%">Ngày sửa</th>
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
                                                <button class="btn btn-primary btn-icon-custom" type="button"
                                                    onclick="getMethods(<?php echo $row['ID'] ?>, '<?php echo URL_IMAGE_SHOW ?>')"
                                                    title="Edit">
                                                    <i class="mdi mdi-pen"></i>
                                                </button>
                                                <button class="btn btn-danger btn-icon-custom" type="button"
                                                    onclick="disableMethods(<?php echo $row['ID'] ?>, 0)" title="Disable">
                                                    <i class="mdi mdi-close-circle-outline"></i>
                                                </button>
                                            </td>

                                            <td><?php echo $row['METHOD']; ?></td>
                                            <td><?php echo $arrGroupMethods[$row['TYPE']]; ?></td>
                                            <td><?php echo $row['CREATED_DATE']; ?></td>
                                            <td><?php echo $row['EDITED_DATE']; ?></td>
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

<div class="modal modalCloseReload" id="addMethods" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Thêm danh mục</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row pdn">
                    <label for="newsCate" class="col-sm-3 col-form-label"> Loại phương thức <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select methodType" id="methodType" name="methodType"
                            data-placeholder="Chọn loại phương thức">
                            <option value="0"> Chọn loại phương thức</option>
                            <?php
                            if(!empty($arrGroupMethods)):
                        ?>
                            <option <?php echo ($post['methodType'] == $cate['ID']) ? 'selected' : ''; ?>
                                value="<?= $cate['ID'] ?>"><?= $cate['NAME'] ?></option>
                            <?php foreach($arrGroupMethods as $keyGroupMethod => $valueGroupMethod): ?>
                            <option <?php echo ($keyGroupMethod == $post['code'] ) ? 'selected' : '' ?>
                                value="<?= $keyGroupMethod ?>"><?= $valueGroupMethod ?></option>
                            <?php endforeach; ?>
                            <?php  endif; ?>
                        </select>
                        <span class="error_text errMethodType"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="methodName" class="col-sm-3 col-form-label"> Tên phương thức <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="methodName" class="form-control methodName" autocomplete="off"
                            id="methodName" placeholder="Tên phương thức" value="" onchange="checkExistMethod()">
                        <span class="error_text errMethodName"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="statusMethods" class="col-sm-3 col-form-label"> Trạng thái <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select statusMethods" id="statusMethods"
                            name="statusMethods">
                            <option class="statusNo" value="0">Không hoạt động</option>
                            <option class="statusYes" value="1">Hoạt động</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row pdn">
                    <label for="isDefaultMethod" class="col-sm-3 col-form-label"> Mặc định <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select isDefaultMethod" id="isDefaultMethod"
                            name="isDefaultMethod">
                            <option class="defaultNo" value="0">Không</option>
                            <option class="defaultYes" value="1">Có</option>
                        </select>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success btn-ok saveMethods" disabled>Thêm mới</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCloseReload fade" id="confirmDeleteRow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
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