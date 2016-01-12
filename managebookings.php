<!DOCTYPE html>
<html>
<head>
  <title>Manage Bookings</title>
  <!--CSS stylesheet-->
  <link rel='stylesheet' type='text/css' href='my-style.css'>
  <!--JQuery library-->
  <script src="jquery-2.1.4.min.js"></script>
  <!--Google font-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <script type="text/javascript">
  $(document).ready(function(){
    $('#allbookings').hide();
    $('#showallbookings').click(function(){
      $('#allbookings').toggle();
      $('#currentbookings').toggle();
      if ($('#allbookings').is(':visible')){
        $('#showallbookings').html('Show Current Bookings');
      } else {
        $('#showallbookings').html('Show All Bookings')
      };
    });
    $("#dismiss").click(function(){
      $("#deletebookinglog").hide();
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
$table = "conferenceroom";
$_SESSION["currenttable"] = $table;
// Establish connection to db
$conn = mysqli_connect($servername,$username,$password,$db_selected);
$_SESSION['conn'] = $conn;
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
            <li><a href="/all_vehicles.php>">All Vehicles</a></li>
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
      <center>
      <h3>Your Bookings</h3>
      <p><button id="showallbookings">Show All Bookings</button></p>
      <?php
        // Checks if a booking has been deleted through POST
        if (isset($_POST['deletebooking'])) {
          deleteBooking($_POST['deletebooking']);
        }
        // Get user ID from Names
        $id = getUserID($conn,$username);
        // Write a table to contain bookings
        // Here we are writing TWO separate tables,
        // one for all bookings for current user, and one for only current bookings
        // i.e. do not include bookings in the past. Relies on JQuery to show/hide each 
        ?>
        <table id="allbookings">
          <th>Description</th>
          <th>Booking Date</th>
          <th>Booking Period</th>
          <th>Resource</th>
          <th>Delete?</th>
          <?php 
          writeBookingsForTable(true,$conn,$id,'ipadtrolleyblack', 'iPad Trolley (Black)');
          writeBookingsForTable(true,$conn,$id,'ipadtrolleygrey', 'iPad Trolley (Grey)');
          writeBookingsForTable(true,$conn,$id,'laptoptrolley', 'Laptop Trolley');
          writeBookingsForTable(true,$conn,$id,'conferenceroom', 'Conference Room');
          writeBookingsForTable(true,$conn,$id,'meetingroom', 'Meeting Room');
          writeBookingsForTable(true,$conn,$id,'minibusjbx', 'Minibus JBX');
          writeBookingsForTable(true,$conn,$id,'minibusjha', 'Minibus JHA');
          writeBookingsForTable(true,$conn,$id,'minibuslle', 'Minibus LLE');
          writeBookingsForTable(true,$conn,$id,'minibusyhj', 'Minibus YHJ');

          writeBookingsForTable(true,$conn,$id,'slt_grouptherapy', 'Group Therapy');
          writeBookingsForTable(true,$conn,$id,'slt_individualtherapy', 'Individual Therapy');
          writeBookingsForTable(true,$conn,$id,'slt_signalong', 'Signalong');
          writeBookingsForTable(true,$conn,$id,'slt_ace', 'ACE');
          writeBookingsForTable(true,$conn,$id,'slt_dls', 'DLS');
          writeBookingsForTable(true,$conn,$id,'slt_celf4', 'CELF 4');
          writeBookingsForTable(true,$conn,$id,'slt_rlsbst', 'RLS BST');
          writeBookingsForTable(true,$conn,$id,'slt_rlsapt', 'RLS APT');
          writeBookingsForTable(true,$conn,$id,'slt_rlswfvt', 'RLS WFVT');
          writeBookingsForTable(true,$conn,$id,'slt_clear', 'CLEAR');
          writeBookingsForTable(true,$conn,$id,'slt_celf3', 'CELF 3');
          writeBookingsForTable(true,$conn,$id,'slt_towk', 'TOWK');
          writeBookingsForTable(true,$conn,$id,'slt_clip', 'CLIP');
          writeBookingsForTable(true,$conn,$id,'slt_stass', 'STASS');
          writeBookingsForTable(true,$conn,$id,'slt_stap', 'STAP');
          writeBookingsForTable(true,$conn,$id,'slt_acap', 'ACAP');
          writeBookingsForTable(true,$conn,$id,'slt_screener', 'Phonology Screener');
          writeBookingsForTable(true,$conn,$id,'slt_ndp', 'NDP');
          writeBookingsForTable(true,$conn,$id,'slt_talc1', 'TALC 1');
          writeBookingsForTable(true,$conn,$id,'slt_talc2', 'TALC 2');

          writeBookingsForTable(true,$conn,$id,'testresource', 'Test Resource');
          writeBookingsForTable(true,$conn,$id,'testroom', 'Test Room');
          writeBookingsForTable(true,$conn,$id,'testvehicle', 'Test Vehicle');
          ?>
        </table>
        <table id="currentbookings">
          <th>Description</th>
          <th>Booking Date</th>
          <th>Booking Period</th>
          <th>Resource</th>
          <th>Delete?</th>
          <?php 
          writeBookingsForTable(false,$conn,$id,'ipadtrolleyblack', 'iPad Trolley (Black)');
          writeBookingsForTable(false,$conn,$id,'ipadtrolleygrey', 'iPad Trolley (Grey)');
          writeBookingsForTable(false,$conn,$id,'laptoptrolley', 'Laptop Trolley');
          writeBookingsForTable(false,$conn,$id,'conferenceroom', 'Conference Room');
          writeBookingsForTable(false,$conn,$id,'meetingroom', 'Meeting Room');
          writeBookingsForTable(false,$conn,$id,'minibusjbx', 'Minibus JBX');
          writeBookingsForTable(false,$conn,$id,'minibusjha', 'Minibus JHA');
          writeBookingsForTable(false,$conn,$id,'minibuslle', 'Minibus LLE');
          writeBookingsForTable(false,$conn,$id,'minibusyhj', 'Minibus YHJ');

          writeBookingsForTable(false,$conn,$id,'slt_grouptherapy', 'Group Therapy');
          writeBookingsForTable(false,$conn,$id,'slt_individualtherapy', 'Individual Therapy');
          writeBookingsForTable(false,$conn,$id,'slt_signalong', 'Signalong');
          writeBookingsForTable(false,$conn,$id,'slt_ace', 'ACE');
          writeBookingsForTable(false,$conn,$id,'slt_dls', 'DLS');
          writeBookingsForTable(false,$conn,$id,'slt_celf4', 'CELF 4');
          writeBookingsForTable(false,$conn,$id,'slt_rlsbst', 'RLS BST');
          writeBookingsForTable(false,$conn,$id,'slt_rlsapt', 'RLS APT');
          writeBookingsForTable(false,$conn,$id,'slt_rlswfvt', 'RLS WFVT');
          writeBookingsForTable(false,$conn,$id,'slt_clear', 'CLEAR');
          writeBookingsForTable(false,$conn,$id,'slt_celf3', 'CELF 3');
          writeBookingsForTable(false,$conn,$id,'slt_towk', 'TOWK');
          writeBookingsForTable(false,$conn,$id,'slt_clip', 'CLIP');
          writeBookingsForTable(false,$conn,$id,'slt_stass', 'STASS');
          writeBookingsForTable(false,$conn,$id,'slt_stap', 'STAP');
          writeBookingsForTable(false,$conn,$id,'slt_acap', 'ACAP');
          writeBookingsForTable(false,$conn,$id,'slt_screener', 'Phonology Screener');
          writeBookingsForTable(false,$conn,$id,'slt_ndp', 'NDP');
          writeBookingsForTable(false,$conn,$id,'slt_talc1', 'TALC 1');
          writeBookingsForTable(false,$conn,$id,'slt_talc2', 'TALC 2');

          writeBookingsForTable(false,$conn,$id,'testresource', 'Test Resource');
          writeBookingsForTable(false,$conn,$id,'testroom', 'Test Room');
          writeBookingsForTable(false,$conn,$id,'testvehicle', 'Test Vehicle');
          ?>
        </table>
        <?php
        // write bookings for laptoptrolley
        // Show bookings for given ID across all booking tables

        // Function to write the bookings of a particular person
        // Given the connection, person's ID, and table name
        // Tablestring holds what should be written as a string in the table
        // Reused to create a table to show only current bookings using $includepast
        function writeBookingsForTable($includepast,$conn, $id, $table, $tablestring) {
          $sqlGetBookings = "SELECT BookingID,BookingDate,BookingPeriod,BookingDesc FROM $table
                             WHERE BookedByID=$id ORDER BY bookingdate DESC, bookingperiod ASC";
          $resultGetBookings = mysqli_query($conn,$sqlGetBookings);
          while($row = mysqli_fetch_assoc($resultGetBookings)) {
            // If includepast=true, i.e. write ALL bookings, past and current
            if ($includepast) {
              echo "<tr>";
              echo "<td>". $row["BookingDesc"] ."</td>";
              echo "<td>". $row["BookingDate"] ."</td>";
              echo "<td>". stylePeriod($row["BookingPeriod"],getResourceType($table)) ."</td>";
              echo "<td>$tablestring</td>";
              ?>
              <td>
                <form method="POST" action="managebookings.php">
                <!--Has a confirm box to make sure user can cancel action-->
                <button type="submit" id="deletebooking" name="deletebooking" onclick="return confirm('Are you sure you want to delete this record?');" value=<?php echo "'".$row["BookingID"].",".$table."'";?>>Delete</button>
                </form>
              </td>
              <?php
              echo "</tr>";
            }
            // Else only prints current bookings 
            else {
              // If booking date is not in the past, print row
              if (!checkIfInThePast($row["BookingDate"])) {
                echo "<tr>";
                echo "<td>". $row["BookingDesc"] ."</td>";
                echo "<td>". styleDate($row["BookingDate"]) ."</td>";
                echo "<td>". stylePeriod($row["BookingPeriod"],getResourceType($table)) ."</td>";
                echo "<td>$tablestring</td>";
                ?>
                <td>
                  <form method="POST" action="managebookings.php">
                  <!--Has a confirm box to make sure user can cancel action-->
                  <button type="submit" id="deletebooking" name="deletebooking" onclick="return confirm('Are you sure you want to delete this record?');" value=<?php echo "'".$row["BookingID"].",".$table."'";?>>Delete</button>
                  </form>
                </td>
                <?php
                echo "</tr>";
              } // if
            } // else
          } // while
        } // writeBookingsForTable

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
        // Checks if given date is in the past
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
          if ($type == "period") {
            return $period;
          } // if
          elseif ($type == "vehicle") {
            switch($period) {
              // accounts for break and lunch
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
            case "testvehicle" : return "Test Vehicle"; break;
            case "testresource" : return "Test Resource"; break;
            case "testroom" : return "Test Room"; break;
            default: return $resourcestring; break;     
          } // switch
        } // styleResource
        // Function to style date in the most user-friendly way
        // DD-MM-YYYY, as opposed to YYYY-MM-DD
        function styleDate($date) {
          return date("d-m-Y", strtotime($date));
        } // styleDate
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