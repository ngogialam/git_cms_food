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

                        <div class="row searchBar">
                            <div class="form-group col-md-5 pdr-menu ">
                                <input type="text" value="<?php echo (isset($conditions['nameCate'])) ? $conditions['nameCate'] : '' ?>"
                                    name="nameCate" class="form-control" placeholder="T??n danh m???c">
                            </div>

                            <div class="form-group col-md-3 pdr-menu">
                                <select class="form-control pdm chosen-select" name="pid"
                                    data-placeholder="Danh m???c cha" id="permission">
                                    <option value="">Danh m???c cha</option>
                                    <?php echo $dataCate ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="conditionFlag" data-placeholder=""
                                    id="conditionFlag">
                                    <option value="-1">Ch???n block hi???n th???</option>
                                    <option
                                        <?php echo (isset($conditions['conditionFlag'] ) && $conditions['conditionFlag'] == 1 ) ? 'selected' : '' ?>
                                        value="1">Block danh m???c ph??? bi???n</option>
                                    <option
                                        <?php echo (isset($conditions['conditionFlag'] ) && $conditions['conditionFlag'] == 2 ) ? 'selected' : '' ?>
                                        value="2">Block s???n ph???m c???a HolaFood</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="status" data-placeholder=""
                                    id="status">
                                    <option value="-1" selected>T???t c???</option>
                                    <option
                                    <?php echo (isset($conditions['status']) && $conditions['status'] == 1 ) ? 'selected' : '' ?>
                                        value="1">Ho???t ?????ng</option>
                                    <option
                                    <?php echo (isset($conditions['status']) && $conditions['status'] == 0 ) ? 'selected' : '' ?>
                                        value="0">Kh??ng ho???t ?????ng</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-4 pdr-menu">
                                <div class="d-flex align-items-center">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text" onclick="addCategory()">Th??m danh m???c</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-8 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text"
                                            id="searchListOrder">T??m ki???m</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text" href="<?= base_url('/danh-muc/danh-sach-danh-muc') ?> ">B??? l???c</a>
                                    </div>
                                    <!-- <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" name="excel" value="1" class="btn btn-info btn-excel" onclick="exportExcelListOrders()">
                                            Xu???t Excel
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
                                                    <input class="checkAll check-action" id="checkAll" value="all-order" name="check[]" type="checkbox">
                                                    <button type="button" class="btn btn-success btn-icon-custom" onclick="activeRowAll()" title="Active">
                                                        <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-icon-custom" onclick="disableRowAll()" title="Disable">
                                                        <i class="mdi mdi-close-circle-outline"></i>
                                                    </button>
                                                </th>
                                                <th class="vertical text-bold" width="14%">Images</th>
                                                <th class="vertical text-bold" width="15%">T??n danh m???c cha</th>
                                                <th class="vertical text-bold" width="15%">T??n danh m???c</th>
                                                <th class="vertical text-bold" width="10%">Blog hi???n th???</th>
                                                <th class="vertical text-bold" width="10%">Ng??y t???o</th>
                                                <th class="vertical text-bold" width="10%">Ng??y s???a</th>
                                                <th class="vertical text-bold" width="3%">Th??? t???</th>
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
                                                        <input style="padding: 5px 9px;" type="checkbox" name="check[]" class="checkSingle check-action" value="<?php echo $row['ID'] ?>" />
                                                        <button class="btn btn-primary btn-icon-custom" type="button" onclick="getRow(<?php echo $row['ID'] ?>, '<?php echo URL_IMAGE_SHOW ?>')" title="Edit">
                                                            <i class="mdi mdi-pen"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-icon-custom" type="button" onclick="disableRow(<?php echo $row['ID'] ?>)" title="Disable">
                                                        <i class="mdi mdi-close-circle-outline"></i>
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="thumbnail-wrap">
                                                            <img class="img-review" src="<?php echo($row['BANNER'])? URL_IMAGE_SHOW.$row['BANNER'] : '/public/images/no_images.png'; ?>" alt="">
                                                        </div>
                                                    </td>
                                                    <td><?php echo $row['PARENT_NAME']; ?></td>
                                                    <td><?php echo $row['NAME']; ?></td>
                                                    <td>
                                                        <span><?php echo($row['POPULAR_FLAG'] == 1)? 'Block danh m???c ph??? bi???n' : '' ; ?></span><br>
                                                        <span><?php echo($row['PRODUCT_FLAG'] == 1)? 'Block s???n ph???m c???a HolaFood' : '' ; ?></span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo $row['CREATED_NAME'] ?></span><br>
                                                        <span><?php echo $row['CREATED_DATE'] ?></span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo $row['EDITED_NAME'] ?></span><br>
                                                        <span><?php echo $row['EDITED_DATE'] ?></span>
                                                    </td>
                                                    <td class="text-center" pid="<?php echo $row['ID'] ?>"> <?php echo $row['POSITION'] ?></td>
                                                    <td class="text-center" pid="<?php echo $row['ID'] ?>"> <?php echo ($row['STATUS'] == 1) ? 'Ho???t ?????ng' : 'Kh??ng ho???t ?????ng'; ?></td>
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

