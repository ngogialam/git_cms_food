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
                    <h2 class="card-content-title"><?php echo $title ?></h2>
                    <form action="" id="formSearchListOrdersWare" method="GET" class="notifacation-wrapper">
                        <?php
                            $checkNoti = get_cookie('__news');
                            $checkNoti = explode('^_^', $checkNoti);
                            setcookie("__news", '', time() + (1), '/');
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
                                    value="<?php echo (isset($get['titleNews'])) ? $get['titleNews'] : '' ?>"
                                    name="titleNews" class="form-control" placeholder="Tiêu đề bài viết"
                                    id="titleNews">
                            </div>

                            <div class="form-group col-md-3 pdr-menu">
                                <select class="form-control pdm chosen-select" name="category"
                                    data-placeholder="Chọn Shipper" id="category">
                                    <option value="0">Chọn danh mục sản phẩm</option>
                                    <?php 
                                    echo $cateNews;
                                        if(!empty($listCategory)): 
                                            foreach($listCategory as $keyCategory => $category):
                                    ?>
                                    <option
                                        <?php echo (isset($get['category'] ) && $get['category'] == $category['ID'] ) ? 'selected' : '' ?>
                                        value="<?php echo $category['ID'] ?>"><?php echo $category['NAME'] ?></option>
                                    <?php       
                                            endforeach;
                                        endif; 
                                    ?>
                                    <?php ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="status" data-placeholder=""
                                    id="status">
                                    <option
                                        <?php echo (isset($get['status'] ) && $get['status'] == -1 ) ? 'selected' : '' ?>
                                        selected value="-1">Chọn trạng thái</option>
                                    <option
                                        <?php echo (isset($get['status'] ) && $get['status'] == 1 ) ? 'selected' : '' ?>
                                        value="1">Hoạt động</option>
                                    <option
                                        <?php echo (isset($get['status'] ) && $get['status'] == 0 ) ? 'selected' : '' ?>
                                        value="0">Không hoạt động</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 pdr-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text"
                                            id="searchListOrder">Tìm kiếm</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text"
                                            href="<?= base_url('/tin-tuc/danh-sach-tin-tuc') ?> ">Bỏ lọc</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="main-body">
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="vertical" width="10%"></th>
                                                <th class="vertical" width="10%">Danh mục</th>
                                                <th class="vertical" width="20%">Thumbnail</th>
                                                <th class="vertical" width="20%">Tiêu đề bài viết</th>
                                                <th class="vertical" width="30%">Sapo</th>
                                                <th class="vertical" width="10%">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php 
                                if(!empty($listNews)){
                                foreach ($listNews as $news) { ?>
                                            <tr>
                                                <td>

                                                <a class="btn btn-primary btn-icon-custom" href="<?php echo base_url('/tin-tuc/sua-tin-tuc/'.$news['ID']) ?>"><i class="mdi mdi-pen"></i></a>
                                                <button class="btn btn-danger btn-icon-custom" type="button" onclick="removeNews(<?php echo $news['ID'] ?>)" title="Disable">
                                                    <i class="mdi mdi-close-circle-outline"></i>
                                                </button>

                                                </td>
                                                <td><?php echo $news['CATE_NAME']; ?></td>
                                                <td>
                                                    <div class="thumbnail-wrap"><img class="img-review"
                                                            src="<?php echo URL_IMAGE_SHOW.$news['NEWS_IMG']; ?>"
                                                            alt=""></div>
                                                </td>
                                                <td><a href="<?php echo base_url('/tin-tuc/sua-tin-tuc/'.$news['ID']) ?>"><?php echo $news['NEWS_TITLE']; ?></a></td>
                                                <td><?php echo $news['NEWS_SAPO']; ?></td>
                                                <td> <?php echo ($news['STATUS'] == 1) ? 'Hoạt động' : 'Không hoạt động'; ?>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            <?php   } 
                                }else{ ?>
                                            <tr>
                                                <td style="padding: 20px 10px!important;" colspan="7">Không tìm thấy dữ
                                                    liệu phù hợp.</td>
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
        </form>
    </div>
</div>

<div class="modal fade" id="confirmDRemoveNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                <!-- <button type="button" class="btn btn-danger btn-ok">Delete</button> -->
                <button type="button" class="btn btn-danger btn-ok btnRemoveNews" data-dismiss="modal">Xóa</button>
                <!-- <a class="btn btn-danger btn-ok" href="<?php //echo base_url('/backend/news/delete/'.$new['id']) ?>"
                    title="Xóa"> Xóa </a> -->
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