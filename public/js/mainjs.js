var ids = [];
$(document).ready(function () {

    $('.checkCharacter').keydown(function (e) {
        var charCode = e.keyCode;
        if ((charCode >= 49 && charCode <= 56) || (charCode >= 96 && charCode <= 105) || charCode > 186 && charCode < 222 && charCode != 189) {
            e.preventDefault();
        }
    });


    $('.checkExistPhone').change(function () {
        var checkExistPhone = $('.checkExistPhone').val();

        $('#btn-add-user').attr('disabled', 'disabled');
        $.ajax({
            url: '/checkExistPhone',
            type: 'post',
            dataType: 'json',
            data: {
                'checkExistPhone': checkExistPhone
            },
            success: function (res) {
                if (res.success) {
                    $('.checkExistPhoneErr').html('');
                    $('#btn-add-user').removeAttr("disabled");
                } else {
                    $('.checkExistPhoneErr').html('Số điện thoại đã tồn tại');
                }
            },
            error: function (res) {
                console.log(12345)
            }
        });
    })

    
    $('.checkExistProductName').change(function () {
        var checkExistProductName = $('.checkExistProductName').val();
        $.ajax({
            url: '/checkExistProductName',
            type: 'post',
            dataType: 'json',
            data: {
                'checkExistProductName': checkExistProductName
            },
            success: function (res) {
                if (res.success) {
                    $('.productNameErr').html('');
                    $('#btn-add-user').removeAttr("disabled");
                } else {
                    $('.productNameErr').html('Tên sản phẩm đã tồn tại');
                }
            },
            error: function (res) {
                console.log(12345)
            }
        });
    })

    $(".barcodePrint75").focus();
    $('.weightProduct').blur(function () {
        weightProduct = $('.weightProduct').val();
        priceProduct = $('.priceProduct').val();
        $('.thanhTien').val(0);
        if (weightProduct == '') {
            $('.weightProductErr').html('Vui lòng nhập khối lượng')
        } else {

            if (priceProduct != '' || priceProduct != 0) {
                price = priceProduct * (weightProduct / 1000);
                $('.thanhTien').val(price);
            }
            $('.weightProductErr').html('')
        }
    })

    $('.priceProduct').blur(function () {
        priceProduct = $('.priceProduct').val();
        weightProduct = $('.weightProduct').val();
        $('.thanhTien').val(0);
        if (priceProduct == '') {
            $('.priceProductErr').html('Vui lòng nhập Giá tiền')
        } else {
            if (weightProduct != '' || weightProduct != 0) {
                price = priceProduct * (weightProduct / 1000);
            }
            $('.thanhTien').val(price);
            $('.priceProductErr').html('');
        }
    })

    $('.namePromotionOrder').blur(function () {
        namePromotionOrder = $('.namePromotionOrder').val();
        if (namePromotionOrder == '') {
            $('.errNamePromotionOrder').html('Tên khuyến mãi không được để trống')
        } else {

            $('.errNamePromotionOrder').html('')
        }
    })

    $('.conditionPromotionOrder').blur(function () {
        conditionPromotionOrder = $('.conditionPromotionOrder').val();
        if (conditionPromotionOrder == '') {
            $('.errConditionOrder ').html('Điều kiện áp dụng không được để trống')
        } else {

            $('.errConditionOrder ').html('')
        }
    })
    $('.discountValuePromotionOrder').blur(function () {
        discountValuePromotionOrder = $('.discountValuePromotionOrder').val();
        if (discountValuePromotionOrder == '') {
            $('.errDiscountValuePromotionOrder  ').html('Giá trị/đơn vị tính không được để trống')
        } else {

            $('.errDiscountValuePromotionOrder  ').html('')
        }
    })
    $('.startedPromotionOrder').blur(function () {
        startedPromotionOrder = $('.startedPromotionOrder').val();
        if (startedPromotionOrder == '') {
            $('.errStartedPromotionOrder  ').html('Ngày bắt đầu không được để trống')
        } else {

            $('.errStartedPromotionOrder  ').html('')
        }
    })
    $('.stopedPromotionOrder').blur(function () {
        stopedPromotionOrder = $('.stopedPromotionOrder').val();
        if (stopedPromotionOrder == '') {
            $('.errStopedPromotionOrder  ').html('Ngày kết thúc không được để trống')
        } else {

            $('.errStopedPromotionOrder  ').html('')
        }
    })

    $('#idBarCodeNew').change(function () {
        var idBarCodeNew = $('.idBarCodeNew').val();
        console.log(idBarCodeNew)
        if(idBarCodeNew != 0 && idBarCodeNew != ''){
            console.log(111)
            $.ajax({
                url: '/getDetailProduct',
                type: 'post',
                dataType: 'json',
                data: {
                    'idBarCodeNew': idBarCodeNew        
                },
                success: function (res) {
                    if (res.success) {
                        $('.productID').val(res.data.ID);
                        $('.productName').val(res.data.PRODUCT_NAME);
                        $('.areaProduct').val(res.data.AREA_PRODUCT);
                        $('.hsd').val(res.data.HAN_SU_DUNG);
                        $('.infoProduct').html(res.data.THONG_TIN_SAN_PHAM);
                        $('.hdsd').html(res.data.HUONG_DAN_SU_DUNG);
                        $('.baoQuan').html(res.data.BAO_QUAN);
                        $('.btnBarCodeNew').html('Sửa mẫu tem');
                    }
                },
                error: function (res) {}
            });
        }else{
            $('.productID').val('');
            $('.productName').val('');
            $('.areaProduct').val('');
            $('.hsd').val('');
            $('.infoProduct').html('');
            $('.hdsd').html('');
            $('.baoQuan').html('');
            $('.btnBarCodeNew').html('Tạo mẫu tem mới');
        }
    })
    

});

function appendPack(keyId) {
    $html = '';
    let checkID = $(".countAppendPack").length;
    let currentID = checkID + 1;
    console.log(keyId)
    $.ajax({
        url: '/appendPackProduct',
        type: 'post',
        dataType: 'json',
        data: {
            'checkID': checkID,
            'keyId': keyId,

        },
        success: function (res) {
            if (res.success) {
                // $('.btnAppend').text('Xóa quy cách');
                $('.btnAppend').html('');
                $('.btnAppend').html('<i class="mdi mdi-minus-circle"></i>');
                $('.btnAppend_' + keyId).attr('onclick', 'removeAppend(' + keyId + ')')
                $('.appendPack').append(res.html);
                $('.areaApply').chosen();
                $('.priceType').chosen();
            }
        },
        error: function (res) {}
    });
}

