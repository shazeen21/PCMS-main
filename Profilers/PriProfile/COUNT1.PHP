<?php
  session_start();
  if (!isset($_SESSION['priusername'])) {
    header("location: index.php");
    exit; // Added exit after redirect for security
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Company Drive Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
    }
    .report-container {
      width: 80%;
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f9f9f9;
    }
    .report-item {
      margin: 10px 0;
      padding: 5px;
    }
    .report-heading {
      color: #333;
      margin-bottom: 20px;
    }
    .error {
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>
<div class="report-container">
  <center>
    <h2 class="report-heading">Drive Results Report</h2>
    
    <?php
    if(isset($_POST['submit'])) {
      // Create connection using mysqli
      $conn = mysqli_connect('localhost', "root", "peter@272105", 'details');
      
      // Check connection
      if (!$conn) {
        die('<p class="error">Connection failed: ' . mysqli_connect_error() . '</p>');
      }
      
      $cname = mysqli_real_escape_string($conn, $_POST['cname']);
      $date = mysqli_real_escape_string($conn, $_POST['date']);
      
      // Number of Students Attended
      $query = "SELECT COUNT(Attendence) as attended FROM updatedrive WHERE Attendence=1 AND CompanyName=? AND Date=?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $data = mysqli_fetch_assoc($result);
      
      echo '<div class="report-item"><strong>Number of Students Attended:</strong> ' . $data['attended'] . '</div>';
      
      // Number of Students Cleared WT (Written Test)
      $query = "SELECT COUNT(WT) as cleared_wt FROM updatedrive WHERE WT=1 AND CompanyName=? AND Date=?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $data = mysqli_fetch_assoc($result);
      
      echo '<div class="report-item"><strong>Number of Students Cleared Written Test:</strong> ' . $data['cleared_wt'] . '</div>';
      
      // Number of Students Cleared GD (Group Discussion)
      $query = "SELECT COUNT(GD) as cleared_gd FROM updatedrive WHERE GD=1 AND CompanyName=? AND Date=?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $data = mysqli_fetch_assoc($result);
      
      echo '<div class="report-item"><strong>Number of Students Cleared Group Discussion:</strong> ' . $data['cleared_gd'] . '</div>';
      
      // Number of Students Cleared Technical
      $query = "SELECT COUNT(Techical) as cleared_tech FROM updatedrive WHERE Techical=1 AND CompanyName=? AND Date=?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $data = mysqli_fetch_assoc($result);
      
      echo '<div class="report-item"><strong>Number of Students Cleared Technical:</strong> ' . $data['cleared_tech'] . '</div>';
      
      // Number of Students Placed
      $query = "SELECT COUNT(Placed) as placed FROM updatedrive WHERE Placed=1 AND CompanyName=? AND Date=?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ss", $cname, $date);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $data = mysqli_fetch_assoc($result);
      
      echo '<div class="report-item"><strong>Number of Students Placed:</strong> ' . $data['placed'] . '</div>';
      
      // Close connection
      mysqli_close($conn);
    } else {
      // If form not submitted, show form
      echo '
      <form method="post" action="">
        <div class="report-item">
          <label for="cname">Company Name:</label>
          <input type="text" id="cname" name="cname" required>
        </div>
        <div class="report-item">
          <label for="date">Drive Date:</label>
          <input type="date" id="date" name="date" required>
        </div>
        <div class="report-item">
          <input type="submit" name="submit" value="Generate Report">
        </div>
      </form>
      ';
    }
    ?>
  </center>
</div>
</body>
</html>