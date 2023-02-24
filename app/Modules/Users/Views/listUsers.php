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
                    <h3 class="card-content-title">Danh sách người dùng</h3>
                    <form action="" id="formSearchListOrdersWare" method="GET" class="notifacation-wrapper">
                        <?php
                            $checkNoti = get_cookie('__user');
                            $checkNoti = explode('^_^', $checkNoti);
                            setcookie("__user", '', time() + (1), '/');
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
                            <div class="form-group col-md-2 pdr-menu ">
                                <input type="text"
                                    value="<?php echo (isset($dataOld['fullName'])) ? $dataOld['fullName'] : '' ?>"
                                    name="fullName" class="form-control" placeholder="Tên người dùng" id="fullName">
                            </div>

                            <div class="form-group col-md-2 pdr-menu ">
                                <input type="text" onkeypress="return isNumber(event)"
                                    value="<?php echo (isset($dataOld['phone'])) ? $dataOld['phone'] : '' ?>"
                                    name="phone" class="form-control" placeholder="Số điện thoại" id="phone">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="permission"
                                    data-placeholder="Chọn Shipper" id="permission">
                                    <option value="0">Quyền hạn</option>
                                    <?php 
                                        if(!empty($arrPermission)): 
                                            foreach($arrPermission as $keyPermission => $permission):
                                    ?>
                                    <option
                                        <?php echo (isset($dataOld['permission'] ) && $dataOld['permission'] == $keyPermission ) ? 'selected' : '' ?>
                                        value="<?php echo $keyPermission ?>"><?php echo $permission ?></option>
                                    <?php       
                                            endforeach;
                                        endif; 
                                    ?>
                                    <?php ?>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="status" data-placeholder="" id="status">
                                    <option <?php echo (isset($dataOld['status'] ) && $dataOld['status'] == -1 ) ? 'selected' : '' ?> selected value="-1">Chọn trạng thái</option>
                                    <option <?php echo (isset($dataOld['status'] ) && $dataOld['status'] == 1 ) ? 'selected' : '' ?> value="1">Hoạt động</option>
                                    <option <?php echo (isset($dataOld['status'] ) && $dataOld['status'] == 0 ) ? 'selected' : '' ?> value="0">Không hoạt động</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-2 pdr-menu">
                                <!-- <select class="form-control pdm chosen-select" name="orderBy" data-placeholder="" id="orderBy">
                                    <option <?php //echo (isset($dataOld['orderBy'] ) && $dataOld['orderBy'] == 0 ) ? 'selected' : '' ?> selected value="0">Ngày cập nhật</option>
                                    <option <?php //echo (isset($dataOld['orderBy'] ) && $dataOld['orderBy'] == 1 ) ? 'selected' : '' ?> value="1">Ngày tạo</option>
                                </select> -->
                            </div>
                            <div class="form-group col-md-2 pdr-menu">
                                <!-- <input type="text" name="fromDate" class="form-control pdm fromDate"
                                    id="daterangepicker"
                                    value="<?php //echo (isset($dataOld['fromDate'])) ? $dataOld['fromDate'] : '' ?>"
                                    placeholder="Từ ngày - đến ngày" value=""> -->
                            </div>
                            <div class="form-group col-md-8 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text" id="searchListOrder">Tìm kiếm</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text"
                                            href="<?= base_url('/user/danh-sach-nguoi-dung') ?> ">Bỏ lọc</a>
                                    </div>
                                    <!-- <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" name="excel" value="1" class="btn btn-info btn-excel"
                                            onclick="exportExcelListOrders()">
                                            Xuất Excel
                                        </button>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </form>
        <div class="main-body">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <?php if($auth['TYPE'] != 4): ?>
                                    <th width="10%">Chức năng</th>
                                <?php endif; ?>
                                    <th width="8%">Tên đăng nhập</th>
                                    <th width="15%">Tên người dùng</th>
                                    <th width="8%">ĐT liên hệ</th>
                                    <th width="10%">Quyền hạn</th>
                                    <th width="10%">Người tạo</th>
                                    <th width="10%">Ngày tạo</th>
                                    <th width="10%">Ngày cập nhật</th>
                                    <th width="10%">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php 
                                if(!empty($listUsers)){
                                foreach ($listUsers as $user) { ?>

                                    <!-- Modal delete -->
                                <div class="modal fade" id="confirm-delete-<?php echo $user['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Bạn có chắc muốn khóa tài khoản này?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>

                                                <a class="btn btn-danger btn-ok" href="<?php echo base_url('/xoa-nguoi-dung/' . $user['ID']) ?>" title="Xóa"> Đồng ý </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal ResetPass -->
                                <div class="modal fade" id="confirm-reset-<?php echo $user['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Bạn có muốn đổi lại mật khẩu thành: <?php $newPass = rand(100000000,999999999); echo $newPass; ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>

                                                <a class="btn btn-danger btn-ok" href="<?php echo base_url('/dat-lai-mat-khau/' . $user['ID'].'/'.$newPass) ?>" title="Đặt lại mật khẩu"> Đồng ý </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <tr>
                                    <td>
                                        <!-- Edit -->
                                        <a href=" <?php echo base_url('/user/sua-nguoi-dung/' . $user['ID']) ?>" style="float:left" title="Sửa">
                                            <button class="btn btn-default">
                                                <i class="mdi mdi-border-color"></i>
                                            </button>
                                        </a>

                                        <button class="btn btn-default" data-toggle="modal" data-target="#confirm-reset-<?php echo $user['ID']; ?>">
                                            <i class="mdi mdi mdi-refresh"></i>
                                        </button>
                                        <!-- Delete -->
                                        <button class="btn btn-default" data-toggle="modal" data-target="#confirm-delete-<?php echo $user['ID']; ?>">
                                            <i class="mdi mdi-account-minus"></i>
                                        </button>
                                    </td>
                                    <td><?php echo $user['USERNAME']; ?></td>
                                    <td> <a href="<?=base_url('/user/sua-nguoi-dung/'.$user['ID']); ?>"> <?php echo $user['NAME'];?> </a> </td>
                                    <td><?php echo $user['PHONE'];?></td>
                                    <td><?php echo $arrPermission[$user['CODE']]; ?></td>
                                    <td><?php echo $user['FULLNAME_CREATOR'];?></td>
                                    <td><?php echo $user['CREATED_TIME'];?></td>
                                    <td><?php echo $user['UPDATED_TIME'];  ?></td>

                                    <td><?php echo ($user['STATUS'] == 1) ? 'Hoạt động' : 'Không hoạt động'; ?></td>

                                </tr>
                                <?php $i++; ?>
                            <?php   } 
                                }else{ ?> 
                                    <tr>
                                        <td style="padding: 20px 10px!important;" colspan="7">Không tìm thấy dữ liệu phù hợp.</td>
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
                    }
                    ?>
                <?php endif?>
            </div>
        </div>
    </div>
</div>
<!-- main-panel ends -->
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