function removeAppend(evt) {
    $('.pack_' + evt).remove();
    // this1.parents().remove();
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode != 44 && charCode != 45) {
        return false;
    }
    return true;
}

function uploadImgJs(event, idName = '', classErr = '', classAppend = '', check = 0, appendOrNot = 1, classChange = '', valueNews = '', countImg = 'inputImgBs', set = 0) {
    console.log('set', set)
    var img = event.target.files[0];
    let allowedExtension = ['image/jpeg', 'image/jpg', 'image/png'];
    type = img.type;
    size = img.size;
    validate = 0;

    if (allowedExtension.indexOf(img.type) < 0) {
        validate = 1;
    } else if (size > 2097152) {
        validate = 2;
    }

    let checkID = $("." + countImg).length;
    if (validate == 0 && check == 0) {
        var myFormData = new FormData();
        myFormData.append('file', img);
        $.ajax({
            url: "/uploadImgs",
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: myFormData,
            type: 'post',
            success: function (res) {
                if (res.success) {
                    if (appendOrNot == 1) {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            if (set == 1) {
                                let countCHeck = $('.frontBsRegisImg').attr('count');
                                console.log(countCHeck)
                                $('.frontBsRegisImg').attr('count', (parseInt(countCHeck) + 1));
                                var html = '<div class="wrapImgAppend wrapImgAppend_' + checkID + '"> <span class="spanClose" onclick="removeImgAppend(' + checkID + ', 1)" >x</span> <img class="imgAppend inputImgBs_' + checkID + '" src="' + event.target.result + '" alt=""> <input type="hidden" class="inputImgBs inputImgValueBs_' + checkID + ' inputImgBs_' + checkID + '" value="' + res.data + '" name="inputImg[]"> </div>'
                            } else {
                                var html = '<div class="wrapImgAppend wrapImgAppend_' + checkID + '"> <span class="spanClose" onclick="removeImgAppend(' + checkID + ')" >x</span> <img class="imgAppend inputImgBs_' + checkID + '" src="' + event.target.result + '" alt=""> <input type="hidden" class="inputImgBs inputImgBs_' + checkID + '" value="' + res.data + '" name="inputImg[]"> </div>'
                            }
                            $('.checkImg').val(1)
                            $('.' + classAppend).append(html);
                        }
                        $()
                        reader.readAsDataURL(img);
                    } else {
                        var reader = new FileReader();
                        reader.onload = function (event) {

                            var html = '<input type="hidden" class="inputImgBs " value="' + res.data + '" name="imgThumbnail">';
                            $("#" + classChange).removeClass("w-100");
                            $("#" + classChange).width("150");
                            $("#" + classChange).attr("src", event.target.result);
                            $('.' + valueNews).val(res.data);
                        }
                        $()
                        reader.readAsDataURL(img);
                    }
                } else {
                    $('.' + classErr).html(res.data)
                }
            },
            error: function (res) {
                alert('Lỗi khi tải ảnh. Vui lòng liên hệ admin.')
            }
        });
    } else if (validate == 1) {
        $('.' + classErr).html('Chỉ cho phép chọn định dạng ảnh: jpg, jpeg, png.')
    } else if (validate == 2) {
        $('.' + classErr).html('Ảnh vượt quá dung lượng tối đa 2 MB.')
    }


}
function submitEditProduct(){
    var status = $('#status').val();
    if(status==1){
        $('#formEditProduct').submit();
    }else{
        $('#confirmDeleteRow').modal('show');
        $('.modal-body').html('<p>Inactive sản phẩm sẽ inactive các set liên quan chứa sản phẩm này.</p><p>Bạn chắc chắn muốn thay đổi trạng thái thành inactive không?</p>');
        $(".btnDeleteRow").attr("onclick", 'confirmSubmit()');
    }
}
function confirmSubmit(){
    $('#formEditProduct').submit();
}

function removeImgAppend(idAppend, set = 0) {
    $('.wrapImgAppend_' + idAppend).remove();
    if (set == 1) {
        let countCHeck = $('.frontBsRegisImg').attr('count');
        console.log(countCHeck)
        $('.frontBsRegisImg').attr('count', (parseInt(countCHeck) - 1));
    }
}
function confirmDisableProduct(idProduct){
    $('#confirmDeleteRow').modal('show');
    $('.modal-body').html('<p>Inactive sản phẩm sẽ inactive các set liên quan chứa sản phẩm này.</p><p>Bạn chắc chắn muốn thay đổi trạng thái thành inactive không?</p>');
    $(".btnDeleteRow").attr("onclick", 'disableProduct('+idProduct+')');
}
function disableProduct(idProduct) {
    $.ajax({
        url: '/san-pham/xoa-san-pham',
        type: 'post',
        dataType: 'json',
        data: {
            'idProduct': idProduct,
            'active': 0
        },
        success: function (res) {
            location.reload();
        },
        error: function () {

        }
    });
}

function disableSet(idProduct) {
    ids.push({
        'setId': idProduct,
        'status': 0
    })
    $.ajax({
        url: '/removeMultiSet',
        type: 'post',
        dataType: 'json',
        data: {
            'ids': ids,
            'active': 0
        },
        success: function (res) {
            location.reload();
        },
        error: function () {

        }
    });
}

function disableMethods(id, status) {
    $.ajax({
        url: '/phuong-thuc/xoa-phuong-thuc',
        type: 'post',
        dataType: 'json',
        data: {
            'id': id,
            'status': status
        },
        success: function (res) {
            console.log(res);
            location.reload();
        },
        error: function () {

        }
    });
}

function addMethods() {
    $('#addMethods').modal('show');
    $('.modal-title').html('Thêm phương thức');
    $('.saveMethods').html('Thêm phương thức');
    $(".saveMethods").attr("onclick", 'saveMethods()');
}

function saveMethods() {
    var methodType = $('.methodType').val();
    var methodName = $('.methodName').val();
    var statusMethods = $('.statusMethods').val();
    var isDefaultMethod = $('.isDefaultMethod').val();
    $.ajax({
        url: '/phuong-thuc/tao-phuong-thuc',
        type: 'post',
        dataType: 'json',
        data: {
            'methodType': methodType,
            'methodName': methodName,
            'status': statusMethods,
            'isDefaultMethod': isDefaultMethod,
        },
        success: function (res) {
            if (res.success) {
                location.reload();
            } else {
                console.log(res.data);
                $('.errMethodName').html(res.data.methodName);
                $('.errMethodType').html(res.data.methodType);
            }
        },
        error: function () {

        }
    });
}


