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
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$email=$request->email;
$pass=$request->pass;

//Define database connection parameters
    $hn = 'localhost';
    $un = 'root'; //username of database here
    $pwd = ''; //password for database here
    $db = 'efake'; //name for database here
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


//Attempt to query tests table and retrieve set of text files associated with tests_id
try{
    $stmt = $pdo->query('SELECT FNAME, LNAME FROM user WHERE EMAIL = \'' .$email. '\' AND PASS = \'' .$pass. '\'');

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
