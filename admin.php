<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head>
  <title>Admin Control</title>
  <!--CSS stylesheet-->
  <link rel='stylesheet' type='text/css' href='my-style.css'>
  <!--JQuery library-->
  <script src="jquery-2.1.4.min.js"></script>
  <meta http-equiv="X-UA-Compatible" content="IE=11" />
  <!--Google font-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <script type="text/javascript">
  function getNewPassword(username) {
    var newPass = prompt("Please enter the new password for " + username);
    if (newPass != null) {
      document.getElementById("password,"+ username).value = newPass;
    }
  }
  </script>
  <script>
  jQuery.fn.extend({
    hidealltables: function() {
      $("#userstable").hide();
      $("#laptoptrolley").hide();
      $("#ipadtrolleyblack").hide();
      $("#ipadtrolleygrey").hide();
      $("#conferenceroom").hide();
      $("#meetingroom").hide();
      $("#minibusjbx").hide();
      $("#minibusjha").hide();
      $("#minibuslle").hide();
      $("#minibusyhj").hide();
      $("#slt_grouptherapy").hide();
      $("#slt_individualtherapy").hide();
      $("#slt_signalong").hide();
      $("#slt_ace").hide();
      $("#slt_dls").hide();
      $("#slt_celf4").hide();
      $("#slt_rlsbst").hide(); 
      $("#slt_rlsapt").hide(); 
      $("#slt_rlswfvt").hide();
      $("#slt_clear").hide();
      $("#slt_celf3").hide();
      $("#slt_towk").hide();
      $("#slt_clip").hide();
      $("#slt_stass").hide();
      $("#slt_stap").hide();
      $("#slt_acap").hide();
      $("#slt_screener").hide();
      $("#slt_ndp").hide();
      $("#slt_talc1").hide();
      $("#slt_talc2").hide();
    }
  })
  $(document).ready(function(){
    $(document).hidealltables();

    $("#showusers").click(function(){
      $("#userstable").toggle();
    });
    $("#dismiss").click(function(){
      $("#adduserlog").hide();
      $("#deletebookinglog").hide();
    });
    $("#showbookings").click(function(){
      $(document).hidealltables();
      var showBookings = $("#managebookings").val();
      switch (showBookings) {
        case "viewall":                 $("#viewall").toggle(); break;
        case "laptoptrolley":           $("#laptoptrolley").toggle(); break;
        case "ipadtrolleyblack":        $("#ipadtrolleyblack").toggle(); break;
        case "ipadtrolleygrey":         $("#ipadtrolleygrey").toggle(); break;
        case "conferenceroom":          $("#conferenceroom").toggle(); break;
        case "meetingroom":             $("#meetingroom").toggle(); break;
        case "minibusjbx":              $("#minibusjbx").toggle(); break;
        case "minibusjha":              $("#minibusjha").toggle(); break;
        case "minibuslle":              $("#minibuslle").toggle(); break;
        case "minibusyhj":              $("#minibusyhj").toggle(); break;
        case "slt_grouptherapy" :       $("#slt_grouptherapy").toggle(); break;
        case "slt_individualtherapy" :  $("#slt_individualtherapy").toggle(); break;
        case "slt_signalong" :          $("#slt_signalong").toggle(); break;
        case "slt_ace" :                $("#slt_ace").toggle(); break;
        case "slt_dls" :                $("#slt_dls").toggle(); break;
        case "slt_celf4" :              $("#slt_celf4").toggle(); break;
        case "slt_rlsbst" :             $("#slt_rlsbst").toggle(); break; 
        case "slt_rlsapt" :             $("#slt_rlsapt").toggle(); break; 
        case "slt_rlswfvt" :            $("#slt_rlswfvt").toggle(); break;
        case "slt_clear" :              $("#slt_clear").toggle(); break;
        case "slt_celf3" :              $("#slt_celf3").toggle(); break;
        case "slt_towk" :               $("#slt_towk").toggle(); break;
        case "slt_clip" :               $("#slt_clip").toggle(); break;
        case "slt_stass" :              $("#slt_stass").toggle(); break;
        case "slt_stap" :               $("#slt_stap").toggle(); break;
        case "slt_acap" :               $("#slt_acap").toggle(); break;
        case "slt_screener" :           $("#slt_screener").toggle(); break;
        case "slt_ndp" :                $("#slt_ndp").toggle(); break;
        case "slt_talc1" :              $("#slt_talc1").toggle(); break;
        case "slt_talc2" :              $("#slt_talc2").toggle(); break;        
      } // switch
    });
  });
  </script>
