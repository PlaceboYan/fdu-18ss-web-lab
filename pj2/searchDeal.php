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
$sql="SELECT * FROM artworks WHERE title LIKE '%$key%' OR artist LIKE '%$key%' OR description LIKE '%$key%'";
if ($_GET["order"]=='4') $sql=$sql." ORDER BY view DESC";
if ($_GET["order"]=='5') $sql=$sql." ORDER BY price DESC";
//if ($_GET["name"]!='null' && $_GET["name"]!='') $sql=$sql." AND artist='".$_GET["name"]."'";
$sql=$sql." LIMIT " . (12 * $page - 12) . ",12";
$result = $conn->query($sql);
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
echo "</table>";