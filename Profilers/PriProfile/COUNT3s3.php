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
    <title>Manage Students</title>
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
      <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>    
              <td><a class="white-text templatemo-sort-by">Sem </a></td>  
              <td><a class="white-text templatemo-sort-by">Branch </a></td> 
              <td><a class="white-text templatemo-sort-by">First Name </a></td>
              <td><a class="white-text templatemo-sort-by">Last Name </a></td>
              <td><a class="white-text templatemo-sort-by">USN </a></td>
              <td><a class="white-text templatemo-sort-by">Mobile </a></td>
              <td><a class="white-text templatemo-sort-by">Email </a></td>
              <td><a class="white-text templatemo-sort-by">DOB</a></td>               
              <td><a class="white-text templatemo-sort-by">SSLC </a></td>
              <td><a class="white-text templatemo-sort-by">PU/Dip </a></td>
              <td><a class="white-text templatemo-sort-by">BE </a></td>
              <td><a class="white-text templatemo-sort-by">Backlogs </a></td>
              <td><a class="white-text templatemo-sort-by">History Of Backlogs </a></td>
              <td><a class="white-text templatemo-sort-by">Detain Years </a></td> 
            </tr>
          </thead>
          <tbody>			   
          <?php		
          // Create connection
          $conn = mysqli_connect('localhost', "root", "peter@272105", 'details');
          
          // Check connection
          if (!$conn) {
              die("Connection failed: " . mysqli_connect_error());
          }
          
          if(isset($_POST['s3'])) { 
              $Csem = $_POST['csem'];
              
              // Escape user input to prevent SQL injection
              $escapedCsem = mysqli_real_escape_string($conn, $Csem);
              
              // Count query
              $countQuery = "SELECT COUNT(*) AS total FROM basicdetails WHERE `Approve`='1' AND Sem='$escapedCsem'";
              $RESULT = mysqli_query($conn, $countQuery);
              
              if (!$RESULT) {
                  die("Query failed: " . mysqli_error($conn));
              }
              
              $data = mysqli_fetch_assoc($RESULT);
              echo "<br><h3>Students in Semister '$Csem'&nbsp:&nbsp";
              echo htmlspecialchars($data['total']);
              echo "</h3>";
              
              // Main query
              $sql = "SELECT * FROM basicdetails WHERE `Approve`='1' AND Sem='$escapedCsem' ORDER BY Branch";
              $result = mysqli_query($conn, $sql);
              
              if (!$result) {
                  die("Query failed: " . mysqli_error($conn));
              }
              
              while($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>"; 	
                  echo '<td>' . htmlspecialchars($row['Sem']) . '</td>';	
                  echo '<td>' . htmlspecialchars($row['Branch']) . '</td>';		
                  echo '<td>' . htmlspecialchars($row['FirstName']) . '</td>';	
                  echo '<td>' . htmlspecialchars($row['LastName']) . '</td>';		
                  echo '<td>' . htmlspecialchars($row['USN']) . '</td>';	
                  echo '<td>' . htmlspecialchars($row['Mobile']) . '</td>';	
                  echo '<td>' . htmlspecialchars($row['Email']) . '</td>';		
                  echo '<td>' . htmlspecialchars($row['DOB']) . '</td>';			 	
                  echo '<td>' . htmlspecialchars($row['SSLC']) . '</td>';	
                  echo '<td>' . htmlspecialchars($row['PU/Dip']) . '</td>';	
                  echo '<td>' . htmlspecialchars($row['BE']) . '</td>';	
                  echo '<td>' . htmlspecialchars($row['Backlogs']) . '</td>';	
                  echo '<td>' . htmlspecialchars($row['HofBacklogs']) . '</td>';	
                  echo '<td>' . htmlspecialchars($row['DetainYears']) . '</td>';
                  echo "</tr>"; 
              }
              
              // Free result sets
              mysqli_free_result($RESULT);
              mysqli_free_result($result);
          }
          
          // Close connection
          mysqli_close($conn);
          ?> 
          </tbody>
        </table>  
      </div>
    </div>
  </div>
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