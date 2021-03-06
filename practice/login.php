<?php

/* Project utilized some Tutorial Republic source code to understand how to implment a login/registration system
Link: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <style type="text/css">
        body{
          font: 14px sans-serif;
          color: white;
        }
        h2{
          font-family: 'Josefin Sans', sans-serif;
          font-size: 5rem;
          color: white;
        }
        p{
          font-family: 'Josefin Sans', sans-serif;
          color: white;
        }
        .wrapper{
          height: 100%;
          width: 100%;
          display: flex;
          position: fixed;
          align-items: center;
          justify-content: center;
          flex-direction: column;
          background: linear-gradient(rgba(0,2,0,0.2), rgba(0,0,0,0.4)), url("workout_Large.jpg") no-repeat center center/cover;
          background-size: cover;
        }
        .bottom{
          display: flex;
          flex-direction: column;
          justify-content: center;
          position: fixed;
          margin-top: 10px;
          left: 0;
          bottom: 0;
          width: 100vw;
          color: white;
          text-align: center;
        }
        a{
          text-decoration: none;
          color: white;
        }
        a:hover{
          color: yellow;
        }

    </style>
</head>
<body>
    <div class="wrapper">
        <h2><b>RunningDate Login</b></h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php" style = "color:#ffb0d1; ">Sign up now</a>.</p>
        </form>
    </div>
    <footer class = "bottom">
      <p>Crislana Rafael 2020 Photo Credit: <a href = "https://www.twenty20.com/photos/d89046cf-3b8f-4ef3-82b8-ec2fcfc76c99/?utm_t20_channel=bl" target="_blank">@criene via Twenty20</a></p>
    </footer>
</body>
</html>
