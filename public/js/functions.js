$(document).ready(function() {
    $("body").on('click', '.toggle-password', function() {
        $(this).toggleClass("fa-eye fa-eye");
        $(this).toggleClass("fa-eye fa-eye-slash");
    });
    $("body").on('keyup', '#otpResPass', function() {
        otp = $('#otpResPass').val();
        $('.otpBackup').val(otp);

    });
    $('body').on('blur', '#phone',function(){
        phone = $('#phone').val();
        if(phone == ''){
            $('.err_phone').html('Số điện thoại không được bỏ trống');
        }else{
            checkPhone = validatePhoneOtp(phone);
            if(!checkPhone){
                $('.err_phone').html('Số điện thoại không hợp lệ');
            }else{
                $('.err_phone').html('');
            }
        }
    });
    $('body').on('blur', '#email',function(){
        email = $('#email').val();
        checkEmail = validateEmail(email);
        if(email.length == 0 ){
            $('.err_email').html('Email không được để trống');
        }else if(checkEmail == false){
            $('.err_email').html('Email không hợp lệ');
        }else{
            $('.err_email').html('');
        }
    });

});
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
/*  removeStorage: removes a key from localStorage and its sibling expiracy key
    params:
        key <string>     : localStorage key to remove
    returns:
        <boolean> : telling if operation succeeded
 */
function removeStorage(name) {
    try {
        localStorage.removeItem(name);
        localStorage.removeItem(name + '_expiresIn');
    } catch (e) {
        console.log('removeStorage: Error removing key [' + key + '] from localStorage: ' + JSON.stringify(e));
        return false;
    }
    return true;
}
/*  getStorage: retrieves a key from localStorage previously set with setStorage().
    params:
        key <string> : localStorage key
    returns:
        <string> : value of localStorage key
        null : in case of expired key or failure
 */
function getStorage(key) {

    var now = Date.now(); //epoch time, lets deal only with integer
    // set expiration for storage
    var expiresIn = localStorage.getItem(key + '_expiresIn');
    if (expiresIn === undefined || expiresIn === null) { expiresIn = 0; }

    if (expiresIn < now) { // Expired
        removeStorage(key);
        return null;
    } else {
        try {
            var value = localStorage.getItem(key);
            return value;
        } catch (e) {
            console.log('getStorage: Error reading key [' + key + '] from localStorage: ' + JSON.stringify(e));
            return null;
        }
    }
}
/*  setStorage: writes a key into localStorage setting a expire time
    params:
        key <string>     : localStorage key
        value <string>   : localStorage value
        expires <number> : number of seconds from now to expire the key
    returns:
        <boolean> : telling if operation succeeded
 */
function setStorage(key, value, expires) {

    if (expires === undefined || expires === null) {
        expires = (24 * 60 * 60); // default: seconds for 1 day
    } else {
        expires = Math.abs(expires); //make sure it's positive
    }
    var now = Date.now(); //millisecs since epoch time, lets deal only with integer
    var schedule = now + expires * 1000;
    try {
        localStorage.setItem(key, value);
        localStorage.setItem(key + '_expiresIn', schedule);
        console.log('ok')
    } catch (e) {
        console.log('setStorage: Error setting key [' + key + '] in localStorage: ' + JSON.stringify(e));
        return false;
    }
    return true;
}

function countDownTimer() {
    let timeleft = 30;
    $('#reSendOTP').attr("disabled", true);
    let checkIDExist = document.getElementById("countdowntimer");
    if (checkIDExist != null) {
        var downloadTimer = setInterval(function() {
            if (timeleft <= 0) {
                clearInterval(downloadTimer);
                document.getElementById("countdowntimer").innerHTML = "0s";
                $('#reSendOTP').removeAttr("disabled")
            } else {
                document.getElementById("countdowntimer").innerHTML = timeleft + "s";
            }
            timeleft -= 1;
        }, 1000);
    }
}

function reSendOtp() {
    var phoneResendOtp = $('#phone').val();
    document.getElementById('otpFalse').innerHTML = '';
    // otpFalse
    if (phoneResendOtp != '') {
        $.ajax({
            url: '/vi/reSendOtp',
            type: 'post',
            dataType: 'json',
            data: { 'reSendOtp ': '1', 'phoneOtp': phoneResendOtp },
            success: function(res) {
                if (res.success) {
                    countDownTimer(30);
                    $("#otp").prop('disabled', false);
                    $("#password").prop('disabled', false);
                    $("#repassword").prop('disabled', false);
                } else {
                    if(res.off == 0){
                        $('#reSendOTP').attr("disabled", true);
                        openModal(res.message,5000);
                    }
                    openModal(res.message,5000);
                }
            },
            error: function() {
                // $('#loading_image').fadeOut(300);
            }
        });
    }
}

