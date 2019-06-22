<?php
//error_reporting(0);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$sql="SELECT * FROM users WHERE name=".$_POST["name"];
$result = $conn->query($sql);
if (!$_POST["name"]){
    setcookie("errorType","usernameEmpty");
    return false;
} else if (!$result) {
//    echo "<script>document.getElementById('usernameError').innerHTML='<div class=\"alert alert-danger\">用户不存在！</div>';</script>";
    setcookie("errorType","userNotExist");
    return false;
}
else if ($_POST["password"])
{
    setcookie("errorType","passwordEmpty");
    return false;
}
else if ($result["password"]!=$_POST["password"])
{
    setcookie("errorType","passwordError");
    return false;
}

?>
