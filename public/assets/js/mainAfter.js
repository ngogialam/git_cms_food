$(document).ready(function() { //Validate Account Info
    $('body').on('change', '.fullName', function() {
        fullName = $('.fullName').val();
        if (fullName.length == 0) {
            $('.err_fullName').html('Họ và tên đầy đủ không được để trống');
        } else if (fullName.length < 4) {
            $('.err_fullName').html('Họ và tên không hợp lệ');
        } else {
            $('.err_fullName').html('');
        }
    });
    $('body').on('change', '.company', function() {
        company = $('.company').val();
        if (company.length == 0) {
            $('.err_shopName').html('Tên cửa hàng không được để trống');
        } else {
            $('.err_shopName').html('');
        }
    });

    $('body').on('change', '.email', function() {
        email = $('.email').val();
        checkEmail = validateEmail(email);
        if (email.length == 0) {
            $('.err_email').html('Email không được để trống');
        } else if (checkEmail == false) {
            $('.err_email').html('Email không hợp lệ');
        } else {
            $('.err_email').html('');
        }
    });
    $('body').on('change', '.address', function() {
        address = $('.address').val();
        if (address.length == 0) {
            $('.err_address').html('Địa chỉ chi tiết không được để trống');
        } else {
            $('.err_address').html('');
        }
    });
    $('body').on('change', '.dob', function() {
        dob = $('.dob').val();
        if (dob.length == 0) {
            $('.err_dob').html('Ngày sinh không được để trống');
        } else {
            $('.err_dob').html('');
        }
    });
    $('body').on('change', '.sex', function() {
        sex = $('.sex').val();
        if (sex.length == 0) {
            $('.err_sex').html('Giới tính không được để trống');
        } else {
            $('.err_sex').html('');
        }
    });

    $('body').on('change', '.ward_code_from', function() {
        ward_code_from = $('.ward_code_from').val();
        if (ward_code_from.length == 0) {
            $('.err_ward').html('Phường/Xã không được để trống');
        } else {
            $('.err_ward').html('');
        }
    });

    $('body').on('change', '.cid', function() {
        cid = $('.cid').val();
        if (cid.length == 0) {
            $('.err_cid').html('Số căn cước/CMND không được để trống');
        } else if (cid.length < 9) {
            $('.err_cid').html('Số căn cước/CMND không hợp lệ');
        } else if (cid.length > 12) {
            $('.err_cid').html('Số căn cước/CMND không hợp lệ');
        } else {
            $('.err_cid').html('');
        }
    });

    $('body').on('change', '.cidDate', function() {
        cidDate = $('.cidDate').val();
        if (cidDate.length == 0) {
            $('.err_cidDate').html('Ngày cấp không được để trống');
        } else {
            $('.err_cidDate').html('');
        }
    });

    $('body').on('change', '.cidPlace', function() {
        cidPlace = $('.cidPlace').val();
        if (cidPlace.length == 0) {
            $('.err_cidPlace').html('Nơi cấp không được để trống');
        } else {
            $('.err_cidPlace').html('');
        }
    });

    //Warehouse Validate
    $('body').on('blur', '.warehouseName', function() {
        warehouseName = $('.warehouseName').val();
        if (warehouseName.length == 0) {
            $('.err_warehouseName').html('Tên kho hàng không được để trống');
        } else {
            $('.err_warehouseName').html('');
        }
    });
    $('body').on('blur', '.senderName', function() {
        senderName = $('.senderName').val();
        if (senderName.length == 0) {
            $('.err_senderName').html('Đầu mối liên hệ lấy hàng không được để trống');
        } else if (senderName.length <= 4) {
            $('.err_senderName').html('Đầu mối liên hệ lấy hàng không hợp lệ');
        } else {
            $('.err_senderName').html('');
        }
    });

    $('body').on('blur', '.senderPhone', function() {
        senderPhone = $('.senderPhone').val();
        // console.log(   senderPhone)
        if (senderPhone == '') {
            $('.err_senderPhone').html('Số điện thoại không được bỏ trống');
        } else {
            checkSenderPhone = validatePhone(senderPhone);
            if (!checkSenderPhone) {
                $('.err_senderPhone').html('Số điện thoại không hợp lệ');
            } else {
                $('.err_senderPhone').html('');
            }
        }
    });
    $('body').on('blur', '.addressWarehouse', function() {
        addressWarehouse = $('.addressWarehouse').val();
        if (addressWarehouse.length == 0) {
            $('.err_addressWarehouse').html('Địa chỉ chi tiết không được để trống');
        } else {
            $('.err_addressWarehouse').html('');
        }
    });

    //Validate bank COD
    // $('body').on('change', '.bankCode',function(){
    //     bankCode = $('.bankCode').val();
    //     if(bankCode.length == 0){
    //         $('.err_bankCode').html('Ngân hàng không được để trống.');
    //     }else{
    //         $('.err_bankCode').html('');
    //     }
    // });
    $('body').on('change', '.bankCode', function() {
        bankCode = $('.bankCode').val();
        if (bankCode.length == 0) {
            $('.err_bankCode').html('Ngân hàng không được để trống');
        } else {
            $('.err_bankCode').html('');
        }
    });

    $('body').on('blur', '.accountName', function(e) {
        accountName = $('.accountName').val();
        unUnicode = removeAccents(accountName);
        if (accountName.length == 0) {
            $('.err_accountName').html('Tên chủ tài khoản không được để trống');
        } else if (accountName.length < 4) {
            $('.err_accountName').html('Tên chủ tài khoản không hợp lệ');
        } else {
            $('.err_accountName').html('');
        }
        $('.accountName').val(unUnicode);
    });
    $('body').on('blur', '.accountNumber', function() {
        accountNumber = $('.accountNumber').val();
        if (accountNumber.length == 0) {
            $('.err_accountNumber').html('Vui lòng nhập số tài khoản/ số thẻ');
        } else if (accountNumber.length < 9 || accountNumber.length > 20) {
            $('.err_accountNumber').html(' Số tài khoản/số thẻ không hợp lệ');
        } else {
            $('.err_accountNumber').html('');
        }
    });

    //Rút tiền
    $('body').on('blur', '.NumberWithDraw', function() {
        NumberWithDraw = parseInt($('.NumberWithDraw').val().replaceAll(',', ''), 10);
        remainBalance = parseInt($('.remainBalance').val(), 10);
        if (digits_count(NumberWithDraw) == 0) {
            $('.err_NumberWithDraw').html('Vui lòng nhập số tiền muốn rút');
        } else if (remainBalance < NumberWithDraw) {
            $('.err_NumberWithDraw').html('Số tiền muốn rút vượt quá số dư có thể rút');
        } else {
            $('.err_NumberWithDraw').html('');
        }
    });
    $('body').on('click', '.AccountNumber', function() {
        AccountNumber = $('input[name="bankId"]:checked').val();
        if (AccountNumber.length == 0) {
            $('.err_AccountNumber').html('Vui lòng nhập số tiền muốn rút');
        } else {
            $('.err_AccountNumber').html('');
        }
    });
});