function getMethods(id, url_img) {
    $('#addMethods').modal('show');
    $('.saveMethods').removeAttr("disabled");
    $.ajax({
        url: '/phuong-thuc/sua-phuong-thuc',
        type: 'post',
        dataType: 'json',
        data: {
            'id': id,
            'getData': 1
        },
        success: function (res) {
            if (res.success) {
                $('.modal-title').html('Sửa phương thức');
                $('.saveMethods').html('Sửa phương thức');
                $('.methodName').val(res.data.method);
                $('.methodType').html(res.htmlOptions);
                $('.methodType').trigger("chosen:updated");
                if (res.data.statusMethod == 1) {
                    $(".statusYes").attr("selected", 'selected');
                } else {
                    $(".statusYes").removeAttr("selected", 'selected');
                }
                $('.statusMethods').trigger("chosen:updated");
                if (res.data.isDefault == 1) {
                    $(".defaultYes").attr("selected", 'selected');
                } else {
                    $(".defaultYes").removeAttr("selected", 'selected');
                }
                $('.isDefaultMethod').trigger("chosen:updated");


                $(".saveMethods").attr("onclick", 'editMEthods(' + res.data.id + ')');
            } else {
                $('#addMethods').modal('hide');
            }
        },
        error: function () {

        }
    });
}

function editMEthods(idMethod) {
    var methodType = $('.methodType').val();
    var methodName = $('.methodName').val();
    var statusMethods = $('.statusMethods').val();
    var isDefaultMethod = $('.isDefaultMethod').val();
    $.ajax({
        url: '/phuong-thuc/sua-phuong-thuc',
        type: 'post',
        dataType: 'json',
        data: {
            'methodType': methodType,
            'methodName': methodName,
            'status': statusMethods,
            'isDefaultMethod': isDefaultMethod,
            'idMethod': idMethod,
            'getData': 0,
        },
        success: function (res) {
            if (res.success) {
                location.reload();
            } else {
                console.log(res.data);
                $('.errMethodName').html(res.data.methodName);
                $('.errMethodType').html(res.data.methodType);
            }
        },
        error: function () {

        }
    });
}

function disableRowMethodsAll() {
    var ids = '';
    var totalItem = $('.checkSingle:checked').length;
    $('.checkSingle:checked').each(function () {
        ids += $(this).val() + ',';
    });
    if (totalItem <= 0) {
        setTimeout(function () {
            alert('Bạn chưa chọn phương thức nào để xóa')
        }, 400);
    } else {
        ids = ids.slice(0, -1);
        console.log(ids);
        $('#confirmDeleteRow').modal('show');
        $('.modal-body').html('<p>Bạn có chắc xoá các danh mục đã chọn?</p>');
        $('.btnDeleteRow').attr('onclick', 'confirmDisableMethodsRow("' + ids + '", 0)');
        $('.btnDeleteRow').html('Xoá');
        $('.btnDeleteRow').removeClass('btn-success');
        $('.btnDeleteRow').addClass('btn-danger');
    }
}

function activeRowMethodsAll() {
    var ids = '';
    var totalItem = $('.checkSingle:checked').length;
    $('.checkSingle:checked').each(function () {
        ids += $(this).val() + ',';
    });
    if (totalItem <= 0) {
        setTimeout(function () {
            alert('Bạn chưa chọn phương thức nào để xóa')
        }, 400);
    } else {
        ids = ids.slice(0, -1);
        console.log(ids);
        $('#confirmDeleteRow').modal('show');
        $('.modal-body').html('<p>Bạn có muốn kích hoạt các danh mục đã chọn?</p>');
        $('.btnDeleteRow').attr('onclick', 'confirmDisableMethodsRow("' + ids + '", 1)');
        $('.btnDeleteRow').html('Kích hoạt');
        $('.btnDeleteRow').removeClass('btn-danger');
        $('.btnDeleteRow').addClass('btn-success');
    }
}

function confirmDisableMethodsRow(id, status) {
    $.ajax({
        url: '/phuong-thuc/xoa-phuong-thuc',
        type: 'post',
        dataType: 'json',
        data: {
            'id': id,
            'status': status
        },
        success: function (res) {
            console.log(res);
            location.reload();
        },
        error: function () {

        }
    });
}

$("#rePassword").keyup(function () {
    var password = $("#password").val();
    $(".err_repassword").html(password == $(this).val() ? "" : "Nhập lại mật khẩu không khớp");
});


function addReviews() {
    $('#addReviews').modal('show');
    $('.modal-title').html('Thêm đánh giá');
    $('.saveReviews').html('Thêm đánh giá');
    $(".saveReviews").attr("onclick", 'saveReviews()');
}

function saveReviews() {
    var product = $('.product').val();
    var comment = $('.comment').val();
    var statusReviews = $('.statusReviews').val();
    var imgReviews = $('.imgReviews').val();
    var isShow = $('.isShow').val();
    scoreReviews = $('input[name="scoreReviews"]:checked').val();

    $.ajax({
        url: '/danh-gia/tao-danh-gia',
        type: 'post',
        dataType: 'json',
        data: {
            'product': product,
            'comment': comment,
            'statusReviews': statusReviews,
            'imgReviews': imgReviews,
            'scoreReviews': scoreReviews,
            'isShow': isShow,
        },
        success: function (res) {
            if (res.success) {
                location.reload();
            } else {
                console.log(res.data);
                $('.errProduct').html(res.data.product);
                $('.errComment').html(res.data.comment);
                $('.errScore').html(res.data.scoreReviews);
            }
        },
        error: function () {

        }
    });
}



function editReviews(voteId) {
    var product = $('.product').val();
    var comment = $('.comment').val();
    var statusReviews = $('.statusReviews').val();
    var imgReviews = $('.imgReviews').val();
    var isShow = $('.isShow').val();
    var scoreReviews = $('input[name="scoreReviews"]:checked').val();
    $.ajax({
        url: '/danh-gia/sua-danh-gia',
        type: 'post',
        dataType: 'json',
        data: {
            'voteId': voteId,
            'product': product,
            'statusReviews': statusReviews,
            'scoreReviews': scoreReviews,
            'imgReviews': imgReviews,
            'isShow': isShow,
            'comment': comment,
            'getData': 0,
        },
        success: function (res) {
            if (res.success) {
                location.reload();
            } else {
                console.log(res.data);
                $('.errProduct').html(res.data.product);
                $('.errComment').html(res.data.comment);
                $('.errScore').html(res.data.scoreReviews);
            }
        },
        error: function () {

        }
    });
}


$('.modalCloseReload').on('hidden.bs.modal', function () {
    location.reload();
});


