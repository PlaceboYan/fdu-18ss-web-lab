<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ArtWorks|艺术品详情</title>
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
    <body>

        <?php
            /**
             * Created by IntelliJ IDEA.
             * User: 13805
             * Date: 2019/5/17
             * Time: 15:47
             */
            session_start();
            include "header.php";
            if (isset($_SESSION["route"]))$route=$_SESSION["route"]; else $route=array();
            $max=0;
            $cnt=count($route);
            $exist=false;
            for ($i=0; $i<$cnt; $i++)
            {
                if ($route[$i]=='artworks') {$exist=true; $max=$i;}
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
            echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">artworks</li>
              </ol>
            </nav>";
            if (!$exist) array_push($route,'artworks'); else $route[$max]='artworks';
            $_SESSION["route"]=$route;
            error_reporting(0);
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "pj2";

            // 创建连接
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("连接失败: " . $conn->connect_error);
            }
            $sql="SELECT * FROM artworks";
            $result = $conn->query($sql);
            $hottest=0;
         //   $a=0;

            while ($row = $result->fetch_assoc()) {
                $a[$row["artworkID"]] = $row["view"];
            }
            if (isset($_GET["id"])) $id=$_GET['id']; else $id=48;
            $artworkResult=$conn->query("SELECT * FROM artworks WHERE artworkID=".$id);//todo
            $artwork=$artworkResult->fetch_assoc();
            echo "<div class='container-fluid'>";
            echo "<div class='row'>";
            echo "<div class='col-5'><img src='resources/img/".$artwork["imageFileName"]."' width='100%' height='auto' id='".$id."'></div>";
            echo "<div class='col-7'>";
            outputForm();
            echo "</div></div></div>";
           // echo "<form action='cart.php' method='get'>"
            if ($artwork["orderID"]=='') {
                echo "<span id='addCart'><button class='btn btn-success btn-block' name='addCart' onclick='ajax(" . $id . ")'>加入购物车</button></span>";
            }
            else{
                echo "<span><button class='btn btn-danger btn-block disabled'>该商品已被购买</button></span>";
            }

            function outputForm()
            {
                global $artwork;
                global $id;
                global $a;
                $a[$id]++;
                echo "<table class='table'>";
                echo "<thead><td>Item</td><td>Content</td></thead>";
                echo "<tr><td>Name</td><td>".$artwork["title"]."</td></tr>";
                if ($artwork["description"]) echo "<tr><td>Description</td><td>".$artwork["description"]."</td></tr>";
                if ($artwork["width"]) echo "<tr><td>Size</td><td>".$artwork["width"]." cm × ".$artwork["height"]." cm</td></tr>";
                echo "<tr><td>Year</td><td>".$artwork["yearOfWork"]."</td></tr>";
                echo "<tr><td>Heat</td><td>".$a[$id]."</td></tr>";
                echo "<tr><td>Artist</td><td>".$artwork["artist"]."</td></tr>";
                echo "<tr><td>Genre</td><td>".$artwork["genre"]."</td></tr>";
                echo "<tr><td>Price</td><td>$ ".$artwork["price"]."</td></tr>";
//                echo "<tr><td>Quantity</td><td>
//                <div class='input-group mb-3' style='width: 30%; left:35%'>
//                    <div class=\"input-group-prepend\">
//                        <button class=\"btn btn-outline-secondary\" type=\"button\">－</button>
//                    </div>
//                    <input type=\"text\" class=\"form-control\" placeholder=\"\" aria-label=\"\" aria-describedby=\"basic-addon2\" id='quantity' value='1' onblur='check()'>
//                    <div class=\"input-group-append\">
//                        <button class=\"btn btn-outline-secondary\" type=\"button\">＋</button>
//                    </div>
//                </div>
//                </td></tr>";
                echo "</table>";
            }
            $conn->query("update artworks set view=view+1 where artworkID =".$id);
            //echo "</form>";
            ?>
    </body>
    <script src="login.js"></script>
    <script>
        // var num=1;
        // var prepend=$(".input-group-prepend button");
        // var append=$(".input-group-append button");
        // prepend.click(function () {
        //     num--;
        //     if (num<0) num=0;
        //     if (num===0) document.getElementById("addCart").innerHTML="<button class='btn btn-danger btn-block' type='submit' name='addCart' disabled>加入购物车</button>";
        //     document.getElementById("quantity").value=num;
        // });
        // append.click(function () {
        //     num++;
        //     if (num>5000) num=5000;
        //     if (num===1) document.getElementById("addCart").innerHTML="<button class='btn btn-success btn-block' name='addCart' type='submit'>加入购物车</button>";
        //     document.getElementById("quantity").value=num;
        // });
        // append.mousedown(function(){
        //     start_timer = setTimeout(function(){
        //         timer = setInterval(function(){
        //             num++;
        //             if (num>5000) num=5000;
        //             if (num===1) document.getElementById("addCart").innerHTML="<button class='btn btn-success btn-block' name='addCart' type='submit'>加入购物车</button>";
        //             document.getElementById("quantity").value=num;
        //         },50)
        //     },500)
        // });
        // append.mouseup(function(){
        //     clearTimeout(start_timer);
        //     clearInterval(timer);
        // });
        // append.mouseout(function(){
        //     clearTimeout(start_timer);
        //     clearInterval(timer);
        // });
        // prepend.mousedown(function(){
        //     start_timer1 = setTimeout(function(){
        //         timer1 = setInterval(function(){
        //             num--;
        //             if (num<0) num=0;
        //             if (num===0) document.getElementById("addCart").innerHTML="<button class='btn btn-danger btn-block' type='submit' name='addCart' disabled>加入购物车</button>";
        //             document.getElementById("quantity").value=num;
        //         },50)
        //     },500)
        // });
        //
        // prepend.mouseup(function(){
        //     clearTimeout(start_timer1);
        //     clearInterval(timer1);
        // });
        // prepend.mouseout(function(){
        //     clearTimeout(start_timer1);
        //     clearInterval(timer1);
        // });
        // function check() {
        //     if (document.getElementById("quantity").value<0) document.getElementById("quantity").value=0;
        //     if (document.getElementById("quantity").value>5000) document.getElementById("quantity").value=5000;
        //     var test=/^[0-9]+$/;
        //     if (!test.test(document.getElementById("quantity").value)　) document.getElementById("quantity").value=0;
        //     num=document.getElementById("quantity").value;
        //     if (num==0) document.getElementById("addCart").innerHTML="<button class='btn btn-danger btn-block' name='addCart' type='submit' disabled>加入购物车</button>"; else if (num===0) document.getElementById("addCart").innerHTML="<button class='btn btn-success btn-block' name='addCart' type='submit'>加入购物车</button>";
        // }
        // document.getElementById("addCart").onclick=function () {
        //     window.location.href = "cart.php?id="+$(".col-5 img").attr("id")+"&quantity="+num;
        // };

        if (getCookie("loginState")!=="true")
        {
            $("button.btn.btn-success.btn-block").addClass("disabled");
        }
        function ajax(id) {
            if (getCookie("loginState") === "true") {
                var xml = new XMLHttpRequest();
                xml.open("POST", "addCart.php", true);
                xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xml.onreadystatechange = function () {
                    if (xml.readyState === 4 && xml.status === 200) {
                        alert(xml.responseText);
                        window.location.href = "cart.php";
                    }
                };
                xml.send("name=" + getCookie("username") + "&id=" + id);
            }
        }
    </script>
</html>
