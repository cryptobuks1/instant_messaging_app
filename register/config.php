<?php
    //for testing input given by user. Retrieved from: https://www.w3schools.com/php/php_form_validation.asp
    function test_input($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //get values from user
    $reg_username = $_POST['username'];
    $reg_password = $_POST['password'];
    $reg_confirmpass = $_POST['confirmPassword'];
    $reg_email = $_POST['email'];

    //test result of email format
    $emailValid = test_input($reg_email);

    //boolean variables used to check if the inputted data by user is valid.
    $nameCheck = true;
    $passwordCheck = true;
    $emailCheck = true;

    //Error messages
    $err_nameMsg = "Username already exists!";
    $err_passMsg = "Password is not rewritten the same!";
    $err_emailMsg = "Either email already used or email format is wrong!";

    //localhost connect (not web based yet!)
    mysql_connect("localhost", "root", "");
    mysql_select_db("comp3334");

    //variable used to check if username already exists
    $existUsername = mysql_query(" SELECT * FROM users  WHERE username = '$reg_username' ")
        or die("Failed to query the database. ".mysql_error());
    $num_existUser = mysql_num_rows($existUsername);

    //variable used to check if email already exists
    $existEmail = mysql_query(" SELECT * FROM users  WHERE email = '$reg_email' ")
        or die("Failed to query the database. ".mysql_error());
    $num_existEmail = mysql_num_rows($existEmail);


    
     //checks user data inputted by user.

     //Checks if password is rewritten the same by the user. Prevents typos.
    if($reg_password != $reg_confirmpass)
    {
        $passwordCheck = false;
    }
    //Checks if username already exists.
    if($num_existUser >= 1)
    {
        $nameCheck = false;
    }
    //Checks if email already exists & Checks if email format is valid!
    if($num_existEmail >= 1 || !filter_var($emailValid, FILTER_VALIDATE_EMAIL))
    {
        $emailCheck = false;
    }

    //only create record of new user if confirm password works & when his/her username does not already exist!
    if($passwordCheck == true && $nameCheck == true && $emailCheck == true)
    {
        //Query the information from the database for the user.
        $info_result = mysql_query(" INSERT INTO users (username, password, email) VALUES ('$reg_username', '$reg_password', '$reg_email') " )
            or die("Failed to query the database. ".mysql_error());
       
        header("location: http://localhost/login/login.php");
    }
    //outputs corresponding error message to user if he/she has typed something wrong.
    else
    {
        if($nameCheck == false && $passwordCheck == false && $emailCheck == false)
        {
            echo $err_nameMsg . "\n" . $err_passMsg . "\n" . $err_emailMsg;
        }
        else if($nameCheck == false && $emailCheck == false)
        {
            echo $err_nameMsg . "\n" . $err_passMsg;
        }
        else if($nameCheck == false && $passwordCheck == false)
        {
            echo $err_nameMsg . "\n" .$err_passMsg;
        }
        else if($passwordCheck == false && $emailCheck == false)
        {
            echo $err_passMsg . "\n" .$err_emailMsg;
        }
        else if($nameCheck == false)
        {
            echo $err_nameMsg;
        }
        else if($passwordCheck == false)
        {
            echo $err_passMsg;
        }
        else if($emailCheck == false)
        {
            echo $err_emailMsg;
        }
    }
?>


<<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/main/main.css" />
    
    <!--Bootstrap CDN-    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>-->

</head>

<body>
    <div>
        <form action = "config.php" method = "post">    
            <div class = "container">
                <div class = "row">
                    <div class = "col-xs-3">
                        <h1>User Registration</h1>

                        <hr class = "mb-3">

                        <label><b>Username</b></label>
                        <input class = "form-control" type = "text" name = "username" required>

                        <label><b>Password</b></label>
                        <input class = "form-control" type = "text" name = "password" required>
                        
                        <label><b>Confirm Password</b></label>
                        <input class = "form-control" type = "text=" name = "confirmPassword" required>

                        <label><b>Email</b></label>
                        <input class = "form-control" type = "text" name = "email" required>

                        <hr class = "mb-3">

                        <input class="btn btn-outline-dark" type = "submit" id = "createButton" value = "Sign Up">
                    </div>
                </div>
            </div>
    </div>
</body>

</html>
