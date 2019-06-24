<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/23
 * Time: 23:54
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$user=$_COOKIE["username"];
$sql="SELECT * FROM users WHERE name='$user'";
$result=$conn->query($sql);
$usert = $result->fetch_assoc();
$userID = $usert["userID"];
$sql=$conn->query("INSERT INTO message  (fromUser,toUser,content,time,mark) VALUES (".$_POST["fromID"].",".$_POST["toID"].",'".$_POST["content"]."',NOW(),0)");
//echo "SELECT * FROM message WHERE (fromUser=".$_POST["fromID"]." AND toUser=".$_POST["toID"].") OR (toUser=".$_POST["fromID"]." AND fromUser=".$_POST["toID"].") ORDER BY time ASC";
//echo "<table class='w-100'>";
//while ($r=$sql->fetch_assoc())
//{
//    echo "<tr><td>";
//    if ($_POST["fromID"]==$r["fromUser"])
//    {
//         echo "<div style='float: right; padding:10px; border-radius:10px; background-color:#dddddd;'>".$r["content"]."</div>";
//        if ($r["mark"]==0) echo "<span class=\"badge badge-secondary\" style='float: right'>未读</span>"; else echo "<span class=\"badge badge-secondary\" style='float: right'>已读</span>";
//    }
//    else
//    {
//        echo "<div style='float: left; padding:10px; border-radius:10px; background-color:#dddddd;'>".$r["content"]."</div>";
//        $conn->query("UPDATE message SET mark=1 WHERE id=".$r["id"]);
//    }
//    echo "</td></tr>";
//}
//echo "</table>";
?>
