$(document).ready(function() {
    $('.unNumber').keydown(function (e) {
        var charCode = e.keyCode;
            if ((charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode >186 && charCode < 222 ) {
                    e.preventDefault();
                }
        });
    $('body').on('blur', '.pickName',function(){
        pickName = $('.pickName').val();
        if(pickName.length == 0){
            $('.err_pickName').html('Tên người gửi không được để trống');
        }else if(pickName.length < 2){
            $('.err_pickName').html('Tên người gửi quá ngắn');
        }else{
            $('.err_pickName').html('');
        }
    });

    $('body').on('blur', '.pickAddress',function(){
        pickAddress = $('.pickAddress').val();
        if(pickAddress.length == 0){
            $('.err_pickAddress').html('Địa chỉ gửi hàng không được để trống');
            $('#pickProvince').parent().removeClass('address_success');
            $('#pickProvince').parent().removeClass('address_warning');
            $('#pickProvince').parent().removeClass('address_edit');
            $('#pickDistrict').parent().removeClass('address_warning');
            $('#pickDistrict').parent().removeClass('address_success');
            $('#pickDistrict').parent().removeClass('address_edit');
            $('#pickWard').parent().removeClass('address_success');
            $('#pickWard').parent().removeClass('address_warning');
            $('#pickWard').parent().removeClass('address_edit');
        }else{
            $('.err_pickAddress').html('');
        }
    });

    $('body').on('blur', '.pickPhone',function(){
        pickPhone = $(this).val();
        if(pickPhone == ''){
            $('.err_pickPhone').html('Số điện thoại không được bỏ trống');
        }else{
            checkpickPhone = validatePhone(pickPhone);
            if(!checkpickPhone){
                $('.err_pickPhone').html('Số điện thoại không hợp lệ');
            }else{
                $('.err_pickPhone').html('');
            }
        }
    });
    $('body').on('blur', '.receiverPhone',function(){
        receiverPhone = $(this).val();
        receiverPhoneIndex = $(this).attr('index_item');
        if(receiverPhone == ''){
            $('.err_receiverPhone_'+receiverPhoneIndex).html('Số điện thoại không được bỏ trống');
        }else{
            checkreceiverPhone = validatePhone(receiverPhone);
            if(!checkreceiverPhone){
                $('.err_receiverPhone_'+receiverPhoneIndex).html('Số điện thoại không hợp lệ');
            }else{
                $('.err_receiverPhone_'+receiverPhoneIndex).html('');
            }
        }
    });
    $('body').on('blur', '.receiver',function(){
        receiver = $(this).val();
        receiverIndex = $(this).attr('index_item');
        if(receiver.length == 0){
            $('.err_receiver_'+receiverIndex).html('Tên người gửi không được để trống');
        }else if(receiver.length < 4){
            $('.err_receiver_'+receiverIndex).html('Tên người gửi không hợp lệ');
        }else{
            $('.err_receiver_'+receiverIndex).html('');
        }
    });
    $('body').on('blur', '.productName',function(){
        productName = $(this).val();
        productNameIndex = $(this).attr('index_item');
        if(productName.length == 0){
            $('.err_productName_'+productNameIndex).html('Tên hàng hóa không được để trống');
        }else{
            $('.err_productName_'+productNameIndex).html('');
        }
    });


    $('.order_province_code_from').change(function(){
        var receiverProductIndex = $(this).attr('index_prov');
        $('.provinceReceiver_'+receiverProductIndex).removeClass('address_success');
        $('.provinceReceiver_'+receiverProductIndex).removeClass('address_warning');
        $('.provinceReceiver_'+receiverProductIndex).removeClass('address_error');
        $('.provinceReceiver_'+receiverProductIndex).addClass('address_edit');
    });


    $('.order_district_code_from').change(function(){
        var receiverDistrictIndex = $(this).attr('index_dict');
        $('.districtReceiver_'+receiverDistrictIndex).removeClass('address_success');
        $('.districtReceiver_'+receiverDistrictIndex).removeClass('address_warning');
        $('.districtReceiver_'+receiverDistrictIndex).removeClass('address_error');
        $('.districtReceiver_'+receiverDistrictIndex).addClass('address_edit');
    });
    
    
    $('.order_ward_code_from').change(function(){
        var receiverWardIndex = $(this).attr('index_ward');
        $('.wardReceiver_'+receiverWardIndex).removeClass('address_success');
        $('.wardReceiver_'+receiverWardIndex).removeClass('address_warning');
        $('.wardReceiver_'+receiverWardIndex).removeClass('address_error');
        $('.wardReceiver_'+receiverWardIndex).addClass('address_edit');
    });

    $('body').on('click', '.choosePostage',function(event){
        var packageCode = $(this).attr('packageCode');
        var packageType = $(this).attr('packageType');
        var packageName = $(this).attr('packageName');
        if(packageCode != '' && packageCode != 0){
            $.ajax({
                url: '/vi/tao-don-le',
                type: 'post',
                dataType: 'json',
                data: {
                    'packageCode': packageCode,
                    'packageType': packageType,
                    'packageName': packageName
                },
                success: function(res) {
                    if (res.success) {
                        window.location.href = res.href;
                    } else {
                    }
                },
                error: function() {
    
                }
            });
        }
    });
    $('body').on('click', '.checkProductValue',function(){
        checkProductValue = $(this).is(":checked");
        var deliveryPointIndex = $(this).attr('deliveryPointIndex');
        var receiverIndex = $(this).attr('receiverIndex');
        var productIndex = $(this).attr('productIndex');
        console.log(checkProductValue)
        if(checkProductValue == true){
            $("#qo-khaigia-ht").removeAttr("disabled");
        }else{
            $("#qo-khaigia-ht").attr("disabled", true);
            $('.err_productValue_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).html('');
        }
    });
    
    // $('body').on('click', '.closePickupOrder',function(){
    //     var receiverIndex = parseInt($(this).attr('receiverIndex'));
    //     var productIndex = parseInt($(this).attr('productIndex'));
    //     var deliveryPointIndex = parseInt($(this).attr('deliveryPointIndex'));
    //     console.log('receiverIndex: ' + receiverIndex)
    //     console.log('deliveryPointIndex: ' + deliveryPointIndex)
    //     receiverPhone = $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][phone]"]').val();
    //     receiverName = $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][name]"]').val();
    //     let arrayProduct =[];
    //     let dataTransfer = [];
    //     for (let i = 0; i < productIndex; i++) {
    //         arrayProduct.push({
    //             productName: $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][items]['+(parseInt(i) + 1)+'][productName]"]').val(),
    //             productQuantity: $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][items]['+(parseInt(i) + 1)+'][quantity]"]').val(),
    //             productCod: $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][items]['+(parseInt(i) + 1)+'][cod]"]').val(),
    //             productValue: $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][items]['+(parseInt(i) + 1)+'][productValue]"]').val()
    //         });
    //     }
    //     dataTransfer.push({
    //         deliveryPointIndex: deliveryPointIndex,
    //         receiverIndex: receiverIndex,
    //         productIndex: productIndex,
    //         receiverName: receiverName,
    //         receiverPhone: receiverPhone,
    //         arrayProduct:arrayProduct
    //     })

    //     if(receiverName == '' ){
    //         $('.err_receiver_'+deliveryPointIndex+'_'+receiverIndex).html('Tên người nhận không được để trống');
    //     }else if(receiverPhone == '' ){
    //         $('.err_receiverPhone_'+deliveryPointIndex+'_'+receiverIndex).html('Tên người nhận không được để trống');
    //     }else{

    //         $.ajax({
    //             url: '/vi/showOrderReceiverDetail',
    //             type: 'post',
    //             dataType: 'json',
    //             data: {
    //                 'dataTransfer': dataTransfer
    //             },
    //             success: function(res) {
    //                 if (res.success) {
    //                     $('.pickupOrder_'+deliveryPointIndex+'_'+receiverIndex).removeClass('dpb');
    //                     $('.pickupOrder_'+deliveryPointIndex+'_'+receiverIndex).addClass('dpn');
    //                     $('.afOrder_'+deliveryPointIndex).show();
    //                     $('.afOrder_'+deliveryPointIndex).append(res.data);
    //                     getAllValue(deliveryPointIndex, receiverIndex, productIndex);
    //                     $('.addProductItem_'+deliveryPointIndex).removeClass('dpn');
                    
    //                     $('.addProductItem_'+deliveryPointIndex).attr('productIndex',1);
    //                     $('.addProductItem_'+deliveryPointIndex).attr('receiverIndex',(parseInt(receiverIndex) +1));
    //                     $('.addProductItem_'+deliveryPointIndex).attr('deliveryPointIndex',deliveryPointIndex);

    //                     $('.addProductItem_'+deliveryPointIndex).addClass('dpb');
    //                 } else {
    //                     console.log(1234)
    //                     console.log(res)
    //                 }
    //             },
    //             error: function(res) {
    //                 console.log(12345)
    //                 console.log(res)
    //             }
    //         });
    //     }
    // });

    $('body').on('click', '.addProductItem',function(){
        var receiverIndex = parseInt($(this).attr('receiverIndex'));
        var productIndex = parseInt($(this).attr('productIndex'));
        var deliveryPointIndex = parseInt($(this).attr('deliveryPointIndex'));
        
        $.ajax({
            url: '/vi/addNewReceivers',
            type: 'post',
            dataType: 'json',
            data: {
                'deliveryPointIndex': deliveryPointIndex,
                'productIndex': productIndex,
                'receiverIndex': receiverIndex
            },
            success: function(res) {
                $('.addReceiver_'+deliveryPointIndex).append(res.html)
                $('.addReceiver_'+deliveryPointIndex).find(".orderdatePicker").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y',
                    minDate: new Date()
                });
            },
            error: function(res) {
                
            }
        });

    })

    $('body').on('click', '.updateAllProductItem',function(){
        var receiverIndex = parseInt($(this).attr('receiverIndex'));
        var productIndex = parseInt($(this).attr('productIndex'));
        var deliveryPointIndex = parseInt($(this).attr('deliveryPointIndex'));
        $('.afOrder_'+deliveryPointIndex+'_'+receiverIndex).hide();
        $('.pickupOrder_'+deliveryPointIndex+'_'+receiverIndex).removeClass('dpn');
        $('.pickupOrder_'+deliveryPointIndex+'_'+receiverIndex).addClass('dpb');
        $('#productCategory_'+deliveryPointIndex+'_'+receiverIndex+'_chosen').css("width", "100%");
        $('#productCategory_'+deliveryPointIndex+'_'+receiverIndex).trigger("chosen:updated");
        console.log(deliveryPointIndex)
        console.log(receiverIndex)
        console.log(productIndex)

    });
    // $('body').on('click', '.saveProduct',function(){
    //     let errorAddProductItem = 0;
    //     var receiverIndex = parseInt($(this).attr('receiverIndex'));
    //     var productIndex = parseInt($(this).attr('productIndex'));
    //     var deliveryPointIndex = parseInt($(this).attr('deliveryPointIndex'));
    
    //     // console.log(receiverIndex)
    //     // console.log(productIndex)
    //     // console.log(deliveryPointIndex)
    //     var checkProductValue = $('#checkProductValue_'+receiverIndex+'_'+productIndex).is(':checked')
    
    //     var productName = $('.productName_'+deliveryPointIndex+'_'+receiverIndex).val();
    //     var productCod = $('.productCOD_'+deliveryPointIndex+'_'+receiverIndex).val();
    //     var productValue = $('.productValue_'+deliveryPointIndex+'_'+receiverIndex).val();
    //     var productCategory = $('.productCategory_'+deliveryPointIndex+'_'+receiverIndex).val();
    //     var productCategoryName = $('.productCategory_'+deliveryPointIndex+'_'+receiverIndex).find(":selected").text();
    //     var productAmount = $('.productQuatity_'+deliveryPointIndex+'_'+receiverIndex).val();
    
    //     //Validate Item
    //     if(productName == ''){
    //         errorAddProductItem = 1;
    //         $('.err_productName_'+deliveryPointIndex+'_'+receiverIndex).html('Tên hàng hóa không được để trống');
    //     }
    //     if(productCod == '' || productCod == 0){
    //         errorAddProductItem = 1;
    //         $('.err_productCod_'+deliveryPointIndex+'_'+receiverIndex).html('Tiền COD không được để trống');
    //     }
    //     if( checkProductValue === true && (productValue == 0 || productValue == '')){
    //         errorAddProductItem = 1;
    //         $('.err_productValue_'+deliveryPointIndex+'_'+receiverIndex).html('Giá trị khai giá không được để trống');
    //     }
    //     if( productCategory == 0 || productCategory == ''){
    //         errorAddProductItem = 1;
    //         console.log('1123')
    //         $('.err_productCategory_'+deliveryPointIndex+'_'+receiverIndex).html('Loại hàng hóa không được để trống');
    //     }
    //     if( productAmount == 0 || productAmount == ''){
    //         errorAddProductItem = 1;
    //         $('.err_productQuatity_'+deliveryPointIndex+'_'+receiverIndex).html('Số lượng không được để trống');
    //     }
        
    //     //Get value push redis
    //     var dataRedis = {};
    
    //     //Nơi append :ttsp
    //     if(errorAddProductItem == 0){
    //         $('.err_productName_'+deliveryPointIndex+'_'+receiverIndex).html('');
    //         $('.err_productCod_'+deliveryPointIndex+'_'+receiverIndex).html('');
    //         $('.err_productValue_'+deliveryPointIndex+'_'+receiverIndex).html('');
    //         $('.err_productCategory_'+deliveryPointIndex+'_'+receiverIndex).html('');
    //         $('.err_productQuatity_'+deliveryPointIndex+'_'+receiverIndex).html('');
    //         $.ajax({
    //             url: '/vi/addNewProductItem',
    //             type: 'post',
    //             dataType: 'json',
    //             data: { 'dataRedis' : dataRedis
    //             },
    //             success: function(res) {
    //                 if (res.success) {
    //                     $("#ttsp_"+deliveryPointIndex+"_"+receiverIndex).append(`
    //                     <ul class="col-12" id="tdl-tthh-${productIndex}">
    //                         <li class="or-ttdh-add">
    //                             <ul class="row">
    //                                 <li class="or-dh-tt col-sm-3 pl-2">
    //                                     <span class="or-dh-stt" style="background: #885DE5;">${productIndex}</span>
    //                                     <span id="ttct-cthh-name_${deliveryPointIndex}_${receiverIndex}_${productIndex}">${productName}</span>
    //                                 </li>
    //                                 <li class="or-dh-sl col-sm-1">
    //                                     SL: <span id="ttct-cthh-amount_${deliveryPointIndex}_${receiverIndex}_${productIndex}">${productAmount}</span>
    //                                 </li>
    //                                 <li class="or-dh-sp col-sm-3">
    //                                     <span id="ttct-cthh-category_${deliveryPointIndex}_${receiverIndex}_${productIndex}">${productCategoryName}</span>
    //                                 </li>
    //                                 <li class="or-dh-cod col-sm-2">
    //                                     COD: <span id="ttct-cthh-cod_${deliveryPointIndex}_${receiverIndex}_${productIndex}">${productCod}</span>đ
    //                                 </li>
    //                                 <li class="or-dh-kg col-sm-2">
    //                                     Khai giá: <span id="ttct-cthh-price_${deliveryPointIndex}_${receiverIndex}_${productIndex}">${productValue}</span>đ
    //                                 </li>
    //                                 <li class="or-dh-ed col-sm-1">
    //                                     <img src="`+location.origin+'/public/images/or-delete.png'+`" onclick="removeProduct('tdl-tthh-${productIndex}',${receiverIndex},${productIndex})">
    //                                     <img src="`+location.origin+'/public/images/or-edit.png'+`" onclick="editProduct(${deliveryPointIndex},${receiverIndex},${productIndex})">
    //                                 </li>
    //                             </ul>
    //                         </li>
    //                     </ul>
    //                     <input index_item = "${productIndex}" class="productItem_${receiverIndex}_${productIndex} productName_${deliveryPointIndex}_${receiverIndex}_${productIndex}" name="deliveryPoint[${deliveryPointIndex}][receivers][${receiverIndex}][items][${productIndex}][productName]" type="hidden" value="${productName}">
                        
    //                     <input index_item = "${productIndex}" class="productItem_${receiverIndex}_${productIndex} cod_${deliveryPointIndex}_${receiverIndex}_${productIndex}" name="deliveryPoint[${deliveryPointIndex}][receivers][${receiverIndex}][items][${productIndex}][cod]" type="hidden" value="${productCod}" >
                        
    //                     <input index_item = "${productIndex}" class="productItem_${receiverIndex}_${productIndex} productValue_${deliveryPointIndex}_${receiverIndex}_${productIndex}" name="deliveryPoint[${deliveryPointIndex}][receivers][${receiverIndex}][items][${productIndex}][productValue]" type="hidden" value="${productValue}" >
                        
    //                     <input index_item = "${productIndex}" class="productItem_${receiverIndex}_${productIndex} category_${deliveryPointIndex}_${receiverIndex}_${productIndex}" name="deliveryPoint[${deliveryPointIndex}][receivers][${receiverIndex}][items][${productIndex}][category]" type="hidden" value="${productCategory}" >
                       
    //                     <input index_item = "${productIndex}" class="productItem_${receiverIndex}_${productIndex} quantity_${deliveryPointIndex}_${receiverIndex}_${productIndex}" name="deliveryPoint[${deliveryPointIndex}][receivers][${receiverIndex}][items][${productIndex}][quantity]" value="${productAmount}" type="hidden">
    //                     `
    //                     );
    //                     // $('.saveProduct').attr('receiverIndex',receiverIndex + 1);
    //                     $('.saveProduct').attr('productIndex',productIndex + 1);
    //                     console.log(productIndex)
    //                     $('.closePickupOrder_'+deliveryPointIndex+'_'+receiverIndex).attr('productIndex',productIndex);
    //                     $('.closePickupOrder_'+deliveryPointIndex+'_'+receiverIndex).attr('receiverIndex',receiverIndex);
    //                     $('.closePickupOrder_'+deliveryPointIndex+'_'+receiverIndex).attr('deliveryPointIndex',deliveryPointIndex);
                        
    //                     $('.productName_'+deliveryPointIndex+'_'+receiverIndex).val('');
    //                     $('.productCOD_'+deliveryPointIndex+'_'+receiverIndex).val('0');
    //                     $('.productValue_'+deliveryPointIndex+'_'+receiverIndex).val('0');
    //                     $('.productCategory_'+deliveryPointIndex+'_'+receiverIndex).val('0');
    //                     $('.productQuatity_'+deliveryPointIndex+'_'+receiverIndex).val('1');
    //                     $('.productCategory_'+deliveryPointIndex+'_'+receiverIndex).trigger("chosen:updated");
        
    //                 }
    //             },
    //             error: function() {
    //                 //Call Modal Thông báo lỗi
    //             }
    //         });
    //     }
    // });

    // $('body').on('click','.updateProduct',function(){
    //     var receiverIndex = parseInt($(this).attr('receiverIndex'));
    //     var productIndex = parseInt($(this).attr('productIndex'));
    //     var deliveryPointIndex = parseInt($(this).attr('deliverypointindex'));

    //     var productName = $('.productName_'+deliveryPointIndex+'_'+receiverIndex).val();
    //     var cod = $('.productCOD_'+deliveryPointIndex+'_'+receiverIndex).val();
    //     var productValue = $('.productValue_'+deliveryPointIndex+'_'+receiverIndex).val();
    //     var category = $('.productCategory_'+deliveryPointIndex+'_'+receiverIndex).val();
    //     var quantity = $('.productQuatity_'+deliveryPointIndex+'_'+receiverIndex).val();
    //     var productCategoryName = $('.productCategory_'+deliveryPointIndex+'_'+receiverIndex).find(":selected").text();
    //     $('.productName_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).val(productName);
    //     $('.cod_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).val(cod);
    //     $('.productValue_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).val(productValue);
    //     $('.category_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).val(category);
    //     $('.quantity_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).val(quantity);

    //     $('#ttct-cthh-name_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).html(productName);
    //     $('#ttct-cthh-cod_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).html(cod);
    //     $('#ttct-cthh-price_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).html(productValue);
    //     $('#ttct-cthh-category_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).html(productCategoryName);
    //     $('#ttct-cthh-amount_'+deliveryPointIndex+'_'+receiverIndex+'_'+productIndex).html(quantity);

    //     $('.productCategory_'+deliveryPointIndex+'_'+receiverIndex).trigger("chosen:updated");
    //     console.log('#qo-btn-thh-1-'+deliveryPointIndex+'-'+receiverIndex);
    //     console.log('#qo-btn-thh-2-'+deliveryPointIndex+'-'+receiverIndex);
    //     $('#qo-btn-thh-2-'+deliveryPointIndex+'-'+receiverIndex).hide();
    //     $('#qo-btn-thh-1-'+deliveryPointIndex+'-'+receiverIndex).show();
    //     clearValueProduct(deliveryPointIndex,receiverIndex)
    // })

});


