<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/9
 * Time: 21:06
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$page=$_GET["page"];
$user=$_GET["name"];
$sql="SELECT * FROM users WHERE name='$user'";
$result=$conn->query($sql);
$user = $result->fetch_assoc();
$userID = $user["userID"];
$sql="SELECT * FROM carts WHERE userID=$userID";
$sql=$sql." LIMIT " . (6 * $page - 6) . ",6";
$result = $conn->query($sql);
echo "<table style='width: 100%; table-layout: fixed'>";
$i = 0;
while ($each = $result->fetch_assoc()) {
    echo "<tr>";
    $imgResult=$conn->query("SELECT * FROM artworks WHERE artworkID=".$each["artworkID"]);
    $img=$imgResult->fetch_assoc();
    echo "<td><div class='card mb-3'>
    <table><tr><td width='40%'>
      <input type='checkbox' name='checkbox' style='margin-right: 20%'  onchange='determine(".$img["artworkID"].");' id='a".$img["artworkID"]."'>  
      <img src='resources/img/".$img["imageFileName"]."' alt='Card image cap' height='300px' width='70%'>
      </td><td width='60%'>
      <div class='card-body'>
        <h5 class='card-title'>".$img["title"]."</h5>
        <p class='card-text'>Price:".$img["price"]."</p>
        <button id='remove' class='btn btn-primary' onclick='del(".$each["cartID"].",".$page.")'>Remove</button>
        <button id='details' class='btn btn-primary' onclick='jmp(".$img["artworkID"].")'>Details</button>
        <button id='Pay Now!' class='btn btn-primary'>Pay Now!</button>
      </div>
      </td>
      </tr></table>
    </div>";
    echo "</tr>";
    $i++;
}
echo "</table>";
if ($i==0) echo "<h1>你的购物车里没有商品哦！快去选购一些商品吧</h1>";
?>