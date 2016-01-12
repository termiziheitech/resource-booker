<!DOCTYPE html>
<html>
<head>
  <title>Log in</title>
  <!--CSS stylesheet-->
  <link rel='stylesheet' type='text/css' href='my-style.css'>
  <!--Google fonts-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
  <?php
  session_start();
  if (!isset($_SESSION["loginerror"])) {
    $_SESSION["loginerror"] = false;
  }
  if (($_SESSION["loggedin"]) == true) {
    echo "Already logged in<br>";
    echo "<a href='/home.php'><u>Home</u></a><br>";
    echo "<a href='/logout.php'><u>Log out</u></a>";
    exit;
  }
  elseif ($_SESSION["loginerror"] == true) {
    echo "<div style='margin:25px 0px 0px 25px'><h2><b>Unable to login</b></h2><br>";
    echo "<h3>Username or password incorrect</h3><br>";
    echo "<h4><u><a href='login.php'>Go back</a></u></h4></div>";
    $_SESSION["loginerror"] = false;
    exit;
  } // if
  else {
    if(isset($_POST["username"])) {
      try {
        $servername = "localhost";
        $username = $_POST['username'];
        $password  = $_POST['password'];
        $db_selected = "rbook_db";
        
        echo "Servername: ".$servername."<br>";
        echo "Username: ".$username."<br>";
        echo "Password: ".$password."<br>";
        echo "db_selected: ".$db_selected."<br>";
        $conn = @mysqli_connect($servername,$username,$password,$db_selected);
        /* check connection */
        if (mysqli_connect_errno()) {
            $_SESSION["loginerror"] = true;
            header("Location: /login.php");
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        } // if
        if($conn) {
          $_SESSION["loginerror"] = false;
          $_SESSION['loggedin'] = true;
          $_SESSION['conn'] = $conn;
          $_SESSION['username'] = $username;
          $_SESSION['password'] = $password;
          $_SESSION['servername'] = $servername;
          $_SESSION['db_selected'] = $db_selected;
          echo "Database Connected.";

          // set ID
          $sqlSetID = "SELECT ID FROM Names
                       WHERE Username='$username'";
          echo $sqlSetID."<br>";
          $resultSetID = mysqli_query($conn,$sqlSetID);
          if (!$resultSetID)
          {
            echo "Problem finding user<br>";
          } else {
            $rowid = mysqli_fetch_row($resultSetID);
            $id = $rowid[0];
          }
          // set session variable for ID
          $_SESSION["id"] = $id;
          echo "SESSION ID: " . $_SESSION["id"] . "<br>";

          // set Fullname
          $sqlSetFullname = "SELECT Fullname FROM Names
                       WHERE ID='$id'";
          echo $sqlSetFullname."<br>";
          $resultSetFullname = mysqli_query($conn,$sqlSetFullname);
          if (!$resultSetFullname)
          {
            echo "Problem finding user<br>";
          } else {
            $rowfullname = mysqli_fetch_row($resultSetFullname);
            $fullname = $rowfullname[0];
          }
          // set session variable for ID
          $_SESSION["fullname"] = $fullname;
          echo "SESSION fullname: " . $_SESSION["fullname"] . "<br>";

          // redirect to home
          header("Location: /home.php");
          exit; 
        } // if 
        else {
          die("Connection failed: " . mysqli_error($conn));
        } // else
      } catch (Exception $e) {
        // incorrect uname/pass, etc.
        echo "<b>An error occured:</b><br>";
        echo $e->getMessage();
      } // catch
    } // if
  } // else
  ?>
    <div id="logindiv">
      <center>
      <img src="Treetops-blue.bmp" style="width:250px"/><br>
      <p id="rbook">Resource Booking System</p>
      <form method="POST" action="login.php">
        <table>
          <tr>
            <td class="nostyle">Username:</td>
            <td class="nostyle"><input type="text" name="username"></td>
          </tr>
          <tr>
            <td class="nostyle">Password:</td>
            <td class="nostyle"><input type="password" name="password"></td>
          </tr>
        </table>
        <button type="submit" id="login" name="login" value="Login">Login</button>
      </form>
      <p style="font-size:10pt">To view bookings, log in as 'guest' with no password</p>
      </center>
    </div>
    <footer style="position: fixed; bottom: 10px; width: 100%; height: 15px;">
      <span style="float:right;font-size:12px;background-color:white;padding: 2.5px 5px 5px 5px">
        <a href="about.php">about</a> | created by <a href="http://aturner.co/">Alex Turner</a>, 2016
      </span>
    </footer>
</body>
</html>
