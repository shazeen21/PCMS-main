<?php
  session_start();
  if (isset($_SESSION['pusername'])) {
    // Continue with the page
  } else {
    header("location: index.php");
    exit; // Add exit to prevent further execution
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
    <center><h2>Approved Students List of Basic Science</h2></center>
    <div class="templatemo-content-widget no-padding">
      <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>
              <td><a class="white-text templatemo-sort-by">First Name</a></td>
              <td><a class="white-text templatemo-sort-by">Last Name</a></td>
              <td><a class="white-text templatemo-sort-by">USN</a></td>
              <td><a class="white-text templatemo-sort-by">Mobile</a></td>
              <td><a class="white-text templatemo-sort-by">Email</a></td>
              <td><a class="white-text templatemo-sort-by">DOB</a></td>
              <td><a class="white-text templatemo-sort-by">Sem</a></td>               
              <td><a class="white-text templatemo-sort-by">Branch</a></td>
              <td><a class="white-text templatemo-sort-by">SSLC</a></td>
              <td><a class="white-text templatemo-sort-by">PU/Dip</a></td>
              <td><a class="white-text templatemo-sort-by">BE</a></td>
              <td><a class="white-text templatemo-sort-by">Backlogs</a></td>
              <td><a class="white-text templatemo-sort-by">History Of Backlogs</a></td>
              <td><a class="white-text templatemo-sort-by">Detain Years</a></td>
            </tr>
          </thead>
          <tbody>
            <?php
            // Set records per page
            $num_rec_per_page = 2;
            
            // Connect to database using mysqli
            $conn = mysqli_connect('localhost', "root", "peter@272105", 'details');
            
            // Check connection
            if (!$conn) {
              die("Connection failed: " . mysqli_connect_error());
            }
            
            // Get current page
            if (isset($_GET["page"])) { 
              $page = $_GET["page"]; 
            } else { 
              $page = 1; 
            }
            
            // Calculate starting position for records
            $start_from = ($page-1) * $num_rec_per_page;
            
            // Prepare and execute the query with pagination
            $sql = "SELECT * FROM basicdetails WHERE Approve='1' AND Branch='Basic Science' LIMIT ?, ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $start_from, $num_rec_per_page);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            // Loop through results and display
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
              echo "<td>" . htmlspecialchars($row['LastName']) . "</td>"; 
              echo "<td>" . htmlspecialchars($row['USN']) . "</td>"; 
              echo "<td>" . htmlspecialchars($row['Mobile']) . "</td>"; 
              echo "<td>" . htmlspecialchars($row['Email']) . "</td>"; 
              echo "<td>" . htmlspecialchars($row['DOB']) . "</td>"; 
              echo "<td>" . htmlspecialchars($row['Sem']) . "</td>"; 
              echo "<td>" . htmlspecialchars($row['Branch']) . "</td>"; 
              echo "<td>" . htmlspecialchars($row['SSLC']) . "</td>"; 
              echo "<td>" . htmlspecialchars($row['PU/Dip']) . "</td>"; 
              echo "<td>" . htmlspecialchars($row['BE']) . "</td>";
              echo "<td>" . htmlspecialchars($row['Backlogs']) . "</td>";
              echo "<td>" . htmlspecialchars($row['HofBacklogs']) . "</td>";
              echo "<td>" . htmlspecialchars($row['DetainYears']) . "</td>";
              echo "</tr>";
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
      // Query to count total records for pagination
      $sql_count = "SELECT COUNT(*) as total FROM basicdetails WHERE Approve='1' AND Branch='Basic Science'";
      $result_count = mysqli_query($conn, $sql_count);
      $row_count = mysqli_fetch_assoc($result_count);
      $total_records = $row_count['total'];
      
      // Calculate total pages
      $totalpage = ceil($total_records / $num_rec_per_page);
      
      // Get current page
      $currentpage = (isset($_GET['page']) ? $_GET['page'] : 1);
      
      // Display pagination only if there are records
      if ($total_records > 0) {
        // Previous page link
        if ($currentpage > 1) {
          $prev = $currentpage - 1;
          echo "<li><a href='bs.php?page=" . $prev . "'>&lt;</a></li>";
        }
        
        // Page numbers
        $start_page = max(1, $currentpage - 1);
        $end_page = min($totalpage, $currentpage + 2);
        
        for ($i = $start_page; $i <= $end_page; $i++) {
          if ($i == $currentpage) {
            echo "<li class='active'><a href='bs.php?page=" . $i . "'>" . $i . "</a></li>";
          } else {
            echo "<li><a href='bs.php?page=" . $i . "'>" . $i . "</a></li>";
          }
        }
        
        // Next page link
        if ($currentpage < $totalpage) {
          $nxt = $currentpage + 1;
          echo "<li><a href='bs.php?page=" . $nxt . "'>&gt;</a></li>";
        }
        
        // Total pages
        echo "<li><a>Total Pages: " . $totalpage . "</a></li>";
      }
      
      // Close database connection
      mysqli_close($conn);
      ?>
    </ul> 
  </div>
  </div>
  </body>
</html>