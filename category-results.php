<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php

// session_start();


// $q = ($_GET['q']);

// $conn=mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");

// $sql="SELECT * FROM item WHERE ID_CATEGORY = '".$q."'";
// $result = mysqli_query($conn,$sql);

// echo "<table>
// <tr>
// <th>Firstname</th>
// <th>Lastname</th>
// </tr>";

// while($row = mysqli_fetch_array($result)) {
//     echo "<tr>";
//     echo "<td>" . $row['TITLE'] . "</td>";
//     echo "<td>" . $row['DESCRIPTION'] . "</td>";
//     echo "</tr>";

// }
// echo "</table>";
// mysqli_close($con);

?>




<div class="container">
    <?php

    	session_start();


        $q = ($_GET['q']);

		$conn=mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");

		$sql="SELECT * FROM item WHERE ID_CATEGORY = '".$q."' AND ID_ITEM IN (SELECT ID_ITEM FROM auction WHERE EXPIRATION_TIME > NOW() ) ";

		$result = mysqli_query($conn,$sql);

        // Check number of rows in the result set
            if(mysqli_num_rows($result) == 0){
                echo "<div class=\"container-fluid\">
                          <div class=\"jumbotron\">
                             <h1 align=\"center\">Search returned no result</h1>
                               </div>
                               </div>";
                               $count = mysqli_num_rows($ExecQuery);
                               echo $count ; 
            }else{
                echo "<br>
                        <div class=\"container-fluid\">
                             <h1 align=\"center\">Here are the results</h1>
                               </div>
                               <br>";
            }


        while ($row = mysqli_fetch_array($result)) {

            $image = $row['PIC'];
            $itemID = $row['ID_ITEM'];
            $title = $row['TITLE'];
            $description = $row['DESCRIPTION'];
            $catagoryID = $row['ID_CATEGORY'];
            $state = $row['ID_STATE'];

            $Query2 = "SELECT * FROM auction WHERE ID_ITEM = '$itemID' ";
            $ExecQuery2 = MySQLi_query($conn, $Query2);

            while ($row = mysqli_fetch_array($ExecQuery2)) {
                $exptime = $row['EXPIRATION_TIME'];
                $idauction = $row['ID_AUCTION'];
                $startprice = $row['START_PRICE'];

                 $Query3 = "SELECT MAX(PRICE) AS max_price FROM bid WHERE ID_AUCTION = '$idauction' ";

                $ExecQuery3 = MySQLi_query($conn, $Query3);

                while ($row = mysqli_fetch_array($ExecQuery3)) {

                    $currentBid = $row['max_price'];

                    ?>


                    <div class="row">

                        <div class="col-md-12">

                        <div class="card">
                            <div class="col-12">
                                <form action="searchtobid.php" method="post">

                                    <div class="card-body">
                                        <div class="row">


                                            <div class="col-4">
                                                <div class="card" >
                                                    <img src="<?php echo $image ?>" alt="..."
                                                         style="height: 200px">
                                                </div>
                                            </div>

                                            <div class="col-8">
                                                <h3><?php echo $title; ?></h3>

                                                <p class="card-title" >
                                                    <?php echo $description; ?> </p>



                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <?php if ($state == 'STATE_01') {
                                                            echo "New with sealed box";
                                                        } elseif ($state == 'STATE_02') {
                                                            echo "New with opened box";
                                                        } elseif ($state == 'STATE_03') {
                                                            echo "New with defects";
                                                        } else {
                                                            echo "Used";
                                                        } ?>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <?php if (isset($currentBid)) {
                                                            echo 'Highest bid is £';
                                                            echo $currentBid;
                                                        } else {
                                                            echo "No bid made yet";
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>


                                                <?php
                                                $_SESSION['auctionID'] = $idauction;
                                                ?>


                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button
                                                                    class="btn btn-primary"  type='submit' name='submit' value="<?php echo $_SESSION['auctionID'];  ?>" id="submit" > Go to bidpage
                                                            </button>

                                                        </div>

                                                        <div class="col-6">
                                                            <button
                                                                    class="btn btn-primary" type='submit' name='submit' value="<?php echo $_SESSION['auctionID'];  ?>" id="submit" > Add to Watchlist
                                                            </button>

                                                        </div>


                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                    </div>

                                </form>


                            </div>

                            <div class="card-footer">
                                <p align="center" class="text-muted">
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
                                </p>
                            </div>
                        </div>


                    </div>
                </div>

                    <br>

                                        <?php

                                   }}}

                    ?>
</div>
















</body>
</html>