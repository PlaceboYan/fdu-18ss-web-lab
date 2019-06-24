<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/22
 * Time: 18:56
 */
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
if (isset($_SESSION["r"])) $r=$_SESSION["r"]; else $r=array();
if (isset($_POST["paintingID"]))
{
    if (!in_array($_POST["paintingID"],$r)) {
        array_push($r, $_POST["paintingID"]);
        $_SESSION["r"] = $r;
    }
}
if (isset($_POST["delPaintingID"]))
{
    $r = array_diff($r, [$_POST["delPaintingID"]]);
    $_SESSION["r"]=$r;
}
if (count($r)>0) {
    $sql = "SELECT * FROM users WHERE name='" . $_COOKIE["username"] . "'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    $balance = $user["balance"];
    $sum = 0;
    foreach ($r as $i) {
        $sql = "SELECT * FROM artworks WHERE artworkID='" . $i . "'";
        $result = $conn->query($sql);
        $painting = $result->fetch_assoc();
        $sum += $painting["price"];
    }
    echo "选购商品总价： ".$sum." colons";
    if ($sum >= 1000) echo "    运费： 0 colon"; else echo "    运费： 100 colons";
    $sum += ($sum >= 1000) ? 0 : 100;
    echo "    总价： ".$sum." colons";
    echo "    你的余额： ".$user["balance"]." colons";
}
else {
    echo "　";
}