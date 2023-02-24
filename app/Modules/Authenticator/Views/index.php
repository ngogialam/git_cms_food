<!-- ================An Tú DEV=============== -->
<div class="element">
  <ul>
    <li>
      <img src="<?php echo base_url('public/images/Union2.png')?>" alt="">
    </li>
    <li>
      <img src="<?php echo base_url('public/images/Vector11.png')?>" alt="">
    </li>
    <li>
      <img src="<?php echo base_url('public/images/bx_bxs-phone-call.png')?>" alt="">
    </li>
  </ul>
</div>

<section id="hero" class="index-banner">
  <div class="hero-container">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active" style="background-image: url(<?php echo base_url('public/images/BG.png')?>);">
        </div>
        <div class="carousel-item" style="background-image: url(<?php echo base_url('public/images/BG.png')?>);"></div>
      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon ri-arrow-left-line" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon ri-arrow-right-line" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>
  </div>
</section>
<!-- End Hero -->

<section id="hm-body">
  <div class="container hm-utp">
    <div class="row">
      <div class="col-12">
        <p>ƯỚC TÍNH PHÍ</p>
      </div>
      <div class="col-md-4 col-12 hm-sl-1">
        <ul class="list-styled p-2 m-0" style="background: #F8F8F8;border-radius: 5px;">
          <span>Điểm lấy hàng</span>
          <br>
          <input list="tinh" placeholder="<?= lang('Label.lbl_chooseProvince') ?>">
          <datalist id="tinh">
            <option value="Internet Explorer">
            <option value="Firefox">
            <option value="Chrome">
            <option value="Opera">
            <option value="Safari">
          </datalist>

          <select class="chosen-select mt-2">
            <option value=""><?= lang('Label.lbl_chooseDistrict') ?></option>
            <option value="Internet Explorer">
            <option value="Chrome">
            <option value="Opera">
            <option value="Safari">
          </select>
        </ul>

      </div>
      <div class="col-md-4 col-12 hm-sl-1">
        <ul class="list-styled p-2 m-0" style="background: #F8F8F8;border-radius: 5px;">
          <span>Điểm nhận hàng</span>
          <br>
          <input list="tinh" placeholder="<?= lang('Label.lbl_chooseProvince') ?>">
          <datalist id="tinh">
            <option value="Internet Explorer">
            <option value="Firefox">
            <option value="Chrome">
            <option value="Opera">
            <option value="Safari">
          </datalist>

          <input list="quan" placeholder="<?= lang('Label.lbl_chooseDistrict') ?>" style="margin-top: 8px;">
          <datalist id="quan">
            <option value="Internet Explorer">
            <option value="Chrome">
            <option value="Opera">
            <option value="Safari">
          </datalist>
        </ul>
      </div>
      <div class="col-md-4 col-12 hm-sl-1 pb-1">
        <ul class="list-styled  m-0 pt-2 pl-2 pr-2" style="background: #F8F8F8;border-radius: 5px;">
          <span>Trọng lượng</span>
          <br>
          <div class="form-group pb-2">
            <input class="form-control frm-lg" id="password" placeholder="Trọng lượng" type="password">
            <span class="field-icon-eye hm-tl">Gram</span>
            <button>Tra cứu chi phí</button>
          </div>
        </ul>
      </div>
    </div>
  </div>

  <!-- ============Tin tức khuyến mãi================ -->
  <div class="hm-tt-km">
    <div class="container hm-menu-sv">
      <div class="row">
        <div class="col-md-4">
          <ul>
            <li class="hm-icon-menu">
              <div>
                <img src="<?php echo base_url('public/images/emojione_closed-book.png')?>" alt="">
              </div>
            </li>
            <li>
              Bảng giá
            </li>
          </ul>
          <ul>
            <li class="hm-icon-menu">
              <div>
                <img src="<?php echo base_url('public/images/Group24.png')?>" alt="">
              </div>
            </li>
            <li>
              Đơn hàng
            </li>
          </ul>
          <ul>
            <li class="hm-icon-menu">
              <div>
                <img src="<?php echo base_url('public/images/wallet11.png')?>" alt="">
              </div>
            </li>
            <li>
              Ví tiền
            </li>
          </ul>
        </div>
        <div class="col-md-4">
          <ul>
            <li class="hm-icon-menu">
              <div>
                <img src="<?php echo base_url('public/images/Location.png')?>" alt="">
              </div>
            </li>
            <li>
              Hành trình
            </li>
          </ul>
          <ul>
            <li class="hm-icon-menu">
              <div>
                <img src="<?php echo base_url('public/images/delivery-man1.png')?>" alt="">
              </div>
            </li>
            <li>
              Đang giao
            </li>
          </ul>
          <ul>
            <li class="hm-icon-menu">
              <div>
                <img src="<?php echo base_url('public/images/Mobile.png')?>" alt="">
              </div>
            </li>
            <li>
              Thẻ Mobie
            </li>
          </ul>
        </div>
        <div class="col-md-4">
          <ul>
            <li class="hm-icon-menu">
              <div>
                <img src="<?php echo base_url('public/images/Data.png')?>" alt="">
              </div>
            </li>
            <li>
              Thẻ Data
            </li>
          </ul>
          <ul>
            <li class="hm-icon-menu">
              <div>
                <img src="<?php echo base_url('public/images/Game.png')?>" alt="">
              </div>
            </li>
            <li>
              Thẻ Game
            </li>
          </ul>
          <ul>
            <li class="hm-icon-menu">
              <div>
                <img src="<?php echo base_url('public/images/Bill.png')?>" alt="">
              </div>
            </li>
            <li>
              Hóa đơn
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 hm-title">
          <p>TIN TỨC - KHUYẾN MÃI</p>
        </div>
        <div class="col-md-4 hm-tt-mn">
          <div>
            <img src="<?php echo base_url('public/images/13.png')?>" alt="">
            <a href="">
              <ul>
                <li class="hm-tt-mn1">
                  Tiêu đề bài viết Tin tức - Khuyến mại
                </li>
                <li class="hm-tt-mn2">
                  <img src="<?php echo base_url('public/images/ei_clock.png')?>" alt="">02/04/2021
                </li>
                <li class="hm-tt-mn3">
                  Tóm tắt nội dung bài viết
                </li>

                <li class="hm-tt-mn4">
                  <p><a href="">Xem thêm>></a></p>
                </li>
              </ul>
            </a>
          </div>
        </div>
        <div class="col-md-4 hm-tt-mn">
          <div>
            <img src="<?php echo base_url('public/images/3.png')?>" alt="">
            <a href="">
              <ul>
                <li class="hm-tt-mn1">
                  Tiêu đề bài viết Tin tức - Khuyến mại
                </li>
                <li class="hm-tt-mn2">
                  <img src="<?php echo base_url('public/images/ei_clock.png')?>" alt="">02/04/2021
                </li>
                <li class="hm-tt-mn3">
                  Tóm tắt nội dung bài viết
                </li>

                <li class="hm-tt-mn4">
                  <p><a href="">Xem thêm>></a></p>
                </li>
              </ul>
            </a>
          </div>
        </div>
        <div class="col-md-4 hm-tt-mn">
          <div>
            <img src="<?php echo base_url('public/images/2.png')?>" alt="">
            <a href="">
              <ul>
                <li class="hm-tt-mn1">
                  Tiêu đề bài viết Tin tức - Khuyến mại
                </li>
                <li class="hm-tt-mn2">
                  <img src="<?php echo base_url('public/images/ei_clock.png')?>" alt="">02/04/2021
                </li>
                <li class="hm-tt-mn3">
                  Tóm tắt nội dung bài viết
                </li>
                <li class="hm-tt-mn4">
                  <p><a href="">Xem thêm>></a></p>
                </li>
              </ul>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container hm-vsc">
    <div class="row">
      <div class="col-md-4 img-left">
        <img src="<?php echo base_url('public/images/Group25.png')?>" alt="" class="hm-svc-img1">
        <img src="<?php echo base_url('public/images/Rectangle51.png')?>" alt="" class="hm-svc-img2">
        <img src="<?php echo base_url('public/images/Rectangle5.png')?>" alt="" class="hm-svc-img3">
      </div>
      <div class="col-md-8 hm-vsc-2">
        <ul>
          <li class="hm-vsc-1" style="margin-left: 40px;">
            <p>VÌ SAO CHỌN HOLASHIP</p>
          </li>
        </ul>
        <section id="services" class="services  section-bg">
          <div class="icon-box why1">
            <img class="srim1" src="<?= base_url('public/images/why_1.png'); ?>" alt="">
            <h4 class="services-active srti1">Nhận COD ngay lập tức</h4>
            <p>Ngay khi bưu tá xác nhận giao hàng thành công, tiền sẽ NGAY LẬP TỨC nổi trong tài khoản Holaship
              của shop. Shop có thể bấm rút tiền về tài khoản ngân hàng NGAY LẬP TỨC 24/7.</p>
            <span class="line"></span>
          </div>
          <div class="icon-box why2">
            <img class="srim2" src="<?= base_url('public/images/why_2.png'); ?>" alt="">
            <h4 class="srti2">Đền bù 100% không cần VAT</h4>
            <p>Đối với các đơn hàng giao qua J&T và GHTK có giá trị dưới 3 triệu. Đền bù 100% không cần hóa đơn nếu
              shop mua bảo hiểm hàng hóa (miễn phí bảo hiểm với hàng hóa giá trị dưới 1 triệu).</p>
            <span class="line"></span>
          </div>

          <div class="icon-box why3">
            <img class="srim3" src="<?= base_url('public/images/why_3.png'); ?>" alt="">
            <h4 class="srti3">Hỗ trợ - chăm sóc riêng 24/7</h4>
            <p>Có nhân viên chăm sóc, hỗ trợ xử lý đơn riêng cho từng Khách hàng. Đối với KH có lượng đơn
              từ 200 đơn/ ngày, hỗ trợ nhân viên đóng gói hàng hóa, lên đơn.</p>
          </div>
        </section>
      </div>
    </div>

  </div>
  <!-- <div class="hm-tt-km">
        <div class="container">
            <div class="row">
                <div class="col-md-12 hm-title">
                    <p>QUY TRÌNH GIAO NHẬN</p>
                </div>
                <div class="col-md-12">
                
                </div>
            </div>
        </div>
    </div> -->

  <div class="section-bg wrap-qt-gn-seccion">
    <div class="container">
      <div class="row justify-content-center text-center">
        <div class="header-service">
          <h2 class="section-title-underline">
            <span>Quy trình giao nhận</span>
          </h2>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="wrap-qt-gn">
            <ul class="list-qt-gn">
              <li class="qt-dkdn">
                <div class="img-qt-gn">
                  <span class="qt-line"></span>
                  <img src="<?php echo base_url('public/images/dkdn.png'); ?>" alt="Đăng ký / Đăng nhập"
                    class="img-fluid">
                  <div class="text-qt-gn">Đăng ký / Đăng nhập</div>
                </div>
              </li>
              <li class="qt-taodon line-bottom-item">
                <div class="img-qt-gn">
                  <img src="<?php echo base_url('public/images/td.png'); ?>" alt="Tạo đơn" class="img-fluid">
                  <div class="text-qt-gn">Tạo đơn</div>
                </div>
              </li>
              <li class="qt-cnvc">
                <div class="img-qt-gn">
                  <img src="<?php echo base_url('public/images/vc.png'); ?>" alt="Chọn nhà vận chuyển"
                    class="img-fluid">
                  <div class="text-qt-gn">Chọn nhà vận chuyển</div>
                </div>
              </li>
              <li class="qt-layhang line-bottom-item">
                <div class="img-qt-gn">
                  <img src="<?php echo base_url('public/images/lh.png'); ?>" alt="Lấy hàng" class="img-fluid">
                  <div class="text-qt-gn">Lấy hàng</div>
                </div>
              </li>
              <li class="qt-giaohang">
                <div class="img-qt-gn">
                  <img src="<?php echo base_url('public/images/gh.png'); ?>" alt="Giao hàng" class="img-fluid">
                  <div class="text-qt-gn">Giao hàng</div>
                </div>
              </li>
              <li class="qt-tdht line-bottom-item">
                <div class="img-qt-gn">
                  <img src="<?php echo base_url('public/images/ht.png'); ?>" alt="Theo dõi hành trình"
                    class="img-fluid">
                  <div class="text-qt-gn">Theo dõi hành trình</div>
                </div>
              </li>
              <li class="qt-ruttien">
                <div class="img-qt-gn">
                  <img src="<?php echo base_url('public/images/rt.png'); ?>" alt="Rút tiền" class="img-fluid">
                  <div class="text-qt-gn">Rút tiền</div>
                </div>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div style="width: 100%;">
    <img src="<?php echo base_url('public/images/Rectangle12.png')?>" alt="" style="width: 100%;">
  </div>
  <div class="hm-tt-km" style="padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12 hm-title">
          <p>ĐỐI TÁC CỦA HOLASHIP</p>
        </div>
        <div class="col-md-12">
          <div id="owl-partners-introduce2" class="owl-carousel owl-theme wow" data-wow-delay="0.6s">
            <div class="hm-bgr">
              <img src="<?php echo base_url('public/images/bidv.png')?>" alt="">
            </div>
            <div class="hm-bgr">
              <img src="<?php echo base_url('public/images/sacombank.png')?>" alt="">
            </div>
            <div class="hm-bgr">
              <img src="<?php echo base_url('public/images/jtexpress.png')?>" alt="">
            </div>
            <div class="hm-bgr">
              <img src="<?php echo base_url('public/images/giaohangtietkiem.png')?>" alt="">
            </div>
            <div class="hm-bgr">
              <img src="<?php echo base_url('public/images/giaohangnhanh.png')?>" alt="">
            </div>
            <div class="hm-bgr">
              <img src="<?php echo base_url('public/images/viettelpost.png')?>" alt="">
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.container-fliud.d-md-flex.footer-copy {
  position: inherit;
}
</style>