$(document).ready(function(){
    $(".sizebox").change(function() {
        sizeBox = $("#sizeBox option:selected").val();
        var countTotalItems = $('.countTotalItems').val();
        var countTotalItemsScaned = $('.countTotalItemsScaned').val();
        // if(countTotalItems == countTotalItemsScaned && sizeBox != 0 ){
        if( sizeBox != 0 ){
            $(".btn-confirmPrepare").removeAttr('disabled');
            var orderCode = $('.orderCode').val();
            $(".btn-confirmPrepare").attr("onclick", 'submitPackageOrder('+orderCode+','+sizeBox+',2)');
        }
    });
});

$('.prepareOrderQR').focus();
function prepareOrderQR(orderId){
    var prepareOrderQR = $('.prepareOrderQR').val();
    // $('input[name=typeProduct]:checked').each(function() {
    //     typeProduct = $(this).val();
    // });
    $('#loader').addClass('show');
    $.ajax({
        url: '/don-hang/prepareOrderWeight',
        type: 'post',
        dataType: 'json',
        data: {
            'prepareOrderQR':prepareOrderQR,
            'orderId':orderId,
            // 'typeProduct':typeProduct,
        },
        success: function(res){
            // window.location = res.href;
            $('#loader').removeClass('show');
            if(res.success){
                $('#loader').removeClass('show');
                var checkClass = $('tr').hasClass('qrItem');
                if(checkClass){
                    $('.qrItem:first').before(res.html);
                }else{
                    $('.appendPrepareOrder').append(res.html);
                }
                $('.prepareOrderQR').focus();
                var totalItem = $('.totalItems').html();
                var countTotalItemsScaned = $('.countTotalItemsScaned').val();
                var newTotalItems = parseInt(countTotalItemsScaned) + 1;
                $('.scanedQR').html(newTotalItems);
                $('.countTotalItemsScaned').val(newTotalItems);
                sizeBox = $("#sizeBox option:selected").val()
                // if(totalItem == newTotalItems && sizeBox != 0){
                if(sizeBox != 0){
                    $(".btn-confirmPrepare").removeAttr('disabled');
                    var orderCode = $('.orderCode').val();
                    $(".btn-confirmPrepare").attr("onclick", 'submitPackageOrder('+orderCode+','+sizeBox+',2)');
                }
            }else{
                $('#loader').removeClass('show');
                $('.notificationMessage').html(res.message)
                $('.notificationMessage').addClass('notification-danger notification');
                $(".notification-container").fadeIn();
                // Set a timeout to hide the element again
                setTimeout(function() {
                    $(".notification-container").fadeOut();
                }, 5000);
            }
        },
        error: function(res){
            $('#loader').removeClass('show');
        }
    });
    $('.prepareOrderQR').val('');
}
function submitPackageOrder(orderCode, boxId,type = 1){
    $('#loader').addClass('show');
    $.ajax({
        url: '/don-hang/wrapperOrderQR',
        type: 'post',
        dataType: 'json',
        data: {
            'orderCode':orderCode,
            'boxId':boxId,
            'type':type,
        },
        success: function(res){
            if(res.success){
                console.log(res)
                if(res.status == 200){
                    let timeout = 1500;
                    $('#theModalPrint').modal('show').find('#printTable').load(res.printUrl);
                    $('.barcodePrint75').val('');
                    $('.barcodePrint75').focus();
                    setTimeout(function(){
                        printDataOnlyExport();
                    }, timeout);
                    $('#loader').removeClass('show');
                    $('#theModalPrint').modal('hide')
                    setTimeout(function(){
                        window.location.href = res.href;
                    }, 3000);
                }else{
                    location.reload();
                }
            }else{
                window.location.href = res.href;
            }
        },
        error: function(){
            $('#loader').removeClass('show');
        }
    });
}

function printExportOnly(urlPrint){
    $('#theModalPrint').modal('show').find('#printTable').load(urlPrint);
    setTimeout(function(){
        printOnly();
    }, 1500);
    $('#theModalPrint').modal('hide')
}
function printOnly(){
    var divToPrint=document.getElementById("printTable");
    newWin= window.open("");
    newWin.document.write(divToPrint.outerHTML);
    setTimeout(function(){
        newWin.print();
        newWin.close();

        $("LINK[href*='print75.css']").remove();
            // window.location.href = res.href;
            location.reload();
        // $(".barcodePrint75").focus();
    }, 200);
}
function printDataOnlyExport(){
    // $(".print_order").focus();
    var divToPrint=document.getElementById("printTable");
    newWin= window.open("");
    newWin.document.write(divToPrint.outerHTML);
    setTimeout(function(){
        newWin.print();
        newWin.close();
$('#loader').modal('hide');
        $("LINK[href*='print75.css']").remove();
            // window.location.href = res.href;
            // location.reload();
        // $(".barcodePrint75").focus();
    }, 200);
}

function removePrepareProduct(idPrepare, orderCode){
    $.ajax({
        url: '/don-hang/deleteItemInOrder',
        type: 'post',
        dataType: 'json',
        data: {
            'idPrepare':idPrepare,
            'orderCode':orderCode
        },
        success: function(res){
            location.reload();
            // if(res.success){
            //     $('.prepare-'+idPrepare).remove();
            // }
        },
        error: function(){
        }
    });
}