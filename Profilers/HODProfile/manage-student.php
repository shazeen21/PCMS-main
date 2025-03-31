<?php
  session_start();
  if (isset($_SESSION['husername'])){
      // User is logged in, continue
  } else {
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
    <!-- Left column -->
    <div class="templatemo-flex-row">
      <div class="templatemo-sidebar">
        <header class="templatemo-site-header">
          <div class="square"></div>
          <?php
          $Welcome = "Welcome";
          echo "<h1>" . $Welcome . "<br>". $_SESSION['husername']. "</h1>";
          echo "<br>";
          echo "<h1>(</h1>";
          echo "<h1>" . $_SESSION['department']. "</h1>";   
          echo "<h1>)</h1>";			
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
            <li><a href="#" class="active"><i class="fa fa-users fa-fw"></i>Manage Students</a></li>
            <li><a href="preferences.php"><i class="fa fa-sliders fa-fw"></i>Preferences</a></li>
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
                <li><a href="../../Drives/index.php">Drives</a></li>
                <li><a href="Notif.php">Notification</a></li>
                <li><a href="Change Password.php">Change Password</a></li>
              </ul>  
            </nav> 
          </div>
        </div>
        <div class="templatemo-content-container">
          <div class="templatemo-content-widget no-padding">
            <div class="panel panel-default table-responsive">
              <table class="table table-striped table-bordered templatemo-user-table">
                <thead>
                  <tr>
                    <td><a class="white-text templatemo-sort-by">First Name </a></td>
                    <td><a class="white-text templatemo-sort-by">Last Name </a></td>
                    <td><a class="white-text templatemo-sort-by">USN</a></td>
                    <td><a class="white-text templatemo-sort-by">Mobile</a></td>
                    <td><a class="white-text templatemo-sort-by">Email</a></td>
                    <td><a class="white-text templatemo-sort-by">Dob </a></td>
                    <td><a class="white-text templatemo-sort-by">Current Sem</a></td>               
                    <td><a class="white-text templatemo-sort-by">Branch</a></td>
                    <td><a class="white-text templatemo-sort-by">SSLC Percentage </a></td>
                    <td><a class="white-text templatemo-sort-by">PU Percentage</a></td>
                    <td><a class="white-text templatemo-sort-by">BE Aggregate</a></td>
                    <td><a class="white-text templatemo-sort-by">Current Backlogs </a></td>
                    <td><a class="white-text templatemo-sort-by">History of Backlogs </a></td>
                    <td><a class="white-text templatemo-sort-by">Detain Years</a></td>
                  </tr>
                </thead>
                <tbody>
                <?php
                $p = $_SESSION['department'];
                $num_rec_per_page = 15;
                
                // Connect using mysqli
                $conn = mysqli_connect("localhost", "root", "Peter@272105", 'details');
                
                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                
                if (isset($_GET["page"])) { 
                    $page = $_GET["page"]; 
                } else { 
                    $page = 1; 
                }
                
                $start_from = ($page-1) * $num_rec_per_page; 
                
                // First check if the 'Approve' column exists in the basicdetails table
                $check_column = mysqli_query($conn, "SHOW COLUMNS FROM basicdetails LIKE 'Approve'");
                
                if (mysqli_num_rows($check_column) > 0) {
                    // Column exists, use it in the query
                    $sql = "SELECT * FROM basicdetails WHERE Approve=0 AND Branch='$p' LIMIT $start_from, $num_rec_per_page";
                } else {
                    // Column doesn't exist, use query without Approve column
                    $sql = "SELECT * FROM basicdetails WHERE Branch='$p' LIMIT $start_from, $num_rec_per_page";
                }
                
                $rs_result = mysqli_query($conn, $sql);
                
                if (!$rs_result) {
                    die("Query failed: " . mysqli_error($conn));
                }
                
                while ($row = mysqli_fetch_assoc($rs_result)) { 
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
                ?> 
                </tbody>
              </table>  
            </div>
          </div>
        
          <div class="pagination-wrap">
            <a href="approve2.php" class="templatemo-edit-btn">Approve</a>
          </div>
          
          <div class="pagination-wrap">
            <ul class="pagination">
            <?php 
            // Check if Approve column exists
            if (mysqli_num_rows($check_column) > 0) {
                $sql = "SELECT * FROM basicdetails WHERE Approve=0 AND Branch='$p'";
            } else {
                $sql = "SELECT * FROM basicdetails WHERE Branch='$p'";
            }
            
            $rs_result = mysqli_query($conn, $sql);
            
            if (!$rs_result) {
                die("Query failed: " . mysqli_error($conn));
            }
            
            $total_records = mysqli_num_rows($rs_result);
            $totalpage = ceil($total_records / $num_rec_per_page); 
            
            $currentpage = (isset($_GET['page']) ? $_GET['page'] : 1);
            
            if($currentpage == 0) {
                // Do nothing
            } else if($currentpage >= 1 && $currentpage <= $totalpage) {
                if($currentpage > 1 && $currentpage <= $totalpage) {
                    $prev = $currentpage - 1;
                    echo "<li><a href='manage-student.php?page=".$prev."'><</a></li>";
                }
                
                if($totalpage > 1) {
                    $prev = $currentpage - 1;
                    for ($i = $prev + 1; $i <= $currentpage + 2 && $i <= $totalpage; $i++) {
                        echo "<li><a href='manage-student.php?page=".$i."'>".$i."</a></li>";
                    }
                }
                
                if($totalpage > $currentpage) {
                    $nxt = $currentpage + 1;
                    echo "<li><a href='manage-student.php?page=".$nxt."'>></a></li>";
                }
                
                echo "<li><a>Total Pages: ".$totalpage."</a></li>";
            }
            
            // Close connection
            mysqli_close($conn);
            ?> 
            </ul>
          </div>

          <br><br>
          <center>
            <label class="control-label" for="inputNote">
              <center><h2>OR</h2></center><br/><br/>
              To View All Students Click Link below:
            </label><br/><br/>
            <a href="manage-users1.php" class="templatemo-blue-button">View All</a>
          </center>
          
          <div class="templatemo-flex-row flex-content-row">
            <div class="col-1"></div> 
            <div>
              <footer class="text-right">
                <br>
                <p>Copyright &copy; 2015 CIT-PMS | Developed by
                  <a href="http://znumerique.azurewebsites.net" target="_parent">ZNumerique Technologies</a>
                </p>
                </br>
              </footer>
            </div>         
          </div>
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