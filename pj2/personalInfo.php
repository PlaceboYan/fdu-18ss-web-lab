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
     * Date: 2019/6/11
     * Time: 10:01
     */

    session_start();
    include "header.php";
    if (isset($_SESSION["route"]))$route=$_SESSION["route"]; else $route=array();
    $max=0;
    $cnt=count($route);
    $exist=false;
    for ($i=0; $i<$cnt; $i++)
    {
        if ($route[$i]=='personalInfo') {$exist=true; $max=$i;}
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
    echo "<li class='breadcrumb-item active' aria-current='page'>personalInfo</li>
              </ol>
            </nav>";
    if (!$exist) array_push($route,'personalInfo'); else $route[$max]='personalInfo';
    $_SESSION["route"]=$route;
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="row-2">
                <?php
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
                echo "<div class='card' style='width: 18rem'>
                  <div class='card-body'>
                    <h5 class='card-title'>User Information</h5>
                    <h6 class='card-subtitle mb-2 text-muted'>id:".$userID." name:".$user."</h6>
                    <p class='card-text'>Balance: ".$usert["balance"]."<br>Address: ".$usert["address"]."<br>Tel: ".$usert["tel"]."<br>Email: ".$usert["email"]."</p>
                    
                    <button onclick='jump2()' class='btn btn-primary'>充值/提现</button>
                    <button onclick='jump()' class='btn btn-primary'>修改</button>
                  </div>
                </div>";
                $sql="SELECT * FROM orders WHERE ownerID='$userID'";
                $result=$conn->query($sql);
                ?>
            </div>
            <div class="row-10">
                <table class="table">
                    <thead><tr><th>OrderId</th><th>Total Amount</th><th>Time</th><th>Details</th></tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($each=$result->fetch_assoc()) {
                        echo "<tr><td>";
                        echo $each["orderID"] . "</td>";
                        echo "<td>" . $each["sum"] . "</td>";
                        echo "<td>" . $each["timeCreated"] . "</td><td>";
                        $sql = $conn->query("SELECT * FROM artworks WHERE orderID=" . $each["orderID"]);
                        echo "<div class=\"card\" style=\"width: 18rem;\"><ul class=\"list-group list-group-flush\">";
                        while ($r = $sql->fetch_assoc()) {
                            echo "<li class=\"list-group-item\">".$r["title"]."<a href='artworks.php?id=".$r["artworkID"]."'>  Link</a></li>";
                        }
                        echo "</ul></div></td></tr>";
                    }
                    ?>
                    </tbody>
                </table>

                <table class="table">
                    <thead><tr><th>My Upload</th><th>Title</th><th>Go</th><th>Change</th><th>Delete</th></tr>
                    </thead>
                    <tbody>
                    <?php
                    $result=$conn->query("SELECT * FROM artworks WHERE ownerID=".$userID." AND orderID is null");
                    while ($each=$result->fetch_assoc()) {
                        echo "<tr><td>";
                        echo $each["artworkID"] . "</td>";
                        echo "<td>" . $each["title"] . "</td>";
                        echo "<td><button class='btn btn-primary' onclick='go(".$each["artworkID"].")'>Go!</button></td>";
                        echo "<td><button class='btn btn-primary' onclick='go1(" . $each["artworkID"] . ")'>Change</button></td>";
                        echo "<td><button class='btn btn-primary' onclick='delet(" . $each["artworkID"] . ")'>Delete</button></td>";
                    }
                    ?>
                    </tbody>
                </table>

                <table class="table">
                    <thead><tr><th>Sold out</th><th>Title</th><th>Go</th><th>Change</th><th>Delete</th></tr>
                    </thead>
                    <tbody>
                    <?php
                    $result=$conn->query("SELECT * FROM artworks WHERE ownerID=".$userID." AND orderID is not null");
                    while ($each=$result->fetch_assoc()) {
                        echo "<tr><td>";
                        echo $each["artworkID"] . "</td>";
                        echo "<td>" . $each["title"] . "</td>";
                        echo "<td><button class='btn btn-primary' onclick='go(".$each["artworkID"].")'>Go!</button></td>";
                        echo "<td><button type='button' class='btn btn-secondary' data-container='body' data-toggle='popover' data-placement='top' data-content='Artwork already sold out.'>Sold out</button></td>";
                        echo "<td><button class='btn btn-secondary'>Sold out</button></td>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</html>
<script>
    function go(id) {
        window.location.href="artworks.php?id="+id;
    }
    function go1(id) {
        window.location.href="upload.php?id="+id;
    }
    function jump() {
        window.location.href="personalInformationChange.php";
    }
    function jump2() {
        window.location.href="recharge&withdraw.php";
    }
    function delet(id) {
        var xml=new XMLHttpRequest();
        xml.open("POST","deleteArtwork.php",true);
        xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xml.onreadystatechange=function () {
            if (xml.readyState === 4 && xml.status === 200) {
                alert("删除成功！");
                window.location.reload();
            }
        };
        xml.send('id='+id);
    }
</script>