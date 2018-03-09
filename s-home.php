<?php
session_start();








?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Home</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.js"></script>

</head>

<!--Links to the sellers pages-->

<body>




<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="s-home.html">
        <img width="100" src="efast.png">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!--<div class="col-md-auto">-->
        <!--<div class="collapse navbar-collapse" id="navbarSupportedContent">-->
            <!--<form class="form-inline my-2 my-lg-0">-->
                <!--<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
                <!--<ul class="navbar-nav mr-auto">-->
                    <!--<li class="nav-item dropdown">-->
                        <!--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"-->
                           <!--aria-expanded="false">-->
                            <!--Search by Catagory-->
                        <!--</a>-->
                        <!--<div class="dropdown-menu" aria-labelledby="navbarDropdown">-->
                            <!--<a class="dropdown-item" href="#">BOOKS</a>-->
                            <!--<a class="dropdown-item" href="#">MOVIES</a>-->
                            <!--<a class="dropdown-item" href="#">ELECTRONICS</a>-->
                            <!--<a class="dropdown-item" href="#">HOME</a>-->
                            <!--<a class="dropdown-item" href="#">CHILDREN</a>-->
                            <!--<a class="dropdown-item" href="#">SPORTS</a>-->
                            <!--<a class="dropdown-item" href="#">FOOD</a>-->
                            <!--<a class="dropdown-item" href="#">BEAUTY</a>-->
                            <!--<a class="dropdown-item" href="#">VEHICLE</a>-->
                            <!--<div class="dropdown-divider"></div>-->
                            <!--<a class="dropdown-item" href="#">Something else here</a>-->
                        <!--</div>-->
                    <!--</li>-->
                <!--</ul>-->
                <!--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
            <!--</form>-->



        <!--</div>-->
    <!--</div>-->

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li><a href="s-myprofile.php"><img height="30px" src="img/user1.png"> <?php echo "Hi "; echo  $_SESSION['first_name'] ;     ?> </a></li>
        </ul>
    </div>

    <button style="margin-left: 10px" type="button" onclick="window.location='login.php';" class="btn btn-outline-danger btn-sm ">Logout</button>

</nav>


<br>
<br>

<div class="container">

<h1>Seller Hub</h1>
    <p>Create an auction on an item, see your statistics or view your profile.</p>
</div>


<br>
<br>

<!--MAIN BODY OF THE PAGE-->

<div class="container-fluid">
    <div style="width: 82%; margin: 0 auto; float: none; margin-bottom: 20px; ">

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">CREATE AN AUCTION</h5>
            <p class="card-text">Create an auction based on an item to list it!</p>
            <a href="s-create-auction.html" class="btn btn-primary">Go to create an auction page</a>
            <img src="https://media.giphy.com/media/E9k0HTREY1qJW/giphy.gif" alt="" style="width:48px;height:48px;">
        </div>
    </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ITEM REPORT</h5>
                <p class="card-text">Report of all the auctions and the viewing traffic of items</p>
                <a href="s-report-page.html" class="btn btn-primary">Item report</a>
                <img src="https://cdn.dribbble.com/users/870415/screenshots/2746862/linegraph.gif" alt="" style="width:48px;height:48px;">

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">View your profile</h5>
                <p class="card-text">Account information, your rating, feedback and auction history</p>
                <a href="s-myprofile.html" class="btn btn-primary">Go to your profile page</a>
                <img src="https://media.giphy.com/media/13C8OJmeUxGz4Y/source.gif" alt="" style="width:48px;height:48px;">
            </div>
        </div>
    </div>
</div>








</body>
</html>