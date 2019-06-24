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
        if ($route[$i]=='deal') {$exist=true; $max=$i;}
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
    echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">deal</li>
                      </ol>
                    </nav>";
    if (!$exist) array_push($route,'deal'); else $route[$max]='deal';
    $_SESSION["route"]=$route;
    /**
     * Created by IntelliJ IDEA.
     * User: 13805
     * Date: 2019/6/22
     * Time: 17:37
     */

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pj2";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if (isset($_SESSION["r"])) $r=$_SESSION["r"]; else $r=array();


    $sql="SELECT * FROM users WHERE name='".$_COOKIE["username"]."'";
    $result=$conn->query($sql);
    $user=$result->fetch_assoc();
    $balance=$user["balance"];
    $sum=0;
    echo "<h1>确认你的订单</h1><table style='width: 100%; margin-bottom: 50px;'>";
    foreach ($r as $i)
    {
        $sql="SELECT * FROM artworks WHERE artworkID='".$i."'";
        $result=$conn->query($sql);
        $painting=$result->fetch_assoc();
        $sql="SELECT COUNT(*) AS num FROM record WHERE artworkID='".$i."'";
        $result=$conn->query($sql);
        $res=$result->fetch_assoc();
        $num=$res["num"];
 //       $sql="SELECT * FROM record WHERE artworkID='".$i."'";
        $sql="select  * from record where id in(Select max(id) FROM record group by detail) and artworkID=$i";
        $result=$conn->query($sql);
        echo "<tr><td><div class='card mb-3'>
        <table><tr><td width='40%'>
          <img src='resources/img/".$painting["imageFileName"]."' alt='Card image cap' height='300px' width='70%'>
          </td><td width='60%'>
          <div class='card-body'>
            <h5 class='card-title'>".$painting["title"]."</h5>
            <p class='card-text'>Price:".$painting["price"]."</p>
            <div>";
        if ($num>0) {   echo "<b>Notice:</b><br>";
            while ($notice=$result->fetch_assoc())
            {
                echo "<b>".$notice["detail"]."</b> was last edited at ".$notice["time"].".<br>";
            }
        }
        echo "
            </div>
          </div>
          </td>
          </tr></table>
        </div>";
        echo "</tr>";
        $sum+=$painting["price"];
    }
    echo "</table>";
    $sum1=$sum;
    $sum+=($sum>=1000)?0:100;
    if ($sum>$balance)
    {
        echo "<script>alert('余额不足请充值！需要".$sum."$'); window.location.href='cart.php';</script>";
    }
    else if (count($r)==0)
    {
        echo "<script>alert('你没有选择商品！'); window.location.href='cart.php';</script>";
    }
    else {
//        echo "<button onclick='' class='btn btn-warning w-40' style='float: '>返回</button>";
//        echo "<button onclick='' class='btn btn-success w-40'>支付</button>";

        echo '  <div class="input-group mb-3 fixed-bottom">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary" type="button" onclick="jamp();" style="padding: 10px 40px 10px 40px; color: white; background-color: orangered;border: none">返回</button>
            </div>
            <div id="cal" class="form-control"></div>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" onclick="jmp('.$userID.','.$sum.');" style="padding: 10px 40px 10px 40px; color: white; background-color: orangered; border: none">支付</button>
            </div>
        </div>
        <script>
            document.getElementById("cal").innerText="共'.$sum.'$ ,其中商品共'.$sum1.'$ ,运费'.($sum-$sum1).'$";
        </script>';
    }
    ?>
    </body>
</html>
<script>
    function jmp(uid,sum) {
        var xml=new XMLHttpRequest();
        xml.open("POST","pay.php",true);
        xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xml.onreadystatechange=function () {
            if (xml.readyState === 4 && xml.status === 200) {
                alert(xml.responseText);
                window.location.href='personalInfo.php';
            }
        };
        xml.send('uid='+uid+"&sum="+sum);
    }

    function jamp() {
        window.location.href='cart.php';
    }
</script>