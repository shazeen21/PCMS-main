<?php
  session_start();
  if($_SESSION["username"]){
    echo "Welcome, ".$_SESSION['username']."!";
  } else {
    header("location: index.php");
    exit; // Added exit after redirect for security
  }
?>

<?php
// First section - INSERT operation
if(isset($_POST['submit'])) { 
  $fname = $_POST['Fname'];
  $lname = $_POST['Lname'];
  $USN = $_POST['USN'];
  $sun = $_SESSION["username"];
  $phno = $_POST['Num'];
  $email = $_POST['Email'];
  $date = $_POST['DOB'];
  $cursem = $_POST['Cursem'];
  $branch = $_POST['Branch'];
  $per = $_POST['Percentage'];
  $puagg = $_POST['Puagg'];
  $beaggregate = $_POST['Beagg'];
  $back = $_POST['Backlogs'];
  $hisofbk = $_POST['History']; 
  $detyear = $_POST['Dety'];
  
  if($USN !='' || $email !='') {
    if($USN == $sun) {
      // Create connection using MySQLi
      $connect = mysqli_connect("localhost", "root", "peter@272105", "details");
      
      // Check connection
      if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
      }
      
      // First, check if the table exists and has the right structure
      $check_table = mysqli_query($connect, "SHOW TABLES LIKE 'basicdetails'");
      
      if(mysqli_num_rows($check_table) == 0) {
        // Table doesn't exist, create it
        $create_table = "CREATE TABLE `basicdetails` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `FirstName` VARCHAR(50) NOT NULL,
          `LastName` VARCHAR(50) NOT NULL,
          `USN` VARCHAR(20) NOT NULL,
          `Mobile` VARCHAR(15) NOT NULL,
          `Email` VARCHAR(50) NOT NULL,
          `DOB` DATE NOT NULL,
          `Sem` VARCHAR(10) NOT NULL,
          `Branch` VARCHAR(50) NOT NULL,
          `SSLC` VARCHAR(10) NOT NULL,
          `PU/Dip` VARCHAR(10) NOT NULL,
          `BE` VARCHAR(10) NOT NULL,
          `Backlogs` INT(5) NOT NULL,
          `HofBacklogs` VARCHAR(100) NOT NULL,
          `DetainYears` INT(5) NOT NULL,
          `Approve` TINYINT(1) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`)
        )";
        
        if(!mysqli_query($connect, $create_table)) {
          die("Error creating table: " . mysqli_error($connect));
        }
      }
      
      // Using prepared statement to prevent SQL injection
      $stmt = mysqli_prepare($connect, "INSERT INTO `basicdetails` (`FirstName`, `LastName`, `USN`, `Mobile`, `Email`, `DOB`, `Sem`, `Branch`, `SSLC`, `PU/Dip`, `BE`, `Backlogs`, `HofBacklogs`, `DetainYears`, `Approve`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0')");
      
      if(!$stmt) {
        die("Prepare failed: " . mysqli_error($connect) . ". Check if column names match the table structure.");
      }
      
      mysqli_stmt_bind_param($stmt, "ssssssssssssss", $fname, $lname, $USN, $phno, $email, $date, $cursem, $branch, $per, $puagg, $beaggregate, $back, $hisofbk, $detyear);
      
      if(mysqli_stmt_execute($stmt)) {
        echo "<center>Data Inserted successfully...!!</center>";
      } else {
        echo "<center>FAILED: " . mysqli_stmt_error($stmt) . "</center>";
      }
      
      mysqli_stmt_close($stmt);
      mysqli_close($connect);
    } else {
      echo "<center>Enter your USN only...!!</center>";
    }
  }
}
?>

<?php
// Second section - UPDATE operation
if(isset($_POST['update'])) { 
  $fname = $_POST['Fname'];
  $lname = $_POST['Lname'];
  $USN = $_POST['USN'];
  $sun = $_SESSION["username"];
  $phno = $_POST['Num'];
  $email = $_POST['Email'];
  $date = $_POST['DOB'];
  $cursem = $_POST['Cursem'];
  $branch = $_POST['Branch'];
  $per = $_POST['Percentage'];
  $puagg = $_POST['Puagg'];
  $beaggregate = $_POST['Beagg'];
  $back = $_POST['Backlogs'];
  $hisofbk = $_POST['History']; 
  $detyear = $_POST['Dety'];
  
  if($USN !='' || $email !='') {
    if($USN == $sun) {
      // Create connection using MySQLi
      $connect = mysqli_connect("localhost", "root", "peter@272105", "details");
      
      // Check connection
      if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
      }
      
      // Check if record exists
      $check_stmt = mysqli_prepare($connect, "SELECT * FROM `basicdetails` WHERE `USN`=?");
      mysqli_stmt_bind_param($check_stmt, "s", $USN);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);
      
      if(mysqli_stmt_num_rows($check_stmt) == 1) {
        mysqli_stmt_close($check_stmt);
        
        // Update the record
        $update_stmt = mysqli_prepare($connect, "UPDATE `basicdetails` SET `FirstName`=?, `LastName`=?, `Mobile`=?, `Email`=?, `DOB`=?, `Sem`=?, `Branch`=?, `SSLC`=?, `PU/Dip`=?, `BE`=?, `Backlogs`=?, `HofBacklogs`=?, `DetainYears`=?, `Approve`='0' WHERE `USN`=?");
        
        if(!$update_stmt) {
          die("Prepare failed: " . mysqli_error($connect) . ". Check if column names match the table structure.");
        }
        
        mysqli_stmt_bind_param($update_stmt, "ssssssssssssss", $fname, $lname, $phno, $email, $date, $cursem, $branch, $per, $puagg, $beaggregate, $back, $hisofbk, $detyear, $USN);
        
        if(mysqli_stmt_execute($update_stmt)) {
          echo "<center>Data Updated successfully...!!</center>";
        } else {
          echo "<center>FAILED: " . mysqli_stmt_error($update_stmt) . "</center>";
        }
        
        mysqli_stmt_close($update_stmt);
      } else {
        echo "<center>NO record found for update</center>";
        mysqli_stmt_close($check_stmt);
      }
      
      mysqli_close($connect);
    } else {
      echo "<center>Enter your USN only</center>";
    }
  }
}
?>