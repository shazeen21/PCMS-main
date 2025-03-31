<?php
session_start();

// Establishing Connection with Server
$connect = mysqli_connect("localhost", "root", "Peter@272105", "details");

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['husername'])) {
    header("Location: index.php");
    exit();
}

$Username = $_SESSION['husername'];
$Password = $_POST['Password'];
$repassword = $_POST['repassword'];
$cur = $_POST['curpassword'];

if($Password && $repassword && $cur) 
{
    if($Password == $repassword)
    {
        // Proper mysqli syntax requires the connection as first parameter
        $sql = mysqli_query($connect, "SELECT * FROM `hlogin` WHERE `Username`='$Username'");
        
        if(mysqli_num_rows($sql) == 1)
        {
            $row = mysqli_fetch_assoc($sql);
            $dbpassword = $row['Password'];
            
            if($cur == $dbpassword)
            {
                // Proper mysqli syntax for query
                if($query = mysqli_query($connect, "UPDATE `hlogin` SET `Password` = '$Password' WHERE `Username` = '$Username'"))
                {
                    echo "<center>Password Changed Successfully</center>";
                } else {
                    echo "<center>Can't Be Changed! Try Again: " . mysqli_error($connect) . "</center>";
                }
            } else {
                die("<center>Error! Please Check ur Password</center>");
            }
        } else {
            die("<center>Username not Found</center>");
        }
    } else {
        die("<center>Passwords Do Not Match</center>");
    }
} else {
    die("<center>Enter All Fields</center>");
}

// Close connection
mysqli_close($connect);
?>