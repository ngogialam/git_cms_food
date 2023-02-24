$(document).ready(function() {
  $('.fullName').keydown(function (e) {
    var charCode = e.keyCode;
        if ((charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode >186 && charCode < 222 ) {
                e.preventDefault();
            }
    });
});

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  
  function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
  
  function checkCookie() {
    let user = getCookie("username");
    if (user != "") {
      alert("Welcome again " + user);
    } else {
      user = prompt("Please enter your name:", "");
      if (user != "" && user != null) {
        setCookie("username", user, 365);
      }
    }
  }
  
  function timer()
  {
      count=count-1;
      if (count < 0){
          count = 0;
      }else if(count==0){
          $('.reSendOtp').removeAttr("disabled");
      }
      document.getElementById("timer").innerHTML=count + "s"; 
  }
  function openModal(message,time=3000){
    console.log(message)
    $('.notifyDetail').html(message)
    $("#modalNotify").modal()
    setTimeout(function(){
        $("#modalNotify").modal('hide')
    }, time);
}