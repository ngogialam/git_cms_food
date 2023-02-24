<!--==========================
  Login Section
============================-->
<section id="hero" class="d-flex align-items-center banner-login" style="background-image: url(<?php echo base_url('public/images/login/bannerlogin.png');?>); ">
  <div class="container" style="margin-bottom: 26px;margin-top: 26px;">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12 col-xs-8 ml-auto login-form">
        <div class="otp">
          <h4 class="lg-title" style="margin-top: 10px;text-transform:uppercase"><?= lang('Label.lbl_verifyOTP') ?></h4>
          <p><?= lang('Label.lbl_postNumberPhone') ?> </p>
          <p id="phoneOtp" style="color: #885DE5;"><?php echo $data['phone']; ?></p>
          <input type="hidden" value="<?php echo $data['username']; ?>" id="phone">
        </div>
        <div ng-app="exampleApp" ng-controller="appCtrl" style="width: 88%;margin: 0 auto;">
          <div otp-input-directive options="otpInput"></div>
          <div class="check-otp err_messages" style="margin-top: 10px;" id="otpFalse">
          </div>
        </div>
        <div class="send-otp">
          <p><?= lang('Label.lbl_sendtoOTP') ?></p>
          <b id="countdowntimer">30s</b>
        </div>
        <div class="form-group btn-login" style="font-size: 16px;background-color: #FFECC7;margin-bottom: 76px;">
          <input disabled type="submit" name="reSendOTP" id="reSendOTP" value="<?= lang('Label.lbl_recoverOTP') ?>"
            onclick="reSendOtp()" class="btn form-control" style="color: #F0A616;">
        </div>
      </div>
    </div>
  </div>
</section>

<script>
'use strict';
var app = angular.module('exampleApp', ["otpInputDirective"]);
app.controller('appCtrl', function($scope) {
  var phone = document.getElementById('phone').value;
  $scope.otpInput = {
    size: 6,
    type: "text",
    onDone: function(value) {
      // console.log(value);
      $.ajax({
        url: '/vi/xac-thuc-so-dien-thoai',
        type: 'post',
        dataType: 'json',
        data: {
          'otp': value,
          'phone': phone
        },
        success: function(res) {
          console.log(res)
          if (res.success) {
            console.log(res);
            window.location.href = "/thong-tin-tai-khoan";
          } else {
            console.log(res);
            // document.getElementById('otpFalse').style.display ="block";
            document.getElementById('otpFalse').innerHTML = res['data'];
          }
        },
        error: function(res) {
          console.log(res);
        }
      });
    },
  }
});
</script>