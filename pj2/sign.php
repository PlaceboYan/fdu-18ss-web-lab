<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ArtWorks|注册</title>
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
        session_start();
        include "header.php";
        echo "<h1>注册</h1>";
        echo "<form onsubmit='return confirm1()' method='post'>";
        echo "<table class='table' width='50%'><tr><td>用户名<br><small>六位及以上，只能包含数字、字母及下划线</small></td><td><input class='form-control' type='text' id='name' onblur='checkName();'></td><td><div id='nameError'></div></td></tr>";
        echo "<tr><td>密码<br><small>六位及以上，只能包含数字、字母及下划线，至少含有一个数字和一个字母</small></td><td><input class='form-control' type='password' id='password' onblur='checkPassword();'> </td><td><div id='passwordError'></div></td></tr>";
        echo "<tr><td>确认密码</td><td><input class='form-control' type='password' id='password2' onblur='checkPassword2();'> </td><td><div id='password2Error'></div></td></tr>";
        echo "<tr><td>电话</td><td><input class='form-control' type='tel' id='tel' onblur='checkTel();'> </td><td><div id='telError'></div></td></tr>";
        echo "<tr><td>邮箱</td><td><input class='form-control' type='email' id='email' onblur='checkEmail();'> </td><td><div id='emailError'></div></td></tr>";
        echo "<tr><td>地址</td><td><input class='form-control' type='text' id='address' onblur='checkAddress();'> </td><td><div id='addressError'></div></td></tr>";
        echo "<tr><td><div id='checkCode' style='display: inline-block' onclick='createCode(4)'></td><td><input type='text' class='form-control' onblur='validateCode()' id='inputCode'></td><td><div id='codeError'></div></td></tr>";
        echo "</table>";
        echo "<button type='reset' class='btn btn-success' style='margin-right: 400px;'>重置</button>";
        echo "<button type='submit' class='btn btn-success'>提交</button></form>";
        ?>
    </body>
    <script src="sign.js"></script>
</html>