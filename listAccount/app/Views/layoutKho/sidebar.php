<style>
    span.menu-title {
        white-space: break-spaces
    }
</style>
<?php
if (!empty($_SESSION['service']) && isset($_SESSION['service'])) {
    foreach ($_SESSION['service'] as $key => $value) {
        $service[$key] = $value->serviceID;
    }
}
$uri =  explode('/', uri_string());
$page = $uri[0];
$segment = $uri[1];
$role = $dataUser->role;
$arrRole = explode('_', $role);
$permission = 0;
if ($role == 'ADMIN' || in_array('ADMIN', $arrRole)) {
    $permission = 1;
}
if ($role != 'ADMIN' && !in_array('ADMIN', $arrRole) && in_array('FOOD', $arrRole)) {
    $permission = 2;
    if ($role == 'FOOD_SALER' && in_array('SALER', $arrRole) && in_array('FOOD', $arrRole)) {
        $permission = 5;
    }
} else
if ($role != 'ADMIN' && !in_array('ADMIN', $arrRole) && in_array('FARM', $arrRole)) {
    $permission = 3;
} else
if ($role != 'ADMIN' && !in_array('ADMIN', $arrRole) && in_array('FACTORY', $arrRole)) {
    $elsepermission = 4;
}
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav" id="unable-move">
        <div class="nav-item">
            <p class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages" style="height:30px;margin:0px;padding:0px;">
                <span class="list-title">Quản lý món ăn</span>
                <i class="mdi mdi-food menu-icon"></i>
            </p>
        </div>
        <li class="nav-item">
            <ul class="nav flex-column sub-menu">
                <div class="current-list">
                    <li class="nav-item <?php echo (($segment == 'danh-sach-mon-an') ? 'active' : ''); ?>">
                        <a class="nav-link" href="/mon-an/danh-sach-mon-an">
                            <span class="menu-title" style="width: 200px;"> Danh sách món ăn </span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-folder-multiple-outline menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($segment == 'danh-sach-don-hang-food' ? 'active' : ''); ?>">
                        <a class="nav-link" href="/mon-an/danh-sach-don-hang-food">
                            <span class="menu-title" style="width: 200px;"> Danh sách đơn hàng </span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-folder-plus menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($segment == 'tong-hop-don-dat-hang' ? 'active' : ''); ?>">
                        <a class="nav-link" href="/mon-an/tong-hop-don-dat-hang">
                            <span class="menu-title" style="width: 200px;"> Tổng hợp đơn đặt hàng </span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-format-float-left menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($segment == 'danh-sach-tai-khoan-doi-tac' ? 'active' : ''); ?>">
                        <a class="nav-link" href="/mon-an/danh-sach-tai-khoan-doi-tac">
                            <span class="menu-title" style="width: 200px;"> Danh sách tài khoản đối tác </span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-format-float-left menu-icon"></i>
                        </a>
                    </li>

                </div>
            </ul>
        </li>

        <?php
        if ($permission == 1) {
        ?>

            <div class="nav-item">
                <p class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages" style="height:30px;margin:0px;padding:0px;">
                    <span class="list-title">Quản Lý User</span>
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                </p>
            </div>
            <li class="nav-item">
                <ul class="nav flex-column sub-menu">
                    <div class="current-list">
                        <li class="nav-item <?php echo ($segment == 'danh-sach-nguoi-dung' ? 'active' : ''); ?>">
                            <a class="nav-link" href="/user/danh-sach-nguoi-dung">
                                <span class="menu-title" style="width: 200px;"> Danh Sách Users </span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-account menu-icon"></i>
                            </a>
                        </li>
                    </div>
                    <div class="current-list">
                        <li class="nav-item <?php echo ($segment == 'tao-nguoi-dung' ? 'active' : ''); ?>">
                            <a class="nav-link" href="/user/tao-nguoi-dung">
                                <span class="menu-title" style="width: 200px;"> Tạo user </span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-account-plus menu-icon"></i>
                            </a>
                        </li>
                    </div>
                    <div class="current-list">
                        <li class="nav-item <?php echo ($segment == 'tao-nhom-nguoi-dung' ? 'active' : ''); ?>">
                            <a class="nav-link" href="/user/tao-nhom-nguoi-dung">
                                <span class="menu-title" style="width: 200px;"> Tạo nhóm người dùng </span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-account-multiple-plus menu-icon"></i>
                            </a>
                        </li>
                    </div>
                </ul>
            </li>
        <?php }
        if ($permission != 5) { ?>
            <?php if ($permission == 1 || $permission == 2) : ?>
                <div class="nav-item <?php echo ($segment == 'danh-sach-don-hang' ? 'active' : ''); ?>">
                    <a class="nav-link" href="/don-hang/danh-sach-don-hang">
                        <span class="menu-title" style="width: 200px;"> Danh sách đơn hàng </span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-book-open menu-icon"></i>
                    </a>
                </div>


                <div class="nav-item <?php echo ($segment == 'danh-sach-menus' ? 'active' : ''); ?>">
                    <a class="nav-link" href="/menus/danh-sach-menus">
                        <span class="menu-title" style="width: 200px;"> Quản lý menus </span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-format-line-weight menu-icon"></i>
                    </a>
                </div>

                <div class="nav-item <?php echo ($segment == 'danh-sach-danh-muc' ? 'active' : ''); ?>">
                    <a class="nav-link" href="/danh-muc/danh-sach-danh-muc">
                        <span class="menu-title" style="width: 200px;"> Quản lý danh mục </span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-dns menu-icon"></i>
                    </a>
                </div>

                <div class="nav-item <?php echo ($segment == 'danh-sach-banners' ? 'active' : ''); ?>">
                    <a class="nav-link" href="/banners/danh-sach-banners">
                        <span class="menu-title" style="width: 200px;"> Quản lý banners </span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-folder-image menu-icon"></i>
                    </a>
                </div>

                <div class="nav-item <?php echo ($segment == 'danh-sach-phuong-thuc' ? 'active' : ''); ?>">
                    <a class="nav-link" href="/phuong-thuc/danh-sach-phuong-thuc">
                        <span class="menu-title" style="width: 200px;"> Quản lý phương thức </span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-shape-plus menu-icon"></i>
                    </a>
                </div>

                <div class="nav-item <?php echo ($segment == 'danh-sach-danh-gia' ? 'active' : ''); ?>">
                    <a class="nav-link" href="/danh-gia/danh-sach-danh-gia">
                        <span class="menu-title" style="width: 200px;"> Quản lý đánh giá </span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-star menu-icon"></i>
                    </a>
                </div>

                <div class="nav-item">
                    <p class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages" style="height:30px;margin:0px;padding:0px;">
                        <span class="list-title">Quản lý sản phẩm</span>
                        <i class="mdi mdi-food menu-icon"></i>
                    </p>
                </div>
                <li class="nav-item">
                    <ul class="nav flex-column sub-menu">
                        <div class="current-list">
                            <li class="nav-item <?php echo ($segment == 'danh-sach-san-pham' ? 'active' : ''); ?>">
                                <a class="nav-link" href="/san-pham/danh-sach-san-pham">
                                    <span class="menu-title" style="width: 200px;"> Danh sách sản phẩm </span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-folder-multiple-outline menu-icon"></i>
                                </a>
                            </li>
                            <li class="nav-item <?php echo ($segment == 'tao-san-pham' ? 'active' : ''); ?>">
                                <a class="nav-link" href="/san-pham/tao-san-pham">
                                    <span class="menu-title" style="width: 200px;"> Thêm sản phẩm </span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-folder-plus menu-icon"></i>
                                </a>
                            </li>

                        </div>
                    </ul>
                </li>

                <div class="nav-item <?php echo ($segment == 'danh-sach-set-san-pham' ? 'active' : ''); ?>">
                    <a class="nav-link" href="/set-san-pham/danh-sach-set-san-pham">
                        <span class="menu-title" style="width: 200px;">Quản lý set sản phẩm</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-food-fork-drink menu-icon"></i>
                    </a>
                </div>


                <div class="nav-item">
                    <p class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages" style="height:30px;margin:0px;padding:0px;">
                        <span class="list-title">Quản lý tin tức</span>
                        <i class="mdi mdi-file-document menu-icon"></i>
                    </p>
                </div>
                <li class="nav-item">
                    <ul class="nav flex-column sub-menu">
                        <div class="current-list">
                            <li class="nav-item <?php echo ($segment == 'danh-sach-tin-tuc' ? 'active' : ''); ?>">
                                <a class="nav-link" href="/tin-tuc/danh-sach-tin-tuc">
                                    <span class="menu-title" style="width: 200px;"> Danh sách tin tức </span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-message-reply menu-icon"></i>
                                </a>
                            </li>
                            <li class="nav-item <?php echo ($segment == 'them-tin-tuc' ? 'active' : ''); ?>">
                                <a class="nav-link" href="/tin-tuc/them-tin-tuc">
                                    <span class="menu-title" style="width: 200px;"> Thêm tin tức </span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-message-plus menu-icon"></i>
                                </a>
                            </li>

                        </div>
                    </ul>
                </li>

                <div class="nav-item <?php echo ($segment == 'danh-sach-khuyen-mai-san-pham-tang-kem' ? 'active' : ''); ?>">
                    <a class="nav-link" href="/khuyen-mai/danh-sach-khuyen-mai-san-pham-tang-kem">
                        <span class="menu-title" style="width: 200px;"> Quản lý khuyến mãi </span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-gift menu-icon"></i>
                    </a>
                </div>

            <?php endif; ?>
            <?php if ($permission == 1 || $permission == 3) : ?>

        <?php endif;
        } ?>
        <div class="nav-item <?php echo ($segment == 'in-tem-san-pham-moi' ? 'active' : ''); ?>">
            <a class="nav-link" href="/trang-trai/in-tem-san-pham-moi">
                <span class="menu-title" style="width: 200px;"> In mã tem sản phẩm </span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-cloud-print menu-icon"></i>
            </a>
        </div>
        <div class="nav-item <?php echo ($segment == 'in-tem-mau-moi' ? 'active' : ''); ?>">
            <a class="nav-link" href="/trang-trai/in-tem-mau-moi">
                <span class="menu-title" style="width: 200px;"> In mã tem sản phẩm mẫu mới </span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-printer menu-icon"></i>
            </a>
        </div>

        <!-- <div class="nav-item <?php //echo ($segment == 'quan-ly-zalo' ? 'active' : ''); 
                                    ?>">
            <a class="nav-link" href="/quan-ly-zalo">
                <span class="menu-title" style="width: 200px;"> Quản lý biểu mẫu Zalo </span>
                <i class="menu-arrow"></i>
                <img src="<?php //echo base_url('public/images/Zalo.jpg') 
                            ?>" alt="" style="width: 20px;">
            </a>
        </div> -->

    </ul>

</nav>