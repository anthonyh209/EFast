<?php

session_start();
require_once("config.php");

?>
<?php

// ----------------------------------------------------------------------------------------------------
// - Display Errors
// ----------------------------------------------------------------------------------------------------
ini_set('display_errors', 'On');
ini_set('html_errors', 0);

// ----------------------------------------------------------------------------------------------------
// - Error Reporting
// ----------------------------------------------------------------------------------------------------
error_reporting(-1);

// ----------------------------------------------------------------------------------------------------
// - Shutdown Handler
// ----------------------------------------------------------------------------------------------------
function ShutdownHandler()
{
    if(@is_array($error = @error_get_last()))
    {
        return(@call_user_func_array('ErrorHandler', $error));
    };

    return(TRUE);
};

register_shutdown_function('ShutdownHandler');

// ----------------------------------------------------------------------------------------------------
// - Error Handler
// ----------------------------------------------------------------------------------------------------
function ErrorHandler($type, $message, $file, $line)
{
    $_ERRORS = Array(
        0x0001 => 'E_ERROR',
        0x0002 => 'E_WARNING',
        0x0004 => 'E_PARSE',
        0x0008 => 'E_NOTICE',
        0x0010 => 'E_CORE_ERROR',
        0x0020 => 'E_CORE_WARNING',
        0x0040 => 'E_COMPILE_ERROR',
        0x0080 => 'E_COMPILE_WARNING',
        0x0100 => 'E_USER_ERROR',
        0x0200 => 'E_USER_WARNING',
        0x0400 => 'E_USER_NOTICE',
        0x0800 => 'E_STRICT',
        0x1000 => 'E_RECOVERABLE_ERROR',
        0x2000 => 'E_DEPRECATED',
        0x4000 => 'E_USER_DEPRECATED'
    );

    if(!@is_string($name = @array_search($type, @array_flip($_ERRORS))))
    {
        $name = 'E_UNKNOWN';
    };

    return(print(@sprintf("%s Error in file \xBB%s\xAB at line %d: %s\n", $name, @basename($file), $line, $message)));
};

$old_error_handler = set_error_handler("ErrorHandler");

// other php code

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buyer MyProfile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/profile.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .checked {
            color: orange;
        }
    </style>
</head>

<body>

<!-- nav bar -->

<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand">
        <img src="eFast.png" width="100" height="30" alt="">
    </a>
</nav>


    <!-- Bid history -->

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>

    <div class="container">
        <button type="button" class="btn btn-default btn-sm" onclick="window.location='./admin-home.php';"><i class="glyphicon glyphicon-arrow-left"></i> Back to Home</button>
        <div class="row">


            <div class="col-md-12">
                <h2>All Buyers</h2>
                <hr/>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">

                        <thead>
                        <th>ID User</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Number of bids made</th>
                        </thead>
                        <tbody>

                        <?php
                        $sql11 = "SELECT ID_USER, FNAME, LNAME FROM user WHERE ID_ROLE = 'ROLE_01'";
                        $result11 = $conn->query($sql11);
                        if(!$result11) {throw new Exception("Database Error6");}
                        while($row11 = $result11->fetch_assoc()){
                            $currentuser = $row11['ID_USER'];
                            $fname = $row11['FNAME'];
                            $lname = $row11['LNAME'];


                        $sql12 = "SELECT COUNT(ID_BUYER) as HELLO FROM bid WHERE ID_BUYER = '$currentuser'";
                        $result12 = $conn->query($sql12);
                        if(!$result12) {throw new Exception("Database Error7");}
                        $row12 = $result12->fetch_assoc();
                        $count = $row12['HELLO'];
                            ?>

                            <tr>
                                <td><?php echo $currentuser?></td>
                                <td><?php echo $fname?></td>
                                <td><?php echo $lname ?></td>
                                <td><?php echo $count ?></td>
                            </tr>


                        <?php }  ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-12">
                <h2>All Sellers</h2>
                <hr/>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">


                    <thead>
                    <th>ID User</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Number of auctions created</th>
                    </thead>
                    <tbody>

                    <?php
                    $sql15 = "SELECT ID_USER, FNAME, LNAME FROM user WHERE ID_ROLE ='ROLE_02'";
                    $result15 = $conn->query($sql15);
                    if(!$result15) {throw new Exception("Database Error7");}
                    while($row15 = $result15->fetch_assoc()){
                        $userID = $row15['ID_USER'];
                        $fname = $row15['FNAME'];
                        $lname = $row15['LNAME'];

                        $sql14 = "SELECT COUNT(ID_SELLER) as HI FROM auction WHERE ID_SELLER = '$userID'";
                        $result14 = $conn->query($sql14);
                        if(!$result14) {throw new Exception("Database Error7");}
                        $row14 = $result14->fetch_assoc();
                        $scount = $row14['HI'];
                        ?>
                        <tr>
                            <td><?php echo $userID ?></td>
                            <td><?php echo $fname ?></td>
                            <td><?php echo $lname ?></td>
                            <td><?php echo $scount ?></td>
                        </tr>


                    <?php }  ?>
                    </tbody>
                    </table>
                </div>
            </div>
    </div>




</body>

</html>


