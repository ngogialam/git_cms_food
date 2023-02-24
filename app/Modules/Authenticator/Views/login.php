<!--==========================
Login Section
============================-->
<section id="hero" class="d-flex align-items-center login banner-login"
  style="background-image: url(<?php echo base_url('public/images/login/bannerlogin.png');?>) ;">
  <div class="container" style="margin-top: 18px;margin-bottom: 18px;">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12 col-xs-8 ml-auto login-form">
        <h4 class="lg-title"><?= lang('Label.lbl_login') ?></h4>
        <p class="lg-sapo"><?= lang('Label.lbl_sapo_login') ?></p>
        <form action="" id="form-search-user" method="POST" enctype="multipart/form-data">
          <div class="">
            <input class="form-control frm-lg" id="username" name="username" data-rule="minlen:4"
              data-msg="Please enter at least 4 chars" placeholder="<?= lang('Label.lbl_username') ?>" type="text"
              value="<?= $oldData['username'] ?>"
              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
            <span class=" err_messages err_email"><?php echo $getErrors['username']; ?></span>
          </div>

          <div class=" ">
            <input class="form-control frm-lg pass_log_id" id="password" name="password" data-rule="minlen:4"
              value="<?= $oldData['password'] ?>" data-msg="Please enter at least 4 chars"
              placeholder="<?= lang('Label.lbl_password') ?>" type="password">
            <span toggle="#password-field" class="fa fa-fw field-icon-eye toggle-password fa-eye "
              onclick="showPass('password')"></span>
            <span class=" err_messages err_email"><?php echo $getErrors['password']; ?></span>
            <span class=" err_messages err_email"><?php echo $error; ?></span>
          </div>
          <label style="margin-bottom: 16px;float: left;">
            <input class="frm-check" value="1" name="remember_pass" checked type="checkbox">
            <span><?= lang('Label.lbl_rememberPassword') ?></span>
          </label>

          <!-- <div class="form-group formlogin">
            <div class="g-recaptcha" data-sitekey="6LcFuKsbAAAAAEuvwWjU0YxHwZi4RlbBR0YkKheB">
            </div>
          </div> -->


          <div class=" btn-login" style="margin-bottom: 19px;">
            <input type="submit" name="submit" value="<?= lang('Label.lbl_login') ?>"
              class="btn form-control btn-primary">
          </div>

          <div class="col-md-12 text-center" style="line-height: 0px;">
            <span class="note-p note-p-dn"><a href="quen-mat-khau"
                style="font-size: 14px;"><?= lang('Label.lbl_forgotPassword'); ?></a></span>

            <div class="wrap-dn-now wrap-dn-now-dn">
              <fb:login-button scope="public_profile,email" onlogin="checkLoginState();" id="loginFacebook"
                style="line-height: 25px;">
              </fb:login-button>

              <a href="<?php echo $loginGoogle; ?>"> <img src="https://holaship.vn/public/images/Gmail.svg"
                  alt="dang-nhap-gmail" class="img-fluid"></a>
            </div>
            <span style="font-size: 14px;"><?= lang('Label.lbl_noAccount') ?> <a href="/dang-ky"
                style="color: #2DB1DB;">? <?= lang('Label.lbl_register') ?></a></span>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<section>
  <div id="addPhoneNumber" <?php echo !empty($dataGoogle) ? 'style="width:100%!important"' : '' ?> class="overlay">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="overlay-content">
      <div class="container" style="margin-top: 18px;margin-bottom: 18px;">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-12 col-xs-8 m-auto login-form">
            <h4 class="lg-title"><?= lang('Label.lbl_addPhoneNumber') ?></h4>
            <?php if(empty($dataGoogle)){ ?>
            <form action="<?= base_url('/vi/loginSocial'); ?>" id="form-add-phone" method="POST"
              enctype="multipart/form-data">
              <?php }else{ ?>
              <form action="<?= base_url('/vi/loginSocial'); ?>" id="form-add-phone" method="POST"
                enctype="multipart/form-data">
                <?php } ?>
                <div class=" form-add-phone-ext">
                  <input class="form-control frm-lg" id="addPhoneInput"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                    name="phone" autocomplete="off" placeholder="<?= lang('Label.ph_phone') ?>" type="text">
                  <span class=" err_messages err_phone"><?php echo $getErrors['phone']; ?></span>
                  <?php if(!empty($dataGoogle)){ ?>
                  <input class="form-control frm-lg" id="socialId" name="socialId" autocomplete="off"
                    value=" <?= $dataGoogle->id ?>" placeholder="" type="hidden">
                  <input class="form-control frm-lg" id="accessToken" name="accessToken" autocomplete="off"
                    value=" <?= $dataGoogle->ggToken ?>" placeholder="" type="hidden">
                  <input class="form-control frm-lg" id="socialType" name="typeSocial" autocomplete="off" value="2"
                    placeholder="" type="hidden">
                  <?php } ?>
                </div>
                <div class=" btn-login">
                  <span class="btn form-control btn-primary" id="addPhone">
                    <?= lang('Label.lbl_additional') ?> </span>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php if($callModal == 1){ ?>
<script>
var message = '<?php echo lang('Label.err_2112') ?>';
openModal(message);
</script>
<?php } ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>