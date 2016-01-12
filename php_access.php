<html>
  <head>
    <link rel='stylesheet' type='text/css' href='my-style.css'>
  </head>
  <body>
  <?php
  // Connect to database
  $database_path = "C:/xampp/htdocs/ResourceBooking.accdb";
  $objConnect = odbc_connect("Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$database_path", "", "");
  if($objConnect)
  {
    echo "Database Connected.";
  } // if
  else
  {
    echo "Database Connect Failed.";
  } // else

  // get Data from Table
  $strSQL = "SELECT tblResources.[ResourceID], tblResources.[ResourceName], tblResources.[ResourceType]
             FROM tblResources";
  $objExec = odbc_exec($objConnect,$strSQL) or die ("Error Execute [".$strSQL."]");
  $intNumField = odbc_num_fields($objExec);
  
  echo "<table width='500px'>";
  echo "<tr>";
  echo "<th>Resource ID</th>";
  echo "<th>Resource Name</th>";
  echo "<th>Resource Type</th>";
  echo "</tr>";
  
  $objResult = array();
  while(odbc_fetch_row($objExec))
  {
    $rid = odbc_result($objExec, "ResourceID");
    $rname = odbc_result($objExec, "ResourceName");
    $rtype = odbc_result($objExec, "ResourceType");
    echo "<tr><td>$rid</td>";
    echo "<td><b>$rname</b></td>";
    echo "<td>$rtype</td></tr>";
  }
  odbc_close($objConnect);
  echo "</table>";
  ?>
  </body>
</html>