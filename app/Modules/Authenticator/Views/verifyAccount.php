<!--==========================
Login Section
============================-->
<section id="hero" class="d-flex align-items-center login banner-login"
  style="background-image: url(<?php echo base_url('public/images/login/bannerlogin.png');?>) ;">
  <div class="container" style="margin-top: 135px;margin-bottom: 135px;">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12 col-xs-8 ml-auto login-form">
        <h4 class="lg-title" style="padding-top: 41px;"><?= $data['title'] ?></h4>
        <p class="lg-sapo"><?= lang('Label.lbl_sapo_verifyAcc') ?></p>
        <form action="" id="form-search-user" method="POST" enctype="multipart/form-data">
          <div class="form-group form-login" style="margin-bottom: 29px;">
            <input class="form-control frm-lg" id="username" name="username" data-rule="minlen:4"
              data-msg="Please enter at least 4 chars" placeholder="<?= lang('Label.ph_phone') ?>" type="text"
              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
            <span class=" err_messages err_email"><?php echo $getErrors['username']; ?></span>
          </div>
          <div class="form-group btn-login" style="margin-bottom: 19px;">
            <input type="submit" name="submit" value="<?= lang('Label.btn_next') ?>"
              class="btn form-control btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>