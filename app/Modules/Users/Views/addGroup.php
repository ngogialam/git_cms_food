<!-- partial:partials/_navbar.html -->
<?php 
  $requestUri = explode("/",$_SERVER['REQUEST_URI'])[2];
  $link_active = explode("?",$requestUri)[0];
?>

<div class="main-panel">
    <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                <h3 class="card-content-title"><?= $title ?></h3>
                    <form action="" id="form-create-group-user" method="POST">
                        <div class="form-group row pdn">
                            <label for="name" class="col-sm-3 col-form-label"> Tên nhóm <span style="color: red">(*)</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" autocomplete="off" id="name" placeholder="Tên nhóm" value="<?php echo $post['name'] ?>">
                                <span class="error_text" id="err_name"><?php echo $getErrors['name'] ?></span>
                            </div>
                        </div>

                        <div class="form-group row pdn">
                            <label for="description" class="col-sm-3 col-form-label"> Mô tả nhóm <span style="color: red">(*)</span></label>
                            <div class="col-sm-9">
                                <!-- <input type="password" name="description" class="form-control" id="description" placeholder="Mô tả nhóm" value=""> -->
                                <textarea name="description" class="form-control" rows="5" placeholder="Mô tả chi tiết nhóm" cols="30" rows="10"><?php echo $post['description'] ?></textarea>
                                <span class="error_text" id="err_description"><?php echo $getErrors['description'] ?></span>
                            </div>
                        </div>

                        <div class="form-group row pdn">
                            <label for="code" class="col-sm-3 col-form-label"> Mã nhóm <span style="color: red">(*)</span></label>
                            <div class="col-sm-9">
                                <select class="form-control chosen-select " id="code" name="code">
                                    <option value="0">Chọn mã nhóm</option>
                                    <?php foreach($arrPermission as $keyPermission => $valuePermission): ?>
                                        <option <?php echo ($keyPermission == $post['code'] ) ? 'selected' : '' ?> value="<?= $keyPermission ?>"><?= $valuePermission ?></option>
                                        <?php endforeach; ?>
                                </select>
                                <span class="error_text" id="err_code"><?php echo $getErrors['code'] ?></span>
                            </div>
                        </div>
                        
                        <div class="form-group row pdn">
                            <label for="status" class="col-sm-3 col-form-label"> Trạng thái <span style="color: red">(*)</span></label>
                            <div class="col-sm-9">
                                <select class="form-control chosen-select " id="status" name="status">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Không hoạt động</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row text-right">
                            <div class="col-sm-12">
                                <a type="button" href="<?php echo base_url('/user/danh-sach-nguoi-dung') ?>" id="goBack" class="btn btn-danger">Hủy</a>
                                <button type="submit" id="btn-add-group-user" class="btn btn-primary btn-add-group-user">Thêm mới</button>
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