
function activeRowReviewAll(){
    var ids = '';
    var totalItem = $('.checkSingle:checked').length;
    $('.checkSingle:checked').each(function() {
        ids += $(this).val() + ',';
    });
    if (totalItem <= 0) {
        setTimeout(function() {
            alert('Bạn chưa chọn đánh giá nào để hiển thị')
        }, 400);
    }else{
        var idsNew = ids.slice(0, -1);
        $('#confirmDeleteRow').modal('show');
        $('.confirmBody').html('<p>Bạn có chắc hiển thị đánh giá?</p>');
        $('.btnDeleteRow').attr('onclick', 'confirmDisableRowReview("'+idsNew+'", 1)');
        $('.btnDeleteRow').html('Đồng ý');
        $('.btnDeleteRow').addClass('btn-success');
        $('.btnDeleteRow').removeClass('btn-danger');
    }
}

function disableRowReviewAll(){
    var ids = '';
    var totalItem = $('.checkSingle:checked').length;
    $('.checkSingle:checked').each(function() {
        ids += $(this).val() + ',';
    });
    if (totalItem <= 0) {
        setTimeout(function() {
            alert('Bạn chưa chọn đánh giá nào để xoá')
        }, 400);
    }else{
        var idsNew = ids.slice(0, -1);
        $('#confirmDeleteRow').modal('show');
        $('.confirmBody').html('<p>Bạn có chắc xoá đánh giá?</p>');
        $('.btnDeleteRow').attr('onclick', 'confirmDisableRowReview("'+idsNew+'", 0)');
        $('.btnDeleteRow').html('Xoá');
        $('.btnDeleteRow').removeClass('btn-success');
        $('.btnDeleteRow').addClass('btn-danger');
    }
}
function getReviews(id, url_img){
    $('#addReviews').modal('show');
    $.ajax({
        url: '/danh-gia/sua-danh-gia',
        type: 'post',
        dataType: 'json',
        data: {
            'id':id,
            'getData': 1
        },
        success: function(res){
            if(res.success){
                let scoreEdit = res.data.score;

                if(scoreEdit > 0 && scoreEdit < 20){
                    $(".score-1").prop("checked", true);
                }else if(scoreEdit >= 20 && scoreEdit < 40){
                    $(".score-2").prop("checked", true);
                }else if(scoreEdit > 40 && scoreEdit < 60){
                    $(".score-3").prop("checked", true);
                }else if(scoreEdit > 60 && scoreEdit < 80){
                    $(".score-4").prop("checked", true);
                }else{
                    $(".score-5").prop("checked", true);
                }

                // reviewImg
                if(res.data.imageVote){
                    $("#reviewImg").attr("src",url_img + res.data.imageVote);
                    $("#reviewImg").width("150");
                    $(".inputImgBs").val(res.data.imageVote);
                }else{
                    $("#reviewImg").attr("src", "/public/images_kho/btn-add-img.svg");
                    $("#reviewImg").width("70");
                }

                $('.myModalLabel').html('Sửa đánh giá');
                $('.saveReviews').html('Sửa đánh giá');
                $('.comment').val(res.data.commentReview);
                $('.product').html(res.htmlOptions);
                $('.product').trigger("chosen:updated");
                if(res.data.statusReview == 1){
                    $(".statusYes").attr("selected", 'selected');
                }else{
                    $(".statusYes").removeAttr("selected", 'selected');
                }
                $('.statusReviews').trigger("chosen:updated");

                if(res.data.isShow == 1){
                    $(".isShowYes").attr("selected", 'selected');
                }else{
                    $(".isShowYes").removeAttr("selected", 'selected');
                }
                $('.isShow').trigger("chosen:updated");

                $(".saveReviews").attr("onclick", 'editReviews('+res.data.id+')');
            }else{
                $('#addMethods').modal('hide');
            }
        },
        error: function(){
            
        }
    });
}

function disableReviews(id){
    $('#confirmDeleteRow').modal('show');
    $('.confirmBody').html('<p>Bạn có chắc xoá đánh giá?</p>');
    $('.btnDeleteRow').attr('onclick', 'confirmDisableRowReview("'+id+'", 0)');
    $('.btnDeleteRow').html('Xoá');
    $('.btnDeleteRow').removeClass('btn-success');
    $('.btnDeleteRow').addClass('btn-danger');
}

function confirmDisableRowReview(idReview, status){
    $.ajax({
        url: '/danh-gia/xoa-danh-gia',
        type: 'post',
        dataType: 'json',
        data: {
            'id':idReview,
            'status': status
        },
        success: function(res){
            // console.log(res);
            location.reload();
        },
        error: function(){
            
        }
    });
}