<!--==========================
  Login Section
============================-->
<section id="hero" class="d-flex align-items-center register banner-login "
  style="background-image: url(<?php echo base_url('public/images/login/bannerlogin.png');?>);">
  <div class="container" style="margin-top: 26px; margin-bottom: 26px;">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12 col-xs-8 ml-auto login-form">
        <h4 class="lg-title mb-3"><?= lang('Label.lbl_register') ?></h4>
        <form action="" id="form-search-user" method="POST" enctype="multipart/form-data">
          <div class=" ">
            <input class="form-control frm-lg" autocomplete="off" id="phone" name="phone"
              value="<?php echo $listValues['phone']; ?>" data-msg="<?= lang('Label.lbl_checkChars') ?>"
              placeholder="<?= lang('Label.ph_phone') ?>" type="text"
              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
            <span class=" err_messages err_phone"><?php echo $getErrors['phone']; ?></span>
          </div>
          <div class=" ">
            <!-- pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" -->
            <input class="form-control frm-lg" id="email" autocomplete="off" type="text" name="email"
              value="<?php echo $listValues['email']; ?>" data-msg="<?= lang('Label.lbl_checkChars') ?>"
              placeholder="Email">
            <span class=" err_messages err_email"><?php echo $getErrors['email']; ?></span>
          </div>

          <div class=" ">
            <input class="form-control frm-lg pass_log_id" id="password" autocomplete="off"
              value="<?php echo $listValues['password']; ?>" data-msg="<?= lang('Label.lbl_checkChars') ?>"
              placeholder="<?= lang('Label.ph_password') ?>" name="password" type="password">
            <span toggle="#password-field" class="fa fa-fw field-icon-eye toggle-password fa-eye"
              onclick="showPass('password')"></span>
            <span class=" err_messages err_password"><?php echo $getErrors['password']; ?></span>
          </div>
          <div class=" ">
            <input class="form-control frm-lg pass_log_id" id="repassword"
              value="<?php echo $listValues['rePassword']; ?>" data-msg="<?= lang('Label.lbl_checkChars') ?>"
              placeholder="<?= lang('Label.ph_repassword') ?>" name="rePassword" type="password">
            <span toggle="#password-field" class="fa fa-fw field-icon-eye toggle-repassword fa-eye"
              onclick="showPass('repassword')"></span>
            <span class=" err_messages err_repassword"><?php echo $getErrors['rePassword']; ?></span>
            <span class=" err_messages "><?php echo $error; ?></span>
          </div>
          <label style="padding-left: 10px;">
            <input class="frm-check" name="legalsAndRules" value="1" checked type="checkbox">
            <span><?= lang('Label.lbl_agreeWith') ?> <a target="_blank" href=""><u
                  style="color: #7ccee8; font-weight: bold;"><?= lang('Label.lbl_termAndLegi') ?></u>
              </a><?= lang('Label.lbl_fromHLS') ?></span>
            <p class=" err_messages "><?php echo \Config\Services::validation()->showError('legalsAndRules'); ?></p>
          </label>
          <div class="btn-login">
            <button type="submit" name="register" value="1" class="btn form-control btn-register btn-primary">
              <?= lang('Label.btn_next') ?></button>
          </div>
          <div class="col-md-12 " style="margin-top: 15px;">
            <p class="note-p note-p-dn"><?= lang('Label.lbl_have_account') ?>? <a href="dang-nhap"
                style="margin-top: -10px;"><?= lang('Label.lbl_login') ?></a></p>
            <div class="wrap-dn-now wrap-dn-now-dn">
              <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"> </fb:login-button>
              <a href="<?php echo $loginGoogle; ?>"> <img src="https://holaship.vn/public/images/Gmail.svg"
                  alt="dang-nhap-gmail" class="img-fluid"></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>