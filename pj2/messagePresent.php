<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/23
 * Time: 22:48
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
$sql="SELECT * FROM users WHERE userID='".$_POST["toID"]."'";
$result=$conn->query($sql);
$usert = $result->fetch_assoc();
$user2 = $usert["name"];
$sql=$conn->query("SELECT * FROM message WHERE (fromUser=".$_POST["fromID"]." AND toUser=".$_POST["toID"].") OR (toUser=".$_POST["fromID"]." AND fromUser=".$_POST["toID"].") ORDER BY time ASC");
//echo "SELECT * FROM message WHERE (fromUser=".$_POST["fromID"]." AND toUser=".$_POST["toID"].") OR (toUser=".$_POST["fromID"]." AND fromUser=".$_POST["toID"].") ORDER BY time ASC";
echo "<h3>".$user2."</h3><table class='w-100'>";
while ($r=$sql->fetch_assoc())
{
    echo "<tr style='padding-bottom: 10px;'><td>";
    if ($_POST["fromID"]==$r["fromUser"])
    {
         echo "<div style='float: right; padding:10px; border-radius:10px; background-color:#dddddd; margin-bottom: 10px;'>".$r["content"]."</div>";
         if ($r["mark"]==0) echo "<span class=\"badge badge-secondary\" style='float: right'>未读</span>"; else echo "<span class=\"badge badge-warning\" style='float: right'>已读</span>";
    }
    else
    {
        echo "<div style='float: left; padding:10px; border-radius:10px; background-color:#dddddd; margin-bottom: 10px'>".$r["content"]."</div>";
        if ($r["mark"]==0) echo "<span class=\"badge badge-warning\" style='float: left'>未读</span>"; else echo "<span class=\"badge badge-secondary\" style='float: left'>已读</span>";
        $conn->query("UPDATE message SET mark=1 WHERE id=".$r["id"]);
    }
    echo "</td></tr>";
}
echo "</table>^";
echo "<button class='btn btn-success' type='submit' onclick='sendAjax(".$userID.',' . $_COOKIE['toUser'] . ")'>发送</button>";
?>