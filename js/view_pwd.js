let loginPwdStatus = false;

function changePwdView(){
  let getLoginInput = document.getElementById("fPassword");

  if (loginPwdStatus === false){
    getLoginInput.setAttribute("type", "text");
    loginPwdStatus = true;
  }else if(loginPwdStatus === true){
    getLoginInput.setAttribute("type", "password");
    loginPwdStatus = false;
  }
}