function removeAccents(str) {
    var AccentsMap = [
        "aàảãáạăằẳẵắặâầẩẫấậ",
        "AÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬ",
        "dđ", "DĐ",
        "eèẻẽéẹêềểễếệ",
        "EÈẺẼÉẸÊỀỂỄẾỆ",
        "iìỉĩíị",
        "IÌỈĨÍỊ",
        "oòỏõóọôồổỗốộơờởỡớợ",
        "OÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢ",
        "uùủũúụưừửữứự",
        "UÙỦŨÚỤƯỪỬỮỨỰ",
        "yỳỷỹýỵ",
        "YỲỶỸÝỴ"
    ];
    for (var i = 0; i < AccentsMap.length; i++) {
        var re = new RegExp('[' + AccentsMap[i].substr(1) + ']', 'g');
        var char = AccentsMap[i][0];
        str = str.replace(re, char);
    }
    return str;
}

function generateZeroNumber(amount, number) {
    let min = 5;
    let max = 8;
    let multiZeroMin = parseInt(min) - parseInt(number);
    let multiZeroMax = parseInt(max) - parseInt(number);
    let arrayHintAmount = [];
    let j = 1;
    if ((max - number) >= 0) {
        for (i = multiZeroMin; i <= multiZeroMax; i++) {
            for (k = 0; k <= (i); k++) {
                j += '0';
            }
            thousand = parseInt(amount) * parseInt(j);
            let format = String(thousand).replace(/(.)(?=(\d{3})+$)/g, '$1,');
            arrayHintAmount.push(format);
            if (i < 0) {
                arrayHintAmount.splice(0);
            }
            j = 1
        }
    }
    return arrayHintAmount;
}

