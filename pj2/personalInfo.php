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
        <link href="bootstrap-4.0.0/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-grid.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-reboot.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <script src="bootstrap-4.0.0/js/bootstrap.js"></script>
        <script src="sign.js"></script>
        <script src="bootstrap-4.0.0/js/bootstrap.bundle.js"></script>
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
    echo "<nav aria-label=\"breadcrumb\">
              <ol class=\"breadcrumb\">";
    for ($i=0; $i<count($route); $i++)
    {
        echo "<li class=\"breadcrumb-item\"><a href=\"".$route[$i].".php\">".$route[$i]."</a></li>";
    }
    echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">personalInfo</li>
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
                echo "<div class=\"card\" style=\"width: 18rem\">
                  <div class='card-body'>
                    <h5 class='card-title'>User Information</h5>
                    <h6 class='card-subtitle mb-2 text-muted'>id:".$userID." name:".$user."</h6>
                    <p class='card-text'>Balance: ".$usert["balance"]."<br>Address: ".$usert["address"]."<br>Tel: ".$usert["tel"]."<br>Email: ".$usert["email"]."</p>
                    
                    <button onclick='' class='btn btn-primary'>充值</button>
                    <button onclick='jump()' class='btn btn-primary'>修改</button>
                    <button onclick='' class='btn btn-primary'>提现</button>
                  </div>
                </div>";
                $sql="SELECT * FROM orders WHERE ownerID='$userID'";
                $result=$conn->query($sql);
                ?>
            </div>
            <div class="row-10">
                <table class="table">
                    <thead><tr><th>OrderId</th><th>Total Amount</th><th>Time</th></tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($each=$result->fetch_assoc()) {
                        echo "<tr><td>";
                        echo $each["orderID"] . "</td>";
                        echo "<td>" . $each["sum"] . "</td>";
                        echo "<td>" .$each["timeCreated"]."</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>

                <table class="table">
                    <thead><tr><th>My Upload</th><th>Title</th><th>Go</th><th>Change</th></tr>
                    </thead>
                    <tbody>
                    <?php
                    $result=$conn->query("SELECT * FROM artworks WHERE ownerID=".$userID);
                    while ($each=$result->fetch_assoc()) {
                        echo "<tr><td>";
                        echo $each["artworkID"] . "</td>";
                        echo "<td>" . $each["title"] . "</td>";
                        echo "<td><button class='btn btn-primary' onclick='go(".$each["artworkID"].")'>Go!</button></td>";
                        echo "<td><button class='btn btn-primary' onclick='go1(".$each["artworkID"].")'>Change</button></td>";
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
</script>