function choosePickupAddress(id){
    if(id == 0){
        $('.pickInput').css("display", "flex");
        $('.senderInfo').css("display", "none");
        $('.orDetail-input').show();
        $(".orDetail-input-show").hide();
        $('.choosePickUpAddress').val('Thêm mới điểm gửi');
        $('.err_orderSender').html('');
        $('.err_orderSenderAddress').html('');
        $('.err_orderSenderPhone').html('');
        $('.pickName').val('');
        $('.pickPhone').val('');
        $('.pickAddress').val('');
        $('.pickProvince').val('');
        $('.pickDistrict').val('');
        $('.pickWard').val('');
        $('.pickupAddressId').val('');
        $('.choosePickUpAddress').attr('pickupAddressId','');
        $('#pickProvince_chosen').width("100%");
        $('#pickDistrict_chosen').width("100%");
        $('#pickWard_chosen').width("100%");
    }
    $.ajax({
        url: '/vi/choose-pickup-address',
        type: 'post',
        dataType: 'json',
        data: {
            'pickUpAddress': id
        },
        success: function(res) {
            if (res.success) {
                $('.pickInput').css("display", "none");
                $('.senderInfo').css("display", "flex");
                $('.orDetail-input').hide();
                $('.choosePickUpAddress').val(res.fullAddress);
                $('.pickupAddressId').val(id);
                $('.choosePickUpAddress').attr('pickupAddressId',id);
                $('.senderInfo').html(res.dataHtml);
                $(".orDetail-input-show").css("display", "flex");
            } else {
                console.log(1234)
                console.log(res)
            }
        },
        error: function(res) {
            console.log(12345)
            console.log(res)
        }
    });   
}

