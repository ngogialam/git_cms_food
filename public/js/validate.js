$(document).ready(function(){
    $('.checkExistPhone').change(function(){
        var checkExistPhone = $('.checkExistPhone').val();
        $.ajax({
            url: '/vi/checkExistPhone',
            type: 'post',
            dataType: 'json',
            data: {
                'checkExistPhone': checkExistPhone
            },
            success: function(res) {
                console.log(res.success)
                console.log(123)
                if (res.success) {
                    console.log(1)
                    $('#btn-add-user').removeAttr("disabled");
                }
            },
            error: function(res) {
                console.log(12345)
            }
        });
    })
});

function validatePass (password, repassword){
    if(password != repassword){
        return 1;
    }else if(password == ''){
        return 2;
    }else if(password == ''){
        return 3;

    }
    return true;
}
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePhone (phone){
        let number = phone;
    if (/(0[0])+([0-9]{9})\b/.test(number)) {
        return false;
    }else if(!/^[0-9]+$/.test(number)){
        return false;
    }else if(!/(0[2|3|5|7|8|9])+([0-9]{8})\b|(\+84)+([0-9]{9})\b|(0[2])+([0-9]{9})\b/.test(number)){
        return false;
    }
    return true;
}