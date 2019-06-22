<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ArtWorks|登录</title>
        <link href="bootstrap-4.0.0/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-grid.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-reboot.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <script src="login.js"></script>
        <script src="bootstrap-4.0.0/js/bootstrap.js"></script>
        <script src="bootstrap-4.0.0/js/bootstrap.bundle.js"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

        <?php
        /**
         * Created by IntelliJ IDEA.
         * User: 13805
         * Date: 2019/5/24
         * Time: 12:26
         */
        include "header.php";
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pj2";
        $conn = new mysqli($servername, $username, $password, $dbname);

        echo "<h1>登陆</h1>";
        echo "<form onsubmit='return confirm()'>";
        echo "<table class='table' width='50%'><tr><td>用户名</td><td><input class='form-control' type='text' name='name' onblur='ajax(\"name\");'></td><td><div id='usernameError'></div></td></tr>";
        echo "<tr><td>密码</td><td><input class='form-control' type='password' name='password' onblur='ajax(\"name\",\"password\");'> </td><td><div id='passwordError'></div></td></tr>";
        echo "<tr><td><div id='checkCode' style='display: inline-block' onclick='createCode(4)'></td><td><input type='text' class='form-control' onblur='validateCode()' id='inputCode'></td><td><div id='codeError'></div></td></tr>";
        echo "</table>";
        echo "<button type='reset' class='btn btn-success' style='margin-right: 400px;'>重置</button>";
        echo "<button type='submit' class='btn btn-success'>提交</button>";
        echo "</form>";
        ?>
    </body>
    <script>
    function ajax(name,password='defaultState') {
        if (name='name') name=document.getElementsByName("name")[0].value;
        if (password=='password') password=document.getElementsByName("password")[0].value;
        if (password=='') password='defaultState';
        var xml = new XMLHttpRequest();
        xml.open("POST", "loginDeal.php", true);
        xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xml.onreadystatechange = function () {
            if (xml.readyState === 4 && xml.status === 200) {
                var t = xml.responseText;
                if (t[0]=='0') document.getElementById("usernameError").innerHTML="<div class='alert alert-danger' id='usernameError'>用户不存在！</div>";
                if (t[0]=='1') document.getElementById("usernameError").innerHTML="<div id='usernameError'></div>";
                if (t[1]=='0' && password!='defaultState') document.getElementById("passwordError").innerHTML="<div class='alert alert-danger' id='passwordError'>密码错误！</div>";
                if (t[1]=='1' || password=='defaultState') document.getElementById("passwordError").innerHTML="<div id='passwordError'></div>";
            }
        };
        xml.send("name=" + name + "&password=" + password);
    }
    function  confirm() {
        var name=document.getElementsByName("name")[0].value;
        var password=document.getElementsByName("password")[0].value;
        var xml = new XMLHttpRequest();
        xml.open("POST", "loginDeal.php", true);
        xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xml.onreadystatechange = function () {
            if (xml.readyState === 4 && xml.status === 200) {
                var t = xml.responseText;
                if (t=='11') {
                    setCookie("username",name);
                    setCookie("loginState","true");
                    window.location.href="index.php";
                    return true;
                } else return false;
            }
        };
        xml.send("name=" + name + "&password=" + password);
    }
    </script>