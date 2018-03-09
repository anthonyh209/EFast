<?php

session_start();
require_once("config.php");

if(!isset($_GET['AUCTION_ID'])){echo 'No ID was given...'; exit;}
$ID = $_GET['ID'];
$sql = "DELETE FROM watchlist WHERE ID = $ID";

if ($conn->query($sql) === TRUE) {}
else {
    echo "Error deleting record: " . $conn->error;
}

header('Location: /Ebay-System/b-watch-page.php');
?>