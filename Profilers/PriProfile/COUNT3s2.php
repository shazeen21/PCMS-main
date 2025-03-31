<?php
  session_start();
  if (isset($_SESSION['priusername'])){
    
  }
  else {
    header("location: index.php");
    exit; // Add exit after redirect for security
  }  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!--favicon-->
    <link rel="shortcut icon" href="favicon.ico" type="image/icon">
    <link rel="icon" href="favicon.ico" type="image/icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>QUERIES</title>
    <meta name="description" content="">
    <meta name="author" content="templatemo">
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
  <div class="bg">
   <div class="templatemo-content-container">
  <div class="templatemo-content-widget no-padding">
<?php
// Replace mysql functions with mysqli
$conn = mysqli_connect('localhost', "root", "peter@272105", 'details');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['s2'])) { 
    $Susn = $_POST['susn'];
    
    // Escape user input to prevent SQL injection
    $escapedSusn = mysqli_real_escape_string($conn, $Susn);
    
    $query = "SELECT * FROM basicdetails WHERE USN='$escapedSusn'";
    $RESULT = mysqli_query($conn, $query);
    
    if (!$RESULT) {
        die("Query failed: " . mysqli_error($conn));
    }
    
    if (mysqli_num_rows($RESULT) > 0) {
        $row = mysqli_fetch_assoc($RESULT);
        
        echo "<br><h3>Details of Student '$Susn'&nbsp:&nbsp</h3>";
        print "<center><tr>"; 
        print "<br><td>First Name : ";
        echo htmlspecialchars($row['FirstName']);
        print "<br></td><td>Last Name : "; 
        echo htmlspecialchars($row['LastName']);
        print "<br></td><td>USN : "; 
        echo htmlspecialchars($row['USN']);
        print "<br></td><td>Mobile : "; 
        echo htmlspecialchars($row['Mobile']);
        print "<br></td><td>Email : ";
        echo htmlspecialchars($row['Email']);
        print "<br></td><td>DOB : "; 
        echo htmlspecialchars($row['DOB']);
        print "<br></td><td>Semister : "; 
        echo htmlspecialchars($row['Sem']);
        print "<br></td><td>Branch : "; 
        echo htmlspecialchars($row['Branch']);
        print "<br></td><td>SSLC Percentage : ";
        echo htmlspecialchars($row['SSLC']);
        print "<br></td><td>PU/Diploma Percentage : ";
        echo htmlspecialchars($row['PU/Dip']);
        print "<br></td><td>BE Aggregate : ";
        echo htmlspecialchars($row['BE']);
        print "<br></td><td>Current Backlogs : ";
        echo htmlspecialchars($row['Backlogs']);
        print "<br></td><td>History of Backlogs : ";
        echo htmlspecialchars($row['HofBacklogs']);
        print "<br></td><td>Detain Years : ";
        echo htmlspecialchars($row['DetainYears']);
        print "</td></tr></center>";
    } else {
        echo "<br><h3>No student found with USN '$Susn'</h3>";
    }
    
    // Free result set
    mysqli_free_result($RESULT);
}

// Close connection
mysqli_close($conn);
?>
<footer class="text-right">
    <p>Copyright &copy; 2001-2015 CIT-PMS
    | Developed by <a href="http://znumerique.azurewebsites.net" target="_parent">ZNumerique Technologies</a></p>
</footer>         
        </div>
      </div>
    </div>    
    <!-- JS -->
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
    <script type="text/javascript" src="js/templatemo-script.js"></script>      <!-- Templatemo Script -->
    <script>
      $(document).ready(function(){
        // Content widget with background image
        var imageUrl = $('img.content-bg-img').attr('src');
        $('.templatemo-content-img-bg').css('background-image', 'url(' + imageUrl + ')');
        $('img.content-bg-img').hide();        
      });
    </script>
  </body>
</html>