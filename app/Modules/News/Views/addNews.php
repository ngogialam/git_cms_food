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
                        <label for="newsCate" class="col-sm-3 col-form-label"> Danh mục bài viết <span
                                style="color: red">(*)</span></label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select " id="newsCate" name="newsCate">
                                <option value="0"> Chọn danh mục bài viết</option>
                                <?php
                                echo $cateNews;
                                if(!empty($listCategory)):
                                    foreach($listCategory as $cate):
                            ?>
                                <option <?php echo ($post['newsCate'] == $cate['ID']) ? 'selected' : ''; ?>
                                    value="<?= $cate['ID'] ?>"><?= $cate['NAME'] ?></option>

                                <?php endforeach; endif; ?>
                            </select>
                            <span class="error_text errNewsTitle"><?php echo $getErrors['newsCate']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row pdn">
                        <label for="newsTitle" class="col-sm-3 col-form-label"> Tên bài viết <span
                                style="color: red">(*)</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="newsTitle" class="form-control newsTitle" autocomplete="off"
                                id="newsTitle" placeholder="Tên bài viết" value="<?= $post['newsTitle'] ?>">
                            <span class="error_text errNewsTitle"><?php echo $getErrors['newsTitle']; ?></span>
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
                        <input type="hidden" class="inputImgBs imgThumbnailNews"
                            value="<?php echo $post['imgThumbnailNews'] ?>" name="imgThumbnailNews">
                    </div>
                    <p class="error_text err_newsThumbnailErr" style="margin-left:25px;">
                        <?php echo $getErrors['imgThumbnailNews']; ?> </p>

                    <div class="form-group row pdn">
                        <label for="newsSapo" class="col-sm-3 col-form-label"> Sapo bài viết <span
                                style="color: red">(*)</span></label>
                        <div class="col-sm-9">

                            <textarea name="newsSapo" class="newsSapo"
                                id="newsSapo"><?php echo $post['newsSapo']; ?></textarea>

                            <span class="error_text errNewsSapo"><?php echo $getErrors['newsSapo']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row pdn">
                        <label for="newsContent" class="col-sm-3 col-form-label"> Nội dung bài viết <span
                                style="color: red">(*)</span></label>
                        <div class="col-sm-9">
                            <textarea name="newsContent" class="newsContent"
                                id="newsContent"><?php echo $post['newsContent']; ?></textarea>
                            <span class="error_text errNewsContent"><?php echo $getErrors['newsContent']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row pdn">
                        <label for="status" class="col-sm-3 col-form-label"> Trạng thái <span
                                style="color: red">(*)</span></label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select " id="status" name="status">
                                <option <?php echo ($post['status'] == 1) ? 'selected' : ''; ?> value="1">Hoạt động
                                </option>
                                <option <?php echo ($post['status'] == 0) ? 'selected' : ''; ?> value="0">Không hoạt
                                    động</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row text-right">
                        <div class="col-sm-12">
                            <a type="button" href="<?php echo base_url('tin-tuc/danh-sach-tin-tuc') ?>" id="goBack"
                                class="btn btn-danger">Hủy</a>
                            <button type="submit" id="btn-add-news" class="btn btn-primary btn-add-news">Thêm
                                mới</button>
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
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                'link', '|',
                'outdent', 'indent', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'code', 'codeBlock', '|',
                'insertTable', '|',
                'uploadImage', 'blockQuote', '|',
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