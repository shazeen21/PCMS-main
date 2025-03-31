<?php
  session_start();
  if (!isset($_SESSION['pusername'])) {
      header("location: index.php");
      exit; // Added exit to prevent further execution
  }
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<center>
<?php
// Establish connection
$conn = mysqli_connect('localhost', "root", "peter@272105", 'details');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['submit'])) { 
    $cname = $_POST['cname'];
    $date = $_POST['date'];
    
    // Prepare statements to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT count(Attendence) as count FROM updatedrive WHERE Attendence=1 AND CompanyName=? AND Date=?");
    mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    echo "<br>Number of Students Attended&nbsp:&nbsp";
    echo $data['count'];
    
    $stmt = mysqli_prepare($conn, "SELECT count(WT) as count FROM updatedrive WHERE WT=1 AND CompanyName=? AND Date=?");
    mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    echo "<br>Number of Students Cleared WT&nbsp:&nbsp";
    echo $data['count'];
    
    $stmt = mysqli_prepare($conn, "SELECT count(GD) as count FROM updatedrive WHERE GD=1 AND CompanyName=? AND Date=?");
    mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    echo "<br>Number of Students Cleared GD&nbsp:&nbsp";
    echo $data['count'];
    
    $stmt = mysqli_prepare($conn, "SELECT count(Techical) as count FROM updatedrive WHERE Techical=1 AND CompanyName=? AND Date=?");
    mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    echo "<br>Number of Students Cleared Technical&nbsp:&nbsp";
    echo $data['count'];
    
    $stmt = mysqli_prepare($conn, "SELECT count(Placed) as count FROM updatedrive WHERE Placed=1 AND CompanyName=? AND Date=?");
    mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    echo "<br>Number of Students Placed&nbsp:&nbsp";
    echo $data['count'];
    
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn);
?>
</center>
</body>
</html>