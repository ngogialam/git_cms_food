<!-- partial:partials/_navbar.html -->
<?php
$requestUri = explode("/", $_SERVER['REQUEST_URI'])[2];
$link_active = explode("?", $requestUri)[0];
?>

<div class="main-panel">
    <div class="content-wrapper">
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

                    <div class="row searchBar">
                        <div class="form-group col-md-3 pdr-menu ">
                            <input type="text" name="name" value="<?= !empty($nameGet) ? $nameGet : "" ?>" class="form-control" placeholder="T??n m??n ??n">
                        </div>

                        <div class="form-group col-md-3 pdr-menu">
                            <select class="form-control pdm chosen-select" id="permission" name="status">
                                <option value="-1" <?= (!empty($statusGet) && $statusGet == -1) ? "selected" : "" ?>>Ch???n tr???ng th??i</option>
                                <option value="2" <?= (!empty($statusGet) && $statusGet == 2) ? "selected" : "" ?>>??ang m??? b??n</option>
                                <option value="3" <?= (!empty($statusGet) && $statusGet == 1) ? "selected" : "" ?>>??ang ????ng </option>
                                <option value="0" <?= (isset($statusGet) && $statusGet == 0) ? "selected" : "" ?>>Kh??ng ho???t ?????ng</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3 pdr-menu">
                            <select class="form-control pdm chosen-select" id="permission" name="restaurant">
                                <option value="-1">Ch???n nh?? h??ng</option>
                                <?php foreach ($listRestaurant as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= (!empty($restaurant) && $restaurant == $value->id) ? "selected" : "" ?>> <?= $value->name ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mgbt searchBar">
                        <div class="form-group col-md-4 pdr-menu">
                            <div class="d-flex align-items-center">
                                <div class="pr-1 mb-4 mb-xl-0">
                                    <button type="button" class="btn btn-success btn-icon-text" data-toggle="modal" data-target="#modalAddMenuFood">Th??m m??n ??n</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-8 pdl-menu">
                            <div class="d-flex align-items-center justify-content-md-end">
                                <div class="pr-1 mb-4 mb-xl-0">
                                    <button type="submit" class="btn btn-primary btn-icon-text" id="searchListOrder">T??m ki???m</button>
                                </div>
                                <div class="pr-1 mb-4 mb-xl-0">
                                    <a class="btn btn-danger bth-cancel btn-icon-text" href="<?= base_url('/mon-an/danh-sach-mon-an') ?> ">B??? l???c</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="active-sale">
                    <div>
                        <button type="button" class="btn btn-primary" onclick="confirmChangeStatusDish(2)">M??? b??n</button>
                        <button type="button" class="btn btn-danger" onclick="confirmChangeStatusDish(1)">????ng b??n</button>
                    </div>
                    <div class="d-flex active-sale-time">
                        <span>Th???i gian m??? b??n</span>
                        <div class="ml-2 w-200">
                            <select class="form-control pdm chosen-select" id="selectTime" onchange="checkTime()">
                                <option value="-1">Ch???n nh?? h??ng</option>
                                <?php foreach ($listRestaurant as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= ((!empty($restaurant) && $restaurant == $value->id) ) ? "selected" : "" ?>> <?= $value->name ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="ml-2 ">
                            <input type="time" class="time-open-sale" value="<?php echo (!empty($defaultOpeningTime) ? $defaultOpeningTime->timeOrderFrom : '');  ?>" id="time-start"> - <input type="time" value="<?php echo (!empty($defaultOpeningTime) ? $defaultOpeningTime->timeOrderTo : '');  ?>" class="time-open-sale" id="time-end">
                        </div>
                        <button type="button" class="btn btn-success ml-2" onclick="changeTimeSale()">X??c nh???n</button>
                    </div>
                </div>

                <div class="main-body">
                    <div class="card mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th class="vertical th-action" width="10%">
                                            <input class="checkAll check-action" id="checkAll" value="all-order" name="check[]" type="checkbox">
                                            <button type="button" class="btn btn-success btn-icon-custom" onclick="confirmChangeStatusDish(1)" title="Active">
                                                <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-icon-custom" onclick="confirmChangeStatusDish(0)" title="Disable">
                                                <i class="mdi mdi-close-circle-outline"></i>
                                            </button>
                                        </th>
                                        <th class="vertical text-bold" width="15%">T??n m??n ??n</th>
                                        <th class="vertical text-bold" width="10%">C???a h??ng</th>
                                        <th class="vertical text-bold" width="10%">M?? t???</th>
                                        <th class="vertical text-bold" width="10%">Gi?? b??n</th>
                                        <th class="vertical text-bold" width="10%">S??? l?????ng set b??n</th>
                                        <th class="vertical text-bold" width="10%">S??? l?????ng c??n l???i</th>
                                        <th class="vertical text-bold" width="10%">Tr???ng th??i m??? b??n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($listDish)) {
                                        foreach ($listDish as $item) { ?>
                                            <tr>
                                                <td class="text-center th-action">
                                                    <input style="padding: 5px 9px;" type="checkbox" name="check[]" class="checkSingle check-action checkValueAction" value="<?= $item->id ?>" />
                                                    <button class="btn btn-primary btn-icon-custom" type="button" title="Edit" onclick="getDetailDish(<?php echo $item->id; ?>,'<?php echo URL_IMAGE_SHOW ?>')">
                                                        <i class="mdi mdi-pen"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-icon-custom" type="button" title="Disable" onclick="confirmChangeStatusDish(0,0,<?php echo $item->id; ?>)">
                                                        <i class="mdi mdi-close-circle-outline"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <?= $item->name ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $item->restaurantName ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $item->content ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= number_format($item->sellingPrice) ?> ??
                                                </td>
                                                <td class="text-center">
                                                    <!-- <input onchange="changeStockDish(<?php //echo $item->id; ?>)" onkeypress="return isNumber(event)" type="text" class="stockDish" value="<?php //echo $item->stock ?>"> -->
                                                    <?= $item->stock ?>
                                                </td>
                                                <td class="text-center">
                                                    <input onchange="changeStockDish(<?php echo $item->id; ?>)" onkeypress="return isNumber(event)" type="text" class="stockDish-<?php echo $item->id; ?>" value="<?php echo $item->availableStock ?>">
                                                    <?php // $item->availableStock ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($item->status == -1) {
                                                        echo 'Ho???t ?????ng';
                                                    } else if ($item->status == 0) {
                                                        echo 'Kh??ng ho???t ?????ng';
                                                    } else if ($item->status == 2) {
                                                        echo '??ang m??? b??n';
                                                    } else if ($item->status == 1) {
                                                        echo '??ang ????ng';
                                                    }
                                                    ?>
                                                </td>

                                            </tr>
                                        <?php   }
                                    } else { ?>
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
                        <?php if ($pager) {
                            echo $pager->makeLinks($page, $perPage, $total, 'default_full', 3);
                        } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCloseReload" id="modalAddMenuFood" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title">Th??m m??n ??n</h4>
            </div>
            <div class="modal-body row">
                <div class="form-group col-sm-6 ">
                    <label for="parentCate" class=""> T??n m??n ??n <span style="color: red">(*)</span></label>
                    <div>
                        <input type="text" onkeyup="changeDataInput('errNameDish')" class="form-control nameDish" autocomplete="off" id="nameDish" placeholder="T??n m??n ??n" name="name">
                        <span class="error_text errNameDish"></span>
                    </div>
                </div>

                <div class="form-group col-sm-3">
                    <label for="parentCate"> Tr???ng th??i m??? b??n <span style="color: red">(*)</span></label>
                    <div>
                        <select class="form-control chosen-select statusOnWeb" id="statusOnWeb" onchange="changeDataInput('errStatusOnWeb')" name="status">
                            <option value="-1">Ch???n tr???ng th??i</option>
                            <option value="2">??ang m??? b??n</option>
                            <option value="1">??ang ????ng </option>
                            <option value="0">Kh??ng ho???t ?????ng</option>
                        </select>
                        <span class="error_text errStatusOnWeb"></span>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label for="parentCate"> Ch???n nh?? h??ng <span style="color: red">(*)</span></label>
                    <div>
                        <select class="form-control chosen-select restaurantId" id="restaurantId" name="restaurantId">
                            <option value="0">Ch???n nh?? h??ng</option>
                            <?php foreach ($listRestaurant as $key => $value) { ?>
                                <option value="<?= $value->id ?>"> <?= $value->name ?> </option>
                            <?php } ?>
                        </select>
                        <span class="error_text errRestaurantId"></span>
                    </div>
                </div>

                <div class="form-group col-sm-3 ">
                    <label class=""> Gi?? g???c <span style="color: red">(*)</span></label>
                    <div>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control originalPrice" onkeyup="changeDataInput('errOriginalPrice')" autocomplete="off" id="originalPrice" placeholder="Nh???p gi?? g???c">
                        <span class="error_text errOriginalPrice"></span>
                    </div>
                </div>

                <div class="form-group col-sm-3 ">
                    <label class=""> Gi?? b??n <span style="color: red">(*)</span></label>
                    <div>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control sellingPrice" onkeyup="changeDataInput('errSellingPrice')" autocomplete="off" id="sellingPrice" placeholder="Nh???p gi?? b??n">
                        <span class="error_text errSellingPrice"></span>
                    </div>
                </div>

                <div class="form-group col-sm-3 ">
                    <label class=""> S??? th??? t??? </label>
                    <div>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control position" autocomplete="off" onkeyup="changeDataInput('errPosition')" id="position" value="999" placeholder="Nh???p s??? th??? t???">
                        <span class="error_text errPosition"></span>
                    </div>
                </div>

                <div class="form-group col-sm-3 ">
                    <label for="nameCate" class=""> S??? l?????ng b??n <span style="color: red">(*)</span></label>
                    <div>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onkeyup="changeDataInput('errStock')" id="stock" class="form-control stock" autocomplete="off" placeholder="Nh???p s??? l?????ng b??n" value="<?= $post['nameMenus'] ?>">
                        <span class="error_text errStock"></span>
                    </div>
                </div>

                <div class="form-group col-12 appendDishThumbnail d-grid">
                    <div class="d-grid">
                        <label for="newsTitle">???nh thumb <span style="color: red">(*)</span></label>
                        <label for="dishThumbnail">
                            <img for="dishThumbnail" id="dishThumbnailImg" class="dishThumbnailImg cursorPointer" src="<?= (isset($post['imgThumbnail']) && $post['imgThumbnail'] != '') ? URL_IMAGE_SHOW . $post['imgThumbnail'] : base_url('public/images_kho/btn-add-img.svg'); ?>" alt="">
                        </label>
                        <input type="file" name="dishThumbnail" class="imgDefault dishThumbnail d-none" onchange="uploadImgJs(event,'div.appendDishThumbnail','err_dishThumbnailErr','appendDishThumbnail',0,0, 'dishThumbnailImg','imgThumbnail')" id="dishThumbnail" />
                        <input type="hidden" class="inputImgBs imgThumbnail" value="" id="imgThumbnail">
                    </div>
                    <span class="error_text errNewsThumbnailImg"></span>
                </div>

                <div class="form-group col-12 appendDishImage">
                    <div class="form-group  imgThumbnail appendImgProduct mg0 d-flex">
                        <label for="frontBsRegis">
                            <span>???nh m??n ??n <span style="color: red">(*)</span> </span>
                            <img for="frontBsRegis" id="frontBsRegisImg" class="frontBsRegisImg cursorPointer" src="<?= base_url('public/images_kho/btn-add-img.svg'); ?>" count="0" alt="">
                            <input type="file" style="display:none" name="frontBsRegis" class="imgDefault frontBsRegis" onchange="uploadImgJs(event,'div.appendImgProduct','err_imgUpload','appendImgProduct',0,1, 'frontBsRegisImg','','inputImgBs',1)" id="frontBsRegis" />
                        </label>
                    </div>
                    <span class="error_text errImagesDish"></span>
                </div>

                <div class="form-group col-12 ">
                    <label for="status"> M?? t??? s???n ph???m<span style="color: red">(*)</span></label>
                    <div>
                        <textarea class="form-control contentDish" id="contentDish"></textarea>
                    </div>
                    <span class="error_text errContentDish"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-success btn-ok saveMenus btnAddMenu" onclick="addDish()">Th??m m???i</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCloseReload fade" id="confirmChangeTimeSale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body confirmBody">
                <p>B???n c?? ch???c ch???n mu???n thay ?????i khung gi??? ?????t h??ng hay kh??ng ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-danger" onclick="confirmChangeTimeSale()">Thay ?????i</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCloseReload fade" id="modalDish" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body confirmBody">
                <p>B???n c?? ch???c ch???n x??c nh???n?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-danger btn-ok btnDeleteRow">X??a</button>
            </div>
        </div>
    </div>
</div>

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


<script>
    let contentNews;
    ClassicEditor
        .create(document.querySelector('#contentDish'), {
            ckfinder: {
                uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
                withCredentials: true,
            },
        })
        .then(contentBanners => {
            contentNews = contentBanners;
        })
        .catch(error => {
            console.error(error);
        });
</script>