function submitOrder(orderId) {
    $('#loader').addClass('show');
    if (orderId != '') {
        $.ajax({
            url: '/don-hang/changeStatus',
            type: 'post',
            dataType: 'json',
            data: {
                'orderId': orderId,
            },
            success: function (res) {
                // console.log(res)
                window.location.href = res.href;
            },
            error: function () {
                $('#loader').remove('show');
            }
        });
    }
}

var typingTimer; //timer identifier
var doneTypingInterval = 500; //time in ms, 5 second for example
function number_format(className, type) {
    console.log(className)
    
    console.log($('.'+className).val())
    var numberFormat = '';
    if (type == 2) {
        numberFormat = parseInt($('.' + className).val().replace(/\./g, ''));
    } else {
        numberFormat = parseInt($('.' + className).val().replace(/\,/g, ''));
    }
    console.log(numberFormat)
    clearTimeout(typingTimer);
    if (numberFormat) {
        typingTimer = setTimeout(function () {
            if (type == 2) {
                numberFormat = String(numberFormat).replace(/(.)(?=(\d{3})+$)/g, '$1.');
            } else {
                numberFormat = String(numberFormat).replace(/(.)(?=(\d{3})+$)/g, '$1,');
            }
            if (numberFormat != 'NaN') {
                $('.' + className).val(numberFormat);
            }
        }, 500);
    }
}

function confirmPrepare(orderId, statusOrder) {
    let confirmOrder = new Array();
    var count = $('.totalItems').val();
    let i = 0;
    let arrPlus = new Array();
    var error = 0;
    do {
        Ư
        if ($('.weight_' + i).val()) {
            let item = new Array();
            item['weight'] = $('.weight_' + i).val();
            item['orderDetailId'] = $('.weight_' + i).data('orderdetailid');
            arrPlus[i] = Object.assign({}, item);
        } else {
            error = 1;
            if ($('.weight_' + i).val() == '') {
                $('.errWeight_' + i).html('Khối lượng thực tế không được để trống');
            }
        }
        i = i + 1;
    } while (i < count);
    sizeBox = $('.sizeBox').val();
    if (sizeBox == 0) {
        $('.errSizeBox').html('Kích thước box được để trống');
        error = 1;
    }
    confirmOrder['orderId'] = orderId;
    confirmOrder['sizeBox'] = sizeBox;
    confirmOrder['arrPlus'] = Object.assign({}, arrPlus);
    if (statusOrder != 100) {
        if (error == 0) {
            $('#loader').addClass('show');
            $.ajax({
                url: '/don-hang/confirmNetWeight',
                type: 'post',
                dataType: 'json',
                data: {
                    'confirmOrder': Object.assign({}, confirmOrder)
                },
                success: function (res) {
                    window.location = res.href;
                },
                error: function () {
                    $('#loader').removeClass('show');
                }
            });
        }
    } else {
        alert('Trạng thái đơn hàng không phù hợp');
    }

}

function changeDelivery(orderId) {

    $('#loader').addClass('show');
    $.ajax({
        url: '/don-hang/changeStatus',
        type: 'post',
        dataType: 'json',
        data: {
            'orderId': orderId
        },
        success: function (res) {
            window.location = res.href;
        },
        error: function () {

            $('#loader').removeClass('show');
        }
    });
}

function changeDeliveryAll(confirm = 0) {
    var ids = '';
    var totalItem = $('.checkSingle:checked').length;
    $('.checkSingle:checked').each(function () {
        ids += $(this).val() + ',';
    });
    if (totalItem <= 0) {
        setTimeout(function () {
            alert('Bạn chưa chọn danh mục nào để Chuyển cho đơn vị vận chuyển')
        }, 400);
    } else {
        ids = ids.slice(0, -1);
        $('#confirmChangeDelivery').modal('show');
        if (confirm == 1) {
            $('#loader').addClass('show');
            $.ajax({
                url: '/don-hang/changeStatus',
                type: 'post',
                dataType: 'json',
                data: {
                    'orderId': ids
                },
                success: function (res) {
                    location.reload();
                },
                error: function () {

                }
            });
        }
    }
}

function cancelOrder(orderID) {
    $('#confirmCancelOrder').modal('show');
    $('.confirmCalcelOrder').attr('onclick', 'confirmCalcelOrder("' + orderID + '", 0)');
}

function confirmCalcelOrder(orderID) {
    $.ajax({
        url: '/don-hang/cancelOrder',
        type: 'post',
        dataType: 'json',
        data: {
            'orderId': orderID
        },
        success: function (res) {

            window.location = res.href;
        },
        error: function () {

        }
    });
}

function addSetProduct() {
    $('#addSetProduct').modal('show');
    $('.modal-title').html('Thêm set sản phẩm');
    $('.saveSetProduct').html('Thêm set sản phẩm');
    $(".saveSetProduct").attr("onclick", 'saveSetProduct()');
}


function printDataOnly() {
    // $(".print_order").focus();
    var divToPrint = document.getElementById("printTable");
    newWin = window.open("");
    newWin.document.write(divToPrint.outerHTML);
    setTimeout(function () {
        newWin.print();
        newWin.close();
        $('#theModalPrint').modal('hide');
        $("LINK[href*='print75.css']").remove();

        // $(".barcodePrint75").focus();
    }, 200);
}

function barCodePrintOnly(orderId = '') {
    if (orderId == '') {
        orderId = $('#barCodePrintOnly').val();
    }
    if (orderId != '') {
        setTimeout(function () {
            $.ajax({
                url: '/trang-trai/in-tem-san-pham',
                type: 'post',
                dataType: 'json',
                data: {
                    'orderId': orderId
                },
                success: function (res) {
                    if (res.success) {
                        let timeout = 1500;
                        //send api print
                        $('#theModalPrint').modal('show').find('#printTable').load(res.printUrl);
                        $('.barcodePrint75').val('');
                        $('.barcodePrint75').focus();
                        setTimeout(function () {
                            printDataOnly();
                        }, timeout);
                    } else {
                        alert(res.message);
                        $('.barcodePrint75').val('');
                        $('.barcodePrint75').focus();
                    }
                },
                error: function (res) {
                    alert(res.message);
                    $('.barcodePrint75').val('');
                    $('.barcodePrint75').focus();
                }
            });
        }, 200);
    }
}

function activeRowProduct(productid) {
    $.ajax({
        url: '/san-pham/xoa-san-pham',
        type: 'post',
        dataType: 'json',
        data: {
            'idProduct': productid,
            'active': 1
        },
        success: function (res) {
            location.reload();
        },
        error: function (res) {
            console.log(12345)
        }
    });
}

