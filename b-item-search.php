<?php
session_start()


                        ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Search</title>
<!--    <link href="css/bootstrap.min.css" rel="stylesheet">-->
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<!--    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
<!--    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</head>

<!--Buyers can search the system for particular kinds of item being auctioned and can browse and
visually re-arrange listings of items within categories.
This is the buyers search items page -> leads to the auction of a particular item.
There will be a link to the item's auction is chosen from a list (Bid for items page-->

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
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form action="b-item-search.php" method="post" class="form-inline my-2 my-lg-0">
                <!--                        <input class="form-control mr-sm-2" type="search" name="search" id="search" placeholder="Search" aria-label="Search">-->
                <input type="text" placeholder="Search" id="search" name="search" onkeyup="getStates(this.value)">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            Search by Category
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="www.google.com">BOOKS</a>
                            <a class="dropdown-item" href="#">MOVIES</a>
                            <a class="dropdown-item" href="#">ELECTRONICS</a>
                            <a class="dropdown-item" href="#">HOME</a>
                            <a class="dropdown-item" href="#">CHILDREN</a>
                            <a class="dropdown-item" href="#">SPORTS</a>
                            <a class="dropdown-item" href="#">FOOD</a>
                            <a class="dropdown-item" href="#">BEAUTY</a>
                            <a class="dropdown-item" href="#">VEHICLE</a>
                        </div>
                    </li>
                </ul>
                <input class="btn btn-outline-success my-2 my-sm-0" type='submit' id="submit" name="submit">
            </form>



        </div>
    </div>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li><a href="b-myprofile.html"><img height="30px" src="img/user1.png"> <?php echo "Hi "; echo  $_SESSION['first_name'] ; echo " "; echo   $_SESSION['last_name'] ;   ?> </a></li>
        </ul>
    </div>

    <button style="margin-left: 10px" type="button" onclick="window.location='logout.php';" class="btn btn-outline-danger btn-sm ">Logout</button>


</nav>


<style>
        div.scrollmenu {
            background-color: transparent;
            overflow: auto;
            white-space: nowrap;
        }

        div.scrollmenu a {
            display: inline-block;
            color: #777777;
            text-align: center;
            padding: 14px;
            text-decoration: none;
        }

        div.scrollmenu a:hover {
            color: #525252;
        }


</style>






<div class="container">
        <div class="row">


            <div class="col-md-12">
                <div class="table-responsive">


                    <table id="mytable" class="table table-bordred table-striped">





                        <?php include 'config.php'; ?>
                        <?php

                        if(isset($_POST["submit"])) {



                            $itemToSearch = $_POST['search'];

                            if ($itemToSearch == null){

                                ?>


                                <div class="container-fluid" >
                                    <div class="jumbotron">
                                        <h1 align="center">Search returned no result</h1>
                                    </div>
                                    <p>Please try again...</p>


                                </div>

                                <?php
                                exit($status);

                            }

                            ?>



                        <thead>


                        <th>Item Image</th>
                        <th>Item Name</th>
                        <th>Item Description</th>
                        <th>Item State</th>
                        <th>Auction End Date</th>
                        <th>Starting Price</th>
                        <th>Current Bid</th>
                        <th>Go to Bid</th>



                        </thead>



                        <tbody>




                            <?php


                            $Query = 'SELECT * FROM item WHERE TITLE LIKE "%'.$itemToSearch.'%" ';

                            $ExecQuery = MySQLi_query($conn, $Query);

//                            $count=count($ExecQuery);
//                            if(isset($count)) {

                            while($row = mysqli_fetch_array($ExecQuery)) {

                                $itemID = $row['ID_ITEM'];
                                $title = $row['TITLE'];
                                $description = $row['DESCRIPTION'];
                                $catagoryID = $row['ID_CATEGORY'];
                                $state = $row['ID_STATE'];


                                $Query2 = "SELECT * FROM auction WHERE ID_ITEM = '$itemID' AND EXPIRED = '0' ";

                                $ExecQuery2 = MySQLi_query($conn, $Query2);

                                while($row = mysqli_fetch_array($ExecQuery2)) {

                                    $exptime = $row['EXPIRATION_TIME'];
                                    $idauction = $row['ID_AUCTION'];
                                    $startprice = $row['START_PRICE'];

                                    $Query3 = "SELECT MAX(PRICE) AS max_price FROM bid WHERE ID_AUCTION = '$idauction' ";

                                    $ExecQuery3 = MySQLi_query($conn, $Query3);


                                    while ($row = mysqli_fetch_array($ExecQuery3)) {

                                        $currentBid = $row['max_price'];






                                ?>

                                <tr>
                                    <form action="logout.php" method="post">
                                    <td><img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded"></td>
                                    <td>   <?php     echo $title; ?> </td>
                                    <td>     <?php   echo $description; ?> </td>
                                    <td> <?php if ($state == 'STATE_01'){
                                                echo "NEW WITH SEALED BOX";
                                                } elseif ($state=='STATE_02'){
                                                echo "NEW WITH OPENED BOX";
                                                } elseif ($state=='STATE_03'){
                                                   echo "NEW WITH DEFECTS";
                                                } else {
                                                    echo "USED";
                                                } ?> </td>

                                    <td> <?php echo $exptime; ?> </td>
                                    <td> <?php echo $startprice; ?> </td>
                                     <td><?php if (isset($currentBid)){
                                                    echo $currentBid;
                                                    } else{
                                         echo "No bid made yet";
                                         }


                                     ?>


                                     </td>
                                    <td> <input type="submit" id="submit2" "> </td>
                                    </form>
                                </tr>


                            <?php


                                    }}}

                        ?>


                        </tbody>




                    <?php


                        } //main submit

                        ?>


                    </table>




            </div>
        </div>
    </div>
</div>


<style>
    .jumbotron{
        background-color: transparent;
    }

</style>



<?php

if(isset($_POST["submit2"])){

    echo "<script> location.href='logout.php'; </script>";




}


?>




















</body>


</html>