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
// calculating average authenticity score
$sql2 = "SELECT AVG(AUTHENTICITY) FROM rating r INNER JOIN criteria_seller c
 ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$userID'";
$result2 = $conn->query($sql2);
if (!$result2) {
    throw new Exception("Database Error2");
}
while($row2 = $result2->fetch_assoc()){
$authenticityscore = $row2['AVG(AUTHENTICITY)'];}
$authenticityscore = round($authenticityscore, 1);
// calculating average responsiveness score
$sql3 = "SELECT AVG(RESPONSIVENESS) FROM rating r INNER JOIN criteria_seller c
 ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$userID'";
$result3 = $conn->query($sql3);
if (!$result3) {
    throw new Exception("Database Error2");
}
while($row3 = $result3->fetch_assoc()){
    $responsivenessscore = $row3['AVG(RESPONSIVENESS)'];}
$responsivenessscore = round($responsivenessscore, 1);
// calculating average dispatch_time score
$sql4 = "SELECT AVG(DISPATCH_TIME) FROM rating r INNER JOIN criteria_seller c
 ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$userID'";
$result4 = $conn->query($sql4);
if (!$result4) {
    throw new Exception("Database Error2");
}
while($row4 = $result4->fetch_assoc()){
    $dispatchtimescore = $row4['AVG(DISPATCH_TIME)'];}
$dispatchtimescore = round($dispatchtimescore, 1);
// calculating average something score
$sql5 = "SELECT AVG(DISPATCH_FEE) FROM rating r INNER JOIN criteria_seller c
 ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$userID'";
$result5 = $conn->query($sql5);
if (!$result5) {
    throw new Exception("Database Error2");
}
while($row5 = $result5->fetch_assoc()){
    $dispatchfeescore = $row5['AVG(DISPATCH_FEE)'];}
