<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/10
 * Time: 1:07
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$user=$_COOKIE["username"];
$sql="DELETE FROM carts WHERE cartID=".$_GET["id"];
$conn->query($sql);
?>