

function checkPhone() {
    var phoneName = $('.phoneName').val();
    $('.saveMenus').attr('disabled', 'disabled');
    $.ajax({
        url: '/getAutoComplete',
        type: 'get',
        dataType: 'json',
        data: {
            'phone': phoneName,
        },
        success: function (res) {
            if (res.success) {
                $('.errphoneName').html('');
                $('.saveMenus').removeAttr("disabled");
            } else {
                $('.errphoneName').html('Tên  đã tồn tại');
            }
        },
        error: function (res) {
            console.log(12345)
        }
    });
}
// validate selectbox
function validateSelectBox(obj) {

    var options = obj.children;
    var html = '';
    for (var i = 0; i < options.length; i++) {
        if (options[i].selected) {
            html += '<li>' + options[i].value + '</li>';
        }
    }
    // console.log($('listUsers').val());
    document.getElementById('result').innerHTML = html;
}
// save from
function saveMenus() {
    // $('#selectedUserId').val(userId);
    var idPartner = $(".idPartner").val();
    var idAppUser = $(".idAppUser").val();
    var status = $(".status").val();

    $.ajax({
        url: "/callAddAccount",
        type: "post",
        dataType: "json",
        data: {
            idPartner: idPartner,
            idAppUser: idAppUser,
            status: status,
        },
        success: function (res) {
            if (res.success) {
                consle.log(res);
                location.reload();
                // return;
            } else {
                // console.log(res.data.nameCate);
                $(".errphoneName").html(res.data.phoneName);
            }
        },
        error: function () { },
    });
}
// theem moi tk
function addAccount() {
    console.log($("#selectedUserId").val());    
    namePartner = $("#namePartner").val().trim();
    phoneName = $("#selectedUserId").val();
    let checkDataCallApi = 0;
    if (namePartner == "") {
        $(".errNamePartner").html("Vui lòng chọn tên");
        checkDataCallApi = 1;
    } else {
        $(".errNamePartner").html("");
    }
    if (phoneName == "") {
        $(".errPhoneName").html("Vui lòng chọn tài khoản");
        checkDataCallApi = 1;
    } else {
        $(".errPhoneName").html("");
    }
    if (checkDataCallApi == 0) {
        $('#loader').addClass('show');
        $.ajax({
            url: "/callAddAccount",
            type: "post",
            dataType: "json",
            data: {
                idPartner: namePartner,
                idAppUser: phoneName,
                status: 1,
            },
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    console.log(res.status)
                    if (res.status == 208) {
                        $('#loader').removeClass('show');
                        $('.errNamePartner').html(res.message)
                        $('.errNamePartner').focus();
                    }
                }
            },
            error: function () {
                location.reload();
            },
        });
    }
}
// ham delete
function confirmDeletePartner(mapperId) {
    $.ajax({
        url: "/deletePartner",
        type: "post",
        dataType: "json",
        data: {
            mapperId: mapperId,
        },
        success: function (res) {
            location.reload();
            // console.log(res);        
        },
        error: function () { },
    });
    consle.log(res);
}
// delete
function deletePartner(mapperId) {
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html("<p>Bạn có chắc xoá user?</p>");
    $(".btnDeleteRow").attr(
        "onclick",
        'confirmDeletePartner("' + mapperId + '", 0)'
    );
    $(".btnDeleteRow").html("Xoá");
    $(".btnDeleteRow").removeClass("btn-success");
    $(".btnDeleteRow").addClass("btn-danger");
}
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}
function fillUserName(userId, userName, phone){
    console.log(userId);
    console.log(userName);    
    $('#selectedUserId').val(userId);
    $('#myInput').val(phone);
    var userName = userName;
    var html = '';
   
    html +=   userName  ;
    document.getElementById('result').innerHTML = html;
    console.log($('#selectedUserId').val());
}