$dispatchfeescore = round($dispatchfeescore,1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller MyProfile</title>
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

<!--This is the seller's MyProfile page. It should include:
 - Account information
 - average rating
 - user feedback history
 - auction history
 -->


<body>


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
                                    <button class="btn btn-primary" href="deletewatched.php?ID=user<?php echo $userID;?>"> Update </button>
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

                <h4>Authenticity</h4>
                <h2 class="bold padding-bottom-7"> <?php echo $authenticityscore ?> <small>/ 5</small></h2>
                <?php if($authenticityscore >= 0.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($authenticityscore >= 1.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($authenticityscore >= 2.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($authenticityscore >= 3.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($authenticityscore >= 4.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>



                <h4><br>Responsiveness</h4>
                <h2 class="bold padding-bottom-7"> <?php echo $responsivenessscore ?> <small>/ 5</small></h2>
                <?php if($responsivenessscore >= 0.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($responsivenessscore >= 1.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($responsivenessscore >= 2.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($responsivenessscore >= 3.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($responsivenessscore >= 4.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="rating-block">

                <h4>Dispatch Time</h4>
                <h2 class="bold padding-bottom-7"> <?php echo $dispatchtimescore ?> <small>/ 5</small></h2>
                <?php if($dispatchtimescore >= 0.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($dispatchtimescore >= 1.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($dispatchtimescore >= 2.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($dispatchtimescore >= 3.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($dispatchtimescore >= 4.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>

                <h4><br>Dispatch Fees</h4>
                <h2 class="bold padding-bottom-7"> <?php echo $dispatchfeescore ?> <small>/ 5</small></h2>
                <?php if($dispatchfeescore >= 0.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($dispatchfeescore >= 1.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($dispatchfeescore >= 2.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($dispatchfeescore >= 3.5){ ?>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php }
                else { ?> <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button> <?php } ?>
                <?php if($dispatchfeescore >= 4.5){ ?>
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


    <!-- This is the review history.-->
    <?php

    $results_per_page = 5;

    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
    $start_from = ($page-1) * $results_per_page;
    $sql6 = "SELECT FNAME, LNAME, TIME_STAMP, COMMENT_HEADLINE, COMMENT, AUTHENTICITY, RESPONSIVENESS, DISPATCH_TIME, DISPATCH_FEE
              FROM rating r INNER JOIN criteria_seller c ON r.ID_CRITERIA = c.ID_CRITERIA
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
                <div class="col-sm-6">
                    <div class="review-block-title"><b><?php echo $row["COMMENT_HEADLINE"]?></b></div>
                    <div class="review-block-description"> <?php echo $row["COMMENT"]?></div>
                </div>
                <div class=""col-sm-3">
                <div class="review-criteria1"><a> Authenticity: <?php echo $row["AUTHENTICITY"]?>/5</a></div>
                <div class="review-criteria2"><a>Responsiveness: <?php echo $row["RESPONSIVENESS"]?>/5</a></div>
                <div class="review-criteria3"><a>Dispatch Time: <?php echo $row["DISPATCH_TIME"]?>/5</a></div>
                <div class="review-criteria4"><a>Dispatch Fees: <?php echo $row["DISPATCH_FEE"]?>/5</a></div>
                </div>
            </div>
            <?php
        };
        ?>
                <div class="clearfix"></div>
                <ul class="pagination pull-right">
                    <li class="disabled"><a href="s-myprofile.php?page=1"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
<?php
$sql = "SELECT COUNT(*) AS total FROM rating r INNER JOIN user u ON r.ID_REVIEWEE = u.ID_USER WHERE u.ID_ROLE = 'ROLE_02'";
    $result6 = $conn->query($sql);
    $row = $result6->fetch_assoc();
    $total_pages = ceil($row["total"] / $results_per_page);

    for ($i=1; $i<=$total_pages; $i++) {
        echo "<li class=\"active\"><a href='s-myprofile.php?page=".$i."'>".$i."</a></li>"; // need to fix this (or get rid of it)
    };
    ?>
                    <?php if ($page == 1){$j = 1;}  // the GET_page doesnt give me the right page number...
                    elseif ($page == $total_pages) {$j = $total_pages;}
                    else {$j = $page+1;} ?>

                    <li><?php echo "<a href='s-myprofile.php?page=".$j."'>"?><span class="glyphicon glyphicon-chevron-right"></span></a></li> <!-- need to fix this link -->
    </ul>

            </div>
        </div>

    <!-- could also use stars for the ratings: see below-->

<?php /* <div class="review-criteria1"><a> Authenticity: &nbsp; <?php
                        if($row["AUTHENTICITY"] >= 0.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["AUTHENTICITY"] >= 1.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["AUTHENTICITY"] >= 2.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["AUTHENTICITY"] >= 3.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["AUTHENTICITY"] >= 4.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                    </a></div>
                <div class="review-criteria2"><a>Responsiveness:  <?php
                        if($row["RESPONSIVENESS"] >= 0.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["RESPONSIVENESS"] >= 1.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["RESPONSIVENESS"] >= 2.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["RESPONSIVENESS"] >= 3.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["RESPONSIVENESS"] >= 4.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?></a></div>

                <div class="review-criteria3"><a>Dispatch Time:  <?php
                        if($row["DISPATCH_TIME"] >= 0.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["DISPATCH_TIME"] >= 1.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["DISPATCH_TIME"] >= 2.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["DISPATCH_TIME"] >= 3.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["DISPATCH_TIME"] >= 4.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?></a></div>

                <div class="review-criteria4"><a>Dispatch Fees:  <?php
                        if($row["DISPATCH_FEE"] >= 0.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["DISPATCH_FEE"] >= 1.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["DISPATCH_FEE"] >= 2.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["DISPATCH_FEE"] >= 3.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?>
                        <?php if($row["DISPATCH_FEE"] >= 4.5){ ?>
                            <span class="fa fa-star checked"></span>
                        <?php }
                        else { ?> <span class="fa fa-star"></span> <?php } ?></a></div>
                </div>
 */ ?>


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

<!-- /container -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Auction History</h2>
                <hr/>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">

                        <thead>
                        <th>Item Name</th>
                        <th>Item Description</th>
                        <th>Time Remaining</th>
                        <th>Most Recent Bid</th>
                        <th>Views</th>
                        <th>Cancel Auction</th>
                        </thead>
                        <tbody>



<?php $sql7 = "SELECT TITLE, DESCRIPTION, EXPIRATION_TIME, ID_AUCTION FROM auction a INNER JOIN item i ON a.ID_ITEM = i.ID_ITEM WHERE a.ID_SELLER = '$userID'";
$result7 = $conn->query($sql7);
if (!$result7) {
    throw new Exception("Database Error4");
}

while($row7 = $result7->fetch_assoc()){
    $currentauction = $row7["ID_AUCTION"];
    $sql8 = "SELECT COUNT(*) AS total FROM traffic WHERE ID_AUCTION = '$currentauction'";
$result8 = $conn->query($sql8);
$row8 = $result8->fetch_assoc();
$total_views = $row8['total'];
$sql9 = "SELECT PRICE FROM bid WHERE ID_AUCTION= '$currentauction' ORDER BY TIME LIMIT 1";
$result9 = $conn->query($sql9);
$row9 = $result9->fetch_assoc();
if(!$row9) {$most_recent_bid = "No bids";}
else{
$most_recent_bid = $row9['PRICE'];}
$now = date('Y-m-d H:i:s');
$expiration_datetime = $row7["EXPIRATION_TIME"];

    $diff=strtotime($expiration_datetime)-strtotime($now);
    if($diff>0) {

// immediately convert to days
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
            $timeremaining = "{$hours} hours {$minutes}";
        } elseif ($minutes > 0) {
            $timeremaining = "{$minutes} minutes {$seconds} seconds";
        } elseif ($seconds > 0) {
            $timeremaining = "{$seconds} seconds";
        }
    }
    else {$timeremaining = "Auction Complete";}


?>


                    <tr>
                        <td><?php echo $row7["TITLE"]?></td>
                        <td><?php echo $row7["DESCRIPTION"]?></td>
                        <td><?php echo $timeremaining?></td>
                        <td><?php echo $most_recent_bid?></td>
                        <td><?php echo $total_views?></td>
                        <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
                    </tr>

                        <?php }  ?>





                    </tbody>

                </table>

            </div>

        </div>
    </div>
</div>

<!-- This section is the delete auction confirmation - but this isn't in the required features -->

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to cancel this auction?</div>

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


