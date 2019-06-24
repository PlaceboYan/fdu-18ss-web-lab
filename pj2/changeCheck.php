<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/22
 * Time: 15:26
 */
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
$sql="SELECT * FROM users WHERE name='".$_COOKIE["username"]."'";
$result = $conn->query($sql);
$user=$result->fetch_assoc();
if ($user["password"]!=$_POST["password"])
{
    echo "0";
}
else
{
    echo "1";
}
?>
