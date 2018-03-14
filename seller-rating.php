<?php

session_start();
require_once("config.php");

//buyer giving seller a rating
$reviewer = $_SESSION['userID'];

//$reviewer = "ID_001032";
$auctionID = $_GET['aID'];
//$auctionID = "AU_000065";

//echo $reviewer2; echo $auctionID2; echo $reviewer; echo $auctionID;

// getting the seller details
$sql = "SELECT ID_SELLER, FNAME, LNAME, FEEDBACK_S, EXPIRATION_TIME FROM auction INNER JOIN user ON ID_SELLER = ID_USER WHERE ID_AUCTION = '$auctionID'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $reviewee = $row['ID_SELLER'];
    $FNAME = $row['FNAME'];
    $LNAME = $row['LNAME'];
    $FEEDBACK_S = $row['FEEDBACK_S'];
    $expiration_datetime = $row['EXPIRATION_TIME'];

}

$verification = 0;
$now = date('Y-m-d H:i:s'); //getting current time
$diff = strtotime($expiration_datetime) - strtotime($now);


// why are you checking expired?
if ($diff <= 0) {
    $expired = 1;
} else {
    $expired = 0;
}

//getting the buyer details, the one with the highest bid
$sql2 = "SELECT ID_BUYER FROM bid WHERE ID_AUCTION = '$auctionID' ORDER BY PRICE DESC LIMIT 1";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$ID_BUYER = $row2['ID_BUYER'];
if ($ID_BUYER == $reviewer) {
    $verification = 1;
}
echo $verification;

if ($FEEDBACK_S == 0 && $expired == 1 && $verification == 1) {

    if (isset($_POST['submit'])) {

        $authen = $_POST['rating-authen'];
        $response = $_POST['rating-response'];
        $speed = $_POST['rating-speed'];
        $fee = $_POST['rating-fee'];
        $textdesc = $_POST['rating-comment'];
        $title = $_POST['rating-title'];
        date_default_timezone_set('Europe/London');
        $startdate = new DateTime();
        $start = $startdate->format("Y-m-d H:i:s");


        $sql = 'INSERT INTO criteria_seller (id_criteria, authenticity, responsiveness, dispatch_time, dispatch_fee) VALUES (NULL, ?,?,?,?)';
        $itemSTMT = $conn->prepare($sql);
        $itemSTMT->bind_param("iiii", $authen, $response, $speed, $fee);
        $itemSTMT->execute();


        $id = mysqli_insert_id($conn); //retrieves just inserted new item
        echo $id;
        $Item_Query = "SELECT * FROM criteria_seller WHERE ID = '$id'";
        $ExecQuery2 = MySQLi_query($conn, $Item_Query);
        while ($row = mysqli_fetch_array($ExecQuery2)) {
            $rating_criteria = $row['ID_CRITERIA'];
            //echo $rating_criteria;
            $auctionSQL = 'INSERT INTO rating (id_rating, id_reviewer, id_reviewee, comment, id_criteria, comment_headline, time_stamp) VALUES (NULL, ?, ?, ?, ?, ?,?)';
            $auctionSTMT = $conn->prepare($auctionSQL);
            $auctionSTMT->bind_param("ssssss", $reviewer, $reviewee, $textdesc, $rating_criteria, $title, $start);
            $auctionSTMT->execute();
        }

        $sql3 = "UPDATE auction SET  FEEDBACK_S = 1 WHERE ID_AUCTION = '$auctionID'";
        if ($conn->query($sql3) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        header('Location: /Ebay-System/b-myprofile.php');

    }
} elseif ($row['FEEDBACK_S'] == 1 && $expired == 1 && verification == 1) {
    echo "Feedback already given.";
} else {
    echo "You're not allowed to give feedback.";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta charset="UTF-8">
        <title>Feedback</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        -->

        <style class="cp-pen-styles">body {
                background-color: #f3f5f7;
                font-family: 'Helvetica Neue', Arial, sans-serif;
            }

            .card {
                background-color: #fff;
                box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                max-width: 300px;
                height: 375px;
                border-radius: 10px;
                overflow: hidden;
            }

            .card .about {
                height: 225px;
                padding: 20px;
                box-sizing: border-box;
            }

            .card .about h3,
            .card .about .lead {
                font-weight: 300;
                margin: 0;
            }

            .card .about h3 {
                font-size: 24px;
            }

            .card .about .lead {
                color: #aaa;
            }

            .card .info {
                float: left;
                padding: 10px 30px 10px 0;
            }

            .card .info p {
                font-size: 11px;
                color: #aaa;
                font-weight: 300;
            }

        </style>
    </head>

    <!--List of auctions, items, users. Analytics.-->


<body>
<div class="card" style="height:auto; width:auto;">
    <div class="col-sm-12" style="height:auto; width:auto;">
        <!-- Custom information -->
        <div class="about" style="height:auto; width:auto;">
            <h3>Provide feedback for <?php echo "$FNAME $LNAME" ?> </h3>
            <form action="<?php echo "seller-rating.php?aID=".$auctionID.""?>" role="form" method="post" enctype="multipart/form-data">
                <div class="spacer" style="height:20px"></div>
                <center>
                    <h7>Authenticity</h7>
                </center>
                <!--<select class="custom-select" id="inputGroupSelect01">-->
                <select id="rating-aut" name="rating-authen" class="form-control">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
                <div class="spacer" style="height:5px"></div>
                <center>
                    <h7>Responsiveness</h7>
                </center>
                <!--<select class="custom-select" id="inputGroupSelect01">-->
                <select id="rating-response" name="rating-response" class="form-control">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
                <div class="spacer" style="height:5px"></div>
                <center>
                    <h7>Delivery Dispatch Time</h7>
                </center>
                <!--<select class="custom-select" id="inputGroupSelect01">-->
                <select id="rating-time" name="rating-speed" class="form-control">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
                <div class="spacer" style="height:5px"></div>
                <center>
                    <h7>Delivery Dispatch Fee</h7>
                </center>
                <!--Dispatch Fee-->
                <select id="rating-fee" name="rating-fee" class="form-control">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>

                <div class="spacer" style="height:20px"></div>
                <center>
                    <h7>Additional comments</h7>
                </center>
                <textarea class="form-control" aria-label="With textarea" id="item-description"
                          name="rating-comment" required></textarea>
                <div class="spacer" style="height:10px"></div>
                <div class="form-group">
                    <label for="usr">Rating Title:</label>
                    <input type="text" class="form-control" id="usr" name="rating-title">
                </div>
                <div class="spacer" style="height:10px"></div>
                <input type='submit' class="btn btn-info" value="Submit Button" name='submit'>
            </form>
        </div>
    </div>
</div>



</body>
</html>