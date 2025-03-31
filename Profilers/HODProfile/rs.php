<?php
session_start();

// Using mysqli instead of mysql
$connect = mysqli_connect("localhost", "root", "peter@272105"); // Establishing Connection with Server
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select database
$db_selected = mysqli_select_db($connect, "details");
if (!$db_selected) {
    die("Can't Connect to database: " . mysqli_error($connect));
}

$USN = $_POST['USN'];
$Question = $_POST['Question'];
$Answer = $_POST['Answer'];

// Use prepared statements to prevent SQL injection
$stmt = mysqli_prepare($connect, "SELECT * FROM hlogin WHERE Username = ?");
mysqli_stmt_bind_param($stmt, "s", $USN);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) != 0) 
{
    $row = mysqli_fetch_assoc($result);
    $dbQuestion = $row['Question'];
    $dbAnswer = $row['Answer'];
    
    if($dbQuestion == $Question && $dbAnswer == $Answer) 
    {
        $_SESSION['reset'] = $USN;
        header("location: Reset password.php");
        exit; // Always add exit after redirect
    }
    else {
        echo "<center>Failed! Incorrect Credentials</center>";
    }
} 
else {
    echo "<center>Enter Something Correctly!!!</center>";
}

// Close the connection
mysqli_close($connect);

/*
The commented code below was in the original file but appears to be unused.
It seems to be for user registration. I've updated it to mysqli as well for reference.

if($query = mysqli_query($connect, "INSERT INTO slogin(Fullname, USN, PASSWORD, Email, Question, Answer) 
    VALUES ('$Name', '$USN', '$password', '$Email', '$Question', '$Answer')"))
{
    echo "<center>You have registered successfully...!! Go back to</center>";
    echo "<center><a href='index.php'>Login here</a></center>";
}
else
{
    echo "<center>Your password do not match</center>";
}
else
{
    echo "<center>This USN already exists</center>"; 
}
*/
?>