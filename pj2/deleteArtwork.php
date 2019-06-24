<?php
/**
 * Created by IntelliJ IDEA.
 * User: 13805
 * Date: 2019/6/23
 * Time: 18:08
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pj2";
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("DELETE FROM artworks WHERE artworkID=".$_POST["id"]);