<?php
/**
 * Created by PhpStorm.
 * User: frazahmad
 * Date: 27/02/2018
 * Time: 15:22
 */


//instruct the PHP script to allow a request from ANY domain by using the wildcard
header('Access-Control-Allow-Origin:*');

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


?>