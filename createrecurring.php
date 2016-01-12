<!DOCTYPE html>
<?php
// Start a session
session_start();
?>
<html>
<head>
  <title>Recurring Booking</title>
  <!--JQuery library-->
  <script src="jquery-2.1.4.min.js"></script>
  <!--CSS stylesheet-->
  <link rel='stylesheet' type='text/css' href='my-style.css'>
  <link href="jquery-ui/jquery-ui.css" rel="stylesheet" />
  <!--Google font-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <meta http-equiv="X-UA-Compatible" content="IE=11" />
  <script>
  $(document).ready(function(){
    // store all select options for a period
    // creates an array of all the period options
    var options = { 'period1' : 'Period 1',
                    'period2' : 'Period 2',
                    'break' : 'Break',
                    'period3' : 'Period 3',
                    'period4' : 'Period 4',
                    'lunch' : 'Lunch',
                    'period5' : 'Period 5',
                    'period6' : 'Period 6',
                    't9to10' : '9:00 to 10:00',
                    't10to11' : '10:00 to 11:00',
                    't11to12' : '11:00 to 12:00',
                    't12to13' : '12:00 to 13:00',
                    't13to14' : '13:00 to 14:00',
                    't14to15' : '14:00 to 15:00',
                    't15to16' : '15:00 to 16:00',
                    't16to17' : '16:00 to 17:00'
                  };
    $("input[name=frequency]").change(function(){
      var selValue = $('input[name=frequency]:checked').val();
      if (selValue == "biweekly") {
        $("#biweeklynote").show();
      } // if
    });
    $("#dismiss").click(function(){
      $("#log").hide();
    });
    $("#selectresource").change(function(){
      // completely empty period list
      $('#createrecurring label').each(function(){
        $(this).remove();
      });
      // append each element from array to selectperiod list
      $.each(options, function(value,text){
        // variable to hold label
        var $label = $("<label>");
        $label.attr({for: value});
        //$label.append("<br>");
        // variable to hold input
        // sets attributes
        var $input = $('<input type="checkbox">').attr({
          class: "selectperiod",
          name: value
        });
        // insert input into label
        $input.appendTo($label);
        // append text of checkbox
        $label.append(text);
        // append break
        $("<br>").appendTo($label);
        // append this whole label into div containing all checkboxes
        $("#periodcheckboxes").append($label);
      }); // each
      $("#selectresource option:selected").each(function(){
        // gets value of selected option
        var inputstring = $(this).val();
        // splits using comma as delimiter
        var splitstring = inputstring.split(",");
        // sets type as the type given in string (period/time/vehicle)
        var type = splitstring[0];
        // for each option in the period options
        $("#createrecurring label").each(function(){
          // gets value of label
          var val = $(this).attr('for');
          // gets first character of option
          var firstchar = val.substr(0,1);
          // if type is period
          if (type == "period" || type == "") {
            if (firstchar != 'p') {
              // if first character is not p
              // i.e. option is not 'period x'
              // remove it from the option list
              $(this).remove();  
            } // if
          } // if
          if (type == "vehicle") {
            // if first character is t
            // so remove every option that is a time
            // and leave period 1, ... , break , ... , lunch , ...
            if (firstchar == 't') {
              $(this).remove();
            } // if
          } // if
          if (type == "time") {
            // if first character is not t
            // so remove everything except times
            if (firstchar != 't') {
              $(this).remove();
            } // if
          } // if
        }); // for each
        str += type; 
      }); // each
    }) // change
    .trigger("change");
  }); // ready
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
    <center>
    <?php
    if (isset($_POST["submitbooking"])) {
      // creates a recurring booking
      createRecurringBooking($conn,$username);
    } // if
    // Function to create a recurring booking
    function createRecurringBooking($conn,$username) {
      try {
        echo "<p id='log'>";
        echo "Creating recurring booking...<br>";
        // Sets all variables from the form POST
        // set table, throw error if empty
        // The value provided is now of format
        // 'type,table', so we need to explode this to find table name
        $tablestring = $_POST["selectresource"];
        if (!$tablestring) {
          throw new Exception("Table cannot be empty<br>");
        } // if
        // explodes string using comma as delimiter
        $str_explode = explode(",",$tablestring);
        // table is second element in array
        $table = $str_explode[1];
        // table type is first element
        $type = $str_explode[0];
        // set and check day
        $inputday = $_POST["selectday"];
        if (!$inputday) {
          throw new Exception("Day cannot be empty<br>");
        } // if
        // format day into 3 characters, and capitalise first char
        // so 'monday' -> 'Mon', for comparisons later
        $day = ucfirst(substr($inputday,0,3));
        // Set and check periods
        // Since multiple periods may be selected, an array of available options is created
        $periodoptions = array("period1", "period2", "period3", "period4",
                               "period5", "period6", "break", "lunch", "t9to10",
                               "t10to11", "t11to12", "t12to13", "t13to14",
                               "t14to15", "t15to16", "t16to17");
        // Foreach element in array
        // We check if the checkbox associated with it has been checked
        // If so, we push it to our new empty array called periodsselected
        $periodsselected = [];
        foreach ($periodoptions as $p) {
          if(isset($_POST[$p])) {
            array_push($periodsselected, $p);
          } // if
        } // foreach
        // Now we know what checkboxes have been selected
        // Set description, does not check because description is allowed to be blank
        $description = addslashes($_POST["description"]);
        // If not booking whole day
        // type is set as either period/time/vehicle
        // each has their method of getting the numerical value of the period
        // for period based resources
        // Another array which will be used to store numerical values of
        // periods selected, e.g. [1, 3, 7]
        $periodsnumerical = [];
        foreach ($periodsselected as $p) {
          if ($type == "period") {
            // casts last character as an int, to get numerical value of 'n'
            $p = (int)substr($p, -1);         
          } // if
          // for vehicle based resources
          elseif ($type == "vehicle") {
            // use a switch to translate string to numerical value
            switch($p) {
              case "period1": $p = 1; break;
              case "period2": $p = 2; break;
              case "break":    $p = 3; break;
              case "period3": $p = 4; break;
              case "period4": $p = 5; break;
              case "lunch":    $p = 6; break;
              case "period5": $p = 7; break;
              case "period6": $p = 8; break;
              default:         $p = 1; break;
            } // switch
          } // elseif
          // for time based bookings
          elseif ($type == "time") {
            // use a switch to translate
            switch($p) {
              case "t9to10":  $p = 1; break;
              case "t10to11": $p = 2; break;
              case "t11to12": $p = 3; break;
              case "t12to13": $p = 4; break;
              case "t13to14": $p = 5; break;
              case "t14to15": $p = 6; break;
              case "t15to16": $p = 7; break;
              case "t16to17": $p = 8; break;
              default:        $p = 1; break;
            } // switch
          } // elseif
          else {
            throw new Exception("Problem with the resource type<br>");
          } // else
          // Pushes period to numerical array
          array_push($periodsnumerical, $p);
        } // foreach
        if (empty($periodsnumerical)) {
          throw new Exception("Period cannot be empty<br>");
        } // if
        //echo "Period(s):" . implode(", ",$periodsnumerical) . "<br>";
        // set frequency and check
        if (!isset($_POST["frequency"])) {
          throw new Exception ("Frequency cannot be empty<br>");
        }
        $frequency = $_POST["frequency"];
        if (!$frequency) {
          throw new Exception("Frequency cannot be empty<br>");
        } // if
        // set start date
        $startdate = $_POST["startdate"];
        if (!$startdate) {
          throw new Exception("Start date cannot be empty<br>");
        } // if
        // checks if the start date given is in the past
        if(checkIfInThePast($startdate)) {
          throw new Exception("Start date cannot be in the past<br>");
        } // if
        // set end date
        $enddate = $_POST["enddate"];
        if (!$enddate) {
          throw new Exception("End date cannot be empty<br>");
        } // if
        // checks if end date is in the past
        if(checkIfInThePast($enddate)) {
          throw new Exception("End date cannot be in the past<br>");
        } // if
        // checks that end date is after start date
        if(strtotime($enddate) < strtotime($startdate)) {
          throw new Exception("End date should be after start date<br>");
        } // if
        // Simple input validation is now complete
        // Now loop through each day, and try to book
        // each day/period for the table given
        // If already booked, report a warning
        // initialise currentdate to use
        // formats to YYYYMMDD
        if ($frequency == "biweekly") {
          // sets a boolean to say if booking is biweekly or not
          $isbiweekly = true;
          $isweekly = false;
        } else {
          $isbiweekly = false;
          $isweekly = true;
        }
        // reformat start and end dates
        $startdate = date("Ymd",strtotime($startdate));
        $enddate = date("Ymd",strtotime($enddate));
        $weekcount = 0;
        $currentdate = $startdate;
        $fullname = getFullname($conn,$username);
        $id = getID($conn,$username);
        // while current date is less than end date
        while (strtotime($currentdate) <= strtotime($enddate)) {
          // if current date is equal to date required
          if ((findDayFromDate($currentdate)) == $day) {
            // increment weekcount every time a booking is made
            $weekcount++;
            // if not biweekly, or is biweekly and this is an odd week
            // so that biweekly bookings occur 1st week, 3rd week, ...
            // loops through each period in the day and books it
            // Foreach period in numerical list
            foreach ($periodsnumerical as $pd) {
              if (!$isbiweekly || ($isbiweekly && ($weekcount % 2 != 0))) {
                $sqlCheck = "SELECT * FROM $table
                             WHERE BookingDate=$currentdate AND BookingPeriod=$pd";
                $resultCheck = mysqli_query($conn,$sqlCheck);
                if (mysqli_num_rows($resultCheck) > 0) {
                  echo "Warning: Record already exists for period $pd on" . styleDate($currentdate) . "<br>";
                  echo "Did not add record<br>";
                } // if
                else {
                  $id = $_SESSION["id"];
                  $fullname = $_SESSION["fullname"];
                  $sqlInsert = "INSERT INTO $table
                                (BookingDate,BookedByID,BookedByName,BookingPeriod,BookingDesc)
                                VALUES
                                ($currentdate,$id,'$fullname',$pd,'$description')";
                  $resultInsert = mysqli_query($conn,$sqlInsert);
                  if ($resultInsert) {
                  } else {
                    echo "Error adding record: " . mysqli_error($conn) . "<br>";
                  } // else
                } // else
              } // if
            } // foreach
          } // if
          // increment current date
          $currentdate = strtotime("+1 day", strtotime($currentdate));
          $currentdate = date("Ymd", $currentdate);
        } // while
        if ($isweekly) {
          $isweeklyval = 1;
          $isbiweeklyval = 0;
        } else {
          $isweeklyval = 0;
          $isbiweeklyval = 1;
        } // else
        // sets is multipleperiods
        if (count($periodsnumerical) > 1) {
          $ismultipleperiods = 1;
        } else {
          $ismultipleperiods = 0;
        } // else
        // If multiple periods, changes the recurperiod variable so that it is used
        // to store which days are recurred
        // So sets recur period to 135 if recurring occurs on periods 1,3, and 5
        if ($ismultipleperiods) {
          $period = implode("", $periodsnumerical);
        } else {
          $period = $periodsnumerical[0];
        } // else
        $sqlInsertRecur = "INSERT INTO RecurringBookings
                           (Resource,StartDate,EndDate,BookedByID,BookedByName,RecurDay,
                            RecurPeriod,isWeekly,isBiWeekly,isMultiplePeriods)
                           VALUES
                           ('$table',$startdate,$enddate,$id,'$fullname','$day',$period,
                            $isweeklyval,$isbiweeklyval,$ismultipleperiods)";
        $resultInsertRecur = mysqli_query($conn,$sqlInsertRecur);
        if (!$resultInsertRecur) {
          echo "Error adding record to recurring bookings table:"  . mysqli_error($conn) . "<br>";
        } else {
          echo "<b>Successfully added a recurring booking</b><br>";
          echo "Resource: " . styleResource($table,$type) . "<br>";
          echo "Day: " . getFullDay($day) .  "<br>";
          // Account for multiple periods
          if (strlen($period) > 1) {
            echo "Periods: ";
          } // if
          else {
            echo "Period: ";
          } // else
          echo stylePeriod($period,$type) . "<br>";
          if ($isweekly) {
            echo "Every week<br>";
          } else {
            echo "Every fortnight<br>";
          } // else
          echo "Between " . styleDateWithYears($startdate) . " and " . styleDateWithYears($enddate) . "<br>";
          echo "Description: " . stripslashes($description) . "<br>";
        }
      } // try
      catch (Exception $e){
        echo "<b><br>An error occured:</b><br>";
        echo $e->getMessage();
      } // catch
      finally {
        echo "<br><button id='dismiss'>Dismiss</button>";
        echo "</p>";
      } // finally
    } // function createRecurringBooking
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
    function getFullname($conn, $username) {
      $sqlGetFullname = "SELECT Fullname FROM Names
                   WHERE Username='$username'";
      $resultGetFullname = mysqli_query($conn,$sqlGetFullname);
      if (!$resultGetFullname)
      {
        echo "Problem finding user<br>";
      } else {
        $rowFullname = mysqli_fetch_row($resultGetFullname);
        $fullname = $rowFullname[0];
      }
      // set session variable for Fullname
      $_SESSION["fullname"] = $fullname;
      return $fullname;
    } // function getUsername
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
    // Function to determine what day of the week a given date is
    function findDayFromDate($date) {
      $day = date("D",strtotime($date));
      return $day;
    } // function findDayFromDate
    // Function to determine whether date given is a weekday or not
    function isWeekDay($date) {
      $day = findDayFromDate($date);
      switch($day) {
        // return false for saturday/sunday
        case "Sat":
        case "Sun":
          return false;
          break;
        // otherwise return true
        default:
          return true;
          break;
      } // switch
    } // function isWeekDay
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
    // Function to write a styled period
    // So that vehicles have break and lunch,
    // and time based have hh:mm - hh:mm strings
    function stylePeriod($period,$type) {
      // If length is given as a concatenated number
      // Loops through each character in string and calls self
      // using (some character,type)
      if (strlen($period) > 1) {
        // Initalise result
        $result = "";
        // For each character in string
        for ($i = 0; $i < strlen($period); $i++) {
          // Sets char as char in given position
          $thisint = (int)substr($period, $i, 1);
          // Append to result using output of function for each character
          $result .= stylePeriod($thisint,$type);
          // If not last item, print comma + space
          if ($i != (strlen($period) - 1)) {
            $result .= ", ";
          } // if
        } // for
        return $result;
      } // if
      else {
        if ($type == "period") {
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
      } // else
    } // stylePeriod
    ?>
    <h3>Create a Recurring Booking</h3><br>
    <form action="/createrecurring.php" method="POST" id="createrecurring">
    <table class="nostyle" id="selectresourcetable">
      <tr class="selectresourcetable">
        <td class="nostyle">Select a resource: </td>
        <td class="nostyle">
        <select name="selectresource" id="selectresource">
          <option value="">- Select an option -</option>
          <option value="period,laptoptrolley">Laptop Trolley</option>
          <option value="period,ipadtrolleyblack">iPad Trolley (Black)</option>
          <option value="period,ipadtrolleygrey">iPad Trolley (Grey)</option>
          <option value="time,meetingroom">Meeting Room</option>
          <option value="time,conferenceroom">Conference Room</option>
          <option value="vehicle,minibusjbx">Minibus JBX</option>
          <option value="vehicle,minibusjha">Minibus JHA</option>
          <option value="vehicle,minibuslle">Minibus LLE</option>
          <option value="vehicle,minibusyhj">Minibus YHJ</option>
          <option value="">&nbsp;</option>
          <option value="">- Speech &amp; Language -</option>
          <option value="period,slt_grouptherapy">Group Therapy</option>
          <option value="period,slt_individualtherapy">Individual Therapy</option>
          <option value="period,slt_signalong">Signalong</option>
          <option value="time,slt_ace">ACE</option>
          <option value="time,slt_dls">DLS</option>
          <option value="time,slt_celf4">CELF 4</option>
          <option value="time,slt_rlsbst">RLS BST</option>
          <option value="time,slt_rlsapt">RLS APT</option>
          <option value="time,slt_rlswfvt">RLS WFVT</option>
          <option value="time,slt_clear">CLEAR</option>
          <option value="time,slt_celf3">CELF 3</option>
          <option value="time,slt_towk">TOWK</option>
          <option value="time,slt_clip">CLIP</option>
          <option value="time,slt_stass">STASS</option>
          <option value="time,slt_stap">STAP</option>
          <option value="time,slt_acap">ACAP</option>
          <option value="time,slt_screener">Phonology Screener</option>
          <option value="time,slt_ndp">NDP</option>
          <option value="time,slt_talc1">TALC 1</option>
          <option value="time,slt_talc2">TALC 2</option>
          <option value="">&nbsp;</option>
          <option value="">- Dev only -</option>
          <option value="period,testresource">Test Resource</option>
          <option value="vehicle,testvehicle">Test Vehicle</option>
          <option value="time,testroom">Test Room</option>
        </select>
        </td>
      </tr>
      <tr class="nostyle" id="selectstartday" style="">
        <td class="nostyle">Select a day</td>
        <td class="nostyle">
        <select name="selectday" id="selectday">
        <option value="">- Select -</option>
        <option value="monday">Monday</option>
        <option value="tuesday">Tuesday</option>
        <option value="wednesday">Wednesday</option>
        <option value="thursday">Thursday</option>
        <option value="friday">Friday</option>
        </select>
        </td>
      </tr>
      <tr>
        <td class="nostyle">Select period(s)</td>
        <td class="nostyle">
          <div id="periodcheckboxes">
            <label for="period1" id="period1"><input type="checkbox" class="selectperiod" name="period1"/>Period 1
            <br></label>
            <label for="period2" id="period2"><input type="checkbox" class="selectperiod" name="period2"/>Period 2
            <br></label>
            <label for="break" id="break"><input type="checkbox" class="selectperiod" name="break"/>Break
            <br></label>
            <label for="period3" id="period3"><input type="checkbox" class="selectperiod" name="period3"/>Period 3
            <br></label>
            <label for="period4" id="period4"><input type="checkbox" class="selectperiod" name="period4"/>Period 4
            <br></label>
            <label for="lunch" id="lunch"><input type="checkbox" class="selectperiod" name="lunch"/>Lunch
            <br></label>
            <label for="period5" id="period5"><input type="checkbox" class="selectperiod" name="period5"/>Period 5
            <br></label>
            <label for="period6" id="period6"><input type="checkbox" class="selectperiod" name="period6"/>Period 6
            <br></label>
            <label for="t9to10" id="t9to10"><input type="checkbox" class="selectperiod" name="t9to10"/>9:00 - 10:00
            <br></label>
            <label for="t10to11" id="t10to11" ><input type="checkbox" class="selectperiod" name="t10to11"/>10:00 - 11:00
            <br></label>
            <label for="t11to12" id="t11to12"><input type="checkbox" class="selectperiod" name="t11to12"/>11:00 - 12:00
            <br></label>
            <label for="t12to13" id="t12to13"><input type="checkbox" class="selectperiod" name="t12to13"/>12:00 - 13:00
            <br></label>
            <label for="t13to14" id="t13to14"><input type="checkbox" class="selectperiod" name="t13to14"/>13:00 - 14:00
            <br></label>
            <label for="t14to15" id="t14to15"><input type="checkbox" class="selectperiod" name="t14to15"/>14:00 - 15:00
            <br></label>
            <label for="t15to16" id="t15to16"><input type="checkbox" class="selectperiod" name="t15to16"/>15:00 - 16:00
            <br></label>
            <label for="t16to17" id="t16to17"><input type="checkbox" class="selectperiod" name="t16to17"/>16:00 - 17:00
            <br></label>
          </div>
        </td>
      </tr>
      <tr>
        <td class="nostyle">Select frequency</td>
        <td class="nostyle">
          <input type="radio" name="frequency" value="weekly" id="selectfrequency">Weekly<br>
          <input type="radio" name="frequency" value="biweekly" id="selectfrequency">Every 2 weeks<br>
          <p id="biweeklynote" style="display:none;font-size:12px">Note that biweekly bookings are made on every 1st, 3rd, 5th... week</p>
        </td>
      </tr>
      <tr>
        <td class="nostyle">Select start date</td>
        <td class="nostyle">
          <input type="date" name="startdate" id="selectstartdate" value="" />


        </td>
      </tr>
      <tr>
        <td class="nostyle">Select end date</td>
        <td class="nostyle">
          <input type="date" name="enddate" id="selectenddate" value="" />
          <script src="jquery-ui/jquery-ui.js"></script>
          <script>
              // Script for IE, to show a datepicker
              // using jquery
             (function() {
                var elem = document.createElement('input');
                elem.setAttribute('type', 'date');
                if ( elem.type === 'text' ) {
                   $('#selectstartdate').datepicker({
                    dateFormat:'dd-mm-yy'
                   }); 
                   $('#selectenddate').datepicker({
                    dateFormat:'dd-mm-yy'
                   });
                }
             })();
           
          </script>
        </td>
      </tr>
      <tr>
        <td class="nostyle">Enter a description</td>
        <td class="nostyle">
        <input type="text" name="description" id="description"/>
        </td>
      </tr>
      <tr>
        <td class="nostyle"></td>
        <td class="nostyle"><button type="submit" name="submitbooking" id="submitbooking">Submit</button>
      </tr>
    </table>
    </form>
    </center>
    <?php
    // Function to write the full version of a day
    // from an abbreviated version
    // so Mon becomes Monday
    function getFullDay($abbr) {
      switch ($abbr) {
        case 'Mon': return 'Monday'; break;
        case 'Tue': return 'Tuesday'; break;
        case 'Wed': return 'Wednesday'; break;
        case 'Thu': return 'Thursday'; break;
        case 'Fri': return 'Friday'; break;
        default: return $abbr; break;
      } // switch
    } // function getFullDay
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
    } // isAdmin
    // Checks if currentweek button has been pressed
    // to call setToCurrentWeek function
    if (isset($_POST["currentweek"])) {
      setToCurrentWeek();
      writeTable($conn,$_SESSION["table"]);
    } // if
    // Checks if next week button has been pressed
    elseif (isset($_POST["nextweek"])) {
      setToNextWeek($_POST["nextweek"]);
      writeTable($conn,$_SESSION["table"]);    
    } // if
    // Checks if previous week button has been pressed
    elseif (isset($_POST["prevweek"])) {
      setToPreviousWeek($_POST["prevweek"]);
      writeTable($conn,$_SESSION["table"]);
    } // elseif
    // Function to set all the date variables, including mondate
    // which is used to calculate all other dates around it
    function setDates() {
      // Set up inital date
      $todaydate = date('Ymd');
      $_SESSION["todaydate"] = $todaydate;
      // Sets mondate, and session variable for mondate
      $mondate = findMonDate($todaydate);
      $_SESSION["mondate"] = $mondate;
    } // function setDates
    // Finds the date of Monday of a week
    // Given some date within that week
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
    // Function to output a date in format
    // "DD/MM/YY", given a date, in format YYYYMMDD
    function styleDateWithYears($date) {
      // Check date string is right length
      if (strlen($date) == 8) {
        // First 4 digits -> year
        $year = substr($date, 0, 4);
        $month = substr($date, 4, 2);
        $day = substr($date, 6, 2);
      }
      else {
        return "Error: string of wrong length";
      }
      return $day."/".$month."/".$year;
    } // function styleDateWithYears
    // Function that takes no parameters and prints in form DD(st/nd/rd/th) Month YYYY
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
    // Function that checks if the date you are checking is today
    function checkIfToday($date) {
      $today = date('Ymd');
      if ($date == $today) {
        return true;
      } // if
    } // checkIfToday
    // Checks if current date is in the past
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
    // Function to calculate next date
    // given a date
    // dates are given in format YYYYMMDD
    function findNextDate($date) {
      // check date string is right length
      if (strlen($date) == 8) {
        // first 4 digits -> year
        $year = substr($date, 0, 4);
        // next 2 digits -> month
        $month = substr($date, 4, 2);
        // next 2 digits -> day
        $day = substr($date, 6, 2);
      } // if
      else {
        return "Error: string of wrong length";
      } // else
      // finds maximum number of days in a month
      // supplies year as well to account for leap years
      $maxdays = findMaxDays($month,$year);
      if ($day < $maxdays) {
        $day += 1;
      } //if
      else {
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
     } // if
     else {
       return "Error: string of wrong length";
     } // else
     // finds max days in previous month
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
    // Finds the maximum number of days in a month
    // used by findNextDate and findPreviousDate
    function findMaxDays($month,$year) {
      switch($month) {
        // case for months with 31 days
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
          return 31;
          break;
        // February: account for leap year
        case 2:
          if ($year % 4 == 0) {
            return 29;
            break;
          } else {
            return 28;
            break;
          } // else
        // All other months
        default:
          return 30;
          break;
      } // switch
    } // findMaxDays
    // Function to check room availability
    // returns name of user if booked
    // else return null
    function checkAvailable($conn,$table,$date,$period) {
      $sql = "SELECT BookedByName FROM $table
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
    // Function to check if user is allowed to book vehicles or not
    // Only certain user may book vehicles
    function canBookVehicles($conn) {
      $username = $_SESSION["username"];
      $sqlCanBookVehicles = "SELECT canBookVehicles from Names
                             WHERE Username='$username'";
      $resultCanBookVehicles = mysqli_query($conn,$sqlCanBookVehicles);
      if (mysqli_num_rows($resultCanBookVehicles) > 0) {
        $row = mysqli_fetch_assoc($resultCanBookVehicles);
        $canBookVehicles = $row["canBookVehicles"];
      } // if
      if ($canBookVehicles) {
        return true;
      } else {
        return false;
      } // else
    } // function canBookVehicles
    // Function to jump forward a week
    // This will set the mondate to a week ahead of this now
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
    // Used to write the individual cells
    // Each individual cell contains a form with a button
    // the value of the form is $date,$period
    function writeCell($conn,$table,$date,$period) {
      // checks if available
      $name = checkAvailable($conn,$table,$date,$period);
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
            if(canBookVehicles($conn)) {
              // else write a form containing a button to POST
              echo "<form method='POST' action=''>";
              echo "<td class='available'><button type='submit' id='selectstartdate' name='book'";
              //echo "onclick=\"return confirm('" . writeDialog("Minibus YHJ",$date,$period) . "');\"";
              echo "value='".$date.",".$period."'>Select</button></td>";
              echo "</form>";
            } else {
              // if can't book vehicles, does not write book button
              echo "<td class='available'></td>";
            }
          } else {
            // if read-only, does not write book button
            echo "<td class='available'></td>";
          } // else
        } // else
      } // else
    } // writeCell
    // Function to write a table for the given resource
    function writeTable($conn,$table) {
      ?>
      <form method="POST" action="/createrecurring.php">
        <button type='submit' id="prevweek" name="prevweek" <?php echo "value='".$_SESSION['mondate']."'"; ?>>Previous Week</button>
        <b>Week of <?php echo styleWeekOf(); ?></b>
        <button type='submit' id="nextweek" name="nextweek"<?php echo "value='".$_SESSION['mondate']."'"; ?>>Next Week</button><br>
        <button type='submit' id="currentweek" name="currentweek"<?php echo "value='".$_SESSION['mondate']."'"; ?>>Current Week</button><br>
      </form>
      <table class="calendar">
      <tr>
      <!-- Write table headers -->
        <th></th>
        <?php
        // Establish the date of each day, store in individual variables
        $mondate = $_SESSION["mondate"];
        // calculate whole week
        $tuedate = findNextDate($mondate);
        $weddate = findNextDate($tuedate);
        $thudate = findNextDate($weddate);
        $fridate = findNextDate($thudate);
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
        for ($period=1;$period<=8;$period++) {
        echo "<tr>";
        echo "<th>Period $period</th>"; 
        writeCell($conn,$table,$mondate,$period);
        writeCell($conn,$table,$tuedate,$period);
        writeCell($conn,$table,$weddate,$period);
        writeCell($conn,$table,$thudate,$period);
        writeCell($conn,$table,$fridate,$period);
        echo "</tr>";
        } // for
        ?>
      </table>
      <?php
    } // writeTable
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