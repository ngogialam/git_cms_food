$(document).ready(function() {
    // Ajax districts 
    $('#scanChangeStatusMultiManager').focus();
    $('#scanChangeStatusMultiManager').change(function(){
        countRow = $('#changeMultiStatusManager .countRow').length;
        setTimeout(function () {
            $('.btn-search-change-status').hide('');
        }, 500);
        $('.countResult').hide('');
        $('.countChangeResult').show('');
        $('.showCountList').html('');
        // showCountList
        // let total = $('.totalNumber').val();
        // console.log(total);
        let lastStatus = $('#lastStatus').val();
        let scanChangeStatusMultiManager = $('#scanChangeStatusMultiManager').val();
        if(scanChangeStatusMultiManager != ''){
            $.ajax({
                url: 'check-in-van-don-barcode-doi-trang-thai',
                type: 'post',
                dataType: 'json',
                data: {'assignShipperOrderId':scanChangeStatusMultiManager, 'lastStatus':lastStatus},
                success: function(res){
                    if(res.success){
                        let checkID = $("#changeMultiStatusManager").find("tr."+res.order_id);
                        if(checkID.length == 0){
                            if(countRow < 50){
                                $('#barcodeAppend').append(res.data);
                                
                                $('.showCountList').html(countRow + 1);
                            }else{
                                alert('Không thể thêm đơn, danh sách đã đạt số lượng giới hạn 50 đơn hàng.');
                            }
                            
                        }else{
                            alert('Mã vận đơn đã quét!');
                            $('.showCountList').html(countRow);
                        }
                        $('#scanChangeStatusMultiManager').val('');
                        $("#scanChangeStatusMultiManager").focus();
                    }else{
                        alert('Trạng thái đơn hàng không phù hợp')
                        $('#scanChangeStatusMultiManager').val('');
                        $("#scanChangeStatusMultiManager").focus();
                    }
                },
                error: function(){
                    // alert('Có lỗi khi lấy Phường. Mời bạn thử lại sau!');
                }
            });
        }else{
            alert('Mã vận đơn đã được quét');
        }
    });

    $('.change-status-multi-ok').click(function(){
        let ids = $('.ids').val();
        // console.log(ids);
        let lastStatus = $('#lastStatus').val();
        $('#loader').addClass('show');
        if(ids != ''){
            $('#confirm_change_status_multi').modal('hide');
            $.ajax({
                // url: '/thay-doi-trang-thai-hoan-thanh-cong',
                url: '/thay-doi-trang-thai-hoan-thanh-cong',
                type: 'post',
                dataType: 'json',
                data: {'ids':ids, 'lastStatus': lastStatus},
                success: function(data){
                    setTimeout(function () {
                        $('#loader').removeClass('show');
                         window.location.href = '/quan-ly-chuyen-trang-thai-hang-loat';
                    }, 500);
                },
                error: function(data){
                //     alert('Có lỗi khi thực hiện. Mời bạn thử lại sau!');
                    setTimeout(function () {
                        $('#loader').removeClass('show');
                         window.location.href = '/quan-ly-chuyen-trang-thai-hang-loat';
                    }, 600);
                }
            });
        }
    });
    $('body').on('change', '#lastStatus',function(){
        let lastStatus = $('#lastStatus').val();
        $('#lastStatusChoosen').val(lastStatus);
        $('.countResult').css("display", "none");
        $('.countChangeResult').css("display", "none");
        setTimeout(function () {
            $('#scanChangeStatusMultiManager').focus();
        }, 100);
        if(lastStatus == 0){
            $(".form-search").css("display", "none");
            $("#listOrderChange").html('');
            $("#barcodeAppend").html('');

        }else if(lastStatus == 1){
            $("#listOrderChange").html('');
            $("#barcodeAppend").html('');
            $(".form-search").css("display", "flex");
            $(".form-search-hoan").css("display", "flex");
            $(".form-search-giao").css("display", "none");
            $('.btn-search-change-status').show('');
        }else if(lastStatus == 2){
            $("#listOrderChange").html('');
            $("#barcodeAppend").html('');
            $(".form-search").css("display", "flex");
            $(".form-search-hoan").css("display", "none");
            $(".form-search-giao").css("display", "flex");
            $('.btn-search-change-status').show('');

        }

    });

    
    $('body').on('change', '.province_code_from', function() {
        var province = $('.province_code_from').find(':selected').val();
        // console.log(province)
        if (province.length == 0 || province == 0 ) {
            $('.err_province').html('Tỉnh/Thành Phố không được để trống.');
        } else {
            $('.err_province').html('');
        }
        $.ajax({
            url: '/vi/getDistrictsAjax',
            type: 'post',
            dataType: 'json',
            data: { 'province': province },
            success: function(res) {
                var district_find_pro = $('.district_find_pro').val();
                $('.district_code_from').html(res.data);
                $('.district_code_from').val(district_find_pro).trigger("chosen:updated");
                $('.district_code_from').trigger("change");
                $('.ward_code_from').html(res.html_ward);
                $('.ward_code_from').trigger("chosen:updated");
            },
            error: function(res) {
                $('.district_code_from').html(res.data);
                $('.district_code_from').trigger("chosen:updated");
                $('.ward_code_from').html(res.html_ward);
                $('.ward_code_from').trigger("chosen:updated");
                $('#loading_image').fadeOut(300);

            }
        });
    });

    //Ajax wards
    $('body').on('change', '.district_code_from', function() {
        var province = $('.province_code_from').find(':selected').val();
        var district = $('.district_code_from').find(':selected').val();
        if (district.length == 0) {
            $('.err_district').html('Quận/Huyện không được để trống.');
        } else {
            $('.err_district').html('');
        }
        $.ajax({
            url: '/vi/getWardsAjax',
            type: 'post',
            dataType: 'json',
            data: { 'province': province, 'district': district },
            success: function(res) {
                var wards_find_pro = $('.wards_find_pro').val();
                $('.ward_code_from').html(res.data);
                $('.ward_code_from').val(wards_find_pro).trigger("chosen:updated");
            },
            error: function(res) {
                $('.ward_code_from').html(res.data);
                $('.ward_code_from').trigger("chosen:updated");
                $('#loading_image').fadeOut(300);
            }
        });
    });

    //Ajax resend OTP Rút tiền
    $('body').on('click', '.reSendOtp', function() {
        var phoneOtp = $('.phoneOtp').val();
        var username = $('.userName').val();
        $(".err_phoneOtp").html('');
        $("#withDrawOtp").html('');
        $("#withDrawOtp").val('');
        // console.log(username);
        $.ajax({
            url: '/vi/reSendOtp',
            type: 'post',
            dataType: 'json',
            data: {
                'reSendOtp': '1',
                'phoneOtp': phoneOtp,
                'username': username
            },
            success: function(res) {
                if (res.success) {
                    count = 30;
                    $('.reSendOtp').prop("disabled", true);
                } else {
                    $(".err_phoneOtp").html(res.message);
                }
            },
            error: function() {
                $(".err_phoneOtp").html(res.message);
            }
        });
    });

    $('body').on('change', '#withDrawOtp', function() {
        var withDrawOtp = $('#withDrawOtp').val();
        if (withDrawOtp.length == 6) {
            $.ajax({
                url: '/vi/xac-nhan-otp',
                type: 'post',
                dataType: 'json',
                data: {
                    'withDrawOtp': withDrawOtp
                },
                success: function(res) {
                    if (res.success) {
                        window.location.href = res.href;
                    } else {
                        if (res.redirect == 1) {
                            window.location.href = res.href;
                        } else {
                            $(".err_phoneOtp").html(res.data);
                        }
                    }
                },
                error: function(res) {
                    $(".err_phoneOtp").html(res.data);
                }
            });
        }
    });

    $('body').on('change', '.ward_code_from', function() {
        $('.err_ward').html('');
    });

    $('body').on('click', '.active-va', function() {
        // var getUrl = window.location;
        // var baseUrl = getUrl .protocol + "//" + getUrl.host ;
        $.ajax({
            url: '/vi/nap-tien-vi-VA',
            type: 'post',
            dataType: 'json',
            data: { 'activeVa': '1' },
            success: function(res) {
                if (res.status == 200) {
                    // $('.firstVa').hide();
                    // $('.userBankName').html(res.data.userName);
                    // $('.bankName').html(res.data.bankName);
                    // $('.shopCode').html(res.data.shopCode);
                    // $(".bankImg").attr("src", baseUrl+'/public/images/Bank_Logos/'+res.data.bankName+'.png');
                    window.location.reload();
                } else {
                    $('.err_connectVA').html(res.data);
                }
            },
            error: function(res) {
                console.log(res);
            }
        });
    });


    //Ajax changeStatus WareHouse
    $('body').on('change', '.statusWareHouse', function() {
        var statusWareHouse = $('.statusWareHouse').find(':selected').val();
        if (statusWareHouse == 0) {
            window.location.href = "/danh-sach-kho-hang?status=0";
        } else {
            window.location.href = "/danh-sach-kho-hang?status=1";
        }
    });
    // Hover dropdown App
    $('.chosen-select').chosen();

    $(".dropdownapptest").hover(
        function() {
            $(".downloadapp").addClass('show');
        },
        function() {
            $(".downloadapp").removeClass('show');
        }
    );
    //Hover Home DropdownNoti
    $(".dropnoti").hover(
        function() {
            $(".notiMess").addClass('show');
        },
        function() {
            $(".notiMess").removeClass('show');
        }
    );

    // Change province Order
    $('body').on('change', '.order_province_code_from', function() {
        var province = $(this).find(':selected').val();
        var receiverProductIndex = $(this).attr('index_prov');
        // console.log(province)
        var reveiverDistrict = $('.district_find_pro_'+receiverProductIndex).val();
        var reveiverWards = $('.wards_find_pro_'+receiverProductIndex).val();
        $('.province_find_pro_'+receiverProductIndex).val(province);
        if (province.length == 0 || province == 0 ) {
            $('.err_province_'+receiverProductIndex).html('Tỉnh/Thành Phố không được để trống.');
        } else {
            $('.err_province_'+receiverProductIndex).html('');
        }
        $(this).parent().removeClass('address_error');
        $(this).parent().removeClass('address_success');
        $(this).parent().removeClass('address_warning');
        $(this).parent().addClass('address_edit');
        $.ajax({
            url: '/vi/getDistrictsAjax',
            type: 'post',
            dataType: 'json',
            data: { 'province': province },
            success: function(res) {
                $('#districtReceiver_'+receiverProductIndex).html(res.data);
                $('#districtReceiver_'+receiverProductIndex).val(reveiverDistrict).trigger("chosen:updated");
                $('#districtReceiver_'+receiverProductIndex).trigger("change");

                $('.wardReceiver_'+receiverProductIndex).val(0);
                $('.wardReceiver_'+receiverProductIndex).trigger("chosen:updated");
                if(reveiverWards != ''){
                    $('#districtReceiver_'+receiverProductIndex).trigger('change');
                    $('.wardReceiver_'+receiverProductIndex).val(0);
                }
            },
            error: function(res) {
                $('#districtReceiver_'+receiverProductIndex).val(0);
                $('#districtReceiver_'+receiverProductIndex).trigger("chosen:updated");
                $('.wardReceiver_'+receiverProductIndex).val(0);
                $('.wardReceiver_'+receiverProductIndex).trigger("chosen:updated");
                $('#loading_image').fadeOut(300);

            }
        });
    });
    // Change district Order
    $('body').on('change', '.order_district_code_from', function() {
        var receiverDistrictIndex = $(this).attr('index_dict');
        var reveiverProvince  = $('.province_find_pro_'+receiverDistrictIndex).val();
        var reveiverWards  = $('.wards_find_pro_'+receiverDistrictIndex).val();
        var reveiverDistrict  = $(this).find(':selected').val();
        if(reveiverDistrict == ''){
            var reveiverDistrict  = $('.district_find_pro_'+receiverDistrictIndex).val();
        }
        if (reveiverDistrict.length == 0 || reveiverDistrict == 0) {
            $('.err_district_'+receiverDistrictIndex).html('Quận/Huyện không được để trống.');
        } else {
            $('.err_district_'+receiverDistrictIndex).html('');
        }
        $(this).parent().removeClass('address_error');
        $(this).parent().removeClass('address_success');
        $(this).parent().removeClass('address_warning');
        $(this).parent().addClass('address_edit');
        $.ajax({
            url: '/vi/getWardsAjax',
            type: 'post',
            dataType: 'json',
            data: { 'province': reveiverProvince, 'district': reveiverDistrict },
            success: function(res) {
                $('#wardReceiver_'+receiverDistrictIndex).html(res.data);
                $('#wardReceiver_'+receiverDistrictIndex).val(reveiverWards).trigger("chosen:updated");
            },
            error: function(res) {
                $('.wardReceiver_'+receiverDistrictIndex).val(0);
                $('.wardReceiver_'+receiverDistrictIndex).trigger("chosen:updated");
                $('#loading_image').fadeOut(300);

            }
        });
    });
    // Change ward Order

    // $("#owl-demo").owlCarousel({
    //     rtl: true,
    //     loop: true,
    //     stagePadding: 10,
    //     margin: 48,
    //     autoplay: true,
    //     smartSpeed: 200,
    //     autoplaySpeed: 1500,
    //     autoplayHoverPause: true,
    //     nav: true,
    //     dots: false,
    //     responsive: {
    //         200: {
    //             items: 1
    //         },
    //         400: {
    //             items: 2
    //         },

    //         600: {
    //             items: 3
    //         },
    //         1000: {
    //             items: 6
    //         },
    //         1200: {
    //             items: 6
    //         }
    //     }
    // })

    //Config date
    // $('.datePicker').datetimepicker({
    //     timepicker: false,
    //     format: 'd/m/Y',
    //     maxDate: new Date()
    // });

    // $('.orderdatePicker').datetimepicker({
    //     timepicker: false,
    //     format: 'd/m/Y',
    //     minDate: new Date()
    // });

    // $('.orderTimePicker').datetimepicker({
    //     datepicker: false, 
    //     minuteStep: 15,
    //     format: 'H:m',
    //     autoclose: true,
    //     showMeridian: true,
    //     startView: 1,
    //     maxView: 1
    // });
});

function showInfo(deliveryPointIndex, receiverIndex){
    $('#info-donhang-'+deliveryPointIndex+'_'+receiverIndex).show();
    $('#iconDown_'+deliveryPointIndex+'_'+receiverIndex).hide();
    $('#iconUp_'+deliveryPointIndex+'_'+receiverIndex).show();
}
function hideInfo(deliveryPointIndex, receiverIndex){
    $('#info-donhang-'+deliveryPointIndex+'_'+receiverIndex).hide();
    $('#iconDown_'+deliveryPointIndex+'_'+receiverIndex).show();
    $('#iconUp_'+deliveryPointIndex+'_'+receiverIndex).hide();
}