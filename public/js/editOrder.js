$(document).ready(function () {
    //Get District by province sender

    $('body').on('change', '.sender_province_code', function () {
        var province = $('.sender_province_code').find(':selected').val();
        $.ajax({
            url: '/ajaxGetDistrictByProvince',
            type: 'post',
            dataType: 'json',
            data: {
                'province': province
            },
            success: function (res) {
                if (res.success) {
                    $('.sender_district_code').html(res.data);
                    $('.sender_district_code').trigger("chosen:updated");
                    $('.sender_ward_code').html('<option value="0"> Chọn Phường/ Xã</option>');
                    $('.sender_ward_code').trigger("chosen:updated");
                } else {
                    alert(res.message);
                }
            },
            error: function () {
                alert('Lấy thông tin Quận thất bại.');
                $('#loading_image').fadeOut(300);
            }
        });
    })

    //Get Ward by district sender
    $('body').on('change', '.sender_district_code', function () {
        var district = $('.sender_district_code').find(':selected').val();
        $.ajax({
            url: '/ajaxGetWardsByDistrict',
            type: 'post',
            dataType: 'json',
            data: {
                'district': district
            },
            success: function (res) {
                if (res.success) {
                    $('.sender_ward_code').html(res.data);
                    $('.sender_ward_code').trigger("chosen:updated");
                } else {
                    alert(res.message);
                }
            },
            error: function () {
                alert('Lấy thông tin Phường/xã thất bại.');
                $('#loading_image').fadeOut(300);
            }
        });
    })

    $("#searchProduct").on('click', function (event) {
        $.ajax({
            url: '/don-hang/searchProduct',
            type: 'post',
            dataType: 'json',
            data: {
                'key': ''
            },
            success: function (res) {
                $("#all-select-product-add-new").html(res.html)
            },
            error: function () {}
        });
    })

    $('body').on('change', '.productNamePlus', function () {
        var productId = $(this).val();
        var key = $(this).attr('key');
        if (productId == 0) {
            $('.weightProductModal-' + key).html('<option value="0"> Chọn cách đóng gói </option>');
            $('.weightProductModal-' + key).trigger("chosen:updated");
        } else {
            $.ajax({
                url: '/don-hang/getWeightProduct',
                type: 'post',
                dataType: 'json',
                data: {
                    'productId': productId,
                    'key': key,
                },
                success: function (res) {
                    if (res.success) {
                        $('.weightProductModal-' + key).html(res.html);
                        $('.weightProductModal-' + key).trigger("chosen:updated");
                        setTimeout(function () {
                            getPriceProduct(key)
                        }, 300);
                    } else {

                    }
                },
                error: function () {

                }
            });
        }
    });
    $('.modal-body').on('change', '.weightProductModal ', function () {
        var price = $(this).find(":selected").attr('keyprice');
        var keyProduct = $(this).find(":selected").attr('key');
        var quantityProduct = $('.quantityProduct-' + keyProduct).val();
        var weight = $(this).find(":selected").val();
        var totalMoney = parseInt(quantityProduct) * parseInt(price);
        $('.weightId-' + keyProduct).val(weight);
        $('.cashProduct-' + keyProduct).val(String(totalMoney).replace(/(.)(?=(\d{3})+$)/g, '$1,'))

    });
    $('.modal-body').on('change', '.quantityProduct ', function () {
        var keyProduct = $(this).attr('key');
        var quantityProduct = $('.quantityProduct-' + keyProduct).val();
        // $('.quantity-'+keyProduct).val(quantityProduct);
        var price = $('.weightProductModal-' + keyProduct).find(":selected").attr('keyprice');
        var totalMoney = parseInt(quantityProduct) * parseInt(price);
        $('.cashProduct-' + keyProduct).val(String(totalMoney).replace(/(.)(?=(\d{3})+$)/g, '$1,'))
    });

    $(".addNewProductItems").on('click', function () {
        var keyProduct = $('.keyProduct').val();
        var keyTotal = $('.totalAllProducts').val();
        let i = 0;
        let arrPlus = new Array();
        var error = 0;
        let newProducts = new Array();
        do {
            if ($('.productNamePlus-' + i).val() != 0 && typeof $('.productNamePlus-' + i).val() != 'undefined') {
                let item = new Array();
                var checkClass = 0;
                var productNamePlus = $('.productNamePlus-' + i).find(":selected").val();
                var weightProduct = $('.weightProductModal-' + i).find(":selected").val();
                var quantityProduct = $('.quantityProduct-' + i).val();
                var duplicateProduct = 0;
                var checkClass = $('.productMainId-' + $('.productNamePlus-' + i).find(":selected").val() + '-' + $('.weightProductModal-' + i).find(":selected").val());
                if (checkClass.length > 0) {
                    keyProductMain = $('.productMainId-' + $('.productNamePlus-' + i).find(":selected").val() + '-' + $('.weightProductModal-' + i).find(":selected").val()).attr('keyMain');
                    var quantityProductOld = $('.quantityId-' + keyProductMain).val();
                    duplicateProduct = 1;
                    quantityProduct = parseInt(quantityProduct) + parseInt(quantityProductOld);
                }

                item['productNamePlus'] = productNamePlus;
                item['weightProduct'] = weightProduct;
                item['quantityProduct'] = quantityProduct;
                item['duplicateProduct'] = duplicateProduct;
                arrPlus[i] = Object.assign({}, item);
            } else if (typeof $('.productNamePlus-' + i).val() != 'undefined') {
                error = 1;
                if ($('.productNamePlus-' + i).val() == '' || $('.productNamePlus-' + i).val() == 0) {
                    $('.errProductNamePlus-' + i).html('Sản phẩm tặng kèm không được để trống');
                }
                if ($('.weightProductModal-' + i).val() == '' || $('.weightProductModal-' + i).val() == null || $('.weightProductModal-' + i).val() == 0) {
                    $('.errweightProductModal-' + i).html('Quy cách đóng gói không được để trống');
                }
                if ($('.quantityProduct-' + i).val() == '' || $('.quantityProduct-' + i).val() == null) {
                    $('.errQuantityProduct-' + i).html('Số lượng không được để trống');
                }
            }
            i = i + 1;
        } while (i < keyProduct);

        if (arrPlus.length > 0) {

            newProducts['arrPlus'] = Object.assign({}, arrPlus);
            newProducts['keyProduct'] = keyProduct;
            orderId = $('.orderId').val();
            newProducts['keyTotal'] = keyTotal;
            newProducts['orderCode'] = orderId;
            if (error == 0) {
                $.ajax({
                    url: '/don-hang/addNewProductToOrder',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'newProducts': Object.assign({}, newProducts)
                    },
                    success: function (res) {
                        if (res.success) {
                            var dataRemove = res.dataRemove;
                            $.each(dataRemove, function (key, value) {
                                $('.productMainId-' + value.keyRemove).remove();
                            });

                            var promotionRemove = res.promotionRemove;
                            $.each(promotionRemove, function (key, value) {
                                $('.promotion-' + value.keyRemove).remove();
                            });
                            setTimeout(function () {
                                $('.appendNewProductTable').append(res.html);
                                $('.weightProduct').chosen();
                                $('#addProductToOrder').modal('hide')
                                $('.totalAllProducts').val(parseInt(res.totalProduct) + 1);
                                orderId = $('.orderId').val();
                                editOrder(orderId, 1)
                            }, 300);

                        } else {
                            location.reload();
                        }
                    },
                    error: function () {

                    }
                });
            }
        } else {
            $('#addProductToOrder').modal('hide');
        }
    });

    $(document).on('change', '.weightProduct ', function () {
        var keyProduct = $(this).attr('key');
        var productName = $('.productName-' + keyProduct).val();
        var productId = $('.productId-' + keyProduct).val();
        var oldPriceId = $('.priceId-' + keyProduct).val();

        var quantityId = $('.quantityId-' + keyProduct).val();
        orderStatus = $('.orderStatus').val();
        var checkSet = $('.checkSet-' + keyProduct).val();
        $('.priceId-' + keyProduct).val(priceId);
        orderId = $('.orderId').val();
        if (checkSet == 0) {

            var priceId = $('.weightProduct-' + keyProduct).find(":selected").val();
            $('.priceId-' + keyProduct).val(priceId).trigger('update');
            priceChoose = getPriceChange(productId, priceId);
            $('.priceWeight-' + keyProduct).html(String(priceChoose.price).replace(/(.)(?=(\d{3})+$)/g, '$1,') + ' đ/ ' + priceChoose.weight + ' ' + priceChoose.unit);
            $('.price-' + keyProduct).html(String(priceChoose.price * quantityId).replace(/(.)(?=(\d{3})+$)/g, '$1,'));
        } else {
            var priceId = $('.priceIdSet-' + keyProduct).val();
            setPrice = $('.setPrice-' + keyProduct).val();
            $('.price-' + keyProduct).html(String(setPrice * quantityId).replace(/(.)(?=(\d{3})+$)/g, '$1,'));
            console.log(setPrice)
        }
        // console.log(productName, productId, priceId, oldPriceId, quantityId, orderStatus,orderId)
        getPromotion(productName, productId, priceId, oldPriceId, quantityId, orderStatus);
        editOrder(orderId, 1)
    })
    $(document).on('change', '.quantity', function () {
        var keyProduct = $(this).attr('key');
        var productName = $('.productName-' + keyProduct).val();
        var productId = $('.productId-' + keyProduct).val();
        var oldPriceId = $('.priceId-' + keyProduct).val();
        orderStatus = $('.orderStatus').val();
        var quantityId = $('.quantity-' + keyProduct).val();
        var checkSet = $('.checkSet-' + keyProduct).val();
        console.log(1111)
        $('.quantityId-' + keyProduct).val(quantityId);
        if (checkSet == 0) {
            var priceId = $('.weightProduct-' + keyProduct).find(":selected").val();
            priceChoose = getPriceChange(productId, priceId);
            $('.price-' + keyProduct).html(String(priceChoose.price * quantityId).replace(/(.)(?=(\d{3})+$)/g, '$1,'));
        } else {
            var priceId = $('.priceIdSet-' + keyProduct).val();
            setPrice = $('.setPrice-' + keyProduct).val();
            $('.price-' + keyProduct).html(String(setPrice * quantityId).replace(/(.)(?=(\d{3})+$)/g, '$1,'));
        }
        getPromotion(productName, productId, priceId, oldPriceId, quantityId, orderStatus);
        orderId = $('.orderId').val();
        editOrder(orderId, 1)
    })
});

