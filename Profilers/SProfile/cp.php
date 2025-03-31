<?php
session_start();

// Establishing Connection with Server using MySQLi - correctly passing all 4 parameters
$connect = mysqli_connect("localhost", "root", "peter@272105", "details"); 

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$Username = $_SESSION['username'];

// Check if form was submitted
if(isset($_POST['Password']) && isset($_POST['repassword']) && isset($_POST['curpassword'])) {
    $Password = $_POST['Password'];
    $repassword = $_POST['repassword'];
    $cur = $_POST['curpassword'];
    
    if($Password && $repassword && $cur) {
        if($Password == $repassword) {
            // Using prepared statement to check username
            $check_stmt = mysqli_prepare($connect, "SELECT * FROM slogin WHERE USN = ?");
            mysqli_stmt_bind_param($check_stmt, "s", $Username);
            mysqli_stmt_execute($check_stmt);
            $result = mysqli_stmt_get_result($check_stmt);
            
            if(mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $dbpassword = $row['PASSWORD'];
                
                if($cur == $dbpassword) {
                    // Using prepared statement for update
                    $update_stmt = mysqli_prepare($connect, "UPDATE slogin SET PASSWORD = ? WHERE USN = ?");
                    mysqli_stmt_bind_param($update_stmt, "ss", $Password, $Username);
                    
                    if(mysqli_stmt_execute($update_stmt)) {
                        echo "<center>Password Changed Successfully</center>";
                    } else {
                        echo "<center>Can't Be Changed! Try Again: " . mysqli_error($connect) . "</center>";
                    }
                    
                    mysqli_stmt_close($update_stmt);
                } else {
                    echo "<center>Error! Please Check your Current Password</center>";
                }
            } else {
                echo "<center>Username not Found</center>";
            }
            
            mysqli_stmt_close($check_stmt);
        } else {
            echo "<center>Passwords Do Not Match</center>";
        }
    } else {
        echo "<center>Enter All Fields</center>";
    }
} else {
    echo "<center>Form not submitted properly</center>";
}

// Close connection
mysqli_close($connect);
?>