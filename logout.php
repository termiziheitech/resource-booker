<html>
<head>
  <title>Log out</title>
  <!--CSS stylesheet-->
  <link rel='stylesheet' type='text/css' href='my-style.css'>
  <!--Google fonts-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
  <?php
  session_start();
  if ($_SESSION["loggedin"]) {
    $_SESSION['username'] = null;
    $_SESSION['password'] = null;
    $_SESSION['loggedin'] = null;
    echo "<h2><b>Successfully logged out</b></h2><br>";
    echo "<h3><u><a href='/login.php'>Log in</a></u></h3>";
  }
  else {
  	echo "<h2><b>Already logged out</b></h2><br>";
  	echo "<h3><u><a href='/login.php'>Log in</a></u></h3>";
  }
  ?>
  <footer style="position: fixed; bottom: 10px; width: 100%; height: 15px;">
    <span style="float:right;font-size:12px;background-color:white;padding: 2.5px 5px 5px 5px">
      <a href="about.php">about</a> | created by <a href="http://aturner.co/">Alex Turner</a>, 2016
    </span>
  </footer>
</body>
</html>
