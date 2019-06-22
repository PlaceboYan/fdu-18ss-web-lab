<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/9
 * Time: 19:25
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$id=$_POST["id"];
$sql="SELECT * FROM artworks WHERE artworkID=$id";
$result=$conn->query($sql);
$painting=$result->fetch_assoc();
$artworkID=$painting['artworkID'];
$sql="SELECT * FROM users WHERE name='".$_POST["name"]."'";
$result=$conn->query($sql);
$user = $result->fetch_assoc();
$userID = $user["userID"];
$sql="SELECT * FROM carts WHERE userID=$userID AND artworkID=$artworkID";
$result=$conn->query($sql);
$exist=$result->fetch_assoc();
if (!$exist) {
    $sql = "INSERT INTO carts (userID,artworkID) VALUES ($userID,$artworkID)";
    $conn->query($sql);
    echo "添加购物车成功！";
} else {
    echo "该商品已经在你的购物车中！";
}
//$sql="DELETE FROM artworks WHERE artworkID=$id";
//$conn->query($sql);
?>