

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
    document.getElementById('result').innerHTML = html;
}
// save from
function saveMenus() {
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
                $(".errphoneName").html(res.data.phoneName);
            }
        },
        error: function () { },
    });
}
// theem moi tk
function addAccount() {
    namePartner = $("#namePartner").val().trim();
    phoneUser = $("#phoneUser").val();
    let checkDataCallApi = 0;
    if (namePartner == "") {
        $(".errNamePartner").html("Vui lòng chọn tên");
        checkDataCallApi = 1;
    } else {
        $(".errNamePartner").html("");
    }
    // if (phoneName == "") {
    //     $(".errPhoneName").html("Vui lòng chọn tài khoản");
    //     checkDataCallApi = 1;
    // } else {
    //     $(".errPhoneName").html("");
    // }
    if (checkDataCallApi == 0) {
        $('#loader').addClass('show');
        $.ajax({
            url: "/callAddAccount",
            type: "post",
            dataType: "json",
            data: {
                idPartner: namePartner,
                userPhone: phoneUser,
                status: 1,
            },
            success: function (res) {
                if (res.success) {
                    // location.reload();
                    window.location.href = '/mon-an/danh-sach-tai-khoan-doi-tac';
                } else {
                    console.log(res.status)
                    if (res.status == 208) {
                        $('#loader').removeClass('show');
                        $('.errNamePartner').html(res.message)
                        $('.errNamePartner').focus();
                    }
                    else if (res.status == 405) {
                        document.getElementById('test').style.visibility = 'visible';
                        document.getElementById('hide_div').style.visibility = 'hidden';
                        $('#loader').removeClass('show');
                        $('#test').removeClass('d-none');
                        $('#editMapperId').val(res.data);
                        console.log($('#editMapperId').val());
                        $('.errCheck').html(res.message).style.width = '500px';
                        $('.errCheck').focus();
                    }
                    else if (res.status == 400) {
                        document.getElementById('test').style.visibility = 'hidden';
                        $('#loader').removeClass('show');
                        $('#editMapperId').val(res.data);
                        console.log($('#editMapperId').val());
                        $('.errCheck').html(res.message).style.width = '500px';
                        $('.errCheck').focus();

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
        },
        error: function () { },
    });
    consle.log(res);
}
// edit lai khi add new user
function editAccount() {
    namePartner = $("#namePartner").val().trim();
    mapperId = $('#editMapperId').val();
    console.log($('#editMapperId').val());
    let checkDataCallApi = 0;
    if (checkDataCallApi == 0) {
        $('#loader').addClass('show');
        $.ajax({
            url: "/editAccount",
            type: "post",
            dataType: "json",
            data: {
                partnerId: namePartner,
                mapperId: mapperId,

            },
            success: function (res) {
                if (res.success) {
                    // location.reload();
                    window.location.href = '/mon-an/danh-sach-tai-khoan-doi-tac';
                } else {
                    console.log(res.status)
                    if (res.status == 208) {
                        $('#loader').removeClass('show');
                        $('.errNamePartner').html(res.message)
                        $('.errNamePartner').focus();
                        location
                    }
                    else if (res.status == 400) {
                        $('#loader').removeClass('show');
                        $('.errCheck').html(res.message).style.width = '500px';
                        $('.errCheck').focus();
                    }
                }
            },
            error: function () {
                location.reload();
            },
        });
        location.reload();
    }


}
// delete
function deletePartner(mapperId) {
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html("<p>Bạn có chắc muốn xóa tài khoản đối tác này?</p>");
    $(".btnDeleteRow").attr(
        "onclick",
        'confirmDeletePartner("' + mapperId + '", 0)'
    );
    $(".btnDeleteRow").html("Xoá");
    $(".btnDeleteRow").removeClass("btn-success");
    $(".btnDeleteRow").addClass("btn-danger");
}
// bat su kien onclick an hien
function myFunction() {
    var show = $('#myInput').val();
    var isShow = !$('#isShowDropdown').val();
    if (isShow) {
        $('#myDropdown').show();
        $('#isShowDropdown').val(isShow);
    } else {
        $('#myDropdown').hide();
        $('#isShowDropdown').val(null);
    }
}
function myCheckDrop() {
    var show = $('#myInput').val();
    if (show) {
        $('#myDropdown').show();
    } else {
        $('#myDropdown').hide();
    }
}
// dropdown danh sach user
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
function fillUserName(userId, userName, phone) {

    document.getElementById("myDropdown").style.display = "none";
    $('#myDropdown').hide();
    var isShow = !$('#isShowClick').val();
    if (isShow) {
        $('#isShowClick').val(isShow);
    } else {
        $('#myDropdown').hide();
        $('#isShowClick').val(null);
    }

    console.log(userId);
    console.log(userName);
    $('#selectedUserId').val(userId);
    $('#myInput').val(phone);
    var userName = userName;
    var html = '';

    html += userName;
    document.getElementById('result').innerHTML = html;
    console.log($('#selectedUserId').val());
}

