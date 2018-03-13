<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 11/03/2018
 * Time: 00:30
 */

$conn = mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {




    if (!is_numeric($length)) {
        echo "Please provide numerical values for your duration";
    } else {
        if ($length < 0) {
            echo "Your duration must be positive";
        } else {
            echo "Your price values are negative";
            $length = $_POST["duration-length"];
            echo $length;
            $sql = 'INSERT INTO duration (id_duration, duration) VALUES (NULL, ?)';
            $itemSTMT = $conn->prepare($sql);
            $itemSTMT->bind_param("i", $length);
            $itemSTMT->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Duration</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <meta charset='UTF-8'>
</head>

<!--List of auctions, items, users. Analytics.-->

<body>

<div class="card" style="height:auto; width:auto;">
    <div class="col-sm-12" style="height:auto; width:auto;">
        <!-- Custom information -->
        <div class="about" style="height:auto; width:auto;">
            <img class="card-img-top" src="efast.png" alt="Card image">
            <div class="spacer" style="height:20px"></div>
            <h3>Add a new duration (in minutes)</h3>
            <div class="spacer" style="height:20px"></div>
            <form action="upload-duration.php" role="form" method="post">
                <div class="spacer" style="height:10px"></div>
                <div class="form-group">
                    <label for="usr">Length of Duration: </label>
                    <input type="text" class="form-control" id="usr" name="duration-length">
                    <div class="spacer" style="height:10px"></div>
                </div>
                <input type='submit' class="btn btn-primary btn-block btn-sm" value="Save" name='submit'>
            </form>
            <div class="spacer" style="height:5px"></div>
            <button type="button" class="btn btn-danger btn-block btn-sm" onclick="window.location='./admin-home.php';">Cancel</button>
            <div class="spacer" style="height:20px"></div>
        </div>
    </div>
</div>

</body>

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

</style>
</html>