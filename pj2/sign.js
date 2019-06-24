var name,password,address,tel,email,password2;
var bool=true;
function confirm1() {
    bool=true;
    checkName();
    checkPassword();
    checkPassword2();
    checkEmail();
    checkTel();
    checkAddress();
    bool=bool&&validateCode();
    if (!bool)
    {
        return false;
    }
    else {
        var xml=new XMLHttpRequest();
        xml.open("POST", "signDo.php", true);
        xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xml.onreadystatechange = function () {
            if (xml.readyState === 4 && xml.status === 200) {
                var t = xml.responseText;
                if (t == 'true') alert("注册成功！"); else alert("注册失败！");
                setCookie("username",name);
                setCookie("loginState","true");
                window.location.href="index.php";
                return true;
            }
        };
        xml.send("name=" + name + "&password=" + password + "&tel=" + tel + "&email=" + email + "&address=" + address);

    }
}
function confirm2(id) {
    bool=true;
    ajaxx();
    checkPassword3();
    if (password!='') checkPassword2(); else password='null';
    checkEmail();
    checkTel();
    checkAddress();
    bool=bool&&validateCode();
    if (!bool)
    {
        return false;
    }
    else {
        var xml=new XMLHttpRequest();
        xml.open("POST", "update.php", true);
        xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xml.onreadystatechange = function () {
            if (xml.readyState === 4 && xml.status === 200) {
                var t = xml.responseText;
                if (t == 'true') alert("修改成功！"); else alert("修改失败！");
                setCookie("username",name);
                top.location.href="index.php";
                return true;
            }
        };
        xml.send("id="+id+"&name=" + name + "&password=" + password + "&tel=" + tel + "&email=" + email + "&address=" + address);

    }
}
function checkName() {
    name=document.getElementById("name").value;
    let passw = /^[0-9a-zA-Z_]{6,888}$/;
    if (name=='') {
        document.getElementById("nameError").innerHTML="<div id='nameError' class='alert alert-danger'>用户名不能为空！</div>";
        bool=false;
        return false;
    }
    if (!passw.test(name)) {
        document.getElementById("nameError").innerHTML="<div id='nameError' class='alert alert-danger'>用户名格式错误！</div>";
        bool=false;
        return false;
    }
    var xml = new XMLHttpRequest();
    xml.open("POST", "signDeal.php", true);
    xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xml.onreadystatechange = function () {
        if (xml.readyState === 4 && xml.status === 200) {
            if (xml.responseText=='false') {
                document.getElementById("nameError").innerHTML = "<div id='nameError' class='alert alert-danger'>用户名已存在！</div>";
                bool = false;
                return false;
            }
        }
    };
    xml.send("name=" + name + "&password=defaultText");
    document.getElementById("nameError").innerHTML="<div id='nameError'></div>";
}

function changeName() {
    name=document.getElementById("name").value;
    let passw = /^[0-9a-zA-Z_]{6,888}$/;
    if (name=='') {
        document.getElementById("nameError").innerHTML="<div id='nameError' class='alert alert-danger'>用户名不能为空！</div>";
        bool=false;
        return false;
    }
    if (!passw.test(name)) {
        document.getElementById("nameError").innerHTML="<div id='nameError' class='alert alert-danger'>用户名格式错误！</div>";
        bool=false;
        return false;
    }
    var xml = new XMLHttpRequest();
    xml.open("POST", "signDeal.php", true);
    xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xml.onreadystatechange = function () {
        if (xml.readyState === 4 && xml.status === 200) {
            if (xml.responseText=='false' && name!=getCookie("username")) {
                document.getElementById("nameError").innerHTML = "<div id='nameError' class='alert alert-danger'>用户名已存在！</div>";
                bool = false;
                return false;
            }
        }
    };
    xml.send("name=" + name + "&password=defaultText");
    document.getElementById("nameError").innerHTML="<div id='nameError'></div>";
}

function checkPassword() {
    password=document.getElementById("password").value;
    let passw = /^(?!^\d+$)(?!^[a-zA-Z]+$)[0-9a-zA-Z_]{6,888}$/;
    if (password=='') {
        document.getElementById("passwordError").innerHTML="<div id='passwordError' class='alert alert-danger'>密码不能为空！</div>";
        bool=false;
        return false;
    }
    if (!passw.test(password)) {
        document.getElementById("passwordError").innerHTML="<div id='passwordError' class='alert alert-danger'>密码格式错误！</div>";
        bool=false;
        return false;
    }
    document.getElementById("passwordError").innerHTML="<div id='passwordError'></div>";
    if (document.getElementById("password2").value!='') checkPassword2();
}

function checkPassword3() {
    password=document.getElementById("password").value;
    let passw = /^(?!^\d+$)(?!^[a-zA-Z]+$)[0-9a-zA-Z_]{6,888}$/;
    if (password=='') {
        document.getElementById("passwordError").innerHTML="<div id='passwordError'></div>";
        return true;
    }
    if (!passw.test(password)) {
        document.getElementById("passwordError").innerHTML="<div id='passwordError' class='alert alert-danger'>密码格式错误！</div>";
        bool=false;
        return false;
    }
    document.getElementById("passwordError").innerHTML="<div id='passwordError'></div>";
    if (document.getElementById("password2").value!='') checkPassword2();
}

function checkPassword2() {
    password2=document.getElementById("password2").value;
    if (password2=='') {
        document.getElementById("password2Error").innerHTML="<div id='password2Error' class='alert alert-danger'>请再次输入密码！</div>";
        bool=false;
        return false;
    }
    if (password2!==password) {
        document.getElementById("password2Error").innerHTML="<div id='password2Error' class='alert alert-danger'>密码错误！</div>";
        bool=false;
        return false;
    }
    document.getElementById("password2Error").innerHTML="<div id='password2Error'></div>";
}

function checkPassword2() {
    password2=document.getElementById("password2").value;
    if (password2=='' && password!='') {
        document.getElementById("password2Error").innerHTML="<div id='password2Error' class='alert alert-danger'>请再次输入密码！</div>";
        bool=false;
        return false;
    }
    if (password2!==password) {
        document.getElementById("password2Error").innerHTML="<div id='password2Error' class='alert alert-danger'>密码错误！</div>";
        bool=false;
        return false;
    }
    document.getElementById("password2Error").innerHTML="<div id='password2Error'></div>";
}
function checkTel() {
    tel=document.getElementById("tel").value;
    if (tel=='') {
        document.getElementById("telError").innerHTML="<div id='telError' class='alert alert-danger'>请填写电话！</div>";
        bool=false;
        return false;
    }
    document.getElementById("telError").innerHTML="<div id='telError'></div>";
}

function checkEmail() {
    email=document.getElementById("email").value;
    let passw=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
    if (email=='') {
        document.getElementById("emailError").innerHTML="<div id='emailError' class='alert alert-danger'>请填写邮箱！</div>";
        bool=false;
        return false;
    }
    if (!passw.test(email)) {
        document.getElementById("emailError").innerHTML="<div id='emailError' class='alert alert-danger'>邮箱格式错误！</div>";
        bool=false;
        return false;
    }
    document.getElementById("emailError").innerHTML="<div id='emailError'></div>";
}

function checkAddress() {
    address=document.getElementById("address").value;
    if (address=='') {
        document.getElementById("addressError").innerHTML="<div id='addressError' class='alert alert-danger'>请填写地址！</div>";
        bool=false;
        return false;
    }
    document.getElementById("addressError").innerHTML="<div id='addressError'></div>";
}