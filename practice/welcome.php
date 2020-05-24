<?php

/* Project utilized some Tutorial Republic source code to understand how to implment a login/registration system
Link: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */

// Initialize the session
session_start();
include("config.php");
global $sessionName, $sessionGender, $sessionInterested;
$userName = $_SESSION["username"];
$sql = "SELECT * FROM users WHERE username ='$userName'";

$result = mysqli_query($link, $sql);
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{
          font: 14px sans-serif; text-align: center;
        }

        h1,h3{
          color: white;
        }
        #Name{
          margin: 5px 0;
        }
        h2{
          margin-top: 5px;
        }

        .page-wrapper{
          height: 100%;
          width: 100%;
          display: flex;
          position: fixed;
          align-items: center;
          justify-content: center;
          flex-direction: column;
          background: linear-gradient(rgba(0,2,0,0.2), rgba(0,0,0,0.4)), url("dashboard.jpg") no-repeat center center/cover;
          background-size: cover;
          margin:0;
        }

        .information{
          background-color: #000;
          padding: 20px;
          border-radius: 8px;
          color: white;
        }

        .table{
          display: flex;
          flex-direction: column;
          justify-content: center;
        }
      .userProfile{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 5px 10px;
        background-color: #fc7b03;
        text-align: left;
        border-radius: 5px;
        margin-bottom: 10px;
      }
      .personalInfo{
        padding: 10px;
        background-color: #94eaff;
        text-align: left;
        border-radius: 5px;
        margin-bottom: 10px;
        color: black;
      }
      .buttons{
        display: flex;
        flex-direction: column;
        justify-content: right;
      }
      .userContent{

      }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <h1>Hi, <b><?php  while($row = mysqli_fetch_assoc($result)){
          echo  $row["name"];
          $sessionGender =  $row["gender"];
          $sessionInterested = $row["interested"];
        }

           ?></b>. Welcome to your RunningDate dashboard.</h1>
        <div class = "information">
          <h2>Your Profile </h2>
          <div class = "personalInfo"><p><b>Username:</b> <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
            <p><b>Gender:</b> <?php echo htmlspecialchars($sessionGender); ?></p>
            <p><b>Looking for a:</b> <?php echo htmlspecialchars($sessionInterested); ?></p>
          </div>
          <div class = "table">
            <h2>Running Matches: </h2>
            <?php
              $displayOtherUsersSql = "SELECT name, username FROM users WHERE gender ='$sessionInterested'";
              $displayOtherUsersResult = mysqli_query($link, $displayOtherUsersSql);
              while($newRow = mysqli_fetch_assoc($displayOtherUsersResult)){
                ?><div class = "userProfile"><div class = "userContent"><h3 id = "Name"><?php echo $newRow["name"]; ?></h3><p><?php
                echo $newRow["username"];?></p></div><div class = "buttons"><a href="logout.php" class="btn btn-danger">Profile</a><a href="logout.php" class="btn btn-danger">Message</a></div></div><?php
              }
              ?>
            </div>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
          </p>
        </div>
    </div>

</body>
</html>
