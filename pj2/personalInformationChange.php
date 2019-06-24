<!DOCTYPE html>
<script src="login.js"></script>
<script>
    if (getCookie("loginState")!=="true")
    {
        alert("Illegal visit");
        window.location.href="index.php";
    }
</script>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ArtWorks|个人信息</title>
        <link href="bootstrap-4.0.0/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-grid.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-reboot.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <script src="bootstrap-4.0.0/js/bootstrap.js"></script>
        <script src="sign.js"></script>
        <script src="bootstrap-4.0.0/js/bootstrap.bundle.js"></script>
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/21
 * Time: 17:07
 */
session_start();
include "header.php";
if (isset($_SESSION["route"]))$route=$_SESSION["route"]; else $route=array();
$max=0;
$cnt=count($route);
$exist=false;
for ($i=0; $i<$cnt; $i++)
{
    if ($route[$i]=='personalInformationChange') {$exist=true; $max=$i;}
}
if ($exist) {
    for ($i = $max; $i < $cnt; $i++) {
        unset($route[$i]);
    };
}
echo "<nav aria-label=\"breadcrumb\">
              <ol class=\"breadcrumb\">";
for ($i=0; $i<count($route); $i++)
{
    echo "<li class=\"breadcrumb-item\"><a href=\"".$route[$i].".php\">".$route[$i]."</a></li>";
}
echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">personalInformationChange</li>
              </ol>
            </nav>";
if (!$exist) array_push($route,'personalInformationChange'); else $route[$max]='personalInformationChange';
$_SESSION["route"]=$route;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$sql="SELECT * FROM users WHERE name='".$_COOKIE["username"]."'";
$result=$conn->query($sql);
$user = $result->fetch_assoc();
echo "<h1>Change Personal Information</h1>";
echo "<form onsubmit='return confirm2(".$user["userID"].");' method='post'>";
echo "<table class='table' width='50%'><tr><td>用户名<br><small>六位及以上，只能包含数字、字母及下划线</small></td><td><input class='form-control' type='text' id='name' onblur='changeName();' value='".$user["name"]."'></td><td><div id='nameError'></div></td></tr>";
echo "<tr><td>原密码</td><td><input class='form-control' type='password' id='Opassword' onblur='ajaxx();'> </td><td><div id='OpasswordError'></div></td></tr>";
echo "<tr><td>新密码<br><small>六位及以上，只能包含数字、字母及下划线，至少含有一个数字和一个字母</small></td><td><input class='form-control' type='password' id='password' onblur='checkPassword3();'> </td><td><div id='passwordError'></div></td></tr>";
echo "<tr><td>确认密码</td><td><input class='form-control' type='password' id='password2' onblur='checkPassword2();'> </td><td><div id='password2Error'></div></td></tr>";
echo "<tr><td>电话</td><td><input class='form-control' type='tel' id='tel' onblur='checkTel();' value='".$user["tel"]."'> </td><td><div id='telError'></div></td></tr>";
echo "<tr><td>邮箱</td><td><input class='form-control' type='email' id='email' onblur='checkEmail();' value='".$user["email"]."'> </td><td><div id='emailError'></div></td></tr>";
echo "<tr><td>地址</td><td><input class='form-control' type='text' id='address' onblur='checkAddress();' value='".$user["address"]."'> </td><td><div id='addressError'></div></td></tr>";
echo "<tr><td><div id='checkCode' style='display: inline-block' onclick='createCode(4)'></td><td><input type='text' class='form-control' onblur='validateCode()' id='inputCode'></td><td><div id='codeError'></div></td></tr>";
echo "</table>";
echo "<button type='reset' class='btn btn-success' style='margin-right: 400px;' onclick='home()'>返回</button>";
echo "<button type='submit' class='btn btn-success'>提交</button></form></table>";
?>

<script>
    function ajaxx() {
        password=document.getElementById("Opassword").value;
        var xml = new XMLHttpRequest();
        xml.open("POST", "changeCheck.php", true);
        xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xml.onreadystatechange = function () {
            if (xml.readyState === 4 && xml.status === 200) {
                var t = xml.responseText;
                if (t=='0') {
                    document.getElementById("OpasswordError").innerHTML = "<div class='alert alert-danger' id='OpasswordError'>密码错误！</div>";
                    bool=false;
                }
                if (t=='1') {
                    document.getElementById("OpasswordError").innerHTML = "<div id='OpasswordError'></div>";
                    bool=true;
                }
            }
        };
        xml.send("password=" + password);
    }

    function home() {
        window.location.href="index.php";
    }
</script>
