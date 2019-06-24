<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/22
 * Time: 15:31
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
if ($_POST["password"]!='null') {
    $sql = "UPDATE users SET name='" . $_POST["name"] . "', password='" . $_POST['password'] . "', tel='" . $_POST["tel"] . "', email='" . $_POST["email"] . "' ,address='" . $_POST["address"] . "' WHERE userID=" . $_POST["id"];
    $conn->query($sql);
}
else
{
    $sql = "UPDATE users SET name='" . $_POST["name"] . "', tel='" . $_POST["tel"] . "', email='" . $_POST["email"] . "' ,address='" . $_POST["address"] . "' WHERE userID=" . $_POST["id"];
    $conn->query($sql);
}
echo "true";