//Get ajax append 
// function addNewProductItem(ttsp){
    
// }
function removeProduct(productId,receiverIndex,productIndex){
    document.getElementById(productId).remove();
    $('.productItem_'+receiverIndex+'_'+productIndex).remove()
}

// function editProduct(deliveryPointIndex,receiverIndex,productIndex){
//     document.getElementById('qo-btn-thh-1-'+deliveryPointIndex+'-'+receiverIndex).style.display = "none";
//     document.getElementById('qo-btn-thh-2-'+deliveryPointIndex+'-'+receiverIndex).style.display = "block";

//     var productName = $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][items]['+productIndex+'][productName]"]').val();
//     var cod = $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][items]['+productIndex+'][cod]"]').val();
//     var productValue = $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][items]['+productIndex+'][productValue]"]').val();
//     var category = $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][items]['+productIndex+'][category]"]').val();
//     var quantity = $('[name="deliveryPoint['+deliveryPointIndex+'][receivers]['+receiverIndex+'][items]['+productIndex+'][quantity]"]').val();

//     $('.productName_'+deliveryPointIndex+'_'+receiverIndex).val(productName);
//     $('.productCOD_'+deliveryPointIndex+'_'+receiverIndex).val(cod);
//     $('.productValue_'+deliveryPointIndex+'_'+receiverIndex).val(productValue);
//     $('.productCategory_'+deliveryPointIndex+'_'+receiverIndex).val(category);
//     $('.productQuatity_'+deliveryPointIndex+'_'+receiverIndex).val(quantity);