</head>
<body>
<?php
  $servername = $_SESSION['servername'];
  $username = $_SESSION['username'];
  $password  = $_SESSION['password'];
  $db_selected = $_SESSION['db_selected'];
  $conn = mysqli_connect($servername,$username,$password,$db_selected);
  $_SESSION["conn"] = $conn;
?>
<!--Navigation menu-->
  <ul id="nav">
    <li class="site-name" style="width:200px;padding-left:0px"><a href="/home.php" style="width:200px">
      <img src="/Treetops-no-text.bmp" style="height:35px;vertical-align:middle;padding-bottom:3px;padding-right:5px"/>Resource Booker</a></li>
    <li class="makeabooking" style="border-left:1px solid #DDDDDD;"><a href="#">Make a Booking</a>
      <ul>
        <li><a href="#">IT Equipment &raquo;</a>            
          <ul>
            <li><a href="/ipadtrolleyblack.php">iPad Trolley (Black)</a></li>
            <li><a href="/ipadtrolleygrey.php">iPad Trolley (Grey)</a></li>
            <li><a href="/laptoptrolley.php">Laptop Trolley</a></li>
          </ul>
        </li>
        <li><a href="#">Rooms &raquo;</a>            
          <ul>
            <li><a href="/conferenceroom.php">Conference Room</a></li>
            <li><a href="/meetingroom.php">Meeting Room</a></li>
          </ul>
        </li>
        <li><a href="#">Vehicles &raquo;</a>            
          <ul>
            <li><a href="/all_vehicles.php">All Vehicles</a></li>
            <li><a href="/minibusjbx.php">Minibus JBX</a></li>
            <li><a href="/minibusjha.php">Minibus JHA</a></li>
            <li><a href="/minibuslle.php">Minibus LLE</a></li>
            <li><a href="/minibusyhj.php">Minibus YHJ</a></li>
          </ul>
        </li>
        <li><a href="#">Speech &amp; Language &raquo;</a>            
          <ul>
            <li><a href="#">Rooms &raquo;</a>
              <ul>
                <li><a href="/slt_grouptherapy.php">Group Therapy</a></li>
                <li><a href="/slt_individualtherapy.php">Individual Therapy</a></li>
                <li><a href="/slt_signalong.php">Signalong</a></li>
              </ul>
            </li>
            <li><a href="#">Key Assessments A &raquo;</a>
              <ul>
                <li><a href="/slt_ace.php">ACE</a></li>
                <li><a href="/slt_dls.php">DLS</a></li>
                <li><a href="/slt_celf4.php">CELF 4</a></li>
                <li><a href="/slt_rlsbst.php">RLS BST</a></li>
                <li><a href="/slt_rlsapt.php">RLS APT</a></li>
                <li><a href="/slt_rlswfvt.php">RLS WFVT</a></li>
                <li><a href="/slt_clear.php">CLEAR</a></li>
              </ul>
            </li>
            <li><a href="#">Key Assessments B &raquo;</a>
              <ul>
                <li><a href="/slt_celf3.php">CELF 3</a></li>
                <li><a href="/slt_towk.php">TOWK</a></li>
                <li><a href="/slt_clip.php">CLIP</a></li>
                <li><a href="/slt_stass.php">STASS</a></li>
                <li><a href="/slt_stap.php">STAP</a></li>
                <li><a href="/slt_acap.php">ACAP</a></li>
                <li><a href="/slt_screener.php">Phonology Screener</a></li>
                <li><a href="/slt_ndp.php">NDP</a></li>
                <li><a href="/slt_talc1.php">TALC 1</a></li>
                <li><a href="/slt_talc2.php">TALC 2</a></li>
              </ul>
            </li>
          </ul>
        </li><!--close s&l-->
      </ul><!--close make a booking-->
    </li><!-- close make a booking-->
    <li class="managebookings"><a href="/managebookings.php">Manage Bookings</a></li>
  <li><a href="#">Recurring Bookings</a>
      <ul>
        <li><a href="/createrecurring.php">Create</a></li>
        <li><a href="/managerecurring.php">Manage</a></li>
      </ul>
    </li>
    <?php
    // Writes Admin item in navigation only if user is admin 
    if (isAdmin($conn,$username)) { echo "<li class='admin'><a href='/admin.php'>Admin</a></li>"; } ?>
    <li class="loginout" style="float:right;border-left: 1px solid #ddd;"><a href="/logout.php">Log out</a></li>
  </ul>
