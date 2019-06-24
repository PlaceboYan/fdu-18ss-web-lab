<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ArtWorks|主页</title>
<!--        <link href="bootstrap-4.0.0/css/bootstrap.css" rel="stylesheet">-->
<!--        <link href="bootstrap-4.0.0/css/bootstrap-grid.css" rel="stylesheet">-->
<!--        <link href="bootstrap-4.0.0/css/bootstrap-reboot.css" rel="stylesheet">-->
<!--        <script src="bootstrap-4.0.0/js/bootstrap.js"></script>-->
<!--        <script src="bootstrap-4.0.0/js/bootstrap.bundle.js"></script>-->
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet">
        <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="login.js"></script>
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        session_start();
        include "header.php";
       // if (isset($_SESSION["route"]))$route=$_SESSION["route"]; else $route=array();
        $route=array();
        $max=0;
        $cnt=count($route);
        $exist=false;
        for ($i=0; $i<$cnt; $i++)
        {
            if ($route[$i]=='index') {$exist=true; $max=$i;}
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
            echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">index</li>
          </ol>
        </nav>";
        if (!$exist) array_push($route,'index'); else $route[$max]='index';
        $_SESSION["route"]=$route;
        error_reporting(0);
        //$hottestOne=0;
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pj2";
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->query("SET GLOBAL time_zone = '+8:00'");
        // Check connection
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql=$conn->query("SELECT * FROM artworks WHERE orderID IS null ORDER BY timeReleased DESC LIMIT 3");
        ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="height: 600px;">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <?php
                    $r=$sql->fetch_assoc();
                    echo '<img class="d-block w-100" style="height:600px" src="resources/img/'.$r["imageFileName"].'" alt="First slide" id="'.$r["artworkID"].'">';
                    ?>
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo $r["title"]?></h5>
                        <p><?php echo $r["description"]?></p>
                    </div>
                </div>
                <div class="carousel-item">
                    <?php
                    $r=$sql->fetch_assoc();
                    echo '<img class="d-block w-100" style="height:600px"  src="resources/img/'.$r["imageFileName"].'" alt="Second slide" id="'.$r["artworkID"].'">';
                    ?>
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo $r["title"]?></h5>
                        <p><?php echo $r["description"]?></p>
                    </div>
                </div>
                <div class="carousel-item">
                    <?php
                    $r=$sql->fetch_assoc();
                    echo '<img class="d-block w-100"  style="height:600px" src="resources/img/'.$r["imageFileName"].'" alt="Third slide" id="'.$r["artworkID"].'">';
                    ?>
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo $r["title"]?></h5>
                        <p><?php echo $r["description"]?></p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>


        <?php

        // 创建连接

        //$arr=$result->fetch_array();
        $sql="SELECT * FROM artworks";
        $result = $conn->query($sql);
        $hottest=0;
        if ($result->num_rows >= 0) {
            // 输出数据
            while ($row = $result->fetch_assoc()) {
                $a[$row["artworkID"]] = $row["view"];
            }
        } else {
            echo "An Error Occurs!";
        }
        echo "<h1>Hottest Artworks</h1>";
        echo "<div class='container-fluid'><div class='row'>";
        $paintingsResult = $conn->query("SELECT artworkID,imageFileName,title,description,artist,view FROM artworks WHERE orderID IS null ORDER BY view DESC LIMIT 3");
        for ($i=1; $i<=3; $i++) {
            echo "<div class='col-sm jumbotron jumbotron-fluid' id='" . $i . "'>";
            $paintings = $paintingsResult->fetch_assoc();
            echo("<h1 style='color:red'>Rank " . $i . "</h1><br><h2>" . $paintings["title"] . "</h2><br><h4>作者：" . $paintings["artist"] . "</h4> <img class='img-thumbnail' src='resources/img/" . $paintings["imageFileName"] . "' height='200px' width='300px' id='" . $paintings["artworkID"] . "'><br> 热度：<div style='color:red; font-family:MV Boli; font-size: larger'>" . $paintings["view"] . "</div><br>" . $paintings["description"]);
            echo "</div>";
        }
        echo "</div></div>";
        ?>
</body>
</html>
<script>
    for (var i=0; i<=2; i++) {
        $("img.img-thumbnail:eq(" + i + ")").click(function f(i) {
            return function () {
                window.location.href = 'artworks.php?id=' + $("img.img-thumbnail:eq(" + i + ")").attr("id");
            }
        }(i));
    }
    for (i=0; i<=2; i++) {
        $("img.d-block.w-100:eq(" + i + ")").click(function f(i) {
            return function () {
                window.location.href = 'artworks.php?id=' + $("img.d-block.w-100:eq(" + i + ")").attr("id");
            }
        }(i));
    }

</script>
