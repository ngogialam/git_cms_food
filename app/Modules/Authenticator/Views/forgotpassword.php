<!--==========================
  Forgot Password
============================-->
<section id="hero" class="d-flex align-items-center banner-login"
  style="background-image: url(<?php echo base_url('public/images/login/bannerlogin.png');?>) ;">
  <div class="container" style="margin-top: 26px; margin-bottom: 26px;">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12 col-xs-8 ml-auto login-form">
        <h4 class="lg-title" style="margin-bottom: 37px;">
          <a href="/dang-nhap"><img src="<?php echo base_url('public/images/Vector.png');?>" alt=""
              style="float: left;"></a><?= lang('Label.lbl_getPassword') ?>
        </h4>
        <form action="" id="form-forgot-password" method="POST" enctype="multipart/form-data">
          <div class="  d-flex">
            <input class="form-control frm-lg" id="phoneOtp" name="phoneGetOtp" value="<?php echo $numberPhone ?>"
              placeholder="<?= lang('Label.ph_phone') ?>"
              onkeyup="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" type="text">
            <span onclick="reSendPass()" class="btn-forgot fz13"
              id="getOtpForgotPassword"><?= lang('Label.lbl_getOTP') ?>
            </span>
            <span class="btn-forgot fz13" style="display:none" id="timeOtpForgotPassword"></span>
          </div>
          <p class="err_messages errPhone" id="errPhone"><?php echo $getErrors['phoneGetOtp']; ?></p>

          <div class="  inputOTP">
            <input class="form-control frm-lg" id="otpResPass" disabled name="otp"
              placeholder="<?= lang('Label.lbl_putOTP') ?>" type="text"
              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
              value="<?php echo $getOTP ?>">
            <input type="hidden" value="<?php echo $getOTP ?>" name="otpBackup" class="otpBackup">

          </div>
          <p class=" err_messages err_otp">
            <?php
            echo $getErrors['otpBackup']; 
            if($errorStatus == 135){
              echo $errorRePass; 
            }
           ?>
          </p>

          <div class=" ">
            <input class="form-control frm-lg phoneForgot" id="password" value="<?php echo $listValues['password']; ?>"
              placeholder="<?= lang('Label.lbl_newPassword') ?>" name="password" type="password">
            <span toggle="#password-field" class="fa fa-fw field-icon-eye toggle-password fa-eye"
              onclick="showPass('password')"></span>
          </div>
          <p class=" err_messages err_passwordForgot"><?php echo $getErrors['password']; ?></p>
          <div class=" ">
            <input class="form-control frm-lg" id="repassword" name="rePassword"
              value="<?php echo $listValues['rePassword']; ?>" placeholder="<?= lang('Label.lbl_newRePassword') ?>"
              type="password">
            <span toggle="#password-field" class="fa fa-fw field-icon-eye toggle-password fa-eye"
              onclick="showPass('repassword')"></span>
          </div>
          <p class=" err_messages err_repassword"><?php echo $getErrors['rePassword']; ?></p>
          <p class=" err_messages"><?php if($errorStatus != 135){
              echo $errorRePass; 
            } ?></p>
          <div class=" btn-login">
            <input type="submit" name="submit" id="submitRePass" value="<?= lang('Label.lbl_finish') ?>"
              class="btn form-control btn-primary" style="margin-bottom: 75px;">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>