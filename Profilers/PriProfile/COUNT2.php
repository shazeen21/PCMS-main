<?php
  session_start();
  if (!isset($_SESSION['priusername'])) {
    header("location: index.php");
    exit; // Add exit after redirect for security
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Company Details</title>
</head>
<body>
<center>
<?php
// Database connection - updated to match the style from the first code
$conn = mysqli_connect('localhost', "root", "peter@272105", 'details');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['submit'])) { 
    $cname = $_POST['cname'];
    
    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM addpdrive WHERE CompanyName=?");
    mysqli_stmt_bind_param($stmt, "s", $cname);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while($row = mysqli_fetch_assoc($result)) {
        print "<tr>"; 
        print "<br><td>Date: ";
        echo htmlspecialchars($row['Date']);
        print "<br></td><td>Campus/Pool: "; 
        echo htmlspecialchars($row['C/P']);
        print "<br></td><td>Pool Venue: "; 
        echo htmlspecialchars($row['PVenue']);
        print "<br></td><td>SSLC: "; 
        echo htmlspecialchars($row['SSLC']);
        print "<br></td><td>PU/Dip: "; 
        echo htmlspecialchars($row['PU/Dip']);
        print "<br></td><td>BE Aggregate: ";
        echo htmlspecialchars($row['BE']);
        print "<br></td><td>Current Backlogs: "; 
        echo htmlspecialchars($row['Backlogs']);
        print "<br></td><td>History of Backlogs: "; 
        echo htmlspecialchars($row['HofBacklogs']);
        print "<br></td><td>Detain Years: "; 
        echo htmlspecialchars($row['DetainYears']);
        print "<br></td><td>Other Details: ";
        echo htmlspecialchars($row['ODetails']);
        print "</td></tr><br><br><br>"; 
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>
</center>
</body>
</html>