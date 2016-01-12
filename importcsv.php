<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<?php
  session_start();
  // Usual session stuff
  // Ensure connection is made because we are adding records to database
  $servername = $_SESSION['servername'];
  $username = $_SESSION['username'];
  $password  = $_SESSION['password'];
  $db_selected = $_SESSION['db_selected'];
  $conn = mysqli_connect($servername,$username,$password,$db_selected);
  $_SESSION["conn"] = $conn;
  // Make sure we are connected to the database
  if($conn) {
    echo "Database connected as $username<br>";
  } // if
  // sets directory of target file
  $target_dir = "uploads/";
  // sets the file path using target directory
  $target_file = $target_dir . basename($_FILES["theFile"]["name"]);
  $uploadOk = 1;
  $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Make sure file is a csv type
  if ($fileType != "csv") {
    echo "File must be a csv file";
    exit;
  } // if
  // Check if file already exists
  if (file_exists($target_file)) {
      echo "Warning: file name already exists. Continuing...<br>";
   }
   // Check file size
  if ($_FILES["theFile"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
   }
   if ($uploadOk == 0) {
       echo "Sorry, your file was not uploaded.";
   // if everything is ok, try to upload file
   } else {
       if (move_uploaded_file($_FILES["theFile"]["tmp_name"], $target_file)) {
           echo "The file ". basename( $_FILES["theFile"]["name"]). " has been uploaded.";
       } else {
           echo "Sorry, there was an error uploading your file.";
       }
   }
  // Check csv location was set
  $csvlocation = $target_file;
  echo "csv location was set as<br>$csvlocation<br>";
  try {
    // Tries to open file
    $row = 1;
    $arrayrow = 0;
    // Opens file in read mode
    if (($handle = @fopen($csvlocation, "r")) !== FALSE) {
      // While there are rows of data
      while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Gets number of lines
        $num = count($data);
        $row++;
        $c=0;
        // Puts each element in a multidimensional array
        //Surname in first position
        $userAdded[$arrayrow][$c] = strtolower($data[$c]);
        // First name in second position
        $userAdded[$arrayrow][$c+1] = strtolower($data[$c+1]);
        $arrayrow++;
      } // while
      // Close file
      fclose($handle);
    } else {
      throw new Exception("An error occured while opening the file");
    } // else
    // Now we have stored in a multidimension array
    // surname (lowercase) , firstname (lowercase)
    // username for each will be set to surname+first initial
    // password will be the same as username
    // Will now loop through each record and create a new array
    // containing username, password, Full Name
    for ($i=0, $size=count($userAdded); $i<$size;$i++) {
      $lastname = $userAdded[$i][0];
      $firstname = $userAdded[$i][1];
      // Create a username
      $username = $firstname[0] . $lastname;
      $fullname = ucfirst($firstname) . " " . ucfirst($lastname);
      $password = $username;
      // Username
      $userToAdd[$i][0] = $username;
      // Password
      $userToAdd[$i][1] = $password;
      // Full name
      $userToAdd[$i][2] = $fullname;
    } // for

    for ($i=0, $size=count($userAdded); $i<$size;$i++) {
      echo $userToAdd[$i][0].", ".$userToAdd[$i][1].", ".$userToAdd[$i][2]."<br>";
    }
    
    // Some bug means that you must flush privileges if you have deleted any record
    // So flushing privileges now to prevent any problems
    //$sqlFlush = "FLUSH PRIVILEGES";
    //$resultFlush = mysqli_query($conn,$sqlFlush);
    //if(!$resultFlush) {
    //  echo "Error flushing privileges";
    //} // if
    // Now all elements in csv file are in a 2d array userToAdd[x][y]
    // Where x = user number, so for each x we need to add a new record to database
    // y = attribute number, so 0 = username, 1 = password, 2 = fullname, 3 = isadmin
    // For each record
    for ($i=0, $size=count($userToAdd); $i<$size;$i++) {
      // Checks username is not empty
      echo "Adding record $i:<br>";
      if (!$userToAdd[$i][0]) {
        throw new Exception("Username cannot be empty");
      } else {
        $username = $userToAdd[$i][0];
      } //else
      // Gets all elements from given record
      $password = $userToAdd[$i][1];
      $fullname = $userToAdd[$i][2];
      // Sets isadmin
      /*if ($userToAdd[$i][3] == 1) {
        $isadmin = true;
      } else {
        $isadmin = false;
      } // else*/
      // Print record to be added
      echo "Username: $username <br>";
      echo "Password: $password <br>";
      echo "Full name: $fullname <br>";
      $servername = "localhost";
      // SQL to check if username already exists
      // Since this is the only unique identifier for users
      $sqlAlreadyExists = "SELECT User FROM mysql.user
                           WHERE User='$username'";
      echo $sqlAlreadyExists . "<br>";
      $resultAlreadyExists = mysqli_query($conn,$sqlAlreadyExists);
      if (!$resultAlreadyExists) {
        echo "An error occurred: ". mysqli_error($conn) . "<br>";
      }
      if (@mysqli_num_rows($resultAlreadyExists) > 0) {
        echo "<b>Username $username already exists</b><br>";
        $alreadyexists = true;
      } else {
        echo "Username ok<br>";
        $alreadyexists = false;
      } // if else
      $conn = $_SESSION['conn'];
      // Have checked to make sure username does not already exist
      // Now OK to create user in mysql.user
      // Creates user using $username and $password
      // Only done if record does not already exist
      if (!$alreadyexists) {
        $sqlCreateUserInUser = "CREATE USER '$username'@'$servername' identified by '$password'";
        echo $sqlCreateUserInUser . "<br>";
        $resultCreateUserInUser = mysqli_query($conn,$sqlCreateUserInUser);
        // if does not return, i.e. an error occurred, throw an exception 
        if (!$resultCreateUserInUser) {
          echo"Error creating user $username:<br>" . mysqli_error($conn) . "<br>";
        } // if
        // Grants privileges
        $sqlGrantPrivileges = "GRANT ALL PRIVILEGES ON rbook_db.* TO '$username'@'$servername'";
        echo $sqlGrantPrivileges . "<br>";
        $resultGrantPrivileges = mysqli_query($conn,$sqlGrantPrivileges);
        // Throws an exception
        if (!$resultGrantPrivileges) {
          echo "Error granting privileges to $username <br>" . mysqli_error($conn) . "<br>";
        }
        // Now create a record in rbook_db.names
        // Which stores username, fullname, and isadmin
        //if (!$isadmin) {$isadmin=0;}
        $sqlCreateUserInNames = "INSERT INTO names
                                 (Username, Fullname)
                                 VALUES
                                 ('$username','$fullname')";
        $resultCreateUserInNames = mysqli_query($_SESSION['conn'],$sqlCreateUserInNames);
        // If successful
        if ($resultCreateUserInNames) {
          echo "<b>Record added for $username</b><br>";
        } else {
          // Else record already exists
          throw new Exception("Error adding record to Names table<br>");
        } //else
      } // if already exists
      
    } // for
    // Just flush privileges because that seems to make grants work
    //$sqlFlush = "FLUSH PRIVILEGES";
    //$resultFlush = mysqli_query($conn,$sqlFlush);
    //if(!$resultFlush) {
    //  echo "Error flushing privileges";
    //} //if
    
  } // try
  catch (Exception $e) {
    echo $e->getMessage();
  } // catch
  finally {
    echo "<a href='/admin.php'>Go back</a>";
  } // finally
  // Sets inital row
  
?>
</body>
</html>