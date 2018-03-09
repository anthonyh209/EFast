<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 09/03/2018
 * Time: 16:24
 */
$conn = mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if (isset($_POST['submit'])) {

    $score = $_POST['rating-score'];
    $textdesc = $_POST['rating-comment'];
    $title = $_POST['rating-title'];
    $startdate = new DateTime();
    $start = $startdate->format("Y-m-d H:i:s");


    $sql = 'INSERT INTO criteria_buyer (id_criteria, rating_score) VALUES (NULL, ?)';
    $itemSTMT = $conn->prepare($sql);
    $itemSTMT->bind_param("i", $score);
    $itemSTMT->execute();

    $id = mysqli_insert_id($conn); //retrieves just inserted new item
    //echo $id;
    $Item_Query = "SELECT * FROM criteria_buyer WHERE ID = '$id'";
    $ExecQuery2 = MySQLi_query($conn, $Item_Query);
    while ($row = mysqli_fetch_array($ExecQuery2)) {
        $rating_criteria = $row['ID_CRITERIA'];
        //echo $rating_criteria;
        $reviewer = 'hiasdf'; //later change with the user session id
        $reviewee = 'INST2302';
        $auctionSQL = 'INSERT INTO rating (id_rating, id_reviewer, id_reviewee, comment, id_criteria, comment_headline, time_stamp) VALUES (NULL, ?, ?, ?, ?, ?,?)';
        $auctionSTMT = $conn->prepare($auctionSQL);
        $auctionSTMT->bind_param("ssssss", $reviewer, $reviewee, $textdesc, $rating_criteria, $title, $start);
        $auctionSTMT->execute();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta charset="UTF-8">
        <title>Create an Auction</title>
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
            <h3>Provide a new rating for buyer</h3>
            <form action="buyer-rating.php" role="form" method="post" enctype="multipart/form-data">
                <div class="spacer" style="height:20px"></div>
                <center>
                    <h7>Rating Score</h7>
                </center>
                <!--<select class="custom-select" id="inputGroupSelect01">-->
                <select id="rating-score" name="rating-score" class="form-control">
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