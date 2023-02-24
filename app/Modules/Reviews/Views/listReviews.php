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
                            $checkNoti = get_cookie('__reviews');
                            $checkNoti = explode('^_^', $checkNoti);
                            setcookie("__reviews", '', time() + (1), '/');
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
                                    name="methodsName" class="form-control" placeholder="Nội dung đánh giá">
                            </div>

                            <div class="form-group col-md-3 pdr-menu">
                                <select class="form-control pdm chosen-select" name="methodsType"
                                    data-placeholder="Chọn loại phương thức" id="methodsType">
                                    <option value="0"> Chọn sản phẩm</option>
                                    <?php
                                        if(!empty($resultListProduct)):
                                    ?>
                                    <?php foreach($resultListProduct as $productShow): ?>
                                        <option value="<?php print_r($productShow->ID) ?>"><?php print_r($productShow->NAME) ?></option>
                                    <?php endforeach; ?>
                                    <?php  endif; ?>

                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="statusMethods" data-placeholder=""
                                    id="statusMethods">
                                    <option value="-1">Tất cả trạng thái</option>
                                    <option
                                        <?php echo (isset($get['status']) && $get['status'] == 1 ) ? 'selected' : '' ?>
                                        value="1">Hoạt động</option>
                                    <option
                                        <?php echo (isset($get['status']) && $get['status'] == 0 ) ? 'selected' : '' ?>
                                        value="0">
                                        Không không hoạt động</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="showMethods" data-placeholder=""
                                    id="statusMethods">
                                    <option value="-1">Hiển thị trang chủ</option>
                                    <option
                                        <?php echo (isset($get['status']) && $get['status'] == 1 ) ? 'selected' : '' ?>
                                        value="1">Hiển thị</option>
                                    <option
                                        <?php echo (isset($get['status']) && $get['status'] == 0 ) ? 'selected' : '' ?>
                                        value="0">
                                        Không hiển thị</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-4 pdr-menu">
                                <div class="d-flex align-items-center">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text"
                                            onclick="addReviews()">Thêm đánh giá</button>
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
                                            href="<?= base_url('danh-gia/danh-sach-danh-gia') ?> ">Bỏ lọc</a>
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
                                                    onclick="activeRowReviewAll()" title="Active">
                                                    <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon-custom"
                                                    onclick="disableRowReviewAll()" title="Disable">
                                                    <i class="mdi mdi-close-circle-outline"></i>
                                                </button>
                                            </th>
                                            <th class="vertical text-bold" width="10%">Người đánh giá</th>
                                            <th class="vertical text-bold" width="15%">Sản phẩm</th>
                                            <th class="vertical text-bold" width="25%">Nội dung</th>
                                            <th class="vertical text-bold" width="5%">Điểm</th>
                                            <th class="vertical text-bold" width="10%">Ảnh</th>
                                            <th class="vertical text-bold" width="10%">Ngày viết</th>
                                            <th class="vertical text-bold" width="10%">Trạng thái</th>
                                            <th class="vertical text-bold" width="10%">Hiển thị trang chủ</th>
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
                                                    onclick="getReviews(<?php echo $row['ID'] ?>, '<?php echo URL_IMAGE_SHOW ?>')"
                                                    title="Edit">
                                                    <i class="mdi mdi-pen"></i>
                                                </button>
                                                <button class="btn btn-danger btn-icon-custom" type="button"
                                                    onclick="disableReviews(<?php echo $row['ID'] ?>)"
                                                    title="Disable">
                                                    <i class="mdi mdi-close-circle-outline"></i>
                                                </button>
                                            </td>

                                            <td><?php echo $row['CUSTOMER_ID']; ?></td>
                                            <td><?php echo $row['PRODUCT_NAME']; ?></td>
                                            <td><?php echo $row['COMMENTS']; ?></td>
                                            <td><?php echo $row['SCORES']; ?></td>
                                            <td>
                                                <?php if($row['IMAGE']!= ''): ?>
                                                    <img for="review" class="cursorPointer mgl20 imageReview_<?php echo $row['ID']; ?>" onclick="modalPopupImage('imageReview_<?php echo $row['ID']; ?>')" style="width: 50px; height: 50px;border-radius:0" src="<?php echo URL_IMAGE_SHOW. $row['IMAGE']; ?>" alt="">
                                                    <?php endif; ?>
                                            </td>
                                            <td><?php echo $row['CREATED_DATE']; ?></td>
                                            <td class="text-center" pid="<?php echo $row['ID'] ?>">
                                                <?php echo ($row['STATUS'] == 1) ? 'Hoạt động' : 'Không hoạt động'; ?>
                                            </td>
                                            <td class="text-center" pid="<?php echo $row['ID'] ?>">
                                                <?php echo ($row['IS_SHOW'] == 1) ? 'Có' : 'Không'; ?>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                        <?php   } 
                                                }else{ ?>
                                        <tr>
                                            <td style="padding: 20px 10px!important;" colspan="9">Không tìm thấy dữ
                                                liệu phù hợp.</td>
                                        </tr>
                                        <tr></tr>
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

<div class="modal modalCloseReload" id="addReviews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Thêm đánh giá</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row pdn">
                    <label for="product" class="col-sm-3 col-form-label"> Sản phẩm <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select product" id="product" name="product"
                            data-placeholder="Chọn sản phẩm">
                            <option value="0"> Chọn sản phẩm</option>
                            <?php
                            if(!empty($resultListProduct)):
                        ?>
                            <?php foreach($resultListProduct as $valueProduct): ?>
                            <option <?php echo ($valueProduct->ID == $post['code'] ) ? 'selected' : '' ?>
                                value="<?= $valueProduct->ID ?>"><?= $valueProduct->NAME ?></option>
                            <?php endforeach; ?>
                            <?php  endif; ?>
                        </select>
                        <span class="error_text errProduct"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="scoreReviews" class="col-sm-3 col-form-label"> Điểm <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9 ">
                        <span></span>
                        <div class="wrapper">
                            <input type="radio" checked value="100" id="r1" class="scoreReviews score-5" name="scoreReviews">
                            <label for="r1">&#9733;</label>
                            <input type="radio" value="80" id="r2" class="scoreReviews score-4" name="scoreReviews">
                            <label for="r2">&#9733;</label>
                            <input type="radio" value="60" id="r3" class="scoreReviews score-3" name="scoreReviews" >
                            <label for="r3">&#9733;</label>
                            <input type="radio" value="40" id="r4" class="scoreReviews score-2" name="scoreReviews">
                            <label for="r4">&#9733;</label>
                            <input type="radio" value="20" id="r5" class="scoreReviews score-1" name="scoreReviews">
                            <label for="r5">&#9733;</label>
                        </div>
                        <p class="error_text errScore"></p>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="comment" class="col-sm-3 col-form-label"> Nội dung <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                            <textarea name="comment" id="comment" class="form-control comment" cols="30" rows="10"></textarea>
                        <span class="error_text errComment"></span>
                    </div>
                </div>

                <div class="form-group row pdn appendreview">
                    <label for="newsTitle" class="col-sm-3 col-form-label">Ảnh đánh giá</label>
                    <label for="review">
                        <img for="review" id="reviewImg" class="reviewImg cursorPointer mgl20"
                            src="<?php
                                echo (isset($post['imgReviews']) && $post['imgReviews'] != '' ) ? URL_IMAGE_SHOW.$post['imgReviews'] : base_url('public/images_kho/btn-add-img.svg');
                            // echo base_url('public/images_kho/btn-add-img.svg');
                            ?>" alt="">
                    </label>
                    <!-- <input type="file" style="display:none" name="review" class="imgDefault review"
                            onchange="loadFile(event,'reviewImg','err_reviewErr')" id="review" /> -->
                    <input type="file" style="display:none" name="review" class="imgDefault review"
                        onchange="uploadImgJs(event,'div.appendreview','err_reviewErr','appendreview',0,0, 'reviewImg','imgReviews')"
                        id="review" />
                    <input type="hidden" class="inputImgBs imgReviews" value="<?php echo $post['imgReviews'] ?>" name="imgReviews">
                </div>
                <div class="form-group row pdn">
                    <label for="isShow" class="col-sm-3 col-form-label"> Hiển thị trang chủ <span style="color: red"> (*)</span></label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select isShow" id="isShow"
                            name="isShow">
                            <option class="isShowNo" value="0">Không hiển thị</option>
                            <option class="isShowYes" value="1">Hiển thị</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="statusReviews" class="col-sm-3 col-form-label"> Trạng thái <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select statusReviews" id="statusReviews"
                            name="statusReviews">
                            <option class="statusNo" value="0">Không hoạt động</option>
                            <option class="statusYes" value="1">Hoạt động</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success btn-ok saveReviews">Thêm mới</button>
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
                <p class="confirmBody">Bạn có chắc chắn muốn xóa.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-ok btnDeleteRow">Xóa</button>
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
                <p class="confirmBody">Bạn có chắc chắn muốn xóa.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-ok btnDeleteRow">Xóa</button>
            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="modalPopupImage">
    <div class="modal-dialog">
        <div class="modal-content modal-show-img" style="background-color: white;">

            <!-- Modal Header -->
            <div class="modal-header" style="border:none">
                <h5 class="modal-title headerFalse">Ảnh chi tiết</h5>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="border:none">
                <div class="row modal-body-content">
                    <img id="imageDetail" class="img-responsive" alt="Image">
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer customize-approve" style="border:none">
                <button type="button" class="btn btn-modal btn-detail-page-modal-2"
                    data-dismiss="modal">Đóng</button>
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