function showPass(idtag) {
    var x = document.getElementById(idtag);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    $('#package_' + idtag).show();
}

function validatePass(password, repassword) {
    if (password != repassword) {
        return 1;
    } else if (password == '') {
        return 2;
    } else if (repassword == '') {
        return 3;

    }
    return true;
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


//Forgot Password
//---Get OTP
function getOTPForgotPass(errMessage) {
    let phoneGetOtp = $('#phoneGetOtp').val();
    if (phoneGetOtp != '') {
        let checkPhoneNumber = validatePhone(phoneGetOtp);
        if (checkPhoneNumber) {
            $(".err_phoneGetOtp").html('');
            //Send ajax 
            $.ajax({
                url: '/vi/reSendOtp',
                type: 'post',
                dataType: 'json',
                data: { 'reSendOtp ': '1', 'phoneOtp': phoneGetOtp },
                success: function(res) {
                    if (res.success) {
                        alert(res.message);
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    // alert('Có lỗi khi gửi lại OTP.Vui lòng thử lại');
                    // $('#loading_image').fadeOut(300);
                }
            });
        } else {
            $(".err_phoneGetOtp").html(errMessage);
        }
    } else {
        $(".err_phoneGetOtp").html(errMessage);
    }
}

function validatePhoneOtp(phone) {
    let number = phone;

    if (/(0[0])+([0-9]{9})\b/.test(number)) {
        return false;
    } else if (number.length != 10) {
        return false;
    } else if (!/^[0-9]+$/.test(number)) {
        return false;
    } else if (!/(0[2|3|5|7|8|9])+([0-9]{8})\b|(\+84)+([0-9]{9})\b|(0[2])+([0-9]{9})\b/.test(number)) {
        return false;
    }
    return true;
}

function reSendPass() {
    var phoneResendOtp = $('#phoneOtp').val();
    var otpResPass = $('#otpResPass').val();
    // otpFalse
    
    var checkValidatePhone = validatePhoneOtp(phoneResendOtp);
    if (checkValidatePhone) {
        $("#errPhone").html("");
        $.ajax({
            url: '/vi/reSendOtp',
            type: 'post',
            dataType: 'json',
            data: {
                'reSendOtp': '1',
                'phoneOtp': phoneResendOtp
            },
            success: function(res) {
                if (res.success) {
                    $("#otpResPass").prop('disabled', false);
                    $("#errPhone").html("");
                    $("#submitRePass").prop('disabled', false);
                    //Off OTP after 1 min
                    setTimeout(function() {
                        $("#otpResPass").prop('disabled', true);
                    }, 60000);
                        countDownTimerForgorPassword(30);
                } else {
                    if(res.otp == 1){
                        openModal(res.message)
                    }else{
                        $("#errPhone").css({ marginBottom: "5px" });
                        $("#errPhone").html(res.message);
                    }
                    // alert(res.message);
                }
            },
            error: function() {

                $("#errPhone").css({ marginBottom: "5px" });
                $("#errPhone").html(res.message);
            }
        });
    }else if(phoneResendOtp == ''){
        $("#errPhone").css({ marginBottom: "5px" });
        $("#errPhone").html("Số điện thoại không được để trống");
    } else {
        $("#errPhone").css({ marginBottom: "5px" });
        $("#errPhone").html("Số điện thoại không đúng định dạng");
    }
}

function countDownTimerForgorPassword(timeLeft) {
    let timeleft = timeLeft;
    let checkIDExist = document.getElementById("timeOtpForgotPassword");

    if (checkIDExist != null) {
        var downloadTimer = setInterval(function() {
            if (timeleft <= 0) {
                clearInterval(downloadTimer);
                document.getElementById("getOtpForgotPassword").innerHTML = 'Lấy OTP';
            } else {
                document.getElementById("getOtpForgotPassword").innerHTML = timeleft + "s";
            }
            timeleft -= 1;
        }, 1000);
    }
}