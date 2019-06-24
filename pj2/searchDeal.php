<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/4
 * Time: 23:40
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
$key=$_SESSION["key"];
$page=$_GET["page"];
$like=array(" title LIKE '%$key%' "," artist LIKE '%$key%' "," description LIKE '%$key%' ");
$sql1="SELECT * FROM artworks ";
$sql="";
if ($_GET["content"]=='5') $sql=$sql."WHERE".$like[0];
if ($_GET["content"]=='6') $sql=$sql."WHERE".$like[1];
if ($_GET["content"]=='3') $sql=$sql."WHERE".$like[2];
if ($_GET["content"]=='0') $sql=$sql."WHERE".$like[0]."OR".$like[1]."OR".$like[2];
if ($_GET["content"]=='1') $sql=$sql."WHERE".$like[0]."OR".$like[2];
if ($_GET["content"]=='2') $sql=$sql."WHERE".$like[1]."OR".$like[2];
if ($_GET["content"]=='4') $sql=$sql."WHERE".$like[0]."OR".$like[1];
if ($_GET["content"]=='7') {
    echo "<h1 style='width: 1000px'>No result!</h1>~<button class='btn disabled'>1</button>";
    exit();
}

if ($_GET["order"]=='4') $sql=$sql." ORDER BY view DESC";
if ($_GET["order"]=='5') $sql=$sql." ORDER BY price DESC";
if ($_GET["order"]=='6') $sql=$sql." ORDER BY view ASC";
if ($_GET["order"]=='7') $sql=$sql." ORDER BY price ASC";
//if ($_GET["name"]!='null' && $_GET["name"]!='') $sql=$sql." AND artist='".$_GET["name"]."'";
$sql2="SELECT COUNT(*) as cnt FROM artworks ";
$result=$conn->query($sql2.$sql);
$totot=$result->fetch_assoc();
$tot=$totot["cnt"];
$sql=$sql." LIMIT " . (12 * $page - 12) . ",12";
$result = $conn->query($sql1.$sql);
echo "<table style='width: 100%; table-layout: fixed'>";
$i = 0;
while ($each = $result->fetch_assoc()) {
    if ($i % 3 == 0) echo "<tr>";
    echo "<td style='height: 650px'><div class='card' style='height: 650px;'>
              <div class='card-img-top'>
                <img src='resources/img/" . $each['imageFileName'] . "' width='100%' height='400px'>
                </div>
                <div class='card-body'>
                <div class='card-title'><h5>" . $each["title"] . "</h5><h6>Artist: " . $each["artist"] . "</h6> </div>
                <p class='card-text'><div class='lineLimit'>" . $each["description"] . "</div></p>
                <a href='artworks.php?id=" . $each["artworkID"] . "' class=\"btn btn-primary\">Go!</a>
                </div></div></td>
                ";
    if ($i % 3 == 2) echo "</tr>";
    $i++;
}
if ($i % 3 != 2) echo "</tr>";
echo "</table>~";
for ($j = 1; $j <= ($tot-1)/12+1; $j++) {
    echo "<button class='btn' onclick='ajax(".$j.")'>$j</button>";
}