function getPriceChange(productId, priceId) {
    var keyIndex = arrProduct.findIndex(element => {
        if (element.id == productId) {
            return true;
        }
        return false;
    });
    priceWeight = arrProduct[keyIndex].prices;
    var keyPrice = priceWeight.findIndex(element => {
        if (element.id == priceId) {
            return true;
        }
        return false;
    });
    priceChoose = priceWeight[keyPrice];
    return priceChoose;
}

function addProductToOrder() {
    $('#addProductToOrder').modal('show');
    var keyProduct = $('.keyProduct').val();
    // product
    let i = 0;
    do {
        $('.product-' + i).remove();
        i = i + 1;
    } while (i < keyProduct);
    $('.namePromotionOrder').val('')
    setTimeout(function () {
        $('.keyProduct').val(0);
    }, 300);
}

function removeProduct(key) {
    $('.productId-' + key).remove();
    var ar = key.split('-');
    $('.promotion-' + ar[0]).remove();
    $('.promotion-' + key).remove();
    orderId = $('.orderId').val();
    editOrder(orderId, 1);
}

function getPromotion(productName, productId, priceId, oldPriceId, quantityId, orderStatus) {
    console.log(priceId)
    var keyTotal = $('.totalAllProducts').val();
    orderId = $('.orderId').val();
    $.ajax({
        url: '/don-hang/getPromotion',
        type: 'post',
        dataType: 'json',
        data: {
            'productName': productName,
            'productId': productId,
            'priceId': priceId,
            'quantityId': quantityId,
            'keyTotal': keyTotal,
            'oldPriceId': oldPriceId,
            'orderStatus': orderStatus,
            'orderId': orderId
        },
        success: function (res) {
            if (res.success) {
                $('.promotion-' + res.removePromotion).remove();
                $('.productMainId-' + res.productId).after(res.html);
            } else {

            }
        },
        error: function () {}
    })
}

