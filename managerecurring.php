<!DOCTYPE html>
<html>
<head>
  <title>Recurring Bookings</title>
  <!--JQuery library-->
  <script src="jquery-2.1.4.min.js"></script>
  <!--CSS stylesheet-->
  <link rel='stylesheet' type='text/css' href='my-style.css'>
  <!--Google font-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <meta http-equiv="X-UA-Compatible" content="IE=11" />
  <script>
  $(document).ready(function(){
    $("#dismiss").click(function(){
      $("#log").hide();
    });
    $('#allrecurringbookings').hide();
    $('#showallbookings').click(function(){
      $('#allrecurringbookings').toggle();
      $('#currentrecurringbookings').toggle();
      if ($('#allrecurringbookings').is(':visible')){
        $('#showallbookings').html('Show Active');
      } else {
        $('#showallbookings').html('Show All')
      };
    });
  });
  </script>
</head>
<body>
<?php
  // Start a session
  session_start();
  $servername = $_SESSION['servername'];
  $username = $_SESSION['username'];
  $password  = $_SESSION['password'];
  $db_selected = $_SESSION['db_selected'];
  $conn = mysqli_connect($servername,$username,$password,$db_selected);
  $_SESSION["conn"] = $conn;
  $_SESSION["id"] = getUserID($conn,$username);
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
<div id="container">
  <div id="content">
    <?php
    // deletes a booking
    if (isset($_POST["deletebooking"])) {
      deleteRecurringBooking($conn,$_POST["deletebooking"]);
    }
    ?>
    <center>
    <h3>Your Recurring Bookings</h3>
    <p><button id="showallbookings">Show All</button></p>
    <table id="currentrecurringbookings">
      <th>Resource</th>
      <th>Day</th>
      <th>Period</th>
      <th>Every</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Delete</th>
      <?php
        writeTable($conn,false);
      ?>
    </table>
    <table id="allrecurringbookings">
      <th>Resource</th>
      <th>Day</th>
      <th>Period</th>
      <th>Every</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Delete</th>
      <?php
        writeTable($conn,true);
      ?>
    </table>
    <?php
    // Function to get a user's id from their username
    // used to insert records into tables
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
      } // if
    } // isAdmin
    // Function to delete a recurring booking
    // It also deletes the future bookings for the given resource
    function deleteRecurringBooking($conn,$inputstring) {
      echo "<p id='log'>";
      try {
        // input string is of form "bookingid,resource,bookedbyid"
        // so this needs to be exploded into its constituent parts
        $str_explode = explode(",",$inputstring);
        $bookingid = $str_explode[0];
        $resource = $str_explode[1];
        $bookedbyid = $str_explode[2];
        // first grabs information from recurringbookings record before deleting it
        $sqlGetBookings = "SELECT * FROM RecurringBookings
                           WHERE BookingID=$bookingid";
        $resultGetBookings = mysqli_query($conn,$sqlGetBookings);
        while ($row = mysqli_fetch_assoc($resultGetBookings)) {
          $startdate = $row["StartDate"];
          $enddate = $row["EndDate"];
          $recurday = $row["RecurDay"];
          $recurperiod = $row["RecurPeriod"];
          $isweekly = $row["isWeekly"];
          $isbiweekly = $row["isBiweekly"];
          // gets whether booking is multiple periods or not
          if ($row["isMultiplePeriods"] == 1) {
            $ismultipleperiods = true;
          } else {
            $ismultipleperiods = false;
          } // else
        } // while
        // creates sql statement to delete record from recurringbookings
        $sqlDeleteFromBookings = "DELETE FROM RecurringBookings
                                  WHERE BookingID=$bookingid";
        // deletes from recurringbookings
        $resultDeleteFromBookings = mysqli_query($conn,$sqlDeleteFromBookings);
        if (!$resultGetBookings) {
          throw new Exception("Error deleting record from recurring bookings table<br>");
        } // if
        // sets today date
        $today = date("Ymd");
        // initialise current date
        $currentdate = $today;
        // create counter for number of records deleted
        $counter = 0;
        // Loops through each day between now and end date
        while (strtotime($currentdate) <= strtotime($enddate)) {
          // If booking is multiple periods
          if ($ismultipleperiods) {
            $periodsselected = [];
            // Creates an array of all selected periods
            for ($i = 0; $i < strlen($recurperiod); $i++) {
              array_push($periodsselected, $recurperiod[$i]);
            } // for
            // now deletes each period one by one using array
            foreach ($periodsselected as $p) {
              // if current day is the correct day
              if ((findDayFromDate($currentdate)) == $recurday) {
                $sqlSelectRecordByDate = "SELECT * FROM $resource
                                          WHERE BookingDate=$currentdate
                                          AND BookedByID=$bookedbyid
                                          AND BookingPeriod=$p";
                $resultSelectRecordByDate = mysqli_query($conn,$sqlSelectRecordByDate);
                // if this query returns a record
                if (mysqli_num_rows($resultSelectRecordByDate) > 0) {
                  // delete it
                  $sqlDeleteRecordByDate = "DELETE FROM $resource
                                            WHERE BookingDate=$currentdate
                                            AND BookedByID=$bookedbyid
                                            AND BookingPeriod=$p";
                  $resultDeleteRecordByDate = mysqli_query($conn,$sqlDeleteRecordByDate);
                  if (!$resultDeleteRecordByDate) {
                    echo "Problem deleting record on date $currentdate<br>" . mysqli_error($conn) . "<br>";
                  } // if
                  else {
                    $counter++;
                  } // else
                } // if
              } // if
            } // foreach
          } // if
          else {
            // if current day is the correct day
            if ((findDayFromDate($currentdate)) == $recurday) {
              $sqlSelectRecordByDate = "SELECT * FROM $resource
                                        WHERE BookingDate=$currentdate
                                        AND BookedByID=$bookedbyid
                                        AND BookingPeriod=$recurperiod";
              $resultSelectRecordByDate = mysqli_query($conn,$sqlSelectRecordByDate);
              // if this query returns a record
              if (mysqli_num_rows($resultSelectRecordByDate) > 0) {
                // delete it
                $sqlDeleteRecordByDate = "DELETE FROM $resource
                                          WHERE BookingDate=$currentdate
                                          AND BookedByID=$bookedbyid
                                          AND BookingPeriod=$recurperiod";
                $resultDeleteRecordByDate = mysqli_query($conn,$sqlDeleteRecordByDate);
                if (!$resultDeleteRecordByDate) {
                  echo "Problem deleting record on date $currentdate<br>" . mysqli_error($conn) . "<br>";
                } // if
              } // if
            } // if
          } // else
          // increment current date
          $currentdate = strtotime("+1 day", strtotime($currentdate));
          $currentdate = date("Ymd", $currentdate);
        } // while
        if ($counter > 1) {
          echo "Deleted " . $counter . " bookings<br>";
        } else {
          echo "Deleted " . $counter . "booking<br>";
        } // else
      } // try
      catch (Exception $e) {
        echo "<b>An error occured:</b><br>";
        echo $e->getMessage();
      } // catch
      finally {
        echo "<br><button id='dismiss'>Dismiss</button>";
        echo "</p>";
      } // finally
    } // deleteRecurringBooking
    // function to get the number of the maximum periods in a day
    // since rooms have 8, vehicles have 8, it equipment have 6
    // used when booking whole days in the recurring booking
    function getMaxPeriods($type) {
      // possibilities are vehicle, period, or time
      switch($type) {
        case "period": return 6; break;
        case "vehicle": return 8; break;
        case "time": return 8; break;
      } // switch
    }  // getMaxPeriods
    // Function to get the type of resource this is
    // either as period, time, or vehicle
    function getResourceType($resource) {
      switch($resource) {
        case "minibusjbx":
        case "minibusjha":
        case "minibuslle":
        case "minibusyhj":
        case "testvehicle":
          return "vehicle";
          break;
        case "ipadtrolleyblack":
        case "ipadtrolleygrey":
        case "laptoptrolley":
        case "slt_grouptherapy":
        case "slt_individualtherapy":
        case "slt_signalong":
        case "testresource":
          return "period";
          break;
        default:
          return "time";
          break;
      } // switch
    } // getType
    // Function to write a styled period
    // So that vehicles have break and lunch,
    // and time based have hh:mm - hh:mm strings
    function stylePeriod($period,$type) {
      if (strlen($period) > 1) {
        // Expand to include a dialog box containing all periods?
        // Because might get messy, especially for a time-based booking
        // Where each period is '9:00 - 10:00'...
        return "Multiple";
      }
      elseif ($type == "period") {
        if ($period == 0) {
          return "All day";
        } else {
          return $period; 
        } // else
      } // if
      elseif ($type == "vehicle") {
        switch($period) {
          // accounts for break and lunch
          case 0: return "All day"; break;
          case 1: return 1; break;
          case 2: return 2; break;
          case 3: return "Break"; break;
          case 4: return 3; break;
          case 5: return 4; break;
          case 6: return "Lunch"; break;
          case 7: return 5; break;
          case 8: return 6; break;
        } // switch
      } // elseif
      // else is time-based
      else {
        switch($period) {
          case 0: return "All day"; break;
          case 1: return "9:00 - 10:00"; break;
          case 2: return "10:00 - 11:00"; break;
          case 3: return "11:00 - 12:00"; break;
          case 4: return "12:00 - 13:00"; break;
          case 5: return "13:00 - 14:00"; break;
          case 6: return "14:00 - 15:00"; break;
          case 7: return "15:00 - 16:00"; break;
          case 8: return "16:00 - 17:00"; break;
        } // switch
      } // else
    } // stylePeriod
    // Function to determine what day of the week a given date is
    function findDayFromDate($date) {
      $day = date("D",strtotime($date));
      return $day;
    } // function findDayFromDate
    // Function to list all the recurring bookings that the user has made
    // boolean parameter to determine whether to show all bookings (or only active)
    function writeTable($conn,$showall) {
      $id = $_SESSION["id"];
      $sqlGetBookings = "SELECT * FROM RecurringBookings
                         WHERE BookedByID=$id";
      $resultGetBookings = mysqli_query($conn,$sqlGetBookings);
      $today = date('Ymd');
      while ($row = mysqli_fetch_assoc($resultGetBookings)) {
        // if we want to show all bookings
        // or today's date is less than the end date of the booking
        if ($showall == true || strtotime($today) <= strtotime($row["EndDate"])) {
          echo "<tr>";
          echo "<td>". styleResource($row["Resource"]) ."</td>";
          echo "<td>". styleDay($row["RecurDay"]) ."</td>";
          echo "<td>". stylePeriod($row["RecurPeriod"],getResourceType($row["Resource"])) ."</td>";
          echo "<td>";
          if ($row["isWeekly"] == 1) {
            echo "Week";
          } else {
            echo "Fortnight";
          }
          echo "</td>";
          echo "<td>". styleDate($row["StartDate"]) ."</td>";
          echo "<td>". styleDate($row["EndDate"]) ."</td>";

        ?>
        <td>
          <form method="POST" action="managerecurring.php">
          <!--Has a confirm box to make sure user can cancel action-->
          <button type="submit" id="deletebooking" name="deletebooking"
                  onclick="return confirm('Are you sure you want to delete this recurring record? \nThat includes ALL future bookings related to this recurrence!');"
                  value=<?php echo "'".$row["BookingID"] .",". $row["Resource"] .",". $row["BookedByID"]."'";?>>Delete</button>
          </form>
        </td>
        <?php
        } // if
      } // while
    } // writeTable
    // Function to style date
    // Converts 3 letter date into full date
    // i.e. "Mon" -> "Monday"
    function styleDay($daystring) {
      switch($daystring) {
        case "Mon":       return "Monday"; break;
        case "Tue":       return "Tuesday"; break;
        case "Wed":       return "Wednesday"; break;
        case "Thu":       return "Thursday"; break;
        case "Fri":       return "Friday"; break;
        case "Sat":       return "Saturday"; break;
        case "Sun":       return "Sunday"; break;
        default:          return $daystring; break;
      } // switch
    } // styleDay
    // Function to write the table string
    // So that table names become their string equivalent
    // so "slt_grouptherapy" -> "Group Therapy"
    function styleResource($resourcestring) {
      switch($resourcestring) {
        case "laptoptrolley": return "Laptop Trolley" ; break;
        case "ipadtrolleyblack": return "iPad Trolley (Black)" ; break;
        case "ipadtrolleygrey": return "iPad Trolley (Grey)" ; break;
        case "conferenceroom": return "Conference Room" ; break;
        case "meetingroom": return "Meeting Room" ; break;
        case "minibusjbx": return "Minibus JBX" ; break;
        case "minibusjha": return "Minibus JHA" ; break;
        case "minibuslle": return "Minibus LLE" ; break;
        case "minibusyhj": return "Minibus YHJ" ; break;
        case "slt_grouptherapy" : return "Group Therapy" ; break;
        case "slt_individualtherapy" : return "Individual Therapy" ; break;
        case "slt_signalong" : return "Signalong" ; break;
        case "slt_ace" : return "ACE" ; break;
        case "slt_dls" : return "DLS" ; break;
        case "slt_celf4" : return "CELF 4" ; break;
        case "slt_rlsbst" : return "RLS BST" ; break; 
        case "slt_rlsapt" : return "RLS APT" ; break; 
        case "slt_rlswfvt" : return "RLS WFVT" ; break;
        case "slt_clear" : return "CLEAR" ; break;
        case "slt_celf3" : return "CELF 3" ; break;
        case "slt_towk" : return "TOWK" ; break;
        case "slt_clip" : return "CLIP" ; break;
        case "slt_stass" : return "STASS" ; break;
        case "slt_stap" : return "STAP" ; break;
        case "slt_acap" : return "ACAP" ; break;
        case "slt_screener" : return "Phonology Screener" ; break;
        case "slt_ndp" : return "NDP" ; break;
        case "slt_talc1" : return "TALC 1" ; break;
        case "slt_talc2" : return "TALC 2" ; break;
        case "testresource": return "Test Resource"; break;
        case "testroom": return "Test Room"; break;
        case "testvehicle": return "Test Vehicle"; break;
        default: return $resourcestring; break;    
      } // switch
    } // styleResource
    // Function to style date in the most user-friendly way
    // DD-MM-YYYY, as opposed to YYYY-MM-DD
    function styleDate($date) {
      return date("d-m-Y", strtotime($date));
    } // styleDate
    ?>
    </center>
  </div>
</div>
<footer style="position: fixed; bottom: 10px; width: 100%; height: 15px;">
  <span style="float:right;font-size:12px;background-color:white;padding: 2.5px 5px 5px 5px">
    <a href="about.php">about</a> | created by <a href="http://aturner.co/">Alex Turner</a>, 2016
  </span>
</footer>
</body>
</html>