<!-- partial:partials/_navbar.html -->
<?php 
  $requestUri = explode("/",$_SERVER['REQUEST_URI'])[2];
  $link_active = explode("?",$requestUri)[0];
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h2><?php echo $title; ?></h2>
                <form action="" id="form-create-group-user" method="POST">
                    <div class="form-group row pdn">
                        <label for="parentCate" class="col-sm-3 col-form-label"> Danh mục cha <span
                                style="color: red">(*)</span></label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select " id="parentCate" name="parentCate">
                                <option value="0"> Chọn danh mục cha</option>
                                <?php echo $listCate ?>
                            </select>
                            <span class="error_text errNewsTitle"><?php echo $getErrors['parentCate']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row pdn">
                        <label for="nameCate" class="col-sm-3 col-form-label"> Tên danh mục <span
                                style="color: red">(*)</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="nameCate" class="form-control nameCate" autocomplete="off"
                                id="nameCate" placeholder="Tên danh mục" value="<?= $post['nameCate'] ?>">
                            <span class="error_text errNewsTitle"><?php echo $getErrors['nameCate']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row pdn appendNewsThumbnail imgThumbnail">
                        <label for="newsTitle" class="col-sm-3 col-form-label">Ảnh thumbnail</label>
                        <label for="newsThumbnail">
                            <img for="newsThumbnail" id="newsThumbnailImg" class="newsThumbnailImg cursorPointer mgl20"
                                src="<?php
                                    echo (isset($post['imgThumbnailNews']) && $post['imgThumbnailNews'] != '' ) ? URL_IMAGE_SHOW.$post['imgThumbnailNews'] : base_url('public/images_kho/btn-add-img.svg');
                                // echo base_url('public/images_kho/btn-add-img.svg');
                                ?>" alt="">
                        </label>
                        <!-- <input type="file" style="display:none" name="newsThumbnail" class="imgDefault newsThumbnail"
                                onchange="loadFile(event,'newsThumbnailImg','err_newsThumbnailErr')" id="newsThumbnail" /> -->
                        <input type="file" style="display:none" name="newsThumbnail" class="imgDefault newsThumbnail"
                            onchange="uploadImgJs(event,'div.appendNewsThumbnail','err_newsThumbnailErr','appendNewsThumbnail',0,0, 'newsThumbnailImg','imgThumbnailNews')"
                            id="newsThumbnail" />
                        <input type="hidden" class="inputImgBs imgThumbnailNews" value="<?php echo $post['imgThumbnailNews'] ?>" name="imgThumbnailNews">
                    </div>
                    <p class="error_text err_newsThumbnailErr" style="margin-left:25px;"><?php echo $getErrors['imgThumbnailNews']; ?> </p>

                    <div class="form-group row pdn">
                        <label for="positionCate" class="col-sm-3 col-form-label"> Thứ tự hiển thị</label>
                        <div class="col-sm-9">
                            <input type="text" name="positionCate" class="form-control positionCate" onkeypress="return isNumber(event)" autocomplete="off"
                                id="positionCate" placeholder="Thứ tự hiển thị" value="<?= $post['positionCate'] ?>">
                            <span class="error_text errNewsTitle"><?php echo $getErrors['positionCate']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row pdn">
                        <label for="popularFlag" class="col-sm-3 col-form-label"> Hiển thị ở block danh mục phổ biến </label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select " id="popularFlag" name="popularFlag">
                                <option <?php echo ($post['popularFlag'] == 0) ? 'selected' : ''; ?> value="0">Không</option>
                                <option <?php echo ($post['popularFlag'] == 1) ? 'selected' : ''; ?> value="1">Có</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row pdn">
                        <label for="productFlag" class="col-sm-3 col-form-label"> Hiển thị ở block sản phẩm của HolaFood </label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select " id="productFlag" name="productFlag">
                                <option <?php echo ($post['productFlag'] == 0) ? 'selected' : ''; ?> value="0">Không</option>
                                <option <?php echo ($post['productFlag'] == 1) ? 'selected' : ''; ?> value="1">Có</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row pdn">
                        <label for="status" class="col-sm-3 col-form-label"> Trạng thái <span
                                style="color: red">(*)</span></label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select " id="status" name="status">
                                <option <?php echo ($post['status'] == 1) ? 'selected' : ''; ?> value="1">Hoạt động</option>
                                <option <?php echo ($post['status'] == 0) ? 'selected' : ''; ?> value="0">Không hoạt động</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row text-right">
                        <div class="col-sm-12">
                            <a type="button" href="<?php echo base_url('tin-tuc/danh-sach-tin-tuc') ?>" id="goBack"
                                class="btn btn-danger">Hủy</a>
                            <button type="submit" id="btn-add-news"
                                class="btn btn-primary btn-add-news">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
let sapoNews;
ClassicEditor
    .create(document.querySelector('#newsSapo'), {
        ckfinder: {
            uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
            // uploadUrl: '/uploadImgsCK',
        },
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