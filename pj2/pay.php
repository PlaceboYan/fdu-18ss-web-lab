<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/23
 * Time: 1:29
 */
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$sum=$_POST["sum"];
$r=$_SESSION["r"];
        echo "交易成功！共花费".$sum."$";
        $sql="UPDATE users SET balance=(balance-$sum) WHERE name='".$_COOKIE["username"]."'";
        $conn->query($sql);
        $sql="SELECT * FROM users WHERE name='".$_COOKIE["username"]."'";
        $result=$conn->query($sql);
        $user=$result->fetch_assoc();
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