<!-- partial:partials/_navbar.html -->
<?php
$requestUri = explode("/", $_SERVER['REQUEST_URI'])[2];
$link_active = explode("?", $requestUri)[0];
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3 class="card-content-title"><?= $title ?></h3>
                <form action="" id="form-create-user" method="POST" class="notifacation-wrapper">
                    <?php
                    $checkNoti = get_cookie('__product');
                    $checkNoti = explode('^_^', $checkNoti);
                    // setcookie("__product", '', time() + (1), '/');
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
                    <input type="hidden" class="setId" value="<?php echo $setId; ?>" name="setId">
                    <div class="form-group row pdn">
                        <div class="col-6">
                            <label for="goodsType">Loại sản phẩm</label>
                            <select class="form-control chosen-select goodsType" id="goodsType" name="goodsType">
                                <!-- <option value="0">Chọn loại sản phẩm</option> -->
                                <?php
                                if (!empty($listProductType)) :
                                    foreach ($listProductType as $productType) :
                                ?>
                                        <option <?php echo ($setDetail->setType == $productType['ID']) ? 'selected' : ''; ?> value="<?= $productType['ID'] ?>"><?= $productType['NAME'] ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                            <p><span class="error_text"><?php echo $getErrors['goodsType']; ?></span></p>
                        </div>
                        <div class="col-md-6">
                            <label for="setCate"> Danh mục sản phẩm <span style="color: red">(*)</span></label>
                            <select class="form-control chosen-select setCate" data-placeholder="Chọn danh mục sản phẩm" multiple id="setCate" name="setCate[]">
                                <?php echo $listCate; ?>
                            </select>
                            <span class="error_text errSetCate"></span>
                        </div>
                    </div>
                    <div class="form-group row pdn">
                        <div class="col-md-6">
                            <label for="nameCate"> Tên set sản phẩm <span style="color: red">(*)</span></label>
                            <input type="text" name="setName" class="form-control setName" id="setName" placeholder="Tên set sản phẩm" value="<?= $setDetail->setName ?>">
                            <span class="error_text errSetName"></span>
                        </div>
                        <div class="col-6 ">
                            <div class="">
                                <label for="areaApply">Khu vực áp dụng </label>
                                <select class="form-control chosen-select areaApply" id="areaApply" multiple data-placeholder="Chọn khu vực áp dụng" name="areaApply[]">
                                    <option <?php
                                            $keyArea = array_search('ALL', array_column($setDetail->areas, 'code'));
                                            if ($keyArea !== false) {
                                                echo 'selected';
                                            }
                                            ?> value="ALL">Toàn Quốc</option>
                                    <?php
                                    if (!empty($listArea)) :
                                        foreach ($listArea as $area) :
                                    ?>
                                            <option <?php
                                                    $keyArea = array_search($area['CODE'], array_column($setDetail->areas, 'code'));
                                                    if ($keyArea !== false) {
                                                        echo 'selected';
                                                    }
                                                    ?> value="<?= $area['CODE'] ?>"><?= $area['NAME'] ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                                <span class="error_text"><?php echo $getErrors['checkArea']; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row pdn  appendProductThumbnail imgThumbnail mg0">
                        <label for="productThumbnail">
                            Ảnh thumbnail
                            <img for="productThumbnail" id="productThumbnailImg" class="productThumbnailImg cursorPointer " src="<?php echo $setDetail->thumbnailImage ?>" alt="">
                        </label>
                        <!-- <input type="file" style="display:none" name="productThumbnail" class="imgDefault productThumbnail"
                        onchange="loadFile(event,'productThumbnailImg','err_productThumbnailErr')" id="productThumbnail" /> -->
                        <input type="file" style="display:none" name="productThumbnail" class="imgDefault productThumbnail" onchange="uploadImgJs(event,'div.appendProductThumbnail','err_productThumbnailErr','appendProductThumbnail',0,0, 'productThumbnailImg','imgThumbnailProduct', 'inputThumbnailProduct')" id="productThumbnail" />
                        <input type="hidden" class="inputThumbnailProduct imgThumbnailProduct" value="<?php echo $setDetail->thumbnailImage ?>" name="imgThumbnailProduct">
                    </div>

                    <p class="error_text err_productThumbnailErr" style="margin-left:25px;">
                        <?php echo $getErrors['imgThumbnailProduct'] ?></p>

                    <div class="form-group row pdn imgThumbnail appendImgProduct mg0">
                        <label for="frontBsRegis">
                            Ảnh set sản phẩm
                            <img for="frontBsRegis" id="frontBsRegisImg" class="frontBsRegisImg cursorPointer" count='0' src="<?php echo base_url('public/images_kho/btn-add-img.svg'); ?>" alt="">
                        </label>
                        <input type="file" style="display:none" name="frontBsRegis" class="imgDefault frontBsRegis" onchange="uploadImgJs(event,'div.appendImgProduct','err_imgUpload','appendImgProduct',0,1,'','','inputImgBs',1)" id="frontBsRegis" />
                        <?php
                        $imagesProducts = $setDetail->images;
                        if (!empty($imagesProducts)) :
                            foreach ($imagesProducts as $keyImg => $imagesProduct) :
                        ?>
                                <div class="wrapImgAppend wrapImgAppend_<?php echo $keyImg + 1; ?>">
                                    <span class="spanClose" onclick="removeImgAppend('<?php echo $keyImg + 1; ?>')">x</span>
                                    <img class="imgAppend inputImgBs_'<?php echo $keyImg + 1; ?>'" src="<?php echo $imagesProduct->path ?>" alt="">
                                    <input type="hidden" class="inputImgBs inputImgBs_<?php echo $keyImg + 1; ?>" value="<?php echo $imagesProduct->path; ?>" name="inputImg[]">
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
                            <label for="sapoSetProduct">Mô tả sản phẩm</label>
                            <textarea name="sapoSetProduct" id="sapoSetProduct" class=" form-control" placeholder="Mô tả sản phẩm" rows="6"><?php echo $setDetail->sapo ?></textarea>
                            <p><span class="error_text"><?php echo $getErrors['sapoSetProduct']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <label for="contentSetProduct">Chi tiết sản phẩm</label>
                            <textarea name="contentSetProduct" id="contentSetProduct" class=" form-control" placeholder="Chi tiết sản phẩm" rows="6"><?php echo $setDetail->content ?></textarea>
                            <p><span class="error_text"><?php echo $getErrors['contentSetProduct']; ?></span></p>
                        </div>
                    </div>
                    <div class="form-group row pdn">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success btn-ok addSetProductPlus" count="0">
                                <span><i class="mdi mdi-plus-circle-outline"></i></span> Thêm sản phẩm vào set</button>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <label for="setPrice"> Giá set <span style="color: red">(*)</span></label>
                                <input type="text" name="setPrice" class="form-control setPrice" id="setPrice" onkeyup="number_format('setPrice', 1)" onkeypress="return isNumber(event)" placeholder="Giá set" value="<?php echo ($setDetail->price != '' && $setDetail->price != 0) ? number_format($setDetail->price) : ''; ?>">
                                <span class="error_text errSetPrice"><?php echo $getErrors['setPrice'] ?></span>
                            </div>
                    </div>

                    <div class="form-group pdn">

                        <?php
                        $packages = $setDetail->setProducts;
                        if (empty($packages)) { ?>
                            <div class="wrapProduct row">
                                <div class="col-md-1 rowPaddingFirst">
                                    <label for="productPrice"> Default </label>
                                    <input class="check-action isDefaultAction isDefault_0" key="0" value="1" name="pack[0][isDefault]" type="checkbox">
                                </div>
                                <div class="col-md-2 setProductPlusDiv-0 rowPadding">
                                    <label for="setProductPlus">Sản phẩm theo set <span style="color: red">(*)</span></label>
                                    <select class="form-control chosen-select setProductPlusKey-0 setProductPlus" key="0" name="pack[0][product]">
                                        <option value="">Chọn sản phẩm theo set</option>
                                        <?php
                                        if (!empty($listProducts)) {
                                            foreach ($listProducts as $item) :
                                        ?>
                                                <option value="<?php echo $item->id ?>"><?php echo $item->name ?> </option>

                                        <?php
                                            endforeach;
                                        }
                                        ?>
                                    </select>
                                    <span class="error_text errSetProductPlus-0"></span>
                                </div>
                                <div class="col-md-2 setProductPriceKeyDiv-0 rowPadding">
                                    <label for="setProductPrice">Quy cách đóng gói <span style="color: red">(*)</span></label>
                                    <select class="form-control chosen-select setProductPriceKey-0 setProductPrice" name="pack[0][productPrice]">
                                        <option value="0">Chọn quy cách đóng gói</option>
                                    </select>
                                    <span class="error_text errSetProductPrice-0"></span>
                                </div>

                                <div class="col-md-3 setProductQuantityDiv-0 rowPadding">
                                    <label for="productPrice"> Số lượng <span style="color: red">(*)</span></label>
                                    <input type="text" name="pack[0][setQuantity]" class="form-control setQuantity setQuantity-0" placeholder="Số lượng" value="<?= $post['setQuantity'] ?>">
                                    <span class="error_text errSetQuantity errSetQuantity-0"></span>
                                </div>
                                <div class="col-md-2 totalMoneyDiv-0 rowPadding">
                                    <label for="totalMoney"> Thành tiền </label>
                                    <input type="text" name="pack[0][totalMoney]" disabled class="form-control totalMoney totalMoney-0" placeholder="Thành tiền" value="<?= $post['productPosition'] ?>">
                                    <span class="error_text errTotalMoney errTotalMoney-0"></span>
                                    <input type="hidden" name="pack[0][totalMoney]" class="totalMoneyPost-0" />
                                </div>
                                <div class="col-md-1 setProductPositionDiv-0 rowPadding">
                                    <label for="productPrice"> Thứ tự </label>
                                    <input type="text" name="pack[0][productPosition]" class="form-control productPosition productPosition-0" placeholder="Thứ tự SP" value="<?= $post['productPosition'] ?>">
                                    <span class="error_text errProductPosition errProductPosition-0"></span>
                                </div>
                                <div class="col-md-1">
                                    <label for="removeProductPlus" class="blRemoveProductPlus"></label>
                                    <button type="button" class="btn btn-danger removeProductPlus removeProductPlus-0"><span><i class="mdi mdi-minus-circle-outline"></i></span></button>
                                </div>
                            </div>
                            <?php
                        } else {

                            $packages = $setDetail->setProducts;
                            foreach ($packages as $keyPack => $itemPack) :
                                $priceProduct = $itemPack->prices;
                            ?>
                                <div class="wrapProduct row setProductPlusItem">
                                    <div class="col-md-1 rowPaddingFirst">
                                        <label for="productPrice"> Default </label>
                                        <input <?php echo ($itemPack->isDefault == 1) ? 'checked' : '' ?> class="check-action isDefaultAction isDefault_<?php echo $keyPack ?>" key="<?php echo $keyPack ?>" value="1" name="pack[<?php echo $keyPack ?>][isDefault]" type="checkbox">
                                    </div>
                                    <?php
                                    if ($itemPack->isDefault == 0) {
                                        $priceClass = 'col-md-3';
                                    } else {
                                        $priceClass = 'col-md-1';
                                    }

                                    ?>
                                    <div class="col-md-2 setProductPlusDiv-<?php echo $keyPack ?> rowPadding">
                                        <label for="setProductPlus">Sản phẩm theo set <span style="color: red">(*)</span></label>
                                        <select class="form-control chosen-select setProductPlusKey-<?php echo $keyPack ?> setProductPlus" key="<?php echo $keyPack ?>" name="pack[<?php echo $keyPack ?>][product]">
                                            <option value="">Chọn sản phẩm theo set</option>
                                            <?php
                                            if (!empty($listProducts)) {
                                                foreach ($listProducts as $item) :
                                            ?>
                                                    <option <?php echo ($itemPack->productId == $item->id) ? 'selected' : ''; ?> value="<?php echo $item->id ?>"><?php echo $item->name ?> </option>

                                            <?php
                                                endforeach;
                                            }
                                            ?>
                                        </select>
                                        <span class="error_text errSetProductPlus-<?php echo $keyPack ?>"></span>
                                    </div>
                                    <div class="col-md-2 setProductPriceKeyDiv-<?php echo $keyPack ?> rowPadding">
                                        <label for="setProductPrice">Quy cách đóng gói <span style="color: red">(*)</span></label>
                                        <select class="form-control chosen-select setProductPriceKey-<?php echo $keyPack ?> setProductPrice" name="pack[<?php echo $keyPack ?>][productPrice]">
                                            <option value="0">Chọn quy cách đóng gói</option>
                                            <?php
                                            if(!empty($priceProduct)):
                                            foreach ($priceProduct as $priceItem) :
                                            ?>
                                                <option price="<?php echo $priceItem->price ?>" <?php echo ($itemPack->productPriceId == $priceItem->id) ? 'selected' : '' ?> value="<?php echo $priceItem->id ?>"><?php echo $priceItem->weight . ' ' . $priceItem->unit; ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                        <span class="error_text errSetProductPrice-<?php echo $keyPack ?>"></span>
                                    </div>
                                    <?php
                                    if ($itemPack->isDefault == 1) { ?>
                                        <div class="col-md-2 setQuantityDefault-<?php echo $keyPack ?> rowPadding">
                                            <label for="productPrice">Số lượng mặc định <span style="color: red">(*)</span></label>
                                            <input  type="text" name="pack[<?php echo $keyPack ?>][setQuantityDefault]" class="form-control setQuantityDefault setQuantityDefault-<?php echo $keyPack ?>" placeholder="Số lượng" value="<?php echo $itemPack->defaultQuantity ?>">
                                            <span class="error_text errSetQuantity errSetQuantity-<?php echo $keyPack ?>"></span>
                                        </div>
                                    <?php } ?>

                                    <div class="<?php echo $priceClass; ?> setProductQuantityDiv-<?php echo $keyPack ?> rowPadding">
                                        <label for="productPrice"> Số lượng <span style="color: red">(*)</span></label>
                                        <input key="<?php echo $keyPack ?>" type="text" name="pack[<?php echo $keyPack ?>][setQuantity]" class="form-control setQuantity setQuantity-<?php echo $keyPack ?>" placeholder="Số lượng" value="<?= $itemPack->quantity ?>">
                                        <span class="error_text errSetQuantity errSetQuantity-<?php echo $keyPack ?>"></span>
                                    </div>
                                    <div class="col-md-2 totalMoneyDiv-<?php echo $keyPack ?> rowPadding">
                                        <label for="totalMoney"> Thành tiền </label>
                                        <input type="text" name="pack[<?php echo $keyPack ?>][totalMoney]" disabled class="form-control totalMoney totalMoney-<?php echo $keyPack .' ||'.$itemPack->price?>" placeholder="Thành tiền" value="<?php echo ($itemPack->price) ? number_format($itemPack->price * $itemPack->quantity) :''; ?>">
                                        <span class="error_text errTotalMoney errTotalMoney-<?php echo $keyPack ?>"></span>
                                        <input type="hidden" value="<?php echo $itemPack->price; ?>" name="pack[<?php echo $keyPack ?>][totalMoney]" class="totalMoneyPost-<?php echo $keyPack ?>" />
                                    </div>
                                    <div class="col-md-1 setProductPositionDiv-<?php echo $keyPack ?> rowPadding">
                                        <label for="productPrice"> Thứ tự </label>
                                        <input type="text" name="pack[<?php echo $keyPack ?>][productPosition]" class="form-control productPosition productPosition-<?php echo $keyPack ?>" placeholder="Thứ tự SP" value="<?= $itemPack->positionProduct ?>">
                                        <span class="error_text errProductPosition errProductPosition-<?php echo $keyPack ?>"></span>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="removeProductPlus" class="blRemoveProductPlus"></label>
                                        <button type="button" class="btn btn-danger removeProductPlus removeProductPlus-<?php echo $keyPack ?>"><span><i class="mdi mdi-minus-circle-outline"></i></span></button>
                                    </div>
                                </div>
                        <?php endforeach;
                        } ?>
                    </div>

                    <div class="form-group row pdn ">
                        <div class="col-6">
                            <label for="setNutrition">Dinh dưỡng</label>
                            <textarea name="setNutrition" id="setNutrition" class=" form-control setNutrition" placeholder="Dinh dưỡng" rows="6"><?php echo $setDetail->nutrition; ?></textarea>
                        </div>
                        <div class="col-6">
                            <label for="setEffectual">Công dụng</label>
                            <textarea name="setEffectual" id="setEffectual" class=" form-control setEffectual" placeholder="Công dụng" rows="6"><?php echo $setDetail->effectual; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row pdn ">
                        <div class="col-6">
                            <label for="setProcessing">Chế biến</label>
                            <textarea name="setProcessing" class=" form-control setProcessing" placeholder="Chế biến" rows="6"><?php echo $setDetail->processing; ?></textarea>
                        </div>
                        <div class="col-6">
                            <label for="preserve">Bảo quản</label>
                            <textarea name="preserve" class=" form-control setPreserve" placeholder="Bảo quản" rows="6"><?php echo $setDetail->preserve; ?></textarea>
                            <p><span class="error_text"><?php echo $getErrors['preserve']; ?></span></p>
                        </div>

                    </div>
                    <div class="form-group row pdn ">
                        <div class="col-6 dspl">
                            <div class="floatLeftRowBig">
                                <label for="cook">Công thức nấu ăn</label>
                                <select class="form-control chosen-select cooking-select cook" multiple id="cook" name="cook[]" data-placeholder="Chọn công thức nấu ăn">
                                    <?php


                                    if (!empty($listCooking)) {
                                        foreach ($listCooking as $cook) :
                                            $keyCook = array_search($cook['ID'], array_column($setDetail->cooks, 'id'));
                                            $selectedCook = '';
                                            if ($keyCook !== false) {
                                                $selectedCook =  'selected';
                                            }
                                    ?>
                                            <option <?php echo $selectedCook; ?> value="<?= $cook['ID'] ?>"><?= $cook['NEWS_TITLE'] ?></option>
                                    <?php endforeach;
                                    } ?>
                                </select>
                                <p><span class="error_text"><?php echo $getErrors['checkCook']; ?></span></p>
                            </div>
                            <div class="floatLeftRowSmall">
                                <a class="nav-link " title="Thêm công thức nấu ăn" href="javascript:void(0)">
                                    <i class="fz35 mdi mdi-plus-circle" onclick="showModalNews()"></i>
                                </a>
                            </div>

                        </div>
                        <div class="col-6">
                            <label for="seasonal">Thời vụ gieo trồng</label>
                            <select class="form-control chosen-select setSeasonal " id="seasonal" multiple data-placeholder="Chọn thời vụ gieo trồng" name="seasonal[]">
                                <?php
                                if (!empty($arrSeasonal)) :
                                    $seasonalArr = explode(",", $setDetail->seasonal);
                                    foreach ($arrSeasonal as $keySeasonal => $valSeasonal) :
                                ?>
                                        <option <?php echo (in_array($keySeasonal, $seasonalArr)) ? 'selected' : ''; ?> value="<?= $keySeasonal ?>"><?= $valSeasonal ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                            <p><span class="error_text"><?php echo $getErrors['checkSeasons']; ?></span></p>
                        </div>

                    </div>

                    <div class="form-group row pdn ">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    <label for="exampleInputUsername1">Hiển thị khuyến mại</label>
                                    </br>
                                    <input type="radio" name="promotionFlag" class="or-radio-checked promotionFlagYes " id="promotionFlagYes" value="1" <?php echo ($setDetail->promotionFlag == 1) ? 'checked' : ''; ?>>
                                    <label for="promotionFlagYes">Có</label><br>
                                    <input type="radio" value="0" name="promotionFlag" class="or-radio-checked promotionFlagNo " id="promotionFlagNo" <?php echo ($setDetail->promotionFlag == 0) ? 'checked' : ''; ?>>
                                    <label for="promotionFlagNo">Không</label>
                                </div>
                                <div class="col-4">
                                    <label for="exampleInputUsername1">Hiển thị bán chạy</label>
                                    </br>
                                    <input type="radio" name="bestSellFlag" class="or-radio-checked bestSellFlagYes " id="bestSellFlagYes" value="1" <?php echo ($setDetail->bestSellFlag == 1) ? 'checked' : ''; ?>>
                                    <label for="bestSellFlagYes">Có</label><br>
                                    <input type="radio" value="0" name="bestSellFlag" class="or-radio-checked bestSellFlagNo " id="bestSellFlagNo" <?php echo ($setDetail->bestSellFlag == 0) ? 'checked' : ''; ?>>
                                    <label for="bestSellFlagNo">Không</label>
                                </div>
                                <div class="col-4">
                                    <label for="positionProduct">Thứ tự hiển thị</label>
                                    </br>
                                    <input type="text" name="positionProduct" class="form-control positionProduct" id="positionProduct" value="<?php echo (isset($setDetail->positionSet)) ? $setDetail->positionSet : '1'; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">

                            <label for="status">Trạng thái</label>
                            <select class="form-control chosen-select status" id="status" name="status">
                                <option <?php echo ($setDetail->status == 1) ? 'selected' : '' ?> value="1">Hoạt động</option>
                                <option <?php echo ($setDetail->status == 0) ? 'selected' : '' ?> value="0">Không hoạt động</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row text-right">
                        <div class="col-sm-12">
                            <a type="button" href="<?php echo base_url('/san-pham/danh-sach-san-pham') ?>" id="goBack" class="btn btn-danger">Hủy</a>
                            <button type="submit" class="btn btn-success btn-ok saveSetProduct">Sửa set</button>
                        </div>
                    </div>
                </form>
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
                        <input type="text" name="newsTitle" class="form-control newsTitle" autocomplete="off" id="newsTitle" placeholder="Tên bài viết" value="<?= $post['newsTitle'] ?>">
                        <span class="error_text errNewsTitle"></span>
                    </div>
                </div>

                <div class="form-group row pdn  appendNewsThumbnail imgThumbnail mg0">
                    <label for="newsThumbnail">
                        Ảnh thumbnail
                        <img for="newsThumbnail" id="newsThumbnailImg" class="newsThumbnailImg cursorPointer " src="<?php echo base_url('public/images_kho/btn-add-img.svg'); ?>" alt="">
                    </label>
                    <!-- <input type="file" style="display:none" name="newsThumbnail" class="imgDefault newsThumbnail"
                        onchange="loadFile(event,'newsThumbnailImg','err_newsThumbnailErr')" id="newsThumbnail" /> -->
                    <input type="file" style="display:none" name="newsThumbnail" class="imgDefault newsThumbnail" onchange="uploadImgJs(event,'div.appendNewsThumbnail','err_newsThumbnailErr','appendNewsThumbnail',0,0, 'newsThumbnailImg','imgThumbnailNews')" id="newsThumbnail" />
                    <input type="hidden" class="inputImgBs imgThumbnailNews" value="" name="imgThumbnailNews">
                </div>
                <p class="error_text err_newsThumbnailErr" style="margin-left:25px;"> </p>

                <div class="form-group row pdn ">
                    <div class="col-12">
                        <label for="newsSapo">Sapo bài viết</label>
                        <input type="text" name="newsSapo" class="form-control newsSapo" autocomplete="off" id="newsSapo" placeholder="Tên bài viết" value="<?= $post['newsTitle'] ?>">
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
    let sapoSetProduct;
    ClassicEditor
        .create(document.querySelector('#sapoSetProduct'), {
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
        .then(setproductSapo => {
            sapoSetProduct = setproductSapo;
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    let contentSetProduct;
    ClassicEditor
        .create(document.querySelector('#contentSetProduct'), {
            ckfinder: {
                uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
                withCredentials: true,
            },
        })
        .then(setProductContent => {
            contentSetProduct = setProductContent;
        })
        .catch(error => {
            console.error(error);
        });
</script>

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