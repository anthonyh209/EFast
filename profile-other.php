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

// end of error code


$other_profileID = $_GET['uID'];
$sql = "SELECT ID_ROLE, FNAME, LNAME, EMAIL FROM user WHERE ID_USER = '$other_profileID'";
$result =$conn->query($sql);
$row = $result->fetch_assoc();
$first_name = $row['FNAME'];
$last_name = $row['LNAME'];
$email = $row['EMAIL'];
if ($row["ID_ROLE"] == "ROLE_01") {

// calculating average score
    $sql2 = "SELECT AVG(RATING_SCORE) FROM rating r INNER JOIN criteria_buyer c
 ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$other_profileID'";
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
        <title><?php echo "$first_name $last_name's Profile"?></title>
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
        <h1 class="display-3"> &nbsp <?php echo "$first_name $last_name's Profile"?> </h1>
        <div class="row">



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

        $sql6 = "SELECT FNAME, LNAME, TIME_STAMP, COMMENT_HEADLINE, COMMENT, RATING_SCORE
              FROM rating r INNER JOIN criteria_buyer c ON r.ID_CRITERIA = c.ID_CRITERIA
              INNER JOIN user u ON u.ID_USER = r.ID_reviewer WHERE  r.ID_REVIEWEE = '$other_profileID' ORDER BY TIME_STAMP DESC";
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


    </div>
    </body>




<?php }

// SELLER PROFILE



elseif($row["ID_ROLE"] == "ROLE_02") { ?>

<?php
    // calculating average authenticity score
    $sql2 = "SELECT AVG(AUTHENTICITY) FROM rating r INNER JOIN criteria_seller c
    ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$other_profileID'";
    $result2 = $conn->query($sql2);
    if (!$result2) {
    throw new Exception("Database Error2");
    }
    while($row2 = $result2->fetch_assoc()){
    $authenticityscore = $row2['AVG(AUTHENTICITY)'];}
    $authenticityscore = round($authenticityscore, 1);
    // calculating average responsiveness score
    $sql3 = "SELECT AVG(RESPONSIVENESS) FROM rating r INNER JOIN criteria_seller c
    ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$other_profileID'";
    $result3 = $conn->query($sql3);
    if (!$result3) {
    throw new Exception("Database Error2");
    }
    while($row3 = $result3->fetch_assoc()){
    $responsivenessscore = $row3['AVG(RESPONSIVENESS)'];}
    $responsivenessscore = round($responsivenessscore, 1);
    // calculating average dispatch_time score
    $sql4 = "SELECT AVG(DISPATCH_TIME) FROM rating r INNER JOIN criteria_seller c
    ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$other_profileID'";
    $result4 = $conn->query($sql4);
    if (!$result4) {
    throw new Exception("Database Error2");
    }
    while($row4 = $result4->fetch_assoc()){
    $dispatchtimescore = $row4['AVG(DISPATCH_TIME)'];}
    $dispatchtimescore = round($dispatchtimescore, 1);
    // calculating average something score
    $sql5 = "SELECT AVG(DISPATCH_FEE) FROM rating r INNER JOIN criteria_seller c
    ON r.ID_CRITERIA = c.ID_CRITERIA WHERE  r.ID_REVIEWEE = '$other_profileID'";
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
            .button2 {
                background-color: #4CAF50;
                align-self: center;
            }
            .button3 {
                background-color: #D3D3D3;
                align-self: center;
            }
        </style>
    </head>


    <body>




    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <a class="navbar-brand" href="s-home.php">
            <img width="100" src="efast.png">
        </a>

        <ul class="navbar-nav ml-auto">
            <button style="margin-left: 10px" type="button" onclick="window.location='logout.php';" class="btn btn-outline-danger btn-sm ">Logout</button>
        </ul>


    </nav>



    <!-- Profile form -->

    <div class="container">
        <h1 class="display-3"> &nbsp <?php echo "$first_name $last_name's Profile"?> </h1>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default panel-info Profile">
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">First Name:</label>
                                <div class="col-sm-9">
                                    <h5> <?php echo $first_name;?> </h5>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Last Name:</label>
                                <div class="col-sm-9">
                                    <h5> <?php echo $last_name;?> </h5>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email:</label>
                                <div class="col-sm-9">
                                    <h5> <?php echo $email;?> </h5>
                                </div>
                            </div>
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

        $sql6 = "SELECT FNAME, LNAME, TIME_STAMP, COMMENT_HEADLINE, COMMENT, AUTHENTICITY, RESPONSIVENESS, DISPATCH_TIME, DISPATCH_FEE
              FROM rating r INNER JOIN criteria_seller c ON r.ID_CRITERIA = c.ID_CRITERIA
              INNER JOIN user u ON u.ID_USER = r.ID_reviewer WHERE  r.ID_REVIEWEE = '$other_profileID' ORDER BY TIME_STAMP DESC";
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
        </div>



        <?php } ?>


</html>
