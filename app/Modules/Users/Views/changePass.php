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
                    <form action="" id="form-create-user" method="POST" class="notifacation-wrapper">
                        <?php
                            $checkNoti = get_cookie('__user');
                            $checkNoti = explode('^_^', $checkNoti);
                            setcookie("__user", '', time() + (1), '/');
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
                        <div class="form-group row pdn">
                            <label for="password" class="col-sm-3 col-form-label"> M???t kh???u m???i <span style="color: red">(*)</span></label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Nh???p m???t kh???u" value="<?= $detailUser['NAME'] ?>">
                                <span class="error_text" ><?= $getErrors['password'] ?></span>
                            </div>
                        </div>

                        <div class="form-group row pdn">
                            <label for="rePassword" class="col-sm-3 col-form-label"> Nh???p l???i m???t kh???u <span style="color: red">(*)</span></label>
                            <div class="col-sm-9">
                                <input type="password" name="rePassword" class="form-control" id="rePassword" placeholder="Nh???p m???t kh???u" value="<?= $detailUser['NAME'] ?>">
                                <span class="error_text err_repassword" ><?= $getErrors['rePassword'] ?></span>
                            </div>
                        </div>

                        <div class="form-group row text-right">
                            <div class="col-sm-12">
                                <a type="button" href="<?php echo base_url('/don-hang/danh-sach-don-hang') ?>" id="goBack" class="btn btn-danger">H???y</a>
                                <button type="submit" id="btn-add-user" class="btn btn-primary btn-add-user"> ?????i m???t kh???u </button>
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