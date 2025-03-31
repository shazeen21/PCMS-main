<?php
  session_start();
  if (!isset($_SESSION['pusername'])) {
    header("location: index.php");
    exit;
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
    <title>ISE Students</title>
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
    <center><h2>Approved Students List of ISE</h2></center>
    <div class="templatemo-content-widget no-padding">
      <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>                   
              <td><a class="white-text templatemo-sort-by">First Name </a></td>
              <td><a class="white-text templatemo-sort-by">Last Name </a></td>
              <td><a class="white-text templatemo-sort-by">USN </a></td>
              <td><a class="white-text templatemo-sort-by">Mobile </a></td>
              <td><a class="white-text templatemo-sort-by">Email </a></td>
              <td><a class="white-text templatemo-sort-by">DOB </a></td>
              <td><a class="white-text templatemo-sort-by">Sem </a></td>               
              <td><a class="white-text templatemo-sort-by">Branch </a></td>
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
            $num_rec_per_page = 15;
            
            // Create connection using mysqli
            $conn = new mysqli('localhost', "root", "peter@272105", 'details');
            
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            
            if (isset($_GET["page"])) { 
              $page = $_GET["page"]; 
            } else { 
              $page = 1; 
            }
            
            $start_from = ($page-1) * $num_rec_per_page; 
            $sql = "SELECT * FROM basicdetails WHERE Approve='1' AND Branch='ISE' LIMIT $start_from, $num_rec_per_page"; 
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) { 
                echo "<tr>"; 
                echo "<td>" . $row['FirstName'] . "</td>"; 
                echo "<td>" . $row['LastName'] . "</td>"; 
                echo "<td>" . $row['USN'] . "</td>"; 
                echo "<td>" . $row['Mobile'] . "</td>"; 
                echo "<td>" . $row['Email'] . "</td>"; 
                echo "<td>" . $row['DOB'] . "</td>"; 
                echo "<td>" . $row['Sem'] . "</td>"; 
                echo "<td>" . $row['Branch'] . "</td>"; 
                echo "<td>" . $row['SSLC'] . "</td>"; 
                echo "<td>" . $row['PU/Dip'] . "</td>"; 
                echo "<td>" . $row['BE'] . "</td>";
                echo "<td>" . $row['Backlogs'] . "</td>";
                echo "<td>" . $row['HofBacklogs'] . "</td>";
                echo "<td>" . $row['DetainYears'] . "</td>";
                echo "</tr>"; 
              }
            }
            ?> 
          </tbody>
        </table>  
      </div>
    </div>
  </div>

  <div class="pagination-wrap">
    <ul class="pagination">
      <?php 
      // Create connection using mysqli
      $conn = new mysqli('localhost', "root", "peter@272105", 'details');
      
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      
      $sql = "SELECT * FROM basicdetails WHERE Approve='1' AND Branch='ISE'"; 
      $result = $conn->query($sql);
      $total_records = $result->num_rows;
      $totalpage = ceil($total_records / $num_rec_per_page); 
      $currentpage = (isset($_GET['page']) ? $_GET['page'] : 1);
      
      if($currentpage == 0) {
        // Do nothing
      } else if($currentpage >= 1 && $currentpage <= $totalpage) {
        if($currentpage > 1 && $currentpage <= $totalpage) {
          $prev = $currentpage-1;
          echo "<li><a href='ise.php?page=".$prev."'><</a></li>";
        }
        
        if($totalpage > 1) {
          $prev = $currentpage-1;
          for ($i=$prev+1; $i<=$currentpage+2 && $i<=$totalpage; $i++) {
            echo "<li><a href='ise.php?page=".$i."'>".$i."</a></li>";
          }
        }
        
        if($totalpage > $currentpage) {
          $nxt = $currentpage+1;
          echo "<li><a href='ise.php?page=".$nxt."'>></a></li>";
        }
        
        echo "<li><a>Total Pages: ".$totalpage."</a></li>";
      }
      
      // Close the connection
      $conn->close();
      ?> 
    </ul>
  </div>
</div>
</body>
</html>