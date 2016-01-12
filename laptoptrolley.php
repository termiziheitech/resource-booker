<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=11" />
  <title>Laptop Trolley</title>
  <!--CSS stylesheet-->
  <link rel='stylesheet' type='text/css' href='my-style.css'>
  <!--JQuery library-->
  <script src="jquery-2.1.4.min.js"></script>
  <!--Google font-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <meta http-equiv="X-UA-Compatible" content="IE=11" />
  <script>
  $(document).ready(function(){
    $("#dismiss").click(function(){
      $("#createuserlog").hide();
    });
  });
  </script>
</head>
<body>

  <?php
  date_default_timezone_set("Europe/London");
  // Start a session
  session_start();
  $servername = "localhost";
  $username = $_SESSION['username'];
  $password  = $_SESSION['password'];
  $db_selected = "rbook_db";
  $table = "laptoptrolley";
  $_SESSION["currenttable"] = $table;
  // Establish connection to db
  $conn = mysqli_connect($servername,$username,$password,$db_selected);
  if (!$_SESSION['loggedin']) {
    echo "You must be logged in to continue";
    echo "<a href='/login.php'>Log in</a>";
    exit;
  }
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
  // Set variables, get username and password from session
  $servername = "localhost";
  $username = $_SESSION['username'];
  $password  = $_SESSION['password'];
  $db_selected = "rbook_db";
  $table = "laptoptrolley";
  $_SESSION["currenttable"] = $table;
  // Establish connection to db
  $conn = mysqli_connect($servername,$username,$password,$db_selected);
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
      echo   "<a id='nav' href='/logout.php'>Log out</a>";
    } else {
      echo   "<a id='nav' href='/login.php'>Log in</a>";
    }
  } // writeLogInOut
  // writes the navigation menu
  // checks if logged in or not, to change
  // login/logout menu item
  function writeNavigation($conn) {
    // if logged in
    // print log out link
    // else print log in link
    ?>
    <div class=''>
    <ul id=''>
    <h3>Make a booking</h3>
      <u><b>IT Equipment</b></u>
      <li id=''><a id='laptoptrolley' href='/laptoptrolley.php'>Laptop Trolley</a></li>
      <li id=''><a id='ipadgrey' href='/ipadtrolleygrey.php'>iPad Trolley (Grey)</a></li>
      <li id=''><a id='ipadblack' href='/ipadtrolleyblack.php'>iPad Trolley (Black)</a></li>
      <u><b>Rooms</b></u>
      <li id=''><a id='conferenceroom' href='/conferenceroom.php'>Conference Room</a></li>
      <li id=''><a id='meetingroom' href='/meetingroom.php'>Meeting Room</a></li>
      <u><b>Vehicles</b></u>
      <li id=''><a id='minibusjbx' href='/minibusjbx.php'>Minibus JBX</a></li>
      <li id=''><a id='minibusjha' href='/minibusjha.php'>Minibus JHA</a></li>
      <li id=''><a id='minibusjlle' href='/minibuslle.php'>Minibus LLE</a></li>
      <li id=''><a id='minibusyhj' href='/minibusyhj.php'>Minibus YHJ</a></li>
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
    $sql = "SELECT BookedByName FROM laptoptrolley
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
    if ($isAdmin == 1) {
      return true;
    }
    // if 1 then return true
    // else return false
  } // isAdmin
  // checks if the date you are checking is today
  function checkIfToday($date) {
    $today = date('Ymd');
    if ($date == $today) {
      return true;
    }
  } // checkIfToday
  // checks if current date is in the past
  function checkIfInThePast($date) {
    // set today date
    $today = date('Ymd');
    // if date is less than today
    if (strtotime($date) < strtotime($today)) {
      // return true
      // i.e. yes date is in the past
      return true;
    } // if
  } // checkIfInThePast
  // function to calculate next date
  // given a date
  // dates are given in format YYYYMMDD
  function findNextDate($date) {
    // check date string is right length
    if (strlen($date) == 8) {
      // first 4 digits -> year
      $year = substr($date, 0, 4);
      $month = substr($date, 4, 2);
      $day = substr($date, 6, 2);
    }
    else {
      return "Error: string of wrong length";
    }
    $maxdays = findMaxDays($month,$year);
    if ($day < $maxdays) {
      $day += 1;
    } //if
    else
    {
      if ($month < 12) {
        $day = 1;
        $month += 1;
      } // if
      else {
        $day = 1;
        $month = 1;
        $year += 1;
      } // else
    } // else
    // return in format YYYYMMDD
    // if single digit, puts 0 in front of it
    // e.g. 9 -> 09
    if (strlen($month) == 1)
      $month = "0".$month;
    if (strlen($day) == 1)
      $day = "0".$day;
    return $year.$month.$day;
  } // findNextDate
  // Function to find previous date
  // given a date 
  function findPreviousDate($date) {
   // check date string is right length
   if (strlen($date) == 8) {
     // first 4 digits -> year
     $year = substr($date, 0, 4);
     $month = substr($date, 4, 2);
     $day = substr($date, 6, 2);
   }
   else {
     return "Error: string of wrong length";
   }
   // finds max days in a month
   $maxdays = findMaxDays(($month-1),$year);
   // if first day of month
   if ($day == 1) {
    // day goes back to 28/29/30/31
    $day = $maxdays;
    // if month = 1, go back 1 year, set year to previous year
    // and set month to 12
    if ($month == 1) {
      $month = 12;
      $year -= 1;
    } // if
    // else, go back to previous month
    else {
      $month--;
    } // else
   } // if
   // else just go back a single day
   else {
    $day -= 1;
   } // else
   if (strlen($month) == 1)
     $month = "0".$month;
   if (strlen($day) == 1)
     $day = "0".$day;
   return $year.$month.$day;
  } // findPreviousDate
  // finds the maximum number of days in a month
  // used by findNextDate and findPreviousDate
  function findMaxDays($month,$year) {
    $maxdays = 0;
    switch($month) {
      case 1:
        return 31;
        break;
      case 2:
        // February: account for leap year
        if ($year % 4 == 0) {
          return 29;
          break;
        } else {
          return 28;
          break;
        }
      case 3:
        return 31;
        break;
      case 4:
        return 30;
        break;
      case 5:
        return 31;
        break;
      case 6:
        return 30;
        break;
      case 7:
        return 31;
        break;
      case 8:
        return 31;
        break;
      case 9:
        return 30;
        break;
      case 10:
        return 31;
        break;
      case 11:
        return 30;
        break;
      case 12:
        return 31;
        break;
    } // switch
  } // findMaxDays
  // Finds the date of Monday of a week
  // Given some date within that week
  // (Improve to use fallthrough of switch statement)
  function findMonDate($todaydate) {
    // convert date to time
    $timestamp = strtotime($todaydate);
    // gets 3 character representation of day
    $todayday = date("D", $timestamp);
    // Switch using $todayday i.e. "Mon" - "Sun"
    // Implements fallthrough, so that the once a case has been
    // selected, all statements are executed until 'break' is reached
    // Therefore, for "Sun", findPreviousDate is executed 6 times
    // For "Mon", it is never executed. Both executed the return statement and break.
    switch($todayday) {
      case "Sun":
        $todaydate = findPreviousDate($todaydate);
      case "Sat":
        $todaydate = findPreviousDate($todaydate);
      case "Fri":
        $todaydate = findPreviousDate($todaydate);
      case "Thu":
        $todaydate = findPreviousDate($todaydate);
      case "Wed":
        $todaydate = findPreviousDate($todaydate);
      case "Tue":
        $todaydate = findPreviousDate($todaydate);
      case "Mon":
        // Executed by all cases
        return $todaydate;
        break;
      default:
        return $todaydate;
        break;
    } // switch
  } // findMonDate
  // function to output a date in format
  // "MM/YY"
  // given a date in format YYYYMMDD
  function styleDate($date) {
    // check date string is right length
    if (strlen($date) == 8) {
      // first 4 digits -> year
      $year = substr($date, 0, 4);
      $month = substr($date, 4, 2);
      $day = substr($date, 6, 2);
    }
    else {
      return "Error: string of wrong length";
    }
    return $day."/".$month;
  } // styleDate
  // takes no parameters and prints in form DD(th) Month YYYY
  // only uses mondate from SESSION
  function styleWeekOf() {
    // check date string is right length
    if (strlen($_SESSION["mondate"]) == 8) {
      // first 4 digits -> year
      $year = substr($_SESSION["mondate"], 0, 4);
      $month = substr($_SESSION["mondate"], 4, 2);
      $day = substr($_SESSION["mondate"], 6, 2);
    }
    else {
      return "Error: string of wrong length";
    }
    $mydate = date_create($year.$month.$day);
    return date_format($mydate, "l, jS \of F Y");
  } // styleWeekOf
  // Used to write the individual cells
  // Each individual cell contains a form which POSTs to booking_exec.php
  // the value of the form is $date,$period
    function writeCell($conn,$date,$period) {
    // checks if available
    $name = checkAvailable($conn,$date,$period);
    // if something is returned, then it is booked
    if ($name) {
      echo "<td class='booked'><b>".$name."</b></td>";
    } else {
      // check if the date is in the past
      if (checkIfInThePast($date)) {
        //if in the past, write a cell
        echo "<td class='past'></td>";
      } else {
        // checks if user is read only or not
        if(!readOnly($conn)) {
          // else write a form containing a button to POST
          echo "<form method='POST' action='laptoptrolley.php'>";
          echo "<td class='available'><button type='submit' id='availablebtn' name='book'";
          echo "onclick=\"return confirm('" . writeDialog("Laptop Trolley",$date,$period) . "');\"";
          echo "value='".$date.",".$period."'>Book</button></td>";
          echo "</form>";
        } else {
          // if read-only, does not write book button
          echo "<td class='available'></td>";
        } // else
      } // else
    } // else
  } // writeCell
  // Writes the text in the confirm box
  // Using the date and period and tablestring
  function writeDialog($tablestring,$date,$period) {
    $dialog = "Are you sure you wish to make the following booking?\\n";
    $dialog .= "Resource: " . $tablestring . "\\n";
    $dialog .= "Date: " . date("l, jS F Y",strtotime($date)) . "\\n";
    $dialog .= "Period: " . $period . "\\n\\n\\n";
    return $dialog;
  } // function writeDialog
  // Check if user is read-only
  // If returns true, then user cannot book, can only view
  function readOnly($conn) {
    $username = $_SESSION["username"];
    $sqlReadOnly = "SELECT readOnly from Names
                   WHERE Username='$username'";
    $resultReadOnly = mysqli_query($conn,$sqlReadOnly);
    if (mysqli_num_rows($resultReadOnly) > 0) {
      $row = mysqli_fetch_assoc($resultReadOnly);
      $readOnly = $row["readOnly"];
    } // if
    if ($readOnly) {
      return true;
    } else {
      return false;
    } // else
  } // readOnly

  // Function to jump forward a week
  // This will set the mondate to a weed ahead of this now
  // since all dates are calculated based on mondate
  // the button in the form uses POST to send mondate
  function setToNextWeek($prevdate) {
    $prevdate = strtotime($_POST["nextweek"]);
    $nowdate = strtotime("+1 week", $prevdate);
    $_SESSION["mondate"] = date('Ymd',$nowdate);
    $_POST["nextweek"] = null;
  } // setToNextWeek

  // Function to return back to the current week now
  // Sets todaydate to now
  // Uses function findMonDate() to find the mondate for this week
  function setToCurrentWeek() {
    $_SESSION["todaydate"] = date('Ymd');
    $_SESSION["mondate"] = findMonDate($_SESSION["todaydate"]);
    $_POST["currentweek"] = null;
  } // setToCurrentWeek

  // Function to jump backwards a week
  // This will set the mondate to the week before this week
  // since all dates are calculated based on mondate
  // the button in the form uses POST to send mondate
  function setToPreviousWeek($prevdate) {
    $prevdate = strtotime($_POST["prevweek"]);
    $nowdate = strtotime("-1 week", $prevdate);
    $_SESSION["mondate"] = date('Ymd',$nowdate);
    $_POST["prevweek"] = null;
  } // setToPreviousWeek
  // Function to create a booking
  function createBooking($inputstring,$conn) {
    //$conn = $_SESSION["conn"];
    // explodes input string using comma as delimiter
    $str_explode = explode(",", $inputstring);
    // sets variables for creating a booking
    $date = $str_explode[0]; // date
    $id = $_SESSION["id"];
    $name = $_SESSION["username"];
    $period = $str_explode[1];
    $table = $_SESSION["currenttable"];
    $fullname = $_SESSION['fullname'];
    echo "<p id='createuserlog'>";
    try {
      // check if there is a record with the same 
      $sqlCheck = "SELECT * FROM $table
                   WHERE BookingDate='$date' AND BookingPeriod='$period'";
      $resultCheck = mysqli_query($conn,$sqlCheck);
      // If the query returns at least one row
      if (mysqli_num_rows($resultCheck) > 0)
      {
        throw new Exception("A record already exists in this timeslot<br>");
      } // if
      // Else timeslot is available
      else {
        // Query to insert record
        $sqlInsert = "INSERT INTO $table (BookingDate, BookedByID, BookedByName,BookingPeriod)
                      VALUES ('$date', '$id', '$fullname', '$period')";
        $resultInsert = mysqli_query($conn,$sqlInsert);
        if ($resultInsert) {
          echo "New record added<br>";
        } else {
          throw new Exception("Error adding record: " . $sqlInsert . mysqli_error($conn) . "<br>");
        } // else
      } // else
    } // try
    catch (Exception $e){
      echo "An error occured:<br>";
      echo $e->getMessage();
    } // catch
    finally {
      echo "<form method='POST' action='laptoptrolley.php'>";
      echo "<button type='submit' id='undo' name='undo' value='$date,$period'>Undo</button>";
      echo "<button id='dismiss'>Dismiss</button>";
      echo "</form>";
      echo "</p>";
    } // finally
  } // createBooking
  // Function to delete a booking, based on the input from the undo button
  function deleteBooking($inputstring,$conn) {
    try {
      // explodes input string using comma as delimiter
      $str_explode = explode(",", $inputstring);
      // sets variables for creating a booking
      $date = $str_explode[0]; // date
      $period = $str_explode[1]; // period
      $table = $_SESSION["currenttable"];
      $sqlDelete = "DELETE FROM $table 
                    WHERE BookingDate=$date AND BookingPeriod=$period";
      $resultDelete = mysqli_query($conn,$sqlDelete);
      if (!$resultDelete) {
        throw new Exception("Could not delete record from $table<br>");
      } // if
    } // try
    catch (Exception $e) {
      echo "<p id='createuserlog'>";
      echo "An error occured deleting booking<br>";
      echo $e->getMessage();
    } // catch
    finally {

    } // finally
  } // deleteBooking
  // Set up inital date
  $_SESSION["todaydate"] = date('Ymd');
  // Checks if currentweek button has been pressed
  // to call setToCurrentWeek function
  if (isset($_POST["currentweek"])) {
    setToCurrentWeek();
  }
  // Checks if next week button has been pressed
  elseif (isset($_POST["nextweek"])) {
    setToNextWeek($_POST["nextweek"]);
  }
  // Checks if previous week button has been pressed
  elseif (isset($_POST["prevweek"])) {
    setToPreviousWeek($_POST["prevweek"]);
  } // elseif
  elseif (isset($_POST["book"])) {
    createBooking($_POST["book"],$conn);
  } // elseif
  elseif (isset($_POST["undo"])) {
    deleteBooking($_POST["undo"],$conn);
  }
  else {
    setToCurrentWeek();
  } // else
  $mondate = $_SESSION["mondate"];
  // calculate whole week
  $tuedate = findNextDate($mondate);
  $weddate = findNextDate($tuedate);
  $thudate = findNextDate($weddate);
  $fridate = findNextDate($thudate);
  ?>
  <!-- Form used to change to previous or next week
  Set values to current mondate, so that next mondate
  Can be set as +1 week (or -1 week for previous)-->
  <center>
  <h3>Laptop Trolley</h3><br>         
  <form method="POST" action='laptoptrolley.php'>
    <button type='submit' id="prevweek" name="prevweek" <?php echo "value='".$_SESSION['mondate']."'"; ?>>Previous Week</button>
    <b>Week of <?php echo styleWeekOf(); ?></b>
    <button type='submit' id="nextweek" name="nextweek"<?php echo "value='".$_SESSION['mondate']."'"; ?>>Next Week</button><br>
    <button type='submit' id="currentweek" name="currentweek"<?php echo "value='".$_SESSION['mondate']."'"; ?>>Current Week</button><br>
  </form>
  </center>
  <table class="calendar">
    <tr>
    <!-- Write table headers -->
    <!-- Write table headers -->
      <th></th>
      <?php
      // Monday
      echo "<th>";
      if (checkIfToday($mondate)) {
        echo "<u>";
      } // if
      echo "Monday";
      echo "<br>" . styleDate($mondate) . "</u></th>";
      // Tuesday
      echo "<th>";
      if (checkIfToday($tuedate)) {
        echo "<u>";
      } // if
      echo "Tuesday";
      echo "<br>" . styleDate($tuedate) . "</u></th>";
      // Wednesday
      echo "<th>";
      if (checkIfToday($weddate)) {
        echo "<u>";
      } // if
      echo "Wednesday";
      echo "<br>" . styleDate($weddate) . "</u></th>";
      // Thursday
      echo "<th>";
      if (checkIfToday($thudate)) {
        echo "<u>";
      } // if
      echo "Thursday";
      echo "<br>" . styleDate($thudate) . "</u></th>";
      // Friday
      echo "<th>";
      if (checkIfToday($fridate)) {
        echo "<u>";
      } // if
      echo "Friday";
      echo "<br>" . styleDate($fridate) . "</u></th>";
      ?>
    </tr>
    <tr>
      <!--PERIOD 1-6-->
      <?php
      for ($period=1;$period<=6;$period++) {
      echo "<tr>";
      echo "<th>Period ".$period."</th>"; 
      writeCell($conn,$mondate,$period);
      writeCell($conn,$tuedate,$period);
      writeCell($conn,$weddate,$period);
      writeCell($conn,$thudate,$period);
      writeCell($conn,$fridate,$period);
      echo "</tr>";
      } // for
      ?>
    </table>
    <?php
    // close connection
    //mysqli_close($conn);
    ?>
  </div>
</div>
<footer style="position: fixed; bottom: 10px; width: 100%; height: 15px;">
  <span style="float:right;font-size:12px;background-color:white;padding: 2.5px 5px 5px 5px">
    <a href="about.php">about</a> | created by <a href="http://aturner.co/">Alex Turner</a>, 2016
  </span>
</footer>
</body>
</html>