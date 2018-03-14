<?php
/**
 * Created by PhpStorm.
 * User: niecy
 * Date: 25/11/2017
 * Time: 19:42
 * Typescript passes test_id to PHP file. Queries tests table and retrieves data for test_id.
 */

//instruct the PHP script to allow a request from ANY domain by using the wildcard
header('Access-Control-Allow-Origin:*');

session_start();
$id_buyer = $_SESSION['userID'];
$id_auction=$_REQUEST["auctionID"];

//picking up parameters from post
//$id_auction=$_REQUEST["id_auction"];
//$id_user=$_REQUEST["id_user"];

//Define database connection parameters
    $hn = 'efastdbs.mysql.database.azure.com';
    $un = 'efast@efastdbs'; //username of database here
    $pwd = 'Gv3-LST-nZU-JyP'; //password for database here
    $db = 'efast_main'; //name for database here
    $cs = 'utf8';

//Set up the PDO parameters
$dsn = "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
$opt = array(
    PDO::ATTR_ERRMODE   =>  PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES  =>  false,
);

//Create a PDO instance (connect to the database)
$pdo = new PDO($dsn, $un, $pwd, $opt);

//Attempt to insert watchlist table
try{
    $stmt = $pdo->query('CALL AddWatchList ( \'' . $id_auction . '\' , \'' . $id_buyer . '\')');

}
catch(PDOException $e)
{
    echo $e -> getMessage();
}




?>
