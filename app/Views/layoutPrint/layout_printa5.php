<html>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
  <title>In đơn hàng khổ A5</title>
  <meta charset="utf-8" content="text/html" />
  <link rel="shortcut icon" href="<?php echo base_url(); ?>/favicon.ico" />
  <link href="<?php echo base_url('public/lib/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

  <script src="<?php echo base_url('public/lib/jquery/jquery.min.js'); ?>"></script>

  <style type="text/css">
  * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  body,
  p,
  span {
    font-family: "Arial" !important;
  }

  span {
    font-size: 15px;
  }

  p {
    margin-bottom: 0px;
  }

  #wrapper-print .container {
    max-width: 980px;
    padding: 0
  }

  .row.header-print {
    margin-top: 30px;
  }

  .header-print {
    margin: 15px 0;
  }

  .header-print img {
    max-width: 100%;
  }

  .header-print h3 {
    text-transform: uppercase;
    color: #333;
    font-size: 20px;
    text-align: center;
    margin-top: 7px;
  }

  .wrap-content-print {
    border-top: 2px #ccc dashed;
    padding: 10px 0;
    margin: 0;
  }

  .wrap-content-print .left-cont {
    border-right: 2px #ccc dashed;
  }

  p.money_cod {
    text-align: center;
    font-weight: bold;
    font-size: 20px;
  }

  .wrap-qc-pr {}

  .qr-code {
    text-align: center;
  }

  .qr-code img {
    width: 128px;
  }

  .logo_GTK img {
    width: 71px !important;
  }

  .content-print p {
    padding-left: 12px;
    font-size: 15px;
    line-height: 18px;
    margin-bottom: 4px;
  }

  .content-print p:last-child {
    margin-bottom: 0;
  }

  .btn-warning-custom {
    background-color: #ffc436;
    border: none;
    color: #333;
    text-transform: uppercase;
  }

  .btn-warning-custom:hover,
  .btn-warning-custom:focus {
    background-color: #e6a916;
    border: none;
    color: #333;
  }

  .logo_holaship {
    text-align: center;
  }

  .logo_nvc {
    text-align: center;
    margin: 10px 0;
  }

  .logo_nvc img {
    width: 130px;
  }

  .ng-order {
    margin: 10px 0;
    text-align: center;
  }

  .ng-order p {
    margin-bottom: 0;
  }

  .ng-order {
    margin: 10px 0;
  }

  p.ng-binding {
    word-wrap: break-word;
    font-weight: bold;
    font-size: 13px !important;
  }

  .ng-img-barcode {
    margin-bottom: 0;
    margin-top: 10px;
    text-align: center;
  }

  .des-text-print {
    font-size: 18px !important;
    font-weight: 600;
  }


  /*        @media print {
           .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                float: left;
           }
           .col-sm-12 {
                width: 100%;
           }
           .col-sm-11 {
                width: 91.66666667%;
           }
           .col-sm-10 {
                width: 83.33333333%;
           }
           .col-sm-9 {
                width: 75%;
           }
           .col-sm-8 {
                width: 66.66666667%;
           }
           .col-sm-7 {
                width: 58.33333333%;
           }
           .col-sm-6 {
                width: 50%;
           }
           .col-sm-5 {
                width: 41.66666667%;
           }
           .col-sm-4 {
                width: 33.33333333%;
           }
           .col-sm-3 {
                width: 25%;
           }
           .col-sm-2 {
                width: 16.66666667%;
           }
           .col-sm-1 {
                width: 8.33333333%;
           }
        }*/

  .wrap-print-order {
    margin-bottom: 30px;
  }

  .container.wrap-print-order {
    border: 1px solid #ccc;
  }

  .content-print h3 {
    font-size: 15px;
    font-weight: bold;
    margin-bottom: 0;
  }

  .wrap-tienthu h3 {
    float: left;
  }

  .content-print p span {
    font-weight: bold;
  }

  .number-order-print {
    margin: 0px 15px;
  }


  @media print {
    @page {
      size: a5 landscape;
      margin: 0;
      min-height: auto;
    }

    /*            html,
            body {
                border: 0px solid white;
            }
            .content {
                width: 794px;
                height: 540px;
                content: ".";
            }
            .info-hub {
                border-bottom: solid 1px #757575;
            }

            .content-print p{
                font-weight: bold;
                font-size: 15px;
            }*/
    /*            .barcode-img {
                width: 300px;
                height: 50px;
            }*/

    .no-print,
    .no-print * {
      display: none !important;
    }

    /*            .total-order-print{
                display: none;
            }*/
  }

  /*        @page {
          size: A5;
        }*/

  .barcode-img {
    /*width: 300px;*/
    height: 60px;
  }
  </style>
</head>

<body>
  <div id="wrapper-print">

    <?=view($view)?>

  </div>
</body>

</html>