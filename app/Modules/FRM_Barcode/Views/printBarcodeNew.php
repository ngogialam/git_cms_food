<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <form action="" id="form-create-user" method="POST" class="notifacation-wrapper">


                    <div class="mgbt row">
                        <div class="col-md-6">
                            <h3 class="card-content-title">In tem sản phẩm mẫu mới</h3>
                            <?php
                            $checkNoti = get_cookie('__barcode');
                            $checkNoti = explode('^_^', $checkNoti);
                            setcookie("__barcode", '', time() + (1), '/');
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
                        </div>
                    </div>
                    <div class="row mgt15">
                        <div class="col-4">
                            <select class="form-control chosen-select idBarCodeNew" id="idBarCodeNew" name="idBarCodeNew">
                                <option value="0">Chọn tem sản phẩm</option>
                                <?php
                                if (!empty($listObject)) :
                                    foreach ($listObject as $object) :
                                ?>
                                        <option data-url="<?php echo base_url('/trang-trai/previewPrintBarCodeNew?idBarCodeNew=' . $object['ID']); ?>" <?php echo ($get['goodsType'] == $object['ID']) ? 'selected' : ''; ?> value="<?= $object['ID'] ?>"><?= $object['PRODUCT_NAME'] ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                        <div class="col-8">
                            <button type="button" class="btn btn-default btn-primary" onclick="getIdBarcodeNew()">In tem </button>
                            <a href="<?php echo base_url('/trang-trai/in-tem-mau-moi') ?>" class="btn btn-default btn-danger">Bỏ chọn</a>
                        </div>
                    </div>


                    <div class="mgbt row" style="margin-top:20px;">
                        <div class="col-md-6">
                            <h3 class="card-content-title">Tạo tem sản phẩm mẫu mới</h3>
                        </div>
                    </div>
                    <input type="hidden" name="productID" class="form-control productID" autocomplete="off" id="productID" value="">
                    <div class="row mgt15">
                        <div class="col-4">
                            <label for="productName" class="fz13">Tên sản phẩm</label>
                            <input type="text" name="productName" class="form-control productName" autocomplete="off" id="productName" placeholder="Tên sản phẩm" value="<?php echo $post['productName'] ?>">
                            <span class="error_text productNameErr"><?php echo $getErrors['productName'] ?></span>
                        </div>
                        <div class="col-4">
                            <label for="areaProduct" class="fz13">Nguồn gốc xuất xứ</label>
                            <input type="text" name="areaProduct" class="form-control areaProduct" autocomplete="off" id="areaProduct" placeholder="Nguồn gốc xuất xứ" value="<?php echo $post['areaProduct'] ?>">
                            <span class="error_text areaProductErr"></span>
                        </div>
                        <div class="col-4">
                            <label for="areaProduct" class="fz13">Hạn sử dụng</label>
                            <input type="text" name="hsd" class="form-control hsd" autocomplete="off" id="hsd" placeholder="Hạn sử dụng" value="<?php echo $post['hsd'] ?>">
                            <span class="error_text areaProductErr"></span>
                        </div>
                    </div>

                    <div class="row mgt15">
                        <div class="col-4">
                            <label for="viTri" class="fz13">Thông tin sản phẩm/ Dinh dưỡng</label>
                            <textarea name="infoProduct" id="infoProduct" class="form-control infoProduct" cols="30" rows="10"><?php echo $post['infoProduct'] ?></textarea>
                            <span class="error_text viTriErr"></span>
                        </div>
                        <div class="col-4">
                            <label for="soLo" class="fz13">Hướng dẫn sử dụng</label>
                            <textarea name="hdsd" id="hdsd" class="form-control hdsd" cols="30" rows="10"><?php echo $post['hdsd'] ?></textarea>
                            <span class="error_text soLoErr"></span>
                        </div>
                        <div class="col-4">
                            <label for="soLo" class="fz13">Bảo quản</label>
                            <textarea name="baoQuan" id="baoQuan" class="form-control baoQuan" cols="30" rows="10"><?php echo $post['baoQuan'] ?></textarea>
                            <span class="error_text soLoErr"></span>
                        </div>
                    </div>
                    <button type="submit" style="float: right; margin-top:15px;" class="btn btn-default btn-primary btnBarCodeNew">Tạo mẫu tem mới</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<div id="theModalPrint" class="modal fade text-center" style="page-break-after: always;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div id="printTable">

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