//     $('#qo-btn-thh-2-'+deliveryPointIndex+'-'+receiverIndex).attr('receiverIndex',receiverIndex);
//     $('#qo-btn-thh-2-'+deliveryPointIndex+'-'+receiverIndex).attr('productIndex',productIndex);
//     $('#qo-btn-thh-2-'+deliveryPointIndex+'-'+receiverIndex).attr('deliveryPointIndex',deliveryPointIndex);
//     $('.productCategory_'+deliveryPointIndex+'_'+receiverIndex).trigger("chosen:updated");
//     // document.getElementById(productId).remove();
// }
function updateProduct(){
    
}
function clearValueProduct(deliverypointindex,receiverIndex){
    $('.productName_'+deliverypointindex+'_'+receiverIndex).val('');
    $('.productCOD_'+deliverypointindex+'_'+receiverIndex).val('0');
    $('.productValue_'+deliverypointindex+'_'+receiverIndex).val('0');
    $('.productCategory_'+deliverypointindex+'_'+receiverIndex).val('0');
    $('.productQuatity_'+deliverypointindex+'_'+receiverIndex).val('1');
    $('.productCategory_'+deliverypointindex+'_'+receiverIndex).trigger("chosen:updated");
}

function addNewPickupAddress(maxPickupAddress = 5){
    deliveryPointNumber = $('[name="deliveryPointNumber"]').val();
    deliveryPointIndex = parseInt(deliveryPointNumber) + 1 ;
    $.ajax({
        url: '/vi/addNewPickupAddress',
        type: 'post',
        dataType: 'json',
        data: { 'deliveryPointIndex' : deliveryPointIndex
        },
        success: function(res) {
            $('.ttdh-main').append(res.html);
            // setTimeout(function(){ 
                $(".chosen-select").chosen();
            //  }, 300);
            $('[name="deliveryPointNumber"]').val(deliveryPointIndex)
            if(deliveryPointNumber == (parseInt(maxPickupAddress) -1 )){
                $('.btn-add-orders').hide();
            }
        },
        error: function() {
            //Call Modal Thông báo lỗi
        }
    });
}
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 31 && (charCode < 48 || charCode > 57) ) && charCode!= 44 && charCode!= 45 ) {
        return false;
    }
    return true;
}

