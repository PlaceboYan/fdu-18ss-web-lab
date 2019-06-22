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
$imgname = $id.".jpg";
$tmp = $_FILES['myfile']['tmp_name'];
$filepath = 'resources/img/';
$title=$_POST["title"];
$description=$_POST["description"];
$genre=$_POST["genre"];
$width=$_POST["width"];
$height=$_POST["height"];
$yow=$_POST["year"];
$artist=$_POST["artist"];
$sql="SELECT * FROM users WHERE name='".$_COOKIE["username"]."'";
$result=$conn->query($sql);
$user = $result->fetch_assoc();
$userID = $user["userID"];
if ($new)
{
    $sql="INSERT INTO artworks (artworkID,title,artist,description,imageFileName,yearOfWork,genre,width,height,view,ownerID,orderID,timeReleased) 
                        VALUES ($id,'$title','$artist','$description','$imgname',$yow,'$genre',$width,$height,0,$userID,NULL,NOW())";
    $conn->query($sql);
} else{
    $sql="UPDATE artworks SET
              artworkID=$id,
              title='$title',
              artist='$artist',
              description='$description',
              imageFileName='$imgname',
              yearOfWork=$yow,
              genre='$genre',
              width=$width,
              height=$height,
              view=view,
              ownerID=$userID,
              orderID=orderID,
              timeReleased=timeReleased)";
    $conn->query($sql);
}
if (file_exists($filepath.$imgname))
{
    unlink($filepath.$imgname);
}
if(move_uploaded_file($tmp,$filepath.$imgname).".jpg"){
    echo "<script>window.location.href='artworks.php?id='+'".$id."'; alert('上传成功！'); </script>";
}else{
    echo "<script>window.location.href='artworks.php?id='+'".$id."'; alert('上传失败！'); </script>";
}
