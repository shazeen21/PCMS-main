<?php
  session_start();
  if(isset($_SESSION["priusername"])){
    echo "Welcome, ".$_SESSION['priusername']."!";
  }
   else
	   header("location: index.php");
?>
<!doctype html>
    <html lang="en">
    <head>
      <link rel="stylesheet" type="text/css" href="style.css">
      <meta charset="UTF-8">
      <title>database connections</title>
      <style>
        .table-container {
          display: flex;
          justify-content: center;
        }
        table {
          display: inline-block;
          border: 1px solid;
        }
      </style>
    </head>
    <body>
      <div class="table-container">
        <table border="1">
        <?php
        if(isset($_POST['submit']))
        { 
            $branch = $_POST['Branch'];
            $sslc = $_POST['sslc'];
            $puaggregate = $_POST['puagg'];
            $beaggregate = $_POST['beagg'];
            $backlogs = $_POST['curback']; 
            $hisofbk = $_POST['hob'];

            // Replace with mysqli connection
            $conn = mysqli_connect('localhost', "root", "peter@272105", 'details');
            
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            // Prepare the query with proper escaping to prevent SQL injection
            $branch = mysqli_real_escape_string($conn, $branch);
            $sslc = mysqli_real_escape_string($conn, $sslc);
            $puaggregate = mysqli_real_escape_string($conn, $puaggregate);
            $beaggregate = mysqli_real_escape_string($conn, $beaggregate);
            $backlogs = mysqli_real_escape_string($conn, $backlogs);
            $hisofbk = mysqli_real_escape_string($conn, $hisofbk);
            
            $sql = "SELECT * FROM basicdetails WHERE Approve=1 AND Branch='$branch' AND SSLC='$sslc' AND `PU/Dip`='$puaggregate' AND BE='$beaggregate' AND Backlogs='$backlogs' AND HofBacklogs='$hisofbk'";
            
            // Execute the query
            $result = mysqli_query($conn, $sql);
            
            // Check if query was successful
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }
            
            // Fetch and display results
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$row['FirstName']."</td></tr>";
                echo "<tr><td>".$row['LastName']."</td></tr>";
                echo "<tr><td>".$row['USN']."</td></tr>";
                echo "<tr><td>".$row['Mobile']."</td></tr>";
                echo "<tr><td>".$row['Email']."</td></tr>";
                echo "<tr><td>".$row['DOB']."</td></tr>";
                echo "<tr><td>".$row['Sem']."</td></tr>";
                echo "<tr><td>".$row['Branch']."</td></tr>";
                echo "<tr><td>".$row['SSLC']."</td></tr>";
                echo "<tr><td>".$row['PU/Dip']."</td></tr>";
                echo "<tr><td>".$row['BE']."</td></tr>";
                echo "<tr><td>".$row['Backlogs']."</td></tr>";
                echo "<tr><td>".$row['HofBacklogs']."</td></tr>";
                echo "<tr><td>".$row['DetainYears']."</td></tr>";
            }
            
            // Close the connection
            mysqli_close($conn);
        }
        ?>
        </table>
      </div>
    </body>
    </html>