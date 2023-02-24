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
                    <form action="" id="form-create-user" method="POST">
                        <div class="form-group row pdn">
                            <label for="phoneLogin" class="col-sm-3 col-form-label"> Số điện thoại đăng nhập <span style="color: red">(*)</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="phoneLogin" class="form-control checkExistPhone" id="phoneLogin" value="<?= $post['phoneLogin'] ?>" onkeypress="return isNumber(event)" placeholder="Số điện thoại đăng nhập" value="">
                                <span class="error_text checkExistPhoneErr"><?= $getErrors['phoneLogin'] ?></span>
                            </div>
                        </div>

                        <div class="form-group row pdn">
                            <label for="fullName" class="col-sm-3 col-form-label"> Tên người dùng <span style="color: red">(*)</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="fullName" class="form-control checkCharacter" id="fullName" placeholder="Tên người dùng" value="<?= $post['fullName'] ?>">
                                <span class="error_text" ><?= $getErrors['fullName'] ?></span>
                            </div>
                        </div>

                        <div class="form-group row pdn">
                            <label for="dob" class="col-sm-3 col-form-label"> Ngày sinh </label>
                            <div class="col-sm-9">
                                <input type="text" name="dob" class="form-control datePicker" id="dob" placeholder="Ngày sinh" value="<?= $post['dob'] ?>">
                                <span class="error_text" ></span>
                            </div>
                        </div>

                        <div class="form-group row pdn">
                            <label for="email" class="col-sm-3 col-form-label"> Email </label>
                            <div class="col-sm-9">
                                <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?= $post['email'] ?>">
                                <span class="error_text" ></span>
                            </div>
                        </div>

                        <div class="form-group row pdn">
                            <label for="groupUser" class="col-sm-3 col-form-label"> Nhóm người dùng <span style="color: red">(*)</span></label>
                            <div class="col-sm-9">
                                <select class="form-control chosen-select " id="groupUser" name="groupUser">
                                    <option value="0">Chọn nhóm người dùng</option>
                                    <?php
                                        if(!empty($listGroupUser)){
                                            foreach($listGroupUser as $groupUser):
                                            ?> 
                                            <option <?php echo ($post['groupUser'] == $groupUser['ID']) ? 'selected' : '' ?> value="<?= $groupUser['ID'] ?>"><?= $groupUser['NAME'] ?></option>
                                        <?php endforeach; } ?>
                                </select>
                                <span class="error_text" ><?= $getErrors['groupUser'] ?></span>
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
                                <button type="submit" id="btn-add-user" disabled class="btn btn-primary btn-add-user">Thêm mới </button>
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