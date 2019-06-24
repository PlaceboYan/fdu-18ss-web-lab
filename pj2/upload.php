<!DOCTYPE html>
<script src="login.js"></script>
<script>
    if (getCookie("loginState")!=="true")
    {
        alert("Illegal visit");
        window.location.href="index.php";
    }
</script>
<td lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ArtWorks|上传</title>
        <link href="bootstrap-4.0.0/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-grid.css" rel="stylesheet">
        <link href="bootstrap-4.0.0/css/bootstrap-reboot.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <script src="bootstrap-4.0.0/js/bootstrap.js"></script>
        <script src="bootstrap-4.0.0/js/bootstrap.bundle.js"></script>
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <?php
    /**
     * Created by IntelliJ IDEA.
     * User: 13805
     * Date: 2019/6/13
     * Time: 0:37
     */
    session_start();
    include "header.php";
    if (isset($_SESSION["route"]))$route=$_SESSION["route"]; else $route=array();
    $max=0;
    $cnt=count($route);
    $exist=false;
    for ($i=0; $i<$cnt; $i++)
    {
        if ($route[$i]=='upload') {$exist=true; $max=$i;}
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
    echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">upload</li>
              </ol>
            </nav>";
    if (!$exist) array_push($route,'upload'); else $route[$max]='upload';
    $_SESSION["route"]=$route;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pj2";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if (isset($_GET["id"])) $id=$_GET["id"]; else $id=0;
    echo "<table class='table'><form method='post' action='uploadDeal.php' enctype='multipart/form-data'>";
    echo "<tr><td>";?>
    <input id="img_input2" type="file" accept="image/*" name="myfile"/>
    <label for="img_input2" id="img_label2">选择文件(不超过2M)<i class="fa fa-plus fa-lg">+</i></label>
    <?php
    if (!isset($_GET["id"])) {
        echo "</td><td><div id='preview_box2' style='height: 405px; width: 100%; border: dashed'></div></td></tr>";
        echo "<tr><td>Title:</td><td><input type='text' class='form-control' name='title' required></td></tr>";
        echo "<tr><td><input type='number' name='id' style='display: none' value='0'>Artist:</td><td><input type='text' class='form-control' name='artist' required></td></tr>";
        echo "<tr><td>Price:</td><td><input type='number' class='form-control' name='price' onblur='check();' required></td></tr>";
        echo "<tr><td>Year:</td><td><input type='number' class='form-control' name='year' onblur='check1();' required></td></tr>";
        echo "<tr><td>Width(cm):</td><td><input type='number' class='form-control' name='width' onblur='check1();' required></td></tr>";
        echo "<tr><td>Height(cm):</td><td><input type='number' class='form-control' name='height' onblur='check1();' required></td></tr>";
        echo "<tr><td>Genre:</td><td><input type='text' class='form-control' name='genre' required></td></tr>";
        echo "<tr><td>Description:</td><td><textarea type='text' class='form-control' name='description' required></textarea></td></tr>";
    } else {
        $id=$_GET["id"];
        $sql="SELECT * FROM artworks WHERE artworkID=$id";
        $result=$conn->query($sql);
        $r=$result->fetch_assoc();
        echo "</td><td>";
        if ($r["width"]*4<=$r["height"]*6) {
            echo '<div id=\'preview_box2\'><img class="preview" src=\'resources/img/'.$r["imageFileName"].'\' alt="preview" style="max-width:600px; height: 400px; width: auto;"/></div>';
        } else {
            echo '<div id=\'preview_box2\'><img class="preview" src=\'resources/img/'.$r["imageFileName"].'\' alt="preview" style="max-height:400px; width: 600px; height: auto;"/></div>';
        }
        echo "</td></tr>";
        echo "<tr><td>Title:</td><td><input type='text' class='form-control' name='title' value='".$r["title"]."' required></td></tr>";
        echo "<tr><td><input type='number' name='id' style='display: none' value='".$id."'>Artist:</td><td><input type='text' class='form-control' name='artist' value='".$r["artist"]."' required></td></tr>";
        echo "<tr><td>Price:</td><td><input type='number' class='form-control' name='price' value=".$r["price"]." onblur='check();' required></td></tr>";
        echo "<tr><td>Year:</td><td><input type='number' class='form-control' name='year' value=".$r["yearOfWork"]." onblur='check1();' required></td></tr>";
        echo "<tr><td>Width(cm):</td><td><input type='number' class='form-control' name='width' value=".$r["width"]." onblur='check3();' required></td></tr>";
        echo "<tr><td>Height(cm):</td><td><input type='number' class='form-control' name='height' value=".$r["height"]." onblur='check2();' required></td></tr>";
        echo "<tr><td>Genre:</td><td><input type='text' class='form-control' name='genre' value='".$r["genre"]."' required></td></tr>";
        echo "<tr><td>Description:</td><td><textarea type='text' class='form-control' name='description' required>".$r["description"]."</textarea></td></tr>";

    }
    echo "<tr><td colspan='2'><button type='submit' class='btn btn-primary'>Submit</button></td></tr>";
    echo "</form></table>";
    ?>



    <script>
        var bool=false;
        $("#img_input2").on("change", function(e) {
            var file = e.target.files[0]; //获取图片资源
            if (!file.type.match('image.*')) {
                return false;
            }
            // 渲染文件
            var target=document.getElementById("img_input2");
            var fileSize = target.files[0].size;
            var size = fileSize / 1024;
            if(size>2000){
                alert("附件不能大于2M");
                location.reload();
            } else {
                var reader = new FileReader();
                reader.readAsDataURL(file); // 读取文件
                reader.onload = function (arg) {
                    var e = arg.target.result;
                    var image = new Image();
                    image.onload = function () {
                        var width = image.width;
                        var height = image.height;
                        if (width * 4 <= height * 6) {
                            var img = '<img class="preview" src="' + e + '" alt="preview" style="max-width:600px; height: 400px; width: auto;" id="preview_box2"/>';
                        } else {
                            var img = '<img class="preview" src="' + e + '" alt="preview" style="max-height:400px; width: 600px; height: auto;" id="preview_box2"/>';
                        }
                        document.getElementById("preview_box2").innerHTML = img;
                        document.getElementById("preview_box2").setAttribute("style", "width:100%; border:none;");
                    };
                    image.src = e;
                    // $("#preview_box2").empty().append(img);
                    bool = true;
                }
            }
        });

        function check() {
            if (document.getElementsByName("price")[0].value<0) document.getElementsByName("price")[0].value=0;
            document.getElementsByName("price")[0].value=Math.round(document.getElementsByName("price")[0].value);
        }
        function check1() {
//            if (document.getElementsByName("year")[0].value<0) document.getElementsByName("year")[0].value=0;
            document.getElementsByName("year")[0].value=Math.round(document.getElementsByName("year")[0].value);
        }
        function check2() {
            if (document.getElementsByName("height")[0].value<0) document.getElementsByName("height")[0].value=0;
            document.getElementsByName("height")[0].value=Math.round(document.getElementsByName("height")[0].value);
        }
        function check3() {
            if (document.getElementsByName("width")[0].value<0) document.getElementsByName("width")[0].value=0;
            document.getElementsByName("width")[0].value=Math.round(document.getElementsByName("width")[0].value);
        }
    </script>