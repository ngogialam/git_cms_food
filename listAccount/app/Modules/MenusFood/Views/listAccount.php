<!-- partial:partials/_navbar.html -->
<?php
$requestUri = explode("/", $_SERVER['REQUEST_URI'])[2];
$link_active = explode("?", $requestUri)[0];
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row add-account">
                    <div class="col-6">
                        <h3 class="card-content-title"><?php echo $title ?></h3>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center justify-content-md-end">
                            <div class="pr-1 mb-4 mb-xl-0">
                                <button type="button" style="background:#FF9900;" class="btn btn-success btn-icon-text" data-toggle="modal" data-target="#modalAddMenu"><i class="mdi mdi-plus-circle"></i>
                                    Thêm mới tài khoản</button>
                            </div>
                        </div>
                    </div>

                </div>

                <form action="" id="formSearchListOrdersWare" method="GET" class="notifacation-wrapper">
                    <?php
                    $checkNoti = get_cookie('__notiCate');
                    $checkNoti = explode('^_^', $checkNoti);
                    // print_r($checkNoti);
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

                    <div class="row searchBar">
                        <div class="form-group col-md-4 pdr-menu ">
                            <!-- <option value="-1">Chọn nhà hàng</option> -->
                            <input type="text" name="name" value="<?= !empty($phone) ? $phone : "" ?>" class="form-control" placeholder="Tài khoản">

                        </div>

                        <div class="form-group col-md-4 pdr-menu">
                            <select class="form-control pdm chosen-select" id="permission" name="name">
                                <option value="-1">Đối tác </option>
                                <?php foreach ($listPartner as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= (!empty($name) && $name == $value->id) ? "selected" : "" ?>>
                                        <?= $value->name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3 pdr-menu">
                            <div class="d-flex align-items-center justify-content-md-end">
                                <div class="pr-1 mb-4 mb-xl-0">
                                    <button type="submit" class="btn btn-primary btn-icon-text" id="searchListOrder">Search</button>
                                </div>
                                <div class="pr-1 mb-4 mb-xl-0">
                                    <a class="btn btn-danger bth-cancel btn-icon-text" href="<?= base_url('/mon-an/danh-sach-tai-khoan-doi-tac') ?> ">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="main-body">
                    <div class="card mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered" id='dsTable'>
                                <thead>
                                    <tr class="text-center">
                                        <th class="vertical text-bold" width="20%">Tài khoản</th>
                                        <th class="vertical text-bold" width="25%">Tên tài khoản</th>
                                        <th class="vertical text-bold" width="25%">Đối tác</th>
                                        <th class="vertical th-action" width="15%"> Hành động
                                        </th>
                                    </tr>

                                <tbody>
                                    <?php
                                    if (!empty($listUser)) {
                                        foreach ($listUser as $item) { ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?= $item->phone ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $item->userName ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $item->partnerName ?>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-icon-custom" onclick="deletePartner(<?php echo $row['mapperId'] ?>)" title="Disable">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </td>
                                            </tr>
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
                        <?php if ($pager) {
                            echo $pager->makeLinks($page, $perPage, $total, 'default_full', 3);
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCloseReload" id="modalAddMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Tài khoản đối tác .</h4>
            </div>
            <div class="form-group row">
                <label for="email_address" class="col-md-4 col-form-label text-md-right">Đối tác</label>
                <div class="col-md-6">
                    <select class="form-control pdm chosen-select" id="namePartner" name="namePartner">
                        <?php foreach ($listPartner as $key => $partner) { ?>
                            <option value="<?= $partner->id ?>"> <?= $partner->name ?> </option>
                        <?php } ?>
                    </select>
                    <span class="error_text errNamePartner"></span>
                </div>
            </div>

            <div class="form-group row">
                <!-- <?php foreach ($listAuto as $key => $aaa) { ?>
                            
                        <?php } ?> -->
                <label for="password" class="col-md-4 col-form-label text-md-right">Tài khoản </label>
                <div class="col-md-6">

                    <div class="dropdown">
                        <input type="text" style="width: 577px;" placeholder="Nhập tài khoản" id="myInput" onkeyup="filterFunction()">
                        <div id="myDropdown" class="dropdown-content">
                            <?php foreach ($listAuto as $key => $value) { ?>
                                <a value="<?= $value->id ?>" onclick="fillUserName('<?php echo $value->id ?>', '<?php echo $value->name ?>',  '<?php echo $value->phone ?>')"> <?= $value->phone ?></a>
                            <?php } ?>
                        </div>
                    </div>

                    <input id="selectedUserId" type="hidden">

                    <span class="error_text errPhoneName"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Tên tài khoản </label>
                <div class="col-md-6">
                    <div id="result" style="margin-top:15px;">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" style="background:#FF9900;" class="btn btn-success btn-ok saveMenus btnAddMenu" onclick="addAccount()">Thêm mới tài khoản</button>
            </div>
        </div>
    </div>
</div>
<!-- delete -->
<div class="modal modalCloseReload fade" id="confirmDeleteRow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<!-- delete -->
<?php if ($checkNoti) { ?>
    <script>
        $(document).ready(function() {
            $(".notification-container").fadeIn();
            setTimeout(function() {
                $(".notification-container").fadeOut();
            }, 5000);
        });
    </script>
<?php } ?>