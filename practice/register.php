<?php
//global $link;
  //Include config file

  require_once "config.php";

  //Define variables and initialize with empty values

  $username = '';
  $password = '';
  $confirm_password = '';
  $name = ''; //extra information I added
  $gender = '';
  $desiredgender = '';

  $name_err = '';
  $username_err = '';
  $password_err = '';
  $confirm_password_err = '';
  $gender_err = '';
  $desiredgender_err = '';
  //Processing form data when form is submitted

  if($_SERVER["REQUEST_METHOD"] == "POST"){

    //Validating username

    //checking if username has been entered
    if(empty(trim($_POST["username"]))){
      $username_err = "Please enter a username.";
    }
    else{
    // Prepare a select statement
      $sql = "SELECT id FROM users WHERE username = ?";

      if($stmt = mysqli_prepare($link, $sql)){
           // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "s", $param_username);

           // Set parameters
           $param_username = trim($_POST["username"]);

           // Attempt to execute the prepared statement
           if(mysqli_stmt_execute($stmt)){
               /* store result */
               mysqli_stmt_store_result($stmt);

               if(mysqli_stmt_num_rows($stmt) == 1){
                   $username_err = "This username is already taken.";
               } else{
                   $username = trim($_POST["username"]);
               }
           } else{
               echo "Oops! Something went wrong. Please try again later.";
           }

           // Close statement
           mysqli_stmt_close($stmt);
       }

       else {
          echo "Something's wrong with the query: " . mysqli_error($link);
        }
   }

   // Validate password
   if(empty(trim($_POST["password"]))){
       $password_err = "Please enter a password.";
   } elseif(strlen(trim($_POST["password"])) < 6){
       $password_err = "Password must have atleast 6 characters.";
   } else{
       $password = trim($_POST["password"]);
   }

   // Validate confirm password
   if(empty(trim($_POST["confirm_password"]))){
       $confirm_password_err = "Please confirm password.";
   } else{
       $confirm_password = trim($_POST["confirm_password"]);
       if(empty($password_err) && ($password != $confirm_password)){
           $confirm_password_err = "Password did not match.";
       }
   }

   // **NEW** Check that a name has been entered

   if(empty(trim($_POST["name"]))){
       $name_err = "Please enter your name.";
   }
    else{
      $name = trim($_POST["name"]);
  }

  // **NEW** Check that radio values have been entered

  if(empty($_POST['userGender'])){
      $gender_err = "Please enter your gender.";
  }
  else {
    $gender = $_POST['userGender'];
  }

  if(empty($_POST['interestedGender'])){
      $desiredgender_err = "Please enter your desired gender.";
  }
  else {
    $desiredgender = $_POST['interestedGender'];
  }

   // Check input errors before inserting in database
   if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err) && empty($gender_err) && empty($desiredgender_err)){

       // Prepare an insert statement
       $sql = "INSERT INTO users (username, name, password, gender, interested) VALUES (?, ?, ?, ?, ?)";

       if($stmt = mysqli_prepare($link, $sql)){
           // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_name, $param_password, $param_gender, $param_interestedGender);

           // Set parameters
           $param_username = $username;
           $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
           $param_name = $name;
           $param_gender = $gender;
           $param_interestedGender = $desiredgender;

           // Attempt to execute the prepared statement
           if(mysqli_stmt_execute($stmt)){
               // Redirect to login page
               header("location: login.php");
           } else{
               echo "Something went wrong. Please try again later.";
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
<title>Sign Up</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
  background: linear-gradient(rgba(0,2,0,0.2), rgba(0,0,0,0.4)), url("coupleRun.jpg") no-repeat center center/cover;
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

.radioContainer{
  border-radius: 3px;
  margin-bottom: 5px;
  padding: 5px;
  background-color: white;
  color: black;
}
.radioContainer:hover{
  background-color: #b1eafa;
}
</style>
</head>
<body>
<div class="wrapper">
    <h2>Sign Up</h2>
    <p>Please enter all fields in this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
            <span class="help-block"><?php echo $name_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <!--  Radio Buttons for gender user is interested in dating -->
        <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
            <label>I am a: </label>
            <div class = "radioContainer"><input type="radio" name="userGender" value="man"> Man</div>
            <div class = "radioContainer"><input type="radio" name="userGender" value="woman"> Woman</div><br>
        </div>
        <div class="form-group <?php echo (!empty($desiredgender_err)) ? 'has-error' : ''; ?>">
            <label>Looking for a: </label>
            <div class = "radioContainer"><input type="radio" name="interestedGender" value="man"> Man</div>
            <div class = "radioContainer"><input type="radio" name="interestedGender" value="woman"> Woman</div><br>
        </div>
        <!--   -->
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
<footer class = "bottom">
  <p>Crislana Rafael 2020 Photo Credit: <a href = "https://www.twenty20.com/photos/b9d04a2b-4fbb-4852-8c52-e263e08657ce/?utm_t20_channel=bl" target="_blank">@criene via Twenty20</a></p>
</footer>
</body>
</html>
