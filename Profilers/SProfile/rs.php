<?php
session_start();

// Establishing Connection with Server using MySQLi
$connect = mysqli_connect("localhost", "root", "peter@272105", "details"); 

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if(isset($_POST['USN']) && isset($_POST['Question']) && isset($_POST['Answer'])) {
    $USN = $_POST['USN'];
    $Question = $_POST['Question'];
    $Answer = $_POST['Answer'];
    
    // Using prepared statement to check the USN
    $check_stmt = mysqli_prepare($connect, "SELECT * FROM slogin WHERE USN = ?");
    mysqli_stmt_bind_param($check_stmt, "s", $USN);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);
    
    if(mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_assoc($result);
        $dbQuestion = $row['Question'];
        $dbAnswer = $row['Answer'];
        
        if($dbQuestion == $Question && $dbAnswer == $Answer) {
            $_SESSION['reset'] = $USN;
            header("location: Reset password.php");
            exit; // Important to exit after redirect
        } else {
            echo "<center>Failed! Incorrect Credentials</center>";
        }
    } else {
        echo "<center>Enter Something Correctly Champ!!!</center>";
    }
    
    mysqli_stmt_close($check_stmt);
} else {
    echo "<center>Please submit the form with all required fields</center>";
}

// Close connection
mysqli_close($connect);

/* 
The commented out code has been removed as it appears to be 
unrelated to the current functionality and possibly from another script
*/
?>