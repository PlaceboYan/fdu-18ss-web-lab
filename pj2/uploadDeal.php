<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/15
 * Time: 20:31
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$new=false;
if ($_POST['id']==0) {
    $sql="SELECT MAX(artworkID) AS idl FROM artworks";
    $result=$conn->query($sql);
    $idl=$result->fetch_assoc();
    $id=$idl["idl"]+1;
    $new=true;
}
else {$id=$_POST['id'];}
if ($_FILES['myfile']['tmp_name']) {
    $imgname = $id . ".jpg";
    $tmp = $_FILES['myfile']['tmp_name'];
    $sql = $conn->query("SELECT * FROM artworks WHERE artworkID=$id");
    $artwork = $sql->fetch_assoc();
    if ($_FILES['myfile']['name'] != $artwork["imageFileName"]) {
        $conn->query("INSERT INTO record (artworkID,detail,time) VALUES ($id,'IMAGE',NOW())");
    }
    $filepath = 'resources/img/';
}


$title=$_POST["title"];
$description=$_POST["description"];
$genre=$_POST["genre"];
$width=$_POST["width"];
$height=$_POST["height"];
$yow=$_POST["year"];
$artist=$_POST["artist"];
$price=$_POST["price"];
$sql="SELECT * FROM users WHERE name='".$_COOKIE["username"]."'";
$result=$conn->query($sql);
$user = $result->fetch_assoc();
$userID = $user["userID"];
if ($new)
{
    $sql="INSERT INTO artworks (artworkID,title,artist,description,imageFileName,yearOfWork,genre,width,height,view,ownerID,orderID,timeReleased,price) 
                        VALUES ($id,'$title','$artist','$description','$imgname',$yow,'$genre',$width,$height,0,$userID,NULL,NOW(),$price)";
    $conn->query($sql);
} else{
    $sql=$conn->query("SELECT * FROM artworks WHERE artworkID=$id");
    $artwork=$sql->fetch_assoc();
    str_replace("\"","&quot;",$title);
    str_replace("'","`",$title);
    str_replace("\"","&quot;",$description);
    str_replace("'","`",$description);
    str_replace("\"","&quot;",$artist);
    str_replace("'","`",$artist);
    str_replace("\"","&quot;",$genre);
    str_replace("'","`",$genre);
    if ($title!=$artwork["title"])
    {
        $conn->query("INSERT INTO record (artworkID,detail,time) VALUES ($id,'TITLE',NOW())");
    }
    if ($artist!=$artwork["artist"])
    {
        $conn->query("INSERT INTO record (artworkID,detail,time) VALUES ($id,'ARTIST',NOW())");
    }
    if ($description!=$artwork["description"])
    {
        $conn->query("INSERT INTO record (artworkID,detail,time) VALUES ($id,'DESCRIPTION',NOW())");
    }
    if ($genre!=$artwork["genre"])
    {
        $conn->query("INSERT INTO record (artworkID,detail,time) VALUES ($id,'GENRE',NOW())");
    }
    if ($width!=$artwork["width"] || $height!=$artwork["height"])
    {
        $conn->query("INSERT INTO record (artworkID,detail,time) VALUES ($id,'SIZE',NOW())");
    }
    if ($price!=$artwork["price"])
    {
        $conn->query("INSERT INTO record (artworkID,detail,time) VALUES ($id,'PRICE',NOW())");
    }
    if ($artist!=$artwork["yearOfWork"])
    {
        $conn->query("INSERT INTO record (artworkID,detail,time) VALUES ($id,'YEAR OF WORK',NOW())");
    }
    $sql="UPDATE artworks SET title='".$title."' WHERE artworkID=$id;"; $conn->query($sql);
    $sql="UPDATE artworks SET artist='".$artist."' WHERE artworkID=$id;";  $conn->query($sql);
    $sql="UPDATE artworks SET description='".$description."' WHERE artworkID=$id;"; $conn->query($sql);
    $sql="UPDATE artworks SET price=$price WHERE artworkID=$id;"; $conn->query($sql);
    $sql="UPDATE artworks SET yearOfWork=$yow WHERE artworkID=$id;"; $conn->query($sql);
    $sql="UPDATE artworks SET width=$width WHERE artworkID=$id;"; $conn->query($sql);
    $sql="UPDATE artworks SET genre='".$genre."' WHERE artworkID=$id;"; $conn->query($sql);
    $sql="UPDATE artworks SET height=$height WHERE artworkID=$id;"; $conn->query($sql);
}

if ($_FILES['myfile']['tmp_name']) {
    echo "<script>".$_FILES['myfile']['tmp_name']."</script>";
    if (file_exists($filepath . $imgname)) {
        unlink($filepath . $imgname);
    }

    if (move_uploaded_file($tmp, $filepath . $imgname) . ".jpg") {
        $sql="UPDATE artworks SET imageFileName='$imgname' WHERE artworkID=$id;";
        //echo $sql;
        $conn->query($sql);
    } else {
        echo "<script>window.location.href='artworks.php?id='+'" . $id . "'; alert('上传失败！'); </script>";
    }
}
echo "<script>window.location.href='artworks.php?id='+'".$id."';alert('上传成功！'); </script>";