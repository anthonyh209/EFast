<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">

</head>

<!--Users have roles of seller, buyer or administrator with different privileges.-->

<body>



<form action="register.php" method="post">
    <div class="container">

        <div align="center">
            <img align="center" height="50" src="efast.png">
        </div>


        <h2>Sign Up</h2>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label><b>First name</b></label>
        <input type="text" placeholder="Enter your first name " name="firstname" id="firstname"  required>

        <label><b>Last name</b></label>
        <input type="text" placeholder="Enter your last name " name="lastname" id="lastname" required>


        <label><b>Email</b></label>
        <input type="text" placeholder="Enter your email. This will act as your username " name="email" id="email" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter your password" name="password" id="password" required>

        <label><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat password" name="password-repeat" id="password-repeat" required>

        <input type="radio" name="radio" value="ROLE_01"> Buyer<br>
        <input type="radio" name="radio" value="ROLE_02"> Seller<br>
<!--         <input type="radio" name="radio" value="ROLE_03"> Administrator<br>
 -->

        <br>
        <br>


        <div>
            
<!--             <button type="submit" class="signupbtn">Sign Up</button>
 -->            <input class='btn btn-info btn-lg btn-block btn-sm'
 type='submit' name='submit' value='Register' id="submit" />

                <button type="button" class="btn btn-warning btn-lg btn-block btn-sm" onclick="window.location='login.php';" >Cancel</button>

        </div>


    </div>
</form>



<style>


    /* Full-width inputs */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* Set a style for all buttons */
    button {
        background-color: #2cbdc6;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    /* Add a hover effect for buttons */
    button:hover {
        background-color: #2badb6;
    }


    /* Add padding to containers */
    .container {
        padding: 150px;
    }

    /* The "Forgot password" text */
    span.psw {
        float: right;
        padding-top: 16px;
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }
        .cancelbtn {
            width: 100%;
        }
    }


    /* Extra styles for the cancel button */
    .cancelbtn {
        padding: 14px 20px;
        background-color: #f44336;
    }

    /* Float cancel and signup buttons and add an equal width */
    .cancelbtn, .signupbtn {
        float: left;
        width: 50%;
    }

</style>

<?php include 'configPDO.php'; ?>
<?php

// when the form is submitted this is triggered
if (isset($_POST['submit'])) {

    //gathering the data from the form
    $firstname = $_POST['firstname'];
    $lastname= $_POST['lastname'];
    $email = $_POST['email'];
    $role = $_POST['radio'];


    $password = $_POST['password'];
    $rpassword = $_POST['password-repeat'];

    //Checking if the passwords match
    if ($password == $rpassword){

            //Hashing of password
            $password = password_hash($password,PASSWORD_BCRYPT);

            //Inserting data into the tables
            //$sql = "INSERT INTO user (FNAME, LNAME, EMAIL, PASS, ID_ROLE) VALUES ('$firstname', '$lastname', '$email','$password','$role')";
        $sql = 'INSERT INTO user (FNAME, LNAME, EMAIL, PASS, ID_ROLE) VALUES (?, ?, ?,?,?)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1,$firstname, PDO::PARAM_STR);
        $stmt->bindParam(2,$lastname, PDO::PARAM_STR);
        $stmt->bindParam(3,$email, PDO::PARAM_STR);
        $stmt->bindParam(4,$password, PDO::PARAM_STR);
        $stmt->bindParam(5,$role, PDO::PARAM_STR);
        $res = $stmt->execute();
            // if the query is correct -> redirect to login page
            if ($res) {
                   echo '<script type="text/javascript"> window.location = "./login.php" </script>';
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

    } else {
        echo "Passwords do not match";
    }

} //if post submit




?>





















</body>
</html>