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
                            <div class="form-group col-md-7 pdr-menu ">
                                <input type="text" value="<?php echo (isset($conditions['nameBanners'])) ? $conditions['nameBanners'] : '' ?>"
                                    name="nameBanners" class="form-control" placeholder="Tên banners">
                            </div>

                            <div class="form-group col-md-3 pdr-menu">
                                <select class="form-control pdm chosen-select" name="pid"
                                    data-placeholder="Danh mục" id="permission">
                                    <option value="">Danh mục</option>
                                    <?php echo $dataCate ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="status" data-placeholder=""
                                    id="status">
                                    <option value="-1" selected>Chọn trạng thái</option>
                                    <option
                                        <?php echo (isset($conditions['status']) && $conditions['status'] == 1 ) ? 'selected' : '' ?>
                                        value="1">Hoạt động</option>
                                    <option
                                        <?php echo (isset($conditions['status']) && $conditions['status'] == 0) ? 'selected' : '' ?>
                                        value="0">Không hoạt động</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-4 pdr-menu">
                                <div class="d-flex align-items-center">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text" onclick="addBanners()">Thêm banners</button>
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
                                        <a class="btn btn-danger bth-cancel btn-icon-text" href="<?= base_url('/banners/danh-sach-banners') ?> ">Bỏ lọc</a>
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
                                                    <button type="button" class="btn btn-success btn-icon-custom" onclick="activeRowAllBanners()" title="Active">
                                                        <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-icon-custom" onclick="disableRowAllBanners()" title="Disable">
                                                        <i class="mdi mdi-close-circle-outline"></i>
                                                    </button>
                                                </th>
                                                <th class="vertical text-bold" width="15%">Images</th>
                                                <th class="vertical text-bold" width="10%">Danh mục</th>
                                                <th class="vertical text-bold" width="10%">Tên banners</th>
                                                <th class="vertical text-bold" width="15%">Nội dung</th>
                                                <th class="vertical text-bold" width="10%">Link</th>
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
                                                        <input style="padding: 5px 9px;" type="checkbox" name="check[]" class="checkSingle check-action" value="<?php echo $row['ID'] ?>" />
                                                        <button class="btn btn-primary btn-icon-custom" type="button" onclick="getRowBanners(<?php echo $row['ID'] ?>, '<?php echo URL_IMAGE_SHOW ?>')" title="Edit">
                                                            <i class="mdi mdi-pen"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-icon-custom" type="button" onclick="disableRowBanners(<?php echo $row['ID'] ?>)" title="Disable">
                                                        <i class="mdi mdi-close-circle-outline"></i>
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="thumbnail-wrap">
                                                            <img class="img-review" src="<?php echo($row['IMAGE'])? URL_IMAGE_SHOW.$row['IMAGE'] : '/public/images/no_images.png'; ?>" alt="">
                                                        </div>
                                                    </td>
                                                    <td><?php echo $row['CATEGORY_NAME']; ?></td>
                                                    <td><?php echo $row['NAME']; ?></td>
                                                    <td><?php echo $row['CONTENT']; ?></td>
                                                    <td><?php echo $row['LINK']; ?></td>
                                                    <td>
                                                        <span><?php echo $row['CREATED_NAME'] ?></span><br>
                                                        <span><?php echo $row['CREATED_DATE'] ?></span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo $row['EDITED_NAME'] ?></span><br>
                                                        <span><?php echo $row['EDITED_DATE'] ?></span>
                                                    </td>
                                                    <td class="text-center" pid="<?php echo $row['ID'] ?>"> <?php echo ($row['STATUS'] == 1) ? 'Hoạt động' : 'Không hoạt động'; ?></td>
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

<div class="modal modalCloseReload " id="addBanners" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Thêm banner</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row pdn">
                    <label for="parentCate" class="col-sm-3 col-form-label"> Danh mục</label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select parentCate" id="parentCate" name="parentCate">
                            <option value=""> Chọn danh mục</option>
                            <?php echo $dataCate ?>
                        </select>
                        <span class="error_text errParentCate"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="nameCate" class="col-sm-3 col-form-label"> Tên banner <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="nameBanners" onchange="checkExistBanner()" class="form-control nameBanners" autocomplete="off"
                            id="nameBanners" placeholder="Tên banner" value="<?= $post['nameBanners'] ?>">
                        <span class="error_text errNameBanners"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="nameCate" class="col-sm-3 col-form-label"> Nội dung </label>
                    <div class="col-sm-9">
                        <textarea style="height: 100px;" name="contentBanners" class="form-control contentBanners" id="contentBanners"><?php echo $post['contentBanners']; ?></textarea>
                        <span class="error_text errContentBanners"></span>
                    </div>
                </div>

                <div class="form-group row pdn appendNewsThumbnail">
                    <label for="newsTitle" class="col-sm-3 col-form-label">Ảnh thumbnail</label>
                    <label for="newsThumbnail">
                        <img for="newsThumbnail" id="newsThumbnailImg" class="newsThumbnailImg cursorPointer mgl20"
                            src="<?php
                                echo (isset($post['imgThumbnail']) && $post['imgThumbnail'] != '' ) ? URL_IMAGE_SHOW.$post['imgThumbnail'] : base_url('public/images_kho/btn-add-img.svg');
                            ?>" alt="">
                    </label>
                    <input type="file" style="display:none" name="newsThumbnail" class="imgDefault newsThumbnail"
                        onchange="uploadImgJs(event,'div.appendNewsThumbnail','err_newsThumbnailErr','appendNewsThumbnail',0,0, 'newsThumbnailImg','imgThumbnail')"
                        id="newsThumbnail" />
                    <input type="hidden" class="inputImgBs imgThumbnail" value="<?php echo $post['imgThumbnail'] ?>" name="imgThumbnail">
                </div>

                <div class="form-group row pdn">
                    <label for="nameCate" class="col-sm-3 col-form-label"> Link banners <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="linkBanners" class="form-control linkBanners" autocomplete="off"
                            id="linkBanners" placeholder="Link banners" value="<?= $post['linkBanners'] ?>">
                        <span class="error_text errLinkBanners"></span>
                    </div>
                </div>

                <div class="form-group row pdn">
                    <label for="status" class="col-sm-3 col-form-label"> Trạng thái <span
                            style="color: red">(*)</span></label>
                    <div class="col-sm-9">
                        <select class="form-control chosen-select status" id="status" name="status">
                            <option value="0">Không hoạt động</option>
                            <option class="statusYes" value="1">Hoạt động</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success btn-ok saveBanners" disabled>Thêm mới</button>
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