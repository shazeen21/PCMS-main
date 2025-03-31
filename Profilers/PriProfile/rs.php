<?php
session_start();

// Create connection using mysqli instead of mysql
$connect = mysqli_connect("localhost", "root", "peter@272105", "details");

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$USN = $_POST['USN'];
$Question = $_POST['Question'];
$Answer = $_POST['Answer'];

// Prevent SQL injection by using prepared statements
$stmt = mysqli_prepare($connect, "SELECT * FROM prilogin WHERE Username = ?");
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
        exit; // Important: terminate script execution after redirect
    } else {
        echo "<center>Failed! Incorrect Credentials</center>";
    }
} else {
    echo "<center>Enter Something Correctly Champ!!!</center>";
}

// Close the connection
mysqli_close($connect);

/* The commented out registration code is preserved below
if($query = mysqli_query($connect, "INSERT INTO slogin(Fullname, USN, PASSWORD, Email, Question, Answer) VALUES ('$Name', '$USN', '$password', '$Email', '$Question', '$Answer')")) {
    echo "<center>You have registered successfully...!! Go back to</center>";
    echo "<center><a href='index.php'>Login here</a></center>";
}
else {
    echo "<center>Your password do not match</center>";
}
else {
    echo "<center>This USN already exists</center>"; 
}
*/
?>