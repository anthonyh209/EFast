<?php include 'configPDO.php'; ?>
<?php
 session_start();

date_default_timezone_set("Europe/London");






 ?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.js"></script>



</head>

<body>

<!-- Navigation Bar search function -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="b-home.php">
        <img width="100" src="efast.png">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="col-md-auto">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form action="b-item-search.php" method="post" class="form-inline my-2 my-lg-0">
                <!--                        <input class="form-control mr-sm-2" type="search" name="search" id="search" placeholder="Search" aria-label="Search">-->
                <div class="search-box">
                    <input type="text" autocomplete="off" placeholder="Search" id="search" name="search" />
                    <div class="result"></div>
                </div>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item" style="padding-left: 10px; padding-right: 10px ">
                    <input type="button" class="btn btn-primary navbar-btn" value="Search by category" onclick="window.location.href='b-category-search.php'" />
                    </a>
                    </li>


                </ul>
                <input class="btn btn-outline-success my-2 my-sm-0" type='submit' id="submit" name="submit" value="Search">
            </form>



        </div>
    </div>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li><a href="b-myprofile.php"><img height="30px" src="img/user1.png"> <?php echo "Hi "; echo  $_SESSION['first_name'] ; echo " "; echo   $_SESSION['last_name'] ;   ?> </a></li>
        </ul>
    </div>

    <button style="margin-left: 10px" type="button" onclick="window.location='logout.php';" class="btn btn-outline-danger btn-sm ">Logout</button>


</nav>




<style type="text/css">
    /* Formatting search box */
    .search-box{
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        background-color: white;
        position: absolute;
        z-index: 999;
        top: 100%;
        left: 0;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #20b5dd;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
    }
</style>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.search-box input[type="text"]').on("keyup input", function(){
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if(inputVal.length){
                $.get("backend-search.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });

        // Set search input value on click of result item
        $(document).on("click", ".result p", function(){
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
        });
    });
</script>






























<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="img/healthandbeauty.jpg" alt="First slide" height="600">
            <div class="carousel-caption d-none d-md-block">
                <h5>HEALTH AND BEAUTY</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="img/homeandgarden.jpg" alt="Second slide" height="600">
            <div class="carousel-caption d-none d-md-block">
                <h5>HOME AND GARDEN</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="img/outdoor.jpg" alt="Third slide" height="600">
            <div class="carousel-caption d-none d-md-block">
                <h5>SPORTS AND OUTDOOR</h5>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<br>
<br>
<br>




<div class="container-fluid">
    <div class="jumbotron">
        <h1>View upcoming auctions and bid away!</h1>
        <p><strong>eFast</strong> is an online auction system which allows users to buy and sell items. </p>
        <button type="button" onclick="window.location='./b-watch-page.php';" class="btn btn-primary">Go to your watchlist</button>
    </div>

</div>


<div class="container-fluid">
    <h1 class="text-center">HUNDEREDS OF DIFFERENT ITEMS</h1>
    <div align="center" class="tg-wrap">
        <table class="tg">

            <tr>
                <th align="center" class="tg-32ig">
                    <img src="img/homeandgarden.jpg" class="img-responsive" alt="logo" align="center" width="400" height="auto"></a>
                </th>
                <th align="center" class="tg-fefd">
                    <img src="img/fashion.jpg" class="img-responsive" alt="logo" align="center" width="400" height="auto"></a>
                </th>
                <th align="center" class="tg-fefd">
                    <img src="img/outdoor.jpg" class="img-responsive" alt="logo" align="center" width="400" height="auto"></a>
                </th>
            </tr>

            <tr>
                <td align="center" class="tg-fefd">
                    <img src="img/office.jpg" class="img-responsive" alt="logo" align="center" width="400" height="auto"></a>
                </td>
                <td align="center" class="tg-fefd">
                    <img src="img/healthandbeauty.jpg" class="img-responsive" alt="logo" align="center" width="400" height="auto"></a>
                </td>
                <td align="center" class="tg-fefd">
                    <img src="img/techimage.jpg" class="img-responsive" alt="logo" align="center" width="400" height="auto"></a>
                </td>

            </tr>


        </table>
    </div>
</div>