function barcodeProduct() {
    console.log(11111)
    productName = $('.productName').val();
    areaProduct = $('.areaProduct').val();
    soLo = $('.soLo').val();
    baoQuan = $('.baoQuan').val();
    ndg = $('.ndg').val();
    bqcd = $('.bqcd').val();
    weight = $('.weight').val();
    price = $('.price').val();
    thanhTien = $('.thanhTien').val();
    unit = $('.unit').val();
    viTri = $('.viTri').val();
    ngt = $('.ngt').val();
    nth = $('.nth').val();
    setTimeout(function () {
        $.ajax({
            url: '/trang-trai/in-tem-san-pham-moi',
            type: 'post',
            dataType: 'json',
            data: {
                'productName': productName,
                'areaProduct': areaProduct,
                'soLo': soLo,
                'baoQuan': baoQuan,
                'ndg': ndg,
                'bqcd': bqcd,
                'weight': weight,
                'price': price,
                'thanhTien': thanhTien,
                'unit': unit,
                'viTri': viTri,
                'ngt': ngt,
                'nth': nth,
            },
            success: function (res) {
                if (res.success) {
                    let timeout = 1500;
                    $('#theModalPrint').modal('show').find('#printTable').load(res.printUrl);
                    $('.barcodePrint75').val('');
                    $('.barcodePrint75').focus();
                    setTimeout(function () {
                        printDataOnly();
                    }, timeout);
                } else {
                    alert(res.message);
                    $('.barcodePrint75').val('');
                    $('.barcodePrint75').focus();
                }
            },
            error: function (res) {
                alert(res.message);
                $('.barcodePrint75').val('');
                $('.barcodePrint75').focus();
            }
        });
    }, 200);

}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode != 44 && charCode != 45) {
        return false;
    }
    return true;
}

function addPromotionOrder() {
    $('#addPromotionOrder').modal('show');
    $('.promotionOrder').html('Thêm khuyến mãi đơn hàng');
    $('.savePromotionOrder').html('Thêm khuyến mãi đơn hàng');
    $(".savePromotionOrder").attr("onclick", 'savePromotionOrder(0)');
}

function savePromotionOrder(type = 0) {
    // type 0 => Tạo, 1=> sửa
    let promotionOrder = new Array();
    let error = 0;
    promotionOrder['typePromotionOrder'] = $('.typePromotionOrder').val();
    promotionOrder['measurePromotionOrder'] = $('.measurePromotionOrder').val();
    promotionOrder['namePromotionOrder'] = $('.namePromotionOrder').val();
    promotionOrder['conditionPromotionOrder'] = $('.conditionPromotionOrder').val();
    promotionOrder['discountValuePromotionOrder'] = $('.discountValuePromotionOrder').val();
    promotionOrder['discountMaxPromotionOrder'] = $('.discountMaxPromotionOrder').val();
    promotionOrder['startedPromotionOrder'] = $('.startedPromotionOrder').val();
    promotionOrder['stopedPromotionOrder'] = $('.stopedPromotionOrder').val();
    promotionOrder['statusPromotionOrder'] = $('.statusPromotionOrder').val();
    promotionOrder['promotionOrderId'] = $('.promotionOrderId').val();
    promotionOrder['type'] = type;
    if ($('.namePromotionOrder').val() == '') {
        $('.errNamePromotionOrder').html('Tên khuyến mãi không được để trống');
        error = 1;
    }
    if ($('.conditionPromotionOrder').val() == '') {
        $('.errConditionOrder').html('Điều kiện áp dụng không được để trống');
        error = 1;
    }
    if ($('.conditionPromotionOrder').val() == '') {
        $('.errDiscountValuePromotionOrder').html('Giá trị/đơn vị tính không được để trống');
        error = 1;
    }

    if ($('.startedPromotionOrder').val() == '') {
        $('.errStartedPromotionOrder').html('Ngày bắt đầu không được để trống');
        error = 1;
    }
    if ($('.stopedPromotionOrder').val() == '') {
        $('.errStopedPromotionOrder').html('Ngày kết thúc không được để trống');
        error = 1;
    }

    if (error == 0) {
        $.ajax({
            url: '/khuyen-mai/tao-khuyen-mai-don-hang',
            type: 'post',
            dataType: 'json',
            data: {
                'promotion': Object.assign({}, promotionOrder)
            },
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    $('.errProducts').html(res.data.productId);
                    $('.errNamePromotion').html(res.data.namePromotion);
                    $('.errCondition').html(res.data.condition);
                    $('.errStarted').html(res.data.started);
                    $('.errStoped').html(res.data.stoped);
                }
            },
            error: function () {

            }
        });
    }
}

function editRowPromotionOrder(promotionID) {
    $('.savePromotion').removeAttr("disabled");
    $.ajax({
        url: '/khuyen-mai/lay-thong-tin-khuyen-mai',
        type: 'post',
        dataType: 'json',
        data: {
            'promotionID': promotionID,
            'getData': 1
        },
        success: function (res) {
            $('.promotionOrder').html('Sửa khuyến mãi đơn hàng');
            $('.savePromotionOrder').html('Sửa khuyến mãi đơn hàng');
            $(".savePromotionOrder").attr("onclick", 'savePromotionOrder(1)');
            $('#typePromotionOrder').attr('disabled', true);
            $('#measurePromotionOrder').attr('disabled', true);
            $('#namePromotionOrder').attr('disabled', true);
            $('#conditionPromotionOrder').attr('disabled', true);
            $('#discountValuePromotionOrder').attr('disabled', true);
            $('#discountMaxPromotionOrder').attr('disabled', true);
            $('#statusPromotionOrder').attr('disabled', true);

            $('#typePromotionOrder').val(res.data.typePromotion).trigger("chosen:updated");
            $('#measurePromotionOrder').val(res.data.measurePromotion).trigger("chosen:updated");
            $('#namePromotionOrder').val(res.data.namePromotion);
            $('#conditionPromotionOrder').val(res.data.conditionPromotion);
            $('#discountValuePromotionOrder').val(res.data.discountValue);
            $('#discountMaxPromotionOrder').val(res.data.discountMax);
            $('#startedPromotionOrder').val(res.data.STARTED);
            $('#stopedPromotionOrder').val(res.data.STOPPED);
            $('#promotionOrderId').val(promotionID);
            $('#statusPromotionOrder').val(res.data.statusPromotion).trigger("chosen:updated");
            $('#addPromotionOrder').modal('show');

        },
        error: function () {

        }
    });
}


function exportExcelItemsScale() {
    $('#loader').addClass('show');
    var status = $('#status').val();
    $.ajax({
        url: '/exportExcelItemsScale',
        type: 'post',
        dataType: 'json',
        data: {
            'status' : status,
            'exportExcel': 1
        },
        success: function (data) {
            $('#loader').removeClass('show');
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", data.fileNameExcel);
            $a[0].click();
            $a.remove();
            window.location.href = data.href;
            $('#excelDeliverBarCodeTransfer').fadeOut();
            $('#tranferBarcode').show();
            setTimeout(function () {
                $('#loader').removeClass('show');
            }, 500);
        },
    })
}

