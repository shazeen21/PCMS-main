<?php
session_start();

$conn = mysqli_connect('localhost', "root", "peter@272105", 'details');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form was submitted
if(isset($_POST['USN']) && isset($_POST['Question']) && isset($_POST['Answer'])) {
    $USN = $_POST['USN'];
    $Question = $_POST['Question'];
    $Answer = $_POST['Answer'];
    
    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM plogin WHERE Username = ?");
    mysqli_stmt_bind_param($stmt, "s", $USN);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if user exists
    if(mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_assoc($result);
        $dbQuestion = $row['Question'];
        $dbAnswer = $row['Answer'];
        
        // Verify security question and answer
        if($dbQuestion == $Question && $dbAnswer == $Answer) {
            $_SESSION['reset'] = $USN;
            header("location: Reset password.php");
            exit; // Important: stop script execution after redirect
        } else {
            echo "<center>Failed! Incorrect Credentials</center>";
        }
    } else {
        echo "<center>Enter Something Correctly!!!</center>";
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "<center>Please fill all required fields</center>";
}

// Close connection
mysqli_close($conn);

/* 
The commented registration code has been removed as it appears to be unrelated 
to the current functionality of password reset verification.
If you need the registration functionality, it should be implemented separately.
*/
?>