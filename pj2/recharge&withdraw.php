
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
    <body>
    <?php
    /**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/23
 * Time: 15:55
 */
    session_start();
    include "header.php";
    if (isset($_SESSION["route"]))$route=$_SESSION["route"]; else $route=array();
    $max=0;
    $cnt=count($route);
    $exist=false;
    for ($i=0; $i<$cnt; $i++)
    {
        if ($route[$i]=='recharge&withdraw') {$exist=true; $max=$i;}
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
    echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">recharge&withdraw</li>
              </ol>
            </nav>";
    if (!$exist) array_push($route,'recharge&withdraw'); else $route[$max]='recharge&withdraw';
    $_SESSION["route"]=$route;
    ?>
    <form method="post">
        <table class="table">
            <tr>
                <td>
                    余额
                </td>
                <td>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "pj2";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $result=$conn->query("SELECT * FROM users WHERE name='".$_COOKIE["username"]."'");
                    $dd=$result->fetch_assoc();
                    echo $dd["balance"];
                    ?>
                </td>
            </tr>
            <tr>
                <td id="clicker">
                    <div onclick="change()"> 充值 </div>(点击更换)
                </td>
                <td>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="recharge" onblur="check();">
                        <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <button type="submit" onclick="ajax()" class="btn btn-success">确定</button>
    </form>
    </body>
</html>
<script>
    var sgn=1;
    function check() {
        if (document.getElementsByName("recharge")[0].value<0) document.getElementsByName("recharge")[0].value=0;
        document.getElementsByName("recharge")[0].value=Math.round(document.getElementsByName("recharge")[0].value);
        if (sgn===-1)
        {
            var xml=new XMLHttpRequest();
            xml.open("POST","rwDeal.php",true);
            xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xml.onreadystatechange=function () {
                if (xml.readyState === 4 && xml.status === 200) {
                    if (parseInt(xml.responseText)<parseInt(document.getElementsByName("recharge")[0].value))
                    {
                        alert("余额不足");
                        document.getElementsByName("recharge")[0].value=0;
                    }
                }
            };
            xml.send("sgn="+sgn+"&quantity="+document.getElementsByName("recharge")[0].value+"&test=true");
        }
    }
    function change() {
        if (sgn===-1) document.getElementById("clicker").innerHTML='<div onclick="change()"> 充值 </div>(点击更换)';
        if (sgn===1) document.getElementById("clicker").innerHTML='<div onclick="change()"> 取现 </div>(点击更换)';
        sgn=-sgn;
        check();
    }
    function ajax() {
        var xml=new XMLHttpRequest();
        xml.open("POST","rwDeal.php",true);
        xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xml.onreadystatechange=function () {
            if (xml.readyState === 4 && xml.status === 200) {
                alert("充值/取现成功！");
                window.location.href='personalInfo.php';
            }
        };
        xml.send("sgn="+sgn+"&quantity="+document.getElementsByName("recharge")[0].value+"&test=false");

    }
</script>