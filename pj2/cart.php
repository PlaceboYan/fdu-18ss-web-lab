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
        <title>ArtWorks|购物车</title>
        <link href="bootstrap-4.0.0/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-grid.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-reboot.css" rel="stylesheet">
        <script src="bootstrap-4.0.0/js/bootstrap.js"></script>
        <script src="bootstrap-4.0.0/js/bootstrap.bundle.js"></script>
        <link href="style.css" rel="stylesheet">
        <script src="cart.js"></script>
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        session_start();
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pj2";
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql="SELECT * FROM users WHERE name='".$_COOKIE["username"]."'";
        $result=$conn->query($sql);
        $user = $result->fetch_assoc();
        $userID = $user["userID"];
        setcookie("userID",$userID);
        include "header.php";
        if (isset($_SESSION["route"]))$route=$_SESSION["route"]; else $route=array();
        $max=0;
        $cnt=count($route);
        $exist=false;
        for ($i=0; $i<$cnt; $i++)
        {
            if ($route[$i]=='cart') {$exist=true; $max=$i;}
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
        echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">cart</li>
                  </ol>
                </nav>";
        if (!$exist) array_push($route,'cart'); else $route[$max]='cart';
        $_SESSION["route"]=$route;
        /**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/5/22
 * Time: 16:03
 */

        $sql="SELECT * FROM carts WHERE userID=".$userID;
        $result=$conn->query($sql);
        while ($each=$result->fetch_assoc())
        {
            $i++;
        }
        $totalPage=$i/6;
        if (isset($_GET["page"])) $page=$_GET["page"]; else $page=1;
        echo "<div id='result'></div>";
        echo "<div class='container-fluid'>";
        echo "<div class='btn-group'>";
        for ($i = 1; $i <= $totalPage+1; $i++) {
            echo "<button class='btn btn-default' onclick='ajax(".$i.")'>$i</button>";
        }
        echo "</div></div> ";
        ?>
        <div style="margin-top: 50px"></div>
        <div class="fixed-bottom" style="background-color: black;">
            <ul>
                <li style="display: inline; background-color: orangered; padding: 10px 40px 10px 40px; float: left; color: white" onclick="reset();">
                    重置
                </li>
                <li style="display: inline; background-color: orangered; padding: 10px 40px 10px 40px; float: right; color: white" onclick="onDeal();">
                    下单
                </li>
            </ul>
        </div>

        <script>
            ajax(1);
        </script>


    </body>
</html>