<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/11
 * Time: 17:04
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
if (isset($_SESSION["r"])) $r=$_SESSION["r"]; else $r=array();
if (isset($_POST["paintingID"]))
{
    array_push($r,$_POST["paintingID"]);
    $_SESSION["r"]=$r;
}
if (isset($_POST["delPaintingID"]))
{
    $r = array_diff($r, [$_POST["delPaintingID"]]);
    $_SESSION["r"]=$r;
}
if (isset($_POST["pay"])&&$_POST["pay"])
{
    $sql="SELECT * FROM users WHERE name='".$_COOKIE["username"]."'";
    $result=$conn->query($sql);
    $user=$result->fetch_assoc();
    $balance=$user["balance"];
    $sum=0;
    foreach ($r as $i)
    {
        $sql="SELECT * FROM artworks WHERE artworkID='".$i."'";
        $result=$conn->query($sql);
        $painting=$result->fetch_assoc();
        $sum+=$painting["price"];
    }
    $sum+=($sum>=1000)?0:100;
    if ($sum>$balance)
    {
        echo "余额不足请充值！需要".$sum."$";
    }
    else if (count($r)==0)
    {
        echo "你没有选择商品！";
    }
    else
    {
        $balance-=$sum;
        echo "交易成功！共花费".$sum."$";
        $sql="UPDATE users SET balance=$balance WHERE name='".$_COOKIE["username"]."'";
        $result=$conn->query($sql);
        $sql="INSERT INTO orders (ownerID,sum,timeCreated) VALUES ('".$user["userID"]."',$sum,NOW())";
        $result=$conn->query($sql);
        $sql="SELECT LAST_INSERT_ID();";
        $result=$conn->query($sql);
        $id1=$result->fetch_assoc();
        $id=$id1["LAST_INSERT_ID()"];
        foreach ($r as $i)
        {
            $sql="SELECT * FROM artworks WHERE artworkID=".$i;
            $result=$conn->query($sql);
            $owner=$result->fetch_assoc();
            $ownerID=$owner["ownerID"];
            $amount=$owner["price"];
            $sql="UPDATE users SET balance=(balance+$amount) WHERE userID='$ownerID'";
            $result=$conn->query($sql);
            $sql="UPDATE artworks SET orderID=$id WHERE artworkID=".$i;
            $result=$conn->query($sql);
            $sql="DELETE FROM carts WHERE artworkID=".$i;
            $result=$conn->query($sql);
        }
        $r=array();
        $_SESSION["r"]=$r;

    }
}

