<?php
if(isset($_POST['submit'])) {
    $subject = $_POST['Subject'];
    $message = $_POST['Message'];
    
    // Create connection using mysqli instead of mysql
    $connect = mysqli_connect("localhost", "root", "peter@272105", "details");
    
    // Check connection
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Check if $images variable exists
    // Note: In the original code, $images was used but not defined
    // If you actually need to handle file uploads, see the commented code below
    $images = ''; // Set default value or remove if not needed
    
    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($connect, "INSERT INTO `prim` (`Subject`, `Message`, `Images`) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $subject, $message, $images);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<center>Message has been Posted</center>";
    } else {
        echo "<center>Message Posting Unsuccessful! Try Again: " . mysqli_error($connect) . "</center>";
    }
    
    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}

/* 
// If you need to handle file uploads, uncomment and use this code instead:

if(isset($_POST['submit'])) {
    $subject = $_POST['Subject'];
    $message = $_POST['Message'];
    
    // Create connection
    $connect = mysqli_connect("localhost", "root", "", "comm");
    
    // Check connection
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // File upload handling
    $images = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $location = 'Uploads/';
        $target = $location . $name;
        
        // Create directory if it doesn't exist
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }
        
        if(move_uploaded_file($tmp_name, $target)) {
            $images = $target;
        }
    }
    
    // Use prepared statement
    $stmt = mysqli_prepare($connect, "INSERT INTO `prim` (`Subject`, `Message`, `Images`) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $subject, $message, $images);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<center>Message has been Posted</center>";
    } else {
        echo "<center>Message Posting Unsuccessful! Try Again: " . mysqli_error($connect) . "</center>";
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
*/
?>