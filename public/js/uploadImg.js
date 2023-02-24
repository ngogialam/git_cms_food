$(document).ready(function() {
    $('#imageFile').change(function(evt) {
        var files = evt.target.files;
        var file = files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            var filesToUploads = document.getElementById('imageFile').files;
            var file = filesToUploads[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement("img");
                    img.src = e.target.result;
                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);
                    var MAX_WIDTH = 400;
                    var MAX_HEIGHT = 400;
                    var width = img.width;
                    var height = img.height;
                    if (width > height) {
                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }
                    } else {
                        if (height > MAX_HEIGHT) {
                            width *= MAX_HEIGHT / height;
                            height = MAX_HEIGHT;
                        }
                    }
                    canvas.width = width;
                    canvas.height = height;
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, width, height);
                    dataurl = canvas.toDataURL(file.type);
                    // document.getElementById('photo').src = dataurl;
                }
                reader.readAsDataURL(file);
            }
        }
    });
});

var firebaseConfig = {
    apiKey: "AIzaSyCNkaG-Is8Lch6CjEGjthxu01tHhUbHnVQ",
    authDomain: "holaphake2.firebaseapp.com",
    databaseURL: "https://holaphake2-default-rtdb.firebaseio.com",
    projectId: "holaphake2",
    storageBucket: "holaphake2.appspot.com",
    messagingSenderId: "709424045843",
    appId: "1:709424045843:web:6911e5d49d08aff4a144e6",
    measurementId: "G-8LP3ZW8N37"
  };
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
// firebase.firestore();
firebase.analytics();

function uploadImage() {
    // size > 2097152 
    // ,'image/gif','image/bmp' 
    let allowedExtension = ['image/jpeg', 'image/jpg','image/png'];
    var nameFile = document.getElementById('userLogin').value;
    const ref = firebase.storage().ref()
    const file = document.querySelector("#imageFile").files[0]
    type = file.type;
    size = file.size;
    validate = 0;
    if(type < 0)
    {
        validate = 1;
    }else if(size > 2097152){
        validate = 2;
    }
    if(validate == 0)
    {
        const name = nameFile;
        const metadata = {
            contentType: file.type
        }
        const task = ref.child(name).put(file, metadata);
        task
            .then(snapshot => snapshot.ref.getDownloadURL())
            .then(urlAcc => {
                var userLogin = document.getElementById('userLogin').value;
                $.ajax({
                    url: '/vi/cap-nhat-avatar',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'username': userLogin,
                        'avatarUrl': urlAcc
                    },
                    success: function(res) {
                        if (res.success) {
                            $(".notification-container").fadeIn();
                            $('.notification-title-info').html('Cập nhật thành công.');
                            $(".notification-danger").hide();
                            // Set a timeout to hide the element again
                            setTimeout(function() {
                                $(".notification-container").fadeOut();
                            }, 5000);
                            setTimeout(function() {
                                window.location.href = "/thong-tin-tai-khoan";
                            }, 1000);
                        } else {
                            $(".notification-container").fadeIn();
                            $('.notification-title-danger').html('Cập nhật không thành công.');
                            $(".notification-info").hide();
                        }
                    },
                    error: function() {
                        console('Có lỗi phát sinh trong quá trình xử lý dữ liệu');
                    }
                });
            })
            .catch(console.error);
    }else{
        if(allowedExtension.indexOf(file.type) < 0)
        {
            $(".notification-container").fadeIn();
            $('.notification-title-danger').html('Chỉ cho phép chọn định dạng ảnh: jpg, jpeg, png.');
            $(".notification-info").hide();
            setTimeout(function() {
                $(".notification-container").fadeOut();
            }, 5000);
        }else if(size > 2097152){
            $(".notification-container").fadeIn();
            $(".notification-info").hide();
            $('.notification-title-danger').html('Vượt quá dung lượng tối đa 2 MB.');

            setTimeout(function() {
                $(".notification-container").fadeOut();
            }, 5000);
        }
    }    
}