<?php
/**
 * Created by PhpStorm.
 * User: frazahmad
 * Date: 27/02/2018
 * Time: 15:22
 */


$con=mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to the efast database: " . mysqli_connect_error();
}else{
    echo "Hello";
}


mysqli_close($con);
?>
