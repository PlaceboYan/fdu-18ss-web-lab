<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/6
 * Time: 9:45
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$name=$_POST["name"];
$password=$_POST["password"];
$select=$conn->query("SELECT * FROM users WHERE name='".$name."'");
if (!$psw=$select->fetch_assoc()) echo "01"; else {
    echo "1";
    if ($psw["password"]!=$password) echo "0"; else echo "1";

}
?>
