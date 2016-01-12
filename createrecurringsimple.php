<!DOCTYPE html>
<html>
<head>
  <title>Recurring Booking</title>
  <!--JQuery library-->
  <script src="jquery-2.1.4.min.js"></script>
  <!--CSS stylesheet-->
  <link rel='stylesheet' type='text/css' href='my-style.css'>
  <!--Google font-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
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
    console.log(options);
    $("#selectresource").change(function(){
      // completely empty period list
      $("#selectperiod option").each(function(){
        $(this).remove();
      });
      // append each element from array to selectperiod list
      $.each(options, function(value,text){
        $("#selectperiod")
          .append($("<option></option>")
          .val(value)
          .html(text))
      });
      var str = "";
      // for each option in select resource
      $("#selectresource option:selected").each(function(){
        // gets value of selected option
        var inputstring = $(this).val();
        // splits using comma as delimiter
        var splitstring = inputstring.split(",");
        // sets type as the type given in string (period/time/vehicle)
        var type = splitstring[0];
        // for each option in the period options
        $("#selectperiod option").each(function(){
          // completely empty period list
          // gets value of option
          var val = $(this).val();
          // gets first character of option
          var firstchar = val.substr(0,1);
          // if type is period
          if (type == "period") {
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
        <li><a href="/createrecurringsimple.php">Create</a></li>
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
      createRecurringBooking($conn);
    } // if
    // Function to create a recurring booking
    function createRecurringBooking($conn) {
      try {
        echo "Creating recurring booking<br>";
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
        echo "Table: $table<br>";
        // set and check day
        $inputday = $_POST["selectday"];
        if (!$inputday) {
          throw new Exception("Day cannot be empty<br>");
        } // if
        // format day into 3 characters, and capitalise first char
        // so 'monday' -> 'Mon', for comparisons later
        $day = ucfirst(substr($inputday,0,3));
        echo "Day: $day<br>";
        // set and check period
        // The period value is set as a string
        // e.g. 'period 1' or 'break' or 't9to10'
        // so this needs to be translated into a period used by the database
        // so a numerical value 1-6 or 1-8
        $periodstring = $_POST["selectperiod"];
        // type is set as either period/time/vehicle
        // each has their method of getting the numerical value of the period
          
        // for period based resources
        echo "Type: $type<br>";
        if ($type == "period") {
          // explodes using space as delimiter where format is "period n"
          $period_explode = explode(" ", $periodstring);
          // casts second element as an int, to get numerical value of 'n'
          $period = (int)$period_explode[1];         
        } // if
        // for vehicle based resources
        elseif ($type == "vehicle") {
          // use a switch to translate string to numerical value
          switch($periodstring) {
            case "period 1": $period = 1; break;
            case "period 2": $period = 2; break;
            case "break":    $period = 3; break;
            case "period 3": $period = 4; break;
            case "period 4": $period = 5; break;
            case "break":    $period = 6; break;
            case "period 5": $period = 7; break;
            case "period 6": $period = 8; break;
            default:         $period = 1; break;
          } // switch
        } // if
        // for time based bookings
        elseif ($type == "time") {
          // use a switch to translate
          switch($periodstring) {
            case "t9to10":  $period = 1; break;
            case "t10to11": $period = 2; break;
            case "t11to12": $period = 3; break;
            case "t12to13": $period = 4; break;
            case "t13to14": $period = 5; break;
            case "t14to15": $period = 6; break;
            case "t15to16": $period = 7; break;
            case "t16to17": $period = 8; break;
            default:        $period = 1; break;
          } // switch
        } // elseif
        else {
          throw new Exception("Problem with the resource type<br>");
        }
        if (!$period) {
          throw new Exception("Period cannot be empty<br>");
        } // if
        echo "Period: $period<br>";
        // set frequency and check
        $frequency = $_POST["frequency"];
        if (!$frequency) {
          throw new Exception("Frequency cannot be empty<br>");
        } // if
        echo "Frequency: $frequency<br>";
        // set start date
        $startdate = $_POST["startdate"];
        if (!$startdate) {
          throw new Exception("Start date cannot be empty<br>");
        } // if
        // checks if the start date given is in the past
        if(checkIfInThePast($startdate)) {
          throw new Exception("Start date cannot be in the past<br>");
        } // if
        echo "Start date: $startdate<br>";
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
        echo "End date: $enddate<br>";
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
        while (strtotime($currentdate) <= strtotime($enddate)) {
          // if current date is equal to date required
          if ((findDayFromDate($currentdate)) == $day) {
            // increment weekcount every time a booking is made
            $weekcount++;
            // if not biweekly, or is biweekly and this is an odd week
            // so that biweekly bookings occur 1st week, 3rd week, ...
            if (!$isbiweekly || ($isbiweekly && ($weekcount % 2 != 0))) {
              $sqlCheck = "SELECT * FROM $table
                           WHERE BookingDate=$currentdate AND BookingPeriod=$period";
              $resultCheck = mysqli_query($conn,$sqlCheck);
              if (mysqli_num_rows($resultCheck) > 0) {
                echo "Warning: Record already exists for period $period on $currentdate<br>";
                echo "Did not add record<br>";
              } // if
              else {
                $id = $_SESSION["id"];
                $fullname = $_SESSION["fullname"];
                $sqlInsert = "INSERT INTO $table
                              (BookingDate,BookedByID,BookedByName,BookingPeriod)
                              VALUES
                              ($currentdate,$id,'$fullname',$period)";
                $resultInsert = mysqli_query($conn,$sqlInsert);
                if ($resultInsert) {
                  echo "New record added on date $currentdate<br>";
                } else {
                  echo "Error adding record: " . mysqli_error($conn) . "<br>";
                } // else
              } // else
            } // if
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
        }
        $sqlInsertRecur = "INSERT INTO RecurringBookings
                           (Resource,StartDate,EndDate,BookedByID,BookedByName,RecurDay,
                            RecurPeriod,isWeekly,isBiWeekly)
                           VALUES
                           ('$table',$startdate,$enddate,$id,'$fullname','$day',$period,
                            $isweeklyval,$isbiweeklyval)";
        $resultInsertRecur = mysqli_query($conn,$sqlInsertRecur);
        if (!$resultInsertRecur) {
          echo "Error adding record to recurring bookings table:"  . mysqli_error($conn) . "<br>";
        } else {
          echo "Successfully added a recurring booking<br>";
        }
      } // try
      catch (Exception $e){
        echo "<b>An error occured:</b><br>";
        echo $e->getMessage();
      } // catch
    } // function createRecurringBooking
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
    ?>
    <h3>Create a Recurring Booking</h3><br>
    <form action="/createrecurringsimple.php" method="POST">
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
        </select>
        <p id="testselected"></p>
        </td>
      </tr>
      <tr class="nostyle" id="selectstartday" style="">
        <td class="nostyle">Select a day</td>
        <td class="nostyle">
        <select name="selectday">
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
        <td class="nostyle">Select a period</td>
        <td class="nostyle">
          <select name="selectperiod" id="selectperiod">
            <option class="pd" value="">- Select -</option>
            <option class="pd" value="period 1">Period 1</option>
            <option class="pd" value="period 2">Period 2</option>
            <option class="pd" value="break">Break</option>
            <option class="pd" value="period 3">Period 3</option>
            <option class="pd" value="period 4">Period 4</option>
            <option class="pd" value="lunch">Lunch</option>
            <option class="pd" value="period 5">Period 5</option>
            <option class="pd" value="period 6">Period 6</option>
            <option class="pd" value="t9to10">9:00 - 10:00</option>
            <option class="pd" value="t10to11">10:00 - 11:00</option>
            <option class="pd" value="t11to12">11:00 - 12:00</option>
            <option class="pd" value="t12to13">12:00 - 13:00</option>
            <option class="pd" value="t13to14">13:00 - 14:00</option>
            <option class="pd" value="t14to15">14:00 - 15:00</option>
            <option class="pd" value="t15to16">15:00 - 16:00</option>
            <option class="pd" value="t16to17">16:00 - 17:00</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="nostyle">Select frequency</td>
        <td class="nostyle">
          <input type="radio" name="frequency" value="weekly">Weekly<br>
          <input type="radio" name="frequency" value="biweekly" id="biweekly">Every 2 weeks<br>
          <p id="biweeklynote" style="display:none">Note that biweekly bookings are made on every 1st, 3rd, 5th... week</p>
        </td>
      </tr>
      <tr>
        <td class="nostyle">Select start date</td>
        <td class="nostyle">
          <input type="date" name="startdate">
        </td>
      </tr>
      <tr>
        <td class="nostyle">Select end date</td>
        <td class="nostyle">
          <input type="date" name="enddate">
        </td>
      </tr>
      <tr>
        <td class="nostyle"></td>
        <td class="nostyle"><button type="submit" name="submitbooking">Submit</button>
      </tr>
    </table>
    </form>
    </center>
    <?php
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
</body>
</html>