function digits_count(n) {
    var count = 0;
    if (n >= 1) ++count;

    while (n / 10 >= 1) {
        n /= 10;
        ++count;
    }
    return count;
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validatePhone(phone) {
    let number = phone;
    if (/(0[0])+([0-9]{9})\b/.test(number)) {
        return false;
    } else if (!/^[0-9]+$/.test(number)) {
        return false;
    } else if (!/(0[2|3|5|7|8|9])+([0-9]{8})\b|(\+84)+([0-9]{9})\b|(0[2])+([0-9]{9})\b/.test(number)) {
        return false;
    }
    return true;
}

function clickAddImage() {
    document.getElementById('imageFile').click();
}

var typingTimer; //timer identifier
var doneTypingInterval = 500; //time in ms, 5 second for example
function generateNumberAmount() {
    NumberWithDraw = parseInt($('.NumberWithDraw').val());
    length = digits_count(NumberWithDraw);
    clearTimeout(typingTimer);
    if (NumberWithDraw) {
        typingTimer = setTimeout(function() {
            //do stuff here e.g ajax call etc....
            NumberWithDraw = String(NumberWithDraw).replace(/(.)(?=(\d{3})+$)/g, '$1,');;
            if (NumberWithDraw != 'NaN') {
                $('#NumberWithDraw').val(NumberWithDraw)
            }
        }, doneTypingInterval);
    }
    // autocomplete(document.getElementById("NumberWithDraw"), amountHint);
}

function chooseFile() {
    document.getElementById("chooseFile").click();
}

function change(e) {
    const image = event.target.files[0];
    document.getElementById('chooseFileOK').value = event.target.files[0].name
    const reader = new FileReader();
    reader.readAsDataURL(image);
    reader.onload = (e) => {
        this.avatarDefault = e.target.result;
    };
}

function ordersError() {
    //Nút đơn lỗi => chuyển qua màu đỏ
    document.getElementById("qo-doi-mau-red").style.border = "0.5px solid #D46F6F";
    document.getElementById("qo-doi-mau-red").style.color = "#D46F6F";
    document.getElementById("qo-doi-mau-vang").style.border = "0.5px solid #D8D8D8";
    document.getElementById("qo-doi-mau-vang").style.color = "#8D869D";

}

function ordersDoubts() {
    //Nút đơn nghi vấn => chuyển qua màu vàng
    document.getElementById("qo-doi-mau-vang").style.border = "0.5px solid #F0A616";
    document.getElementById("qo-doi-mau-vang").style.color = "#F0A616";
    document.getElementById("qo-doi-mau-red").style.border = "0.5px solid #D8D8D8"
    document.getElementById("qo-doi-mau-red").style.color = "#8D869D";

}


function btnDefau() {
    document.getElementById("qo-doi-mau-vang").style.border = "0.5px solid #D8D8D8";
    document.getElementById("qo-doi-mau-vang").style.color = "#8D869D";
    document.getElementById("qo-doi-mau-red").style.border = "0.5px solid #D8D8D8"
    document.getElementById("qo-doi-mau-red").style.color = "#8D869D";

}



// =========Tắt  hiển thị chỉnh sửa================ 
function outEdit(a, b) {
    document.getElementsByClassName(a)[0].style.display = "none";
    document.getElementById(b).style.display = "flex";
}


function showInfoConfirm(id, images) {
    document.getElementById(id).style.display = "flex";
    document.getElementsByClassName(images)[0].style.display = "none";
    document.getElementsByClassName(images + 'a')[0].style.display = "block";

}

function defaultInfoConfirm(id, images) {
    console.log(images)
    document.getElementById(id).style.display = "none";
    document.getElementsByClassName(images)[0].style.display = "block";
    document.getElementsByClassName(images + 'a')[0].style.display = "none";

}

//Ẩn thông tin hàng hóa
function noneInfo(a, b) {
    document.getElementById(a + 'a').style.display = "none";
    document.getElementById(a).style.display = "inline";
    document.getElementById(b).style.display = "none";
}
//Xóa thông tin 1 cột hàng hóa
function deleteRowInfo(a) {
    document.getElementById(a).remove();
}

//lấy thông tin hàng hóa hiển thị lên thẻ input
function editDetailOrders(ten, sl, lh, cod, kg, tenht, slht, lhht, codht, kght, thh, shh) {
    document.getElementById(thh).style.display = "none";
    document.getElementById(shh).style.display = "block";
    // Lấy thông tin đơn hàng
    var a = document.getElementById(ten).innerHTML;
    var b = document.getElementById(sl).innerHTML;
    var c = document.getElementById(lh).innerHTML;
    var d = document.getElementById(cod).innerHTML;
    var e = document.getElementById(kg).innerHTML;

    //Đưa vào thẻ input để sửa
    document.getElementById(tenht).value = a;
    document.getElementById(slht).value = b;
    document.getElementById(lhht).value = c;
    document.getElementById(codht).value = d;
    document.getElementById(kght).value = e;
}

