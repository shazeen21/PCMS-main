<?php
  session_start();
  
  // Check if user is logged in
  if(!isset($_SESSION["username"])) {
    header("location: index.php");
    exit();
  }
  
  // Database connection
  $conn = new mysqli("localhost", "root", "peter@272105", "details");
  
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Check if form was submitted
  if(isset($_POST['curpassword']) && isset($_POST['Password']) && isset($_POST['repassword'])) {
    $curpassword = $_POST['curpassword'];
    $newpassword = $_POST['Password'];
    $repassword = $_POST['repassword'];
    $username = $_SESSION["username"];
    
    // First check if new passwords match
    if($newpassword != $repassword) {
      echo "<script>alert('New passwords do not match!');</script>";
      echo "<script>window.location.href='Change Password.php';</script>";
      exit();
    }
    
    // Get the current stored password
    $stmt = $conn->prepare("SELECT PASSWORD FROM slogin WHERE USN=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists
    if($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $stored_password = $row['PASSWORD'];
      
      // Check if we're dealing with a legacy plain text password
      if($stored_password === $curpassword) {
        // It's a plain text match - update with a hashed password
        $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE slogin SET PASSWORD=? WHERE USN=?");
        $update_stmt->bind_param("ss", $hashed_password, $username);
        
        if($update_stmt->execute()) {
          echo "<script>alert('Password updated successfully!');</script>";
          echo "<script>window.location.href='dashboard.php';</script>";
        } else {
          echo "<script>alert('Error updating password: " . $conn->error . "');</script>";
          echo "<script>window.location.href='Change Password.php';</script>";
        }
        $update_stmt->close();
      } 
      // Check if it's already a hashed password
      elseif(password_verify($curpassword, $stored_password)) {
        // Password verified with hashing
        $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE slogin SET PASSWORD=? WHERE USN=?");
        $update_stmt->bind_param("ss", $hashed_password, $username);
        
        if($update_stmt->execute()) {
          echo "<script>alert('Password updated successfully!');</script>";
          echo "<script>window.location.href='dashboard.php';</script>";
        } else {
          echo "<script>alert('Error updating password: " . $conn->error . "');</script>";
          echo "<script>window.location.href='Change Password.php';</script>";
        }
        $update_stmt->close();
      }
      else {
        // Password doesn't match
        echo "<script>alert('Current password is incorrect!');</script>";
        echo "<script>window.location.href='Change Password.php';</script>";
      }
    } else {
      echo "<script>alert('User not found!');</script>";
      echo "<script>window.location.href='Change Password.php';</script>";
    }
    $stmt->close();
  } else {
    // If accessed directly without form submission
    header("location: Change Password.php");
    exit();
  }
  
  $conn->close();
?>