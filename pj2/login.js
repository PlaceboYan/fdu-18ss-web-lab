var search;
var code='';
window.onload = function () {
    if ($("#checkCode").length>0) createCode(4);
    if (getCookie("loginState")==="true") showLogin(); else showLogout();
};



function showLogout() {
    document.getElementById("Signined").style.display = "none";
    document.getElementById("Unsignined").style.display = "block";
}

function showLogin() {
    document.getElementById("Unsignined").style.display = "none";
    document.getElementById("Signined").style.display = "block";
}
function resetLogin() {
    document.getElementById("loginNameError").innerHTML = "";
    document.getElementById("loginPasswordError").innerHTML = "";
    document.getElementById("inputCodeError").innerHTML = "";
}
function checkNumber() {
    if (document.getElementsByName("quantity")[0].innerHTML<0) document.getElementsByName("quantity")[0].innerHTML = "0";
}


function loginPassword() {
    let password1 = document.getElementsByName("password")[0].value;
    let rightPassword = "crafting123";
    let passw = /^[0-9a-zA-Z_]{6,888}$/;
    if (password1.length === 0) {
        document.getElementById("loginPasswordError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请填写密码</span>";
        return false;
    } else if (!passw.test(password1)) {
        document.getElementById("loginPasswordError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请按正确格式填写密码，示例：crafting123</span>";
        return false;
    }
    else if (password1 === document.getElementsByName("username")[0].value) {
        document.getElementById("loginPasswordError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>密码不能与用户名相同！</span>";
        return false;
    }else if (password1 !== rightPassword) {
        document.getElementById("loginPasswordError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>密码错误</span>";
        return false;
    }

    document.getElementById("loginPasswordError").innerHTML = "";
    return true;
}

function signinPassword() {
    let password1 = document.getElementById("password").value;
    let passw = /^[0-9a-zA-Z_]{6,888}$/;
    let username1=document.getElementById("usernameSignin").value;
    if (password1.length === 0) {
        document.getElementById("signinPasswordError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请填写密码</span>";
        return false;
    }
    if (password1===username1)
    {
        document.getElementById("signinPasswordError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>密码不能与用户名相同！</span>";
        return false;
    }
    if (!passw.test(password1)) {
        document.getElementById("signinPasswordError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请按正确格式填写密码，示例：crafting123</span>";
        return false;
    }

    document.getElementById("signinPasswordError").innerHTML = "";
    return true;
}

function signinRepassword() {
    let password2 = document.getElementById("repassword").value;
    let password1 = document.getElementById("password").value;
    if (password2.length === 0) {
        document.getElementById("repasswordError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请重复输入密码！</span>";
        return false;
    } else if (password1 !== password2) {
        document.getElementById("repasswordError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>两次输入密码不一致！</span>";
        return false;
    }
    document.getElementById("repasswordError").innerHTML = "";
    return true;
}

function signinName() {
    let username1 = document.getElementById("usernameSignin").value;
    let re = /^(?!^\d+$)(?!^[a-zA-Z]+$)[0-9a-zA-Z_]{6,888}$/;
    if (username1.length === 0) {
        document.getElementById("signinNameError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请填写用户名！</span>";
        return false;
    } else if (!re.test(username1)) {
        document.getElementById("signinNameError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请按正确格式填写用户名，示例：Placebo_Yan</span>";
        return false;
    }
    document.getElementById("signinNameError").innerHTML = "";
}

function telError() {
    let tel = /^[1][0-9]{10}$/;
    let telephone = document.getElementById("tel").value;
    if (telephone.length === 0) {
        document.getElementById("telError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请填写电话！</span>";
        return false;
    } else if (!tel.test(telephone)) {
        document.getElementById("telError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请按照格式填写电话，示例：13382522595</span>";
        return false;
    }
    document.getElementById("telError").innerHTML = "";
}
function emailError() {
    let email = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
    let emaill = document.getElementById("email").value;
    if (emaill.length === 0) {
        document.getElementById("emailError").innerHTML = "";
    } else if (!email.test(emaill)) {
        document.getElementById("emailError").innerHTML = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请按照格式填写邮箱，示例：13382522595@163.com</span>";
        return false;
    }
    document.getElementById("emailError").innerHTML = "";
}


function onSearch() {
    window.location.href = "search.html";
}

function upload1() {
    window.location.href = "upload.html";
}

// document.getElementById("shoppinglist1").onmouseenter=

function changesigninPassword() {
    let password1 = document.getElementById("password").value;
    let passw = /^[0-9a-zA-Z_]{6,888}$/;
    if (!passw.test(password1)) {
        document.getElementById("signinPasswordError").innerHTML = "<span class='error'>请按正确格式填写密码</span>";
        return false;
    }
    document.getElementById("signinPasswordError").innerHTML = "";
    return true;
}

function changesigninRepassword() {
    let password2 = document.getElementById("repassword").value;
    let password1 = document.getElementById("password").value;
    if (password1 !== password2) {
        document.getElementById("repasswordError").innerHTML = "<span class='error'>两次输入密码不一致！</span>";
        return false;
    }
    document.getElementById("repasswordError").innerHTML = "";
    return true;
}

function changesigninName() {
    let username1 = document.getElementById("username").value;
    let re = /^(?=^[0-9a-zA-Z_]{6,888}$)\w*[a-zA-Z_]+\w*/;
    if (!re.test(username1)) {
        document.getElementById("signinNameError").innerHTML = "<span class='error'>请按正确格式填写用户名！</span>";
        return false;
    }
    document.getElementById("signinNameError").innerHTML = "";
}

function changetelError() {
    let tel = /^[1][0-9]{10}$/;
    let telephone = document.getElementById("tel").value;
    if (!tel.test(telephone)) {
        document.getElementById("telError").innerHTML = "<span class='error'>请按照格式填写电话！</span>";
        return false;
    }
    document.getElementById("telError").innerHTML = "";
}


//生成验证码的方法
function createCode(length) {
    // let code = "";
    // let codeLength = parseInt(length); //验证码的长度
    let checkCode = document.getElementById("checkCode");
    document.getElementById("checkCode").innerHTML='<canvas width="120" height="40" id="c1"> </canvas>';
    s1();
    ////所有候选组成验证码的字符，当然也可以用中文的
    // let codeChars = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    // for (let i = 0; i < codeLength; i++) {
    //     let charNum = Math.floor(Math.random() * 62);
    //     code += codeChars[charNum];
    // }
    // if (checkCode) {
    //     checkCode.className = "code";
    //     checkCode.innerHTML = code;
    // }
}

function validateCode() {
    let checkCode = code;
    let inputCode = document.getElementById("inputCode").value;
    if (inputCode.length <= 0) {
        document.getElementById("codeError").innerHTML="<div id='codeError' class='alert alert-danger'>请输入验证码</div>";
        return false;
    }
    else if (inputCode.toUpperCase() !== checkCode.toUpperCase()) {
        document.getElementById("codeError").innerHTML="<div id='codeError' class='alert alert-danger'>验证码输入有误</div>";
        return false;
    }
    document.getElementById("codeError").innerHTML="";
    return true;
}
function checkInputCode() {
    let checkCode = code;
    let inputCode = document.getElementById("inputCode").value;
    if (inputCode.length <= 0) {
        document.getElementById("inputCodeError").innerHTML = "<div id='inputCodeError' class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>请输入验证码！</div>";
    }
    else if (inputCode.toUpperCase() !== checkCode.toUpperCase()) {
        document.getElementById("inputCodeError").innerHTML = "<div id='inputCodeError' class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times;</button>验证码输入有误！</div>";
    }
    else {
        document.getElementById("inputCodeError").innerHTML = "<div id='inputCodeError'></div>"
    }
}

function getCookie(name) {
    var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return v ? v[2] : null;
}
//
// function setCookie(name, value) {
//     document.cookie =" "+name + "=" + value + "; ";
//     alert(cookie);
// }
function setCookie(cname, cvalue, exdays=1) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60*60*1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function deleteCookie(name) { setCookie(name, '', -1); }

function logout() {
    setCookie("loginState","false");
}
function s1() {
    function rn(min,max){
        return  parseInt(Math.random()*(max-min)+min);
    }
//2.新建一个函数产生随机颜色
    function rc(min,max){
        var r=rn(min,max);
        var g=rn(min,max);
        var b=rn(min,max);
        return `rgb(${r},${g},${b})`;
    }
//3.填充背景颜色,颜色要浅一点
    var w=120;
    var h=40;
    var ctx=c1.getContext("2d");
    ctx.fillStyle=rc(180,230);
    ctx.fillRect(0,0,w,h);
//4.随机产生字符串
    code='';
    var pool="ABCDEFGHIJKLIMNOPQRSTUVWSYZ1234567890";
    for(let i=0;i<4;i++){
        var c=pool[rn(0,pool.length)];//随机的字
        code+=c;
        var fs=rn(18,40);//字体的大小
        var deg=rn(-30,30);//字体的旋转角度
        ctx.font=fs+'px Simhei';
        ctx.textBaseline="top";
        ctx.fillStyle=rc(80,150);
        ctx.save();
        ctx.translate(30*i+15,15);
        ctx.rotate(deg*Math.PI/180);
        ctx.fillText(c,-15+5,-15);
        ctx.restore();
    }
//5.随机产生5条干扰线,干扰线的颜色要浅一点
    for(let i=0;i<5;i++){
        ctx.beginPath();
        ctx.moveTo(rn(0,w),rn(0,h));
        ctx.lineTo(rn(0,w),rn(0,h));
        ctx.strokeStyle=rc(180,230);
        ctx.closePath();
        ctx.stroke();
    }
//6.随机产生40个干扰的小点
    for(let i=0;i<40;i++){
        ctx.beginPath();
        ctx.arc(rn(0,w),rn(0,h),1,0,2*Math.PI);
        ctx.closePath();
        ctx.fillStyle=rc(150,200);
        ctx.fill();
    }
}
