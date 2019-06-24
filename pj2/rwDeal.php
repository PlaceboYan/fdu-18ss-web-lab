<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/23
 * Time: 17:22
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($_POST["test"]=='true')
{
    $result=$conn->query("SELECT * FROM users WHERE name='".$_COOKIE["username"]."'");
    $dd=$result->fetch_assoc();
    echo $dd["balance"];
}
else{
    $delta=$_POST["sgn"]*$_POST["quantity"];
    $conn->query("UPDATE users SET balance=(balance+$delta) WHERE name='".$_COOKIE["username"]."'");
}
exit();