<!--Close nav-->
  <!--Page content-->
    <div id="container">
      <div id="content">
  <?php
    if ((isAdmin($conn,$username)) == 0) {
      echo "You are not an admin";
      exit;
    } // if
    echo "<center><h3>Admin Control</h3></center>";
    if($conn) {
      $_SESSION['loggedin'] = true;
    } else {
      die("Connection failed: " . mysql_error());
    } // if
    // Function to write a log in/ log out link
    // depending on whether the user is currently
    // logged in or out
    function writeLogInOut() {
      if (isset($_SESSION['loggedin'])) {
        echo   "<a id='' href='/logout.php'>Log out</a>";
      } else {
        echo   "<a id='' href='/login.php'>Log in</a>";
      }
    } // writeLogInOut
    // writes the navigation menu
    function writeNavigation($conn) {
      ?>
      <div class=''>
      <ul id=''>
      <h3>Make a booking</h3>
        <u><b>IT Equipment</b></u>  
        <li class='nav'><a id='laptoptrolley1' href='/laptoptrolley.php'>Laptop Trolley</a></li>
        <li class='nav'><a id='ipadgrey1' href='/ipadtrolleygrey.php'>iPad Trolley (Grey)</a></li>
        <li class='nav'><a id='ipadblack1' href='/ipadtrolleyblack.php'>iPad Trolley (Black)</a></li>
        <u><b>Rooms</b></u>
        <li class='nav'><a class='nav' href='/conferenceroom.php'>Conference Room</a></li>
        <li class='nav'><a id='meetingroom1' href='/meetingroom.php'>Meeting Room</a></li>
        <u><b>Vehicles</b></u>
        <li class='nav'><a id='minibusjbx1' href='/minibusjbx.php'>Minibus JBX</a></li>
        <li class='nav'><a id='minibusjbx1' href='/minibusjha.php'>Minibus JHA</a></li>
        <li class='nav'><a id='minibusjbx1' href='/minibuslle.php'>Minibus LLE</a></li>
        <li class='nav'><a id='minibusjbx1' href='/minibusyhj.php'>Minibus YHJ</a></li>
        <?php
        if(isAdmin($conn,$_SESSION['username'])) {
          echo "<li id=''><b><a id='admin' href='/admin.php'>Admin Control</a></b></li>";
        }
        ?>
        </ul>
        </div>
      <?php
    } // writeNavigation
    // function to check room availability
    // returns name of user if booked
    // else return null
    function checkAvailable($conn,$date,$period) {
      $sql = "SELECT BookedByName FROM conferenceroom
      WHERE BookingDate=$date AND BookingPeriod=$period";
      $result = mysqli_query($conn,$sql);
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["BookedByName"];
      } // if
      else {
        return null;
      }
    } // checkAvailable

    // checks if user is an admin or not
    function isAdmin($conn,$username) {
      // create sql query to get isAdmin for given username
      $sql = "SELECT isAdmin FROM Names
              WHERE Username='$username'";
      $result = mysqli_query($conn,$sql);
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $isAdmin = $row["isAdmin"];
      } // if
      else {
        $isAdmin = 0;
      } // else
      if (($isAdmin)==1) {
        return true;
      }
      // if 1 then return true
      // else return false
    } // isAdmin
    // Function to check if the user is allowed to book vehicles or not
    function canBookVehicles($conn,$username) {
      // create sql query to get canBookVehicles for given username
      $sql = "SELECT canBookVehicles FROM Names
              WHERE Username='$username'";
      $result = mysqli_query($conn,$sql);
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $canBookVehicles = $row["canBookVehicles"];
      } // if
      else {
        $canBookVehicles = 0;
      } // else
      if (($canBookVehicles)==1) {
        return true;
      }
      // if 1 then return true
      // else return false
    } // canBookVehicles
    // Function to check if user is allowed to book slt resources or not
    // Only certain user may book slt
    function canBookSLT($conn,$username) {
      $sqlCanBookSLT = "SELECT isSLT from Names
                             WHERE Username='$username'";
      $resultCanBookSLT = mysqli_query($conn,$sqlCanBookSLT);
      if (mysqli_num_rows($resultCanBookSLT) > 0) {
        $row = mysqli_fetch_assoc($resultCanBookSLT);
        $canBookSLT = $row["isSLT"];
      } // if
      else {
        $canBookSLT = 0;
      }
      if (($canBookSLT)==1) {
        return true;
      } // if
    } // function canBookSLT
    // Function to create a new user
    // based on the values in the form
    // takes the values given in the 
    function createNewUser($username, $fullname, $password) {
      // checks if the checkbox for 'Is Admin?' is ticked or not
      // defines a variable $isadmin
      $servername = $_SESSION['servername'];
      if (isset($_POST['isadmin'])) {
        $isadmin = true;
      } else {
        $isadmin = false;
      }
      echo "<p id='adduserlog'>";
      try {
        $conn = $_SESSION['conn'];
        // SQL statement to check if username exists
        if (!$username) {
          throw new Exception("Username cannot be empty");
        }
        $sqlAlreadyExists = "SELECT User FROM mysql.user
                             WHERE User='$username'";
        $resultAlreadyExists = mysqli_query($conn,$sqlAlreadyExists);
        if (mysqli_num_rows($resultAlreadyExists) > 0) {
          throw new Exception("Username already exists");
        } else {
          echo "Username ok<br>";
        } // if else
        // Have checked to make sure username does not already exist
        // Now OK to create user in mysql.user
        // Creates user using $username and $password
        $sqlCreateUserInUser = "CREATE USER '$username'@'$servername' IDENTIFIED BY '$password'";
        $resultCreateUserInUser = mysqli_query($conn,$sqlCreateUserInUser);
        // if does not return, i.e. an error occurred, throw an exception 
        if (!$resultCreateUserInUser) {
          throw new Exception("Error creating user");
        } // if
        // If user created is an admin
        // Gives privileges to *.*, as well as ability to grant privileges itself
        if ($isadmin) {
          $sqlGrantPrivileges = "GRANT ALL ON rbook_db.* TO '$username'@'$servername' WITH GRANT OPTION";  
        // Else only gives privileges within rbook_db
        } else {
          $sqlGrantPrivileges = "GRANT ALL ON rbook_db.* TO '$username'@'$servername'";
        }
        $resultGrantPrivileges = mysqli_query($conn,$sqlGrantPrivileges);
        // Throws an exception
        if (!$resultGrantPrivileges) {
          throw new Exception("Error granting privileges");
        }
        // Now create a record in rbook_db.names
        // Which stores username, fullname, and isadmin
        if (!$isadmin) {$isadmin=0;}
        $sqlCreateUserInNames = "INSERT INTO names
                                 (Username, Fullname, isAdmin)
                                 VALUES
                                 ('$username','$fullname',$isadmin)";
        $resultCreateUserInNames = mysqli_query($conn,$sqlCreateUserInNames);
        // If successful
        if ($resultCreateUserInNames) {
          echo "<b>New record added:</b><br>";
          echo "Username: ".$username."<br>";
          echo "Fullname: ".$fullname."<br>";
          echo "Password: ".$password."<br>";
          echo "isAdmin: ".$isadmin."<br>";
        } else {
          throw new Exception("Error adding record to Names table<br>isadmin: $isadmin");
        } 
      } // try
      catch (Exception $e) {
        echo "<b>An error occured:</b><br>";
        echo $e->getMessage();
      } // catch
      finally {
        echo "<br><button id='dismiss'>Dismiss</button>";
        echo "</p>";
      } // finally
    } // createNewUser

    // Function to delete a given user
    // Takes username and deletes records from
    // mysql.user table, and rbook_db.names
    function deleteUser($username) {
      echo "<p id='adduserlog'>";
      try {
        // Delete user from mysql.user
        $sqlDeleteFromUser = "DROP USER '$username'@'localhost'";
        $resultDeleteFromUser = mysqli_query($_SESSION['conn'],$sqlDeleteFromUser);
        if(!$resultDeleteFromUser) {
          throw new Exception("Unable to delete '$username' from mysql.user");
        } // if
        // Delete user from names
        $sqlDeleteFromNames = "DELETE FROM Names
                               WHERE Username='$username'";
        $resultDeleteFromNames = mysqli_query($_SESSION['conn'],$sqlDeleteFromNames);
        if(!$resultDeleteFromNames) {
          throw new Exception("Unable to delete '$username' from rbook_db.names");
        } // if
        $sqlFlush = "FLUSH PRIVILEGES";
        $resultFlush = mysqli_query($_SESSION['conn'],$sqlFlush);
        if(!$resultFlush) {
          throw new Exception("Error flushing privileges");
        }
        echo "User $username was deleted";
      } // try
      catch (Exception $e){
        echo "<b>An error occured:</b><br>";
        echo $e->getMessage();
      } // catch
      finally {
        echo "<br><button id='dismiss'>Dismiss</button>";
        echo "</p>";
      } // finally
    } // deleteUser

    // Function to make a user admin on click of button
    // Validation used so button only appears for those who are not admins already
    function makeAdmin($username) {
      try {
        echo "<p id='adduserlog'>";
        $sqlAddGrantOption = "GRANT ALL PRIVILEGES ON rbook_db.* to '$username'@'localhost'
                              WITH GRANT OPTION";
        //echo $sqlAddGrantOption . "<br>";
        $resultAddGrantOption = mysqli_query($_SESSION['conn'],$sqlAddGrantOption);
        if(!$resultAddGrantOption) {
          throw new Exception("Could not make this user an admin"); 
        } else {
          echo "User $username succesfully made admin<br>";
        }
        $sqlMakeAdmin = "UPDATE Names
                         SET isAdmin=1 WHERE Username='$username'";
        //echo $sqlMakeAdmin . "<br>";
        $resultMakeAdmin = mysqli_query($_SESSION['conn'],$sqlMakeAdmin);
        if(!$resultMakeAdmin) {
          throw new Exception("Could not make this user an admin"); 
        } else {
          echo "User $username succesfully made admin<br>";
        }
      } catch (Exception $e) {
        echo "<b>An error occured:</b><br>";
        echo $e->getMessage();
      } // catch
      finally {
        echo "<br><button id='dismiss'>Dismiss</button>";
        echo "</p>";
      } // finally
    } // makeAdmin
    // Function to make a user able to book vehicles on click of button
    // Validation used so button only appears for those who are not able already
    function makeBookVehicles($username) {
      try {
        echo "<p id='adduserlog'>";
        $sqlMakeBookVehicles = "UPDATE Names
                         SET canBookVehicles=1 WHERE Username='$username'";
        //echo $sqlMakeBookVehicles . "<br>";
        $resultMakeBookVehicles = mysqli_query($_SESSION['conn'],$sqlMakeBookVehicles);
        if(!$resultMakeBookVehicles) {
          throw new Exception("Could not make this user able to book vehicles"); 
        } else {
          echo "User $username succesfully given ability to book vehicles<br>";
        }
      } catch (Exception $e) {
        echo "<b>An error occured:</b><br>";
        echo $e->getMessage();
      } // catch
      finally {
        echo "<br><button id='dismiss'>Dismiss</button>";
        echo "</p>";
      } // finally
    } // makeBookVehicles
    function makeSLT($username) {
      try {
        echo "<p id='adduserlog'>";
        $sqlMakeSLT = "UPDATE Names
                         SET isSLT=1 WHERE Username='$username'";
        //echo $sqlMakeSLT . "<br>";
        $resultMakeSLT = mysqli_query($_SESSION['conn'],$sqlMakeSLT);
        if(!$resultMakeSLT) {
          throw new Exception("Could not make this user Speech &amp; Language"); 
        } else {
          echo "User $username succesfully made Speech &amp; Language<br>";
        }
      } catch (Exception $e) {
        echo "<b>An error occured:</b><br>";
        echo $e->getMessage();
      } // catch
      finally {
        echo "<br><button id='dismiss'>Dismiss</button>";
        echo "</p>";
      } // finally
    } // makeSLT
    // Function to delete a booking, given its Booking ID
    // ID passed as a parameter through the POST of a form
    // The button in the form for each record has the value of that record's booking ID,
    // followed by the table in question
    function deleteBooking($input) {
      try {
        echo "<p id='deletebookinglog'>";
        // Input string is of form "id,table", so we need to explode the string using
        // comma as delimiter, then set individual variables for id and table
        $input_explode = explode(",", $input);
        // Set ID
        $id = $input_explode[0];
        // Set table
        $table = $input_explode[1];
        // Delete record from table
        $sqlDeleteFromTable = "DELETE FROM $table
                               WHERE BookingID=$id";
        $resultDeleteFromTable = mysqli_query($_SESSION['conn'],$sqlDeleteFromTable);
        if(!$resultDeleteFromTable) {
          throw new Exception("Unable to delete Booking $id from table $table");
        } // if
        echo "Successfully deleted booking $id from table $table";
      } // try
      catch (Exception $e){
        echo "<b>An error occured:</b><br>";
        echo $sqlDeleteFromTable . "<br>";
        echo $e->getMessage();
      } // catch
      finally {
        echo "<br><button id='dismiss'>Dismiss</button>";
        echo "</p>";
      }
    } // deleteBooking
    // Writes a table for the given table name
    function writeTable($table) {
      //echo "<p id='$table'>";
      //echo "Showing bookings for $table<br>";
      //echo "<button>Hide</button><br>";
      //echo "</p>";
      echo "<table id='$table'>";
      ?>
        <th>Booking Description</th>
        <th>Booked By Name</th>
        <th>Booking Date</th>
        <th>Booking Period</th>
        <th>Delete?</th>
      <?php
      $sqlGetBookings = "SELECT * from $table ORDER BY bookingdate DESC, bookingperiod ASC";
      $resultGetBookings = mysqli_query($_SESSION['conn'],$sqlGetBookings);
      while($row = mysqli_fetch_assoc($resultGetBookings)) {
        echo "<tr>";
        echo "<td>". $row["BookingDesc"] . "</td>";
        echo "<td>". $row["BookedByName"] . "</td>";
        echo "<td>". $row["BookingDate"] . "</td>";
        echo "<td>". $row["BookingPeriod"] . "</td>";
        echo "<td>";
        // Writes a form with a button, uses POST to post booking ID and table, which become parameters of a function
        ?>
        <form method="POST" action="/admin.php">
        <button type="submit" id="deletebooking" name="deletebooking" onclick="return confirm('Are you sure you want to delete this record?');" value=<?php echo "'".$row["BookingID"].",".$table."'";?>>Delete</button>
        </form>
        <?php
        echo "</td>";
        echo "</tr>";
      } // while
      echo "</table>";
    } // writeTable
    // Function to set a new password, given the username
    // and new password to set
    function setNewPassword($conn, $username, $password) {
      try {
        echo "<p id='adduserlog'>";
        $sqlSetPassword = "SET PASSWORD FOR '$username'@'localhost' = '$password'";
        $resultSetPassword = mysqli_query($conn,$sqlSetPassword);
        if (!$resultSetPassword) {
          throw new Exception("Error changing password: " . mysqli_error($conn) . "<br>");
        }
        else {
          echo "Password successfully changed for $username to $password <br>";
          // if changing password for this user
          if ($username == $_SESSION['username']) {
            // change session variable
            $_SESSION["password"] = $password;
          }
        }
      }
      catch (Exception $e) {
        echo "An error occured:<br>";
        echo $e->getMessage();
      }
      finally {
        echo "<button id='dismiss'>Dismiss</button>";
        echo "</form>";
        echo "</p>";
      }
    }
    // Checks if a booking has been deleted through POST
    if (isset($_POST['deletebooking'])) {
      deleteBooking($_POST['deletebooking']);
    }
    // If new user has been entered
    if (isset($_POST['newuser'])) {
      createNewUser($_POST['newusername'],$_POST['newuserfullname'],$_POST['newuserpwd']);
    }
    // If Delete button pressed on one of the users
    if (isset($_POST['deleteuser'])) {
      deleteUser($_POST['deleteuser']);
    }
    // If Make Admin has been pressed
    if (isset($_POST['makeadmin'])) {
      makeAdmin($_POST['makeadmin']);
    }
    // If allow book vehicles has been pressed
    if (isset($_POST['bookvehicles'])) {
      makeBookVehicles($_POST['bookvehicles']);
    }
    // If make SLT has been pressed
    if (isset($_POST['bookslt'])) {
      makeSLT($_POST['bookslt']);
    }
    // If set own password is pressed
    if (isset($_POST['setmypassword'])) {
      setNewPassword($conn, $_POST['setmypassword'],$_POST['mypassword']);
    }
    // Set password for another user
    if (isset($_POST['setuserpass'])) {
      setNewPassword($conn, $_POST['setuserpass'], $_POST['hiddenpassword']);
    }
    ?>
    <br>
    <!-- Form to set your own password-->
    <form method="POST" action="admin.php">
    <table style="border:1px solid black;">
    <th class="nostyle">Set Your Password</th>
    <th class="nostyle"></th>
    <tr>
      <td class="nostyle">New Password:</td>
      <td class="nostyle">
        <input type="text" id="mypassword" name="mypassword" />
      </td>
    </tr>
    <tr>
      <td class="nostyle"></td>
      <td class="nostyle"><button type="submit" id="setmypassword" name="setmypassword" value=<?php echo "\"" . $username . "\"" ?>>Set Password</button></td>
    </tr>
    </table>
    </form>
    <br>
    <form method="POST" action="admin.php">
      <table class="createuser">
        <th class="nostyle">Add new user</th>
        <th class="nostyle"></th>
        <tr>
          <td class="nostyle">Username:</td>
          <td class="nostyle"><input type="text" name="newusername"><br></td>
        </tr>
        <tr>
          <td class="nostyle">Full name:</td>
          <td class="nostyle"><input type="text" name="newuserfullname"><br></td>
        </tr>
        <tr>
          <td class="nostyle">Password:</td>
          <td class="nostyle"><input type="text" name="newuserpwd"><br></td>
        </tr>
        <tr>
          <td class="nostyle"><input type="checkbox" id="isadmin" name="isadmin" value="yes">Is Admin?</button></td>
          <td class="nostyle"><button type="submit" id="newuser" name="newuser" value="newuser">Create</button></td>
        </tr>
      </table>
    </form>
    <br>
    <form method="POST" action="importcsv.php" enctype="multipart/form-data">
    <table style="border:1px solid black;">
    <th class="nostyle">Import CSV</th>
    <th class="importcsv"></th>
    <tr>
      <td class="nostyle">File Location:</td>
      <td class="importcsv">
        <input type="file" id="theFile" name="theFile" />
      </td>
    </tr>
    <tr>
      <td class="nostyle"></td>
      <td class="importcsv"><button type="submit" id="browsecsv" name="browsecsv" value="">Import CSV</button></td>
    </tr>
    </table>
    </form>
    <br>
    <button id="showusers">Toggle Users Table</button><br>
    <!--Users table which can be shown and hidden using jQuery-->
    <table id="userstable">
    <!--PHP to write a list of all users in the system, with other details-->
    <th>Username</th>
    <th>Full name</th>
    <th>is Admin?</th>
    <th>Make Admin</th>
    <th>Can Book Vehicles?</th>
    <th>Allow Book Vehicles</th>
    <th>is SLT?</th>
    <th>Make SLT</th>
    <th>Delete?</th>
    <th>Set Password</th>
    <?php
      $sqlGetUsers = "SELECT * FROM names";
      $resultGetUsers = mysqli_query($_SESSION['conn'],$sqlGetUsers);
      while($row = mysqli_fetch_assoc($resultGetUsers)) {
        echo "<tr>";
        echo "<td>". $row["Username"] . "</td>";
        echo "<td>". $row["Fullname"] . "</td>";
        echo "<td>". $row["isAdmin"] . "</td>";
        ?>
          <td>
          <form method="POST" action="admin.php">
          <!--Has a confirm box to make sure user can cancel action-->
          <?php
          // If the user is not an admin
          // Shows 'Make Admin' button 
          if (!isAdmin($conn,$row["Username"])) {
          ?>
          <button type="submit" id="makeadmin" name="makeadmin" onclick="return confirm('Are you sure you want to make this user admin?');" value=<?php echo "'".$row["Username"]."'";?>>Make Admin</button>
          <?php
          }
          ?>
          </form>
          <?php
          echo "<td>". $row["canBookVehicles"]. "</td>";
          echo "<td>";
          if (!canBookVehicles($conn,$row["Username"])) {
          ?>
            <form method="POST" action="admin.php">
            <!--Has a confirm box to make sure user can cancel action-->
            <button type="submit" id="bookvehicles" name="bookvehicles" onclick="return confirm('Are you sure you want to allow this user to book vehicles?');" value=<?php echo "'".$row["Username"]."'";?>>Allow</button>
            <?php
          }
            ?>
            </form>
          </td>
          <?php
          echo "<td>". $row["isSLT"]. "</td>";
          echo "<td>";
          if (!canBookSLT($conn,$row["Username"])) {
          ?>
            <form method="POST" action="admin.php">
            <!--Has a confirm box to make sure user can cancel action-->
            <button type="submit" id="bookslt" name="bookslt" onclick="return confirm('Are you sure you want to make this user Speech &amp; Language?');" value=<?php echo "'".$row["Username"]."'";?>>Allow</button>
            <?php
          }
            ?>
          <td>
            <form method="POST" action="admin.php">
            <!--Has a confirm box to make sure user can cancel action-->
            <button type="submit" id="deleteuser" name="deleteuser" onclick="return confirm('Are you sure you want to delete this record?');" value=<?php echo "'".$row["Username"]."'";?>>Delete</button>
            </form>
          </td>
          <td>
            <!--Button to reset password-->
            <?php
            echo "<form method='POST' action='admin.php'>";
            echo "<input type='hidden' id='password," . $row["Username"] . "' name='hiddenpassword' value='' runat='server'>";
            echo "<button type='submit' id='setuserpass' name='setuserpass' ";
            echo "onclick=\"getNewPassword('" . $row["Username"] ."')\"";
            echo "value='".$row["Username"]."'>Set</button>";
            echo "</form>";
            ?>
          </td>
        </td>
        <?php
        echo "</tr>";
      } // while
    ?>
    </table>
    <br>
    <h4>Manage Bookings</h4>
    <select id="managebookings">
      <option value="empty">- Select an option -</option>
      <option value="laptoptrolley">Laptop Trolley</option>
      <option value="ipadtrolleyblack">iPad Trolley (Black)</option>
      <option value="ipadtrolleygrey">iPad Trolley (Grey)</option>
      <option value="meetingroom">Meeting Room</option>
      <option value="conferenceroom">Conference Room</option>
      <option value="minibusjbx">Minibus JBX</option>
      <option value="minibusjha">Minibus JHA</option>
      <option value="minibuslle">Minibus LLE</option>
      <option value="minibusyhj">Minibus YHJ</option>
      <option value="empty">&nbsp;</option>
      <option value="empty">- Speech &amp; Language -</option>
      <option value="slt_grouptherapy">Group Therapy</option>
      <option value="slt_individualtherapy">Individual Therapy</option>
      <option value="slt_signalong">Signalong</option>
      <option value="slt_ace">ACE</option>
      <option value="slt_dls">DLS</option>
      <option value="slt_celf4">CELF 4</option>
      <option value="slt_rlsbst">RLS BST</option>
      <option value="slt_rlsapt">RLS APT</option>
      <option value="slt_rlswfvt">RLS WFVT</option>
      <option value="slt_clear">CLEAR</option>
      <option value="slt_celf3">CELF 3</option>
      <option value="slt_towk">TOWK</option>
      <option value="slt_clip">CLIP</option>
      <option value="slt_stass">STASS</option>
      <option value="slt_stap">STAP</option>
      <option value="slt_acap">ACAP</option>
      <option value="slt_screener">Phonology Screener</option>
      <option value="slt_ndp">NDP</option>
      <option value="slt_talc1">TALC 1</option>
      <option value="slt_talc2">TALC 2</option>
    </select>
    <button id="showbookings">Show Bookings</button>
    <br>
    <?php
    writeTable("laptoptrolley");
    writeTable("ipadtrolleyblack");
    writeTable("ipadtrolleygrey");
    writeTable("meetingroom");
    writeTable("conferenceroom");
    writeTable("minibusjbx");
    writeTable("minibusjha");
    writeTable("minibuslle");
    writeTable("minibusyhj");
    writeTable("slt_grouptherapy");
    writeTable("slt_individualtherapy");
    writeTable("slt_signalong");
    writeTable("slt_ace");
    writeTable("slt_dls");
    writeTable("slt_celf4");
    writeTable("slt_rlsbst"); 
    writeTable("slt_rlsapt"); 
    writeTable("slt_rlswfvt");
    writeTable("slt_clear");
    writeTable("slt_celf3");
    writeTable("slt_towk");
    writeTable("slt_clip");
    writeTable("slt_stass");
    writeTable("slt_stap");
    writeTable("slt_acap");
    writeTable("slt_screener");
    writeTable("slt_ndp");
    writeTable("slt_talc1");
    writeTable("slt_talc2");
    ?>
  </div>
  <footer style="position: fixed; bottom: 10px; width: 100%; height: 15px;">
    <span style="float:right;font-size:12px;background-color:white;padding: 2.5px 5px 5px 5px">
      <a href="about.php">about</a> | created by <a href="http://aturner.co/">Alex Turner</a>, 2016
    </span>
  </footer>
</body>
</html>