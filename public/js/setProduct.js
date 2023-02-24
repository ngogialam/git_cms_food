
$(document).ready(function(){

    $('body').on('change', '.isDefaultAction',function(){
        var key = $(this).attr('key');
        checked = 0;
        $('input.isDefault_' + key  + ':checkbox:checked').each(function() {
            checked = $(this).val();
        });
        if(checked == 1){
            $('.setProductQuantityDiv-'+key).removeClass('col-md-3');
            setTimeout(function() {
                $('.setProductQuantityDiv-'+key).fadeIn("slow").addClass('col-md-1');
            }, 10);

        }else{
            $('.setProductQuantityDiv-'+key).removeClass('col-md-1');
            setTimeout(function() {
                $('.setProductQuantityDiv-'+key).addClass('col-md-3');
            }, 15);
            setTimeout(function() {
                $('.setQuantityDefault-'+key).remove();
            }, 1);
        }
        var html = '';
        html += `<div class="col-md-2 setQuantityDefault-`+key+` rowPadding">`;
            html += `<label for="productPrice">Số lượng mặc định <span style="color: red">(*)</span></label>`;
            html += `<input type="text" name="pack[`+key+`][setQuantityDefault]" class="form-control setQuantityDefault setQuantityDefault-`+key+`" placeholder="Số lượng sản phẩm theo set" value="">`;
            html += `<span class="error_text errSetQuantity errSetQuantity-`+key+`"></span>`;
        html += `<div/>`;

        $('.setProductPriceKeyDiv-'+key).after(html);

    });
    $('body').on('change', '.setProductPrice',function(){
        var key = $(this).attr('key');
        var quantity = $('.setQuantity-'+key).val();
        var priceId = $('.setProductPriceKey-'+key).find(":selected").attr('price');
        console.log(priceId)
        if(quantity != '' && quantity != 0){
            var totalMoney = parseInt(quantity) * parseInt(priceId);   
            $('.totalMoney-'+key).val(String(totalMoney).replace(/(.)(?=(\d{3})+$)/g, '$1,'));
            $('.totalMoneyPost-'+key).val(totalMoney)
            setTimeout(function(){
                changeTotalMoney();
            },10)
        }
    });
    $('body').on('change', '.setQuantity',function(){
        var key = $(this).attr('key');
        var priceId = $('.setProductPriceKey-'+key).find(":selected").attr('price');
        console.log(typeof priceId)
        console.log(key)
        if(typeof priceId !== 'undefined'){
            var quantity = $('.setQuantity-'+key).val();
            var totalMoney = parseInt(quantity) * parseInt(priceId);   
            $('.totalMoney-'+key).val(String(totalMoney).replace(/(.)(?=(\d{3})+$)/g, '$1,'));
            $('.totalMoneyPost-'+key).val(totalMoney)
            setTimeout(function(){
                changeTotalMoney();
            },10)
        }

    });
    
    $('body').on('click','.removeProductPlus',function() {
        var total = $('.setProductPlusItem').length
        console.log(total)
        if(total > 1){
            $(this).parent().parent().remove();
        }else{
            alert('Cần ít nhất 1 sản phẩm')
            $('.productPlus').val('');
            $('.productPlus').trigger("chosen:updated");
            $('.pricePlus').val('0');
        }
    });

    $('.addSetProductPlus').click(function() {
        var total = $('.setProductPlusItem').length
        $.ajax({
            url: '/addProductToSet',
            type: 'post',
            dataType: 'json',
            data: {
                'total':total
            },
            success: function(res){
                console.log(res)
                if(res.success){
                    $('.addSetProductPlus').attr('count', (total+1));
                    $('.setProductPlusItem:last').after(res.data);
                    $('.setProductPlus').chosen();
                    $('.setProductPrice').chosen();
                }else{
                }
            },
            error: function(){
                
            }
        });
    });

    $('.setName').change(function(){
        var setName = $('.setName').val();
        $.ajax({
            url: '/checkExistProductName',
            type: 'post',
            dataType: 'json',
            data: {
                'checkExistProductName': setName
            },
            success: function(res) {
                if (res.success) {
                    $('.errSetName').html('');
                    $('.saveSetProduct').removeAttr("disabled");
                }else{
                    $('.errSetName').html('Tên set đã tồn tại');
                }
            },
            error: function(res) {
                console.log(12345)
            }
        });
    })
    // $('.setProductPlus').change(function(){
    $('.main-panel').on('change','.setProductPlus',function() {
        var productId = $(this).val();
        var key = $(this).attr('key');
        $.ajax({
            url: '/set-san-pham/lay-quy-cach-set',
            type: 'post',
            dataType: 'json',
            data: {
                'productId':productId
            },
            success: function(res){
                if(res.success){
                    $('.setProductPriceKey-'+key).html(res.data);
                    $('.setProductPriceKey-'+key).trigger("chosen:updated");
                }else{
                }
            },
            error: function(){
                
            }
        });
    });
    $('input[type=radio][name=typePromotion]').change(function() {
        var value = this.value;
        console.log(value)
        if(value == 2 ){
            $('.productName').addClass('displayNone');
            $('.wrapperProductSet').removeClass('displayNone');
            $('.btnAddProductSet').removeClass('displayNone');
        }else{
            $('.productName').removeClass('displayNone');
            $('.wrapperProductSet').addClass('displayNone');
            $('.btnAddProductSet').addClass('displayNone');
        }
    });
    $('.addProductSetPlus').click(function() {
        var total = $('.setProductPlusItem').length
        $.ajax({
            url: '/addSetProductPromotion',
            type: 'post',
            dataType: 'json',
            data: {
                'total':total
            },
            success: function(res){
                if(res.success){
                    $('.addProductSetPlus').attr('count', (total+1));
                    $('.setProductPlusItem:last').after(res.data);
                    $('.setProductPlus').chosen();
                    $('.measureSet').chosen();
                }else{
                }
            },
            error: function(){
                
            }
        });
        
    });

    $('.addProductPlusForSet').click(function() {
        var total = $('.productPlusItem').length
        $.ajax({
            url: '/khuyen-mai/them-san-pham-set-tang-kem',
            type: 'post',
            dataType: 'json',
            data: {
                'total':total
            },
            success: function(res){
                if(res.success){
                    $('.addProductPlusForSet').attr('count', (total+1));
                    $('.productPlusItemSet:last').after(res.data);
                    $('.productSetPlus').chosen();
                    $('.productSetPrice').chosen();
                }else{
                }
            },
            error: function(){
                
            }
        });
        
    });

    $('.modal-body').on('change','.productSetPlus',function() {
        var productId = $(this).val();
        var key = $(this).attr('key');
        $.ajax({
            url: '/khuyen-mai/lay-quy-cach',
            type: 'post',
            dataType: 'json',
            data: {
                'productId':productId,
                'type': 1
            },
            success: function(res){
                if(res.success){
                    $('.productSetPriceKey-'+key).html(res.data);
                    $('.productSetPriceKey-'+key).trigger("chosen:updated");
                }else{
                }
            },
            error: function(){
                
            }
        });
    });

});

