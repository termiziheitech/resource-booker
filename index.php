<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<?php
session_start();
  if(!isset($_SESSION["loggedin"])) {
    header('Location: /login.php');
    $_SESSION["loggedin"] = false;
  }
  if ($_SESSION["loggedin"] == true) {
    header('Location: /home.php');
  } else {
    header('Location: /login.php');
  } // else
?>
</body>
</html>