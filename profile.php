<?php

session_start();
require_once("config.php");
$currentuser = $_SESSION['user_id'];
$userprofile = "insert here the clicked on user id";

$sql = "SELECT ID_ROLE FROM user WHERE ID_USER = '$currentuser'";
$result = $conn->query($sql);
if (!$result) {
    throw new Exception("Database Error2");
}
$row = $result->fetch_assoc();
$userrole = $row["ID_ROLE"];

if ($userprofile == $currentuser && $userrole == "ROLE_01") {
    include(b-myprofile.php);}
elseif ($userprofile == $currentuser && userrole == "ROLE_02"){
    include(s-myprofile.php);}
else (include(profile-other.php));

?>