<?php

session_start();

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
    <title>Watch List</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>

<!-- Buyers can watch auctions on items and receive emailed updates on bids
on those items including notifications when they are outbid.-->

<body>











<nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand" href="b-home.php">
                <img width="100" src="efast.png">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="col-md-auto">
            </div>

    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="b-myprofile.php"><img height="30px" src="img/user1.png"> <?php echo "Hi "; echo  $_SESSION['first_name'] ; echo " "; echo   $_SESSION['last_name'] ;   ?> </a></li>
        </ul>
    </div>

    <button style="margin-left: 10px" type="button" onclick="window.location='logout.php';" class="btn btn-outline-danger btn-sm ">Logout</button>


</nav>
























<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Your Watched Auctions</h2>
            <div class="table-responsive">
                <table id="mytable" class="table table-bordred table-striped">

                    <thead>
                    <th>Item Image</th>
                    <th>Item Name</th>
                    <th>Item Description</th>
                    <th>Current Highest Bid</th>
                    <th>Auction End Date</th>
                    <th>Seller</th>
                    <th>Remove</th>
                    </thead>
                    <tbody>



<?php include 'config.php'; ?>
<?php
$userID = $_SESSION['userID'];

$sql = "SELECT DISTINCT PIC, TITLE, DESCRIPTION, w.ID_AUCTION, EXPIRATION_TIME, FNAME, LNAME, w.ID FROM item i INNER JOIN auction a ON i.ID_ITEM = a.ID_ITEM 
              INNER JOIN user u ON u.ID_USER = a.ID_SELLER INNER JOIN watchlist w ON w.ID_AUCTION = a.ID_AUCTION WHERE w.ID_USER = '$userID'";

$result = $conn->query($sql);
// if there are no watched auctions:
if(!$result){$title = "";
    $descr = "";
    $fname = "";
    $lname = "";
    $expiration_datetime= "";
    $timeremaining="";
    $highestbid = "";
    $ID = "";
    $pic ="";}
    //otherwise:
    else{
    while($row = $result->fetch_assoc()) {
        $title = $row["TITLE"];
        $descr = $row["DESCRIPTION"];
        $fname = $row["FNAME"];
        $lname = $row["LNAME"];
        $expiration_datetime = $row["EXPIRATION_TIME"];
        $currentauctionID = $row["ID_AUCTION"];
        $ID = $row["ID"];
        $pic = $row["PIC"];
        $sql2 = "SELECT PRICE FROM bid WHERE ID_AUCTION = '$currentauctionID' ORDER BY PRICE DESC LIMIT 1";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
//if there are no bids:
        if(!$row2) {
            $highestbid = "No bids";
        }
        //otherwise:
        else {
            $highestbid = $row2["PRICE"];
        }
        $now = date('Y-m-d H:i:s');
        $expiration_datetime = $row["EXPIRATION_TIME"];
        $diff = strtotime($expiration_datetime) - strtotime($now);

        if ($diff > 0) {

            //  convert to days
            $temp = $diff / 86400; // 86400 secs in a day

            // days
            $days = floor($temp);
            $temp = 24 * ($temp - $days);
            // hours
            $hours = floor($temp);
            $temp = 60 * ($temp - $hours);
            // minutes
            $minutes = floor($temp);
            $temp = 60 * ($temp - $minutes);
            // seconds
            $seconds = floor($temp);

            if ($days > 0) {
                $timeremaining = "{$days} days {$hours} hours";
            } elseif ($hours > 0) {
                $timeremaining = "{$hours} hours {$minutes} minutes";
            } elseif ($minutes > 0) {
                $timeremaining = "{$minutes} minutes {$seconds} seconds";
            } elseif ($seconds > 0) {
                $timeremaining = "{$seconds} seconds";
            }
        }
        else {
                $timeremaining = "Auction Complete";
            }
?>

                    <tr>
                        <td><img src="<?php echo $pic?>" class="img-rounded" height="70" width="100"></td>
                        <td><?php echo $title?></td>
                        <td><?php echo $descr?></td>
                        <td><?php echo $highestbid?></td>
                        <td><?php echo $timeremaining?> </td>
                        <td> <?php echo $fname; echo " "; echo $lname?> </td>
                        <td> <a class="btn" href="deletewatched.php?ID=<?php echo $currentauctionID;?>"<button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></button></td>
                    </tr>

<?php }} ?>

                    </tbody>

                </table>


            </div>
        </div>
    </div>



</html>