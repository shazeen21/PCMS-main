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
  
  // Get table structure to check existing columns
  $table_columns = array();
  $columns_result = $conn->query("SHOW COLUMNS FROM basicdetails");
  if ($columns_result) {
    while ($column = $columns_result->fetch_assoc()) {
      $table_columns[] = $column['Field'];
    }
  }
  
  // Check for approval column (try different possible names)
  $approve_column = null;
  $approval_candidates = ['Approve', 'Approved', 'Approval', 'IsApproved', 'Status'];
  foreach ($approval_candidates as $candidate) {
    if (in_array($candidate, $table_columns)) {
      $approve_column = $candidate;
      break;
    }
  }
  
  // Check for date column (try different possible names)
  $date_column = null;
  $date_candidates = ['ApprovalDate', 'Date', 'CreatedDate', 'RegisteredDate', 'JoinDate', 'Updated'];
  foreach ($date_candidates as $candidate) {
    if (in_array($candidate, $table_columns)) {
      $date_column = $candidate;
      break;
    }
  }
  
  // Default to first column if no date column found (for ordering)
  if (!$date_column && !empty($table_columns)) {
    $date_column = $table_columns[0];
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
    <title>View Students</title>
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
    <!-- Left column -->
    <div class="templatemo-flex-row">
      <div class="templatemo-sidebar">
        <header class="templatemo-site-header">
          <div class="square"></div>
          <?php
            $Welcome = "Welcome";
            echo "<h1>" . $Welcome . "<br>". $_SESSION['pusername']. "</h1>";
            echo "<br>";
          ?>
        </header>
        <div class="profile-photo-container">
          <img src="images/profile-photo.jpg" alt="Profile Photo" class="img-responsive">  
          <div class="profile-photo-overlay"></div>
        </div>      
        <!-- Search box -->
        <form class="templatemo-search-form" role="search">
          <div class="input-group">
            <button type="submit" class="fa fa-search"></button>
            <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">           
          </div>
        </form>
        <div class="mobile-menu-icon">
          <i class="fa fa-bars"></i>
        </div>
        <nav class="templatemo-left-nav">          
          <ul>
            <li><a href="login.php"><i class="fa fa-home fa-fw"></i>Dashboard</a></li> 
            <li><a href="Placement Drives.php"><i class="fa fa-home fa-fw"></i>Placement Drives</a></li>           
            <li><a href="#" class="active"><i class="fa fa-users fa-fw"></i>View Students</a></li>
            <li><a href="queries.php"><i class="fa fa-users fa-fw"></i>Queries</a></li>
            <li><a href="Students Eligibility.php"><i class="fa fa-sliders fa-fw"></i>Students Eligibility Status</a></li>
            <li><a href="logout.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
          </ul>  
        </nav>
      </div>
      <!-- Main content --> 
      <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
          <div class="row">
            <nav class="templatemo-top-nav col-lg-12 col-md-12">
              <ul class="text-uppercase">
                <li><a href="../../Homepage/index.php">Home CIT-PMS</a></li>
                <li><a href="../../Drives/index.php">Drives Home</a></li>
                <li><a href="Notif.php">Notification</a></li>
                <li><a href="Change Password.php">Change Password</a></li>
              </ul>  
            </nav> 
          </div>
        </div>
        
        <div class="templatemo-content-container">
          <div class="templatemo-content-widget no-padding">
            <a href="bgo.php" class="templatemo-blue-button">View Branchwise</a>
            <div class="panel panel-default table-responsive">
              <table class="table table-striped table-bordered templatemo-user-table">
                <thead>
                  <tr>
                    <?php
                    // Dynamically generate table headers based on existing columns
                    $display_headers = ['ApprovalDate', 'FirstName', 'LastName', 'USN', 'Mobile', 
                                       'Email', 'DOB', 'Sem', 'Branch', 'SSLC', 'PU/Dip', 'BE', 
                                       'Backlogs', 'HofBacklogs', 'DetainYears'];
                    
                    foreach ($display_headers as $header) {
                      echo '<td><a class="white-text templatemo-sort-by">' . $header . '</a></td>';
                    }
                    ?>
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
                    
                    // Build the query based on available columns
                    if ($approve_column) {
                      if ($date_column) {
                        $sql = "SELECT * FROM basicdetails WHERE $approve_column='1' ORDER BY $date_column DESC LIMIT ?, ?";
                      } else {
                        $sql = "SELECT * FROM basicdetails WHERE $approve_column='1' LIMIT ?, ?";
                      }
                    } else {
                      if ($date_column) {
                        $sql = "SELECT * FROM basicdetails ORDER BY $date_column DESC LIMIT ?, ?";
                      } else {
                        $sql = "SELECT * FROM basicdetails LIMIT ?, ?";
                      }
                    }
                    
                    try {
                      $stmt = $conn->prepare($sql);
                      $stmt->bind_param("ii", $start_from, $num_rec_per_page);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      
                      if ($result) {
                        while ($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          foreach ($display_headers as $header) {
                            echo "<td>" . (isset($row[$header]) ? htmlspecialchars($row[$header]) : 'N/A') . "</td>";
                          }
                          echo "</tr>";
                        }
                      }
                    } catch (Exception $e) {
                      echo '<tr><td colspan="15">Error retrieving data: ' . $e->getMessage() . '</td></tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="pagination-wrap">
            <ul class="pagination">
              <?php
                // Get total records for pagination
                if ($approve_column) {
                  $sql_count = "SELECT COUNT(*) as total FROM basicdetails WHERE $approve_column='1'";
                } else {
                  $sql_count = "SELECT COUNT(*) as total FROM basicdetails";
                }
                
                try {
                  $result_count = $conn->query($sql_count);
                  $row_count = $result_count->fetch_assoc();
                  $total_records = $row_count['total'];
                  $totalpage = ceil($total_records / $num_rec_per_page);
                  $currentpage = (isset($_GET['page']) ? (int)$_GET['page'] : 1);
                  
                  if ($currentpage >= 1 && $currentpage <= $totalpage) {
                    // Previous page link
                    if ($currentpage > 1) {
                      $prev = $currentpage - 1;
                      echo "<li><a href='manage-users.php?page=" . $prev . "'>&lt;</a></li>";
                    }
                    
                    // Page numbers
                    if ($totalpage > 1) {
                      $prev = $currentpage - 1;
                      $start = max(1, $prev);
                      $end = min($currentpage + 2, $totalpage);
                      
                      for ($i = $start; $i <= $end; $i++) {
                        $active = ($i == $currentpage) ? 'class="active"' : '';
                        echo "<li " . $active . "><a href='manage-users.php?page=" . $i . "'>" . $i . "</a></li>";
                      }
                    }
                    
                    // Next page link
                    if ($currentpage < $totalpage) {
                      $nxt = $currentpage + 1;
                      echo "<li><a href='manage-users.php?page=" . $nxt . "'>&gt;</a></li>";
                    }
                    
                    echo "<li><a>Total Pages: " . $totalpage . "</a></li>";
                  }
                } catch (Exception $e) {
                  echo "<li>Error with pagination: " . $e->getMessage() . "</li>";
                }
              ?>
            </ul>
          </div>

          <footer class="text-right">
            <p>Copyright &copy; 2001-2015 CIT-PMS | Developed by <a href="http://znumerique.azurewebsites.net" target="_parent">ZNumērique Technologies</a></p>
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
<?php
  // Close the database connection
  $conn->close();
?>