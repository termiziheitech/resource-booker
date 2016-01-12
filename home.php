<!DOCTYPE html>
<html>
<head>
  <!-- Created by Alex Turner, 2015-->
  <!--JQuery library-->
  <title>Home</title>
  <!--CSS stylesheet-->
  <link rel='stylesheet' type='text/css' href='my-style.css'>
  <!--Google font-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <!--Favicon-->
  <link rel="icon" type="image/ico" href="/favicon.ico"/>
  <meta http-equiv="X-UA-Compatible" content="IE=11" />

</head>
<body>
  <?php
  date_default_timezone_set("Europe/London");
  // Start a session
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    echo "You must be logged in to continue<br>";
    echo "<a href='/login.php'>Log in</a>";
    exit;
  }
  if (!$_SESSION['loggedin']) {
    echo "You must be logged in to continue<br>";
    echo "<a href='/login.php'>Log in</a>";
    exit;
  }

  $servername = "localhost";
  $username = $_SESSION['username'];
  $password  = $_SESSION['password'];
  $db_selected = "rbook_db";
  $table = "conferenceroom";
  $_SESSION["currenttable"] = $table;
  // Establish connection to db
  $conn = mysqli_connect($servername,$username,$password,$db_selected);
  $_SESSION["conn"] = $conn;
  // Set up inital date
  if(!isset($_SESSION['todaydate'])) {
    $_SESSION["todaydate"] = date('Ymd');
  }

  // Set up mondate if not already set from next week/previous week functions
  if(!isset($_SESSION['mondate'])) {
    $_SESSION['mondate'] = findMonDate($_SESSION['todaydate']);
  }
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
    <p id="home">
      <?php
      echo "<h2>Welcome " . $_SESSION["fullname"] . ".</h2><br>";
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

      $today = date('l, jS \of F Y');
      echo "Today's date is $today. <br><br>";
      // if user is read only / guest
      if (readOnly($conn)) {
        echo "You are logged in as a guest.<br>
              This means that you cannot make bookings, only view them.<br>
              To make a booking, log out and log in using a user account.";
      } else {
        // Calls function to write today's bookings
        printTodayBookings();
      }
      // Function to check if the user has any bookings for today
      // If they have, prints them sequentially in a styled format
      // If not, prints a message to say that they have no bookings
      function printTodayBookings() {
        try {
          // Sets today's date in form YYYYMMDD for searching
          $today = date("Ymd");
          // Start by initialising an array, which will be used to loop through
          // to check each table for bookings
          // Stores table name, table string, and resource type
          $tables = array
          (
            array("laptoptrolley", "Laptop Trolley", "IT Equipment"),
            array("ipadtrolleyblack", "iPad Trolley (Black)", "IT Equipment"),
            array("ipadtrolleygrey", "iPad Trolley (Grey)", "IT Equipment"),
            array("conferenceroom", "Conference Room", "Rooms"),
            array("meetingroom", "Meeting Room", "Rooms"),
            array("minibusjbx", "Minibus JBX", "Vehicles"),
            array("minibusjha", "Minibus JHA", "Vehicles"),
            array("minibuslle", "Minibus LLE", "Vehicles"),
            array("minibusyhj", "Minibus YHJ", "Vehicles"),
            array("slt_grouptherapy", "Group Therapy", "SLTRooms"),
            array("slt_individualtherapy", "Individual Therapy", "SLTRooms"),
            array("slt_signalong", "Signalong", "SLTRooms"),
            array("slt_ace", "ACE", "Assessments"),
            array("slt_dls", "DLS", "Assessments"),
            array("slt_celf4", "CELF 4", "Assessments"),
            array("slt_rlsbst", "RLS BST", "Assessments"),
            array("slt_rlsapt", "RLS APT", "Assessments"),
            array("slt_rlswfvt", "RLS WFVT", "Assessments"),
            array("slt_clear", "CLEAR", "Assessments"),
            array("slt_celf3", "CELF 3", "Assessments"),
            array("slt_towk", "TOWK", "Assessments"),
            array("slt_clip", "CLIP", "Assessments"),
            array("slt_stass", "STASS", "Assessments"),
            array("slt_stap", "STAP", "Assessments"),
            array("slt_acap", "ACAP", "Assessments"),
            array("slt_screener", "Phonology Screener", "Assessments"),
            array("slt_ndp", "NDP", "Assessments"),
            array("slt_talc1", "TALC 1", "Assessments"),
            array("slt_talc2", "TALC 2", "Assessments"),
            );
            // Sets a return string which will be printed once all other functions
            // have taken place
            // Mainly so number of bookings can be written first
          $returnstring = "";
            // Creates counter for the number of bookings
          $numbookings = 0;
            // For each element in array, i.e. for every table
          foreach($tables as $table) {
              // Gets an array of all periods booked for this resource on this date
            $results = findBookingsForDate($today, $table[0],$table[1],$table[2]);
            if ($results) {
              for ($i = 0, $c=count($results); $i<$c; $i++) {
                  // Uses resulting period and resource type to style the period
                $returnstring .= "$table[1] is booked for <b>" . stylePeriod($results[$i],$table[2]) . " </b><br>";
                $numbookings+=1;
                } // for
              } // if
            } // foreach
            if ($numbookings == 0) {
              echo "<b>You have no bookings for today.</b><br>";
              echo "To make a booking, go to \"Make a Booking\" and select a resource.<br>";
            } // if
            else {
              // Different return string for a single booking
              if ($numbookings == 1) {
                echo "<b>You have $numbookings booking today:<br></b>";
                echo "<p>$returnstring<p>";
              } // if
              else {
                echo "<b>You have $numbookings bookings today:<br></b>";
                echo "<p style='line-height:200%;'>$returnstring</p>";
              } // else
            } // else
        } // try
        catch (Exception $e){
          echo "<b>An error occured:</b><br>";
          echo $sqlDeleteFromTable . "<br>";
          echo $e->getMessage();
        } // catch
        finally {

        }
      } // printTodayBookings
      // Function to get ID, using username
      function getID($conn, $username) {
        $sqlGetID = "SELECT ID FROM Names
                     WHERE Username='$username'";
        $resultGetID = mysqli_query($conn,$sqlGetID);
        if (!$resultGetID)
        {
          echo "Problem finding user<br>";
        } else {
          $rowid = mysqli_fetch_row($resultGetID);
          $id = $rowid[0];
        }
        // set session variable for ID
        $_SESSION["id"] = $id;
        return $id;
      } // function getID
      // Function to get full name, given username 
      function getUsername($conn, $username) {
        $sqlGetUsername = "SELECT Username FROM Names
                     WHERE Username='$username'";
        $resultGetUsername = mysqli_query($conn,$sqlGetUsername);
        if (!$resultGetUsername)
        {
          echo "Problem finding user<br>";
        } else {
          $rowUsername = mysqli_fetch_row($resultGetUsername);
          $username = $rowUsername[0];
        }
        // set session variable for Username
        $_SESSION["username"] = $username;
        return $username;
      } // function getUsername
      // Function used to find the bookings in a given table for a given date
      // Used to find if there are any bookings in that table, and returns
      // the period(s), if any
      function findBookingsForDate($date,$table,$tablestring,$resourcetype){
        $username = $_SESSION["username"];
        $conn = $_SESSION["conn"];
        // gets user ID using function
        $id = getUserID($conn,$username);
        $sqlFindBookingPeriods = "SELECT BookingPeriod FROM $table
        WHERE BookingDate=$date AND BookedByID='$id'";
        $resultFindBookingPeriods = mysqli_query($conn,$sqlFindBookingPeriods);
        // If any bookings are found, creates an array of their periods and returns it
        if(mysqli_num_rows($resultFindBookingPeriods) > 0) {
          $count = 0;
          while($row = mysqli_fetch_assoc($resultFindBookingPeriods)) {
            $period[$count] = $row["BookingPeriod"];
            $count++;
          } // while
          sort($period);
          return $period;
        } // if
        // Else returns null
        else {
          return null;
        } // else
      } // function findBookingsForDate
      // Function to check if user is read only or not
      function readOnly($conn) {
        $username = $_SESSION["username"];
        $sqlReadOnly = "SELECT readOnly from Names
                       WHERE Username='$username'";
        $resultReadOnly = mysqli_query($conn,$sqlReadOnly);
        if (mysqli_num_rows($resultReadOnly) > 0) {
          $row = mysqli_fetch_assoc($resultReadOnly);
          $readOnly = $row["readOnly"];
        } // if
        else {
          $readOnly = false;
        }
        if ($readOnly) {
          return true;
        } else {
          return false;
        } // else
      } // readOnly
      // Function to return a stylized Period string
      // Since rooms and vehicles use a different period system
      // but still use the same period numbering system
      function stylePeriod($period,$resourcetype) {
        // IT Equipment is simple, because it just uses
        // Period 1 - Period 6 as its numbering
        if ($resourcetype == "IT Equipment" || $resourcetype == "SLTRooms") {
          return "Period $period";
        } // if
        // Rooms have a time based system
        // So period 1 -> 9:00 - 10:00, 2 -> 10:00 - 11:00...
        else if ($resourcetype == "Rooms" || $resourcetype == "Assessments") {
          // a switch statement is probably the easiest way to do this
          switch($period) {
            case 1: return "9:00 - 10:00";  break;
            case 2: return "10:00 - 11:00"; break;
            case 3: return "11:00 - 12:00"; break;
            case 4: return "12:00 - 13:00"; break;
            case 5: return "13:00 - 14:00"; break;
            case 6: return "14:00 - 15:00"; break;
            case 7: return "15:00 - 16:00"; break;
            case 8: return "16:00 - 17:00"; break;
            default: return $period; break;
          } // switch
        } // else if
        // Vehicles are slightly different, wherein Period 3 -> Break
        // and Period 6 -> Lunch, and the other periods 1-6 have to
        // compensate for this shift
        else if ($resourcetype == "Vehicles") {
          switch($period) {
            case 1: return "Period 1";  break;
            case 2: return "Period 2"; break;
            case 3: return "Break"; break;
            case 4: return "Period 3"; break;
            case 5: return "Period 4"; break;
            case 6: return "Lunch"; break;
            case 7: return "Period 5"; break;
            case 8: return "Period 6"; break;
            default: return $period; break;
          } // switch
        } // else if
        else {
          return $period;
        } // else
      } // function stylePeriod
      // Gets the ID of the user, given their username
      // Using Names table
      function getUserID($conn,$username) {
        $sqlGetID = "SELECT ID FROM Names
        WHERE Username='$username'";
        $resultGetID = mysqli_query($conn,$sqlGetID);
        if (mysqli_num_rows($resultGetID) > 0) {
          $row = mysqli_fetch_assoc($resultGetID);
          return $row["ID"];
        } else {
          return -1;
        } // else
      } // getUserID

      // Checks if user is an admin or not
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
      ?>
    </div>
  </div>
</div>
<footer style="position: fixed; bottom: 10px; width: 100%; height: 15px;">
  <span style="float:right;font-size:12px;background-color:white;padding: 2.5px 5px 5px 5px">
    <a href="about.php">about</a> | created by <a href="http://aturner.co/">Alex Turner</a>, 2016
  </span>
</footer>
</body>
</html>