<style>
    .img-responsive {
        border-style:1px solid green;
        opacity: 0.3;
        -webkit-transition: opacity .1s ease-in-out;
        -moz-transition: opactiy .1s ease-in-out;
        -ms-transition: opacity .1s ease-in-out;
        -o-transition: opacity .1s ease-in-out;
        transition: opacity .1s ease-in-out;
    }

    .img-responsive:hover{
        opacity: 1;
        -webkit-transition: opacity .1s ease-in-out;
        -moz-transition: opactiy .1s ease-in-out;
        -ms-transition: opacity .1s ease-in-out;
        -o-transition: opacity .1s ease-in-out;
        transition: opacity .1s ease-in-out;
    }

    .jumbotron{
        background-color: transparent;
    }

</style>




<!--contain for the RECOMMENDED ITEMS  items -->


<div class="container-fluid" >
    <div class="jumbotron">
        <h1 align="center">Items we recommend for you, based on your bid history.</h1>
    </div>


</div>




<!--Recommeneded items -->

<div class="container">

    <div class="row">




        <?php


        //Columns must be a factor of 12 (1,2,3,4,6,12)
        $numOfCols = 3;
        $rowCount = 0;
        $bootstrapColWidth = 12 / $numOfCols;



        $userID = $_SESSION['userID'];

        // $sql = "SELECT DISTINCT ID_AUCTION FROM BID WHERE ID_BUYER IN (SELECT DISTINCT ID_BUYER FROM BID WHERE NOT ID_BUYER = '$userID' AND ID_AUCTION IN (SELECT DISTINCT ID_AUCTION FROM BID WHERE ID_BUYER = '$userID'))";


        //$sql = "SELECT DISTINCT auc.ID_AUCTION FROM BID bid INNER JOIN auction auc ON bid.ID_AUCTION = auc.ID_AUCTION WHERE bid.ID_BUYER IN (SELECT DISTINCT ID_BUYER FROM BID WHERE NOT ID_BUYER = '$userID' AND ID_AUCTION IN (SELECT DISTINCT ID_AUCTION FROM BID WHERE ID_BUYER = '$userID')) AND bid.ID_AUCTION NOT IN (SELECT ID_AUCTION FROM bid WHERE ID_BUYER = '$userID') AND auc.EXPIRATION_TIME > NOW()";

        try {
            $sql = 'SELECT DISTINCT auc.ID_AUCTION FROM BID bid INNER JOIN auction auc ON bid.ID_AUCTION = auc.ID_AUCTION WHERE bid.ID_BUYER IN (SELECT DISTINCT ID_BUYER FROM BID WHERE NOT ID_BUYER = ? AND ID_AUCTION IN (SELECT DISTINCT ID_AUCTION FROM BID WHERE ID_BUYER = ?)) AND bid.ID_AUCTION NOT IN (SELECT ID_AUCTION FROM bid WHERE ID_BUYER = ?) AND auc.EXPIRATION_TIME > NOW();';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1,$userID, PDO::PARAM_STR, 9);
            $stmt->bindParam(2,$userID, PDO::PARAM_STR, 9);
            $stmt->bindParam(3,$userID, PDO::PARAM_STR, 9);

            $stmt->execute();
             while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){


                 $auctionID = $row['ID_AUCTION'];
                 //$num_rows++;


                 //$Query1 = "SELECT * FROM auction WHERE ID_AUCTION = '$auctionID'" ;
                 $Query1 = 'SELECT * FROM auction WHERE ID_AUCTION = ?' ;
                 $stmt1 = $pdo->prepare($Query1);
                 $stmt1->bindParam(1,$auctionID, PDO::PARAM_STR,9);
                 $stmt1->execute();

                 //$ExecQuery1 = MySQLi_query($conn, $Query1);

                 while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {


                     $exptime = $row['EXPIRATION_TIME'];
                     $startprice = $row['START_PRICE'];
                     $itemID = $row['ID_ITEM'];
                     $idauction = $row['ID_AUCTION'];

                     //$Query2 = "SELECT * FROM item WHERE ID_ITEM = '$itemID' ";
                     $Query2 = 'SELECT * FROM item WHERE ID_ITEM = ? ';
                     $stmt2 = $pdo->prepare($Query2);
                     $stmt2->bindParam(1,$itemID,PDO::PARAM_STR,9);
                     $stmt2->execute();

                     //$ExecQuery2 = MySQLi_query($conn, $Query2);

                     while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {

                         $image = $row['PIC'];
                         $title = $row['TITLE'];
                         $description = $row['DESCRIPTION'];
                         $catagoryID = $row['ID_CATEGORY'];
                         $state = $row['ID_STATE'];


                         //$Query3 = "SELECT MAX(PRICE) AS max_price FROM bid WHERE ID_AUCTION = '$auctionID' ";
                         $Query3 = 'SELECT MAX(PRICE) AS max_price FROM bid WHERE ID_AUCTION = ? ';
                         $stmt3 = $pdo->prepare($Query3);
                         $stmt3->bindParam(1,$auctionID, PDO::PARAM_STR,9);
                         $stmt3->execute();

                         //$ExecQuery3 = MySQLi_query($conn, $Query3);

                         while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {

                             $currentBid = $row['max_price'];

                             ?>



                             <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                                 <form action="searchtobid.php" method="post">
                                     <div class="card" style="width: 18rem;">
                                         <img class="card-img-top" src="<?php echo $image ?>" alt="Card image cap">
                                         <div class="card-body">
                                             <h5 class="card-title"><?php echo $title; ?></h5>
                                             <p class="card-text"><?php echo $description; ?></p>
                                         </div>
                                         <ul class="list-group list-group-flush">

                                             <li class="list-group-item"><?php if ($state == 'STATE_01') {
                                                     echo "New with sealed box";
                                                 } elseif ($state == 'STATE_02') {
                                                     echo "New with opened box";
                                                 } elseif ($state == 'STATE_03') {
                                                     echo "New with defects";
                                                 } else {
                                                     echo "Used";
                                                 } ?></li>

                                             <li class="list-group-item"><?php if (isset($currentBid)) {
                                                     echo "Highest bid is £"; echo  $currentBid;
                                                 } else {
                                                     echo "No bid made yet";
                                                 }
                                                 ?></li>

                                         </ul>
                                         <div class="card-body">

                                             <?php
                                             $_SESSION['auctionID'] = $idauction;
                                             ?>

                                             <button
                                                     class="btn btn-primary"  type='submit' name='submit' value="<?php echo $_SESSION['auctionID'];  ?>" id="submit" > Go to bidpage
                                             </button>

                                         </div>
                                         <div class="card-footer text-muted">
                                             <?php
                                             $now = date('Y-m-d H:i:s');
                                             $diff=strtotime($exptime)-strtotime($now);
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
                                                     $timeremaining = "{$hours} hours {$minutes} minutes";
                                                 } elseif ($minutes > 0) {
                                                     $timeremaining = "{$minutes} minutes {$seconds} seconds";
                                                 } elseif ($seconds > 0) {
                                                     $timeremaining = "{$seconds} seconds";
                                                 }
                                             }
                                             else {$timeremaining = "Auction Complete";}
                                             ?>
                                             Time remaining: <?php echo $timeremaining; ?>
                                         </div>
                                     </div>
                                 </form>


                             </div>



                             <?php


                             $rowCount++;

                             if ($rowCount % $numOfCols == 0) {
                                 echo '</div>';
                                 echo '<br>';
                                 echo '<br>';
                                 echo' <div class="row">';
                             }



                         }}}





             }


        }
        catch(PDOException $e)
        {
            echo $e -> getMessage();
        }



       // $result = MySQLi_query($conn, $sql);

        //number of items
        //$num_rows = -1;


        //while ($row = mysqli_fetch_array($result)) {}





        ?>

    </div>
    <br>

</div>
















<style>
     .btn.btn-success.btn-md {
         height: 40px;
         width: 150px;
        padding: 15px 25px;
        font-size: 20px;
        text-align: center;
        cursor: pointer;
        outline: none;
        color: #ffffff;
        background-color: #20d3fb;
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px #999;
    }

     .btn.btn-success.btn-md:hover {background-color: rgba(32, 215, 255, 0.37)
     }

     .btn.btn-success.btn-md:active {
        background-color: #20d3fb;
        box-shadow: 0 5px #666;
        transform: translateY(4px);
    }
</style>







</body>

</html>