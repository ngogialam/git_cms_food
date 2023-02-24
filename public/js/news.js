$(document).ready(function(){
    

    $('.newsTitle').change(function(){
        var newsTitle = $('.newsTitle').val();
        $.ajax({
            url: '/checkExistNewsTitle',
            type: 'post',
            dataType: 'json',
            data: {
                'newsTitle': newsTitle
            },
            success: function(res) {
                if (res.success) {
                    $('.errNewsTitle').html('');
                    $('.btnAddNewsCook').removeAttr("disabled");
                }else{
                    $('.errNewsTitle').html('Tên bài viết đã trùng');
                }
            },
            error: function(res) {
            }
        });
    })

});
function showModalNews(){
    $('#newsTitle').val('');
    sapoNews.setData('');
    contentNews.setData('');
    $("#newsThumbnailImg").addClass("w-100");
    $("#newsThumbnailImg").attr("src",'/public/images_kho/btn-add-img.svg');
    $('#cooking-modal').modal('show');
}
function addNewsCook(){
    var newsTitle = $('.newsTitle').val();
    var newsSapo = sapoNews.getData();
    var newsContent = contentNews.getData();
    var newsThumbnail = $('.imgThumbnailNews').val();
    var error = 0;
    if(newsTitle == ''){
        error = 1;
        $('.errNewsTitle').html('Tên bài viết không được để trống.');
    }
    if(newsSapo == ''){
        error = 1;
        $('.errNewsSapo').html('Sapo bài viết không được để trống.');
    }
    if(newsContent == ''){
        error = 1;
        $('.errNewsContent').html('Nội dung bài viết không được để trống.');
    }
    if(newsThumbnail == ''){
        error = 1;
        $('.err_newsThumbnailErr').html('Ảnh tiêu đề không được để trống.');
    }

    if(error == 0){
        $.ajax({
            url: '/tin-tuc/them-tin-tuc',
            type: 'post',
            dataType: 'json',
            data: {
                'newsTitle':newsTitle,
                'newsSapo':newsSapo,
                'newsContent':newsContent,
                'newsThumbnail':newsThumbnail,
                'ajax' : 1
            },
            success: function(res){
                console.log(res.html);
                if(res.success){
                    $('.cooking-select').html(res.html);
                    $('.cooking-select').trigger("chosen:updated");
                    $('#cooking-modal').modal('hide');
                }else{
                }
            },
            error: function(){
                
            }
        });
    }
}

function removeNews(newsId){
    $('#confirmDRemoveNews').modal('show');
    $('.btnRemoveNews').attr('onclick', 'confirmRemoveNews('+newsId+')')
}

function confirmRemoveNews(newsId){
    $.ajax({
        url: '/tin-tuc/xoa-tin-tuc',
        type: 'post',
        dataType: 'json',
        data: {
            'newsId':newsId,
        },
        success: function(res){
            console.log(res);
            location.reload();
        },
        error: function(){
            
        }
    });
}