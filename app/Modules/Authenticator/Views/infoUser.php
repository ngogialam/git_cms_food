<section id="connectbank">
  <section id="info-bn">
    <div class="link-user">
      <ul>
        <li>
          <img src="<?php echo base_url('public/images/Home.png');?>" alt="">
        </li>
        <li style="margin-top: 2px;">
          > Tài khoản > <span> <?= lang('Label.lbl_infoAccount') ?></span>
        </li>
      </ul>
    </div>
    <div class="info-banner"
      style="background-image: url('<?php echo base_url('public/images/Rectangle121.png');?>');    ">
      <ul>
        <li>
          <img src="public/images/Ava.png" alt="" style="width: 80px; height: 80px;">
          <a href=""><img src="public/images/iconCamera.png" alt="" style="margin-top: 55px;margin-left:-30px;"></a>
        </li>
      </ul>
    </div>
  </section>
  <section id="info-detail">
    <div class="info-detail-1" style="margin-left: 40px;">
      <ul>
        <li class="info-detail-2">
          <?= lang('Label.lbl_basicInformation') ?>
        </li>
        <li>
          <input type="text" class="form-control frm-lg" placeholder="Họ và Tên đầy đủ">
        </li>
        <li>
          <input type="text" class="form-control frm-lg" placeholder="Số điện thoại">
        </li>
        <li>
          <input type="text" class="form-control frm-lg" placeholder="Gmail">
        </li>
        <li>
          <input type="date" class="form-control frm-lg">
        </li>
        <li>
          <select name="" id="" class="form-control frm-lg info-detail-3">
            <option value="" class="form-control frm-lg info-detail-3">
              Giới tính
            </option>
            <option value=""> Nam</option>
            <option value="">
              Nữ
            </option>
          </select>
        </li>
        <li>
          <select name="" id="" class="form-control frm-lg info-detail-3">
            <option value="" class="form-control frm-lg info-detail-3">
              Chọn Quận/Huyện
            </option>
            <option value=""> Nam</option>
            <option value=""> Nữ </option>
          </select>
        </li>
        <li>
          <select name="" id="" class="form-control frm-lg info-detail-3">
            <option value="" class="form-control frm-lg info-detail-3">
              Chọn Tỉnh/Thành Phố
            </option>
            <option value=""> Nam</option>
            <option value=""> Nữ </option>
          </select>
        </li>
        <li>
          <input type="text" class="form-control frm-lg" placeholder="Thêm chi tiết">
        </li>
      </ul>
    </div>
    <div class="info-detail-1">
      <ul>
        <li class="info-detail-2">
          Thông tin căn cước/ CMND
        </li>
        <li>
          <input type="text" class="form-control frm-lg" placeholder="Số căn cước/ CMND">
        </li>
        <li>
          <input type="date" class="form-control frm-lg">
        </li>
        <li>
          <input type="text" class="form-control frm-lg" placeholder="Nơi cấp">
        </li>
        <li>
          <img src="<?php echo base_url('public/images/Warning.png');?>" alt="">
          <spa>Lưu ý</spa n>
          <p class="info-detail-4">
            Tài liệu phải hợp pháp và còn hiệu lực
          </p>
        </li>
        <li>
          <button type="text" class="form-control frm-lg info-button">Cập nhật thông tin</button>
        </li>


      </ul>
    </div>
  </section>

  <section>