<div class="modal modalCloseReload " id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                <h4 class="modal-title" id="myModalLabel">Th??m danh m???c</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row pdn">
                    <label for="parentCate" class="col-sm-3 col-form-label"> Danh m???c cha</label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select parentCate" id="parentCate" name="parentCate">
                            <option value="0"> Ch???n danh m???c cha</option>
                            <?php echo $dataCate ?>
                        </select>
                        <span class="error_text errParentCate"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="nameCate" class="col-sm-3 col-form-label"> T??n danh m???c <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="nameCate" class="form-control nameCate" onchange="checkExistCate()" autocomplete="off"
                            id="nameCate" placeholder="T??n danh m???c" value="<?= $post['nameCate'] ?>">
                        <span class="error_text errNameCate"></span>
                    </div>
                </div>

                <div class="form-group row pdn appendNewsThumbnail">
                    <label for="newsTitle" class="col-sm-3 col-form-label">???nh thumbnail</label>
                    <label for="newsThumbnail">
                        <img for="newsThumbnail" id="newsThumbnailImg" class="newsThumbnailImg cursorPointer mgl20"
                            src="<?php
                                echo (isset($post['imgThumbnail']) && $post['imgThumbnail'] != '' ) ? URL_IMAGE_SHOW.$post['imgThumbnail'] : base_url('public/images_kho/btn-add-img.svg');
                            // echo base_url('public/images_kho/btn-add-img.svg');
                            ?>" alt="">
                    </label>
                    <!-- <input type="file" style="display:none" name="newsThumbnail" class="imgDefault newsThumbnail"
                            onchange="loadFile(event,'newsThumbnailImg','err_newsThumbnailErr')" id="newsThumbnail" /> -->
                    <input type="file" style="display:none" name="newsThumbnail" class="imgDefault newsThumbnail"
                        onchange="uploadImgJs(event,'div.appendNewsThumbnail','err_newsThumbnailErr','appendNewsThumbnail',0,0, 'newsThumbnailImg','imgThumbnail')"
                        id="newsThumbnail" />
                    <input type="hidden" class="inputImgBs imgThumbnail" value="<?php echo $post['imgThumbnail'] ?>" name="imgThumbnail">
                </div>

                <div class="form-group row pdn">
                    <label for="positionCate" class="col-sm-3 col-form-label"> Th??? t??? hi???n th???</label>
                    <div class="col-sm-9">
                        <input type="text" name="positionCate" class="form-control positionCate" onkeypress="return isNumber(event)" autocomplete="off"
                            id="positionCate" placeholder="Th??? t??? hi???n th???" value="<?= $post['positionCate'] ?>">
                        <span class="error_text errPositionCate"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="popularFlag" class="col-sm-3 col-form-label"> Hi???n th??? ??? block danh m???c ph??? bi???n </label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select popularFlag" id="popularFlag" name="popularFlag">
                            <option value="0">Kh??ng</option>
                            <option class="popularFlagYes" value="1">C??</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="productFlag" class="col-sm-3 col-form-label"> Hi???n th??? ??? block s???n ph???m c???a HolaFood </label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select productFlag" id="productFlag" name="productFlag">
                            <option value="0">Kh??ng</option>
                            <option class="productFlagYes" value="1">C??</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="status" class="col-sm-3 col-form-label"> Tr???ng th??i <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select status" id="status" name="status">
                            <option class="statusYes" value="1">Ho???t ?????ng</option>
                            <option value="0">Kh??ng ho???t ?????ng</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                <button type="button" class="btn btn-success btn-ok saveCate" disabled>Th??m m???i</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteRow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
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