function editOrder(orderCode, type = 0) {

    var keyProduct = $('.keyProduct').val();
    var keyTotal = $('.totalAllProducts').val();
    let i = 0;
    let arrPlus = new Array();
    var error = 0;
    let newProducts = new Array();
    do {
        if ($('.productNamePlus-' + i).val() != 0) {
            let item = new Array();
            var productName = $('.productName-' + i).val();
            var productID = $('.productId-' + i).val();
            var priceId = $('.priceId-' + i).val();
            var quantityId = $('.quantityId-' + i).val();

            item['priceId'] = priceId;
            item['productID'] = productID;
            item['productName'] = productName;
            item['quantity'] = quantityId;
            console.log(item)
            console.log(i)
            arrPlus[i] = Object.assign({}, item);
        }
        i = i + 1;
    } while (i < keyTotal);

    newProducts['arrPlus'] = Object.assign({}, arrPlus);
    newProducts['orderCode'] = orderCode;
    if (error == 0) {
        if (type == 1) {
            $.ajax({
                url: '/getNewPrice',
                type: 'post',
                dataType: 'json',
                data: {
                    'newProducts': Object.assign({}, newProducts)
                },
                success: function (res) {
                    console.log(res)
                    if (res.success) {
                        $('.totalMoney').html(res.value);
                        $('.totalPayment').html(res.total);
                        $('.totalFee').html(res.deliveryFee);
                        $('.promotionFee').html(res.promotionFee);
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
                error: function () {

                }
            });
        } else {
            console.log(1111)
            $('#loader').addClass('show');
            $.ajax({
                url: '/don-hang/updateOrder',
                type: 'post',
                dataType: 'json',
                data: {
                    'newProducts': Object.assign({}, newProducts)
                },
                success: function (res) {
                    location.reload();
                    // if(res.success){
                    // }else{
                    location.reload();
                    // }
                },
                error: function () {

                }
            });
        }
    } else {

        $('#loader').removeClass('show');
    }

}

function getPriceProduct(key) {
    var keyProduct = $('.weightProductModal-' + key).find(":selected").attr('key');
    var quantityProduct = $('.quantityProduct-' + keyProduct).val();
    var weight = $('.weightProductModal-' + key).find(":selected").val();
    var product = $('.productNamePlus-' + key).find(":selected").val();
    var price = $('.weightProductModal-' + key).find(":selected").attr('keyprice');
    var totalMoney = parseInt(quantityProduct) * parseInt(price);

    // $('.productId-'+keyProduct).val(product);
    // $('.weightId-'+keyProduct).val(weight);
    // $('.quantity-'+keyProduct).val(quantityProduct);

    $('.cashProduct-' + keyProduct).val(String(totalMoney).replace(/(.)(?=(\d{3})+$)/g, '$1,'))
}

function changeSizeOrder() {
    width = $('.width').val();
    height = $('.height').val();
    length = $('.length').val();
    weight = $('.weight').val().replace(/\./g, '');;
    orderId = $('.orderId').val();
    note = $('.note').val();
    error = 0;
    if (width == '' || width == 0) {
        $('.err_width').html('Độ rộng không đc để trống');
        error = 1;
    }
    if (height == '' || height == 0) {
        $('.err_height').html('Độ cao không đc để trống');
        error = 1;
    }
    if (length == '' || length == 0) {
        $('.err_length').html('Độ dài không đc để trống');
        error = 1;
    }
    if (weight == '' || weight == 0) {
        $('.err_weight').html('Cân nặng không đc để trống');
        error = 1;
    }
    if (error == 0) {
        $('#loader').addClass('show');
        $.ajax({
            url: '/chi-tiet-don-hang/' + orderId,
            type: 'post',
            dataType: 'json',
            data: {
                'width': width,
                'height': height,
                'length': length,
                'weight': weight,
                'note': note,
                'orderId': orderId,
            },
            success: function (res) {
                location.reload();
            },
            error: function () {
                location.reload();
            }

        });
    }
}

function changeInfoReceiver(orderId) {

    let error = 0;

    $('#loader').addClass('show');
    var receiverNameChange = $('.receiverNameChange').val();
    var receiverPhoneChange = $('.receiverPhoneChange').val();
    var receiverAddressChange = $('.receiverAddressChange').val();
    var province = $('.sender_province_code').find(':selected').val();
    var district = $('.sender_district_code').find(':selected').val();
    var ward = $('.sender_ward_code').find(':selected').val();
    if (receiverNameChange == '') {
        err_receiverNameChange = 'Tên người nhận không được để trống';
        $(".err_receiverNameChange").html('Tên người nhận không được để trống');
        error = 1;
    }
    if (receiverPhoneChange == '') {
        err_receiverPhoneChange = 'Điện thoại người nhận không được để trống';
        $(".err_receiverPhoneChange").html('Điện thoại người nhận không được để trống');
        error = 1;
    }
    if (receiverAddressChange == '') {
        err_receiverAddressChange = 'Địa chỉ người nhận không được để trống';
        $(".err_receiverAddressChange").html('Địa chỉ người nhận không được để trống');
        error = 1;
    }
    if (province == '' || province == 0) {
        err_sender_province_code = 'Thành phố không được để trống';
        $(".err_sender_province_code").html('Thành phố không được để trống');
        error = 1;
    }
    if (district == '') {
        err_sender_district_code = 'Quận/huyện không được để trống';
        $(".err_sender_district_code").html('Quận/huyện không được để trống');
        error = 1;
    }
    if (ward == '') {
        err_sender_ward_code = 'Phường/xã không được để trống';
        $(".err_sender_ward_code").html('Phường/xã không được để trống');
        error = 1;
    }
    if (orderId == '') {
        alert('Không tìm thấy mã vận dơn.')
        error = 1;
    }
    if (error == 0) {
        $.ajax({
            url: '/changeInfoReceiver',
            type: 'post',
            dataType: 'json',
            data: {
                'receiverNameChange': receiverNameChange,
                'receiverPhoneChange': receiverPhoneChange,
                'receiverAddressChange': receiverAddressChange,
                'province': province,
                'district': district,
                'ward': ward,
                'orderId': orderId,
            },
            success: function (res) {
                location.reload();
            },
            error: function () {
                location.reload();
            }
        });
    }
}

function changeMethodReceiver(orderId) {
    $('#loader').addClass('show');

    let error = 0;
    var orderMethod = $('.orderMethod').find(':selected').val();
    var shippingMethod = $('.shippingMethod').find(':selected').val();
    var deliveryMethod = $('.deliveryMethod').find(':selected').val();
    var paymentMethod = $('.paymentMethod').find(':selected').val();

    if (orderMethod == '') {
        $(".err_orderMethod").html('Phương thức đặt hàng không được để trống.');
        error = 1;
    }

    if (shippingMethod == '') {
        $(".err_shippingMethod").html('Phương thức vận chuyển không được để trống.');
        error = 1;
    }
    if (deliveryMethod == '') {
        $(".err_sender_ward_code").html('Phương thức giao hàng không được để trống.');
        error = 1;
    }

    if (paymentMethod == '') {
        $(".err_paymentMethod").html('Phương thức thanh toán không được để trống.');
        error = 1;
    }

    if (orderId == '') {
        alert('Không tìm thấy mã vận dơn.')
        error = 1;
    }
    if (error == 0) {
        $.ajax({
            url: '/changeMethodInfo',
            type: 'post',
            dataType: 'json',
            data: {
                'orderMethod': orderMethod,
                'shippingMethod': shippingMethod,
                'deliveryMethod': deliveryMethod,
                'paymentMethod': paymentMethod,
                'orderId': orderId,
            },
            success: function (res) {
                location.reload();
            },
            error: function () {
                location.reload();
            }
        });
    }
}
var timeOut = 100;

function getProductSearch() {
    $("#all-select-product-add-new").html('<div class="col-12">Đang tìm kiếm sản phẩm ... </div>')
    var key = $("#searchProduct").val();
    clearTimeout(timeOut);
    timeOut = setTimeout(function () {
        $.ajax({
            url: '/don-hang/searchProduct',
            type: 'post',
            dataType: 'json',
            data: {
                'key': key
            },
            success: function (res) {
                if (res.success) {
                    $('#modal-add-product-detail').css('width', '100%');
                    $("#all-select-product-add-new").html(res.html)
                } else {
                    $("#all-select-product-add-new").html('<div class="col-12">' + res.message + '</div>')
                }
            },
            error: function () {}
        });
    }, 500)
}

function chooseProduct(idProduct) {
    if (idProduct != '') {
        var keyProduct = $('.keyProduct').val();
        var priceWeight = [];
        var checked = '';
        console.log(arrProduct)
        var keyIndex = arrProduct.findIndex(element => {
            if (element.id === idProduct) {
                return true;
            }
            return false;
        });
        priceWeight = arrProduct[keyIndex].prices;
        var html = `
            <div class="form-group row pdn product-` + keyProduct + `"> 
                <div class="col-md-3">
                    <label for="productNamePlus">Tên sản phẩm </label>
                    <select class="form-control chosen-select productNamePlus productNamePlus-` + keyProduct + `" key="` + keyProduct + `" id="productNamePlus"
                        name="productNamePlus" data-placeholder="Tên sản phẩm">
                        <option value="0">Chọn sản phẩm </option>
                        `
        $.each(arrProduct, function (key, value) {
            if (value.id == idProduct) {
                checked = 'selected';
            } else {
                checked = '';
            }
            html += `
                                <option  ` + checked + ` value="` + value.id + `"> ` + value.name + ` </option>`;
        });
        html += `   </select>
                    <span class="error_text errProductNamePlus-` + keyProduct + `"></span>
                </div>
                <div class="col-md-3">
                    <label for="weightProductModal">Quy cách đóng gói</label>
                    <select class="form-control chosen-select weightProductModal weightProductModal-` + keyProduct + `" id="weightProductModal-` + keyProduct + `"
                    key="` + keyProduct + `" name="weightProductModal weightProductModal-` + keyProduct + `" data-placeholder="Quy cách đóng gói">
                        `
        $.each(priceWeight, function (keyPrice, valuePrice) {
            html += `
                                <option key="` + keyProduct + `" keystock="` + valuePrice.stock + `" keyprice="` + valuePrice.price + `" value="` + valuePrice.id + `"> ` + valuePrice.weight + ` ` + valuePrice.unit + `</option>`;
        });
        html += `</select>
                    <span class="error_text errWeightProductModal-` + keyProduct + `"></span>
                </div>
                <div class="col-md-3">
                    <label for="quantityProduct"> Số lượng </label>
                    <input type="number" name="quantityProduct" class="form-control quantityProduct quantityProduct-` + keyProduct + `"
                        id="quantityProduct" key="` + keyProduct + `" placeholder="Số lượng" value="1">
                    <span class="error_text errQuantityProduct-` + keyProduct + `"></span>
                </div>
                <div class="col-md-2">
                    <label for="cashProduct"> Thành tiền </label>
                    <input type="text" name="cashProduct" class="form-control cashProduct cashProduct-` + keyProduct + `" disabled
                        id="cashProduct" placeholder="Thành tiền" value="">
                    <span class="error_text errcashProduct"></span>
                </div>
                <div class="col-md-1">
                        <label for="removeProductPlus" class="blRemoveProductPlus"></label>
                        <button type="button" class="btn btn-danger removeProductPlus removeProductPlus-` + keyProduct + `" onclick = 'removeProductPlus(` + keyProduct + `)'><span><i
                                    class="mdi mdi-minus-circle-outline"></i></span></button>
                    </div>
            </div>`;
        $('.appendNewProduct').append(html);
        $('.productNamePlus-' + keyProduct).val(idProduct).trigger("chosen:updated");
        $('.productNamePlus').chosen();
        $('.weightProductModal-' + keyProduct).chosen();

        $('.keyProduct').val(parseInt(keyProduct) + 1);

        $('.cashProduct-' + keyProduct).val(String(priceWeight[0].price).replace(/(.)(?=(\d{3})+$)/g, '$1,'))

    }
}

function addProductOrder() {
    var keyProduct = $('.keyProduct').val();
    var html = `
            <div class="form-group row pdn product-` + keyProduct + `"> 
                <div class="col-md-3">
                    <label for="productNamePlus">Tên sản phẩm </label>
                    <select class="form-control chosen-select productNamePlus productNamePlus-` + keyProduct + `" key="` + keyProduct + `" id="productNamePlus"
                        name="productNamePlus" data-placeholder="Tên sản phẩm">
                        <option value="0">Chọn sản phẩm </option>
                        `
    $.each(arrProduct, function (key, value) {
        html += `
                                <option value="` + value.id + `"> ` + value.name + ` </option>`;
    });
    html += `
                    </select>
                    <span class="error_text errProductNamePlus-` + keyProduct + `"></span>
                </div>
                <div class="col-md-3">
                    <label for="weightProductModal">Quy cách đóng gói</label>
                    <select class="form-control chosen-select weightProductModal weightProductModal-` + keyProduct + `" id="weightProductModal-` + keyProduct + `"
                    key="` + keyProduct + `" name="weightProductModal weightProductModal-` + keyProduct + `" data-placeholder="Quy cách đóng gói">
                        <option value="0">Chọn cách đóng gói</option>
                    </select>
                    <span class="error_text errWeightProductModal-` + keyProduct + `"></span>
                </div>
                <div class="col-md-3">
                    <label for="quantityProduct"> Số lượng </label>
                    <input type="number" min="0" name="quantityProduct" class="form-control quantityProduct quantityProduct-` + keyProduct + `"
                        id="quantityProduct" key="` + keyProduct + `" placeholder="Số lượng" value="1">
                        <span class="error_text errQuantityProduct-` + keyProduct + `"></span>
                </div>
                <div class="col-md-2">
                    <label for="cashProduct"> Thành tiền </label>
                    <input type="text" name="cashProduct" class="form-control cashProduct cashProduct-` + keyProduct + `" disabled
                        id="cashProduct" placeholder="Thành tiền" value="">
                    <span class="error_text errcashProduct"></span>
                </div>
                <div class="col-md-1">
                        <label for="removeProductPlus" class="blRemoveProductPlus"></label>
                        <button type="button" class="btn btn-danger removeProductPlus removeProductPlus-` + keyProduct + `" onclick = 'removeProductPlus(` + keyProduct + `)'><span><i
                                    class="mdi mdi-minus-circle-outline"></i></span></button>
                    </div>
            </div>`;
    $('.appendNewProduct').append(html);
    $('.productNamePlus').chosen();
    $('.weightProductModal').chosen();
    $('.keyProduct').val(parseInt(keyProduct) + 1);
}

function removeProductPlus(keyProductPlus) {
    $('.product-' + keyProductPlus).remove();
}

function confirmOrder(orderCode, type) {
    $('#loader').addClass('show');
    if (orderCode != '' || orderCode != 0) {
        $.ajax({
            url: '/don-hang/confirmOrder',
            type: 'post',
            dataType: 'json',
            data: {
                'orderCode': orderCode,
                'type': type
            },
            success: function (res) {
                window.location.href = res.href;
            },
            error: function () {
                window.location.href = res.href;
            }
        });
    }
}

function exportExcelTemplZalo() {
    $('#loader').addClass('show');
    let templId = $("input[name=templateId]").val();
    let service = $("[name=service]").val();
    let status = $("[name=status]").val();

    $.ajax({
        url: '/exportExcelZalo',
        type: 'post',
        dataType: 'json',
        data: {
            'templateId': templId,
            'service': service,
            'status': status
        },
        success: function (data) {
            console.log(data);
            if (data.status == 200) {
                $('#loader').removeClass('show');
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", data.name);
                $a[0].click();
                $a.remove();
                window.location.href = data.href;
                setTimeout(function () {
                    $('#loader').removeClass('show');
                }, 1000);
            } else {
                $('#loader').removeClass('show');
            }
        },
        error: function () {
            // window.location.href = res.href;
        }
    });

}

function exportExcelOrder(isReality, type = 0) {
    $('#loader').addClass('show');
    var keySearch = $('#keySearch').val();
    var status = $('.status').val();
    var started = $('.started').val();
    var stoped = $('.stoped').val();
    var url = '/don-hang/exportExcelOrder';
    if (type == 1) {
        var url = '/don-hang/exportExcelOrderGet';
    }
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: {
            'keySearch': keySearch,
            'status': status,
            'started': started,
            'stoped': stoped,
            'isReality': isReality,
            'type': type,
        },
        success: function (data) {
            if (data.status == 200) {
                $('#loader').removeClass('show');
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", data.name);
                $a[0].click();
                $a.remove();
                window.location.href = data.href;
                setTimeout(function () {
                    $('#loader').removeClass('show');
                }, 1000);
            } else {
                $('#loader').removeClass('show');
            }
        },
        error: function () {
            // window.location.href = res.href;
        }
    });

}