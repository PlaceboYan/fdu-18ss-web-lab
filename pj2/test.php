<!DOCTYPE html>
<script src="login.js"></script>
<script>
    if (getCookie("loginState")!=="true")
    {
        alert("侬脑子瓦特了");
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

    if (isset($_GET["id"])) $id=$_GET["id"]; else $id=0;
    echo "<table class='table'><form>";
    echo "<tr><td>";?>
    <input id="img_input2" type="file" accept="image/*"/>
    <label for="img_input2" id="img_label2">选择文件<i class="fa fa-plus fa-lg">+</i></label>
    <?php
    echo "</td><td><div id='preview_box2' style='height: 405px; width: 605px; border: dashed'></div></td></tr>";
    echo "<tr><td>Artist:</td><td><input type='text' class='form-control' name='artist'></td></tr>";
    echo "<tr><td>Price:</td><td><input type='text' class='form-control' name='price'></td></tr>";
    echo "<tr><td>Year:</td><td><input type='text' class='form-control' name='year'></td></tr>";
    echo "<tr><td>Genre:</td><td><input type='text' class='form-control' name='genre'></td></tr>";
    echo "<tr><td>Description:</td><td><textarea type='text' class='form-control' name='artist'></textarea></td></tr>";
    echo "<tr><td colspan='2'><button type='submit' class='btn btn-primary'>Submit</button></td></tr>";
    echo "</form></table>";
    ?>



    <script>
        /*
         * Demo3:label样式
         */
        var bool=false;
        $("#img_input2").on("change", function(e) {

            var file = e.target.files[0]; //获取图片资源

            // 只选择图片文件
            if (!file.type.match('image.*')) {
                return false;
            }
            var reader = new FileReader();
            reader.readAsDataURL(file); // 读取文件
            // 渲染文件
            reader.onload = function(arg) {
                var img = '<img class="preview" src="' + arg.target.result + '" alt="preview" style="max-width:600px; height: 400px; width: auto" id="preview_box2"/>';
                // $("#preview_box2").empty().append(img);
                document.getElementById("preview_box2").innerHTML=img;
                bool=true;
            }
        });


    </script>