function offProductMulti(type = 0) {
    var ids = '';
    var totalItem = $('.checkSingle:checked').length;
    $('.checkSingle:checked').each(function () {
        ids += $(this).val() + ',';
    });
    if (totalItem <= 0) {
        setTimeout(function () {
            alert('Bạn chưa chọn sản phẩm nào để ẩn')
        }, 400);
    } else {
        ids = ids.slice(0, -1);
        $('#confirmDeleteRow').modal('show');
        if (type == 0) {
            $('.confirmBody').html('<p>Bạn có chắc xoá các sản phẩm đã chọn?</p>');
            $('.btnDeleteRow').attr('onclick', 'confirmOffProductMulti("' + ids + '", "' + type + '")');
            $('.btnDeleteRow').html('Xoá');
            $('.btnDeleteRow').removeClass('btn-success');
            $('.btnDeleteRow').addClass('btn-danger');
        } else {
            $('.confirmBody').html('<p>Bạn có chắc muốn mở các sản phẩm đã chọn?</p>');
            $('.btnDeleteRow').attr('onclick', 'confirmOffProductMulti("' + ids + '", "' + type + '")');
            $('.btnDeleteRow').html('Mở');
            $('.btnDeleteRow').removeClass('btn-danger');
            $('.btnDeleteRow').addClass('btn-success');
        }
    }
}

function offProductMultiSet(type) {
  
    var totalItem = $('.checkSingle:checked').length;
    $('.checkSingle:checked').each(function () {
        ids.push({
            'setId': $(this).val(),
            'status': type
        })
    });
    if (totalItem <= 0) {
        setTimeout(function () {
            alert('Bạn chưa chọn sản phẩm nào để ẩn')
        }, 400);
    } else {
        $('#confirmDeleteRow').modal('show'); 
        if (type == 0) {
            $('.confirmBody').html('<p>Bạn có chắc ẩn các set đã chọn?</p>');
            $('.btnDeleteRow').attr('onclick', 'confirmOffProductMultiSet()');
            $('.btnDeleteRow').html('Xoá');
            $('.btnDeleteRow').removeClass('btn-success');
            $('.btnDeleteRow').addClass('btn-danger');
        } else {
            $('.confirmBody').html('<p>Bạn có chắc muốn hiển thị các set đã chọn?</p>');
            $('.btnDeleteRow').attr('onclick', 'confirmOffProductMultiSet()');
            $('.btnDeleteRow').html('Mở');
            $('.btnDeleteRow').removeClass('btn-danger');
            $('.btnDeleteRow').addClass('btn-success');
        }
    }
}

function confirmOffProductMulti(ids, type) {
    $('#loader').addClass('show');
    $.ajax({
        url: '/removeMultiProducts',
        type: 'post',
        dataType: 'json',
        data: {
            'ids': ids,
            'type': type
        },
        success: function (res) {
            location.reload();
        },
        error: function () {
            $('#loader').removeClass('show');

        }
    });
}

function confirmOffProductMultiSet() {
    console.log(ids);
    $('#loader').addClass('show');
    $.ajax({
        url: '/removeMultiSet',
        type: 'post',
        dataType: 'json',
        data: {
            'ids': ids
        },
        success: function (res) {
            location.reload();
        },
        error: function () {
            $('#loader').removeClass('show');

        }
    });
}

function checkExistMenu() {
    var nameMenus = $('.nameMenus').val();
    console.log(nameMenus);
    $('.btnAddMenu').attr('disabled', 'disabled');
    $.ajax({
        url: '/checkExistMenu',
        type: 'post',
        dataType: 'json',
        data: {
            'nameMenus': nameMenus
        },
        success: function (res) {
            if (res.success) {
                $('.errNameMenus').html('');
                $('.btnAddMenu').removeAttr("disabled");
            } else {
                $('.errNameMenus').html('Tên menu đã tồn tại');
            }
        },
        error: function (res) {
            console.log(12345)
        }
    });
}

function checkExistCate() {
    var nameCate = $('.nameCate').val();
    $('.saveCate').attr('disabled', 'disabled');
    $.ajax({
        url: '/checkExistCate',
        type: 'post',
        dataType: 'json',
        data: {
            'nameCate': nameCate
        },
        success: function (res) {
            if (res.success) {
                $('.errNameCate').html('');
                $('.saveCate').removeAttr("disabled");
            } else {
                $('.errNameCate').html('Tên danh mục đã tồn tại');
            }
        },
        error: function (res) {
            console.log(12345)
        }
    });
}

function checkExistBanner() {
    var nameBanners = $('.nameBanners').val();
    $('.saveBanners').attr('disabled', 'disabled');
    $.ajax({
        url: '/checkExistBanner',
        type: 'post',
        dataType: 'json',
        data: {
            'nameBanners': nameBanners
        },
        success: function (res) {
            if (res.success) {
                $('.errNameBanners').html('');
                $('.saveBanners').removeAttr("disabled");
            } else {
                $('.errNameBanners').html('Tên banner đã tồn tại');
            }
        },
        error: function (res) {
            console.log(12345)
        }
    });
}

function checkExistMethod() {
    var methodName = $('.methodName').val();
    $('.saveMethods').attr('disabled', 'disabled');
    $.ajax({
        url: '/checkExistMethod',
        type: 'post',
        dataType: 'json',
        data: {
            'methodName': methodName
        },
        success: function (res) {
            if (res.success) {
                $('.errMethodName').html('');
                $('.saveMethods').removeAttr("disabled");
            } else {
                $('.errMethodName').html('Tên phương thức đã tồn tại');
            }
        },
        error: function (res) {
            console.log(12345)
        }
    });
}

function checkExistPromotion(type = 1, className) {
    // namePromotionSet
    var namePromotion = $('.' + className).val();
    $('.savePromotion').attr('disabled', 'disabled');
    $.ajax({
        url: '/checkExistPromotion',
        type: 'post',
        dataType: 'json',
        data: {
            'namePromotion': namePromotion,
            'type': type
        },
        success: function (res) {
            if (res.success) {
                $('.errNamePromotion').html('');
                $('.errNamePromotionSet').html('');
                if (className == 'namePromotionSet') {
                    $('.saveSetPromotion').removeAttr("disabled");
                } else {
                    $('.savePromotion').removeAttr("disabled");
                }
            } else {
                if (className == 'namePromotionSet') {
                    $('.errNamePromotionSet').html('Tên khuyến mại đã tồn tại');
                } else {
                    $('.errNamePromotion').html('Tên khuyến mại đã tồn tại');
                }
            }
        },
        error: function (res) {
            console.log(12345)
        }
    });
}

