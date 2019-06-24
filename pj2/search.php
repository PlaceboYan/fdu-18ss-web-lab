<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ArtWorks|搜索</title>
        <link href="bootstrap-4.0.0/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-grid.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-reboot.css" rel="stylesheet">
        <script src="bootstrap-4.0.0/js/bootstrap.js"></script>
        <script src="bootstrap-4.0.0/js/bootstrap.bundle.js"></script>
        <link href="style.css" rel="stylesheet">
        <script src="login.js"></script>
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <?php
    session_start();
    include "header.php";
    if (isset($_SESSION["route"]))$route=$_SESSION["route"]; else $route=array();

    $max=0;
    $cnt=count($route);
    $exist=false;
    for ($i=0; $i<$cnt; $i++)
    {
        if ($route[$i]=='search') {$exist=true; $max=$i;}
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
    echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">search</li>
          </ol>
        </nav>";
    if (!$exist) array_push($route,'search'); else $route[$max]='search';
    $_SESSION["route"]=$route;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pj2";
    $conn = new mysqli($servername, $username, $password, $dbname);

    ?>

    <body>
    </body>
    <?php


    $_SESSION["key"]=$_GET["search"];
    $key=$_GET["search"];


    echo "<div style='float:left'>";
    $search=$conn->query("SELECT COUNT(*) FROM artworks WHERE title LIKE '%$key%' OR artist LIKE '%$key%' OR description LIKE '%$key%' AND orderID IS null;");
    $num=$search->fetch_assoc();
    $num=$num['COUNT(*)'];
    if ($num==0) echo "<h1>No match!</h1>";
    $pageTotal=floor(($num-1)/12)+1;
    if (isset($_GET["page"])) $page=$_GET["page"]; else $page=1;

    $page=1;
    $artist='';
    $result = $conn->query("SELECT * FROM artworks WHERE title LIKE '%$key%' OR artist LIKE '%$key%' OR description LIKE '%$key%' AND orderID IS null LIMIT " . (12 * $page - 12) . ",12");
    ?>
    <form>
        <div class="form-check-inline">
          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" onclick='ajax(1,6)'>
          <label class="form-check-label" for="exampleRadios1">
            Hot↑
          </label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" onclick='ajax(1,4)'>
            <label class="form-check-label" for="exampleRadios1">
                Hot↓
            </label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" onclick='ajax(1,7)'>
            <label class="form-check-label" for="exampleRadios2">
                Price↑
            </label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" onclick='ajax(1,5)'>
            <label class="form-check-label" for="exampleRadios2">
                Price↓
            </label>
        </div>
    </form>
    <form>
        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadio1" value="option1" onchange='prepare(1)' checked="checked">
            <label class="form-check-label" for="exampleRadios1">
                artist
            </label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadio2" value="option2" onchange='prepare(2)' checked="checked">
            <label class="form-check-label" for="exampleRadios1">
                title
            </label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadio4" value="option4" onchange='prepare(4)' checked="checked">
            <label class="form-check-label" for="exampleRadios2">
                description
            </label>
        </div>
    </form>
    <?php
    echo "<div style='float: left; width: 75%'><div id='searchResult' style='float: left'>";
    echo "<table style='width: 100%; table-layout: fixed'>";
    $i = 0;
    while ($each = $result->fetch_assoc()) {
        if ($i % 3 == 0) echo "<tr>";
        echo "<td style='height: 650px;'><div class='card' style='height: 650px;'>
                <div class='card-img-top'>
                <img src='resources/img/" . $each['imageFileName'] . "' width='100%' height='400px'>
                </div>
                <div class='card-body'>
                <div class='card-title'><h5>" . $each["title"] . "</h5><h6>Artist: " . $each["artist"] . "</h6> </div>
                <p class='card-text'><div class='lineLimit'>" . $each["description"] . "</div></p>
                <a href='artworks.php?id=" . $each["artworkID"] . "' class='btn btn-primary'>Go!</a>
                </div></div></td>
                ";
        if ($i % 3 == 2) echo "</tr>";
        $i++;
    }
    if ($i % 3 != 2) echo "</tr>";
    echo "</table></div>";

    echo "<div class='btn-group' id='pagination'>";
    for ($i = 1; $i <= $pageTotal; $i++) {
        echo "<button class='btn' onclick='ajax(".$i.")'>$i</button>";
    }
    echo "</div></div> ";

    $artist=$conn->query("SELECT DISTINCT artist FROM artworks");
    $i=0;
    while ($each=$artist->fetch_assoc())
    {
        $i++;
        $name[$i]=$each["artist"];
        $cnt=$conn->query("SELECT COUNT(*) FROM artworks WHERE artist='".$name[$i]."'");
        $count[$i]=$cnt->fetch_assoc()["COUNT(*)"];
    }
    echo "<div id='accordion' style='width: 25%; float: right'>";
    for ($j=1; $j<=$i; $j++) {
        echo "<li class='list-group-item'>" . $name[$j] . "
        <span class='badge badge-primary badge-pill'>".$count[$j]."</span></li>";
    }

    echo "</div>";
    ?>
    <script>
        var cont=0;
        setCookie("order",0);
        function prepare(num) {
            if ($('#exampleRadio'+num).get(0).checked) {
                cont-=num;
            }
            else
            {
                cont+=num;
            }
            ajax(1,-1);
        }
        function ajax(t=1,order=-1) {
            var xml=new XMLHttpRequest();
            if (order==-1) order=getCookie("order");
            xml.onreadystatechange=function () {
                if (xml.readyState === 4 && xml.status === 200) {
                    let arr=xml.responseText.split("~");
                    document.getElementById("searchResult").innerHTML = arr[0];
                    document.getElementById("pagination").innerHTML = arr[1];
                    setCookie("order",order);
                }
            };
            xml.open("GET","searchDeal.php?page="+t+"&order="+order+"&content="+cont,false);
            xml.send();
        }
    </script>
