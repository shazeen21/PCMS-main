<?php
session_start();

$priusername = $_POST['Username'] ?? '';
$password = $_POST['Password'] ?? '';

if (!empty($priusername) && !empty($password)) {
    // Connect to the database using MySQLi
    $connect = new mysqli("localhost", "root", "Peter@272105", "details");

    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $connect->prepare("SELECT Username, Password FROM prilogin WHERE Username = ?");
    $stmt->bind_param("s", $priusername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbusername, $dbpassword);
        $stmt->fetch();

        if ($password === $dbpassword) { // Consider using password_hash() in DB for security
            $_SESSION['priusername'] = $priusername;
            echo "<center>Login Successful..!! <br/>Redirecting you to HomePage! </br>If not, go to <a href='index.php'> Here </a></center>";
            echo "<meta http-equiv='refresh' content ='3; url=index.php'>";
        } else {
            echo "<script>alert('Username and/or Password incorrect.');</script>";
            echo "<center>Redirecting you back to Login Page! If not, go to <a href='index.php'> Here </a></center>";
            echo "<meta http-equiv='refresh' content ='1; url=index.php'>";
        }
    } else {
        echo "User does not exist";
    }
    
    // Close the statement and connection
    $stmt->close();
    $connect->close();
} else {
    die("Please enter Username and Password");
}
?>