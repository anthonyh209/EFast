<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 02/03/2018
 * Time: 15:35
 */

session_start();

$conn = mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {

//Get the content of the image and then add slashes to it
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["upload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["upload"]["tmp_name"]);
    if ($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image. Please return and upload a correct image";
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. Please return and upload a correct image";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
            //echo "The file " . basename($_FILES["upload"]["name"]) . " has been uploaded.";
            $duration = $_POST['item-duration'];

            date_default_timezone_set('Europe/London');
            $startdate = new DateTime();
            $enddate = $startdate;
            $enddate->add(new DateInterval('PT' . $duration . 'M'));
            //$startdate-> format("Y-m-d H:i:s");
            $start = $startdate->format("Y-m-d H:i:s");
            $end = $enddate->format("Y-m-d H:i:s");
            //echo $startdate-> format("Y-m-d H:i:s");
            //$currentdate->modify("+{$duration} minutes");
            //echo $currentdate;
            $title = $_POST['item-title'];
            $state = $_POST['item-state'];
            $category = $_POST['item-category'];
            $description = $_POST['item-description'];
            $expiredValue = 0;
            $counterDefault = 0;
            $price = $_POST['item-price'];
            settype($price, "double");

            $sql = 'INSERT INTO item (id_item, pic, title, description, id_category, id_state) VALUES (NULL, ?,?,?,?,?)';
            $itemSTMT = $conn->prepare($sql);
            $itemSTMT->bind_param("sssss", $target_file, $title, $description, $category, $state);
            $itemSTMT->execute();

            $id = mysqli_insert_id($conn); //retrieves just inserted new item
            settype($id, "string");
            $Item_Query = "SELECT * FROM item WHERE ID = '$id'";
            $ExecQuery2 = MySQLi_query($conn, $Item_Query);
            while ($row = mysqli_fetch_array($ExecQuery2)) {
                $item_number = $row['ID_ITEM'];
                $id2 = $_SESSION['userID']; //later change with the user session id
                $auctionSQL = 'INSERT INTO auction (id_auction, id_seller, id_item, start_price, start_timestamp, expiration_time, expired, counter) VALUES (NULL, ?, ?, ?, ?, ?, ?,?)';
                $auctionSTMT = $conn->prepare($auctionSQL);
                $auctionSTMT->bind_param("ssdssii", $id2, $item_number, $price, $start, $end, $expiredValue, $counterDefault);
                $auctionSTMT->execute();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

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

</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="s-home.html">
        <img width="100" src="efast.png">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li><a href="s-myprofile.html"><img height="30px" src="img/user1.png">Your Profile</a></li>
        </ul>
    </div>


</nav>

<body style="background-color: #F0EEEC">

<!--name tag is the most important to transmit to php section-->

<!--Title-->
<div class="spacer" style="height: 20px"></div>
<form action="createAuction.php" role="form" method="post" enctype="multipart/form-data">
    <div style="width: 70%; margin: 0 auto; float: none; margin-bottom: 20px; ">

        <div class="card">
            <div class="card-header">
                Specify details of your product
            </div>
            <div class="card-body">
                <h5 class="card-title">Title of your product</h5>
                <div class="form-group">
                    <label>Use words people would search for when looking for your item</label>
                    <input class="form-control" aria-describedby="titleHolder" placeholder="Enter title"
                           name="item-title"
                           id="title" required>
                    <small class="form-text text-muted">Be descriptive not creative!</small>
                </div>
            </div>
        </div>

        <!-- Item image -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Photo</h5>
                <p class="card-text">Upload a photo of your item and improve user confidence by adding an associating
                    picture</p>
                <input type="file" name="upload" required>
                <input type='submit' name='submit'>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Item specific</h5>
                <p class="card-text">Select specific details about your item to help buyers find it quickly</p>

                <!-- Item state-->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Item condition &nbsp;</label>
                    </div>
                    <select class="custom-select" name="item-state" id="inputGroupSelect01">
                        <?php
                        $conn = mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");
                        $res = $conn->query("SELECT * FROM state");
                        while ($row = $res->fetch_array()) {
                            ?>
                            <option value="<?php echo $row['ID_STATE']; ?>"><?php echo $row['STATE']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <!--Category-->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Category &nbsp; &nbsp; &nbsp; &nbsp;
                            &nbsp;
                            &nbsp;</label>
                    </div>
                    <!--<select class="custom-select" id="inputGroupSelect01">-->
                    <select id="item-category" name="item-category" class="form-control" required>
                        <!--<option selected="selected">Select Category</option-->
                        <?php
                        $conn = mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");
                        $res = $conn->query("SELECT * FROM category");
                        while ($row = $res->fetch_array()) {
                            ?>
                            <option value="<?php echo $row['ID_CATEGORY']; ?>"><?php echo $row['CATEGORY']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Description</h5>
                <p class="card-text">Add any further details about your item including unique features or
                    defects/flaws</p>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Item description</span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" id="item-description"
                              name="item-description" required></textarea>
                </div>
            </div>
        </div>


        <!-- Auction details -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Auction details</h5>

                <!-- Start Price -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Start Price</h5>
                                <p class="card-text">Please provide the starting price of your item</p>
                                <div class="input-group-prepend">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="text" class="form-control" name="item-price"
                                               aria-label="Amount (to the nearest dollar)" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Duration -->
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Duration</h5>
                                <p class="card-text">Please set the duration of your auction</p>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect02">Duration (min) &nbsp;
                                            &nbsp; &nbsp; &nbsp; &nbsp;
                                            &nbsp;</label>
                                    </div>
                                    <!--<select class="custom-select" id="inputGroupSelect01">-->
                                    <select id="item-duration" name="item-duration" class="form-control">
                                        <!--<option selected="selected">Select Category</option-->
                                        <?php
                                        $conn = mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");
                                        $res = $conn->query("SELECT * FROM duration");
                                        while ($row = $res->fetch_array()) {
                                            ?>
                                            <option value="<?php echo $row['DURATION']; ?>"><?php echo $row['DURATION']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <input type='submit' name='submit'>
</form>

<p style="font-size: 0.7em">Please make sure that all fields are correctly filled and that all information provided
    reflect the actual current physical state of the item. Be aware that buyers have the right to request refunds during
    a 2 weeks time-frame upon receive of the auctioned item. Note that wrong information might lead to negative
    reviews. </p>
<div class="spacer" style="height: 20px"></div>
<button type="button" class="btn btn-primary btn-danger btn-lg btn-block">List item as new auction</button>
<button type="button" class="cancelbtn" onclick="window.location='createAuction.php';">List item as new auction</button>
<!--             <button type="submit" class="signupbtn">Sign Up</button>


<div class="spacer" style="height: 50px"></div>
</body>

</html>