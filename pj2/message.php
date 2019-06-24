<!DOCTYPE html>
<script src="login.js"></script>
<script>
    if (getCookie("loginState")!=="true")
    {
        alert("Illegal visit");
        window.location.href="index.php";
    }
</script>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ArtWorks|个人信息</title>
        <link href="style.css" rel="stylesheet">
        <script src="sign.js"></script>
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet">
        <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <?php
    /**
     * Created by IntelliJ IDEA.
     * User: 13805
     * Date: 2019/6/23
     * Time: 22:00
     */
    session_start();
    include "header.php";
    if (isset($_SESSION["route"]))$route=$_SESSION["route"]; else $route=array();
    $max=0;
    $cnt=count($route);
    $exist=false;
    for ($i=0; $i<$cnt; $i++)
    {
        if ($route[$i]=='message') {$exist=true; $max=$i;}
    }
    if ($exist) {
        for ($i = $max; $i < $cnt; $i++) {
            unset($route[$i]);
        };
    }
    echo "<nav aria-label='breadcrumb'>
              <ol class='breadcrumb'>";
    for ($i=0; $i<count($route); $i++)
    {
        echo "<li class='breadcrumb-item'><a href='".$route[$i].".php'>".$route[$i]."</a></li>";
    }
    echo "<li class='breadcrumb-item active' aria-current='page'>message</li>
              </ol>
            </nav>";
    if (!$exist) array_push($route,'message'); else $route[$max]='message';
    $_SESSION["route"]=$route;
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
    ?>
    <aside>
        <table style="width: 20%; float: right" class="table">
            <?php
            $sql=$conn->query("SELECT userID,name FROM users");
            //$k=0;
            while ($r=$sql->fetch_assoc())
            {
             //   $k++;
            //    if ($k==1) echo "<script>ajax(".$userID.",".$r["userID"].")</script>";
                if ($r["userID"]!=$userID) {
                    echo "<tr><td id='" . $r["userID"] . "' onclick='ajax($userID," . $r["userID"] . ")'><a href='#'>" . $r["name"] . "</a>";
                    $sql2 = $conn->query("SELECT COUNT(*) AS tot FROM message WHERE toUser=$userID AND mark=0 AND fromUser=" . $r["userID"]);
                    $res = $sql2->fetch_assoc();
                    if ($res["tot"] > 0) echo "<span class=\"badge badge-primary\">" . $res["tot"] . "</span>";
                    echo "</td></tr>";
                }
            }
            ?>
        </table>
    </aside>
    <div style="width: 80%">
    <div id="msg"></div>
    <form>
        <textarea class="form-control" id="input" rows="3"></textarea>
        <?php
        if (isset($_COOKIE["toUser"]) && $_COOKIE["toUser"]!=0) {
            echo '<div id="ftr" style="padding: 20px;"><button class="btn btn-success" onclick="sendAjax('.$userID.',' . $_COOKIE["toUser"] . ')">发送</button></div>';
        } else {
            echo '<div id="ftr" style="padding: 20px;"><button class="btn btn-success disabled" type="submit">发送</button></div>';
        }
        ?>

    </form>
    </div>
    <script>
        setCookie("toUser",0);
        function ajax(fromID,toID)
        {
            setCookie("toUser",toID);
            var xml=new XMLHttpRequest();
            xml.open("POST","messagePresent.php",false);
            xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xml.onreadystatechange=function () {
                if (xml.readyState === 4 && xml.status === 200) {
                    arr=xml.responseText.split("^");
                    document.getElementById("msg").innerHTML=arr[0];
                    document.getElementById("ftr").innerHTML=arr[1];
                    setCookie("toUser",toID);
                }
            };
            xml.send('fromID='+fromID+'&toID='+toID);
        }
        function sendAjax(fromID,toID) {
            if (document.getElementById("input").value != '' && toID != 0) {
                var xml = new XMLHttpRequest();
                xml.open("POST", "messageSave.php", true);
                xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xml.onreadystatechange = function () {
                    if (xml.readyState === 4 && xml.status === 200) {
                        ajax(fromID, toID);
                        document.getElementById("input").value = '';
                    }
                };
                xml.send('fromID=' + fromID + '&toID=' + toID + "&content=" + document.getElementById("input").value);
            }
        }
    </script>