function addAddressDetail(deliveryPointIndex){
    var receiverSenderSub = $('.address_'+deliveryPointIndex).val();
    var receiverProductIndex = deliveryPointIndex;
        //Remove all class 
        $('.districtReceiver_'+receiverProductIndex).removeClass('address_success');
        $('.districtReceiver_'+receiverProductIndex).removeClass('address_warning');
        $('.districtReceiver_'+receiverProductIndex).removeClass('address_error');
        $('.provinceReceiver_'+receiverProductIndex).removeClass('address_success');
        $('.provinceReceiver_'+receiverProductIndex).removeClass('address_warning');
        $('.provinceReceiver_'+receiverProductIndex).removeClass('address_error');
        $('.wardReceiver_'+receiverProductIndex).removeClass('address_success');
        $('.wardReceiver_'+receiverProductIndex).removeClass('address_warning');
        $('.wardReceiver_'+receiverProductIndex).removeClass('address_error');
        
        if(receiverSenderSub.length <= 0){
            $('#provinceReceiver_'+receiverProductIndex).trigger("chosen:updated");
            $('#districtReceiver_'+receiverProductIndex).trigger("chosen:updated");
            $('#wardReceiver_'+receiverProductIndex).trigger("chosen:updated");

            $('#provinceReceiver_'+receiverProductIndex+'_chosen').css("width", "100%");
            $('#districtReceiver_'+receiverProductIndex+'_chosen').css("width", "100%");
            $('#wardReceiver_'+receiverProductIndex+'_chosen').css("width", "100%");
            $(".orderDetail_"+receiverProductIndex).removeClass('address_show');
            $(".orderDetail_"+receiverProductIndex).addClass('address_v2');
            $('.err_address_'+receiverProductIndex).html('Địa chỉ gửi hàng không được để trống');
        }else{
            $('.err_address_'+receiverProductIndex).html('');
            $.ajax({
                url: '/vi/get-address-location',
                type: 'post',
                dataType: 'json',
                data: {
                    'receiverSenderSub': receiverSenderSub
                },
                success: function(res) {
                    if (res.success) {
                        if(res.data != 1){
                        var obj          = jQuery.parseJSON(res.data);

                        if (obj.ward_prob >= 0.9 && obj.ward_code) {
                            
                            $('.wardReceiver_'+receiverProductIndex).addClass('address_success');
                        }else if((0.7 <= obj.ward_prob) && (obj.ward_prob < 0.9) && obj.ward_code){
                            
                            $('.wardReceiver_'+receiverProductIndex).addClass('address_warning');
                        }else{
                            $('.wardReceiver_'+receiverProductIndex).addClass('address_error');
                        }

                        if (obj.district_prob >= 0.9 && obj.district_code) {
                            $('.districtReceiver_'+receiverProductIndex).addClass('address_success');
                        }else if((0.7 <= obj.district_prob) && (obj.district_code < 0.9) && obj.district_code){
                            $('.districtReceiver_'+receiverProductIndex).addClass('address_warning');
                        }else{
                            $('.districtReceiver_'+receiverProductIndex).addClass('address_error');
                        }

                        if (obj.province_prob >= 0.9 && obj.province_code) {
                            $('.provinceReceiver_'+receiverProductIndex).addClass('address_success');
                        }else if((0.7 <= obj.province_prob) && (obj.province_code < 0.9) && obj.province_code){
                            $('.provinceReceiver_'+receiverProductIndex).addClass('address_warning');
                        }else{
                            $('.provinceReceiver_'+receiverProductIndex).addClass('address_error');
                        }

                        $('#provinceReceiver_'+receiverProductIndex).trigger("chosen:updated");
                        $('#districtReceiver_'+receiverProductIndex).trigger("chosen:updated");
                        $('#wardReceiver_'+receiverProductIndex).trigger("chosen:updated");

                        $('#provinceReceiver_'+receiverProductIndex+'_chosen').css("width", "100%");
                        $('#districtReceiver_'+receiverProductIndex+'_chosen').css("width", "100%");
                        $('#wardReceiver_'+receiverProductIndex+'_chosen').css("width", "100%");
                        $(".orderDetail_"+receiverProductIndex).addClass('address_show');
                        $(".orderDetail_"+receiverProductIndex).removeClass('address_v2');
                        if(obj.province_prob >= 0.7 && obj.province_code){
                            $(".province_find_pro_"+receiverProductIndex).val(obj.province_code);
                            if (obj.district_prob >= 0.7 && obj.district_code) {
                                $(".district_find_pro_"+receiverProductIndex).val(obj.district_code);
                                if (obj.ward_prob >= 0.7 && obj.ward_code) {
                                    $(".wards_find_pro_"+receiverProductIndex).val(obj.ward_code);
                                }else{
                                    $(".wards_find_pro_"+receiverProductIndex).val('0');
                                }
                            }else{
                                $(".district_find_pro_"+receiverProductIndex).val('0');
                                $(".wards_find_pro_"+receiverProductIndex).val('0');
                            }
                            $('#provinceReceiver_'+receiverProductIndex).val(obj.province_code).trigger("chosen:updated");
                            $('#provinceReceiver_'+receiverProductIndex).trigger('change');
                        }else{
                            $('.districtReceiver_'+receiverProductIndex).removeClass('address_success');
                            $('.districtReceiver_'+receiverProductIndex).removeClass('address_warning');
                            $('.districtReceiver_'+receiverProductIndex).removeClass('address_edit');
                            $('.provinceReceiver_'+receiverProductIndex).removeClass('address_warning');
                            $('.provinceReceiver_'+receiverProductIndex).removeClass('address_success');
                            $('.provinceReceiver_'+receiverProductIndex).removeClass('address_edit');
                            $('.wardReceiver_'+receiverProductIndex).removeClass('address_success');
                            $('.wardReceiver_'+receiverProductIndex).removeClass('address_warning');
                            $('.wardReceiver_'+receiverProductIndex).removeClass('address_edit');
                            
                            $('.districtReceiver_'+receiverProductIndex).addClass('address_error');
                            $('.provinceReceiver_'+receiverProductIndex).addClass('address_error');
                            $('.wardReceiver_'+receiverProductIndex).addClass('address_error');
                            $(".province_find_pro_"+receiverProductIndex).val('0');
                            $(".district_find_pro_"+receiverProductIndex).val('0');
                            $(".wards_find_pro_"+receiverProductIndex).val('0');
                            $('#provinceReceiver_'+receiverProductIndex).val(0).trigger("chosen:updated");
                            $('#districtReceiver_'+receiverProductIndex).val(0).trigger("chosen:updated");
                            $('#wardReceiver_'+receiverProductIndex).val(0).trigger("chosen:updated");
                        }
                    }

                    } else {
                        console.log(res)
                    }
                },
                error: function() {
                }
            });
        }
}
// function addProductItem(){
//     var receiverIndex = parseInt($(this).attr('receiverIndex'));
//     var productIndex = parseInt($(this).attr('productIndex'));
//     var deliveryPointIndex = parseInt($(this).attr('deliveryPointIndex'));
//     console.log(deliveryPointIndex)
//     console.log(receiverIndex)
//     console.log(productIndex)
// }
function btnFinished(deliveryPointIndex = 1,receiverIndex = 1,productIndex = 1){
    var dataRedis = {};
    var deliveryPoint = [];
    var items = [];
    var receivers = [];
    var extraServices = [];
    
    for (let p = 0; p < deliveryPointIndex; p++) {
            deliveryPoint[p] = {};
            deliveryPoint[p]['receivers'] = {};
            deliveryPoint[p]['address'] = $('[name="deliveryPoint['+(parseInt(p) + 1)+'][address]"]').val();
            deliveryPoint[p]['province'] = $('[name="deliveryPoint['+(parseInt(p) + 1)+'][province]"]').val();
            deliveryPoint[p]['district'] = $('[name="deliveryPoint['+(parseInt(p) + 1)+'][district]"]').val();
            deliveryPoint[p]['ward'] = $('[name="deliveryPoint['+(parseInt(p) + 1)+'][ward]"]').val();

            for (let r = 0; r < receiverIndex; r++) {
                    receivers[r]={};
                    receivers[r]['items'] ={};
                    receivers[r]['extraServices'] ={};
                    receivers[r]['phone'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][phone]"]').val();
                    receivers[r]['name'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][name]"]').val();
                    // receivers[r]['length'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][length]"]').val();
                    receivers[r]['length'] = '10';
                    receivers[r]['width'] = '10';
                    receivers[r]['height'] = '10';
                    receivers[r]['weight'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][weight]"]').val();
                    receivers[r]['note'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][note]"]').val();
                    receivers[r]['expectDate'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][expectDate]"]').val();
                    receivers[r]['expectTime'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][expectTime]"]').val();
                    receivers[r]['isFree'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][isFree]"]:checked').val();
                    // receivers[r]['isPorter'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][extraServices][isPorter]"]').val();
                    // receivers[r]['isDoorDeliver'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][extraServices][isDoorDeliver]"]').val();
                    receivers[r]['partialDelivery'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][partialDelivery]"]:checked').val();
                    receivers[r]['isRefund'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][isRefund]"]:checked').val();
                    receivers[r]['requireNote'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][requireNote]"]').val();
                    receivers[r]['extraServices']['isPorter'] = '1';
                    // receivers[r]['extraServices']['isPorter'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][extraServices][isPorter]"]:checked').val();
                    // receivers[r]['extraServices']['isDoorDeliver'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][extraServices][isDoorDeliver]"]:checked').val();
                    receivers[r]['extraServices']['isDoorDeliver'] = '1';
                    
                    for (let i = 0; i < productIndex; i++) {
                        // console.log((parseInt(r) + 1) + '---' + (parseInt(i) + 1))
                        // console.log('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][productName]"]');
                        // console.log($('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][productName]"]').val());
                        items[i] = {};
                        items[i]['productName']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][productName]"]').val();
                        items[i]['quantity']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][quantity]"]').val();
                        items[i]['cod']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][cod]"]').val();
                        items[i]['productValue']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][productValue]"]').val();
                        items[i]['category']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][category]"]').val();
                    }
                    receivers[r]['items'] = items;
        
            }
            deliveryPoint[p]['receivers'] = receivers;
    }
    dataRedis['pickupAddressId'] = $('[name="pickupAddressId"]').val();
    dataRedis['pickName'] = $('[name="pickName"]').val();
    dataRedis['pickPhone'] = $('[name="pickPhone"]').val();
    dataRedis['pickAddress'] = $('[name="pickAddress"]').val();
    dataRedis['pickProvince'] = $('[name="pickProvince"]').val();
    dataRedis['pickDistrict'] = $('[name="pickDistrict"]').val();
    dataRedis['pickWard'] = $('[name="pickWard"]').val();
    dataRedis['packCode'] = $('[name="packCode"]').val();
    dataRedis['pickupType'] = $('[name="packType"]').val();
    dataRedis['expectShipperPhone'] = $('[name="expectShipperPhone"]').val();
    dataRedis['deliveryPoint'] = deliveryPoint;

    $.ajax({
        url: '/vi/postFormApi',
        type: 'post',
        dataType:'json',
        data: {
            dataRedis: dataRedis
        },
        success: function(res) {
        },
        error: function() {
            //Call Modal Thông báo lỗi
        }
    });
}
function getAllValue(deliveryPointIndex = 1,receiverIndex = 1,productIndex = 1){
    var dataRedis = {};
    var deliveryPoint = [];
    var items = [];
    var receivers = [];
    var extraServices = [];
    
    for (let p = 0; p <deliveryPointIndex; p++) {
            deliveryPoint[p] = {};
            deliveryPoint[p]['receivers'] = {};
            deliveryPoint[p]['address'] = $('[name="deliveryPoint['+(parseInt(p) + 1)+'][address]"]').val();
            deliveryPoint[p]['province'] = $('[name="deliveryPoint['+(parseInt(p) + 1)+'][province]"]').val();
            deliveryPoint[p]['district'] = $('[name="deliveryPoint['+(parseInt(p) + 1)+'][district]"]').val();
            deliveryPoint[p]['ward'] = $('[name="deliveryPoint['+(parseInt(p) + 1)+'][ward]"]').val();

            for (let r = 0; r <receiverIndex; r++) {
                    receivers[r]={};
                    receivers[r]['items'] ={};
                    receivers[r]['extraServices'] ={};
                    receivers[r]['phone'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][phone]"]').val();
                    receivers[r]['name'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][name]"]').val();
                    receivers[r]['length'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][length]"]').val();
                    receivers[r]['weight'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][weight]"]').val();
                    receivers[r]['note'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][note]"]').val();
                    receivers[r]['expectDate'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][expectDate]"]').val();
                    receivers[r]['expectTime'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][expectTime]"]').val();
                    receivers[r]['isFree'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][isFree]"]:checked').val();
                    // receivers[r]['isPorter'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][extraServices][isPorter]"]').val();
                    // receivers[r]['isDoorDeliver'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][extraServices][isDoorDeliver]"]').val();
                    receivers[r]['partialDelivery'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][partialDelivery]"]:checked').val();
                    receivers[r]['isRefund'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][isRefund]"]:checked').val();
                    receivers[r]['requireNote'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][requireNote]"]').val();
                    receivers[r]['extraServices']['isPorter'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][extraServices][isPorter]"]:checked').val();
                    receivers[r]['extraServices']['isDoorDeliver'] = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+ (parseInt(r) + 1)+'][extraServices][isDoorDeliver]"]:checked').val();
                    
                    for (let i = 0; i < productIndex; i++) {
                        items[i] = {};
                        items[i]['productName']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][productName]"]').val();
                        items[i]['productQuantity']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][quantity]"]').val();
                        items[i]['productCod']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][cod]"]').val();
                        items[i]['productValue']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][productValue]"]').val();
                        items[i]['productCategory']  = $('[name="deliveryPoint['+ (parseInt(p) + 1)+'][receivers]['+(parseInt(r) + 1)+'][items]['+(parseInt(i) + 1)+'][category]"]').val();
                    }
                    receivers[r]['items'] = items;
        
            }
            deliveryPoint[p]['receivers'] = receivers;
    }
    dataRedis['pickupAddressId'] = $('[name="pickupAddressId"]').val();
    dataRedis['pickName'] = $('[name="pickName"]').val();
    dataRedis['pickPhone'] = $('[name="pickPhone"]').val();
    dataRedis['pickAddress'] = $('[name="pickAddress"]').val();
    dataRedis['pickProvince'] = $('[name="pickProvince"]').val();
    dataRedis['pickDistrict'] = $('[name="pickDistrict"]').val();
    dataRedis['pickWard'] = $('[name="pickWard"]').val();
    dataRedis['expectShipperPhone'] = $('[name="expectShipperPhone"]').val();
    dataRedis['deliveryPoint'] = deliveryPoint;

    //Update cache
    $.ajax({
        url: '/vi/updateCacheOrder',
        type: 'post',
        dataType:'json',
        data: {
            dataRedis: dataRedis
        },
        success: function(res) {
        },
        error: function() {
            //Call Modal Thông báo lỗi
        }
    });

}