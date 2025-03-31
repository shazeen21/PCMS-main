<?php
session_start();

// Check if user is authorized to reset password
if (!isset($_SESSION['reset'])) {
    // Redirect to login page if not authorized
    header("location: index.php");
    exit;
}

$USN1 = $_POST['USN'];
$password = $_POST['PASSWORD'];
$confirm = $_POST['repassword'];

// Create connection using mysqli instead of mysql
$connect = mysqli_connect("localhost", "root", "peter@272105", "details");

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verify the USN matches the one in session
if ($USN1 != $_SESSION['reset']) {
    echo "<center>Unauthorized access</center>";
    exit;
}

if($password == $confirm) {
    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($connect, "UPDATE `prilogin` SET `PASSWORD` = ? WHERE `Username` = ?");
    mysqli_stmt_bind_param($stmt, "ss", $password, $USN1);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<center>Password Reset Complete</center>";
        echo "<center><a href='index.php'>Go Back</a></center>";
        
        // Clear all session variables and destroy the session
        session_unset();
        session_destroy();
    } else {
        echo "<center>Update Failed: " . mysqli_error($connect) . "</center>";
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "<center>Passwords do not match</center>";
}

// Close connection
mysqli_close($connect);
?>