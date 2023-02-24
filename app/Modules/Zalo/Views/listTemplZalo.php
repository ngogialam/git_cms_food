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
                    <h3 class="card-content-title">Danh sách biểu mẫu tin nhắn zalo</h3>
                    <form action="" id="formSearchListOrdersWare" method="GET" class="notifacation-wrapper">
                        <div class="row searchBar">
                            <?php
                            $checkNoti = get_cookie('__templ');
                            $checkNoti = explode('^_^', $checkNoti);
                            setcookie("__templ", '', time() + (1), '/');
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

                            <div class="form-group col-md-2 pdr-menu ">
                                <input type="text" name="templateId" value="<?=  $dataRequest['templateId'] ?>" class="form-control" placeholder="Mã mẫu tin nhắn zalo">
                            </div> 
                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="service">
                                    <option value="-1">Chọn dịch vụ</option>
                                    <option value="1" <?=  $dataRequest['service'] == 1 ? 'selected' : ''  ?> >Dịch vụ Food</option>
                                    <option value="2" <?=  $dataRequest['service'] == 2 ? 'selected' : ''  ?>>Dịch vụ Ship</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="status">
                                    <option value="-1">Chọn trạng thái</option>
                                    <option value="1" <?=  $dataRequest['status'] == 1 ? 'selected' : ''  ?>>Hoạt động</option>
                                    <option value="0" <?=  $dataRequest['status'] == 2 ? 'selected' : ''  ?>>Không hoạt động</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mgbt searchBar">
                            <div class="col-md-12 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-2 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text" id="" onclick="exportExcelTemplZalo()">Xuất Excel</button>
                                    </div>
                                    <div class="pr-1 mb-2 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text" id="searchListOrder">Tìm kiếm</button>
                                    </div>
                                    <div class="pr-1 mb-2 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text" href="<?= base_url('/quan-ly-zalo') ?> ">Bỏ lọc</a>
                                    </div>
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
                                    <th width="10%">Mã biểu mẫu</th>
                                    <th width="20%">Tên biểu mẫu</th>
                                    <th width="20%">Dịch vụ</th>
                                    <th width="10%">Tổng tin nhắn</th>
                                    <th width="10%">Tổng tiền</th>
                                    <th width="15%">Trạng thái</th>
                                    <th width="15%">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                if (!empty($dataTemplate)) {
                                    foreach ($dataTemplate as $templ) { ?>
                                        <tr style="font-size: 16px;">
                                            <td class="text-center"><?php echo $templ->templateId ?></td>
                                            <td class="text-center"><?php echo $templ->name ?></td>
                                            <td class="text-center"><?= $templ->serviceType == 1 ? 'Dịch vụ food' : 'Dịch vụ ship' ?></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><?= $templ->status == 1 ? 'Hoạt động' : 'Không hoạt động'; ?></td>
                                            <td class="text-center">
                                                <div class="form-check pl-0">
                                                    <input id="stackedCheck1" onchange="changeStatusTemplZalo(<?= $templ->status ?>,<?= $templ->templateId ?>)" class="form-check-input" type="checkbox" data-toggle="toggle" <?= $templ->status  == 1 ? 'checked' : '' ?>>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php   }
                                } else { ?>
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
                <?php if ($pager) : ?>
                    <?php
                    if (isset($uri) && $uri[0] != '') {
                        echo $pager->makeLinks($page, $perPage, $total, 'default_full', 3);
                    }
                    ?>
                <?php endif ?>
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
    function changeStatusTemplZalo(status, id) {
        $.ajax({
            url: '/activeTemplZalo',
            type: 'post',
            dataType: 'json',
            data: {
                'templateId': id,
                'status': status
            },
            success: function(res) {
                location.reload()
            },
            error: function() {
                $('#loading_image').fadeOut(300);
            }
        });
    }
</script>