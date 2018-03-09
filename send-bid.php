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

//picking up parameters from post
$id_auction="";
if (isset($_REQUEST['id_auction'])) {
    $id_auction=$_REQUEST["id_auction"];
} else {
    echo("NOT SETTING!!!!");
}
$id_buyer="";
if (isset($_REQUEST['id_user'])) {
    $id_buyer=$_REQUEST["id_user"];
}
$datetime="";
if (isset($_REQUEST['time'])) {
    $datetime=$_REQUEST["time"];
}
$price="";
if (isset($_REQUEST['price'])) {
    $price=$_REQUEST["price"];
}

$valid="";
$expired_flag="";

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

try {
    $sql = 'CALL CheckBidIsLargest(?,?,@valid,@expired_flag)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1,$id_auction);
    $stmt->bindParam(2,$price);

    $stmt->execute();
    $stmt->closeCursor();

    $r = $pdo->query("SELECT @valid,@expired_flag")->fetch(PDO::FETCH_ASSOC);
    if ($r){
        $valid=$r['@valid'];
        $expired_flag=$r['@expired_flag'];

    }
}
catch(PDOException $e)
{
    echo $e -> getMessage();
}

if ($expired_flag == 1){

    echo "Unfortunately the auction has expired and your bid did not reach in time.";
} else {

    if ($valid == 1){ //1 means valid. 0 means invalid.

        //Attempt to insert bid table
        try{
            $stmt = $pdo->query('INSERT INTO bid (ID_BUYER, ID_AUCTION, PRICE, TIME) VALUES ( \'' . $id_buyer . '\', \'' . $id_auction . '\' , \'' . $price. '\' , \'' . $datetime . '\')');
        }
        catch(PDOException $e)
        {
            echo $e -> getMessage();
        }

        //Attempt to update COUNTER column in auction table
        try{
            $stmt = $pdo->query('UPDATE auction SET COUNTER = COUNTER + 1 WHERE ID_AUCTION = \'' .$id_auction. '\'');


        }
        catch(PDOException $e)
        {
            echo $e -> getMessage();
        }

        //Attempt to insert watchlist table
        try{
            $stmt = $pdo->query('INSERT INTO watchlist (ID_AUCTION, ID_USER) VALUES ( \'' . $id_auction . '\' , \'' . $id_buyer . '\')');

        }
        catch(PDOException $e)
        {
            echo $e -> getMessage();
        }


    } else {
        echo "Your proposed bid is not the current highest bid for the auction. Another buyer may have just posted a larger bid. Please review bid history.";
    }
}








?>
