<?php
/**
 * Created by PhpStorm.
 * User: frazahmad
 * Date: 09/03/2018
 * Time: 14:29
 */
session_start();
$value = $_POST['submit'];

$_SESSION['auctionID'] = $value;

echo "<script> location.href='./b-bidpage.html'; </script>";

?>