function addSetPromotion(){
    $('#addSetPromotion').modal('show');
    $('.modal-title').html('Thêm khuyến mãi cho set');
    $('.saveSetPromotion').html('Thêm khuyến mãi cho set');
    $(".saveSetPromotion").attr("onclick", 'saveSetPromotion()');
}

function saveSetPromotion(){

    let promotion = new Array();
    promotion['namePromotion']  = $('.namePromotionSet').val();
    promotion['limitApply']     = $('.limitApplySet').val();
    promotion['quantityMax']    = $('.quantityMaxSet').val();
    promotion['started']        = $('.startedSet').val();
    promotion['stoped']         = $('.stopedSet').val();
    promotion['status']         = $('.statusSet').val();

    var countProduct = $('.addProductPlusForSet').attr('count');
    let i = 0;
    let arrPlus = new Array();
    var error = 0;
    do {
        if($('.productSetPlusKey-'+i).val() && $('.productSetPriceKey-'+i).val()){
            let item = new Array();
            item['productPlus']     = $('.productSetPlusKey-'+i).val();
            item['productPrice']    = $('.productSetPriceKey-'+i).val();
            // item['pricePlus']       = $('.priceSetPlusKey-'+i).val();
            item['quantity']        = $('.quantitySetKey-'+i).val();
            arrPlus[i] = Object.assign({}, item);
        }else{
            error = 1;
            if($('.productSetPlusKey-'+i).val() == ''){
                $('.errProductPlus-'+i).html('Sản phẩm tặng kèm không được để trống');
            }
            if($('.productSetPriceKey-'+i).val() == '' || $('.productSetPriceKey-'+i).val() == null){
                $('.errProductPrice-'+i).html('Quy cách đóng gói không được để trống');
            }
            if($('.quantitySetKey-'+i).val() == '' || $('.quantitySetKey-'+i).val() == null){
                $('.errQuantity-'+i).html('Số lượng không được để trống');
            }
            // if($('.pricePlusKey-'+i).val() == '' || $('.pricePlusKey-'+i).val() == null){
            //     $('.errPricePlus-'+i).html('Giá không được để trống');
            // }
        }
        i = i + 1;
    }while (i < countProduct);
    promotion['arrPlus'] = Object.assign({}, arrPlus);

    var countProduct = $('.addProductSetPlus').attr('count');
    console.log(countProduct)
    let j = 0;
    let arrPlusSet = new Array();
    do {
        if($('.setProductPlusKey-'+j).val() && $('.measureSet-'+j).val() && $('.conditionSet-'+j).val()){
            let item = new Array();
            item['setProductPlusKey']     = $('.setProductPlusKey-'+j).val();
            item['measureSet']    = $('.measureSet-'+j).val();
            item['conditionSet']       = $('.conditionSet-'+j).val();
            arrPlusSet[j] = Object.assign({}, item);
        }else{
            error = 1;
            console.log('j:' + j)
            if($('.setProductPlusKey-'+j).val() == ''){
                $('.errSetProductPlus-'+j).html('Sản phẩm không được để trống');
            }
            if($('.measureSet-'+j).val() == '' || $('.measureSet-'+j).val() == null){
                $('.errMeasureSet-'+j).html('Đơn vị tính để trống');
            }
            if($('.conditionSet-'+j).val() == '' || $('.quantitySetKey-'+j).val() == null){
                $('.errConditionSet-'+j).html('Điều kiện không được để trống');
            }
        }
        j = j + 1;
    }while (j < countProduct);
    promotion['arrPlusSet'] = Object.assign({}, arrPlusSet);

    if(error == 0){
        $.ajax({
            url: '/khuyen-mai/tao-set-khuyen-mai',
            type: 'post',
            dataType: 'json',
            data: {
                'promotion':Object.assign({}, promotion)
            },
            success: function(res){
                if(res.success){
                    location.reload();
                }else{
                    $('.errProducts').html(res.data.productId);
                    $('.errNamePromotion').html(res.data.namePromotion);
                    $('.errCondition').html(res.data.condition);
                    $('.errStarted').html(res.data.started);
                    $('.errStoped').html(res.data.stoped);
                }
            },
            error: function(){
                // location.reload();
            }
        });
    }
}

function changeTotalMoney(){
    var countProduct = $('.setProductPlusItem').length
    let i = 0;
    let totalMoney = 0;
    do {
        money = $('.totalMoney-'+i).val().replace(/\,/g, '');
        
        if(money != 0 && money!=''){
            totalMoney += parseInt(money);
            $('.setPrice').val(String(totalMoney).replace(/(.)(?=(\d{3})+$)/g, '$1,'))
        }
        i = i + 1;
    }while (i < countProduct);
}