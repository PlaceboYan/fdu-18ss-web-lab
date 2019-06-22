<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/9
 * Time: 15:50
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$name=$_POST["name"];
$password=$_POST["password"];
$tel=$_POST["tel"];
$email=$_POST["email"];
$address=$_POST["address"];
$sql="INSERT INTO users (name,email,password,tel,address,balance) VALUES ('$name','$email','$password','$tel','$address',0);";
$conn->query($sql);
echo "true";
?>