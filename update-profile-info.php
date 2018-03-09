<?php

session_start();
require_once("config.php");

if(!isset($_GET['userID'])){echo 'No userID was given...'; exit;}
$ID = $_GET['userID'];
$sql = "UPDATE FROM watchlist WHERE ID = $ID";

if ($conn->query($sql) === TRUE) {}
else {
    echo "Error deleting record: " . $conn->error;
}

header('Location: /Ebay-System/b-watch-page.php');
?>