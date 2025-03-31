<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["priusername"])) {
    header("location: index.php");
    exit; // Added exit after redirect for security
}

// Only process if this is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = mysqli_connect('localhost', "root", "peter@272105", 'details');

    // Check connection
    if (!$conn) {
        die("<center>Connection failed: " . mysqli_connect_error() . "</center>");
    }

    $Username = $_SESSION['priusername'];
    $Password = $_POST['Password'];
    $repassword = $_POST['repassword'];
    $cur = $_POST['curpassword'];

    if($Password && $repassword && $cur) {
        if($Password == $repassword) {
            // Use prepared statement to prevent SQL injection
            $stmt = mysqli_prepare($conn, "SELECT * FROM prilogin WHERE Username=?");
            mysqli_stmt_bind_param($stmt, "s", $Username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if(mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $dbpassword = $row['Password'];
                
                if($cur == $dbpassword) {
                    // Update password using prepared statement
                    $update_stmt = mysqli_prepare($conn, "UPDATE prilogin SET Password=? WHERE Username=?");
                    mysqli_stmt_bind_param($update_stmt, "ss", $Password, $Username);
                    
                    if(mysqli_stmt_execute($update_stmt)) {
                        echo "<center>Password Changed Successfully</center>";
                    } else {
                        echo "<center>Can't Be Changed! Try Again</center>";
                    }
                    mysqli_stmt_close($update_stmt);
                } else {
                    die("<center>Error! Please Check your Current Password</center>");
                }
            } else {
                die("<center>Username not Found</center>");
            }
            mysqli_stmt_close($stmt);
        } else {
            die("<center>Passwords Do Not Match</center>");
        }
    } else {
        die("<center>Enter All Fields</center>");
    }
    
    // Close connection
    mysqli_close($conn);
}
?>