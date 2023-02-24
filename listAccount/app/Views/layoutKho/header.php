<!DOCTYPE html>
<html lang='en'>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HolaFood</title>
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/screen.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/chosen/chosen.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/chosen/chosen-custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/vendors/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/vendors/base/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/daterangepicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/jquery.datetimepicker.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('public/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/anhtt.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/quangtv.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/listaccount.css') ?>">

    <script src="<?php echo base_url('public/assets/vendors/base/vendor.bundle.base.js'); ?>"></script>
    <script src="<?php echo base_url('public/js/loader.js?v=' . microtime(true) . ''); ?>"></script>

    <script src="<?php echo base_url('public/assets/js/moment.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/assets/js/bootstrap-datepicker.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/assets/js/daterangepicker.js'); ?>"></script>
    <script src="<?php echo base_url('public/assets/js/config-daterangepicker.js'); ?>"></script>
    <script src="<?php echo base_url('ckeditor5/ckeditor.js') ?>" referrerpolicy="origin"></script>
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery.datetimepicker.full.min.js') ?>"></script>


    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
</head>

<body class="sidebar-icon-only">
    <div id="loader" class="show fullscreen ">
        <svg svg class="circular " width="80px" height="80px">
            <circle class="loader-path" cx="40" cy="40" r="30" fill="none" stroke="#2DB1DB" stroke-width="1"></circle>
            <circle class="path" cx="40" cy="40" r="30" fill="none" stroke-width="7" stroke-miterlimit="10" stroke="#F0A616">
            </circle>
        </svg>
    </div>
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="<?php echo base_url('/don-hang/danh-sach-don-hang') ?>"><img style="height: 40px;width:150px" src="<?php echo base_url('public/images/Logo_Holafresh.svg') ?>" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="<?php echo base_url('/don-hang/danh-sach-don-hang') ?>"><img src="<?php echo base_url('public/images_kho/logo-mini.png') ?>" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
            <div class="search-field d-none d-md-block">

            </div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link" title="Đăng xuất" style="color:black" href="javascript:void(0)">
                        <?php echo $dataUser->username . ' - ' . $dataUser->name . ' - ' . $dataUser->role ?>
                    </a>
                </li>
                <li class="nav-item d-none d-lg-block full-screen-link cursorPointer">
                    <a class="nav-link" href="<?php echo base_url('/user/doi-mat-khau') ?>" title="Đổi mật khẩu">
                        <i class="mdi mdi-account-key"></i>
                    </a>
                </li>
                <li class="nav-item nav-logout d-none d-lg-block">
                    <a class="nav-link" title="Đăng xuất" href="<?php echo base_url('/dang-xuat') ?>">
                        <i class="mdi mdi-power"></i>
                    </a>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>