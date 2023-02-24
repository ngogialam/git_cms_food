<!-- partial:partials/_navbar.html -->
<?php 
// if(!isset($productDetail->priceProduct) || empty($productDetail->priceProduct)){
//     echo 111;
// }else{
//     echo 222;
// }
// echo '<pre>';
// print_r($productDetail);die;
  $requestUri = explode("/",$_SERVER['REQUEST_URI'])[2];
  $link_active = explode("?",$requestUri)[0];
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h2><?php echo $title; ?></h2>
                <form action="" id="formEditProduct" method="POST">
                    <div class="form-group row pdn ">
                        <div class="col-6">
                            <label for="goodsType">Loại sản phẩm <span
                                style="color: red">(*)</span></label>
                            <select class="form-control chosen-select " id="goodsType" name="goodsType">
                                <option value="0">Chọn loại sản phẩm</option>
                                <?php
                                    if(!empty($listProductType)):
                                        foreach($listProductType as $productType):
                                ?>
                                <option
                                    <?php echo ($productDetail->PRODUCT_TYPE == $productType['ID']) ? 'selected' : ''; ?>
                                    value="<?= $productType['ID'] ?>"><?= $productType['NAME'] ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                            <p><span class="error_text"><?php echo $getErrors['goodsType']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <label for="category">Danh mục sản phẩm <span
                                style="color: red">(*)</span></label>
                            <select class="form-control chosen-select " data-placeholder="Chọn danh mục sản phẩm"
                                multiple id="category" name="category[]">
                                <?php echo $listCate; ?>
                            </select>
                            <p><span class="error_text"><?php echo $getErrors['category']; ?></span></p>
                        </div>
                    </div>
                    <div class="form-group row pdn ">
                        <div class="col-6">
                            <label for="productName">Tên sản phẩm <span
                                style="color: red">(*)</span></label>
                            <input type="text" name="productName" class="form-control checkExistProductName"
                                autocomplete="off" id="productName" placeholder="Tên sản phẩm"
                                value="<?php echo $productDetail->NAME; ?>">
                            <span class="error_text productNameErr"><?php echo $getErrors['productName']; ?></span>
                        </div>
                        <div class="col-6 ">
                            <label for="areaApply">Khu vực áp dụng <span
                                style="color: red">(*)</span></label>
                            <select class="form-control chosen-select areaApply" multiple
                                data-placeholder="Chọn khu vực áp dụng" name="areaApply[]">
                                <option <?php echo (in_array('ALL',$productDetail->AREA)) ? 'selected' : '' ?>
                                    value="ALL">Toàn Quốc</option>
                                <?php
                                                if(!empty($listArea)):
                                                    foreach($listArea as $area):
                                            ?>
                                <option
                                    <?php echo (isset($productDetail->AREA) && in_array($area['CODE'],$productDetail->AREA)) ? 'selected' : ''; ?>
                                    value="<?= $area['CODE'] ?>"><?= $area['NAME'] ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                            <span class="error_text"><?php echo $getErrors['checkArea']; ?></span>
                        </div>
                    </div>

                    <div class="form-group pdn appendPack">
                        <?php
                            if(!isset($productDetail->priceProduct) || empty($productDetail->priceProduct)){
                        ?>
                        <div class="row packProduct pack_0 countAppendPack">
                            <div class="col-2">
                                <label for="priceType">Loại đóng gói <span
                                style="color: red">(*)</span></label>
                                <select class="form-control chosen-select " id="priceType" name="pack[0][priceType]">
                                    <option value="0">Chọn loại đóng gói</option>
                                    <?php
                                    if(!empty($arrPriceType)):
                                        foreach($arrPriceType as $key => $priceType):
                                ?>
                                    <option <?php echo ($post['priceType'] == $productType['ID']) ? 'selected' : ''; ?>
                                        value="<?= $key ?>"><?= $priceType ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                                <span class="error_text"><?php echo $getErrors['checkPriceType']; ?></span>
                            </div>
                            <div class="col-3">
                                <label for="weight">Quy cách đóng gói <span
                                style="color: red">(*)</span></label>
                                <input type="text" name="pack[0][weight]" class="form-control" autocomplete="off"
                                    placeholder="Quy cách đóng gói: 100" value="">
                                <span class="error_text"><?php echo $getErrors['checkWeight']; ?></span>
                            </div>
                            <div class="col-3">
                                <label for="price">Giá theo quy cách <span
                                style="color: red">(*)</span></label>
                                <input type="text" name="pack[0][price]" class="form-control" autocomplete="off"
                                    placeholder="Giá theo quy cách" value="">
                                <span class="error_text"><?php echo $getErrors['checkPrice']; ?></span>
                            </div>

                            <div class="col-3">
                                <label for="quantity">Số lượng <span
                                style="color: red">(*)</span></label>
                                <input type="text" name="pack[0][quantity]" class="form-control" autocomplete="off"
                                    placeholder="Số lượng" value="">
                                <span class="error_text"><?php echo $getErrors['checkQuantity']; ?></span>
                            </div>

                            <div class="col-1 dspl">
                                <div class="floatLeftRowSmall">
                                    <a class="nav-link btnAppend fz35" title="Thêm quy cách" href="javascript:void(0)"
                                        onclick="appendPack(0)">
                                        <i class="mdi mdi-plus-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php }else{
                            $packages = $productDetail->priceProduct;
                            $keyEnd = array_key_last($packages);
                            foreach($packages as $keyPack => $package): ?>
                        <div class="row packProduct pack_<?php echo $keyPack; ?>">
                            <div class="col-2">
                                <label for="priceType">Loại đóng gói <span
                                style="color: red">(*)</span></label>
                                <select class="form-control chosen-select " id="priceType"
                                    name="pack[<?php echo $keyPack ?>][priceType]">
                                    <option value="0">Chọn loại đóng gói</option>
                                    <?php
                                    if(!empty($arrPriceType)):
                                        foreach($arrPriceType as $key => $priceType):
                                ?>
                                    <option <?php echo ($package->TYPE == $key) ? 'selected' : ''; ?>
                                        value="<?= $key ?>"><?= $priceType ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                                <span
                                    class="error_text"><?php echo $getErrors['checkPack'][$keyPack]['checkPriceType']; ?></span>
                            </div>
                            <div class="col-3">
                                <label for="weight">Quy cách đóng gói <span
                                style="color: red">(*)</span></label>
                                <input type="text" name="pack[<?php echo $keyPack ?>][weight]"
                                    onkeypress="return isNumber(event)" class="form-control" autocomplete="off"
                                    placeholder="Quy cách đóng gói: 100"
                                    value="<?php  echo ($package->WEIGHT != '' && $package->WEIGHT != 0) ? number_format($package->WEIGHT,0,",",".") :''; ?>">
                                <span
                                    class="error_text"><?php echo $getErrors['checkPack'][$keyPack]['checkWeight']; ?></span>
                            </div>

                            <div class="col-3">
                                <label for="price">Giá theo quy cách <span
                                style="color: red">(*)</span></label>
                                <input type="text" name="pack[<?php echo $keyPack ?>][price]"
                                    onkeypress="return isNumber(event)"
                                    class="form-control pack_price_<?php echo $keyPack ?>" autocomplete="off"
                                    placeholder="Giá theo quy cách"
                                    onkeyup="number_format('pack_price_<?php echo $keyPack ?>', 1)"
                                    value="<?php echo ($package->PRICE != '' && $package->PRICE != 0) ? number_format($package->PRICE) :''; ?>">
                                <span
                                    class="error_text"><?php echo $getErrors['checkPack'][$keyPack]['checkPrice']; ?></span>
                            </div>
                            <div class="col-3">
                                <label for="quantity">Số lượng <span
                                style="color: red">(*)</span></label>
                                <input type="text" name="pack[<?php echo $keyPack ?>][quantity]"
                                    onkeypress="return isNumber(event)" class="form-control" autocomplete="off"
                                    placeholder="Số lượng" value="<?php echo $package->STOCK ?>">
                                <span
                                    class="error_text"><?php echo $getErrors['checkPack'][$keyPack]['checkQuantity']; ?></span>
                            </div>
                            <input type="hidden" value="<?php echo $package->ID; ?>"
                                name="pack[<?php echo $keyPack ?>][idPrice]">

                            <div class="col-1 dspl">
                                <?php
                                    if($keyPack == $keyEnd){
                                ?>
                                <div class="floatLeftRowBig">
                                    <div class="floatLeftRowSmall">
                                        <a class="nav-link btnAppend btnAppend_<?php echo $keyPack ?> fz35"
                                            title="Thêm quy cách" href="javascript:void(0)"
                                            onclick="appendPack(<?php echo $keyPack; ?>)">
                                            <i class="mdi mdi-plus-circle"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php }else { ?>
                                <div class="floatLeftRowBig">
                                    <div class="floatLeftRowSmall">
                                        <a class="nav-link btnAppend btnAppend_<?php echo $keyPack ?> fz35"
                                            title="Thêm quy cách" href="javascript:void(0)"
                                            onclick="removeAppend(<?php echo $keyPack ?>)"><i
                                                class="mdi mdi-minus-circle"></i></a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php endforeach; } ?>
                    </div>
                    <div class="form-group row pdn  appendProductThumbnail imgThumbnail mg0">
                        <label for="productThumbnail">
                        <span > Ảnh thumbnail  <span style="color: red"> (*) </span></span>

                            <!-- src="<?php //echo base_url('public/images_kho/btn-add-img.svg');?>" -->
                            <img for="productThumbnail" id="productThumbnailImg"
                                class="productThumbnailImg cursorPointer "
                                src="<?php echo URL_IMAGE_SHOW.$productDetail->imagesThumbnail[0] ?>" alt="">
                        </label>
                        <!-- <input type="file" style="display:none" name="productThumbnail" class="imgDefault productThumbnail"
                        onchange="loadFile(event,'productThumbnailImg','err_productThumbnailErr')" id="productThumbnail" /> -->
                        <input type="file" style="display:none" name="productThumbnail"
                            class="imgDefault productThumbnail"
                            onchange="uploadImgJs(event,'div.appendProductThumbnail','err_productThumbnailErr','appendProductThumbnail',0,0, 'productThumbnailImg','imgThumbnailProduct', 'inputThumbnailProduct')"
                            id="productThumbnail" />
                        <input type="hidden" class="inputThumbnailProduct imgThumbnailProduct"
                            value="<?php echo $productDetail->imagesThumbnail[0] ?>" name="imgThumbnailProduct">
                    </div>

                    <p class="error_text err_productThumbnailErr" style="margin-left:25px;">
                        <?php echo $getErrors['imgThumbnailProduct'] ?></p>

                    <div class="form-group row pdn imgThumbnail appendImgProduct mg0">
                        <label for="frontBsRegis">
                        <span>Ảnh sản phẩm <span style="color: red">(*)</span> </span>
                            <img for="frontBsRegis" id="frontBsRegisImg" class="frontBsRegisImg cursorPointer"
                                src="<?php echo base_url('public/images_kho/btn-add-img.svg');?>" alt="">
                        </label>
                        <input type="file" style="display:none" name="frontBsRegis" class="imgDefault frontBsRegis"
                            onchange="uploadImgJs(event,'div.appendImgProduct','err_imgUpload','appendImgProduct')"
                            id="frontBsRegis" />

                        <?php
                            $imagesProducts = $productDetail->imagesProducts;
                            if(!empty($imagesProducts)):
                                foreach($imagesProducts as $keyImg => $imagesProduct):
                        ?>
                        <div class="wrapImgAppend wrapImgAppend_<?php echo $keyImg + 1; ?>">
                            <span class="spanClose" onclick="removeImgAppend('<?php echo $keyImg + 1; ?>')">x</span>
                            <img class="imgAppend inputImgBs_'<?php echo $keyImg + 1; ?>'"
                                src="<?php echo URL_IMAGE_SHOW.$imagesProduct ?>" alt="">
                            <input type="hidden" class="inputImgBs inputImgBs_<?php echo $keyImg + 1; ?>"
                                value="<?php echo $imagesProduct; ?>" name="inputImg[]">
                        </div>
                        <?php
                                endforeach;
                            endif;
                        ?>

                    </div>
                    <p class="error_text err_imgUpload" style="margin-left:25px;">
                        <?php echo $getErrors['inputImg'] ?>
                    </p>

                    <div class="form-group row pdn ">
                        <div class="col-6">
                            <label for="sapoProduct">Mô tả sản phẩm <span
                                style="color: red">(*)</span></label>
                            <textarea name="sapoProduct" id="sapoProduct" class=" form-control"
                                placeholder="Mô tả sản phẩm" rows="6"><?php echo $productDetail->SAPO ?></textarea>
                            <p><span class="error_text"><?php echo $getErrors['sapoProduct']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <label for="contentProduct">Chi tiết sản phẩm <span
                                style="color: red">(*)</span></label>
                            <textarea name="contentProduct" id="contentProduct" class=" form-control"
                                placeholder="Chi tiết sản phẩm"
                                rows="6"><?php echo $productDetail->CONTENT->load() ?></textarea>
                            <p><span class="error_text"><?php echo $getErrors['contentProduct']; ?></span></p>
                        </div>
                    </div>

                    <div class="form-group row pdn ">
                        <div class="col-6">
                            <label for="nutrition">Dinh dưỡng</label>
                            <textarea name="nutrition" id="nutrition" class=" form-control" placeholder="Dinh dưỡng"
                                rows="6"><?php echo $productDetail->NUTRITION ?></textarea>
                        </div>
                        <div class="col-6">
                            <label for="effectual">Công dụng</label>
                            <textarea name="effectual" id="effectual" class=" form-control" placeholder="Công dụng"
                                rows="6"><?php echo $productDetail->EFFECTUAL ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row pdn ">
                        <div class="col-6">
                            <label for="processing">Chế biến</label>
                            <textarea name="processing" class=" form-control" placeholder="Chế biến"
                                rows="6"><?php echo $productDetail->PROCESSING ?></textarea>
                        </div>
                        <div class="col-6">
                            <label for="preserve">Bảo quản</label>
                            <textarea name="preserve" class=" form-control" placeholder="Bảo quản"
                                rows="6"><?php echo $productDetail->PRESERVE ?></textarea>
                        </div>

                    </div>

                    <div class="form-group row pdn ">

                        <div class="col-6 dspl">
                            <div class="floatLeftRowBig">
                                <label for="exampleInputUsername1">Công thức nấu ăn</label>
                                <select class="form-control chosen-select cooking-select" multiple id="cook"
                                    name="cook[]" data-placeholder="Chọn công thức nấu ăn">
                                    <?php
                                    if(!empty($listCooking)){
                                            foreach($listCooking as $cook):
                                    ?>
                                    <option
                                        <?php echo (isset($productDetail->listNewsProduct) && in_array($cook['ID'], $productDetail->listNewsProduct)) ? 'selected' : '' ?>
                                        value="<?= $cook['ID'] ?>"><?= $cook['NEWS_TITLE'] ?></option>
                                    <?php endforeach; } ?>
                                </select>
                                <p><span class="error_text"><?php echo $getErrors['cook']; ?></span></p>
                            </div>
                            <div class="floatLeftRowSmall">
                                <a class="nav-link " title="Thêm công thức nấu ăn" href="javascript:void(0)">
                                    <i class="fz35 mdi mdi-plus-circle" onclick="showModalNews()"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="seasonal">Thời vụ gieo trồng</label>
                            <select class="form-control chosen-select " id="seasonal" multiple
                                data-placeholder="Chọn thời vụ gieo trồng" name="seasonal[]">
                                <?php 
                                    if(!empty($arrSeasonal)):
                                        foreach($arrSeasonal as $keySeasonal => $valSeasonal):
                                ?>
                                <option
                                    <?php $seasonal = explode(",",$productDetail->SEASONAL); echo ( is_array($seasonal)  && in_array($keySeasonal, $seasonal)) ? 'selected' : ''; ?>
                                    value="<?= $keySeasonal ?>"><?= $valSeasonal ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row pdn">


                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    <label for="exampleInputUsername1">Hiển thị khuyến mại</label>
                                    </br>
                                    <input type="radio" name="promotionFlag"
                                        <?php echo ($productDetail->PROMOTION_FLAG == 1) ? 'checked' :''; ?>
                                        class="or-radio-checked promotionFlagYes " id="promotionFlagYes" value="1"
                                        checked="">
                                    <label for="promotionFlagYes">Có</label><br>
                                    <input type="radio" value="0" name="promotionFlag"
                                        <?php echo ($productDetail->PROMOTION_FLAG == 0) ? 'checked' :''; ?>
                                        class="or-radio-checked promotionFlagNo " id="promotionFlagNo">
                                    <label for="promotionFlagNo">Không</label>
                                </div>
                                <div class="col-4">
                                    <label for="exampleInputUsername1">Hiển thị bán chạy</label>
                                    </br>
                                    <input type="radio" name="bestSellFlag" class="or-radio-checked bestSellFlagYes "
                                        <?php echo ($productDetail->BEST_SELL_FLAG == 0) ? 'checked' :''; ?>
                                        id="bestSellFlagYes" value="1" checked="">
                                    <label for="bestSellFlagYes">Có</label><br>
                                    <input type="radio" value="0" name="bestSellFlag"
                                        <?php echo ($productDetail->BEST_SELL_FLAG == 0) ? 'checked' :''; ?>
                                        class="or-radio-checked bestSellFlagNo " id="bestSellFlagNo">
                                    <label for="bestSellFlagNo">Không</label>
                                </div>
                                <div class="col-4">
                                    <label for="positionProduct">Thứ tự hiển thị</label>
                                    </br>
                                    <input type="text" name="positionProduct" class="form-control positionProduct"
                                        id="positionProduct" value="<?php echo $productDetail->POSITION_PRODUCT ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="status" class="col-sm-3 col-form-label"> Trạng thái <span
                                    style="color: red">(*)</span></label>
                            <select class="form-control chosen-select " id="status" name="status">
                                <option <?= ($productDetail->STATUS == 1) ? 'selected' : ''; ?> value="1">Hoạt động
                                </option>
                                <option <?= ($productDetail->STATUS == 0) ? 'selected' : ''; ?> value="0">Không hoạt
                                    động</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row text-right">
                        <div class="col-sm-12">
                            <a type="button" href="<?php echo base_url('/san-pham/danh-sach-san-pham') ?>" id="goBack"
                                class="btn btn-danger">Hủy</a>
                            <button type="button" onclick="submitEditProduct()" id="btn-add-user" class="btn btn-primary btn-add-user">Sửa sản
                                phẩm</button>
                        </div>
                    </div>
                </form>
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
                <button type="button" class="btn btn-primary btn-ok btnDeleteRow" data-dismiss="modal">Sửa sản phẩm</button>
            </div>
        </div>
    </div>
</div>
<div id="cooking-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-custom">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tạo công thức nấu ăn</h4>
            </div>
            <div class="modal-body modal-body-custom">
                <div class="form-group row pdn ">
                    <div class="col-12">
                        <label for="newsTitle">Tên bài viết</label>
                        <input type="text" name="newsTitle" class="form-control newsTitle" autocomplete="off"
                            id="newsTitle" placeholder="Tên bài viết" value="<?= $post['newsTitle'] ?>">
                        <span class="error_text errNewsTitle"></span>
                    </div>
                </div>

                <div class="form-group row pdn  appendNewsThumbnail imgThumbnail mg0">
                    <label for="newsThumbnail">
                        Ảnh thumbnail
                        <img for="newsThumbnail" id="newsThumbnailImg" class="newsThumbnailImg cursorPointer "
                            src="<?php echo base_url('public/images_kho/btn-add-img.svg');?>" alt="">
                    </label>
                    <!-- <input type="file" style="display:none" name="newsThumbnail" class="imgDefault newsThumbnail"
                        onchange="loadFile(event,'newsThumbnailImg','err_newsThumbnailErr')" id="newsThumbnail" /> -->
                    <input type="file" style="display:none" name="newsThumbnail" class="imgDefault newsThumbnail"
                        onchange="uploadImgJs(event,'div.appendNewsThumbnail','err_newsThumbnailErr','appendNewsThumbnail',0,0, 'newsThumbnailImg','imgThumbnailNews')"
                        id="newsThumbnail" />
                    <input type="hidden" class="inputImgBs imgThumbnailNews" value="" name="imgThumbnailNews">
                </div>
                <p class="error_text err_newsThumbnailErr" style="margin-left:25px;"> </p>

                <div class="form-group row pdn ">
                    <div class="col-12">
                        <label for="newsSapo">Sapo bài viết</label>
                        <input type="text" name="newsSapo" class="form-control newsSapo" autocomplete="off"
                            id="newsSapo" placeholder="Tên bài viết" value="<?= $post['newsTitle'] ?>">
                        <span class="error_text errNewsSapo"></span>
                    </div>
                </div>
                <div class="form-group row pdn ">
                    <div class="col-12">
                        <label for="newsContent">Nội dung bài viết</label>
                        <textarea name="newsContent" class="newsContent" id="newsContent"></textarea>
                        <span class="error_text errNewsContent"></span>
                        <!-- <input type="text" name="newsTitle" class="form-control " autocomplete="off" id="newsTitle" placeholder="Tên bài viết" value="<?= $post['newsTitle'] ?>"> -->
                    </div>
                </div>
                <!-- <div class="form-group row pdn">
                    <div class="col-sm-12">
                        <label for="statusNe"> Trạng thái <span style="color: red">(*)</span></label>
                        <select class="form-control chosen-select " id="statusNe" name="statusNe">
                            <option value="1">Hoạt động</option>
                            <option value="0">Không hoạt động</option>
                        </select>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btnAddNewsCook" disabled onclick="addNewsCook()">Thêm bài
                    viết</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script>
let sapoNews;
ClassicEditor
    .create(document.querySelector('#newsSapo'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic',
                'link', '|',
                'outdent', 'indent', '|',
                'bulletedList', 'numberedList', '|',
                'insertTable', '|',
                'blockQuote', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        }
    })
    .then(newsSapo => {
        sapoNews = newsSapo;
    })

    .catch(error => {
        console.error(error);
    });
</script>

<script>
let contentNews;
ClassicEditor
    .create(document.querySelector('#newsContent'), {
        ckfinder: {
            uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
            withCredentials: true,

        },
    })
    .then(newsContent => {
        contentNews = newsContent;
    })
    .catch(error => {
        console.error(error);
    });
</script>

<script>
let sapoProduct;
ClassicEditor
    .create(document.querySelector('#sapoProduct'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic',
                'link', '|',
                'outdent', 'indent', '|',
                'bulletedList', 'numberedList', '|',
                'insertTable', '|',
                'blockQuote', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        }
    })
    .then(productSapo => {
        sapoProduct = productSapo;
    })
    .catch(error => {
        console.error(error);
    });
</script>

<script>
let contentProduct;
ClassicEditor
    .create(document.querySelector('#contentProduct'), {
        ckfinder: {
            uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
            withCredentials: true,
        },
    })
    .then(productContent => {
        contentProduct = productContent;
    })
    .catch(error => {
        console.error(error);
    });
</script>