function modalPopupImage(className) {
    var src = $('.' + className).attr("src");
    $("#imageDetail").attr("src", src);
    $('#modalPopupImage').modal('show')
}

function getIdBarcodeNew(){
    var idBarCodeNew = $('.idBarCodeNew').val();
    var urlBarCodeNew = $('.idBarCodeNew').find(':selected').attr('data-url');
    console.log(urlBarCodeNew)
    if(idBarCodeNew != 0 || idBarCodeNew !=''){
        $('#theModalPrint').modal('show').find('#printTable').load(urlBarCodeNew);
        setTimeout(function () {
            printDataOnly();
        }, 500);
    }
}

function changeStatusDishOrder(typeDish){
    // typeDish
    // 1: Xác nhận
    // 2: Hủy đơn
    // 3: Cbi hàng xong
    // 4: Giao cho shipper

    var ids = '';
    var totalItem = $('.checkSingle:checked').length;
    console.log(totalItem)
    $('.checkSingle:checked').each(function () {
        ids += $(this).val() + ',';
    });
    var messageConfirm = '';
    var removeClassButton = 'btn-danger';

    if (totalItem <= 0) {
        setTimeout(function () {
            alert('Bạn chưa chọn đơn nào để thay đổi trạng thái.')
        }, 400);
    } else {
        if(typeDish == 100){
            if(totalItem > 1 ){
                setTimeout(function () {
                    alert('Chỉ cho phép xác nhận cho từng đơn hàng.')
                }, 400);
                return false;
            }
            messageConfirm = '<p>Bạn có chắc chắn xác nhận các danh mục đã chọn?</p>';
            classButton = 'btn-success';
        }else if(typeDish == 107){
            if(totalItem > 1 ){
                setTimeout(function () {
                    alert('Chỉ cho phép hủy đơn cho từng đơn hàng.')
                }, 400);
                return false;
            }
            messageConfirm = '<p>Bạn có chắc chắn hủy các danh mục đã chọn?</p>';
            classButton = 'btn-danger';
            removeClassButton = 'btn-success';
        }else {
            messageConfirm = '<p>Bạn có chắc chắn muốn chuyển trạng thái các danh mục đã chọn?</p>';
            classButton = 'btn-success';
        }
        ids = ids.slice(0, -1);
        $('#modalDish').modal('show');
        $('.modal-body').html(messageConfirm);
        $('.btnDeleteRow').attr('onclick', 'confirmChangeStatus("' + ids + '", '+typeDish+')');
        $('.btnDeleteRow').html('Đồng ý');
        $('.btnDeleteRow').removeClass(removeClassButton);
        $('.btnDeleteRow').addClass(classButton);
    }
}

function confirmChangeStatus(ids,typeDish){   
    $('#modalDish').modal('hide');
    $.ajax({
        url: '/changeStatusDishOrder',
        type: 'post',
        dataType: 'json',
        data: {
            'ids': ids,
            'typeDish': typeDish
        },
        success: function (res) {
            location.reload();
        },
        error: function (res) {
            console.log(12345)
        }
    });
}

function getDetailDish(idDish, url_img){
    if(idDish != '' && idDish != 0){
        $.ajax({
            url: '/getDetailDish',
            type: 'post',
            dataType: 'json',
            data: {
                'idDish': idDish
            },
            success: function (res) {
                console.log(res)
                if(res.success){
                    $('#modalAddMenuFood').modal('show');
                    $('.nameDish').val(res.data.name);
                    $('.stock').val(res.data.stock);
                    $('.originalPrice').val(String(res.data.originalPrice).replace(/(.)(?=(\d{3})+$)/g, "$1,"));
                    $('.sellingPrice').val(String(res.data.sellingPrice).replace(/(.)(?=(\d{3})+$)/g, "$1,"));
                    $('.position').val(res.data.position);
                    contentNews.setData(res.data.content);
                    $(".statusOnWeb").val(res.data.status).trigger("chosen:updated");
                    $(".restaurantId").val(res.data.restaurantId).trigger("chosen:updated");
                    var imageArr = res.data.imageDish;
                    if (imageArr.length > 0) {
                        $("#dishThumbnailImg").attr("src", url_img + res.data.imageThumbnail);
                        $("#imgThumbnail").val(res.data.imageThumbnail);
                        $("#dishThumbnailImg").width("150");
                    } else {
                        $("#dishThumbnailImg").attr("src", "/public/images_kho/btn-add-img.svg");
                        $("#dishThumbnailImg").width("70");
                    }
                    $(".frontBsRegisImg").attr("count", res.countImg);
                    $('.appendImgProduct ').append(res.htmlImg);
                    $('.btnAddMenu').attr('onclick', 'editDish(' + idDish + ')')
                    $('.btnAddMenu').html('Sửa món ăn')

                }else{
                    // location.reload();    
                }
            },
            error: function (res) {
                // location.reload();
            }
        });
    }
}
function editDish(idDish){
    nameDish = $("#nameDish").val().trim();
    statusOnWeb = $("#statusOnWeb").val();
    stock = $("#stock").val().trim();
    originalPrice = $("#originalPrice").val();
    sellingPrice = $("#sellingPrice").val();
    position = $("#position").val();
    imgThumbnail = $("#imgThumbnail").val();
    restaurantId = $("#restaurantId").val();
    sellingPrice = sellingPrice.replace(/\,/g, "");
    originalPrice = originalPrice.replace(/\,/g, "");
    
    dataContentNews = contentNews.getData();

    let checkDataCallApi = 0
    if (nameDish == '') {
        $('.errNameDish').html('Vui lòng nhập tên món ăn')
        checkDataCallApi = 1
    } else {
        $('.errNameDish').html('')

    }
    if (stock == '') {
        $('.errStock').html('Vui lòng nhập số lượng món ăn')
        checkDataCallApi = 1
    } else {
        $('.errStock').html('')

    }

    if (originalPrice == '') {
        $('.errOriginalPrice').html('Vui lòng nhập giá gốc')
        checkDataCallApi = 1
    } else {
        $('.errOriginalPrice').html('')

    }

    if (sellingPrice == '') {
        $('.errSellingPrice').html('Vui lòng nhập giá bán')
        checkDataCallApi = 1
    } else {
        $('.errSellingPrice').html('')

    }

    // if (position == '') {
    //     $('.errPosition').html('Vui lòng nhập số thứ tự')
    //     checkDataCallApi = 1
    // } else {
    //     $('.errPosition').html('')

    // }

    if (stock == '') {
        $('.errStock').html('Vui lòng nhập số lượng món ăn')
        checkDataCallApi = 1
    } else {
        $('.errStock').html('')

    }

    if (statusOnWeb == -1) {
        $('.errStatusOnWeb').html('Vui lòng chọn trạng thái món ăn')
        checkDataCallApi = 1
    } else {
        $('.errStatusOnWeb').html('')

    }

    if (dataContentNews == '') {
        $('.errContentDish').html('Vui lòng thêm mô tả món ăn')
        checkDataCallApi = 1
    } else {
        $('.errContentDish').html('')

    }

    if (imgThumbnail == '') {
        $('.errNewsThumbnailImg').html('Vui lòng thêm ảnh thumb')
        checkDataCallApi = 1
    } else {
        $('.errNewsThumbnailImg').html('')

    }
    if(parseInt(originalPrice) < parseInt(sellingPrice) ){
        $(".errSellingPrice").html("Giá bán phải nhỏ hơn hoặc bằng giá gốc");
        checkDataCallApi = 1;
      } else {
        $(".errSellingPrice").html("");
      }
    
    if (restaurantId == 0) {
        $('.errRestaurantId').html('Vui lòng chọn nhà hàng')
        checkDataCallApi = 1
    } else {
        $('.errRestaurantId').html('')

    }

    var ek = $('.inputImgBs').map((_, el) => el.value).get()
    if (ek.length === 1) {
        $('.errImagesDish').html('Vui lòng thêm ảnh món ăn')
        checkDataCallApi = 1
    } else {
        $('.errImagesDish').html('')
    }
    var countCHeck = $(".frontBsRegisImg").attr("count");
    var imgValues = '';
    for (var i = 1; i<= countCHeck; i++){
        console.log(i)
      imgValues += $('.inputImgValueBs_'+i).val()+'|';
    }
    imgJson = imgValues.slice(0, -1);
    console.log('checkDataCallApi',checkDataCallApi)
    //checkDataCallApi =1;
    if(checkDataCallApi == 0){
        $('#loader').addClass('show');
        $.ajax({
            url: '/editDish',
            type: 'post',
            dataType: 'json',
            data: {
                'idDish': idDish,
                'name': nameDish,
                'status': statusOnWeb,
                'originalPrice': originalPrice,
                'sellingPrice': sellingPrice,
                'stock': stock,
                'position': position,
                'thumbnailImage': imgThumbnail,
                'imageDish': imgJson,
                'contentDish': dataContentNews,
                "isBestSelling": 1,
                "isFavorite": 1,
                "restaurantId": restaurantId,
            },
            success: function (res) {
                if(res.success){
                    location.reload();
                }else{
                    console.log(res.status)
                    if(res.status == 208){
                        $('#loader').removeClass('show');
                        $('.errNameDish').html(res.message)
                        $('.errNameDish').focus();
                    }
                }
            },
            error: function () {
                location.reload();

            }
        });
    }

}

