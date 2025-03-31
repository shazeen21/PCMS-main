<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if ($username && $password) {
    // Connect using MySQLi
    $connect = mysqli_connect("localhost", "root", "Peter@272105") or die("Couldn't Connect: " . mysqli_connect_error());
    mysqli_select_db($connect, "details") or die("Can't find DB: " . mysqli_error($connect));
    
    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($connect, "SELECT * FROM slogin WHERE USN=?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $numrows = mysqli_num_rows($result);
    
    if ($numrows != 0) {
        $row = mysqli_fetch_assoc($result);
        $dbusername = $row['USN'];
        $dbpassword = $row['PASSWORD'];
        
        // SECURITY ISSUE: Consider using password_verify() instead of direct comparison
        if ($username == $dbusername && $password == $dbpassword) {
            echo "<center>Login Successful..!! <br/>Redirecting you to HomePage! </br>If not Goto <a href='index.php'> Here </a></center>";
            echo "<meta http-equiv='refresh' content ='3; url=index.php'>";
            $_SESSION['username'] = $username;
        } else {
            $message = "Username and/or Password incorrect.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            echo "<center>Redirecting you back to Login Page! If not Goto <a href='index.php'> Here </a></center>";
            echo "<meta http-equiv='refresh' content ='1; url=index.php'>";
        }
    } else {
        die("User does not exist");
    }
    
    mysqli_close($connect);
} else {
    die("Please enter USN and Password");
}
?>