<?php
  session_start();
  if (!isset($_SESSION['pusername'])) {
    header("location: index.php");
    exit();
  }
  
  // Database connection
  $conn = new mysqli("localhost", "root", "peter@272105", "details");
  
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
        <center><h2>Approved Students List of ME</h2></center>
        <div class="templatemo-content-widget no-padding">
          <div class="panel panel-default table-responsive">
            <table class="table table-striped table-bordered templatemo-user-table">
              <thead>
                <tr>
                  <td><a class="white-text templatemo-sort-by">First Name</a></td>
                  <td><a class="white-text templatemo-sort-by">Last Name </a></td>
                  <td><a class="white-text templatemo-sort-by">USN </a></td>
                  <td><a class="white-text templatemo-sort-by">Mobile </a></td>
                  <td><a class="white-text templatemo-sort-by">Email </a></td>
                  <td><a class="white-text templatemo-sort-by">DOB </a></td>
                  <td><a class="white-text templatemo-sort-by">Sem </a></td>               
                  <td><a class="white-text templatemo-sort-by">Branch </a></td>
                  <td><a class="white-text templatemo-sort-by">SSLC</a></td>
                  <td><a class="white-text templatemo-sort-by">PU/Dip</a></td>
                  <td><a class="white-text templatemo-sort-by">BE </a></td>
                  <td><a class="white-text templatemo-sort-by">Backlog </a></td>
                  <td><a class="white-text templatemo-sort-by">History Of Backlogs </a></td>
                  <td><a class="white-text templatemo-sort-by">Detain Years</a></td>
                </tr>
              </thead>
              <tbody>
                <?php
                  $num_rec_per_page = 15;
                  
                  if (isset($_GET["page"])) { 
                    $page = $_GET["page"]; 
                  } else { 
                    $page = 1; 
                  }
                  
                  $start_from = ($page-1) * $num_rec_per_page;
                  $branch = "ME"; 
                  
                  $sql = "SELECT * FROM basicdetails WHERE Approve='1' AND Branch=? LIMIT ?, ?"; 
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("sii", $branch, $start_from, $num_rec_per_page);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  
                  while ($row = $result->fetch_assoc()) { 
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
            // Get total records for pagination
            $branch = "ME";
            $sql_count = "SELECT COUNT(*) as total FROM basicdetails WHERE Approve='1' AND Branch=?";
            $stmt_count = $conn->prepare($sql_count);
            $stmt_count->bind_param("s", $branch);
            $stmt_count->execute();
            $result_count = $stmt_count->get_result();
            $row_count = $result_count->fetch_assoc();
            $total_records = $row_count['total'];
            
            $totalpage = ceil($total_records / $num_rec_per_page); 
            $currentpage = (isset($_GET['page']) ? $_GET['page'] : 1);
            
            if ($currentpage >= 1 && $currentpage <= $totalpage) {
              // Previous page link
              if ($currentpage > 1) {
                $prev = $currentpage - 1;
                echo "<li><a href='me.php?page=" . $prev . "'>&lt;</a></li>";
              }
              
              // Page numbers
              if ($totalpage > 1) {
                $prev = $currentpage - 1;
                $start = max(1, $prev);
                $end = min($currentpage + 2, $totalpage);
                
                for ($i = $start; $i <= $end; $i++) {
                  $active = ($i == $currentpage) ? 'class="active"' : '';
                  echo "<li " . $active . "><a href='me.php?page=" . $i . "'>" . $i . "</a></li>";
                }
              }
              
              // Next page link
              if ($totalpage > $currentpage) {
                $nxt = $currentpage + 1;
                echo "<li><a href='me.php?page=" . $nxt . "'>&gt;</a></li>";
              }
              
              echo "<li><a>Total Pages: " . $totalpage . "</a></li>";
            }
          ?> 
        </ul> 
      </div>
    </div>
    
    <?php
      // Close the database connection
      $conn->close();
    ?>
  </body>
</html>