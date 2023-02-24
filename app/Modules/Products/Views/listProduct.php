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
                    <h3 class="card-content-title"><?= $title ?></h3>
                    <form action="" id="formSearchListOrdersWare" method="GET" class="notifacation-wrapper">
                        <?php
                            $checkNoti = get_cookie('__product');
                            $checkNoti = explode('^_^', $checkNoti);
                            setcookie("__product", '', time() + (1), '/');
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
                                <input type="text" value="<?php echo (isset($get['name'])) ? $get['name'] : '' ?>"
                                    name="name" class="form-control" placeholder="Tên sản phẩm" id="name">
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control chosen-select " id="goodsType" name="goodsType">
                                    <option value="0">Chọn loại sản phẩm</option>
                                    <?php
                                    if(!empty($listProductType)):
                                        foreach($listProductType as $productType):
                                ?>
                                    <option <?php echo ($get['goodsType'] == $productType['ID']) ? 'selected' : ''; ?>
                                        value="<?= $productType['ID'] ?>"><?= $productType['NAME'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control chosen-select areaApply"
                                    data-placeholder="Chọn khu vực áp dụng" name="areaApply">
                                    <option value="0">Chọn khu vực</option>
                                    <option <?php echo ('ALL' == $get['areaApply']) ? 'selected' : ''; ?> value="ALL">
                                        Toàn Quốc</option>
                                    <?php
                                                if(!empty($listArea)):
                                                    foreach($listArea as $area):
                                            ?>
                                    <option <?php echo ($area['CODE'] == $get['areaApply']) ? 'selected' : ''; ?>
                                        value="<?= $area['CODE'] ?>"><?= $area['NAME'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="promotionFlag"
                                    data-placeholder="Chọn Shipper" id="promotionFlag">
                                    <option
                                        <?php echo (isset($get['promotionFlag']) && ($get['promotionFlag'] == '-1')) ? 'selected' : ''; ?>
                                        value="-1">Sản phẩm khuyến mại</option>
                                    <option
                                        <?php echo (isset($get['promotionFlag']) && ($get['promotionFlag'] == '1')) ? 'selected' : ''; ?>
                                        value="1">Có</option>
                                    <option
                                        <?php echo (isset($get['promotionFlag']) && ($get['promotionFlag'] == '0')) ? 'selected' : ''; ?>
                                        value="0">Không</option>

                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="bestSellFlag"
                                    data-placeholder="Chọn Shipper" id="bestSellFlag">
                                    <option
                                        <?php echo(isset($get['bestSellFlag']) && ($get['bestSellFlag'] == '-1')) ? 'selected' : ''; ?>
                                        value="-1">Sản phẩm bán chạy</option>
                                    <option
                                        <?php echo(isset($get['bestSellFlag']) && ($get['bestSellFlag'] == '1')) ? 'selected' : ''; ?>
                                        value="1">Có</option>
                                    <option
                                        <?php echo(isset($get['bestSellFlag']) && ($get['bestSellFlag'] == '0')) ? 'selected' : ''; ?>
                                        value="0">Không</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="status" data-placeholder=""
                                    id="status">
                                    <!-- <option
                                        <?php //echo (isset($get['status'] ) && $get['status'] == -1 ) ? 'selected' : '' ?>
                                        selected value="-1">Chọn trạng thái</option> -->
                                    <option
                                        <?php echo (isset($get['status'] ) && $get['status'] == 1 ) ? 'selected' : '' ?>
                                        value="1">Hoạt động</option>
                                    <option
                                        <?php echo (isset($get['status'] ) && $get['status'] == 0 ) ? 'selected' : '' ?>
                                        value="0">Không hoạt động</option>
                                </select>
                            </div>
                        </div>
                        <div class="row searchBar">
                            <div class="form-group col-md-2 pdr-menu">
                                <select class="form-control pdm chosen-select" name="cateId"
                                    data-placeholder="Danh mục cha" id="permission">
                                    <option value="-1">Chọn danh mục</option>
                                    <?php echo $listCate ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mgbt searchBar">
                            <div class="form-group col-md-4 pdr-menu">
                                <input class="checkAll check-action" id="checkAll" value="all-order" name="check[]"
                                    type="checkbox">
                                <button class="dropdown-toggle action-all fz13" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Chức năng
                                    chung</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownAction" x-placement="bottom-start">
                                    <div class="dropdown-item action-item" onclick="offProductMulti(1)">
                                        <i class="icon ico-approved"></i>
                                        <a href="javascript:;" class="fz13" title="">Hiển thị sản phẩm đã chọn</a>
                                    </div>
                                    <div class="dropdown-item action-item" onclick="offProductMulti(0)">
                                        <i class="icon ico-approved"></i>
                                        <a href="javascript:;" class="fz13" title="">Ẩn sản phẩm đã chọn</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-8 pdl-menu">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="button" class="btn btn-success btn-icon-text"
                                            onclick="exportExcelItemsScale()" id="exportExcelScale">Xuất excel cho cân</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <button type="submit" class="btn btn-primary btn-icon-text"
                                            id="searchListOrder">Tìm kiếm</button>
                                    </div>
                                    <div class="pr-1 mb-4 mb-xl-0">
                                        <a class="btn btn-danger bth-cancel btn-icon-text"
                                            href="<?= base_url('/san-pham/danh-sach-san-pham') ?> ">Bỏ lọc</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </form>
        <div class="main-body">
            <?php if(empty($listProducts)){ ?>
            <div class="listOders-bd-1 dontHaveOrver d-flex">
                <div class="card mt-2 noData">
                    <div class="card-body dont-have">
                        Không có dữ liệu phù hợp
                    </div>
                </div>
            </div>
            <?php }else{ 
                foreach($listProducts as $product) : ?>
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-1 dspal">
                            <input style="padding: 5px 9px;margin-bottom:8px;" type="checkbox" name="check[]"
                                class="checkSingle check-action" value="<?php echo $product->ID; ?>" />
                            <a class="btn btn-primary btn-icon-custom"
                                href="<?php echo base_url('/san-pham/sua-san-pham/'.$product->ID); ?>"><i
                                    class="mdi mdi-pen"></i></a>
                            <?php if($product->STATUS == 0){ ?>
                            <button type="button" class="btn btn-success btn-icon-custom"
                                onclick="activeRowProduct(<?php echo $product->ID; ?>)" title="Active">
                                <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                            </button>
                            <?php }else{ ?>
                            <button class="btn btn-danger btn-icon-custom" type="button"
                                onclick="confirmDisableProduct(<?php echo $product->ID; ?>)" title="Disable">
                                <i class="mdi mdi-close-circle-outline"></i>
                            </button>
                            <?php } ?>
                        </div>

                        <div class="col-2">
                            <?php
                                $getImagesProduct = $productModels->getImagesProduct($product->ID, $username);
                            ?>
                            <img class="imgProduct" src="<?php echo URL_IMAGE_SHOW.$getImagesProduct[0]->IMAGE; ?>"
                                alt="">
                        </div>
                        <div class="col-4">
                            <p>Tên sản phẩm: <span class="fontWeight"><a
                                        href="<?php echo base_url('/san-pham/sua-san-pham/'.$product->ID); ; ?>"><?= $product->NAME ?></a></span>
                            </p>
                            <p>Loại sản phẩm: <span class="fontWeight"><?= $product->TYPENAME ?></span></p>
                            <p>Danh mục sản phẩm: <span class="fontWeight"><?= $product->CATE_NAME ?></span></p>
                            <p>Sản phẩm khuyến mại: <span
                                    class="fontWeight"><?= ($product->PROMOTION_FLAG == 1) ? 'Có' : 'Không'; ?></span>
                            </p>
                            <p>Sản phẩm bán chạy: <span
                                    class="fontWeight"><?= ($product->BEST_SELL_FLAG == 1) ? 'Có' : 'Không'; ?></span>
                            </p>
                            <p>Trạng thái: <span
                                    class="fontWeight"><?= ($product->STATUS == 1) ? 'Hiển thị' : 'Không hiển thị'; ?></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>Khu vực áp dụng:
                                <span>
                                    <?php
                                    $nameArea = ''; 
                                    $getProvinceName = $productModels->getProvinceName($product->AREA);
                                    if(!empty($getProvinceName)){
                                        $nameArea .= $getProvinceName[0]->name;
                                    }
                                    echo $nameArea;
                                
                                ?>
                                </span>
                            </p>
                            <p>Quy cách đóng gói | Giá | Số lượng</p>
                            <ul>
                                <?php
                                $getPriceProduct = $productModels->getPriceProduct($product->ID, $username);
                                    $priceProduct = $product->priceProduct;
                                    if(!empty($getPriceProduct)):
                                        foreach($getPriceProduct as $price):
                                            if(isset($arrPriceType[$price->UNIT])){
                                                $unitType = $arrPriceType[$price->UNIT];
                                            }else{
                                                $unitType = 'gram';
                                            }
                                ?>
                                <li>
                                    <?php echo number_format($price->WEIGHT,0,",",".") .' '.$unitType.' | ' .number_format($price->PRICE) .'đ | '. $price->STOCK .' SP'; ?>
                                </li>
                                <?php endforeach; endif; ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach; } ?>
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


<div class="modal fade" id="confirmDeleteRow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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