function confirmChangeStatusDish(statusChange,typeStatus = 1, idDish = ''){
    // typeStatus = 0: nút đóng k cần tích
    var ids = '';
    var totalItem = $('.checkSingle:checked').length;
    if(typeStatus == 1){
        $('.checkSingle:checked').each(function () {
            ids += $(this).val() + ',';
        });
    }else{
        ids = idDish;
        totalItem = 1;
    }
    
    var messageConfirm = '';
    var removeClassButton = 'btn-danger';

    if (totalItem <= 0) {
        setTimeout(function () {
            alert('Bạn chưa chọn món nào để thay đổi trạng thái.')
        }, 400);
    } else {
        if(statusChange == 2){
            messageConfirm = '<p>Bạn có chắc chắn mở bán các danh mục đã chọn?</p>';
            classButton = 'btn-success';
        }else if(statusChange == 1){
            messageConfirm = '<p>Bạn có chắc chắn đóng bán các danh mục đã chọn?</p>';
            classButton = 'btn-danger';
            removeClassButton = 'btn-success';
        }else if(statusChange == 0){
            messageConfirm = '<p>Bạn có chắc chắn thay đổi trạng thái không hoạt động cho các danh mục đã chọn?</p>';
            classButton = 'btn-danger';
            removeClassButton = 'btn-success';
        }else{
            messageConfirm = '<p>Bạn có chắc chắn thay đổi trạng thái hoạt động cho các danh mục đã chọn?</p>';
            classButton = 'btn-success';
        }
        if(typeStatus == 1){
            ids = ids.slice(0, -1);
        }
        $('#modalDish').modal('show');
        $('.modal-body').html(messageConfirm);
        $('.btnDeleteRow').attr('onclick', 'changeStatusDish("' + ids + '", '+statusChange+')');
        $('.btnDeleteRow').html('Đồng ý');
        $('.btnDeleteRow').removeClass(removeClassButton);
        $('.btnDeleteRow').addClass(classButton);
    }
}
function changeStatusDish(ids,statusChange){
    $.ajax({
        url: '/changeStatusDish',
        type: 'post',
        dataType: 'json',
        data: {
            'ids': ids,
            'statusChange': statusChange
        },
        success: function (res) {
            location.reload();
        },
        error: function (res) {
            location.reload();
        }
    });
}

function exportExcelListOrders(){
    var nameDish = $("#nameDish").val().trim();
    var statusOrder = $(".status").val();
    var restaurantId = $(".restaurantId").val();
    var partnerId = $(".partnerId").val();
    var started = $(".started").val();
    var stoped = $(".stoped").val();
    $.ajax({
        url: '/exportExcelListOrders',
        type: 'post',
        dataType: 'json',
        data: {
            'nameDish':nameDish,
            'restaurantId':restaurantId,
            'statusOrder':statusOrder,
            'partnerId':partnerId,
            'started':started,
            'stoped':stoped,
        }
    }).done(function(data){
        var $a = $("<a>");
            $a.attr("href",data.file);
            $("body").append($a);
            $a.attr("download",data.name);
            $a[0].click();
            $a.remove();
        setTimeout(function () {
            $('#loader').removeClass('show');
        }, 1000);
    });
}
function changeStockDish(idDish){
    var stockDish = $('.stockDish-'+idDish).val();
    if(idDish != '' && stockDish != '' ){
        $.ajax({
            url: '/changeStockDish',
            type: 'post',
            dataType: 'json',
            data: {
                'idDish': idDish,
                'stockDish': stockDish
            },
            success: function (res) {
                location.reload();
            },
            error: function (res) {
                location.reload();
            }
        });
    }
}