<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/9
 * Time: 13:53
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$name=$_POST["name"];
$password=$_POST["password"];
$select=$conn->query("SELECT * FROM users WHERE name='".$name."'");
if ($user=$select->fetch_assoc()) echo "false"; else echo "true";
?>