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

<?php
$userID = $_SESSION['userID'];
$email = $_SESSION['username'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$role = $_SESSION['role'];
$sql1 = "SELECT * FROM user WHERE ID_USER = '$userID'";
$result1 = $conn->query($sql1);
if (!$result1) {
    throw new Exception("Database Error1");
}
while($row = $result1->fetch_assoc()){
    $email = $row['EMAIL'];
}
// calculating average something score
$sql2 = "SELECT AVG(RATING_SCORE) FROM rating r INNER JOIN criteria_buyer c
 ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$userID'";
$result2 = $conn->query($sql2);
if (!$result2) {
    throw new Exception("Database Error2");
}
while($row2 = $result2->fetch_assoc()){
    $averagerating = $row2['AVG(RATING_SCORE)'];}
$averagerating = round($averagerating,1);

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
    <a class="navbar-brand" href="s-home.html">
        <img src="eFast.png" width="100" height="30" alt="">
    </a>
</nav>



<!-- Profile form -->

<div class="container">
    <h1 class="display-3"> &nbsp My Profile </h1>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default panel-info Profile">
                <div class="panel-body">
                    <div class="form-horizontal">
                        <form>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">First Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="firstName"
                                           placeholder="<?php echo $first_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Last Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="lastName"
                                           placeholder="<?php echo $last_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="email"
                                           placeholder="<?php echo $email;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5">
                                    <button class="btn btn-primary" ng-click="updateMe()">Update</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>  <!-- end form-horizontal -->
            </div> <!-- end panel-body -->

        </div> <!-- end panel -->


        <!-- Ratings section-->

        <div class="col-sm-3">
            <div class="rating-block">

                <h4>Average rating</h4>
                <h2 class="bold padding-bottom-7"> <?php echo $averagerating ?> <small>/ 5</small></h2>
                <?php if($averagerating >= 0.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($averagerating >= 1.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($averagerating >= 2.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($averagerating >= 3.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($averagerating >= 4.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>

        </div>
    </div>
    </div>

    <!-- potentially include review breakdown from the html file if there's time -->

    <!-- Review history.-->

    <?php

    $results_per_page = 5;

    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
    $start_from = ($page-1) * $results_per_page;
    $sql6 = "SELECT FNAME, LNAME, TIME_STAMP, COMMENT_HEADLINE, COMMENT, RATING_SCORE
              FROM rating r INNER JOIN criteria_buyer c ON r.ID_CRITERIA = c.ID_CRITERIA
              INNER JOIN user u ON u.ID_USER = r.ID_reviewer WHERE  r.ID_REVIEWEE = '$userID' ORDER BY TIME_STAMP DESC LIMIT $start_from, $results_per_page";
    $rs_result = $conn->query($sql6);
    if (!$rs_result) {
        throw new Exception("Database Error3");
    }
    ?>
    <h2> Review history </h2>
    <div class="row">
        <div class="col-sm-12">
            <div class="review-block">
                <?php
                while($row = $rs_result->fetch_assoc()) {
                $review_timestamp = $row["TIME_STAMP"];
                $review_timestamp = date("j F Y", strtotime($review_timestamp));
                ?>
                <hr/>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="review-block-name"><a><?php echo $row['FNAME']; echo " "; echo $row["LNAME"]?></a></div>
                        <div class="review-block-date"><?php echo $review_timestamp?></div>
                    </div>
                    <div class="col-sm-5">
                        <div class="review-block-title"><b><?php echo $row["COMMENT_HEADLINE"]?></b></div>
                        <div class="review-block-description"> <?php echo $row["COMMENT"]?></div>
                    </div>
                    <div class=""col-sm-3">
                    <div class="review-criteria1">
                        <?php $thisrating = $row["RATING_SCORE"];
                        if($thisrating >= 0.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($thisrating >= 1.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($thisrating >= 2.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($thisrating >= 3.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($thisrating >= 4.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                    </div>

                </div>
            </div>
            <?php
            };
            ?>
            <div class="clearfix"></div>
            <ul class="pagination pull-right">
                <li class="disabled"><a href="b-myprofile.php?page=1"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
                <?php
                $sql = "SELECT COUNT(*) AS total FROM rating WHERE TYPE = 1";
                $result6 = $conn->query($sql);
                $row = $result6->fetch_assoc();
                $total_pages = ceil($row["total"] / $results_per_page);

                for ($i=1; $i<=$total_pages; $i++) {
                    echo "<li class=\"active\"><a href='b-myprofile.php?page=".$i."'>".$i."</a></li>"; // need to fix this (or get rid of it)
                };
                ?>
                <?php if ($page == 1){$j = 1;}  // the GET_page doesnt give me the right page number...
                elseif ($page== $total_pages) {$j = $total_pages;}
                else {$j = $page+1;} ?>

                <li><?php echo "<a href='b-myprofile.php?page=".$j."'>"?><span class="glyphicon glyphicon-chevron-right"></span></a></li> <!-- need to fix this link -->
            </ul>

        </div>
    </div>

    <!-- Example numbered list:

            <div class="clearfix"></div>
            <ul class="pagination pull-right">
                <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
            </ul>

    -->


    <!-- Bid history -->

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>

    <div class="container">
        <div class="row">


            <div class="col-md-12">
                <h2>Bid History</h2>
                <hr/>
                <div class="table-responsive">


                    <table id="mytable" class="table table-bordred table-striped">

                        <thead>


                        <th>Item Name</th>
                        <th>Item Seller</th>
                        <th>Item Description</th>
                        <th>Your Bid</th>
                        <th>Auction Time Remaining</th>
                        <th>Bid Status</th>
                        <th>Delete</th>
                        </thead>
                        <tbody>

                        <?php $sql10 = "SELECT PRICE, ID_AUCTION FROM bid WHERE ID_BUYER = '$userID'";
                        $result10 = $conn->query($sql10);
                        if(!$result10) {throw new Exception("Database Error5");}
                        while($row10 = $result10->fetch_assoc()){
                            $currentauctionID = $row10['ID_AUCTION'];
                            $bidamount = $row10['PRICE'];
                            $sql11 = "SELECT TITLE, DESCRIPTION, EXPIRATION_TIME, FNAME, LNAME FROM auction a INNER JOIN item i ON a.ID_ITEM = i.ID_ITEM
                                      INNER JOIN user u ON u.ID_USER = a.ID_SELLER WHERE ID_AUCTION = '$currentauctionID' ORDER BY EXPIRATION_TIME DESC";
                            $result11 = $conn->query($sql11);
                            if(!$result11) {throw new Exception("Database Error6");}
                            $row11 = $result11->fetch_assoc();
                        $now = date('Y-m-d H:i:s');
                        $expiration_datetime = $row11["EXPIRATION_TIME"];
                        $diff=strtotime($expiration_datetime)-strtotime($now);

                        if($diff>0) {

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
                            } elseif (hours > 0) {
                                $timeremaining = "{$hours} hours {$minutes}";
                            } elseif (minutes > 0) {
                                $timeremaining = "{$minutes} minutes {$seconds} seconds";
                            } elseif (seconds > 0) {
                                $timeremaining = "{$seconds} seconds";
                            }
                        }
                        else {$timeremaining = "Auction Complete";}


                        $sql12 = "SELECT PRICE FROM bid WHERE ID_AUCTION = '$currentauctionID' ORDER BY PRICE DESC LIMIT 1";
                        $result12 = $conn->query($sql12);
                        $row12 = $result12->fetch_assoc();
                        $highestbid = $row12['PRICE'];
                        if ($highestbid > $bidamount){$bidstatus = 'Outbid';}
                        elseif ($highestbid = $bidamount && $timeremaining == "Auction Complete") {$bidstatus = 'Bid Successful';}
                        elseif ($highestbid = $bidamount && $timeremaining != "Auction Complete") {$bidstatus = 'Highest Bid';}
                        $m=1;
                        ?>

                            <tr>
                                <td><?php echo $row11["TITLE"]?></td>
                                <td><?php echo $row11["FNAME"]; echo " ";echo $row11["LNAME"]?></td>
                                <td><?php echo $row11["DESCRIPTION"]?></td>
                                <td><?php echo $bidamount?></td>
                                <td><?php echo $timeremaining ?></td>
                                <td><?php echo $bidstatus?></td>
                                <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" <?php echo "data-target='#delete".$m."'"?>><span class="glyphicon glyphicon-trash"></span></button></p></td>
                            </tr>

                            <div class="modal fade" <?php echo "id='delete".$m."'" ?> tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                <php if $
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                            <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this bid?</div>

                                        </div>
                                        <div class="modal-footer ">
                                            <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        <?php }  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- This section is the delete auction confirmation - but this isn't in the required features -->

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <php if $
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this bid?</div>

                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</body>

</html>


