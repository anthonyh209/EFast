
<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        -->


</head>



<body>

<div class="container" style="padding: 20%">

    <!--form to contain the login functionalitiy-->

    <form action="login.php" method="post">


        <div align="center">
            <img src="eFast.png" width="auto" height="80" alt="">
        </div>

        <br>
        <br>

        <h2 class="form-signin-heading">Welcome Back!</h2>
        <div id="spacer" style="height: 20px"></div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">@</span>
            </div>
            <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" aria-label="Username" aria-describedby="basic-addon1" class="form" required >
        </div>
        <div>
            <div>
                <input type="text" class="form-control" id="password" name="password" placeholder="Password" required >
            </div>
            <div id="spacer" style="height: 20px"></div>
            <!-- <button type="submit" class="btn btn-primary btn-lg btn-block btn-sm">Login</button> -->
            <input type='submit' name='submit' value='submit' id="submit" />
        </div>
        <div id="spacer2" style="height: 20px"></div>
        <div>
            <button type="button" class="btn btn-primary btn-lg btn-block btn-sm" onclick="window.location='./register.html';">Sign up here</button>
        </div>

    </form>

</div>







<style>
</style>

</body>

</html>


<?php include 'config.php'; ?>
<?php
if(isset($_POST["submit"]))
{



    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE EMAIL = '$email' ";


    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result)) {

        $userID = $row['ID_USER'];
        $db_pass = $row['PASS'];
        $first_name = $row['FNAME'];
        $last_name = $row['LNAME'];
        $email = $row['EMAIL'];
        $role = $row['ID_ROLE'];
    }

    $userID = $userID;
    $first_name =$first_name;
    $last_name = $last_name;
    $role = $role;

    session_start();


        // if valid
        $_SESSION['userID'] = $userID;
        $_SESSION['username'] = $email;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['role'] = $role;


        setcookie('userID', $userID,   time() + (60 * 60 * 24 * 30));
        setcookie('username', $email,  time() + (60 * 60 * 24 * 30));
        setcookie('first_name', $first_name,  time() + (60 * 60 * 24 * 30));
        setcookie('last_name', $last_name,  time() + (60 * 60 * 24 * 30));
        setcookie('role', $role,  time() + (60 * 60 * 24 * 30));

        // Now logged in
            if ($role == 'ROLE_01') {    // redirecting to correct homepage
                echo "<script> location.href='b-home.php'; </script>";
            } elseif ($role == 'ROLE_02') {
                echo "<script> location.href='s-home.php'; </script>";
            } elseif ($role == 'ROLE_03') {
              echo "<script> location.href='./a-home.html'; </script>";
              } else { echo "<div align='center'>
               <p><strong>Please enter a valid username and password</strong></p>
                </div>";
            }



}


?>























