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
$id_user = $_SESSION['userID'];
$id_auction=$_SESSION["auctionID"];

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

try{
    $stmt = $pdo->query('INSERT INTO traffic (ID_AUCTION, ID_USER, DATETIME) VALUES ( \'' . $id_auction . '\', \'' . $id_user . '\', Now() )');
}
catch(PDOException $e)
{
    echo $e -> getMessage();
}


//Attempt to query tests table and retrieve set of text files associated with tests_id
try{
    $stmt = $pdo->query('SELECT ite.TITLE, ite.DESCRIPTION, auc.START_PRICE, UNIX_TIMESTAMP(auc.START_TIMESTAMP) AS START_TIMESTAMP, UNIX_TIMESTAMP(auc.EXPIRATION_TIME) AS EXPIRATION_TIME, cat.CATEGORY, sta.STATE FROM (((item ite
INNER JOIN auction auc ON auc.ID_ITEM = ite.ID_ITEM)
INNER JOIN category cat ON ite.ID_CATEGORY = cat.ID_CATEGORY)
INNER JOIN state sta ON ite.ID_STATE = sta.ID_STATE)
WHERE auc.ID_AUCTION = \'' .$id_auction. '\'');

    while($row = $stmt -> fetch(PDO::FETCH_OBJ))
    {
        //Assign each row of data to associative array
        $data[] = $row;
    }

    echo json_encode($data);

}
catch(PDOException $e)
{
    echo $e -> getMessage();
}


?>
