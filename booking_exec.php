<?php
  session_start();
  $servername = "localhost";
  $username = $_SESSION["username"];
  $password  = $_SESSION["password"];
  $db_selected = "rbook_db";
    //connection using mysqli
  $conn = mysqli_connect($servername,$username,$password,$db_selected);

  if($conn) {

  } else {
    die("Connection failed: " . mysql_error());
  }

  $inputstring = $_POST['book'];
  $str_explode = explode(",", $inputstring);

  $date = $str_explode[0]; // date
  $id = $_SESSION["id"];
  $name = $_SESSION["username"];
  $period = $str_explode[1];
  $table = $_SESSION["currenttable"];
  $fullname = $_SESSION['fullname'];
  
  echo "Date: ". $date . "<br>";
  echo "ID: " . $id . "<br>";
  echo "Name: " . $name . "<br>";
  echo "Period: " . $period . "<br>";
  echo "Table: " . $table . "<br>";
  echo "Full name: " . $fullname . "<br>";


  // check then insert the record
  $sqlInsert = "INSERT INTO $table (BookingDate, BookedByID, BookedByName,BookingPeriod)
                VALUES ('$date', '$id', '$fullname', '$period');";
  // check if exists already
  $sqlCheck = "SELECT * FROM $table
               WHERE BookingDate='$date' AND BookingPeriod='$period';";

  $resultCheck = mysqli_query($conn,$sqlCheck);
  if (mysqli_num_rows($resultCheck) != 0)
  {
    echo "<h2><b>Record already exists<b></h2>";
  }
  else
  {
    $resultInsert = mysqli_query($conn,$sqlInsert);
    if ($resultInsert) {
      echo "<h1><b>New record added<b></h1>";
    } else {
      echo "<h2><b>Error adding record: <b></h2>" . $sqlInsert . mysqli_error($conn);
    }    
  }
  echo "<br><h2><a href='/" . $table . ".php'>Return to previous</a></h2>";
?>